<?php

namespace App\Filament\Resources\Asientos\Pages;

use App\Filament\Resources\Asientos\AsientoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAsientos extends ListRecords
{
    protected static string $resource = AsientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
