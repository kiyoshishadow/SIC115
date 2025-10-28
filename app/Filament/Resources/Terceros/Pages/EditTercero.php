<?php

namespace App\Filament\Resources\Terceros\Pages;

use App\Filament\Resources\Terceros\TerceroResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTercero extends EditRecord
{
    protected static string $resource = TerceroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
