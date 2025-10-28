<?php

namespace App\Filament\Resources\LibroCompras\Schemas;

use App\Filament\Resources\Terceros\Schemas\TerceroForm;
//use Closure;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class LibroCompraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tercero_id')
                    ->label('Proveedor')
                    ->relationship(
                        name: 'tercero',
                        titleAttribute: 'nombre',
                    )
                    ->searchable()
                    ->preload()
                    ->createOptionForm(TerceroForm::getFormProveedores()) // Permite crear un tercero desde aquí
                    ->required(),
                DatePicker::make('fecha_documento')
                    ->label('Fecha del Documento')
                    ->required()
                    ->default(now()),
                TextInput::make('numero_documento')
                    ->label('N° de Documento (CCF, Factura)')
                    ->required()
                    ->maxLength(255),
                /*TextInput::make('monto_neto')
                    ->label('Monto Neto (Sin IVA)')
                    ->required()
                    ->numeric()
                    ->prefix('USD $'),*/
                TextInput::make('monto_neto')
                ->label('Monto Neto')
                ->numeric()
                ->required()
                ->reactive() 
                ->lazy()
                ->afterStateUpdated(function (Set $set, $state) {
                    $iva = round(floatval($state) * 0.13, 2);
                    $set('iva_credito_fiscal', $iva);
                }),
                TextInput::make('iva_credito_fiscal')
                    ->label('IVA Crédito Fiscal (Compras)')
                    ->required()
                    ->numeric()
                    ->prefix('USD $'),
                    
                TextInput::make('monto_exento')
                ->label('Monto Exento')
                ->numeric()
                ->required(),
                Textarea::make('concepto')
                    ->label('Concepto / Descripción')
                    ->columnSpanFull(),
            ]);
    }
}
