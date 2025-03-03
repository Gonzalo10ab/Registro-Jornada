@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-gray-100">Editar Usuario</h1>

        <form id="edit-user-form" method="POST" action="{{ route('admin.usuarios.actualizar', $usuario->id) }}"
            class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf

            <!-- Nombre -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="name">Nombre:</label>
                <input type="text" name="name" value="{{ old('name', $usuario->name) }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- Apellido -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="surname">Apellido:</label>
                <input type="text" name="surname" value="{{ old('surname', $usuario->surname) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- Correo -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="email">Correo Electrónico:</label>
                <input type="email" name="email" value="{{ old('email', $usuario->email) }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- Nueva Contraseña -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="password">Nueva Contraseña (Opcional):</label>
                <input type="password" name="password"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            @if ($errors->has('password'))
                <div class="text-red-500 text-sm mt-1">
                    {{ $errors->first('password') }}
                </div>
            @endif

            <!-- Rol -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="rol_id">Rol:</label>
                <select name="rol_id" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id }}" {{ $usuario->rol_id == $rol->id ? 'selected' : '' }}>
                            {{ $rol->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
@endsection
