<?php

namespace App\Filament\Resources\Asientos\Pages;
use Filament\Actions\Action;
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

        Action::make('libro_diario_pdf')
    ->label('Descargar PDF')
    ->icon('heroicon-o-arrow-down-tray')
    ->color('danger')
    ->before(function () {
        // Inyecta JS para refrescar la página antes de abrir el PDF
        $this->dispatchBrowserEvent('refresh-before-pdf');
    })
    ->url(fn () => route('asientos.pdf', request()->only(['filters'])))
    ->openUrlInNewTab(),

    ];
}
}
