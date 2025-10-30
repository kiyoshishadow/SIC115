<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReporteLibroMayorController extends Controller
{
    public function exportarPdf(Request $request)
    {
        $resultados = $request->session()->get('resultados_libro_mayor', []);
        $cuenta = $request->session()->get('cuenta_nombre', '');

        $pdf = Pdf::loadView('pdf.reporte-libro-mayor', [
            'resultados' => $resultados,
            'cuenta' => $cuenta,
        ]);

        return $pdf->download('libro_mayor.pdf');
    }
}
