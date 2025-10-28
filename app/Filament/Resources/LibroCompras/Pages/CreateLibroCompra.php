<?php

namespace App\Filament\Resources\LibroCompras\Pages;

use App\Filament\Resources\LibroCompras\LibroCompraResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLibroCompra extends CreateRecord
{
    protected static string $resource = LibroCompraResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // --- 1. ARREGLO DEL TIPO DE LIBRO ---
        // Usamos la columna 'tipo_libro' y el valor 'Compra'
        // (con mayúscula, como en tu migración).
        $data['tipo_libro'] = 'Compra';

        // --- 2. ARREGLO DEL CÁLCULO TOTAL ---
        // Obtenemos todos los valores del formulario
        $neto = floatval($data['monto_neto'] ?? 0);
        $exento = floatval($data['monto_exento'] ?? 0);
        $credito_fiscal = floatval($data['iva_credito_fiscal'] ?? 0);
        $percibido = floatval($data['iva_percibido'] ?? 0);
        $retenido = floatval($data['iva_retenido'] ?? 0);

        // Fórmula contable correcta para el total de una compra
        // Total = (Neto + Exento + IVA) + Percepción - Retención
        $data['total_documento'] = $neto + $exento + $credito_fiscal + $percibido - $retenido;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
