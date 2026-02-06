<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Démonstration mathématique</h3>
    
    <div class="space-y-6">
        <!-- Équation -->
        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
            <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Équation :</div>
            <div class="text-xl font-mono text-gray-900 dark:text-white text-center">
                H₂ + O₂ → H₂O
            </div>
        </div>
        
        <!-- Balance -->
        <div class="flex flex-col items-center">
            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">Équilibrage :</div>
            
            <div class="flex items-center justify-center space-x-8 mb-6">
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white mb-2">2H₂</div>
                    <div class="h-1 w-16 bg-gray-300 dark:bg-gray-600"></div>
                </div>
                
                <div class="text-2xl text-gray-400">+</div>
                
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white mb-2">O₂</div>
                    <div class="h-1 w-16 bg-gray-300 dark:bg-gray-600"></div>
                </div>
                
                <div class="text-2xl text-gray-400">→</div>
                
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white mb-2">2H₂O</div>
                    <div class="h-1 w-16 bg-gray-300 dark:bg-gray-600"></div>
                </div>
            </div>
            
            <div class="text-sm text-gray-600 dark:text-gray-400 text-center">
                Nombre d'atomes : H=4, O=2 de chaque côté
            </div>
        </div>
        
        <!-- Explication étape par étape -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h4 class="font-medium text-gray-900 dark:text-white mb-3">Étapes de résolution :</h4>
            
            <div class="space-y-3">
                <div class="flex items-start">
                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 text-xs font-bold mr-3">
                        1
                    </span>
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Compter les atomes de chaque côté
                    </span>
                </div>
                
                <div class="flex items-start">
                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 text-xs font-bold mr-3">
                        2
                    </span>
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Ajouter des coefficients pour équilibrer H
                    </span>
                </div>
                
                <div class="flex items-start">
                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 text-xs font-bold mr-3">
                        3
                    </span>
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Vérifier l'équilibre des atomes d'oxygène
                    </span>
                </div>
                
                <div class="flex items-start">
                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 text-xs font-bold mr-3">
                        4
                    </span>
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Simplifier si possible
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Interaction -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <button @click="toggleDetails = !toggleDetails"
                    class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <span class="font-medium text-gray-900 dark:text-white">Voir les détails des calculs</span>
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            
            <div x-show="toggleDetails" x-transition class="mt-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Atomes de H à gauche :</span>
                        <span class="font-mono text-gray-900 dark:text-white">2 × 2 = 4</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Atomes de H à droite :</span>
                        <span class="font-mono text-gray-900 dark:text-white">2 × 2 = 4</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Atomes de O à gauche :</span>
                        <span class="font-mono text-gray-900 dark:text-white">1 × 2 = 2</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Atomes de O à droite :</span>
                        <span class="font-mono text-gray-900 dark:text-white">2 × 1 = 2</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Script pour gérer l'affichage des détails
    document.addEventListener('alpine:init', () => {
        Alpine.data('mathDemo', () => ({
            toggleDetails: false,
            showSteps: {{ $preferences->show_math_steps ?? false ? 'true' : 'false' }},
            
            init() {
                if (this.showSteps) {
                    this.toggleDetails = true;
                }
            }
        }));
    });
</script>
@endpush