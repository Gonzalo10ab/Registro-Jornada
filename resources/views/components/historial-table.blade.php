<div class="container mx-auto p-4 lg:p-6">
    <h1 class="text-xl lg:text-3xl font-bold mb-4 lg:mb-6 text-gray-900 dark:text-gray-100">
        {{ $titulo ?? 'Historial de Registros' }}
    </h1>

    <!-- Contenedor flex para alinear usuario y botón en la misma fila -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mt-4">
        <h2 class="text-lg lg:text-2xl font-semibold text-gray-800 dark:text-gray-300">
            Usuario: {{ $usuario->name }} {{ $usuario->surname ?? '' }} ({{ $usuario->email }})
        </h2>

        <a href="{{ route('historial.pdf', ['id' => $usuario->id ?? auth()->id()]) }}"
            class="bg-green-500 text-white px-3 lg:px-4 py-1 lg:py-2 rounded flex items-center gap-2 hover:bg-green-600 mt-2 lg:mt-0">
             Descargar PDF
         </a>
    </div>

    <div class="overflow-x-auto mt-4">
        <table class="w-full bg-white dark:bg-gray-900 shadow-md rounded-lg overflow-hidden mt-4 text-xs lg:text-base">
            <thead class="bg-gray-800 text-white dark:bg-gray-700">
                <tr>
                    <th class="p-2 lg:p-3 text-center">Fecha Entrada</th>
                    <th class="p-2 lg:p-3 text-center">Hora Entrada</th>
                    <th class="p-2 lg:p-3 text-center">Fecha Salida</th>
                    <th class="p-2 lg:p-3 text-center">Hora Salida</th>
                    <th class="p-2 lg:p-3 text-center">Horas Trabajadas</th>
                </tr>
            </thead>
            <tbody class="dark:text-gray-300">
                @foreach ($registros as $registro)
                    <tr class="border-b dark:border-gray-700">
                        <td class="p-1 lg:p-3 text-center">{{ $registro->entry_time ? \Carbon\Carbon::parse($registro->entry_time)->format('d/m/Y') : '---' }}</td>
                        <td class="p-1 lg:p-3 text-center">{{ $registro->entry_time ? \Carbon\Carbon::parse($registro->entry_time)->format('H:i') : '---' }}</td>
                        <td class="p-1 lg:p-3 text-center">{{ $registro->departure_time ? \Carbon\Carbon::parse($registro->departure_time)->format('d/m/Y') : '---' }}</td>
                        <td class="p-1 lg:p-3 text-center">{{ $registro->departure_time ? \Carbon\Carbon::parse($registro->departure_time)->format('H:i') : '---' }}</td>
                        <td class="p-1 lg:p-3 text-center">{{ $registro->horas_trabajadas ?? 'Error en cálculo' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Paginación -->
    <div class="mt-4">
        {{ $registros->links() }}
    </div>

    <h3 class="mt-4 font-bold text-sm lg:text-lg text-gray-700 dark:text-gray-300">
        Total de horas trabajadas: {{ $usuario->total_horas }}h {{ $usuario->total_minutos }}m
    </h3>
</div>



