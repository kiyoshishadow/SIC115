<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\LibroCompraController;
use App\Http\Controllers\TerceroController;
use App\Http\Controllers\LibroVentaController;
use App\Http\Controllers\AsientoController;
use App\Http\Controllers\LibroMayorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/asientos/pdf', [AsientoController::class, 'exportPdf'])->name('asientos.pdf');
Route::get('/libro-mayor/pdf', [LibroMayorController::class, 'exportPdf'])->name('libro-mayor.pdf');
Route::get('/cuentas/pdf', [CuentaController::class, 'generarCatalogo'])->name('cuentas.pdf');
Route::get('/cuenta.pdf/{cuenta}', [CuentaController::class, 'exportCuentaPdf'])->name('cuenta.pdf');
Route::get('/libro-compras/pdf', [LibroCompraController::class, 'exportPdf'])->name('librocompras.pdf');
Route::get('/libro-ventas/pdf', [LibroVentaController::class, 'exportPdf'])->name('libroventas.pdf');
Route::get('/terceros/pdf', [TerceroController::class, 'exportPdf'])->name('terceros.pdf');