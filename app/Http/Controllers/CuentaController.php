<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use Barryvdh\DomPDF\Facade\Pdf;

class CuentaController extends Controller
{

  public function generarCatalogo()
{
    $cuentas = \App\Models\Cuenta::orderBy('codigo')->get();
    $data = [
        'cuentas' => $cuentas,
        'empresa' => 'Fremarca S.A de C.V',
        'fecha' => now()->format('d/m/Y')
    ];
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.catalogo_cuentas', $data);
    return $pdf->download('catalogo_cuentas.pdf'); // o ->stream() para abrir en el navegador
}

}
