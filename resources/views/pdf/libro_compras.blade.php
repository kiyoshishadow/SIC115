<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libro de Compras - FREMARCA S.A. DE C.V.</title>
    <style>
        @page {
            margin: 3cm 2cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
        }

        /* Encabezado */
        .header {
            position: fixed;
            top: -2.2cm;
            left: 0;
            right: 0;
            text-align: center;
        }

        .header .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #2a4365; /* Azul oscuro corporativo */
            margin-bottom: 3px;
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

        /* Pie de página */
        .footer {
            position: fixed;
            bottom: -1.8cm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #777;
        }

        .footer .page-number:after {
            content: counter(page);
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #2a4365; /* Azul oscuro */
            color: #ffffff; /* Texto blanco */
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Gris claro */
        }

        tr:hover {
            background-color: #e2e8f0; /* Azul tenue al pasar */
        }

        h1 {
            text-align: center;
            color: #2a4365;
            font-size: 20px;
            margin-top: 70px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">FREMARCA S.A. DE C.V.</div>
        <div class="document-title">Libro de Compras</div>
        <div class="date">Fecha de emisión: {{ now()->format('d/m/Y') }}</div>
    </div>

    <div class="footer">
        Generado por SIC115 | Página <span class="page-number"></span>
    </div>

    <h1>Libro de Compras</h1>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>N° Documento</th>
                <th>Proveedor</th>
                <th>Neto</th>
                <th>Crédito Fiscal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $compra)
                <tr>
                    <td>{{ $compra->fecha_documento }}</td>
                    <td>{{ $compra->numero_documento }}</td>
                    <td>{{ $compra->tercero?->nombre }}</td>
                    <td>{{ number_format($compra->monto_neto, 2) }} US$</td>
                    <td>{{ number_format($compra->iva_credito_fiscal, 2) }} US$</td>
                    <td>{{ number_format($compra->total_documento, 2) }} US$</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
