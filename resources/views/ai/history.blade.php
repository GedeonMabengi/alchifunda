{{-- resources/views/ai/history.blade.php --}}
@extends('layouts.app')

@section('title', 'Assistant Chimie IA - ALCHIFUNDA')

@section('page-title', 'Assistant Chimie IA')
@section('page-subtitle', 'Posez vos questions et explorez votre historique d\'apprentissage')

@section('content')
<div class="space-y-8">
    <!-- En-tête avec statistiques -->
    <div class="bg-gradient-to-r from-brand/20 to-cyan-400/20 border border-brand/30 rounded-2xl p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Assistant Chimie IA</h1>
                <p class="text-gray-300">
                    Votre assistant personnel spécialisé dans le programme de chimie de la RDC
                </p>
                <div class="flex items-center gap-4 mt-4">
                    <div class="inline-flex items-center gap-2 bg-black/30 border border-white/10 px-3 py-1 rounded-full text-xs">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-gray-300">En ligne</span>
                    </div>
                    <span class="text-sm text-gray-400">
                        {{ $conversations->total() }} conversations
                    </span>
                </div>
            </div>
            
            <!-- Statistiques IA -->
            <div class="flex items-center gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">{{ $conversations->total() }}</div>
                    <div class="text-xs text-gray-400">Questions</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">
                        {{ $conversations->where('context', 'lesson_help')->count() }}
                    </div>
                    <div class="text-xs text-gray-400">Aide leçons</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">
                        {{ $conversations->count() > 0 ? round($conversations->sum(fn($c) => $c->metadata['tokens_used'] ?? 0) / 1000, 1) : 0 }}k
                    </div>
                    <div class="text-xs text-gray-400">Tokens utilisés</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Colonne gauche : Chat IA -->
        <div class="lg:col-span-2">
            <!-- Interface de chat -->
            <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden flex flex-col shadow-2xl" style="height: 650px;">
                <!-- En-tête du chat -->
                <div class="bg-gradient-to-r from-brand to-cyan-500 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-gray-900"></div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Assistant Chimie IA</h3>
                                <p class="text-sm text-white/80">Spécialisé dans le programme RDC</p>
                            </div>
                        </div>
                        <button onclick="clearChat()" 
                                class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-colors text-sm">
                            Nouvelle conversation
                        </button>
                    </div>
                </div>

                <!-- Zone des messages -->
                <div id="chat-messages" class="flex-1 overflow-y-auto p-6 space-y-6 bg-gray-900">
                    @if(isset($conversation) && $conversation)
                        <!-- Afficher une conversation existante -->
                        <div class="flex items-start justify-end animate-fade-in">
                            <div class="flex-1 max-w-3xl">
                                <div class="bg-gradient-to-r from-brand to-cyan-500 text-white rounded-2xl p-4">
                                    <p class="font-medium">{{ $conversation->user_message }}</p>
                                </div>
                                <div class="text-xs text-gray-500 mt-1 text-right">
                                    {{ $conversation->created_at->format('H:i') }}
                                </div>
                            </div>
                            <div class="flex-shrink-0 ml-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-cyan-400 to-emerald-500 flex items-center justify-center">
                                    <span class="text-xs font-bold text-white">VO</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start animate-fade-in">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-brand to-cyan-400 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 max-w-3xl">
                                <div class="bg-gray-800/50 border border-gray-700 rounded-2xl p-4">
                                    <div class="prose prose-invert max-w-none text-gray-300 text-sm">
                                        {!! nl2br(e($conversation->ai_response)) !!}
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $conversation->created_at->format('H:i') }}
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Message de bienvenue -->
                        <div class="flex items-start animate-fade-in">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-brand to-cyan-400 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="bg-gray-800/50 border border-gray-700 rounded-2xl p-4">
                                    <p class="text-white text-lg font-semibold mb-2">👋 Bonjour ! Je suis votre assistant en chimie</p>
                                    <p class="text-gray-300 text-sm mb-3">
                                        Je suis spécialisé dans le programme national de chimie de la RDC. 
                                        Posez-moi des questions sur :
                                    </p>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="flex items-center gap-2 text-xs text-gray-400">
                                            <div class="w-1.5 h-1.5 bg-brand rounded-full"></div>
                                            <span>Les concepts chimiques</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-gray-400">
                                            <div class="w-1.5 h-1.5 bg-cyan-400 rounded-full"></div>
                                            <span>Les exercices et problèmes</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-gray-400">
                                            <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></div>
                                            <span>Les réactions et équations</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-gray-400">
                                            <div class="w-1.5 h-1.5 bg-purple-500 rounded-full"></div>
                                            <span>Le tableau périodique</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Zone de saisie -->
                <div class="border-t border-gray-800 bg-gray-900 p-4">
                    <form id="chat-form" onsubmit="sendMessage(event)" class="space-y-3">
                        <div class="relative">
                            <textarea 
                                id="chat-input" 
                                rows="2" 
                                class="w-full bg-gray-800 border border-gray-700 rounded-xl p-3 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent resize-none"
                                placeholder="Posez votre question sur la chimie... Ex: 'Expliquez-moi la loi des gaz parfaits'"
                                maxlength="2000"
                                required
                            ></textarea>
                            <div class="absolute bottom-2 right-2 text-xs text-gray-600">
                                <span id="char-count">0</span>/2000
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <button 
                                    type="button" 
                                    onclick="suggestQuestion('Expliquez-moi la différence entre un acide et une base')"
                                    class="px-3 py-1.5 bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-300 rounded-lg transition-colors text-xs"
                                >
                                    💡 Exemple
                                </button>
                                <button 
                                    type="button" 
                                    onclick="suggestQuestion('Donnez-moi un exercice sur les moles')"
                                    class="px-3 py-1.5 bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-300 rounded-lg transition-colors text-xs"
                                >
                                    🧪 Exercice
                                </button>
                            </div>
                            
                            <button 
                                type="submit" 
                                id="send-btn"
                                class="px-4 py-2 bg-gradient-to-r from-brand to-cyan-500 text-white text-sm font-semibold rounded-lg hover:opacity-90 transition-opacity flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span>Envoyer</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="text-center text-xs text-gray-600">
                            L'IA peut parfois faire des erreurs. Vérifiez toujours les informations importantes.
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Colonne droite : Historique et filtres -->
        <div class="space-y-6">
            <!-- Historique récent -->
            <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-brand/20 to-brand/10 border-b border-gray-800 p-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-bold text-white">📚 Historique récent</h3>
                        <span class="text-xs text-gray-400">{{ $conversations->count() }} conversations</span>
                    </div>
                </div>
                
                <div class="overflow-y-auto" style="max-height: 350px;">
                    @if($conversations->count() > 0)
                        <div class="divide-y divide-gray-800">
                            @foreach($conversations->take(10) as $conv)
                                <a href="{{ route('ai.assistant', ['conversation_id' => $conv->id]) }}" 
                                   class="block p-3 hover:bg-gray-800/50 transition {{ isset($conversation) && $conversation->id == $conv->id ? 'bg-brand/10 border-l-2 border-brand' : '' }}">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-brand/20 to-cyan-400/20 flex items-center justify-center">
                                                @if($conv->context == 'lesson_help')
                                                    <svg class="w-4 h-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-white truncate">
                                                {{ Str::limit($conv->user_message, 50) }}
                                            </p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-xs px-2 py-0.5 rounded-full bg-gray-800 text-gray-400">
                                                    {{ $conv->created_at->diffForHumans() }}
                                                </span>
                                                @if($conv->lesson)
                                                    <span class="text-xs px-2 py-0.5 rounded-full bg-brand/20 text-brand truncate max-w-[80px]">
                                                        {{ Str::limit($conv->lesson->title, 10) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        
                        @if($conversations->count() > 10)
                            <div class="p-3 text-center border-t border-gray-800">
                                <span class="text-xs text-gray-500">
                                    Et {{ $conversations->count() - 10 }} conversations de plus...
                                </span>
                            </div>
                        @endif
                    @else
                        <div class="p-6 text-center">
                            <div class="w-12 h-12 mx-auto rounded-full bg-gray-800 flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                            </div>
                            <p class="text-gray-400 text-sm">Aucune conversation</p>
                            <p class="text-xs text-gray-500 mt-1">Commencez par poser une question !</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Filtres rapides -->
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4">
                <h4 class="text-base font-bold text-white mb-3">🔍 Filtrer</h4>
                <div class="space-y-2">
                    <a href="{{ route('ai.assistant') }}" 
                       class="flex items-center justify-between p-2 rounded-lg {{ !request()->has('context') ? 'bg-brand/20 border border-brand/30' : 'hover:bg-gray-800 border border-gray-700' }} transition-all">
                        <span class="text-sm {{ !request()->has('context') ? 'text-white' : 'text-gray-300' }}">Toutes</span>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-gray-800 text-gray-300">{{ $conversations->total() }}</span>
                    </a>
                    <a href="{{ route('ai.assistant', ['context' => 'lesson_help']) }}" 
                       class="flex items-center justify-between p-2 rounded-lg {{ request('context') == 'lesson_help' ? 'bg-brand/20 border border-brand/30' : 'hover:bg-gray-800 border border-gray-700' }} transition-all">
                        <span class="text-sm {{ request('context') == 'lesson_help' ? 'text-white' : 'text-gray-300' }}">Aide leçons</span>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-gray-800 text-gray-300">{{ $conversations->where('context', 'lesson_help')->count() }}</span>
                    </a>
                    <a href="{{ route('ai.assistant', ['context' => 'general_question']) }}" 
                       class="flex items-center justify-between p-2 rounded-lg {{ request('context') == 'general_question' ? 'bg-brand/20 border border-brand/30' : 'hover:bg-gray-800 border border-gray-700' }} transition-all">
                        <span class="text-sm {{ request('context') == 'general_question' ? 'text-white' : 'text-gray-300' }}">Questions générales</span>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-gray-800 text-gray-300">{{ $conversations->where('context', 'general_question')->count() }}</span>
                    </a>
                </div>
            </div>

            <!-- Informations IA -->
            <div class="bg-gradient-to-r from-brand/10 to-cyan-400/10 border border-brand/20 rounded-2xl p-4">
                <h4 class="text-base font-bold text-white mb-2">ℹ️ À propos</h4>
                <ul class="space-y-2 text-xs text-gray-300">
                    <li class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 bg-brand rounded-full"></div>
                        <span>Spécialisé programme RDC</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 bg-cyan-400 rounded-full"></div>
                        <span>Données pédagogiques vérifiées</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></div>
                        <span>Adapté niveau secondaire</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentConversationId = {{ isset($conversation) ? $conversation->id : 'null' }};

    function sendMessage(event) {
        event.preventDefault();
        
        console.log('=== DÉBUT ENVOI MESSAGE ===');
        
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        const sendBtn = document.getElementById('send-btn');
        const messagesContainer = document.getElementById('chat-messages');
        
        console.log('Message:', message);
        
        if (!message) {
            console.error('Message vide');
            return;
        }
        
        // Désactiver le bouton
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<span>Envoi...</span><svg class="animate-spin h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        
        // Ajouter le message utilisateur immédiatement
        const userHtml = `
            <div class="flex items-start justify-end animate-fade-in">
                <div class="flex-1 max-w-3xl">
                    <div class="bg-gradient-to-r from-brand to-cyan-500 text-white rounded-2xl p-3">
                        <p class="text-sm font-medium">${escapeHtml(message)}</p>
                    </div>
                    <div class="text-xs text-gray-500 mt-1 text-right">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                </div>
                <div class="flex-shrink-0 ml-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-cyan-400 to-emerald-500 flex items-center justify-center">
                        <span class="text-xs font-bold text-white">VO</span>
                    </div>
                </div>
            </div>
        `;
        messagesContainer.insertAdjacentHTML('beforeend', userHtml);
        
        input.value = '';
        updateCharCount();
        input.style.height = 'auto';
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        
        // Envoyer à l'API
        const url = '{{ route("ai.ask") }}';
        console.log('URL:', url);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                message: message,
                context: 'general_question',
                conversation_id: currentConversationId
            })
        })
        .then(response => {
            console.log('Status HTTP:', response.status);
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Erreur serveur:', text.substring(0, 500));
                    throw new Error('Erreur ' + response.status);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Données reçues:', data);
            
            if (data.success && data.response) {
                // Réponse IA
                const aiHtml = `
                    <div class="flex items-start animate-fade-in">
                        <div class="flex-shrink-0 mr-2">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-brand to-cyan-400 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 max-w-3xl">
                            <div class="bg-gray-800/50 border border-gray-700 rounded-2xl p-3">
                                <div class="prose prose-invert max-w-none text-gray-300 text-sm">
                                    ${formatResponse(data.response)}
                                </div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                ${data.processing_time ? `• ${data.processing_time}ms` : ''}
                            </div>
                        </div>
                    </div>
                `;
                messagesContainer.insertAdjacentHTML('beforeend', aiHtml);
                
                if (data.conversation_id) {
                    currentConversationId = data.conversation_id;
                    console.log('Nouveau conversation_id:', currentConversationId);
                }
            } else {
                throw new Error(data.message || 'Réponse invalide du serveur');
            }
        })
        .catch(error => {
            console.error('ERREUR:', error);
            const errorHtml = `
                <div class="flex items-start animate-fade-in">
                    <div class="flex-shrink-0 mr-2">
                        <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-3">
                            <p class="text-red-300 text-sm">Erreur: ${escapeHtml(error.message)}</p>
                            <button onclick="location.reload()" class="text-xs text-red-400 underline mt-1">Recharger la page</button>
                        </div>
                    </div>
                </div>
            `;
            messagesContainer.insertAdjacentHTML('beforeend', errorHtml);
        })
        .finally(() => {
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<span>Envoyer</span><svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>';
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        });
    }

    function clearChat() {
        if (confirm('Nouvelle conversation ?')) {
            currentConversationId = null;
            window.location.href = '{{ route("ai.assistant") }}';
        }
    }

    function suggestQuestion(question) {
        document.getElementById('chat-input').value = question;
        document.getElementById('chat-input').focus();
        updateCharCount();
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatResponse(text) {
        if (!text) return '';
        
        // Échapper d'abord
        let formatted = escapeHtml(text);
        
        // Formater le markdown
        formatted = formatted
            .replace(/\n/g, '<br>')
            .replace(/\*\*(.*?)\*\*/g, '<strong class="text-white">$1</strong>')
            .replace(/\*(.*?)\*/g, '<em class="text-cyan-300">$1</em>')
            .replace(/### (.*?)<br>/g, '<h3 class="text-base font-bold text-white mt-3 mb-1">$1</h3>')
            .replace(/## (.*?)<br>/g, '<h2 class="text-lg font-bold text-white mt-4 mb-2">$1</h2>')
            .replace(/# (.*?)<br>/g, '<h1 class="text-xl font-bold text-white mt-5 mb-2">$1</h1>')
            .replace(/\- (.*?)<br>/g, '<div class="flex items-start gap-2 mb-1"><span class="text-brand mt-1">•</span><span>$1</span></div>');
        
        return formatted;
    }

    function updateCharCount() {
        const input = document.getElementById('chat-input');
        const count = document.getElementById('char-count');
        count.textContent = input.value.length;
        count.classList.toggle('text-red-500', input.value.length > 1800);
    }

    // Auto-resize
    document.getElementById('chat-input').addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        updateCharCount();
    });

    updateCharCount();
</script>

<style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .prose-invert { color: #d1d5db; }
    .prose-invert strong { color: white; }
</style>
@endpush
@endsection