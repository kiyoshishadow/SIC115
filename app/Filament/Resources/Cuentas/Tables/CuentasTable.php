<?php

namespace App\Filament\Resources\Cuentas\Tables;

use BladeUI\Icons\Components\Icon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

use Filament\Tables\Actions\Action;

class CuentasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('padre.codigo')->label('Padre')->searchable(),
                TextColumn::make('codigo')->label('Código')->searchable(),
                TextColumn::make('nombre')->label('Nombre')->searchable(),
                TextColumn::make('tipo')->badge()->label('Tipo')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('naturaleza')->badge()->label('Naturaleza'),
                IconColumn::make('es_mayor')->boolean()->label('Cuenta Mayor'),
                IconColumn::make('permite_movimientos')->boolean()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('saldo_actual')->numeric()->label('Saldo')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('download_pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('danger')
                    ->url(fn ($record) => route('cuenta.pdf', ['cuenta' => $record]))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
