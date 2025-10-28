<?php

namespace App\Filament\Resources\LibroCompras;

use App\Filament\Resources\LibroCompras\Pages\CreateLibroCompra;
use App\Filament\Resources\LibroCompras\Pages\EditLibroCompra;
use App\Filament\Resources\LibroCompras\Pages\ListLibroCompras;
use App\Filament\Resources\LibroCompras\Schemas\LibroCompraForm;
use App\Filament\Resources\LibroCompras\Tables\LibroComprasTable;
use App\Models\LibroIva;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\DatePicker;

class LibroCompraResource extends Resource
{
    protected static ?string $model = LibroIva::class;

    // --- 2. ETIQUETAS PARA EL MENÚ ---
    protected static ?string $modelLabel = 'Compra (Libro IVA)';
    protected static ?string $pluralModelLabel = 'Compras (Libro IVA)';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowTrendingDown;
    protected static string|UnitEnum|null $navigationGroup = 'Libros de IVA'; // Mismo grupo

    //protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'tipo_libro';

    // --- 3. FILTRADO AUTOMÁTICO (SOLO COMPRAS) ---
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tipo_libro', 'compra');
    }

    // --- 4. ASIGNACIÓN AUTOMÁTICA AL CREAR ---
    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tipo_libro'] = 'compra';
        return $data;
    }

    public static function form(Schema $schema): Schema
    {
        return LibroCompraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LibroComprasTable::configure($table);
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
            'index' => ListLibroCompras::route('/'),
            'create' => CreateLibroCompra::route('/create'),
            'edit' => EditLibroCompra::route('/{record}/edit'),
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
