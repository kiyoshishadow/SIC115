<?php

namespace App\Filament\Resources\LibroVentas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class LibroVentasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fecha_documento')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('numero_documento')
                    ->label('N° Documento')
                    ->searchable(),
                TextColumn::make('tercero.nombre')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('monto_neto')
                    ->label('Neto')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('iva_debito_fiscal')
                    ->label('Débito Fiscal')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('total_documento')
                    ->label('Total')
                    ->money('USD')
                    ->sortable(),
            ])
            ->defaultSort('fecha_documento', 'desc')
            ->filters([
                //TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    //ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
