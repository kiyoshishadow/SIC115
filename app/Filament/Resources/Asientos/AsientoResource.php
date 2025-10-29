<?php

namespace App\Filament\Resources\Asientos;

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

class AsientoResource extends Resource
{
    protected static ?string $model = Asiento::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'numero_asiento';

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
        return AsientosTable::configure($table);
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
