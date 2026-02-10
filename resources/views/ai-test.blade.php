<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test API DeepSeek - Chimie</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen p-4 md:p-8">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                🧪 Test API DeepSeek - Chimie
            </h1>
            <p class="text-gray-600">
                Testez l'intégration de l'IA dans votre application de chimie
            </p>
        </div>
        
        <!-- Section de test -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="mb-6">
                <label for="question" class="block text-sm font-medium text-gray-700 mb-2">
                    Posez votre question de chimie :
                </label>
                <textarea 
                    id="question" 
                    rows="4" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="Ex: Explique la loi des gaz parfaits, équilibre l'équation H2 + O2 → H2O, qu'est-ce qu'une mole ?..."
                >Explique la loi des gaz parfaits en 3 phrases simples</textarea>
            </div>
            
            <!-- Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Température (créativité) : <span id="tempValue">0.7</span>
                    </label>
                    <input 
                        type="range" 
                        id="temperature" 
                        min="0" 
                        max="2" 
                        step="0.1" 
                        value="0.7"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tokens maximum : <span id="tokensValue">500</span>
                    </label>
                    <input 
                        type="range" 
                        id="max_tokens" 
                        min="100" 
                        max="2000" 
                        step="100" 
                        value="500"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                    >
                </div>
            </div>
            
            <!-- Bouton -->
            <div class="text-center">
                <button 
                    id="askBtn"
                    class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span id="btnText">📡 Demander à l'IA</span>
                    <span id="loading" class="hidden">⏳ En cours...</span>
                </button>
            </div>
        </div>
        
        <!-- Réponse -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <span class="mr-2">🤖</span> Réponse de l'IA
            </h2>
            <div id="response" class="min-h-[200px] p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-gray-500 text-center py-10">
                    Posez une question pour voir la réponse ici...
                </p>
            </div>
            
            <!-- Infos -->
            <div id="info" class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600 hidden">
                <div class="bg-blue-50 p-3 rounded-lg">
                    <span class="font-medium">Modèle :</span>
                    <span id="model">-</span>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <span class="font-medium">Tokens utilisés :</span>
                    <span id="tokensUsed">-</span>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg">
                    <span class="font-medium">Statut :</span>
                    <span id="status" class="text-green-600">-</span>
                </div>
            </div>
        </div>
        
        <!-- Exemples -->
        <div class="mt-6 text-center">
            <p class="text-gray-600 mb-2">Exemples rapides :</p>
            <div class="flex flex-wrap justify-center gap-2">
                <button class="exemple-btn px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">
                    Qu'est-ce qu'une mole ?
                </button>
                <button class="exemple-btn px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">
                    Équilibre H2 + O2 → H2O
                </button>
                <button class="exemple-btn px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">
                    Différence acide/base
                </button>
                <button class="exemple-btn px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">
                    Tableau périodique
                </button>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionInput = document.getElementById('question');
            const askBtn = document.getElementById('askBtn');
            const responseDiv = document.getElementById('response');
            const infoDiv = document.getElementById('info');
            const btnText = document.getElementById('btnText');
            const loading = document.getElementById('loading');
            const tempSlider = document.getElementById('temperature');
            const tempValue = document.getElementById('tempValue');
            const tokensSlider = document.getElementById('max_tokens');
            const tokensValue = document.getElementById('tokensValue');
            
            // Mise à jour des valeurs des sliders
            tempSlider.addEventListener('input', () => {
                tempValue.textContent = tempSlider.value;
            });
            
            tokensSlider.addEventListener('input', () => {
                tokensValue.textContent = tokensSlider.value;
            });
            
            // Bouton d'envoi
            askBtn.addEventListener('click', askAI);
            
            // Exemples rapides
            document.querySelectorAll('.exemple-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    questionInput.value = btn.textContent;
                    askAI();
                });
            });
            
            // Entrée pour envoyer
            questionInput.addEventListener('keydown', (e) => {
                if (e.ctrlKey && e.key === 'Enter') {
                    askAI();
                }
            });
            
            async function askAI() {
                const question = questionInput.value.trim();
                
                if (!question) {
                    alert('Veuillez poser une question !');
                    return;
                }
                
                // État chargement
                askBtn.disabled = true;
                btnText.classList.add('hidden');
                loading.classList.remove('hidden');
                
                // Réponse en attente
                responseDiv.innerHTML = `
                    <div class="text-center py-10">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500 mb-2"></div>
                        <p class="text-gray-600">L'IA réfléchit à votre question de chimie...</p>
                    </div>
                `;
                infoDiv.classList.add('hidden');
                
                try {
                    const response = await fetch('{{ route("ai.ask") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            question: question,
                            temperature: parseFloat(tempSlider.value),
                            max_tokens: parseInt(tokensSlider.value)
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        // Afficher la réponse
                        responseDiv.innerHTML = `
                            <div class="prose max-w-none">
                                ${data.response.replace(/\n/g, '<br>')}
                            </div>
                        `;
                        
                        // Afficher les infos
                        document.getElementById('model').textContent = data.model;
                        document.getElementById('tokensUsed').textContent = 
                            data.usage?.total_tokens || 'N/A';
                        document.getElementById('status').textContent = 'Succès';
                        document.getElementById('status').className = 'text-green-600';
                        
                        infoDiv.classList.remove('hidden');
                        
                    } else {
                        responseDiv.innerHTML = `
                            <div class="text-center py-10 text-red-600">
                                <p class="font-bold">❌ Erreur</p>
                                <p>${data.error || 'Erreur inconnue'}</p>
                                <p class="text-sm mt-2">${data.message || ''}</p>
                            </div>
                        `;
                        
                        document.getElementById('status').textContent = 'Erreur';
                        document.getElementById('status').className = 'text-red-600';
                        infoDiv.classList.remove('hidden');
                    }
                    
                } catch (error) {
                    responseDiv.innerHTML = `
                        <div class="text-center py-10 text-red-600">
                            <p class="font-bold">❌ Erreur réseau</p>
                            <p>${error.message}</p>
                        </div>
                    `;
                } finally {
                    // Réinitialiser le bouton
                    askBtn.disabled = false;
                    btnText.classList.remove('hidden');
                    loading.classList.add('hidden');
                }
            }
        });
    </script>
</body>
</html>