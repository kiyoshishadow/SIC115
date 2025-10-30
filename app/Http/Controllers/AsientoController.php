<?php

namespace App\Http\Controllers;

use App\Models\Asiento;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AsientoController extends Controller
{
    public function exportPdf()
{
    $query = Asiento::with('movimientos.cuenta')->orderBy('fecha', 'asc');

    
    $filters = request('filters', []);

    if (!empty($filters['fecha']['fecha_inicio'])) {
        $query->whereDate('fecha', '>=', $filters['fecha']['fecha_inicio']);
    }
    if (!empty($filters['fecha']['fecha_fin'])) {
        $query->whereDate('fecha', '<=', $filters['fecha']['fecha_fin']);
    }

    $asientos = $query->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.libro_diario', compact('asientos'))
        ->setPaper('letter', 'portrait');

    return $pdf->stream('Libro_Diario.pdf');
}

}
