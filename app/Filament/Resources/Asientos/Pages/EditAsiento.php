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
            //DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // $this->record es el Asiento que se acaba de editar
        $asiento = $this->record;

        $totalDebe = $asiento->movimientos()->sum('debe');
        $totalHaber = $asiento->movimientos()->sum('haber');

        // Actualizamos los totales
        $asiento->updateQuietly([
            'total_debe' => $totalDebe,
            'total_haber' => $totalHaber,
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
