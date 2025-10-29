<!DOCTYPE html>
<html>
<head>
    <title>Catálogo de Cuentas</title>
    <style>
        @page {
            margin: 3cm 2cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 11px;
        }
        .header {
            position: fixed;
            top: -2.5cm;
            left: 0;
            right: 0;
            height: 2cm;
            text-align: center;
        }
        .header .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #2a4365; /* A nice dark blue */
            margin-bottom: 2px;
        }
        .header .document-title {
            font-size: 18px;
            color: #333;
            margin-bottom: 2px;
        }
        .header .date {
            font-size: 12px;
            color: #777;
        }
        .footer {
            position: fixed;
            bottom: -2cm;
            left: 0;
            right: 0;
            height: 1.5cm;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
        .footer .page-number:after {
            content: counter(page);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #2a4365; /* Dark blue background */
            color: #ffffff; /* White text */
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Lighter grey for even rows */
        }
        tr:hover {
            background-color: #e2e8f0; /* A light blue on hover (for web) */
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $empresa }}</div>
        <div class="document-title">Catálogo de Cuentas</div>
        <div class="date">Fecha de emisión: {{ $fecha }}</div>
    </div>

    <div class="footer">
        Generado por SIC115 | Página <span class="page-number"></span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Naturaleza</th>
                <th class="text-right">Saldo Actual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuentas as $cuenta)
                <tr>
                    <td>{{ $cuenta->codigo }}</td>
                    <td>{{ $cuenta->nombre }}</td>
                    <td class="text-center">{{ $cuenta->tipo }}</td>
                    <td class="text-center">{{ $cuenta->naturaleza }}</td>
                    <td class="text-right">${{ number_format($cuenta->saldo_actual, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
