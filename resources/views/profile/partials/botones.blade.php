<div class="bg-white dark:bg-gray-900 min-h-[calc(100vh-4rem)] flex flex-col justify-center items-center p-8 rounded-lg text-center">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Registro de Jornada</h1>

    <div class="flex flex-col md:flex-row justify-center items-center space-y-4 md:space-y-0 md:space-x-6 w-full px-4">
        <form id="entradaForm" action="{{ route('entrada') }}" method="POST" class="w-full md:w-auto">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <input type="hidden" id="entradaLat" name="latitude">
            <input type="hidden" id="entradaLon" name="longitude">
            <button type="button" onclick="obtenerUbicacion('entrada')" class="w-full md:w-auto bg-green-500 text-white text-lg font-semibold px-8 py-3 rounded-xl shadow-lg 
                   hover:bg-green-700 active:scale-90 transition-all duration-300">
                Registrar Entrada
            </button>
        </form>

        <form id="salidaForm" action="{{ route('salida') }}" method="POST" class="w-full md:w-auto">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <input type="hidden" id="salidaLat" name="latitude">
            <input type="hidden" id="salidaLon" name="longitude">
            <button type="button" onclick="obtenerUbicacion('salida')" class="w-full md:w-auto bg-red-500 text-white text-lg font-semibold px-8 py-3 rounded-xl shadow-lg 
                   hover:bg-red-700 active:scale-90 transition-all duration-300">
                Registrar Salida
            </button>
        </form>
    </div>
</div>

<script>
function obtenerUbicacion(tipo) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById(tipo + "Lat").value = position.coords.latitude;
                document.getElementById(tipo + "Lon").value = position.coords.longitude;
                document.getElementById(tipo + "Form").submit();
            },
            function(error) {
                alert("No se pudo obtener la ubicación. Asegúrate de que la geolocalización está activada.");
            }
        );
    } else {
        alert("La geolocalización no es soportada por este navegador.");
    }
}
</script>
