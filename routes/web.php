<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\LibroCompraController;
use App\Http\Controllers\TerceroController;
use App\Http\Controllers\LibroVentaController;
Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/cuentas/catalogo-pdf', [CuentaController::class, 'generarCatalogo'])
    ->name('cuentas.catalogo.pdf');

Route::get('/libro-compras/pdf', [LibroCompraController::class, 'exportPdf'])
    ->name('librocompras.pdf');

Route::get('/libro-compras/excel', [LibroCompraController::class, 'exportExcel'])
    ->name('librocompras.excel');

Route::get('/terceros/pdf', [TerceroController::class, 'exportPdf'])->name('terceros.pdf');

Route::get('/libro-ventas/pdf', [LibroVentaController::class, 'exportPdf'])
    ->name('libroventas.pdf');