@extends('layouts.app')

@section('title', 'Assistant IA - ALCHIFUNDA')

@section('content')
<div class="flex h-[calc(100vh-4rem)]">
    
    {{-- Sidebar : Historique des conversations --}}
    <aside class="w-64 bg-gray-50 dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 overflow-y-auto">
        <div class="p-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Historique
            </h2>
            
            {{-- Nouvelle conversation --}}
            <a href="{{ route('ai.assistant') }}" 
               class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg mb-4 transition">
                + Nouvelle conversation
            </a>
            
            {{-- Liste des conversations --}}
            <div class="space-y-2">
                @forelse($conversations as $conv)
                    <a href="{{ route('ai.assistant', ['conversation_id' => $conv->id]) }}" 
                       class="block p-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition {{ request('conversation_id') == $conv->id ? 'bg-indigo-100 dark:bg-indigo-900' : '' }}">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                            {{ Str::limit($conv->user_message, 30) }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $conv->created_at->diffForHumans() }}
                        </p>
                    </a>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">
                        Aucune conversation
                    </p>
                @endforelse
            </div>
            
            {{-- Pagination --}}
            @if($conversations->hasPages())
                <div class="mt-4">
                    {{ $conversations->links() }}
                </div>
            @endif
        </div>
    </aside>

    {{-- Zone principale : Chat --}}
    <main class="flex-1 flex flex-col bg-white dark:bg-gray-900">
        
        {{-- Messages --}}
        <div id="chat-messages" class="flex-1 overflow-y-auto p-6 space-y-4">
            @if($conversation)
                {{-- Affiche la conversation active --}}
                <div class="flex justify-end">
                    <div class="bg-indigo-600 text-white rounded-lg py-2 px-4 max-w-2xl">
                        {{ $conversation->user_message }}
                    </div>
                </div>
                <div class="flex justify-start">
                    <div class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg py-2 px-4 max-w-2xl prose dark:prose-invert">
                        {!! Str::markdown($conversation->ai_response) !!}
                    </div>
                </div>
            @else
                {{-- Message de bienvenue --}}
                <div class="text-center py-12">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        Comment puis-je vous aider ?
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Posez vos questions sur la chimie, je suis là pour vous accompagner.
                    </p>
                </div>
            @endif
        </div>

        {{-- Zone de saisie --}}
        <div class="border-t border-gray-200 dark:border-gray-700 p-4">
            <form id="chat-form" class="flex gap-2">
                @csrf
                <input type="hidden" name="conversation_id" value="{{ $conversation?->id }}">
                
                <input type="text" 
                       name="message" 
                       id="message-input"
                       placeholder="Posez votre question..." 
                       class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                       required>
                
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition flex items-center gap-2">
                    <span>Envoyer</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
        </div>
    </main>
</div>

@push('scripts')
<script>
document.getElementById('chat-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const form = e.target;
    const input = document.getElementById('message-input');
    const messagesDiv = document.getElementById('chat-messages');
    const message = input.value;
    const conversationId = form.querySelector('[name="conversation_id"]').value;
    
    // Affiche le message utilisateur
    messagesDiv.innerHTML += `
        <div class="flex justify-end mb-4">
            <div class="bg-indigo-600 text-white rounded-lg py-2 px-4 max-w-2xl">
                ${escapeHtml(message)}
            </div>
        </div>
    `;
    
    input.value = '';
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
    
    try {
        const response = await fetch('{{ route("ai.ask") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                message: message,
                conversation_id: conversationId || null
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            messagesDiv.innerHTML += `
                <div class="flex justify-start mb-4">
                    <div class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg py-2 px-4 max-w-2xl prose dark:prose-invert">
                        ${marked.parse(data.response)}
                    </div>
                </div>
            `;
            
            if (!conversationId && data.conversation_id) {
                history.pushState(null, '', '{{ route("ai.assistant") }}?conversation_id=' + data.conversation_id);
            }
        } else {
            throw new Error(data.message);
        }
        
    } catch (error) {
        messagesDiv.innerHTML += `
            <div class="flex justify-center mb-4">
                <div class="bg-red-100 text-red-700 rounded-lg py-2 px-4">
                    Erreur: ${error.message}
                </div>
            </div>
        `;
    }
    
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
});

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
@endpush
@endsection