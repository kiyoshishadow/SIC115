<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\LibroIva;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LibroComprasExport;

class LibroCompraController extends Controller
{
    public function exportPdf()
    {
        $compras = LibroIva::where('tipo_libro', 'compra')->get();

        $pdf = Pdf::loadView('pdf.libro_compras', ['compras' => $compras]);
        return $pdf->download('libro_compras.pdf');
    }

    
}
