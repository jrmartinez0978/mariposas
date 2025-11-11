@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <div class="p-6 bg-gradient-to-r from-pink-50 to-purple-50">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">
                        ¡Bienvenido, {{ $miembro->nombres }}! 👋
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Aquí puedes ver el progreso de tu red y gestionar tus referidos.
                    </p>
                </div>
                <div class="hidden sm:block">
                    <div class="flex items-center space-x-2">
                        <svg class="h-16 w-16 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C11.5 2 11 2.19 10.59 2.59L2.59 10.59C1.8 11.37 1.8 12.63 2.59 13.41L10.59 21.41C11.37 22.2 12.63 22.2 13.41 21.41L21.41 13.41C22.2 12.63 22.2 11.37 21.41 10.59L13.41 2.59C13 2.19 12.5 2 12 2M12 4L20 12L12 20L4 12L12 4M12 7C9.79 7 8 8.79 8 11S9.79 15 12 15 16 13.21 16 11 14.21 7 12 7Z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nivel Actual -->
    <div class="bg-gradient-to-br from-purple-600 via-pink-600 to-blue-600 overflow-hidden shadow-lg rounded-lg">
        <div class="p-6">
            <div class="flex items-center justify-between text-white">
                <div>
                    <p class="text-sm font-medium text-purple-100">Tu Nivel Actual</p>
                    <h3 class="mt-2 text-4xl font-bold">{{ $miembro->rol }}</h3>
                </div>
                <div class="flex-shrink-0">
                    @if($miembro->rol === 'Mariposa Azul')
                        <span class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-500/30 text-4xl">🦋</span>
                    @elseif($miembro->rol === 'Mariposa Padre/Madre')
                        <span class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-purple-500/30 text-4xl">👑</span>
                    @else
                        <span class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-yellow-500/30 text-4xl">⭐</span>
                    @endif
                </div>
            </div>

            @if($progreso['nivel_actual'] !== 'Mariposa Ejecutiva')
                <div class="mt-6">
                    <div class="flex items-center justify-between text-sm text-purple-100 mb-2">
                        <span>Progreso hacia {{ $progreso['proximo_nivel'] }}</span>
                        <span class="font-semibold">{{ number_format($progreso['progreso'], 1) }}%</span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-3 overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-400 to-green-400 h-3 rounded-full transition-all duration-500" style="width: {{ $progreso['progreso'] }}%"></div>
                    </div>
                    <p class="mt-3 text-sm text-purple-100">
                        @if($miembro->rol === 'Mariposa Azul')
                            Te faltan <span class="font-bold text-white">{{ $progreso['faltantes'] }}</span> referidos para alcanzar Mariposa Padre/Madre
                        @else
                            <span class="font-bold text-white">{{ $progreso['faltantes'] }}</span> de tus referidos necesitan alcanzar 10 referidos
                        @endif
                    </p>
                </div>
            @else
                <div class="mt-6 bg-white/20 rounded-lg p-4">
                    <p class="text-lg font-semibold text-white">{{ $progreso['mensaje'] }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Referidos Directos -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-lg transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-md bg-gradient-to-br from-blue-500 to-blue-600 p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Referidos Directos</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $referidosDirectos->count() }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total en Red -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-lg transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-md bg-gradient-to-br from-purple-500 to-purple-600 p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total en Red</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $totalReferidos }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mariposas Padre/Madre -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-lg transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-md bg-gradient-to-br from-pink-500 to-pink-600 p-3">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12,2C11.5,2 11,2.19 10.59,2.59L2.59,10.59C1.8,11.37 1.8,12.63 2.59,13.41L10.59,21.41C11.37,22.2 12.63,22.2 13.41,21.41L21.41,13.41C22.2,12.63 22.2,11.37 21.41,10.59L13.41,2.59C13,2.19 12.5,2 12,2M12,4L20,12L12,20L4,12L12,4M12,7C9.79,7 8,8.79 8,11C8,13.21 9.79,15 12,15C14.21,15 16,13.21 16,11C16,8.79 14.21,7 12,7Z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Padres/Madres</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $mariposas_padres }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mariposas Ejecutivas -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-lg transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-md bg-gradient-to-br from-yellow-500 to-yellow-600 p-3">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Ejecutivas</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $mariposas_ejecutivas }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimos Referidos -->
    @if($referidosDirectos->count() > 0)
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Tus Últimos Referidos
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Los miembros más recientes de tu red
                </p>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($referidosDirectos->take(5) as $referido)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($referido->nombres, 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $referido->nombres }} {{ $referido->apellidos }}</p>
                                    <p class="text-sm text-gray-500">{{ $referido->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($referido->rol === 'Mariposa Azul') bg-blue-100 text-blue-800
                                    @elseif($referido->rol === 'Mariposa Padre/Madre') bg-purple-100 text-purple-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ $referido->rol }}
                                </span>
                                <span class="text-sm text-gray-500">{{ $referido->miembrosReferidos->count() }} referidos</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($referidosDirectos->count() > 5)
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-center">
                    <a href="{{ route('dashboard.referidos') }}" class="text-sm font-medium text-pink-600 hover:text-pink-500">
                        Ver todos los referidos ({{ $referidosDirectos->count() }})
                        <span aria-hidden="true"> &rarr;</span>
                    </a>
                </div>
            @endif
        </div>
    @else
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No tienes referidos aún</h3>
                <p class="mt-1 text-sm text-gray-500">Comienza a construir tu red invitando a nuevos miembros.</p>
            </div>
        </div>
    @endif
</div>
@endsection
