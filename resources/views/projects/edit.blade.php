@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 mt-8 flex flex-col items-center">

    <div class="max-w-4xl w-full bg-white dark:bg-gray-900 shadow-2xl rounded-lg overflow-hidden transition-all">
        <!-- Encabezado con fondo degradado -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 dark:from-yellow-700 dark:to-yellow-800 p-6 text-white">
            <h1 class="text-3xl font-bold">Editar Proyecto</h1>
        </div>

        <!-- Contenido principal -->
        <div class="p-8">
            <form action="{{ route('admin.projects.update', $project->id) }}" method="POST">
                @csrf
                @method('POST')

                <!-- Nombre -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300 font-semibold">Nombre del Proyecto</label>
                    <input type="text" name="name" id="name" value="{{ $project->name }}" required 
                        class="w-full mt-2 p-3 border rounded-lg dark:bg-gray-800 dark:text-white">
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300 font-semibold">Descripción</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full mt-2 p-3 border rounded-lg dark:bg-gray-800 dark:text-white">{{ $project->description }}</textarea>
                </div>

                <!-- Fecha Límite -->
                <div class="mb-4">
                    <label for="due_date" class="block text-gray-700 dark:text-gray-300 font-semibold">Fecha Límite</label>
                    <input type="date" name="due_date" id="due_date" value="{{ $project->due_date }}"
                        class="w-full mt-2 p-3 border rounded-lg dark:bg-gray-800 dark:text-white">
                </div>

                <!-- Usuarios Asignados -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Usuarios Asignados</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($users as $user)
                            <label class="flex items-center space-x-3 bg-white dark:bg-gray-900 p-3 rounded-lg shadow-sm cursor-pointer">
                                <input type="checkbox" name="users[]" value="{{ $user->id }}" 
                                    class="w-5 h-5 text-indigo-600 border-gray-300 rounded-md focus:ring focus:ring-indigo-400"
                                    {{ $project->users->contains($user->id) ? 'checked' : '' }}>
                                <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $user->name }} {{ $user->surname ?? '' }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <!-- Botón Guardar Cambios -->
                    <button type="submit" 
                        class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all">
                        <span>Guardar Cambios</span>
                    </button>

                    <!-- Botón Cancelar -->
                    <a href="{{ route('projects.show', $project->id) }}" 
                        class="flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all">
                        <span>Cancelar</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
