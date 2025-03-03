@extends('layouts.app')
@section('content')

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-gray-100">Gestión de Usuarios</h1>
        
        @include('admin.partials.usuario-modal')

        <!-- Barra de búsqueda -->
        <form id="search-form" class="mb-4 flex gap-2">
            <input type="text" id="buscar" name="buscar" placeholder="Buscar usuario..." value="{{ request('buscar') }}"
                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <select id="rol" name="rol"
                class="p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-800 dark:text-gray-100">
                <option value="">Todos</option>
                <option value="1" {{ request('rol') == '1' ? 'selected' : '' }}>Administrador</option>
                <option value="2" {{ request('rol') == '2' ? 'selected' : '' }}>Usuario</option>
            </select>
        </form>

        <!-- Contenedor donde se actualizarán los resultados -->
        <div id="tabla-usuarios">
            @include('admin.partials.usuarios-table', ['usuarios' => $usuarios])
        </div>


    </div>
@endsection
