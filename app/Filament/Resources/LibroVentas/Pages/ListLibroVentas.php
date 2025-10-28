<?php

namespace App\Filament\Resources\LibroVentas\Pages;

use App\Filament\Resources\LibroVentas\LibroVentaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLibroVentas extends ListRecords
{
    protected static string $resource = LibroVentaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
