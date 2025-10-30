<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libro Mayor</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1, .header h2, .header h3 {
            margin: 0;
        }
        .header h1 {
            font-size: 18px;
            font-weight: bold;
        }
        .header h2 {
            font-size: 14px;
        }
        .header h3 {
            font-size: 12px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 8px;
        }
        .page-number:before {
            content: "Página " counter(page);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Mi Empresa S.A. de C.V.</h1>
        <h2>Libro Mayor</h2>
        <h3>Cuenta: {{ $nombreCuentaSeleccionada }}</h3>
        <h4>Del {{ $fechaInicio }} al {{ $fechaFin }}</h4>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Partida N°</th>
                <th class="text-right">Debe</th>
                <th class="text-right">Haber</th>
                <th class="text-right">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resultados as $resultado)
                <tr>
                    <td>{{ $resultado['fecha'] }}</td>
                    <td>{{ $resultado['numero_partida'] }}</td>
                    <td class="text-right">{{ number_format($resultado['debe'], 2) }}</td>
                    <td class="text-right">{{ number_format($resultado['haber'], 2) }}</td>
                    <td class="text-right">{{ number_format($resultado['saldo'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <span class="page-number"></span>
    </div>
</body>
</html>
