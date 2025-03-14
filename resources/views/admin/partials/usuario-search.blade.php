        <!-- Barra de búsqueda responsiva -->
        <form id="search-form" class="mb-4 flex flex-col sm:flex-row gap-2">
            <input type="text" id="buscar" name="buscar" placeholder="Buscar usuario..." value="{{ request('buscar') }}"
                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm md:text-base">

            <select id="rol" name="rol"
                class="p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-800 dark:text-gray-100 text-sm md:text-base">
                <option value="">Todos</option>
                <option value="1" {{ request('rol') == '1' ? 'selected' : '' }}>Administrador</option>
                <option value="2" {{ request('rol') == '2' ? 'selected' : '' }}>Usuario</option>
            </select>
        </form>