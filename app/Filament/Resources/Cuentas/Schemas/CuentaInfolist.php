<?php

namespace App\Filament\Resources\Cuentas\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CuentaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('padre.id')
                    ->label('Padre')
                    ->placeholder('-'),
                TextEntry::make('codigo'),
                TextEntry::make('nombre'),
                TextEntry::make('tipo')
                    ->badge(),
                TextEntry::make('naturaleza')
                    ->badge(),
                IconEntry::make('permite_movimientos')
                    ->boolean(),
                TextEntry::make('saldo_actual')
                    ->numeric(),
                IconEntry::make('es_mayor')
                    ->label('Cuenta Mayor')
                    ->boolean()
                
                /*TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),*/
            ]);
    }
}
