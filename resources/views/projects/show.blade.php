@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 mt-8 flex flex-col items-center">

        <div class="max-w-4xl w-full bg-white dark:bg-gray-900 shadow-2xl rounded-lg overflow-hidden transition-all">
            <!-- Encabezado con fondo degradado -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-700 dark:to-indigo-800 p-6 text-white">
                <h1 class="text-3xl font-bold">{{ $project->name }}</h1>
                <p class="mt-2 text-sm">Creado por <span class="font-semibold">{{ $project->creator->name }}
                        {{ $project->creator->surname }}</span></p>
            </div>

            <!-- Contenido principal -->
            <div class="p-8">
                <!-- Descripción destacada -->
                <div class="mb-6 bg-gray-200 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Descripción</h2>
                    <p class="mt-3 text-gray-700 dark:text-gray-300 leading-relaxed">
                        {{ $project->description ?? 'Este proyecto no tiene descripción.' }}
                    </p>
                </div>

                <!-- Detalles clave del proyecto -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div
                        class="p-4 border-l-4 border-indigo-500 bg-indigo-50 dark:border-indigo-400 dark:bg-indigo-900 rounded-lg shadow-sm">
                        <p class="text-lg font-semibold text-indigo-700 dark:text-indigo-300">Fecha de Creación</p>
                        <p class="text-gray-700 dark:text-gray-300">{{ $project->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div
                        class="p-4 border-l-4 border-pink-500 bg-pink-50 dark:border-pink-400 dark:bg-pink-900 rounded-lg shadow-sm">
                        <p class="text-lg font-semibold text-pink-700 dark:text-pink-300">Fecha Límite</p>
                        <p class="text-gray-700 dark:text-gray-300">{{ $project->due_date ?? 'Sin definir' }}</p>
                    </div>
                </div>

                <!-- Lista de usuarios asignados con etiquetas vibrantes -->
                <div class="mt-6">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Usuarios Asignados</h2>
                    <div class="mt-4 flex flex-wrap gap-3">
                        @foreach ($project->users as $user)
                            <span
                                class="bg-gradient-to-r from-blue-400 to-blue-600 dark:from-blue-500 dark:to-blue-700 text-white px-4 py-2 rounded-full shadow-md text-sm font-medium">
                                {{ $user->name }} {{ $user->surname }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Botones de Editar y Eliminar (Solo visibles para admins) -->
                @if(auth()->user()->rol_id == 1)
                    <div class="mt-8 flex flex-wrap justify-center gap-4">
                        <!-- Botón Editar -->
                        <a href="{{ route('admin.projects.edit', $project->id) }}"
                            class="flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all">
                            <span>Editar</span>
                        </a>

                        <!-- Botón Eliminar -->
                        <button type="button" onclick="confirmarEliminacion({{ $project->id }})"
                            class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all">
                            <span>Eliminar</span>
                        </button>

                        <!-- Formulario de Eliminación Oculto -->
                        <form id="delete-form-{{ $project->id }}"
                            action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endif

                <!-- Botón de volver -->
                <div class="mt-8 text-center">
                    <a href="{{ route('projects.index') }}"
                        class="inline-flex items-center gap-2 bg-gray-700 dark:bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-700 transition-all shadow-lg">
                        <span>Volver a mis proyectos</span>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        function confirmarEliminacion(projectId) {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + projectId).submit();
                }
            });
        }
    </script>
@endsection
