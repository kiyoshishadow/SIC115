<?php

namespace App\Filament\Resources\Cuentas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CuentaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('padre_id')
                    ->relationship('padre', 'id')
                    ->default(null),
                TextInput::make('codigo')
                    ->required(),
                TextInput::make('nombre')
                    ->required(),
                Select::make('tipo')
                    ->options([
            'Activo' => 'Activo',
            'Pasivo' => 'Pasivo',
            'Patrimonio' => 'Patrimonio',
            'Ingreso' => 'Ingreso',
            'Costo' => 'Costo',
            'Gasto' => 'Gasto',
        ])
                    ->required(),
                Select::make('naturaleza')
                    ->options(['Deudor' => 'Deudor', 'Acreedor' => 'Acreedor'])
                    ->required(),
                Toggle::make('permite_movimientos')
                    ->required(),
                TextInput::make('saldo_actual')
                    ->required()
                    ->numeric()
                    ->default(0.0),
            ]);
    }
}
