<?php

namespace App\Filament\Resources\Asientos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AsientosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fecha')
                    ->date()
                    ->sortable(),
                TextColumn::make('numero_asiento')
                    ->searchable(),
                TextColumn::make('descripcion'),
                TextColumn::make('total_debe')
                    ->label('Total Debe')
                    ->numeric(decimalPlaces: 2)
                    ->money('USD'),
                TextColumn::make('total_haber')
                    ->label('Total Haber')
                    ->numeric(decimalPlaces: 2)
                    ->money('USD'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('fecha', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
