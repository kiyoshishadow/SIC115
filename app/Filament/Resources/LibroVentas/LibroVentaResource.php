<?php

namespace App\Filament\Resources\LibroVentas;

use App\Filament\Resources\LibroVentas\Pages\CreateLibroVenta;
use App\Filament\Resources\LibroVentas\Pages\EditLibroVenta;
use App\Filament\Resources\LibroVentas\Pages\ListLibroVentas;
use App\Filament\Resources\LibroVentas\Schemas\LibroVentaForm;
use App\Filament\Resources\LibroVentas\Tables\LibroVentasTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Actions\Action;
use App\Models\LibroIva;
use App\Models\Tercero;
use Filament\Forms\Components\DatePicker;
use UnitEnum;

class LibroVentaResource extends Resource
{
    protected static ?string $model = LibroIva::class;

    //ETIQUETAS
    protected static ?string $modelLabel = 'Venta (Libro IVA)';
    protected static ?string $pluralModelLabel = 'Ventas (Libro IVA)';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowTrendingUp;
    protected static string|UnitEnum|null $navigationGroup = 'Libros de IVA'; 



    //protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'tipo_libro';

    // --- 3. FILTRADO AUTOMÁTICO (SOLO VENTAS) ---
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tipo_libro', 'venta');
    }

    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tipo_libro'] = 'venta';
        return $data;
    }

    public static function form(Schema $schema): Schema
    {
        return LibroVentaForm::configure($schema);
    }

public static function table(Table $table): Table
{
    return LibroVentasTable::configure($table)
        ->headerActions([
            Action::make('descargar_pdf')
                ->label('PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('danger')
                ->url(route('libroventas.pdf'))
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
            'index' => ListLibroVentas::route('/'),
            'create' => CreateLibroVenta::route('/create'),
            'edit' => EditLibroVenta::route('/{record}/edit'),
        ];
    }
/*
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }*/
}
