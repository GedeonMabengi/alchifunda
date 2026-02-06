<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - ALCHIFUNDA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style type="text/css">
        :root {
            --font-sans: 'Inter', ui-sans-serif, system-ui;
            --color-brand: #3b82f6;
            --color-secondary: #10b981;
            --color-bg: #0a0a0a;
        }

        body {
            background-color: #0a0a0a;
            color: white;
            overflow-x: hidden;
            min-height: 100vh;
            font-family: var(--font-sans);
        }

        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-form {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .molecule-shape {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            clip-path: polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%);
            filter: drop-shadow(0 0 50px rgba(59, 130, 246, 0.3));
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        .float-animation-delay {
            animation: float 6s ease-in-out infinite;
            animation-delay: 2s;
        }

        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            from { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
            to { box-shadow: 0 0 40px rgba(59, 130, 246, 0.8); }
        }

        .input-glow:focus {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
            border-color: #3b82f6;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="font-sans antialiased flex flex-col min-h-screen">

    <!-- Header -->
    <header class="flex items-center justify-between px-8 py-6 max-w-7xl mx-auto w-full">
        <a href="{{ route('home') }}" class="text-2xl font-bold flex items-center gap-2 hover:opacity-80 transition">
            <span class="w-8 h-8 bg-white text-black rounded-full flex items-center justify-center font-bold">A</span>
            ALCHIFUNDA
        </a>

        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="text-sm font-medium text-gray-400 hover:text-white transition">Retour à l'accueil</a>
            <a href="{{ route('register') }}" class="text-sm font-medium text-brand hover:text-blue-400 transition">Créer un compte</a>
        </div>
    </header>

    <!-- Contenu Principal -->
    <main class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-12 items-center">

            <!-- Section gauche - Présentation et visuel -->
            <div class="relative hidden lg:block">
                <div class="absolute w-[500px] h-[500px] bg-brand/10 rounded-full blur-[120px] -top-20 -left-20"></div>

                <div class="relative">
                    <h1 class="text-5xl font-bold leading-tight mb-6">
                        Bienvenue dans <span class="text-brand">votre laboratoire</span> d'apprentissage
                    </h1>

                    <p class="text-gray-400 text-lg mb-10 max-w-md">
                        Connectez-vous pour accéder à votre parcours personnalisé de chimie, adapté à votre niveau et basé sur le programme de la RDC.
                    </p>

                    <!-- Éléments visuels flottants -->
                    <div class="relative h-64">
                        <!-- Molécule centrale -->
                        <div class="molecule-shape w-32 h-32 opacity-90 flex items-center justify-center relative float-animation mx-auto">
                           <div class="absolute -top-4 bg-amber-500 w-10 h-10 rounded-full shadow-2xl flex items-center justify-center font-bold">AI</div>
                           <div class="absolute -bottom-4 bg-indigo-500 w-10 h-10 rounded-full shadow-2xl flex items-center justify-center font-bold text-sm">CH</div>
                        </div>

                        <!-- Atomes flottants -->
                        <div class="absolute top-0 left-10 w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center border border-blue-500/30 float-animation-delay">
                            <span class="text-blue-300">H</span>
                        </div>

                        <div class="absolute bottom-10 right-10 w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center border border-red-500/30 float-animation">
                            <span class="text-red-300">O</span>
                        </div>

                        <div class="absolute top-20 right-0 w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center border border-green-500/30 float-animation-delay">
                            <span class="text-green-300">C</span>
                        </div>
                    </div>

                    <!-- Avantages -->
                    <div class="glass p-6 rounded-2xl mt-12">
                        <h3 class="font-bold mb-4 text-lg">Pourquoi se connecter ?</h3>
                        <ul class="space-y-3 text-sm text-gray-400">
                            <li class="flex items-center gap-3"><i class="fas fa-robot text-brand"></i> <span>Reprise de votre progression personnalisée</span></li>
                            <li class="flex items-center gap-3"><i class="fas fa-chart-line text-secondary"></i> <span>Accès à vos statistiques détaillées</span></li>
                            <li class="flex items-center gap-3"><i class="fas fa-flask text-purple-400"></i> <span>Exercices adaptés à votre niveau</span></li>
                            <li class="flex items-center gap-3"><i class="fas fa-trophy text-amber-400"></i> <span>Suivi de vos scores et badges</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Section droite - Formulaire -->
            <div class="relative z-10">
                <div class="glass-form p-8 rounded-3xl max-w-md mx-auto">
                    <!-- En-tête avec onglets -->
                    <div class="flex border-b border-gray-800 mb-8">
                        <button id="login-tab" class="flex-1 py-3 font-bold text-center border-b-2 border-brand text-white transition">Connexion</button>
                        <button id="signup-tab" class="flex-1 py-3 font-bold text-center text-gray-400 hover:text-white transition">Inscription</button>
                    </div>

                    <!-- Formulaire de connexion -->
                    <div id="login-form" class="tab-content active">
                        <h2 class="text-2xl font-bold mb-2">Connectez-vous</h2>
                        <p class="text-gray-400 text-sm mb-8">Entrez vos identifiants pour accéder à votre compte</p>

                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf
                            <div>
                                <label for="email" class="block text-sm font-medium mb-2">Adresse email ou nom d'utilisateur</label>
                                <input
                                    type="text"
                                    id="email"
                                    name="email"
                                    class="w-full bg-zinc-900 border border-gray-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-brand/50 input-glow transition @error('email') border-red-500 @enderror"
                                    placeholder="votre@email.com"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                >
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label for="password" class="block text-sm font-medium">Mot de passe</label>
                                    <a href="{{ route('password.request') }}" class="text-xs text-brand hover:text-blue-400 transition">Mot de passe oublié ?</a>
                                </div>
                                <div class="relative">
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="w-full bg-zinc-900 border border-gray-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-brand/50 input-glow transition pr-12 @error('password') border-red-500 @enderror"
                                        placeholder="Votre mot de passe"
                                        required
                                    >
                                    <button type="button" id="togglePassword" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    id="remember"
                                    name="remember"
                                    class="w-4 h-4 rounded bg-zinc-900 border-gray-700 text-brand focus:ring-brand/50"
                                    {{ old('remember') ? 'checked' : '' }}
                                >
                                <label for="remember" class="ml-2 text-sm text-gray-400">Se souvenir de moi</label>
                            </div>

                            <button
                                type="submit"
                                class="w-full bg-brand text-white font-bold py-3 rounded-xl hover:bg-blue-600 transition pulse-glow"
                            >
                                Se connecter
                            </button>

                            <div class="relative my-6">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-800"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-[#0a0a0a] text-gray-500">Ou continuer avec</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <button type="button" class="glass py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-white/10 transition">
                                    <i class="fab fa-google text-red-400"></i>
                                    <span class="text-sm">Google</span>
                                </button>
                                <button type="button" class="glass py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-white/10 transition">
                                    <i class="fab fa-microsoft text-blue-400"></i>
                                    <span class="text-sm">Microsoft</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Formulaire d'inscription -->
                    <div id="signup-form" class="tab-content">
                        <h2 class="text-2xl font-bold mb-2">Créez votre compte</h2>
                        <p class="text-gray-400 text-sm mb-8">Commencez votre parcours d'apprentissage personnalisé</p>

                        <form method="POST" action="{{ route('register') }}" class="space-y-6">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label for="firstname" class="block text-sm font-medium mb-2">Prénom</label>
                                    <input
                                        type="text"
                                        id="firstname"
                                        name="firstname"
                                        class="w-full bg-zinc-900 border border-gray-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-brand/50 input-glow transition @error('firstname') border-red-500 @enderror"
                                        placeholder="Votre prénom"
                                        value="{{ old('firstname') }}"
                                        required
                                    >
                                    @error('firstname')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="lastname" class="block text-sm font-medium mb-2">Nom</label>
                                    <input
                                        type="text"
                                        id="lastname"
                                        name="lastname"
                                        class="w-full bg-zinc-900 border border-gray-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-brand/50 input-glow transition @error('lastname') border-red-500 @enderror"
                                        placeholder="Votre nom"
                                        value="{{ old('lastname') }}"
                                        required
                                    >
                                    @error('lastname')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium mb-2">Adresse email</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="w-full bg-zinc-900 border border-gray-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-brand/50 input-glow transition @error('email') border-red-500 @enderror"
                                    placeholder="votre@email.com"
                                    value="{{ old('email') }}"
                                    required
                                >
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium mb-2">Mot de passe</label>
                                <div class="relative">
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="w-full bg-zinc-900 border border-gray-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-brand/50 input-glow transition pr-12 @error('password') border-red-500 @enderror"
                                        placeholder="Créez un mot de passe"
                                        required
                                    >
                                    <button type="button" id="toggleSignupPassword" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Minimum 8 caractères avec des chiffres et lettres</p>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium mb-2">Confirmez le mot de passe</label>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="w-full bg-zinc-900 border border-gray-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-brand/50 input-glow transition"
                                    placeholder="Répétez votre mot de passe"
                                    required
                                >
                            </div>

                            <div>
                                <label for="niveau" class="block text-sm font-medium mb-2">Niveau scolaire (RDC)</label>
                                <select
                                    id="niveau"
                                    name="niveau"
                                    class="w-full bg-zinc-900 border border-gray-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-brand/50 input-glow transition @error('niveau') border-red-500 @enderror"
                                    required
                                >
                                    <option value="" disabled {{ !old('niveau') ? 'selected' : '' }}>Sélectionnez votre niveau</option>
                                    <option value="1secondaire" {{ old('niveau') === '1secondaire' ? 'selected' : '' }}>1ère Secondaire</option>
                                    <option value="2secondaire" {{ old('niveau') === '2secondaire' ? 'selected' : '' }}>2ème Secondaire</option>
                                    <option value="3secondaire" {{ old('niveau') === '3secondaire' ? 'selected' : '' }}>3ème Secondaire</option>
                                    <option value="4secondaire" {{ old('niveau') === '4secondaire' ? 'selected' : '' }}>4ème Secondaire</option>
                                    <option value="5secondaire" {{ old('niveau') === '5secondaire' ? 'selected' : '' }}>5ème Secondaire</option>
                                    <option value="6secondaire" {{ old('niveau') === '6secondaire' ? 'selected' : '' }}>6ème Secondaire</option>
                                    <option value="humanites" {{ old('niveau') === 'humanites' ? 'selected' : '' }}>Humanités Générales</option>
                                    <option value="autre" {{ old('niveau') === 'autre' ? 'selected' : '' }}>Autre / Enseignant</option>
                                </select>
                                @error('niveau')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-start">
                                <input
                                    type="checkbox"
                                    id="terms"
                                    name="terms"
                                    class="w-4 h-4 mt-1 rounded bg-zinc-900 border-gray-700 text-brand focus:ring-brand/50 @error('terms') border-red-500 @enderror"
                                    required
                                >
                                <label for="terms" class="ml-2 text-sm text-gray-400">
                                    J'accepte les
                                    <a href="#" class="text-brand hover:text-blue-400">Conditions d'utilisation</a>
                                    et la
                                    <a href="#" class="text-brand hover:text-blue-400">Politique de confidentialité</a>
                                </label>
                            </div>
                            @error('terms')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            <button
                                type="submit"
                                class="w-full bg-secondary text-white font-bold py-3 rounded-xl hover:bg-emerald-600 transition"
                            >
                                Créer mon compte
                            </button>

                            <p class="text-center text-sm text-gray-500">
                                En créant un compte, vous acceptez de passer l'évaluation initiale de niveau.
                            </p>
                        </form>
                    </div>

                    <!-- Message d'accès démo -->
                    <div class="mt-8 pt-6 border-t border-gray-800 text-center">
                        <p class="text-sm text-gray-400 mb-2">Vous voulez juste essayer le système ?</p>
                        <button id="demoLogin" class="text-brand hover:text-blue-400 font-medium text-sm">
                            <i class="fas fa-flask mr-2"></i>Accéder à la version démo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="px-8 py-8 mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} ALCHIFUNDA. Système d'apprentissage de la chimie par IA.
            </div>

            <div class="flex gap-6 text-sm text-gray-400">
                <a href="#" class="hover:text-white transition">Confidentialité</a>
                <a href="#" class="hover:text-white transition">Conditions</a>
                <a href="#" class="hover:text-white transition">Support</a>
                <a href="#" class="hover:text-white transition">À propos</a>
            </div>
        </div>
    </footer>

    <!-- Script JavaScript -->
    <script>
        // Gestion des onglets Connexion/Inscription
        document.addEventListener('DOMContentLoaded', function() {
            const loginTab = document.getElementById('login-tab');
            const signupTab = document.getElementById('signup-tab');
            const loginForm = document.getElementById('login-form');
            const signupForm = document.getElementById('signup-form');

            // Onglet Connexion
            loginTab.addEventListener('click', function() {
                loginTab.classList.add('border-brand', 'text-white');
                loginTab.classList.remove('text-gray-400');
                signupTab.classList.remove('border-brand', 'text-white');
                signupTab.classList.add('text-gray-400');

                loginForm.classList.add('active');
                signupForm.classList.remove('active');
            });

            // Onglet Inscription
            signupTab.addEventListener('click', function() {
                signupTab.classList.add('border-brand', 'text-white');
                signupTab.classList.remove('text-gray-400');
                loginTab.classList.remove('border-brand', 'text-white');
                loginTab.classList.add('text-gray-400');

                signupForm.classList.add('active');
                loginForm.classList.remove('active');
            });

            // Toggle visibilité mot de passe
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    togglePassword.innerHTML = type === 'password' ? '<i class="far fa-eye"></i>' : '<i class="far fa-eye-slash"></i>';
                });
            }

            // Toggle visibilité mot de passe inscription
            const toggleSignupPassword = document.getElementById('toggleSignupPassword');
            const signupPasswordInput = document.getElementById('signup-password');

            if (toggleSignupPassword && signupPasswordInput) {
                toggleSignupPassword.addEventListener('click', function() {
                    const type = signupPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    signupPasswordInput.setAttribute('type', type);
                    toggleSignupPassword.innerHTML = type === 'password' ? '<i class="far fa-eye"></i>' : '<i class="far fa-eye-slash"></i>';
                });
            }

            // Connexion démo
            const demoLogin = document.getElementById('demoLogin');
            if (demoLogin) {
                demoLogin.addEventListener('click', function() {
                    const demoBtn = this;
                    const originalText = demoBtn.innerHTML;
                    demoBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Chargement...';
                    demoBtn.disabled = true;

                    setTimeout(() => {
                        window.location.href = '/demo';
                    }, 1500);
                });
            }

            // Animation des éléments flottants
            const floatingElements = document.querySelectorAll('.float-animation, .float-animation-delay');
            floatingElements.forEach(el => {
                el.style.animationPlayState = 'running';
            });
        });
    </script>
</body>
</html>
