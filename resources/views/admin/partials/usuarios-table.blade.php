<form method="POST" action="{{ route('admin.usuarios.pdf-masivo') }}">
    @csrf
    <table class="w-full bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-800 text-white dark:bg-gray-700">
            <tr>
                <th class="p-3"><input type="checkbox" id="select-all" class="cursor-pointer"></th>
                <th class="p-3">ID</th>
                <th class="p-3">Nombre</th>
                <th class="p-3">Email</th>
                <th class="p-3">Rol</th>
                <th class="p-3">Acciones</th>
            </tr>
        </thead>
        <tbody class="dark:text-gray-300">
            @foreach ($usuarios as $usuario)
                <tr class="fila-usuario border-b border-gray-300 dark:border-gray-700 even:bg-gray-100 dark:even:bg-gray-900 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700"
                    data-user-id="{{ $usuario->id }}">
                    <td class="p-3 text-center">
                        <input type="checkbox" name="usuarios[]" value="{{ $usuario->id }}"
                            class="cursor-pointer dark:bg-gray-700 dark:border-gray-600"
                            onclick="event.stopPropagation();">
                    </td>
                    <td class="p-3 text-center">{{ $usuario->id }}</td>
                    <td class="p-3 text-center">{{ $usuario->name . ' ' . $usuario->surname }}</td>
                    <td class="p-3 text-center">{{ $usuario->email }}</td>
                    <td class="p-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs text-white {{ $usuario->rol_id == 1 ? 'bg-green-500' : 'bg-blue-500' }}">
                            {{ $usuario->rol_id == 1 ? 'Administrador' : 'Usuario' }}
                        </span>
                    </td>
                    <td class="p-3 flex gap-2 sm:gap-4 sm:justify-center">
                        <a href="{{ route('admin.usuarios.editar', $usuario->id) }}"
                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Editar
                        </a>
    
                        <button type="button"
                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 eliminar-btn"
                            data-user-id="{{ $usuario->id }}">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Botón de envío -->
    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mt-4">
        Descargar Informe PDF
    </button>
</form>

<!-- Paginación -->
<div class="mt-4 dark:text-gray-300">
    {{ $usuarios->appends(request()->query())->links() }}
</div>
