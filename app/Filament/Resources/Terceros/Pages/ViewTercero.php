<?php

namespace App\Filament\Resources\Terceros\Pages;

use App\Filament\Resources\Terceros\TerceroResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTercero extends ViewRecord
{
    protected static string $resource = TerceroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
