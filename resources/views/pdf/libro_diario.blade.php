<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libro Diario</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 25px 35px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
        }
        h2 { font-size: 16px; margin-bottom: 5px; }
        h4 { margin-bottom: 20px; font-weight: normal; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th, td { padding: 6px 8px; }
        th {
            border-bottom: 1px solid #000;
            border-top: 1px solid #000;
            text-align: center;
            font-weight: bold;
        }

        tr.linea td { border-bottom: 1px dotted #888; }

        .codigo { width: 15%; text-align: left; }
        .cuenta { width: 45%; text-align: left; }
        .debe, .haber { width: 20%; text-align: right; }

        .total { border-top: 1px solid #000; font-weight: bold; text-align: right; }
        .descripcion { font-style: italic; padding-top: 4px; }
        .asiento-titulo { margin-top: 20px; font-weight: bold; border-bottom: 1px solid #000; padding-bottom: 4px; }
    </style>
</head>
<body>

<h2>LIBRO DIARIO</h2>
<h4>Período: {{ now()->format('F Y') }}</h4>

@foreach ($asientos as $asiento)
    <div class="asiento-titulo">
        Asiento N° {{ $asiento->numero_asiento }} — Fecha: {{ \Carbon\Carbon::parse($asiento->fecha)->format('d/m/Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Cuenta</th>
                <th>Código</th>
                <th>Debe</th>
                <th>Haber</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asiento->movimientos as $mov)
    <tr class="linea">
        <td class="cuenta">{{ $mov->cuenta->nombre ?? 'Cuenta sin nombre' }}</td>
        <td class="codigo">{{ $mov->cuenta->codigo ?? '' }}</td>
        <td class="debe">{{ $mov->tipo_movimiento === 'D' ? number_format($mov->monto, 2) : '' }}</td>
        <td class="haber">{{ $mov->tipo_movimiento === 'C' ? number_format($mov->monto, 2) : '' }}</td>
    </tr>
@endforeach


            <tr class="total">
                <td colspan="2">Totales:</td>
                <td>{{ number_format($asiento->total_debe, 2) }}</td>
                <td>{{ number_format($asiento->total_haber, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="descripcion">
                    {{ $asiento->descripcion }}
                </td>
            </tr>
        </tbody>
    </table>
@endforeach

</body>
</html>
