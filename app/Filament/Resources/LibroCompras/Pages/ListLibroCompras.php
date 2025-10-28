<?php

namespace App\Filament\Resources\LibroCompras\Pages;

use App\Filament\Resources\LibroCompras\LibroCompraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLibroCompras extends ListRecords
{
    protected static string $resource = LibroCompraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
