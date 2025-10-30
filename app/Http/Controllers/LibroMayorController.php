<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta;
use App\Models\Movimiento;
use Barryvdh\DomPDF\Facade\Pdf;

class LibroMayorController extends Controller
{
    public function exportPdf(Request $request)
    {
        $cuentaId = $request->input('cuentaId');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');

        $cuenta = Cuenta::find($cuentaId);
        if (!$cuenta) {
            abort(404, 'Cuenta no encontrada');
        }

        $nombreCuentaSeleccionada = $cuenta->getCodigoNombreAttribute();

        // --- CÁLCULO DEL SALDO ANTERIOR ---
        $saldoAnterior = 0;
        $movsAnteriores = Movimiento::where('cuenta_id', $cuentaId)
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

        $movsPeriodo = Movimiento::where('cuenta_id', $cuentaId)
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

        $pdf = Pdf::loadView('pdf.libro_mayor', compact('resultados', 'nombreCuentaSeleccionada', 'fechaInicio', 'fechaFin', 'cuenta'));
        return $pdf->stream('Libro_Mayor.pdf');
    }
}
