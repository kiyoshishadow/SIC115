<h1>Libro de Ventas</h1>
<style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        th { background: #eee; }
    </style>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>N° Documento</th>
            <th>Cliente</th>
            <th>Neto</th>
            <th>Débito Fiscal</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ventas as $venta)
        <tr>
            <td>{{ $venta->fecha_documento }}</td>
            <td>{{ $venta->numero_documento }}</td>
            <td>{{ $venta->tercero->nombre }}</td>
            <td>{{ $venta->monto_neto }}</td>
            <td>{{ $venta->iva_debito_fiscal }}</td>
            <td>{{ $venta->total_documento }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
