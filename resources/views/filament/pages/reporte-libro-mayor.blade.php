<x-filament-panels::page>

    {{-- Estilos CSS manuales como fallback para la tabla del reporte --}}
    <style>
        .tabla-reporte-manual {
            width: 100%;
            font-size: 0.875rem; /* text-sm */
            line-height: 1.25rem;
            text-align: left;
            color: rgb(107 114 128); /* text-gray-500 */
            border-collapse: collapse; /* Para que los bordes se vean bien */
        }
        /* Modo Oscuro: Color de texto base */
        .dark .tabla-reporte-manual {
            color: rgb(156 163 175); /* dark:text-gray-400 */
        }

        /* --- Encabezado (thead) --- */
        .tabla-reporte-manual thead {
            font-size: 0.75rem; /* text-xs */
            line-height: 1rem;
            color: rgb(55 65 81); /* text-gray-700 */
            text-transform: uppercase;
            background-color: rgb(249 250 251); /* bg-gray-50 */
        }
        .dark .tabla-reporte-manual thead {
            background-color: rgb(55 65 81); /* dark:bg-gray-700 */
            color: rgb(156 163 175); /* dark:text-gray-400 */
        }
        
        .tabla-reporte-manual th {
            padding: 0.75rem 1.5rem; /* px-6 py-3 */
            border-bottom-width: 1px;
            border-bottom-color: rgb(229 231 235); /* border-gray-200 */
        }
        .dark .tabla-reporte-manual th {
             border-bottom-color: rgb(55 65 81); /* dark:border-gray-700 */
        }

        /* --- Cuerpo (tbody) --- */
        .tabla-reporte-manual tbody tr {
            background-color: rgb(255 255 255); /* bg-white */
            border-bottom-width: 1px;
            border-bottom-color: rgb(229 231 235); /* border-gray-200 */
        }
        .dark .tabla-reporte-manual tbody tr {
            background-color: rgb(31 41 55); /* dark:bg-gray-800 */
            border-bottom-color: rgb(55 65 81); /* dark:border-gray-700 */
        }

        .tabla-reporte-manual tbody tr:hover {
            background-color: rgb(249 250 251); /* hover:bg-gray-50 */
        }
        .dark .tabla-reporte-manual tbody tr:hover {
            background-color: rgb(75 85 99); /* dark:hover:bg-gray-600 */
        }

        .tabla-reporte-manual td {
            padding: 1rem 1.5rem; /* px-6 py-4 */
        }

        /* --- Clases de utilidad --- */
        .tabla-reporte-manual .text-right {
            text-align: right;
        }
        .tabla-reporte-manual .whitespace-nowrap {
            white-space: nowrap;
        }
        .tabla-reporte-manual .font-bold {
            font-weight: 700;
        }
        .tabla-reporte-manual .uppercase {
            text-transform: uppercase;
        }
        .tabla-reporte-manual .text-center {
            text-align: center;
        }
        .tabla-reporte-manual .text-gray-500 {
             color: rgb(107 114 128);
        }
        .dark .tabla-reporte-manual .text-gray-500 {
            color: rgb(156 163 175);
        }

    </style>


    {{-- 1. Renderizar el formulario --}}
    <form wire:submit="cargarDatos">
        {{ $this->form }}
        <div class="mt-4">
            <x-filament::button type="submit">
                Generar
            </x-filament::button>
        </div>
    </form>

    {{-- 2. Mostrar los resultados (solo si se ha generado el reporte) --}}
    @if ($nombreCuentaSeleccionada)
        {{-- ... resto del archivo sin cambios ... --}}
        <div class="mt-8 space-y-4">
            
            {{-- Encabezado del Reporte (Componente Section de Filament) --}}
            <x-filament::section>
                <x-slot name="heading">
                    Libro Mayor para: {{ $nombreCuentaSeleccionada }}
                </x-slot>
                <x-slot name="description">
                    Período del {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
                </x-slot>
                {{-- No se necesita contenido aquí, solo usamos el header de la sección --}}
            </x-filament::section>


            {{-- Tabla de Resultados (Componente Section de Filament en modo 'compact') --}}
            {{-- :compact="true" elimina el padding interno para que la tabla se ajuste perfectamente --}}
            <x-filament::section :compact="true">
                <div class="relative overflow-x-auto">
                    <!-- AQUÍ: Se reemplazan las clases de Tailwind por 'tabla-reporte-manual'
                      y las clases de utilidad (ej. text-right) ahora están definidas en el <style> de arriba.-->
                    <table class="tabla-reporte-manual">
                        <thead>
                            <tr>
                                <th scope="col">
                                    Fecha
                                </th>
                                <th scope="col">
                                    Número Partida
                                </th>
                                <th scope="col" class="text-right whitespace-nowrap">
                                    Debe
                                </th>
                                <th scope="col" class="text-right whitespace-nowrap">
                                    Haber
                                </th>
                                <th scope="col" class="text-right whitespace-nowrap">
                                    Saldo
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- Fila del Saldo Anterior --}}
                            <tr class="font-bold">
                                <td>
                                    {{-- Aquí usamos $resultados[0] que contiene el saldo anterior --}}
                                    @if(isset($resultados[0]))
                                        {{ \Carbon\Carbon::parse($resultados[0]['fecha'])->format('d/m/Y') }}
                                    @endif
                                </td>
                                <td class="uppercase">
                                    @if(isset($resultados[0]))
                                        {{ $resultados[0]['numero_partida'] }}
                                    @else
                                        Saldo anterior al período
                                    @endif
                                </td>
                                <td class_l="text-right">
                                    {{-- Vacío --}}
                                </td>
                                <td class="text-right">
                                    {{-- Vacío --}}
                                </td>
                                <td class="text-right whitespace-nowrap">
                                    @if(isset($resultados[0]))
                                        {{ number_format($resultados[0]['saldo'], 2) }}
                                    @else
                                        0.00
                                    @endif
                                </td>
                            </tr>

                            {{-- Fila por cada movimiento --}}
                            {{-- Usamos array_slice para omitir el primer elemento (saldo anterior) --}}
                            @forelse (array_slice($resultados, 1) as $detalle)
                                <tr>
                                    <td>
                                        {{ \Carbon\Carbon::parse($detalle['fecha'])->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{ $detalle['numero_partida'] }}
                                    </td>
                                    <td class="text-right whitespace-nowrap">
                                        {{ number_format($detalle['debe'], 2) }}
                                    </td>
                                    <td class="text-right whitespace-nowrap">
                                        {{ number_format($detalle['haber'], 2) }}
                                    </td>
                                    <td class="text-right whitespace-nowrap">
                                        {{ number_format($detalle['saldo'], 2) }}
                                    </td>
                                </tr>
                            @empty
                                {{-- Mensaje si no hay movimientos en el período (solo se muestra si $resultados > 1) --}}
                                @if(count($resultados) <= 1)
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500">
                                        No hay movimientos para esta cuenta en el período seleccionado.
                                    </td>
                                </tr>
                                @endif
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </x-filament::section>

        </div>
    @endif

</x-filament-panels::page>