<?php

namespace App\Filament\Resources\LibroVentas\Pages;

use App\Filament\Resources\LibroVentas\LibroVentaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLibroVenta extends CreateRecord
{
    protected static string $resource = LibroVentaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // --- 1. ARREGLO DEL TIPO DE LIBRO ---
        $data['tipo_libro'] = 'Venta';

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
