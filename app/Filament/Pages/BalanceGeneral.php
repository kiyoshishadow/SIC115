<?php

namespace App\Filament\Pages;

use App\Models\Cuenta;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Blade;

class BalanceGeneral extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected string $view = 'filament.pages.balance-general';
    protected static ?string $navigationLabel = 'Balance General';
    protected static ?string $title = 'Balance General';
    //protected static ?string $navigationGroup = 'Reportes';
    protected static ?int $navigationSort = 1;

    public ?array $data = [];
    public $fechaCorte;

    public function mount(): void
    {
        $this->fechaCorte = now()->format('Y-m-d');
        $this->form->fill([
            'fecha_corte' => $this->fechaCorte,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                DatePicker::make('fecha_corte')
                    ->label('Fecha de Corte')
                    ->default(now())
                    ->required()
                    ->maxDate(now()),
            ])
            ->statePath('data');
    }

    public function aplicarFiltro(): void
    {
        $this->fechaCorte = $this->data['fecha_corte'];
    }

    public function getBalanceData(): array
    {
        // Obtener todas las cuentas mayores ordenadas por código
        $cuentas = Cuenta::where('es_mayor', true)
            ->orderBy('codigo')
            ->get();

        $activos = [];
        $pasivos = [];
        $patrimonio = [];
        $totalActivo = 0;
        $totalPasivo = 0;
        $totalPatrimonio = 0;

        foreach ($cuentas as $cuenta) {
            $saldo = $cuenta->saldo_actual;
            
            // Solo mostrar cuentas con saldo diferente de cero
            if ($saldo == 0) {
                continue;
            }
            
            $item = [
                'codigo' => $cuenta->codigo,
                'nombre' => $cuenta->nombre,
                'saldo' => abs($saldo),
            ];
            //para que no sume cabeceras de cuenta
            if($cuenta->permite_movimientos==true){
                $saldo2 = $saldo;
            }else{
                $saldo2 = 0;
            }

            // Clasificar por tipo
            switch (strtolower($cuenta->tipo)) {
                case 'activo':
                    $activos[] = $item;
                    $totalActivo += abs($saldo2);
                    break;
                case 'pasivo':
                    $pasivos[] = $item;
                    $totalPasivo += abs($saldo2);
                    break;
                case 'capital':
                case 'patrimonio':
                    $patrimonio[] = $item;
                    $totalPatrimonio += abs($saldo2);
                    break;
            }
        }

        return [
            'activos' => $activos,
            'pasivos' => $pasivos,
            'patrimonio' => $patrimonio,
            'totalActivo' => $totalActivo,
            'totalPasivo' => $totalPasivo,
            'totalPatrimonio' => $totalPatrimonio,
            'totalPasivoPatrimonio' => $totalPasivo + $totalPatrimonio,
        ];
    }

    public function descargarPdf()
    {
        $data = $this->getBalanceData();
        $fecha = $this->fechaCorte ?? now()->format('Y-m-d');

        $pdf = Pdf::loadView('pdf.balance-general', [
            'data' => $data,
            'fecha' => $fecha,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'balance-general-' . $fecha . '.pdf');
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('descargar_pdf')
                ->label('Descargar PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action('descargarPdf'),
        ];
    }
}