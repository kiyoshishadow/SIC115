<?php

namespace App\Http\Controllers;

use App\Models\Asiento;
use Barryvdh\DomPDF\Facade\Pdf;

class AsientoController extends Controller
{
    public function exportPdf()
    {
        // Cargamos los asientos con sus movimientos
        $asientos = Asiento::with('movimientos.cuenta')
            ->orderBy('fecha', 'asc')
            ->get();

        // Carga la vista del PDF
        $pdf = Pdf::loadView('pdf.libro_diario', compact('asientos'))
            ->setPaper('letter', 'portrait');

        return $pdf->stream('Libro_Diario.pdf');
    }
}
