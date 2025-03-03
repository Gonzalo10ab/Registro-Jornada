{{-- Botón para abrir el modal de creación de usuario --}}
<button id="open-modal" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mb-4">
    Crear Usuario
</button>
<div id="user-modal" class="hidden fixed inset-0 flex justify-center items-center bg-gray-900 bg-opacity-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Nuevo Usuario</h2>
        <form id="create-user-form" method="POST" action="{{ route('admin.usuarios.store') }}">
            @csrf
            <div class="mb-2">
                <label for="nombre" class="block font-semibold text-gray-700 dark:text-gray-300">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-100">
            </div>
            <div class="mb-2">
                <label for="apellidos" class="block font-semibold text-gray-700 dark:text-gray-300">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-100">
            </div>
            <div class="mb-2">
                <label for="email" class="block font-semibold text-gray-700 dark:text-gray-300">Gmail:</label>
                <input type="email" id="email" name="email" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-100">
            </div>
            <div class="mb-2">
                <label for="password" class="block font-semibold text-gray-700 dark:text-gray-300">Contraseña:</label>
                <input type="password" id="password" name="password" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-100">
            </div>
            <div class="mb-2">
                <label for="rol_id" class="block font-semibold text-gray-700 dark:text-gray-300">Rol:</label>
                <select id="rol_id" name="rol_id" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-100">
                    <option value="2" selected>Usuario</option>
                    <option value="1">Administrador</option>
                </select>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="close-modal" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
                    Cancelar
                </button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script para abrir y cerrar el modal -->
<script>
document.getElementById('open-modal').addEventListener('click', function() {
    document.getElementById('user-modal').classList.remove('hidden');
});

document.getElementById('close-modal').addEventListener('click', function() {
    document.getElementById('user-modal').classList.add('hidden');
});
</script>