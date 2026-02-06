<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ALCHIFUNDA - Apprendre la Chimie avec l\'IA')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --font-sans: 'Inter', ui-sans-serif, system-ui;
            --color-brand: #3b82f6;
            --color-secondary: #10b981;
            --color-accent: #8b5cf6;
            --color-bg: #0a0a0a;
            --color-glass: rgba(255, 255, 255, 0.05);
        }

        body {
            background-color: var(--color-bg);
            color: white;
            font-family: var(--font-sans);
        }

        .glass {
            background: var(--color-glass);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-dark {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .bg-brand-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .text-brand {
            color: var(--color-brand);
        }

        .bg-brand {
            background-color: var(--color-brand);
        }

        .border-brand {
            border-color: var(--color-brand);
        }

        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            from { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
            to { box-shadow: 0 0 40px rgba(59, 130, 246, 0.8); }
        }

        .atom-spin {
            animation: rotateAtom 20s linear infinite;
        }

        @keyframes rotateAtom {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--color-brand);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-black" x-data="{ sidebarOpen: false }">
    <!-- Effet de fond moléculaire -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-brand/10 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="relative min-h-screen">
        <!-- Sidebar pour mobile -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex md:hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black/80" aria-hidden="true" @click="sidebarOpen = false"></div>
            
            <div class="relative flex-1 flex flex-col max-w-xs w-full glass-dark border-r border-white/10">
                @include('layouts.partials.sidebar')
            </div>
        </div>

        <!-- Sidebar pour desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="glass-dark border-r border-white/10 h-full">
                @include('layouts.partials.sidebar')
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="md:pl-64 flex flex-col flex-1">
            @include('layouts.partials.header')
            
            <main class="flex-1 relative z-10">
                <!-- Notifications -->
                @if(session('success'))
                    <div class="max-w-7xl mx-auto px-8 py-4">
                        <div class="glass border border-green-500/30 p-4 rounded-xl">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-300">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="max-w-7xl mx-auto px-8 py-4">
                        <div class="glass border border-red-500/30 p-4 rounded-xl">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-300">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Contenu de la page -->
                <div class="max-w-7xl mx-auto px-8 py-8">
                    @yield('content')
                </div>
            </main>

            @include('layouts.partials.footer')
        </div>
    </div>

    <!-- Scripts -->
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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