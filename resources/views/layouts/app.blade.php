<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="ruta-usuarios" content="{{ route('admin.usuarios') }}">
        <meta name="ruta-historial" content="{{ url('/historial/') }}">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">



        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script>
            window.flashMessage = @json(session('success'));
            window.flashError = @json(session('error'));
            window.flashWarning = @json(session('warning'));
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot ?? '' }} <!-- Evita el error si $slot no está definido -->
                @yield('content') <!-- Para las vistas que extienden de este layout -->
            </main>
        </div>
    </body>
</html>
