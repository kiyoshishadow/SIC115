<?php

namespace App\Filament\Resources\Terceros\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TerceroForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre o Razón Social')
                    ->required(),
                TextInput::make('nrc')
                    ->label('N° de Registro (NRC)')
                    ->default(null),
                TextInput::make('nit')
                    ->label('NIT/DUI')
                    ->default(null),
                TextInput::make('giro')
                    ->label('Giro')
                    ->default(null),
                Toggle::make('es_cliente')
                    ->label('Es Cliente')
                    ->default(true)
                    ->required(),
                Toggle::make('es_proveedor')
                    ->label('Es Proveedor')
                    ->required(),
                Toggle::make('es_gran_contribuyente')
                    ->label('Es Gran Contribuyente')
                    ->required(),
            ]);
    }

    public static function getFormClientes(): array
    {
        return [
            TextInput::make('nombre')
                ->label('Nombre o Razón Social')
                ->required()
                ->columnSpanFull(), // Ocupa todo el ancho
            TextInput::make('nrc')
                ->label('N° de Registro (NRC)')
                ->default(null),
            TextInput::make('nit')
                ->label('NIT/DUI')
                ->default(null),
            TextInput::make('giro')
                ->label('Giro')
                ->default(null),
            Toggle::make('es_cliente')
                ->label('Es Cliente')
                ->required()
                ->default(true), 
            Toggle::make('es_proveedor')
                ->label('Es Proveedor')
                ->required()
                ->default(false),
            Toggle::make('es_gran_contribuyente')
                ->label('Es Gran Contribuyente')
                ->required()
                ->default(false),
        ];
    }
    public static function getFormProveedores(): array
    {
        return [
            TextInput::make('nombre')
                ->label('Nombre o Razón Social')
                ->required()
                ->columnSpanFull(),
            TextInput::make('nrc')
                ->label('N° de Registro (NRC)')
                ->default(null),
            TextInput::make('nit')
                ->label('NIT/DUI')
                ->default(null),
            TextInput::make('giro')
                ->label('Giro')
                ->default(null),
            Toggle::make('es_cliente')
                ->label('Es Cliente')
                ->required()
                ->default(false), 
            Toggle::make('es_proveedor')
                ->label('Es Proveedor')
                ->required()
                ->default(true),
            Toggle::make('es_gran_contribuyente')
                ->label('Es Gran Contribuyente')
                ->required()
                ->default(false),
        ];
    }
}
