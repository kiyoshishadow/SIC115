<?php

namespace App\Filament\Resources\LibroCompras;
use Filament\Tables\Filters\Filter;


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
use Filament\Actions\Action; // Importa Action
use Filament\Forms\Components\DatePicker;

class LibroCompraResource extends Resource
{
    protected static ?string $model = LibroIva::class;

    // --- 2. ETIQUETAS PARA EL MENÚ ---
    protected static ?string $modelLabel = 'Compra (Libro IVA)';
    protected static ?string $pluralModelLabel = 'Compras (Libro IVA)';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowTrendingDown;
    protected static string|UnitEnum|null $navigationGroup = 'Libros de IVA'; // Mismo grupo

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
      return LibroComprasTable::configure($table)
        ->filters([
            Filter::make('fecha_documento')
                ->form([
                    DatePicker::make('fecha_inicio')->label('Fecha inicio'),
                    DatePicker::make('fecha_fin')->label('Fecha fin'),
                ])
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['fecha_inicio'])) {
                        $query->where('fecha_documento', '>=', $data['fecha_inicio']);
                    }
                    if (!empty($data['fecha_fin'])) {
                        $query->where('fecha_documento', '<=', $data['fecha_fin']);
                    }
                })
                ->indicateUsing(function (array $data) {
                    if (!empty($data['fecha_inicio']) && !empty($data['fecha_fin'])) {
                        return "Desde {$data['fecha_inicio']} hasta {$data['fecha_fin']}";
                    }
                    return null;
                }),
        ])
        ->headerActions([
            Action::make('descargar_pdf')
                ->label('Descargar PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('danger')
                ->url(route('librocompras.pdf'))
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
