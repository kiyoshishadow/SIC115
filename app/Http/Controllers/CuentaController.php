<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use Barryvdh\DomPDF\Facade\Pdf;

class CuentaController extends Controller
{
  public function generarCatalogo()
{
    $cuentas = \App\Models\Cuenta::orderBy('codigo')->get();
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.catalogo_cuentas', compact('cuentas'));
    return $pdf->download('catalogo_cuentas.pdf'); // o ->stream() para abrir en el navegador
}

}
