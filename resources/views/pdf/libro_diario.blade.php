<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libro Diario - Fremarca S.A. de C.V.</title>
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

        .total { 
            border-top: 1px solid #000; 
            font-weight: bold; 
            text-align: right; 
            background-color: #f0f0f0; 
        }

        .descripcion { 
            font-style: italic; 
            padding-top: 4px; 
        }

        .asiento-titulo { 
            margin-top: 20px; 
            font-weight: bold; 
            border-bottom: 1px solid #000; 
            padding-bottom: 4px; 
        }
    </style>
</head>
<body>

<!-- Encabezado general -->
<h2>Fremarca S.A. de C.V.</h2>
<h2>LIBRO DIARIO</h2>
<h4>Período: {{ now()->format('F Y') }}</h4>
<h4>
    Total General Debe: ${{ number_format($asientos->sum(fn($a) => $a->total_debe), 2) }} | 
    Total General Haber: ${{ number_format($asientos->sum(fn($a) => $a->total_haber), 2) }}
</h4>

@foreach ($asientos as $asiento)
    <!-- Título por asiento con totales -->
    <div class="asiento-titulo">
        Fecha: {{ \Carbon\Carbon::parse($asiento->fecha)->format('d/m/Y') }} — Asiento N° {{ $asiento->numero_asiento }}  
    </div>
    <!-- Total Debe: ${{ number_format($asiento->total_debe, 2) }} | 
        Total Haber: ${{ number_format($asiento->total_haber, 2) }} -->

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Cuenta</th>
                <th>Debe</th>
                <th>Haber</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asiento->movimientos as $mov)
                <tr class="linea">
                    <td class="codigo">{{ $mov->cuenta->codigo ?? '' }}</td>
                    <td class="cuenta">{{ $mov->cuenta->nombre ?? 'Cuenta sin nombre' }}</td>
                    <td class="debe">{{ $mov->debe ?? '0.00' }}</td>
                    <td class="haber">{{ $mov->haber ?? '0.00' }}</td>
                </tr>
            @endforeach

            <!-- Totales por asiento -->
            <tr class="total">
                <td colspan="2" style="text-align: left;">C/ {{ $asiento->descripcion }}</td>
                <td>{{ number_format($asiento->total_debe, 2) }}</td>
                <td>{{ number_format($asiento->total_haber, 2) }}</td>
            </tr>

            <!-- Descripción -->
            <!--tr>
                <td colspan="4" class="descripcion">
                    {{ $asiento->descripcion }}
                </td>
            </tr-->
        </tbody>
    </table>
@endforeach

</body>
</html>
