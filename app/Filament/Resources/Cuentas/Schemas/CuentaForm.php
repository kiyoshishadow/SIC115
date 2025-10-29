<?php
namespace App\Filament\Resources\Cuentas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use App\Models\Cuenta;

class CuentaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('padre_id')
    ->label('Cuenta Padre')
    ->options(
        Cuenta::orderBy('codigo')
            ->get()
            ->mapWithKeys(fn ($c) => [$c->id => "{$c->codigo} - {$c->nombre}"])
            ->toArray()
    )
    ->searchable()
    ->preload()
    ->default(null),


                TextInput::make('codigo')
                    ->required()
                    ->unique(table: Cuenta::class, column: 'codigo', ignoreRecord: true) // <-- evita duplicados
                    ->maxLength(20)
                    ->helperText('El código debe ser único'),

                TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),

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
                TextInput::make('saldo_actual')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Toggle::make('permite_movimientos')
                    ->default(true)
                    ->required(),
                Toggle::make('es_mayor')
                    ->label('Cuenta Mayor')
                    ->default(true)
                    ->required(),
                
            ]);
    }
}
