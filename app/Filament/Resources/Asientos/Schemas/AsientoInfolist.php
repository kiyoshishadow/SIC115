<?php

namespace App\Filament\Resources\Asientos\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AsientoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                TextEntry::make('fecha')
                    ->date()
                    ->columns(4),
                TextEntry::make('numero_asiento')
                ->columns(4),
                TextEntry::make('tipo_asiento')
                    ->badge()
                    ->columns(4),
                RepeatableEntry::make('movimientos')
                    ->label('Detalle del Asiento')
                    ->columnSpanFull()
                    ->schema([
                        
                        TextEntry::make('cuenta.nombre') 
                            ->label('Cuenta'),

                        TextEntry::make('debe')
                            ->label('Debe')
                            ->alignEnd() // Alinea el número a la derecha
                            ->money('USD'), // Le da formato de moneda
                        
                        TextEntry::make('haber')
                            ->label('Haber')
                            ->alignEnd() // Alinea el número a la derecha
                            ->money('USD'), // Le da formato de moneda
                    ])
                    ->columns(4), // Muestra el detalle en 4 columnas
                TextEntry::make('descripcion'),
                TextEntry::make('total_debe')
                    ->label('Total Debe')
                    ->money('USD'),
                TextEntry::make('total_haber')
                    ->label('Total Haber')
                    ->money('USD'),
            ]);
    }
}
