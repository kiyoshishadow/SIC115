<?php

namespace App\Filament\Resources\LibroCompras\Pages;

use App\Filament\Resources\LibroCompras\LibroCompraResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditLibroCompra extends EditRecord
{
    protected static string $resource = LibroCompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            //ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
