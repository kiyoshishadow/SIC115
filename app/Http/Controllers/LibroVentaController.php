<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LibroIva;
use Barryvdh\DomPDF\Facade\Pdf;

class LibroVentaController extends Controller
{
    public function exportPdf()
    {
        
        $ventas = LibroIva::where('tipo_libro', 'venta')->get();

        
        $pdf = Pdf::loadView('pdf.libro_ventas', ['ventas' => $ventas]);

        
        return $pdf->download('libro_ventas.pdf');
    }
}
