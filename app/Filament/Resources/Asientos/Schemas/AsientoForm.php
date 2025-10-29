<?php

namespace App\Filament\Resources\Asientos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AsientoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('fecha')
                    ->required(),
                TextInput::make('numero_asiento')
                    ->required(),
                Textarea::make('descripcion')
                    ->required()
                    ->columnSpanFull(),
                Select::make('tipo_asiento')
                    ->options(['Diario' => 'Diario', 'Apertura' => 'Apertura', 'Cierre' => 'Cierre', 'Ajuste' => 'Ajuste'])
                    ->default('Diario')
                    ->required(),
            ]);
    }
}
