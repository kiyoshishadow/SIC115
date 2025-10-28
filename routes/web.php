<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuentaController;

// Redirigir la raíz al admin
Route::get('/', function () {
    return redirect('/admin');
});

// Ruta para generar el catálogo PDF
Route::get('/cuentas/catalogo-pdf', [CuentaController::class, 'generarCatalogo'])
    ->name('cuentas.catalogo.pdf');
