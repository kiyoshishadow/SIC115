<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;

class CuentaController extends Controller
{

  public function generarCatalogo()
{
    $cuentas = \App\Models\Cuenta::orderBy('codigo')->get();
    $data = [
        'cuentas' => $cuentas,
        'empresa' => 'Mi Empresa S.A. de C.V.',
        'fecha' => now()->format('d/m/Y')
    ];
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.catalogo_cuentas', $data);
    return $pdf->stream('catalogo_cuentas.pdf'); // o ->stream() para abrir en el navegador
}

public function exportCuentaPdf(Cuenta $cuenta)
{
    $fechaInicio = now()->startOfYear()->format('Y-m-d');
    $fechaFin = now()->endOfYear()->format('Y-m-d');

    $nombreCuentaSeleccionada = $cuenta->getCodigoNombreAttribute();

    // --- CÁLCULO DEL SALDO ANTERIOR ---
    $saldoAnterior = 0;
    $movsAnteriores = Movimiento::where('cuenta_id', $cuenta->id)
        ->join('asientos', 'movimientos.asiento_id', '=', 'asientos.id')
        ->where('asientos.fecha', '<', $fechaInicio)
        ->select('movimientos.debe', 'movimientos.haber')
        ->get();

    foreach ($movsAnteriores as $mov) {
        if ($cuenta->naturaleza === 'Deudor') {
            $saldoAnterior += ($mov->debe - $mov->haber);
        } else { // Asumimos 'Acreedor'
            $saldoAnterior += ($mov->haber - $mov->debe);
        }
    }

    $movsPeriodo = Movimiento::where('cuenta_id', $cuenta->id)
        ->join('asientos', 'movimientos.asiento_id', '=', 'asientos.id')
        ->whereBetween('asientos.fecha', [$fechaInicio, $fechaFin])
        ->select(
            'asientos.fecha',
            'asientos.numero_asiento',
            'movimientos.debe',
            'movimientos.haber'
        )
        ->orderBy('asientos.fecha')
        ->orderBy('asientos.id')
        ->get();

    $resultados = [];
    $saldoCorriente = $saldoAnterior;
    $resultados[] = [
        'fecha' => $fechaInicio,
        'numero_partida' => 'SALDO ANTERIOR AL PERÍODO',
        'debe' => 0,
        'haber' => 0,
        'saldo' => $saldoCorriente,
    ];

    foreach ($movsPeriodo as $mov) {
        $delta = 0;
        if ($cuenta->naturaleza === 'Deudor') {
            $delta = $mov->debe - $mov->haber;
        } else { // 'Acreedor'
            $delta = $mov->haber - $mov->debe;
        }
        $saldoCorriente += $delta;

        $resultados[] = [
            'fecha' => $mov->fecha,
            'numero_partida' => $mov->numero_asiento,
            'debe' => $mov->debe,
            'haber' => $mov->haber,
            'saldo' => $saldoCorriente,
        ];
    }

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.libro_mayor', compact('resultados', 'nombreCuentaSeleccionada', 'fechaInicio', 'fechaFin', 'cuenta'));
    return $pdf->stream('Libro_Mayor_' . $cuenta->codigo . '.pdf');
}

}
