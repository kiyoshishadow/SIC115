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
use Filament\Tables\Actions\ButtonAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CuentasImport;
use Filament\Actions\Action;
use Filament\Tables\Filters\SelectFilter;

use Illuminate\Support\Facades\Response;
use Filament\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Barryvdh\DomPDF\Facade\Pdf;

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
                // Importar Excel
                Action::make('importar_excel')
                    ->label('Importar Excel')
                    ->icon('heroicon-o-document')
                    ->color('success')
                    ->form([
                        FileUpload::make('archivo')
                            ->acceptedFileTypes([
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.ms-excel'
                            ])
                            ->required()
                            ->storeFiles(false),
                    ])
                    ->action(function (array $data) {
                        $import = new CuentasImport();
                        Excel::import($import, $data['archivo']);

                        $ok = $import->getInsertadas();
                        $dup = $import->getDuplicadas();

                        Notification::make()
                            ->success()
                            ->title(" Importación finalizada")
                            ->body(" Insertadas: {$ok}\n Duplicadas ignoradas: {$dup}")
                            ->send();
                    }),
                // Descargar PDF (Todo)
                Action::make('descargar_catalogo_todo')
                    ->label('Descargar PDF (Todo)')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('danger')
                    ->url(route('cuentas.pdf'))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                BulkAction::make('descargar_pdf_seleccion')
                    ->label('Descargar PDF (Selección)')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Collection $records) {
                        // Generar el PDF con los registros seleccionados
                        $pdf = Pdf::loadView('pdf.catalogo_cuentas', [
                            'cuentas' => $records,
                            'empresa' => 'Fremarca S.A de C.V',
                            'fecha' => now()->format('d/m/Y')
                        ]);
                        
                        // Descargar el PDF
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'catalogo_cuentas_seleccion.pdf');
                    })
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
