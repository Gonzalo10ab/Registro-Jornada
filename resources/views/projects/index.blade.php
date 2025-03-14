@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 text-center mb-6">Mis Proyectos</h1>
    
    @if(auth()->check() && auth()->user()->role->id === 1) {{-- Suponiendo que 1 es el ID de Administrador --}}
    <div class="text-right mb-4">
        <a href="{{ route('admin.projects.create') }}" 
            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition shadow-md">
            Crear Proyecto
        </a>
    </div>

@endif

    @if($projects->isEmpty())
        <div class="bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-200 p-4 text-center rounded-lg shadow-md">
            No tienes proyectos asignados.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($projects as $project)
                <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg overflow-hidden transition-all">
                    <!-- Encabezado con degradado -->
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-700 dark:to-indigo-800 p-4 text-white">
                        <h5 class="text-xl font-bold">{{ $project->name }}</h5>
                        <p class="text-sm opacity-90">Creado por: 
                            <span class="font-semibold">{{ $project->creator->name }} {{ $project->creator->last_name ?? '' }}</span>
                        </p>
                    </div>

                    <!-- Contenido -->
                    <div class="p-4">
                        <p class="text-gray-700 dark:text-gray-300 text-sm">
                            {{ Str::limit($project->description, 100) }}
                        </p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">
                            <strong>Fecha límite:</strong> {{ $project->due_date ?? 'Sin definir' }}
                        </p>

                        <!-- Botón para ver detalles -->
                        <div class="mt-4 text-right">
                            <a href="{{ route('projects.show', $project) }}" class="inline-block bg-indigo-600 dark:bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition shadow-md">
                                Ver detalles →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
