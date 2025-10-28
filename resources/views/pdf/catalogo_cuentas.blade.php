<!DOCTYPE html>
<html>
<head>
    <title>Catálogo de Cuentas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Catálogo de Cuentas</h2>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Naturaleza</th>
                <th>Saldo Actual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuentas as $cuenta)
                <tr>
                    <td>{{ $cuenta->codigo }}</td>
                    <td>{{ $cuenta->nombre }}</td>
                    <td>{{ $cuenta->tipo }}</td>
                    <td>{{ $cuenta->naturaleza }}</td>
                    <td>{{ number_format($cuenta->saldo_actual, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
