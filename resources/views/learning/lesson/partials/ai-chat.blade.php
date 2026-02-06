<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6" x-data="aiChat()">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Assistant IA</h3>
    
    <!-- Historique des messages -->
    <div class="mb-4 h-64 overflow-y-auto space-y-4" id="chat-messages">
        <!-- Messages seront ajoutés ici dynamiquement -->
    </div>
    
    <!-- Formulaire de question -->
    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
        <form @submit.prevent="sendMessage" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Posez votre question
                </label>
                <textarea x-model="message" rows="3" 
                          placeholder="Ex: Pouvez-vous expliquer la théorie atomique de Dalton ?"
                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                          required></textarea>
            </div>
            
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    L'IA adaptera sa réponse à vos préférences
                </div>
                
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                        :disabled="loading">
                    <template x-if="loading">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!loading">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    <span x-text="loading ? 'Traitement...' : 'Envoyer'"></span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function aiChat() {
        return {
            message: '',
            loading: false,
            messages: [],
            
            async sendMessage() {
                if (!this.message.trim() || this.loading) return;
                
                const userMessage = this.message.trim();
                this.message = '';
                
                // Ajouter le message utilisateur
                this.addMessage('user', userMessage);
                
                // Afficher l'indicateur de chargement
                this.loading = true;
                
                try {
                    const response = await fetch('{{ route("ai.ask") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: userMessage,
                            lesson_id: {{ $lesson->id ?? 'null' }},
                            context: 'lesson_help'
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        // Ajouter la réponse IA
                        this.addMessage('ai', data.response);
                    } else {
                        this.addMessage('ai', 'Désolé, une erreur est survenue. Veuillez réessayer.');
                    }
                } catch (error) {
                    this.addMessage('ai', 'Erreur de connexion. Veuillez vérifier votre connexion internet.');
                } finally {
                    this.loading = false;
                }
            },
            
            addMessage(sender, content) {
                this.messages.push({ sender, content, timestamp: new Date() });
                this.scrollToBottom();
            },
            
            scrollToBottom() {
                this.$nextTick(() => {
                    const container = document.getElementById('chat-messages');
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                });
            },
            
            // Initialiser avec un message de bienvenue
            init() {
                this.$nextTick(() => {
                    this.addMessage('ai', 'Bonjour ! Je suis votre assistant IA. Posez-moi vos questions sur cette leçon et je vous répondrai en adaptant mes explications à vos préférences.');
                });
            }
        }
    }
</script>
@endpush