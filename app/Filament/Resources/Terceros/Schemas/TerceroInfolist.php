<?php

namespace App\Filament\Resources\Terceros\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TerceroInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nombre'),
                TextEntry::make('nrc')
                    ->placeholder('-'),
                TextEntry::make('nit')
                    ->placeholder('-'),
                TextEntry::make('giro')
                    ->placeholder('-'),
                IconEntry::make('es_cliente')
                    ->boolean(),
                IconEntry::make('es_proveedor')
                    ->boolean(),
                IconEntry::make('es_gran_contribuyente')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
