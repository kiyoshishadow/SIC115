<?php

namespace App\Filament\Resources\Asientos\Pages;

use App\Filament\Resources\Asientos\AsientoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAsiento extends CreateRecord
{
    protected static string $resource = AsientoResource::class;

    protected function afterCreate(): void
    {
        // $this->record es el Asiento que se acaba de crear
        $asiento = $this->record;

        // Ahora podemos consultar los movimientos que se acaban de guardar
        $totalDebe = $asiento->movimientos()->sum('debe');
        $totalHaber = $asiento->movimientos()->sum('haber');

        // Actualizamos el Asiento padre con los totales correctos
        // (Usamos updateQuietly para no disparar otros eventos y evitar bucles)
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
