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
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

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
            Action::make('export_pdf')
                ->label('Descargar PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('danger')
                ->url(function () {
                    return route('libro-mayor.pdf', [
                        'cuentaId' => $this->cuentaId,
                        'fechaInicio' => $this->fechaInicio,
                        'fechaFin' => $this->fechaFin,
                    ]);
                })
                ->openUrlInNewTab(),
        ];
    }

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

    public function cargarDatos(): void
    {
        // 1. Validar que los datos del formulario están
        $data = $this->form->getState();
        $this->resultados = []; // Resetea los resultados

        $cuenta = Cuenta::find($data['cuentaId']);
        if (!$cuenta) {
            $this->resultados = [];
            return;
        }
        $this->nombreCuentaSeleccionada = $cuenta->getCodigoNombreAttribute();

        // --- 2. CÁLCULO DEL SALDO ANTERIOR ---
        $saldoAnterior = 0;
        
        // Obtenemos todos los movimientos ANTERIORES a la fecha de inicio
        $movsAnteriores = Movimiento::where('cuenta_id', $data['cuentaId'])
            ->join('asientos', 'movimientos.asiento_id', '=', 'asientos.id')
            ->where('asientos.fecha', '<', $data['fechaInicio'])
            ->select('movimientos.debe', 'movimientos.haber')
            ->get();
        foreach ($movsAnteriores as $mov) {
            if ($cuenta->naturaleza === 'Deudor') {
                $saldoAnterior += ($mov->debe - $mov->haber);
            } else { // Asumimos 'Acreedor'
                $saldoAnterior += ($mov->haber - $mov->debe);
            }
        }

        $movsPeriodo = Movimiento::where('cuenta_id', $data['cuentaId'])
            ->join('asientos', 'movimientos.asiento_id', '=', 'asientos.id')
            ->whereBetween('asientos.fecha', [$data['fechaInicio'], $data['fechaFin']])
            ->select(
                'asientos.fecha',
                'asientos.numero_asiento', 
                'movimientos.debe',
                'movimientos.haber'
            )
            ->orderBy('asientos.fecha')
            ->orderBy('asientos.id') 
            ->get();
        $saldoCorriente = $saldoAnterior;
        $this->resultados[] = [
            'fecha' => $data['fechaInicio'],
            'numero_partida' => 'SALDO ANTERIOR AL PERÍODO',
            'debe' => 0,
            'haber' => 0,
            'saldo' => $saldoCorriente,
        ];

        foreach ($movsPeriodo as $mov) {
            $delta = 0;
            if ($cuenta->naturaleza === 'Deudor') {
                $delta = $mov->debe - $mov->haber;
            } else { // 'Acreedor'
                $delta = $mov->haber - $mov->debe;
            }
            $saldoCorriente += $delta;

            $this->resultados[] = [
                'fecha' => $mov->fecha,
                'numero_partida' => $mov->numero_asiento,
                'debe' => $mov->debe,
                'haber' => $mov->haber,
                'saldo' => $saldoCorriente,
            ];
        }

    }    
}
