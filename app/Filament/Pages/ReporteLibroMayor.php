<?php

namespace App\Filament\Pages;

use App\Models\Cuenta;
use App\Models\Movimiento;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;
use Filament\Actions\Action;
class ReporteLibroMayor extends Page implements HasForms
{
    use InteractsWithForms;

    // --- 1. Propiedades para los filtros y resultados ---
    public ?int $cuentaId = null;
    public ?string $fechaInicio = null;
    public ?string $fechaFin = null;

    public array $resultados = [];
    public ?string $nombreCuentaSeleccionada = '';

    // --- 2. Configuración de la Página ---
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Libro Mayor';
    protected string $view = 'filament.pages.reporte-libro-mayor';

    protected function getHeaderActions(): array
{
    return [
        Action::make('exportar_pdf')
            ->label('Exportar a PDF')
            ->icon('heroicon-o-arrow-down-tray')
            ->url(fn () => route('reporte.libro-mayor.pdf'))
            ->openUrlInNewTab(),
    ];
}
    // --- 3. Formulario ---
    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Select::make('cuentaId')
                    ->label('Cuenta Contable')
                    ->options(
                        Cuenta::where('es_mayor', true)
                            ->orderBy('codigo')
                            ->get()
                            ->mapWithKeys(fn ($c) => [$c->id => "{$c->codigo} - {$c->nombre}"])
                            ->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->default(null),
                DatePicker::make('fechaInicio')
                    ->label('Fecha de Inicio')
                    ->required()
                    ->reactive(),
                DatePicker::make('fechaFin')
                    ->label('Fecha de Fin')
                    ->required()
                    ->reactive(),
            ])
            ->columns(3);
    }

    // --- 4. Cargar Datos con corrección UTF-8 ---
    public function cargarDatos(): void
    {
        $data = $this->form->getState();
        $this->resultados = []; // Resetea resultados

        $cuenta = Cuenta::find($data['cuentaId']);
        if (!$cuenta) {
            $this->resultados = [];
            return;
        }


        // Forzar UTF-8
        $this->nombreCuentaSeleccionada = mb_convert_encoding($cuenta->getCodigoNombreAttribute(), 'UTF-8', 'UTF-8');

        // --- Saldo Anterior ---
        $saldoAnterior = 0;
        $movsAnteriores = Movimiento::where('cuenta_id', $data['cuentaId'])
            ->join('asientos', 'movimientos.asiento_id', '=', 'asientos.id')
            ->where('asientos.fecha', '<', $data['fechaInicio'])
            ->select('movimientos.debe', 'movimientos.haber')
            ->get();

        foreach ($movsAnteriores as $mov) {
            $saldoAnterior += ($cuenta->naturaleza === 'Deudor') 
                ? $mov->debe - $mov->haber 
                : $mov->haber - $mov->debe;
        }

        // --- Movimientos del período ---
        $movsPeriodo = Movimiento::where('cuenta_id', $data['cuentaId'])
            ->join('asientos', 'movimientos.asiento_id', '=', 'asientos.id')
            ->whereBetween('asientos.fecha', [$data['fechaInicio'], $data['fechaFin']])
            ->select('asientos.fecha', 'asientos.numero_asiento', 'movimientos.debe', 'movimientos.haber')
            ->orderBy('asientos.fecha')
            ->orderBy('asientos.id')
            ->get();

        $saldoCorriente = $saldoAnterior;

        // --- Saldo anterior al período ---
        $this->resultados[] = [
            'fecha' => $data['fechaInicio'],
            'numero_partida' => mb_convert_encoding('SALDO ANTERIOR AL PERÍODO', 'UTF-8', 'UTF-8'),
            'debe' => 0,
            'haber' => 0,
            'saldo' => $saldoCorriente,
        ];

        foreach ($movsPeriodo as $mov) {
            $delta = ($cuenta->naturaleza === 'Deudor') 
                ? $mov->debe - $mov->haber 
                : $mov->haber - $mov->debe;

            $saldoCorriente += $delta;

            $this->resultados[] = [
                'fecha' => $mov->fecha,
                'numero_partida' => mb_convert_encoding($mov->numero_asiento, 'UTF-8', 'UTF-8'),
                'debe' => $mov->debe,
                'haber' => $mov->haber,
                'saldo' => $saldoCorriente,
            ];
        }
        
    session([
        'resultados_libro_mayor' => $this->resultados,
        'cuenta_nombre' => $this->nombreCuentaSeleccionada,
        'fecha_inicio' => $this->fechaInicio,
        'fecha_fin' => $this->fechaFin,
    ]);
    }
}
