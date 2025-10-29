<?php

namespace App\Filament\Resources\Asientos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class AsientoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('fecha')
                    ->label('Fecha del Asiento')
                    ->required()
                    ->default(now())
                    ->columnSpanFull(),
                TextInput::make('numero_asiento')
                    ->required(),
                Select::make('tipo_asiento')
                    ->options(['Diario' => 'Diario', 'Apertura' => 'Apertura', 'Cierre' => 'Cierre', 'Ajuste' => 'Ajuste'])
                    ->default('Diario')
                    ->required(),
                Textarea::make('descripcion')
                    ->label('Concepto General del Asiento')
                    ->required()
                    ->rows(2)
                    ->columnSpanFull(),
                Repeater::make('movimientos')
                    ->label('Movimientos Contables')
                    ->relationship() // <-- IMPORTANTE: usa la relación del modelo
                    ->columns(6) // Columnas dentro del repetidor
                    ->columnSpanFull()
                    ->schema([
                        Select::make('cuenta_id')
                            ->label('Cuenta')
                            //->relationship('cuenta', 'nombre') // Muestra 'nombre_cuenta'
                            ->relationship(
                                name: 'cuenta', // El nombre de la relación en el modelo Movimiento
                                titleAttribute: 'nombre', // El campo a mostrar
                                // Esta es la línea clave que añade el filtro
                                modifyQueryUsing: fn (Builder $query) => 
                                        $query->where('permite_movimientos', true)->orderBy('codigo'))
                            ->searchable(['codigo', 'nombre']) // Busca por código o nombre
                            ->preload()
                            ->required()
                            ->columnSpan(2), // Ocupa 2 de 6 columnas

                        TextInput::make('debe')
                            ->label('Debe')
                            ->numeric()
                            ->step('0.01')
                            ->default(0.00)
                            ->required()
                            ->columnSpan(1)
                            ->reactive() // <-- Reactivo para sumar
                            ->afterStateUpdated(function ($get, $set, $state) {
                                // Si escribe en Debe, pone Haber en 0
                                if (floatval($state) > 0) {
                                    $set('haber', 0.00);
                                }
                            })
                            ->lazy(),
                        TextInput::make('haber')
                            ->label('Haber')
                            ->numeric()
                            ->step('0.01')
                            ->default(0.00)
                            ->required()
                            ->columnSpan(1)
                            ->reactive() // <-- Reactivo para sumar
                            ->afterStateUpdated(function ( $get, $set, $state) {
                                // Si escribe en Haber, pone Debe en 0
                                if (floatval($state) > 0) {
                                    $set('debe', 0.00);
                                }
                            })->lazy(),
                    ])
                    ->addActionLabel('Añadir Movimiento')
                    ->minItems(2) // Mínimo 2 líneas (partida doble)
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {
                                $totalDebe = 0;
                                $totalHaber = 0;

                                foreach ($value as $movimiento) {
                                    $totalDebe += floatval($movimiento['debe']);
                                    $totalHaber += floatval($movimiento['haber']);
                                }

                                // Usamos round() para evitar problemas con decimales
                                if (round($totalDebe, 2) !== round($totalHaber, 2)) {
                                    $fail('La partida doble no cuadra. Total Debe ($'. number_format($totalDebe, 2) .') no es igual al Total Haber ($'. number_format($totalHaber, 2) .').');
                                }
                            };
                        }
                    ]),

            ]);
    }
}
