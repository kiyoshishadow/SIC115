<x-filament-panels::page>

    {{-- Estilos CSS para Balance General formal --}}
    <style>
        /* Encabezado de la empresa */
        .encabezado-empresa {
            text-align: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            border-bottom: 3px solid rgb(31 41 55);
        }
        .dark .encabezado-empresa {
            border-bottom-color: rgb(156 163 175);
        }

        .encabezado-empresa h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: rgb(17 24 39);
            margin-bottom: 0.25rem;
        }
        .dark .encabezado-empresa h1 {
            color: rgb(243 244 246);
        }

        .encabezado-empresa .subtitulo {
            font-size: 1.25rem;
            font-weight: 600;
            color: rgb(55 65 81);
            margin-bottom: 0.5rem;
        }
        .dark .encabezado-empresa .subtitulo {
            color: rgb(209 213 219);
        }

        .encabezado-empresa .fecha {
            font-size: 0.875rem;
            color: rgb(107 114 128);
        }
        .dark .encabezado-empresa .fecha {
            color: rgb(156 163 175);
        }

        /* Tablas del balance */
        .tabla-balance {
            width: 100%;
            font-size: 0.875rem;
            line-height: 1.25rem;
            text-align: left;
            border-collapse: collapse;
            border: 1px solid rgb(209 213 219);
        }
        .dark .tabla-balance {
            border-color: rgb(75 85 99);
        }

        /* Encabezado (thead) */
        .tabla-balance thead {
            font-size: 0.75rem;
            line-height: 1rem;
            color: rgb(17 24 39);
            text-transform: uppercase;
            background-color: rgb(229 231 235);
            font-weight: 700;
        }
        .dark .tabla-balance thead {
            background-color: rgb(55 65 81);
            color: rgb(229 231 235);
        }
        
        .tabla-balance th {
            padding: 0.75rem 1rem;
            border: 1px solid rgb(209 213 219);
        }
        .dark .tabla-balance th {
            border-color: rgb(75 85 99);
        }

        /* Cuerpo (tbody) */
        .tabla-balance tbody tr {
            background-color: rgb(255 255 255);
        }
        .dark .tabla-balance tbody tr {
            background-color: rgb(31 41 55);
        }

        .tabla-balance tbody tr:nth-child(even) {
            background-color: rgb(249 250 251);
        }
        .dark .tabla-balance tbody tr:nth-child(even) {
            background-color: rgb(55 65 81);
        }

        .tabla-balance td {
            padding: 0.625rem 1rem;
            color: rgb(17 24 39);
            border: 1px solid rgb(229 231 235);
        }
        .dark .tabla-balance td {
            color: rgb(229 231 235);
            border-color: rgb(75 85 99);
        }

        /* Footer (tfoot) */
        .tabla-balance tfoot tr {
            font-weight: 700;
            background-color: rgb(243 244 246);
            color: rgb(17 24 39);
        }
        .dark .tabla-balance tfoot tr {
            background-color: rgb(75 85 99);
            color: rgb(229 231 235);
        }

        .tabla-balance tfoot td {
            padding: 0.875rem 1rem;
            border: 1px solid rgb(209 213 219);
        }
        .dark .tabla-balance tfoot td {
            border-color: rgb(55 65 81);
        }

        /* Total final más destacado */
        .tabla-balance .total-final {
            background-color: rgb(31 41 55);
            color: white;
            font-size: 0.9375rem;
        }
        .dark .tabla-balance .total-final {
            background-color: rgb(17 24 39);
        }

        /* Títulos de secciones */
        .titulo-seccion {
            padding: 0.75rem 1rem;
            margin-bottom: 0.75rem;
            margin-top: 1.5rem;
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            color: rgb(17 24 39);
            background-color: rgb(243 244 246);
            border-left: 4px solid rgb(31 41 55);
        }
        .dark .titulo-seccion {
            color: rgb(229 231 235);
            background-color: rgb(55 65 81);
            border-left-color: rgb(156 163 175);
        }

        .titulo-seccion:first-of-type {
            margin-top: 0;
        }

        /* Clases de utilidad */
        .tabla-balance .text-right {
            text-align: right;
        }
        .tabla-balance .text-center {
            text-align: center;
        }
        .tabla-balance .font-mono {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        }
        .tabla-balance .text-xs {
            font-size: 0.75rem;
        }
        .tabla-balance .text-sm {
            font-size: 0.875rem;
        }
        .tabla-balance .font-medium {
            font-weight: 500;
        }
        .tabla-balance .uppercase {
            text-transform: uppercase;
        }
        .tabla-balance .codigo {
            color: rgb(75 85 99);
            font-weight: 500;
        }
        .dark .tabla-balance .codigo {
            color: rgb(156 163 175);
        }

        .mensaje-vacio {
            text-align: center;
            padding: 2rem;
            color: rgb(107 114 128);
            font-style: italic;
            border: 1px solid rgb(209 213 219);
        }
        .dark .mensaje-vacio {
            color: rgb(156 163 175);
            border-color: rgb(75 85 99);
        }

        /* Espaciado entre columnas */
        .columna-balance {
            padding: 0 1rem;
        }
    </style>

    @php
        $balanceData = $this->getBalanceData();
        $fechaCorte = $this->fechaCorte ?? now()->format('Y-m-d');
    @endphp

    <x-filament::section>
        {{-- Encabezado de la Empresa --}}
        <div class="encabezado-empresa">
            <h1>FREMARCA S.A. DE C.V.</h1>
            <div class="subtitulo">Balance General</div>
            <div class="fecha">Al {{ \Carbon\Carbon::parse($fechaCorte)->format('d \d\e F \d\e Y') }}</div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
            {{-- ACTIVOS --}}
            <div class="columna-balance">
                <div class="titulo-seccion">Activos</div>

                @if(count($balanceData['activos']) > 0)
                    <table class="tabla-balance">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Código</th>
                                <th style="width: 50%;">Cuenta</th>
                                <th class="text-right" style="width: 30%;">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($balanceData['activos'] as $cuenta)
                                <tr>
                                    <td class="text-xs font-mono codigo">{{ $cuenta['codigo'] }}</td>
                                    <td class="text-sm">{{ $cuenta['nombre'] }}</td>
                                    <td class="text-sm text-right">${{ number_format($cuenta['saldo'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-sm uppercase">Total de Activos</td>
                                <td class="text-sm text-right">${{ number_format($balanceData['totalActivo'], 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <div class="mensaje-vacio">
                        No hay cuentas de activo
                    </div>
                @endif
            </div>

            {{-- PASIVOS Y PATRIMONIO --}}
            <div class="columna-balance">
                {{-- PASIVOS --}}
                <div class="titulo-seccion">Pasivos</div>

                @if(count($balanceData['pasivos']) > 0)
                    <table class="tabla-balance">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Código</th>
                                <th style="width: 50%;">Cuenta</th>
                                <th class="text-right" style="width: 30%;">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($balanceData['pasivos'] as $cuenta)
                                <tr>
                                    <td class="text-xs font-mono codigo">{{ $cuenta['codigo'] }}</td>
                                    <td class="text-sm">{{ $cuenta['nombre'] }}</td>
                                    <td class="text-sm text-right">${{ number_format($cuenta['saldo'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-sm uppercase">Total de Pasivos</td>
                                <td class="text-sm text-right">${{ number_format($balanceData['totalPasivo'], 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <div class="mensaje-vacio">
                        No hay cuentas de pasivo
                    </div>
                @endif

                {{-- PATRIMONIO --}}
                <div class="titulo-seccion">Patrimonio</div>

                @if(count($balanceData['patrimonio']) > 0)
                    <table class="tabla-balance">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Código</th>
                                <th style="width: 50%;">Cuenta</th>
                                <th class="text-right" style="width: 30%;">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($balanceData['patrimonio'] as $cuenta)
                                <tr>
                                    <td class="text-xs font-mono codigo">{{ $cuenta['codigo'] }}</td>
                                    <td class="text-sm">{{ $cuenta['nombre'] }}</td>
                                    <td class="text-sm text-right">${{ number_format($cuenta['saldo'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-sm uppercase">Total de Patrimonio</td>
                                <td class="text-sm text-right">${{ number_format($balanceData['totalPatrimonio'], 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <div class="mensaje-vacio">
                        No hay cuentas de patrimonio
                    </div>
                @endif

                {{-- TOTAL GENERAL --}}
                <table class="tabla-balance" style="margin-top: 1rem;">
                    <tfoot>
                        <tr class="total-final">
                            <td colspan="2" class="uppercase" style="width: 70%;">Suma del Pasivo y Patrimonio</td>
                            <td class="text-right" style="width: 30%;">${{ number_format($balanceData['totalPasivoPatrimonio'], 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </x-filament::section>

</x-filament-panels::page>