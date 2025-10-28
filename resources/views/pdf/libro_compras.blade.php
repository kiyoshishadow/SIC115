<h1>Libro de Compras</h1>
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
            <td>{{ number_format($compra->monto_neto, 2) }}</td>
            <td>{{ number_format($compra->iva_credito_fiscal, 2) }}</td>
            <td>{{ number_format($compra->total_documento, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
