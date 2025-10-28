<?php

namespace App\Filament\Resources\Terceros;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\Terceros\Pages\CreateTercero;
use App\Filament\Resources\Terceros\Pages\EditTercero;
use App\Filament\Resources\Terceros\Pages\ListTerceros;
use App\Filament\Resources\Terceros\Pages\ViewTercero;
use App\Filament\Resources\Terceros\Schemas\TerceroForm;
use App\Filament\Resources\Terceros\Schemas\TerceroInfolist;
use App\Filament\Resources\Terceros\Tables\TercerosTable;
use App\Models\Tercero;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Actions\Action;
class TerceroResource extends Resource
{
    protected static ?string $model = Tercero::class;

    // --- ETIQUETAS EN ESPAÑOL ---
    protected static ?string $modelLabel = 'Cliente/Proveedor';
    protected static ?string $pluralModelLabel = 'Clientes/Proveedores';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Identification;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return TerceroForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TerceroInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TercerosTable::configure($table)
        ->filters([
            SelectFilter::make('es_cliente')
                ->label('Cliente')
                ->options([
                    1 => 'Sí',
                    0 => 'No',
                ]),
            SelectFilter::make('es_proveedor')
                ->label('Proveedor')
                ->options([
                    1 => 'Sí',
                    0 => 'No',
                ]),
            SelectFilter::make('es_gran_contribuyente')
                ->label('Gran Contribuyente')
                ->options([
                    1 => 'Sí',
                    0 => 'No',
                ]),
        ])
        ->headerActions([
            Action::make('descargar_pdf')
                ->label('Descargar PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('danger')
                ->url(route('terceros.pdf'))
                ->openUrlInNewTab(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTerceros::route('/'),
            'create' => CreateTercero::route('/create'),
            'view' => ViewTercero::route('/{record}'),
            'edit' => EditTercero::route('/{record}/edit'),
        ];
    }
}
