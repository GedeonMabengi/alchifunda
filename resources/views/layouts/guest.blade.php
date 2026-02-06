<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'ALCHIFUNDA'))</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles globaux -->
    <style>
        :root {
            --font-sans: 'Inter', ui-sans-serif, system-ui;
            --color-brand: #3b82f6;
            --color-secondary: #10b981;
            --color-bg: #0a0a0a;
        }

        body {
            font-family: var(--font-sans);
            background-color: #0a0a0a;
            color: white;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .text-brand {
            color: var(--color-brand);
        }

        .bg-brand {
            background-color: var(--color-brand);
        }

        .bg-secondary {
            background-color: var(--color-secondary);
        }

        /* Animation pour atomes tournants */
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

        /* Forme moléculaire */
        .molecule-shape {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            clip-path: polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%);
            filter: drop-shadow(0 0 50px rgba(59, 130, 246, 0.3));
        }

        /* Transitions globales */
        button, a, input[type="submit"] {
            transition: all 0.2s ease;
        }

        button:hover, a:hover {
            transform: translateY(-2px);
        }

        input:focus {
            outline: none;
            ring: 2px;
            ring-color: var(--color-brand);
        }
    </style>

    <!-- Styles spécifiques à la page -->
    @stack('styles')
</head>
<body class="antialiased">
    <!-- Cercles décoratifs de fond -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-brand/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500/5 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-emerald-500/3 rounded-full blur-3xl"></div>
    </div>

    <!-- Contenu principal -->
    <main class="relative z-10">
        @yield('content')
    </main>

    <!-- Scripts globaux -->
    <script>
        // Gestion du menu mobile (si nécessaire)
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle menu mobile
            const menuButton = document.getElementById('menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (menuButton && mobileMenu) {
                menuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Fermer le menu mobile en cliquant à l'extérieur
            document.addEventListener('click', function(event) {
                if (mobileMenu && !mobileMenu.contains(event.target) && menuButton && !menuButton.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });

            // Gestion des messages flash
            const flashMessages = document.querySelectorAll('[data-dismiss="flash"]');
            flashMessages.forEach(message => {
                message.addEventListener('click', function() {
                    this.parentElement.remove();
                });

                // Auto-dismiss après 5 secondes
                setTimeout(() => {
                    if (message.parentElement) {
                        message.parentElement.remove();
                    }
                }, 5000);
            });

            // Amélioration des inputs
            const textInputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
            textInputs.forEach(input => {
                // Ajouter une classe au parent lors du focus
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-brand/20', 'rounded-lg');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-brand/20', 'rounded-lg');
                });

                // Auto-capitalization pour les emails (minuscules)
                if (input.type === 'email') {
                    input.addEventListener('blur', function() {
                        this.value = this.value.toLowerCase();
                    });
                }
            });

            // Prévenir la double soumission des formulaires
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitButton = this.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Chargement...';
                        
                        // Réactiver le bouton après 5 secondes au cas où
                        setTimeout(() => {
                            submitButton.disabled = false;
                            submitButton.innerHTML = submitButton.getAttribute('data-original-text') || 'Soumettre';
                        }, 5000);
                    }
                });
            });

            // Sauvegarder le texte original des boutons de soumission
            document.querySelectorAll('button[type="submit"]').forEach(button => {
                button.setAttribute('data-original-text', button.innerHTML);
            });

            // Smooth scroll pour les ancres
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Gestion des modales (si nécessaire)
            window.openModal = function(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            };

            window.closeModal = function(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            };

            // Fermer les modales avec ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.modal').forEach(modal => {
                        if (!modal.classList.contains('hidden')) {
                            modal.classList.add('hidden');
                            document.body.style.overflow = 'auto';
                        }
                    });
                }
            });
        });

        // Fonction utilitaire pour afficher les erreurs
        function showError(inputElement, message) {
            // Créer ou récupérer l'élément d'erreur
            let errorElement = inputElement.parentElement.querySelector('.error-message');
            
            if (!errorElement) {
                errorElement = document.createElement('p');
                errorElement.className = 'mt-1 text-sm text-red-400 error-message';
                inputElement.parentElement.appendChild(errorElement);
            }
            
            errorElement.textContent = message;
            inputElement.classList.add('border-red-500');
            
            // Focus sur l'input en erreur
            inputElement.focus();
        }

        // Fonction utilitaire pour effacer les erreurs
        function clearError(inputElement) {
            const errorElement = inputElement.parentElement.querySelector('.error-message');
            if (errorElement) {
                errorElement.remove();
            }
            inputElement.classList.remove('border-red-500');
        }
    </script>

    <!-- Scripts spécifiques à la page -->
    @stack('scripts')
</body>
</html>