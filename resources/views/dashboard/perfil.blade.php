@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900">Mi Perfil</h2>
            <p class="mt-1 text-sm text-gray-600">
                Aquí puedes ver y administrar tu información personal.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Información del Perfil -->
        <div class="lg:col-span-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Información Personal
                    </h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Nombres</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $miembro->nombres }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Apellidos</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $miembro->apellidos }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Cédula</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $miembro->cedula }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $miembro->email }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $miembro->telefono ?? 'No especificado' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Provincia</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $miembro->provincia->nombre ?? 'No especificado' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Municipio</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $miembro->municipio->nombre ?? 'No especificado' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Fecha de Registro</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $miembro->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Información del Líder -->
            @if($miembro->liderGrupo)
                <div class="mt-6 bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Mi Líder
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="h-16 w-16 rounded-full bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center text-white text-2xl font-bold">
                                    {{ strtoupper(substr($miembro->liderGrupo->nombres, 0, 1)) }}
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-900">{{ $miembro->liderGrupo->nombres }} {{ $miembro->liderGrupo->apellidos }}</h4>
                                <p class="text-sm text-gray-500">{{ $miembro->liderGrupo->email }}</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($miembro->liderGrupo->rol === 'Mariposa Azul') bg-blue-100 text-blue-800
                                    @elseif($miembro->liderGrupo->rol === 'Mariposa Padre/Madre') bg-purple-100 text-purple-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ $miembro->liderGrupo->rol }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-purple-600 via-pink-600 to-blue-600 overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 text-white">
                    <h3 class="text-lg font-semibold mb-4">Tu Nivel</h3>
                    <div class="text-center">
                        @if($miembro->rol === 'Mariposa Azul')
                            <span class="text-6xl">🦋</span>
                        @elseif($miembro->rol === 'Mariposa Padre/Madre')
                            <span class="text-6xl">👑</span>
                        @else
                            <span class="text-6xl">⭐</span>
                        @endif
                        <h4 class="mt-4 text-2xl font-bold">{{ $miembro->rol }}</h4>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Estadísticas</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Referidos Directos</span>
                            <span class="text-lg font-bold text-gray-900">{{ $miembro->miembrosReferidos->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total en Red</span>
                            <span class="text-lg font-bold text-gray-900">{{ $miembro->obtenerTodosIdsReferidos()->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Estado</span>
                            @if($miembro->estado)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Activo
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Inactivo
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones</h3>
                    <div class="space-y-2">
                        <a href="{{ route('filament.panel.resources.miembros.edit', ['record' => $miembro->miembros_id]) }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-200">
                            Editar Perfil
                        </a>
                        <a href="{{ route('dashboard.referidos') }}" class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-200">
                            Ver Mis Referidos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
