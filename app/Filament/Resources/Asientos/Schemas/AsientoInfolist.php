<?php

namespace App\Filament\Resources\Asientos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AsientoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('fecha')
                    ->date(),
                TextEntry::make('numero_asiento'),
                TextEntry::make('descripcion')
                    ->columnSpanFull(),
                TextEntry::make('tipo_asiento')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
