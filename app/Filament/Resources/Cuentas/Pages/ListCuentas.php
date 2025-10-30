<?php

namespace App\Filament\Resources\Cuentas\Pages;

use App\Filament\Resources\Cuentas\CuentaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;

class ListCuentas extends ListRecords
{
    protected static string $resource = CuentaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('export_pdf')
                ->label('Descargar Catálogo PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('danger')
                ->url(route('cuentas.pdf'))
                ->openUrlInNewTab(),
        ];
    }
}
