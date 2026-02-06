<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Logo -->
        <div class="w-full sm:max-w-md px-6 py-8">
            <div class="flex justify-center mb-8">
                <a href="{{ route('home') }}">
                    <div class="text-3xl font-bold text-indigo-600">
                        ALCHIFUNDA
                    </div>
                    <div class="text-sm text-center text-gray-600 mt-1">
                        Apprentissage Intelligent de la Chimie
                    </div>
                </a>
            </div>

            <!-- Notifications -->
            @if(session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4">
                    <div class="font-medium text-red-600">
                        Oups ! Quelque chose s'est mal passé.
                    </div>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Contenu de la page -->
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>