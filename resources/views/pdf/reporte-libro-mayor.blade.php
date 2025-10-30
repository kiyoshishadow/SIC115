<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libro Mayor - {{ $cuenta }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 13px;
            margin: 20px;
        }

        .marca {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
            color: #2a4365; /* Dark blue like in catálogo */
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }

        thead th {
            background-color: #2a4365; /* Dark blue header */
            color: #ffffff; /* White text */
            font-weight: bold;
            text-transform: uppercase;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2; /* Light grey even rows */
        }

        tbody tr:hover {
            background-color: #e2e8f0; /* Light blue on hover */
        }
    </style>
</head>
<body>
    <div class="marca">Fremarca S.A. DE C.V.</div>
    <h2>Libro Mayor - {{ $cuenta }}</h2>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>N° Partida</th>
                <th>Debe</th>
                <th>Haber</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($resultados as $r)
                <tr>
                    <td>{{ $r['fecha'] }}</td>
                    <td>{{ $r['numero_partida'] }}</td>
                    <td>{{ number_format($r['debe'], 2) }}</td>
                    <td>{{ number_format($r['haber'], 2) }}</td>
                    <td>{{ number_format($r['saldo'], 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay datos para mostrar</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
