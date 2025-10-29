<?php

namespace App\Filament\Resources\Asientos\Pages;

use App\Filament\Resources\Asientos\AsientoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAsiento extends ViewRecord
{
    protected static string $resource = AsientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
