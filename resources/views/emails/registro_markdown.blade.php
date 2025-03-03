@component('mail::message')
# Hola {{ $user->name }},

Tu fichaje de **{{ ucfirst($tipo) }}** ha sido registrado correctamente.

- **Fecha y hora:** {{ $fecha }}

@if($tipo === 'entrada')
@component('mail::button', ['url' => url('http://localhost:8080/contadorjornada/public/historial')])
Ver mi historial
@endcomponent
@endif

Si no has realizado este fichaje, contacta con el administrador.

Gracias,<br>
**{{ config('app.name') }}**
@endcomponent
