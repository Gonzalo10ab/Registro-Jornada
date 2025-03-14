@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 mt-8">
        <div class="max-w-3xl mx-auto bg-white dark:bg-gray-900 shadow-lg rounded-lg p-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-6 text-center">Crear Nuevo Proyecto</h1>

            <form action="{{ route('admin.projects.store') }}" method="POST">
                @csrf

                <!-- Nombre -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300 font-semibold">Nombre del
                        Proyecto</label>
                    <input type="text" name="name" id="name" required
                        class="w-full mt-2 p-3 border rounded-lg dark:bg-gray-800 dark:text-white">
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <label for="description"
                        class="block text-gray-700 dark:text-gray-300 font-semibold">Descripción</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full mt-2 p-3 border rounded-lg dark:bg-gray-800 dark:text-white"></textarea>
                </div>

                <!-- Fecha Límite -->
                <div class="mb-4">
                    <label for="due_date" class="block text-gray-700 dark:text-gray-300 font-semibold">Fecha Límite</label>
                    <input type="date" name="due_date" id="due_date"
                        class="w-full mt-2 p-3 border rounded-lg dark:bg-gray-800 dark:text-white">
                </div>
                <!-- Asignar Usuarios -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Asignar Usuarios</h2>

                    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow">

                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Selecciona los usuarios que tendrán acceso
                            a este proyecto:</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($users as $user)
                                <label
                                    class="flex items-center space-x-3 bg-white dark:bg-gray-900 p-3 rounded-lg shadow-sm cursor-pointer">
                                    <input type="checkbox" name="users[]" value="{{ $user->id }}"
                                        class="w-5 h-5 text-indigo-600 border-gray-300 rounded-md focus:ring focus:ring-indigo-400">
                                    <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $user->name }}
                                        {{ $user->surname ?? '' }}</span>
                                </label>
                            @endforeach
                        </div>
                        <!-- Paginación -->
                        <div class="mt-4 dark:text-gray-300">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>



                <!-- Botón de Enviar -->
                <div class="text-center mt-6">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition shadow-md">
                        Crear Proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
