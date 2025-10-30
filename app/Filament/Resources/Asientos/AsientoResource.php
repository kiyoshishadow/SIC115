<?php

namespace App\Filament\Resources\Asientos;
use Filament\Actions\Action;

use App\Filament\Resources\Asientos\Pages\CreateAsiento;
use App\Filament\Resources\Asientos\Pages\EditAsiento;
use App\Filament\Resources\Asientos\Pages\ListAsientos;
use App\Filament\Resources\Asientos\Pages\ViewAsiento;
use App\Filament\Resources\Asientos\Schemas\AsientoForm;
use App\Filament\Resources\Asientos\Schemas\AsientoInfolist;
use App\Filament\Resources\Asientos\Tables\AsientosTable;
use App\Models\Asiento;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\TextFilter;

class AsientoResource extends Resource
{
    protected static ?string $model = Asiento::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BookOpen;

    protected static ?string $recordTitleAttribute = 'numero_asiento';

    protected static ?string $modelLabel = 'Asiento de Diario';
    protected static ?string $pluralModelLabel = 'Asientos de Diario';

    public static function form(Schema $schema): Schema
    {
        return AsientoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AsientoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AsientosTable::configure($table)
        ->filters([
            // Filtro por fecha
            Filter::make('fecha')
                ->form([
                    DatePicker::make('fecha_inicio')->label('Fecha inicio'),
                    DatePicker::make('fecha_fin')->label('Fecha fin'),
                ])
                ->query(function ($query, array $data) {
                    return $query
                        ->when($data['fecha_inicio'], fn($q) => $q->whereDate('fecha', '>=', $data['fecha_inicio']))
                        ->when($data['fecha_fin'], fn($q) => $q->whereDate('fecha', '<=', $data['fecha_fin']));
                }),

            // Filtro por número de asiento
            Filter::make('numero_asiento')
                ->form([
                    \Filament\Forms\Components\TextInput::make('numero_asiento')->label('Número de Asiento')
                ])
                ->query(function ($query, array $data) {
                    return $query
                        ->when($data['numero_asiento'], fn($q) => $q->where('numero_asiento', 'like', "%{$data['numero_asiento']}%"));
                }),
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
            'index' => ListAsientos::route('/'),
            'create' => CreateAsiento::route('/create'),
            'view' => ViewAsiento::route('/{record}'),
            'edit' => EditAsiento::route('/{record}/edit'),
        ];
    }
}
