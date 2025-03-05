<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-neutral">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen">
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
                <a href="{{ url('/dashboard') }}" class="font-semibold text-primary hover:text-secondary focus:outline focus:outline-2 focus:rounded-sm focus:outline-accent">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-secondary focus:outline focus:outline-2 focus:rounded-sm focus:outline-accent">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="ml-4 font-semibold text-primary hover:text-secondary focus:outline focus:outline-2 focus:rounded-sm focus:outline-accent">Registrarse</a>
            @endauth
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <h1 class="text-4xl font-bold text-primary">{{ config('app.name') }}</h1>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <div class="scale-100 p-6 bg-white rounded-lg shadow-2xl">
                        <h2 class="text-xl font-semibold text-primary mb-4">Gestión de Notificaciones</h2>
                        <p class="text-secondary">Sistema centralizado para enviar y gestionar notificaciones importantes a los usuarios sobre eventos, actualizaciones y recordatorios del sistema.</p>
                    </div>

                    <div class="scale-100 p-6 bg-white rounded-lg shadow-2xl">
                        <h2 class="text-xl font-semibold text-primary mb-4">Características Principales</h2>
                        <ul class="list-disc list-inside text-secondary">
                            <li>Notificaciones en tiempo real</li>
                            <li>Personalización de preferencias</li>
                            <li>Historial de notificaciones</li>
                            <li>Centro de control unificado</li>
                        </ul>
                    </div>

                    <div class="scale-100 p-6 bg-white rounded-lg shadow-2xl">
                        <h2 class="text-xl font-semibold text-primary mb-4">Tipos de Notificaciones</h2>
                        <ul class="list-disc list-inside text-secondary">
                            <li>Alertas del sistema</li>
                            <li>Actualizaciones importantes</li>
                            <li>Recordatorios personalizados</li>
                            <li>Mensajes de equipo</li>
                        </ul>
                    </div>

                    <div class="scale-100 p-6 bg-white rounded-lg shadow-2xl">
                        <h2 class="text-xl font-semibold text-primary mb-4">Beneficios</h2>
                        <ul class="list-disc list-inside text-secondary">
                            <li>Comunicación efectiva</li>
                            <li>Mayor productividad</li>
                            <li>Seguimiento en tiempo real</li>
                            <li>Interfaz intuitiva</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
