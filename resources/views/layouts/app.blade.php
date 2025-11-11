<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mariposas') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 6s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 100%);
            backdrop-filter: blur(10px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
        }

        .progress-glow {
            box-shadow: 0 0 20px rgba(236, 72, 153, 0.5);
        }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 overflow-x-hidden">
    <div class="min-h-full">
        <!-- Navbar con Glass Effect -->
        <nav class="fixed top-0 left-0 right-0 z-50 glass-effect border-b border-white/20 shadow-lg">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-20 items-center justify-between">
                    <!-- Logo y nombre con efecto -->
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 rounded-2xl blur opacity-75 group-hover:opacity-100 transition duration-500"></div>
                                <div class="relative bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 p-3 rounded-2xl">
                                    <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C11.5 2 11 2.19 10.59 2.59L2.59 10.59C1.8 11.37 1.8 12.63 2.59 13.41L10.59 21.41C11.37 22.2 12.63 22.2 13.41 21.41L21.41 13.41C22.2 12.63 22.2 11.37 21.41 10.59L13.41 2.59C13 2.19 12.5 2 12 2M12 4L20 12L12 20L4 12L12 4M12 7C9.79 7 8 8.79 8 11S9.79 15 12 15 16 13.21 16 11 14.21 7 12 7Z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 bg-clip-text text-transparent">
                                Mariposas
                            </h1>
                            <p class="text-xs font-medium text-gray-500">Red de Crecimiento</p>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-2">
                            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-pink-600 to-purple-600 text-white shadow-lg shadow-pink-500/50' : 'text-gray-700 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 hover:text-pink-600' }} rounded-xl px-4 py-2.5 text-sm font-semibold transition-all duration-300">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <span>Dashboard</span>
                                </div>
                            </a>
                            <a href="{{ route('dashboard.referidos') }}" class="{{ request()->routeIs('dashboard.referidos') ? 'bg-gradient-to-r from-pink-600 to-purple-600 text-white shadow-lg shadow-pink-500/50' : 'text-gray-700 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 hover:text-pink-600' }} rounded-xl px-4 py-2.5 text-sm font-semibold transition-all duration-300">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span>Mis Referidos</span>
                                </div>
                            </a>
                            <a href="{{ route('dashboard.perfil') }}" class="{{ request()->routeIs('dashboard.perfil') ? 'bg-gradient-to-r from-pink-600 to-purple-600 text-white shadow-lg shadow-pink-500/50' : 'text-gray-700 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 hover:text-pink-600' }} rounded-xl px-4 py-2.5 text-sm font-semibold transition-all duration-300">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>Mi Perfil</span>
                                </div>
                            </a>
                            <a href="{{ route('filament.panel.pages.dashboard') }}" class="text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all duration-300">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>Admin</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" type="button" class="flex items-center space-x-3 rounded-xl p-2 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 focus:outline-none transition-all duration-300">
                                    <div class="relative">
                                        <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-pink-500 via-purple-500 to-blue-500 p-0.5 shadow-lg">
                                            <div class="h-full w-full rounded-xl bg-white flex items-center justify-center">
                                                <span class="text-lg font-bold bg-gradient-to-br from-pink-600 to-purple-600 bg-clip-text text-transparent">
                                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full bg-green-400 border-2 border-white"></div>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs font-medium text-gray-500">{{ auth()->user()->miembro->rol ?? 'Miembro' }}</p>
                                    </div>
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-2xl glass-effect shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-2">
                                        <form method="POST" action="{{ route('filament.panel.auth.logout') }}">
                                            @csrf
                                            <button type="submit" class="group flex w-full items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 hover:text-red-600 transition-all duration-200">
                                                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                </svg>
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
                        <button @click="mobileOpen = !mobileOpen" type="button" class="inline-flex items-center justify-center rounded-xl p-2 text-gray-700 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                            </svg>
                        </button>

                        <!-- Mobile menu -->
                        <div x-show="mobileOpen" @click.away="mobileOpen = false" x-transition class="absolute top-20 left-0 right-0 glass-effect md:hidden shadow-2xl border-t border-white/20 mx-4 rounded-2xl">
                            <div class="space-y-1 px-3 pb-3 pt-3">
                                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-pink-600 to-purple-600 text-white' : 'text-gray-700 hover:bg-gray-50' }} block rounded-xl px-3 py-3 text-base font-semibold">Dashboard</a>
                                <a href="{{ route('dashboard.referidos') }}" class="{{ request()->routeIs('dashboard.referidos') ? 'bg-gradient-to-r from-pink-600 to-purple-600 text-white' : 'text-gray-700 hover:bg-gray-50' }} block rounded-xl px-3 py-3 text-base font-semibold">Mis Referidos</a>
                                <a href="{{ route('dashboard.perfil') }}" class="{{ request()->routeIs('dashboard.perfil') ? 'bg-gradient-to-r from-pink-600 to-purple-600 text-white' : 'text-gray-700 hover:bg-gray-50' }} block rounded-xl px-3 py-3 text-base font-semibold">Mi Perfil</a>
                                <a href="{{ route('filament.panel.pages.dashboard') }}" class="text-gray-700 hover:bg-gray-50 block rounded-xl px-3 py-3 text-base font-semibold">Panel Admin</a>
                                <form method="POST" action="{{ route('filament.panel.auth.logout') }}" class="mt-2 border-t border-gray-200 pt-2">
                                    @csrf
                                    <button type="submit" class="block w-full text-left rounded-xl px-3 py-3 text-base font-semibold text-red-600 hover:bg-red-50">
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
        <main class="pt-24 pb-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
