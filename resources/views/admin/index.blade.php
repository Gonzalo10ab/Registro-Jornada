@extends('layouts.app')
@section('content')

    <div class="container mx-auto p-4 md:p-6">
        <h1 class="text-2xl md:text-3xl font-bold mb-4 md:mb-6 text-gray-900 dark:text-gray-100">
            Gestión de Usuarios
        </h1>

        @include('admin.partials.usuario-modal')

        <!-- Barra de búsqueda responsiva -->
        @include('admin.partials.usuario-search')


        <!-- Contenedor donde se actualizarán los resultados -->
        <div id="tabla-usuarios" class="overflow-x-auto">
            @include('admin.partials.usuarios-table', ['usuarios' => $usuarios])
        </div>

    </div>
@endsection
