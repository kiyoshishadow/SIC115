<h1>Listado de Clientes/Proveedores</h1>
<style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        th { background: #eee; }
    </style>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>NRC</th>
            <th>NIT</th>
            <th>Giro</th>
            <th>Cliente</th>
            <th>Proveedor</th>
            <th>Gran Contribuyente</th>
        </tr>
    </thead>
    <tbody>
        @foreach($terceros as $tercero)
        <tr>
            <td>{{ $tercero->nombre }}</td>
            <td>{{ $tercero->nrc }}</td>
            <td>{{ $tercero->nit }}</td>
            <td>{{ $tercero->giro }}</td>
            <td>{{ $tercero->es_cliente ? 'Sí' : 'No' }}</td>
            <td>{{ $tercero->es_proveedor ? 'Sí' : 'No' }}</td>
            <td>{{ $tercero->es_gran_contribuyente ? 'Sí' : 'No' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
