<?php

namespace App\Filament\Resources\Asientos\Pages;

use App\Filament\Resources\Asientos\AsientoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAsiento extends EditRecord
{
    protected static string $resource = AsientoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
