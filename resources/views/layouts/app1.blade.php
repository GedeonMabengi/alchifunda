<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'ALCHIFUNDA'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --primary-color: #4F46E5;
            --secondary-color: #10B981;
            --accent-color: #F59E0B;
            --background-color: #F9FAFB;
            --card-background: #FFFFFF;
        }

        [data-theme="dark"] {
            --primary-color: #6366F1;
            --secondary-color: #34D399;
            --accent-color: #FBBF24;
            --background-color: #1F2937;
            --card-background: #374151;
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: false, theme: 'light' }" x-init="theme = localStorage.getItem('theme') || 'light'; $watch('theme', value => { localStorage.setItem('theme', value); document.documentElement.setAttribute('data-theme', value) })">
    <div class="min-h-screen">
        <!-- Sidebar pour mobile -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 flex md:hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true" @click="sidebarOpen = false"></div>
            
            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white dark:bg-gray-800">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button type="button" @click="sidebarOpen = false"
                        class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Fermer le menu</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                @include('layouts.partials.sidebar')
            </div>
        </div>

        <!-- Sidebar pour desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            @include('layouts.partials.sidebar')
        </div>

        <!-- Contenu principal -->
        <div class="md:pl-64 flex flex-col flex-1">
            @include('layouts.partials.header')
            
            <main class="flex-1">
                <!-- Notifications -->
                @if(session('success'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 my-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 my-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Contenu de la page -->
                @yield('content')
            </main>

            @include('layouts.partials.footer')
        </div>
    </div>

    <!-- Scripts -->
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser le thème
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', theme);
            
            // Gestion des notifications non lues
            function updateUnreadNotifications() {
                fetch('/api/notifications/unread-count')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.getElementById('unread-notifications-badge');
                        if (badge) {
                            if (data.count > 0) {
                                badge.textContent = data.count;
                                badge.classList.remove('hidden');
                            } else {
                                badge.classList.add('hidden');
                            }
                        }
                    });
            }
            
            // Mettre à jour toutes les 30 secondes
            setInterval(updateUnreadNotifications, 30000);
            updateUnreadNotifications();
        });
    </script>
</body>
</html>