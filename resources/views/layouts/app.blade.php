<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mariposas') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full font-sans antialiased">
    <div class="min-h-full">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 shadow-lg">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <!-- Logo y nombre -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-10 w-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C11.5 2 11 2.19 10.59 2.59L2.59 10.59C1.8 11.37 1.8 12.63 2.59 13.41L10.59 21.41C11.37 22.2 12.63 22.2 13.41 21.41L21.41 13.41C22.2 12.63 22.2 11.37 21.41 10.59L13.41 2.59C13 2.19 12.5 2 12 2M12 4L20 12L12 20L4 12L12 4M12 7C9.79 7 8 8.79 8 11S9.79 15 12 15 16 13.21 16 11 14.21 7 12 7Z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h1 class="text-2xl font-bold text-white">Mariposas</h1>
                            <p class="text-xs text-pink-100">Sistema de Gestión</p>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : 'text-pink-100 hover:bg-white/10 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium transition-all duration-200">
                                Dashboard
                            </a>
                            <a href="{{ route('dashboard.referidos') }}" class="{{ request()->routeIs('dashboard.referidos') ? 'bg-white/20 text-white' : 'text-pink-100 hover:bg-white/10 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium transition-all duration-200">
                                Mis Referidos
                            </a>
                            <a href="{{ route('dashboard.perfil') }}" class="{{ request()->routeIs('dashboard.perfil') ? 'bg-white/20 text-white' : 'text-pink-100 hover:bg-white/10 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium transition-all duration-200">
                                Mi Perfil
                            </a>
                            <a href="{{ route('filament.panel.pages.dashboard') }}" class="text-pink-100 hover:bg-white/10 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition-all duration-200">
                                Panel Admin
                            </a>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <div class="relative inline-block text-left" x-data="{ open: false }">
                                <button @click="open = !open" type="button" class="flex items-center rounded-full bg-white/10 p-1 text-pink-100 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-pink-600 transition-all duration-200">
                                    <span class="sr-only">Abrir menú de usuario</span>
                                    <div class="flex items-center space-x-3 px-3">
                                        <div class="flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                                            <p class="text-xs text-pink-100">{{ auth()->user()->miembro->rol ?? 'Miembro' }}</p>
                                        </div>
                                        <svg class="h-5 w-5 text-pink-100" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <form method="POST" action="{{ route('filament.panel.auth.logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">
                                                Cerrar Sesión
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="-mr-2 flex md:hidden" x-data="{ mobileOpen: false }">
                        <button @click="mobileOpen = !mobileOpen" type="button" class="inline-flex items-center justify-center rounded-md bg-white/10 p-2 text-pink-100 hover:bg-white/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                            <span class="sr-only">Abrir menú principal</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                            </svg>
                        </button>

                        <!-- Mobile menu -->
                        <div x-show="mobileOpen" @click.away="mobileOpen = false" x-transition class="absolute top-16 left-0 right-0 bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 md:hidden">
                            <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : 'text-pink-100 hover:bg-white/10 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium">Dashboard</a>
                                <a href="{{ route('dashboard.referidos') }}" class="{{ request()->routeIs('dashboard.referidos') ? 'bg-white/20 text-white' : 'text-pink-100 hover:bg-white/10 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium">Mis Referidos</a>
                                <a href="{{ route('dashboard.perfil') }}" class="{{ request()->routeIs('dashboard.perfil') ? 'bg-white/20 text-white' : 'text-pink-100 hover:bg-white/10 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium">Mi Perfil</a>
                                <a href="{{ route('filament.panel.pages.dashboard') }}" class="text-pink-100 hover:bg-white/10 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Panel Admin</a>
                                <form method="POST" action="{{ route('filament.panel.auth.logout') }}" class="mt-2">
                                    @csrf
                                    <button type="submit" class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-pink-100 hover:bg-white/10 hover:text-white">
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>

    @livewireScripts
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
