<?php

namespace App\Filament\Resources\LibroVentas\Schemas;

use App\Filament\Resources\Terceros\Schemas\TerceroForm;
use App\Filament\Resources\Terceros\TerceroResource;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Builder;

class LibroVentaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tercero_id')
                    ->label('Cliente')
                    ->relationship(
                        name: 'tercero', 
                        titleAttribute: 'nombre',
                        // Opcional: filtrar solo clientes si los tienes separados
                        modifyQueryUsing: fn (Builder $query) => $query->where('es_cliente', true) 
                    )
                    ->searchable()
                    ->preload()
                    ->createOptionForm(TerceroForm::getFormClientes()) // Permite crear un tercero desde aquí
                    ->required(),
                DatePicker::make('fecha_documento')
                    ->label('Fecha del Documento')
                    ->required()
                    ->default(now()),
                TextInput::make('numero_documento')
                    ->label('N° de Documento (Factura, CCF)')
                    ->required()
                    ->maxLength(255),
                TextInput::make('total_documento')
                    ->label('Monto Total (Con IVA)')
                    ->required()
                    ->numeric()
                    ->reactive() 
                    ->lazy()
                    ->afterStateUpdated(function (Set $set, $state) {
                        $neto = round(floatval($state) / 1.13, 2);
                        $iva = round(floatval($state) - $neto, 2);
                        $set('monto_neto', $neto);
                        $set('iva_debito_fiscal', $iva);
                    }),
                // --- CAMPO ESPECÍFICO DE VENTA ---
                TextInput::make('monto_neto')
                    ->label('Monto Neto (Sin IVA)')
                    ->required()
                    ->numeric(),
                TextInput::make('iva_debito_fiscal')
                    ->label('IVA Débito Fiscal (Ventas)')
                    ->required()
                    ->numeric(),
                Textarea::make('concepto')
                    ->label('Concepto / Descripción')
                    ->columnSpanFull(),
            ]);
    }
}
