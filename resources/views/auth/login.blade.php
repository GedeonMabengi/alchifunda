@extends('layouts.guest')

@section('title', 'Connexion - ALCHIFUNDA')

@section('content')
<div class="relative bg-black min-h-screen">
    <!-- Header -->
    <header class="absolute top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-lg bg-brand/20 flex items-center justify-center">
                        <span class="text-xl font-bold text-brand">A</span>
                    </div>
                    <span class="text-xl font-bold">ALCHIFUNDA</span>
                </div>
                <a href="{{ url('/') }}" class="glass px-6 py-2 rounded-full hover:bg-white/10 transition">
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="relative max-w-7xl mx-auto px-8 pt-32 pb-20 grid lg:grid-cols-2 gap-12 items-center min-h-screen">
        <!-- Section gauche : Texte et formulaire -->
        <div class="z-10">
            <div class="inline-flex items-center gap-2 bg-zinc-900 border border-zinc-800 px-4 py-1.5 rounded-full text-xs mb-6">
                <span class="text-gray-400">Accès sécurisé à votre compte</span>
            </div>

            <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-8">
                Connectez-vous à votre<span class="text-brand"> Espace Élève</span>
            </h1>

            <p class="text-gray-400 text-lg max-w-md mb-10">
                Accédez à votre apprentissage personnalisé de la chimie adapté au programme national de la RDC.
            </p>

            <!-- Formulaire de connexion -->
            <div class="glass p-8 rounded-2xl max-w-md">
                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            Adresse email
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                value="{{ old('email') }}"
                                class="w-full px-4 py-3 rounded-lg bg-zinc-900/50 border border-zinc-800 
                                       focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent
                                       placeholder-gray-500 text-white
                                       transition-all duration-200">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            Mot de passe
                        </label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="w-full px-4 py-3 rounded-lg bg-zinc-900/50 border border-zinc-800 
                                       focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent
                                       placeholder-gray-500 text-white
                                       transition-all duration-200">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-400 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Options -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox"
                                class="h-5 w-5 text-brand focus:ring-brand bg-zinc-900 border-zinc-700 rounded 
                                       transition duration-200 cursor-pointer">
                            <label for="remember" class="ml-2 block text-sm text-gray-300 cursor-pointer">
                                Se souvenir de moi
                            </label>
                        </div>

                        {{-- Lien mot de passe oublié à activer plus tard --}}
                        {{-- <div class="text-sm">
                            <a href="{{ route('password.request') }}" 
                               class="font-medium text-brand hover:text-brand/80 transition-colors duration-200">
                                Mot de passe oublié ?
                            </a>
                        </div> --}}
                    </div>

                    <!-- Bouton de connexion -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center items-center py-3 px-4 rounded-lg 
                                   text-sm font-medium text-white bg-brand hover:bg-brand/90 
                                   transition-all duration-200 pulse-glow">
                            Se connecter
                        </button>
                    </div>
                </form>

                <!-- Séparateur -->
                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-zinc-800"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-black text-gray-500">
                                Nouveau sur ALCHIFUNDA ?
                            </span>
                        </div>
                    </div>

                    <!-- Bouton d'inscription -->
                    <div class="mt-6">
                        <a href="{{ route('register') }}"
                            class="w-full flex justify-center items-center py-3 px-4 rounded-lg 
                                   text-sm font-medium text-gray-300 
                                   glass hover:bg-white/5 transition-all duration-200
                                   border border-zinc-800">
                            Créer un compte
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section droite : Graphique moléculaire -->
        <div class="relative flex justify-center items-center">
            <div class="absolute w-[500px] h-[500px] bg-brand/10 rounded-full blur-[120px]"></div>

            <div class="relative w-full aspect-square flex justify-center items-center">
                <!-- Orbites atomiques -->
                <div class="absolute w-96 h-96 rounded-full border border-brand/20 atom-orbit"></div>
                <div class="absolute w-64 h-64 rounded-full border border-brand/30 atom-orbit" style="animation-duration: 15s; animation-direction: reverse;"></div>

                <!-- Élément central représentant une molécule -->
                <div class="molecule-shape w-48 h-48 opacity-90 flex items-center justify-center relative">
                   <div class="absolute -top-6 bg-amber-500 w-12 h-12 rounded-full shadow-2xl flex items-center justify-center font-bold text-xl">AI</div>
                   <div class="absolute -bottom-6 bg-indigo-500 w-12 h-12 rounded-full shadow-2xl flex items-center justify-center font-bold text-xl">CH</div>
                   <div class="absolute -right-6 bg-emerald-500 w-12 h-12 rounded-full shadow-2xl flex items-center justify-center font-bold text-xl">RDC</div>
                   <div class="absolute -left-6 bg-purple-500 w-12 h-12 rounded-full shadow-2xl flex items-center justify-center font-bold text-xl">6e</div>
                </div>

                <!-- Notes flottantes adaptées à la connexion -->
                <div class="absolute top-10 left-0 glass px-4 py-2 rounded-xl flex items-center gap-2 z-20">
                    <span class="text-white text-xs">🔐 Connexion Sécurisée</span>
                </div>

                <div class="absolute bottom-20 right-0 glass px-4 py-2 rounded-xl flex items-center gap-2 z-20">
                    <span class="text-white text-xs">📚 Accès aux Cours</span>
                </div>

                <div class="absolute top-32 right-10 glass px-4 py-2 rounded-xl flex items-center gap-2 z-20">
                    <span class="text-white text-xs">🎯 Progression Sauvegardée</span>
                </div>

                <div class="absolute bottom-32 left-10 glass px-4 py-2 rounded-xl flex items-center gap-2 z-20">
                    <span class="text-white text-xs">🧪 Exercices Personnalisés</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative border-t border-zinc-900 py-8">
        <div class="max-w-7xl mx-auto px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center gap-2 mb-4 md:mb-0">
                    <div class="w-8 h-8 rounded-lg bg-brand/20 flex items-center justify-center">
                        <span class="font-bold text-brand">A</span>
                    </div>
                    <span class="font-bold">ALCHIFUNDA</span>
                </div>
                <p class="text-gray-500 text-sm">
                    Apprenez la Chimie avec l'IA • Programme RDC Adapté
                </p>
            </div>
        </div>
    </footer>
</div>

<!-- Styles spécifiques -->
<style>
    .glass {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .molecule-shape {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        clip-path: polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%);
        filter: drop-shadow(0 0 50px rgba(59, 130, 246, 0.3));
    }

    @keyframes rotateAtom {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .atom-orbit {
        animation: rotateAtom 20s linear infinite;
    }

    .pulse-glow {
        animation: pulseGlow 2s ease-in-out infinite alternate;
    }

    @keyframes pulseGlow {
        from { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
        to { box-shadow: 0 0 40px rgba(59, 130, 246, 0.8); }
    }

    .text-brand {
        color: #3b82f6;
    }

    .bg-brand {
        background-color: #3b82f6;
    }

    /* Effets de transition */
    input:focus {
        background: rgba(59, 130, 246, 0.05);
    }

    button:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease;
    }

    a:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease;
    }
</style>

<!-- Script pour les animations -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation des orbites atomiques
        const orbits = document.querySelectorAll('.atom-orbit');
        orbits.forEach((orbit, index) => {
            const randomDelay = Math.random() * 3;
            orbit.style.animationDelay = `${randomDelay}s`;
        });

        // Effet de focus pour les inputs
        const inputs = document.querySelectorAll('input[type="email"], input[type="password"], input[type="text"]');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-brand/30', 'rounded-lg');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-brand/30', 'rounded-lg');
            });
        });

        // Effet de hover pour le bouton de connexion
        const loginBtn = document.querySelector('button[type="submit"]');
        loginBtn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.02)';
        });
        
        loginBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
</script>
@endsection