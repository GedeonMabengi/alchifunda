<footer class="glass border-t border-white/10 mt-12">
    <div class="max-w-7xl mx-auto px-8 py-8">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <div class="text-xl font-bold bg-linear-to-r from-brand to-cyan-400 bg-clip-text text-transparent mb-4">
                    ALCHIFUNDA
                </div>
                <p class="text-sm text-gray-400">
                    Apprenez la chimie avec une IA personnalisée, adaptée au programme de la RDC.
                </p>
            </div>
            
            <div>
                <h4 class="text-white font-semibold mb-4">Apprentissage</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('level.index') }}" class="hover:text-white transition-colors">Niveaux</a></li>
                    <li><a href="{{ route('chapter.index') }}" class="hover:text-white transition-colors">Chapitres</a></li>
                    <li><a href="{{ route('progress.index') }}" class="hover:text-white transition-colors">Progression</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-white font-semibold mb-4">Ressources</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('ai.history') }}" class="hover:text-white transition-colors">Assistant IA</a></li>
                    <li><a href="{{ route('achievement.index') }}" class="hover:text-white transition-colors">Récompenses</a></li>
                    <li><a href="{{ route('profile.show') }}" class="hover:text-white transition-colors">Profil</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-white font-semibold mb-4">Contact</h4>
                <p class="text-sm text-gray-400 mb-2">
                    Questions ? Contactez-nous
                </p>
                <a href="mailto:support@alchifunda.com" class="text-brand hover:text-cyan-400 text-sm transition-colors">
                    support@alchifunda.com
                </a>
            </div>
        </div>
        
        <div class="border-t border-white/10 mt-8 pt-8 text-center text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} ALCHIFUNDA. Tous droits réservés.</p>
            <p class="mt-1">Conçu pour le programme national de chimie de la RDC</p>
        </div>
    </div>
</footer>