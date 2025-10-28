<?php

namespace App\Filament\Resources\Terceros\Pages;

use App\Filament\Resources\Terceros\TerceroResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTerceros extends ListRecords
{
    protected static string $resource = TerceroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
