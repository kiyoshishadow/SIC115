<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance General - Fremarca S.A. de C.V.</title>
    <style>
        @page {
            size: portrait;
            margin: 20mm 15mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9pt;
            color: #2c3e50;
            line-height: 1.3;
        }

        /* Encabezado Corporativo */
        .header-corporativo {
            text-align: center;
            border-bottom: 3px solid #1a1a1a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header-corporativo .empresa {
            font-size: 22pt;
            font-weight: bold;
            color: #1a1a1a;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .header-corporativo .documento {
            font-size: 14pt;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 6px;
        }

        .header-corporativo .fecha {
            font-size: 10pt;
            color: #7f8c8d;
            font-weight: 500;
        }

        .header-corporativo .generado {
            font-size: 7pt;
            color: #95a5a6;
            font-style: italic;
            margin-top: 4px;
        }

        /* Títulos de sección */
        .section-title {
            background-color: #2c3e50;
            color: white;
            padding: 8px 12px;
            font-size: 11pt;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-left: 5px solid #95a5a6;
        }

        .section-title:first-of-type {
            margin-top: 0;
        }

        /* Tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            background-color: white;
        }

        table.datos-tabla {
            border: 1px solid #bdc3c7;
        }

        /* Encabezado de tabla */
        table.datos-tabla thead {
            background-color: #ecf0f1;
            border-bottom: 2px solid #95a5a6;
        }

        table.datos-tabla th {
            padding: 7px 10px;
            text-align: left;
            font-size: 8pt;
            font-weight: 700;
            color: #2c3e50;
            text-transform: uppercase;
            border-right: 1px solid #d5d8dc;
        }

        table.datos-tabla th:last-child {
            border-right: none;
        }

        table.datos-tabla th.col-codigo {
            width: 18%;
        }

        table.datos-tabla th.col-cuenta {
            width: 52%;
        }

        table.datos-tabla th.col-importe {
            width: 30%;
            text-align: right;
        }

        /* Cuerpo de tabla */
        table.datos-tabla tbody tr {
            border-bottom: 1px solid #ecf0f1;
        }

        table.datos-tabla tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        table.datos-tabla td {
            padding: 6px 10px;
            font-size: 8.5pt;
            color: #2c3e50;
            border-right: 1px solid #ecf0f1;
        }

        table.datos-tabla td:last-child {
            border-right: none;
        }

        table.datos-tabla td.codigo {
            font-family: 'Courier New', monospace;
            font-size: 8pt;
            color: #7f8c8d;
            font-weight: 600;
        }

        table.datos-tabla td.cuenta {
            color: #34495e;
        }

        table.datos-tabla td.importe {
            text-align: right;
            font-weight: 500;
            font-family: 'Courier New', monospace;
        }

        /* Totales */
        table.datos-tabla tfoot tr {
            background-color: #34495e;
            color: white;
            font-weight: bold;
            border-top: 2px solid #2c3e50;
        }

        table.datos-tabla tfoot td {
            padding: 8px 10px;
            font-size: 9pt;
            border-right: none;
        }

        /* Total intermedio (subtotales) */
        table.datos-tabla tfoot.subtotal tr {
            background-color: #95a5a6;
            color: white;
        }

        /* Total final más destacado */
        .total-final {
            background-color: #1a1a1a !important;
            color:#ccc !important;
            font-size: 10pt !important;
            padding: 10px !important;
        }

        /* Mensaje vacío */
        .no-data {
            text-align: center;
            padding: 25px;
            color: #95a5a6;
            font-style: italic;
            background-color: #f8f9fa;
            border: 1px dashed #bdc3c7;
            border-radius: 4px;
            font-size: 8.5pt;
            margin-bottom: 12px;
        }

        /* Footer del documento */
        .footer {
            position: fixed;
            bottom: 10mm;
            left: 15mm;
            right: 15mm;
            text-align: center;
            font-size: 7pt;
            color: #95a5a6;
            padding-top: 8px;
            border-top: 1px solid #ecf0f1;
        }

        /* Espaciado entre secciones */
        .seccion-balance {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    {{-- Encabezado Corporativo --}}
    <div class="header-corporativo">
        <div class="empresa">FREMARCA S.A. DE C.V.</div>
        <div class="documento">Balance General</div>
        <div class="fecha">
            Al {{ \Carbon\Carbon::parse($fecha)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
        </div>
        <div class="generado">
            Documento generado el {{ now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] HH:mm') }} hrs
        </div>
    </div>

    {{-- ACTIVOS --}}
    <div class="seccion-balance">
        <div class="section-title">Activos</div>
        
        @if(count($data['activos']) > 0)
            <table class="datos-tabla">
                <thead>
                    <tr>
                        <th class="col-codigo">Código</th>
                        <th class="col-cuenta">Cuenta</th>
                        <th class="col-importe">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['activos'] as $cuenta)
                        <tr>
                            <td class="codigo">{{ $cuenta['codigo'] }}</td>
                            <td class="cuenta">{{ $cuenta['nombre'] }}</td>
                            <td class="importe">${{ number_format($cuenta['saldo'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="subtotal"  style="font-weight: bold;">
                    <tr>
                        <td colspan="2">TOTAL DE ACTIVOS</td>
                        <td class="importe">${{ number_format($data['totalActivo'], 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        @else
            <div class="no-data">No hay cuentas de activo registradas</div>
        @endif
    </div>

    {{-- PASIVOS --}}
    <div class="seccion-balance">
        <div class="section-title">Pasivos</div>
        
        @if(count($data['pasivos']) > 0)
            <table class="datos-tabla">
                <thead>
                    <tr>
                        <th class="col-codigo">Código</th>
                        <th class="col-cuenta">Cuenta</th>
                        <th class="col-importe">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['pasivos'] as $cuenta)
                        <tr>
                            <td class="codigo">{{ $cuenta['codigo'] }}</td>
                            <td class="cuenta">{{ $cuenta['nombre'] }}</td>
                            <td class="importe">${{ number_format($cuenta['saldo'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="subtotal">
                    <tr>
                        <td colspan="2">TOTAL DE PASIVOS</td>
                        <td class="importe">${{ number_format($data['totalPasivo'], 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        @else
            <div class="no-data">No hay cuentas de pasivo registradas</div>
        @endif
    </div>

    {{-- PATRIMONIO --}}
    <div class="seccion-balance">
        <div class="section-title">Patrimonio</div>
        
        @if(count($data['patrimonio']) > 0)
            <table class="datos-tabla">
                <thead>
                    <tr>
                        <th class="col-codigo">Código</th>
                        <th class="col-cuenta">Cuenta</th>
                        <th class="col-importe">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['patrimonio'] as $cuenta)
                        <tr>
                            <td class="codigo">{{ $cuenta['codigo'] }}</td>
                            <td class="cuenta">{{ $cuenta['nombre'] }}</td>
                            <td class="importe">${{ number_format($cuenta['saldo'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="subtotal">
                    <tr>
                        <td colspan="2">TOTAL DE PATRIMONIO</td>
                        <td class="importe">${{ number_format($data['totalPatrimonio'], 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        @else
            <div class="no-data">No hay cuentas de patrimonio registradas</div>
        @endif
    </div>

    {{-- TOTAL GENERAL --}}
    <table class="datos-tabla">
        <tfoot class="subtotal" style="font-weight: bold;">
            <tr>
                <td colspan="2">SUMA DEL PASIVO Y PATRIMONIO</td>
                <td class="importe">${{ number_format($data['totalPasivoPatrimonio'], 2) }}</td>
            </tr>
        </tfoot>
    </table>
        <div class="seccion-balance">
            <div class="section-title">Total Activos: {{ number_format($data['totalActivo'], 2) }} = Total Pasivo + Patrimonio: {{ number_format($data['totalPasivoPatrimonio'], 2) }}</div>
        </div>
    {{-- Footer --}}
    <div class="footer">
        <p>FREMARCA S.A. DE C.V. | Balance General</p>
        <p>Este documento es de carácter confidencial y está destinado únicamente para uso interno de la empresa</p>
    </div>
</body>
</html>