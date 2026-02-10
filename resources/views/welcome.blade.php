<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALCHIFUNDA - Apprendre la Chimie avec l'IA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style type="text/css">
        :root {
            --font-sans: 'Inter', ui-sans-serif, system-ui;
            --color-brand: #3b82f6; /* Bleu scientifique */
            --color-secondary: #10b981; /* Vert pour accent */
            --color-bg: #0a0a0a;
        }

        body {
            background-color: #0a0a0a;
            color: white;
            overflow-x: hidden;
            font-family: var(--font-sans);
        }

        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Forme abstraite représentant une molécule */
        .molecule-shape {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            clip-path: polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%);
            filter: drop-shadow(0 0 50px rgba(59, 130, 246, 0.3));
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
    </style>
</head>
<body class="font-sans antialiased">

    @include('partials.header')

    <main class="relative max-w-7xl mx-auto px-8 pt-20 pb-32 grid lg:grid-cols-2 gap-12 items-center">
        <div class="z-10">
            <div class="inline-flex items-center gap-2 bg-zinc-900 border border-zinc-800 px-4 py-1.5 rounded-full text-xs mb-6">
                <span class="text-gray-400">Nouveau système d'apprentissage adaptatif</span>
                <a href="#" class="text-white font-bold flex items-center">En savoir plus <span class="ml-1">›</span></a>
            </div>

            <h1 class="text-6xl md:text-7xl font-bold leading-tight mb-8">
                Apprenez la Chimie<br>avec une<span class="text-brand"> IA Personnalisée</span>
            </h1>

            <p class="text-gray-400 text-lg max-w-md mb-10">
                Système d'apprentissage adaptatif basé sur le programme national de la RDC pour les élèves du secondaire. Cours personnalisés, exercices interactifs et suivi intelligent.
            </p>

            <div class="flex items-center gap-6 mb-16">
                <button class="bg-white text-black px-8 py-4 rounded-full font-bold hover:scale-105 transition pulse-glow">Commencer l'Évaluation</button>
                <button class="font-bold flex items-center gap-2 hover:underline text-brand">Voir la Démo</button>
            </div>

            <div class="glass p-5 rounded-2xl max-w-xs">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full border-2 border-zinc-900 bg-blue-600 flex items-center justify-center text-xs">H</div>
                        <div class="w-8 h-8 rounded-full border-2 border-zinc-900 bg-red-600 flex items-center justify-center text-xs">O</div>
                        <div class="w-8 h-8 rounded-full border-2 border-zinc-900 bg-green-600 flex items-center justify-center text-xs">C</div>
                    </div>
                    <span class="font-bold text-sm">Programme RDC Adapté</span>
                </div>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Contenu généré à partir du programme national de chimie pour le secondaire et humanités générales.
                </p>
            </div>
        </div>

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

                <!-- Notes flottantes -->
                <div class="absolute top-10 left-0 glass px-4 py-2 rounded-xl flex items-center gap-2 z-20">
                    <span class="text-white text-xs">🎯 Évaluation du Niveau</span>
                </div>

                <div class="absolute bottom-20 right-0 glass px-4 py-2 rounded-xl flex items-center gap-2 z-20">
                    <span class="text-white text-xs">📊 Suivi Personnalisé</span>
                </div>

                <div class="absolute top-32 right-10 glass px-4 py-2 rounded-xl flex items-center gap-2 z-20">
                    <span class="text-white text-xs">🧪 Exercices Adaptatifs</span>
                </div>

                <div class="absolute bottom-32 left-10 glass px-4 py-2 rounded-xl flex items-center gap-2 z-20">
                    <span class="text-white text-xs">📈 Progression Intelligente</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Section Fonctionnalités -->
    <section class="max-w-7xl mx-auto px-8 py-20">
        <h2 class="text-4xl font-bold text-center mb-4">Comment Fonctionne ALCHIFUNDA</h2>
        <p class="text-gray-400 text-center max-w-2xl mx-auto mb-16">Notre système en 3 étapes pour un apprentissage optimal de la chimie</p>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="glass p-6 rounded-2xl">
                <div class="w-12 h-12 rounded-lg bg-brand/20 flex items-center justify-center text-2xl mb-4">1</div>
                <h3 class="text-xl font-bold mb-3">Base de Connaissances</h3>
                <p class="text-gray-400 text-sm">Génération du contenu pédagogique à partir du programme national de chimie de la RDC pour chaque niveau du secondaire.</p>
            </div>

            <div class="glass p-6 rounded-2xl">
                <div class="w-12 h-12 rounded-lg bg-secondary/20 flex items-center justify-center text-2xl mb-4">2</div>
                <h3 class="text-xl font-bold mb-3">Évaluation Personnalisée</h3>
                <p class="text-gray-400 text-sm">L'IA détermine votre niveau, vos préférences et votre rythme d'apprentissage comme sur Duolingo.</p>
            </div>

            <div class="glass p-6 rounded-2xl">
                <div class="w-12 h-12 rounded-lg bg-purple-500/20 flex items-center justify-center text-2xl mb-4">3</div>
                <h3 class="text-xl font-bold mb-3">Apprentissage Adaptatif</h3>
                <p class="text-gray-400 text-sm">Contenu reformulé selon vos besoins, questions de contrôle, scores et progression intelligente vers les leçons suivantes.</p>
            </div>
        </div>
    </section>

    <!-- Section Pourquoi ALCHIFUNDA -->
    <section class="max-w-7xl mx-auto px-8 py-20">
        <div class="glass p-8 rounded-3xl">
            <h2 class="text-3xl font-bold mb-6">Différenciation par rapport aux IA Génériques</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 text-brand">ALCHIFUNDA</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2"><span class="text-green-500">✓</span> <span>Contenu spécifique au programme RDC</span></li>
                        <li class="flex items-start gap-2"><span class="text-green-500">✓</span> <span>Suivi de progression structuré</span></li>
                        <li class="flex items-start gap-2"><span class="text-green-500">✓</span> <span>Évaluations et scores personnalisés</span></li>
                        <li class="flex items-start gap-2"><span class="text-green-500">✓</span> <span>Parcours d'apprentissage adaptatif</span></li>
                        <li class="flex items-start gap-2"><span class="text-green-500">✓</span> <span>Base de données pédagogique organisée</span></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4 text-gray-400">IA Générique (ChatGPT, etc.)</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2"><span class="text-red-500">✗</span> <span>Contenu généraliste, non spécifique au programme RDC</span></li>
                        <li class="flex items-start gap-2"><span class="text-red-500">✗</span> <span>Pas de suivi de progression</span></li>
                        <li class="flex items-start gap-2"><span class="text-red-500">✗</span> <span>Pas d'évaluations structurées</span></li>
                        <li class="flex items-start gap-2"><span class="text-red-500">✗</span> <span>Pas de parcours d'apprentissage</span></li>
                        <li class="flex items-start gap-2"><span class="text-red-500">✗</span> <span>Réponses isolées, sans continuité pédagogique</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="max-w-4xl mx-auto px-8 py-20 text-center">
        <h2 class="text-4xl font-bold mb-6">Prêt à Maîtriser la Chimie ?</h2>
        <p class="text-gray-400 text-lg mb-10 max-w-2xl mx-auto">Rejoignez les premiers élèves à bénéficier de l'apprentissage adaptatif par IA spécifiquement conçu pour le programme de la RDC.</p>
        <button class="bg-linear-to-r from-brand to-secondary text-white px-10 py-4 rounded-full font-bold text-lg hover:scale-105 transition">Commencer Gratuitement</button>
        <p class="text-gray-500 text-sm mt-6">Aucune carte de crédit requise • Évaluation gratuite du niveau</p>
    </section>

    @include('partials.footer')

</body>
</html>
