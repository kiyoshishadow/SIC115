<?php

namespace App\Filament\Resources\Cuentas;

use App\Filament\Resources\Cuentas\Pages\CreateCuenta;
use App\Filament\Resources\Cuentas\Pages\EditCuenta;
use App\Filament\Resources\Cuentas\Pages\ListCuentas;
use App\Filament\Resources\Cuentas\Pages\ViewCuenta;
use App\Filament\Resources\Cuentas\Schemas\CuentaForm;
use App\Filament\Resources\Cuentas\Schemas\CuentaInfolist;
use App\Filament\Resources\Cuentas\Tables\CuentasTable;
use App\Models\Cuenta;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CuentasImport;
use Filament\Actions\BulkAction;
use Filament\Actions\Action;
// Filament 4
use Filament\Tables\Actions\ButtonAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;

class CuentaResource extends Resource
{
    protected static ?string $model = Cuenta::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CuentaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CuentaInfolist::configure($schema);
    }

public static function table(Table $table): Table
{
    return CuentasTable::configure($table)
        ->filters([
            SelectFilter::make('tipo')->options([
                'Activo' => 'Activo',
                'Pasivo' => 'Pasivo',
                'Patrimonio' => 'Patrimonio',
                'Ingreso' => 'Ingreso',
                'Costo' => 'Costo',
                'Gasto' => 'Gasto',
            ]),
            SelectFilter::make('naturaleza')->options([
                'Deudor' => 'Deudor',
                'Acreedor' => 'Acreedor',
            ]),
        ])
        ->headerActions([
            Action::make('importar_excel')
                ->label('Importar Excel')
                ->icon('heroicon-o-document')
                ->color('success')
                ->form([
                    FileUpload::make('archivo')
                        ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'])
                        ->required()
                        ->storeFiles(false),
                ])
                ->action(function (array $data) {
    $import = new CuentasImport;
    Excel::import($import, $data['archivo']);

    $count = $import->getRowCount() ?? 'desconocido';

    Notification::make()
        ->success()
        ->title("Se importaron {$count} cuentas correctamente")
        ->send();
}),

        ]);
}


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCuentas::route('/'),
            'create' => CreateCuenta::route('/create'),
            'view' => ViewCuenta::route('/{record}'),
            'edit' => EditCuenta::route('/{record}/edit'),
        ];
    }
}
