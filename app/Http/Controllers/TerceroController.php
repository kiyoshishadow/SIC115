<?php
namespace App\Http\Controllers;
use App\Models\Tercero;
use Barryvdh\DomPDF\Facade\Pdf;

class TerceroController extends Controller
{
    public function exportPdf()
    {
        $terceros = Tercero::all();
        $pdf = Pdf::loadView('pdf.terceros', compact('terceros'));
        return $pdf->download('terceros.pdf');
    }
}
