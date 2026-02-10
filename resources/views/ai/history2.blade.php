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
                        {{ $conversations->count() > 0 ? round($conversations->sum('tokens_used') / 1000, 1) : 0 }}k
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
                {{-- le code de vue que tu viens de me donner, je le met ici ? --}}
                {{-- <div id="chat-messages" class="flex-1 overflow-y-auto p-6 space-y-6 bg-gray-900">
                    <!-- Message de bienvenue -->
                    <div class="flex items-start animate-fade-in">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-brand to-cyan-400 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="bg-gray-800/50 border border-gray-700 rounded-2xl p-6">
                                <p class="text-white text-lg font-semibold mb-3">👋 Bonjour ! Je suis votre assistant en chimie</p>
                                <p class="text-gray-300 mb-4">
                                    Je suis spécialisé dans le programme national de chimie de la RDC. 
                                    Posez-moi des questions sur :
                                </p>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="flex items-center gap-2 text-sm text-gray-400">
                                        <div class="w-2 h-2 bg-brand rounded-full"></div>
                                        <span>Les concepts chimiques</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-gray-400">
                                        <div class="w-2 h-2 bg-cyan-400 rounded-full"></div>
                                        <span>Les exercices et problèmes</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-gray-400">
                                        <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                        <span>Les réactions et équations</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-gray-400">
                                        <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                        <span>Le tableau périodique</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <!-- Zone des messages -->
<div id="chat-messages" class="flex-1 overflow-y-auto p-6 space-y-6 bg-gray-900">
    @if(isset($conversation))
        <!-- Afficher une conversation existante -->
        <div class="flex items-start justify-end animate-fade-in">
            <div class="flex-1 max-w-3xl">
                <div class="bg-gradient-to-r from-brand to-cyan-500 text-white rounded-2xl p-6">
                    <p class="font-medium">{{ $conversation->user_message }}</p>
                </div>
                <div class="text-xs text-gray-500 mt-2 text-right">
                    {{ $conversation->created_at->format('H:i') }}
                </div>
            </div>
            <div class="flex-shrink-0 ml-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-cyan-400 to-emerald-500 flex items-center justify-center">
                    <span class="text-sm font-bold text-white">VO</span>
                </div>
            </div>
        </div>

        <div class="flex items-start animate-fade-in">
            <div class="flex-shrink-0 mr-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-brand to-cyan-400 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
            </div>
            <div class="flex-1 max-w-3xl">
                <div class="bg-gray-800/50 border border-gray-700 rounded-2xl p-6">
                    <div class="prose prose-invert max-w-none text-gray-300">
                        {!! nl2br(e($conversation->ai_response)) !!}
                    </div>
                </div>
                <div class="text-xs text-gray-500 mt-2">
                    {{ $conversation->created_at->format('H:i') }}
                </div>
            </div>
        </div>
    @else
        <!-- Message de bienvenue -->
        <div class="flex items-start animate-fade-in">
            <div class="flex-shrink-0 mr-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-brand to-cyan-400 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <div class="bg-gray-800/50 border border-gray-700 rounded-2xl p-6">
                    <p class="text-white text-lg font-semibold mb-3">👋 Bonjour ! Je suis votre assistant en chimie</p>
                    <p class="text-gray-300 mb-4">
                        Je suis spécialisé dans le programme national de chimie de la RDC. 
                        Posez-moi des questions sur :
                    </p>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <div class="w-2 h-2 bg-brand rounded-full"></div>
                            <span>Les concepts chimiques</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <div class="w-2 h-2 bg-cyan-400 rounded-full"></div>
                            <span>Les exercices et problèmes</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                            <span>Les réactions et équations</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                            <span>Le tableau périodique</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

                <!-- Zone de saisie -->
                <div class="border-t border-gray-800 bg-gray-900 p-6">
                    <form id="chat-form" onsubmit="sendMessage(event)" class="space-y-4">
                        <div class="relative">
                            <textarea 
                                id="chat-input" 
                                rows="3" 
                                class="w-full bg-gray-800 border border-gray-700 rounded-xl p-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent resize-none"
                                placeholder="Posez votre question sur la chimie... Ex: 'Expliquez-moi la loi des gaz parfaits'"
                                maxlength="2000"
                                required
                            ></textarea>
                            <div class="absolute bottom-3 right-3 text-xs text-gray-500">
                                <span id="char-count">0</span>/2000
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <button 
                                    type="button" 
                                    onclick="suggestQuestion('Expliquez-moi la différence entre un acide et une base')"
                                    class="px-4 py-2 bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-300 rounded-lg transition-colors text-sm"
                                >
                                    💡 Question suggérée
                                </button>
                                <button 
                                    type="button" 
                                    onclick="suggestQuestion('Donnez-moi un exercice sur les moles')"
                                    class="px-4 py-2 bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-300 rounded-lg transition-colors text-sm"
                                >
                                    🧪 Exercice
                                </button>
                            </div>
                            
                            <button 
                                type="submit" 
                                id="send-btn"
                                class="px-6 py-3 bg-gradient-to-r from-brand to-cyan-500 text-white font-bold rounded-lg hover:opacity-90 transition-opacity flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span>Envoyer à l'IA</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="text-center text-xs text-gray-500">
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
                <div class="bg-gradient-to-r from-brand/20 to-brand/10 border-b border-gray-800 p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white">📚 Historique récent</h3>
                        <span class="text-xs text-gray-400">{{ $conversations->count() }} conversations</span>
                    </div>
                </div>
                
                <div class="overflow-y-auto" style="max-height: 400px;">
                    @if($conversations->count() > 0)
                        <div class="divide-y divide-gray-800">
                            @foreach($conversations->take(8) as $conversation)
                                <div class="p-4 hover:bg-gray-800/50 transition cursor-pointer group" onclick="loadConversation({{ $conversation->id }})">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-brand/20 to-cyan-400/20 flex items-center justify-center">
                                                @if($conversation->context == 'lesson_help')
                                                    <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-white group-hover:text-brand transition-colors truncate">
                                                {{ Str::limit($conversation->user_message, 60) }}
                                            </p>
                                            <div class="flex items-center gap-2 mt-2">
                                                <span class="text-xs px-2 py-1 rounded-full bg-gray-800 text-gray-400">
                                                    {{ $conversation->created_at->diffForHumans() }}
                                                </span>
                                                @if($conversation->lesson)
                                                    <span class="text-xs px-2 py-1 rounded-full bg-brand/20 text-brand">
                                                        {{ Str::limit($conversation->lesson->title, 15) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-600 group-hover:text-brand transition-colors flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($conversations->count() > 8)
                            <div class="p-4 text-center border-t border-gray-800">
                                <a href="{{ route('ai.history') }}" class="text-sm text-brand hover:text-cyan-400 transition-colors inline-flex items-center gap-1">
                                    Voir tout l'historique
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="p-8 text-center">
                            <div class="w-16 h-16 mx-auto rounded-full bg-gray-800 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                            </div>
                            <p class="text-gray-400">
                                Aucune conversation encore
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Commencez par poser une question à l'IA !
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Filtres rapides -->
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
                <h4 class="text-lg font-bold text-white mb-4">🔍 Filtrer par type</h4>
                <div class="space-y-3">
                    <a href="{{ route('ai.history') }}" 
                       class="flex items-center justify-between p-3 rounded-xl {{ !request()->has('context') ? 'bg-brand/20 border border-brand/30' : 'hover:bg-gray-800 border border-gray-700' }} transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-gray-700 to-gray-600 flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <span class="font-medium {{ !request()->has('context') ? 'text-white' : 'text-gray-300' }}">Toutes</span>
                        </div>
                        <span class="text-sm px-2 py-1 rounded-full bg-gray-800 text-gray-300">
                            {{ $conversations->total() }}
                        </span>
                    </a>
                    
                    <a href="{{ route('ai.history', ['context' => 'lesson_help']) }}" 
                       class="flex items-center justify-between p-3 rounded-xl {{ request('context') == 'lesson_help' ? 'bg-brand/20 border border-brand/30' : 'hover:bg-gray-800 border border-gray-700' }} transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-brand/20 to-blue-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <span class="font-medium {{ request('context') == 'lesson_help' ? 'text-white' : 'text-gray-300' }}">Aide aux leçons</span>
                        </div>
                        <span class="text-sm px-2 py-1 rounded-full bg-gray-800 text-gray-300">
                            {{ $conversations->where('context', 'lesson_help')->count() }}
                        </span>
                    </a>
                    
                    <a href="{{ route('ai.history', ['context' => 'general_question']) }}" 
                       class="flex items-center justify-between p-3 rounded-xl {{ request('context') == 'general_question' ? 'bg-brand/20 border border-brand/30' : 'hover:bg-gray-800 border border-gray-700' }} transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-cyan-400/20 to-emerald-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="font-medium {{ request('context') == 'general_question' ? 'text-white' : 'text-gray-300' }}">Questions générales</span>
                        </div>
                        <span class="text-sm px-2 py-1 rounded-full bg-gray-800 text-gray-300">
                            {{ $conversations->where('context', 'general_question')->count() }}
                        </span>
                    </a>
                </div>
            </div>

            <!-- Informations IA -->
            <div class="bg-gradient-to-r from-brand/10 to-cyan-400/10 border border-brand/20 rounded-2xl p-6">
                <h4 class="text-lg font-bold text-white mb-3">ℹ️ À propos de l'IA</h4>
                <ul class="space-y-3">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-brand mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-300">Spécialisé dans le programme RDC</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-brand mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-300">Données pédagogiques vérifiées</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-brand mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-300">Adapté au niveau secondaire</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentConversationId = null;

    function sendMessage(event) {
        event.preventDefault();
        
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        const sendBtn = document.getElementById('send-btn');
        const messagesContainer = document.getElementById('chat-messages');
        
        if (!message) return;
        
        // Désactiver le bouton
        sendBtn.disabled = true;
        sendBtn.innerHTML = `
            <span>Envoi à l'IA</span>
            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        `;
        
        // Ajouter le message de l'utilisateur
        messagesContainer.innerHTML += `
            <div class="flex items-start justify-end animate-fade-in">
                <div class="flex-1 max-w-3xl">
                    <div class="bg-gradient-to-r from-brand to-cyan-500 text-white rounded-2xl p-6">
                        <p class="font-medium">${escapeHtml(message)}</p>
                    </div>
                    <div class="text-xs text-gray-500 mt-2 text-right">
                        ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                    </div>
                </div>
                <div class="flex-shrink-0 ml-4">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-cyan-400 to-emerald-500 flex items-center justify-center">
                        <span class="text-sm font-bold text-white">VO</span>
                    </div>
                </div>
            </div>
        `;
        
        // Réinitialiser le textarea
        input.value = '';
        updateCharCount();
        input.style.height = 'auto';
        
        // Faire défiler vers le bas
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        
        // Envoyer à l'API
        fetch('{{ route("ai.ask") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                message: message,
                context: 'general_question',
                conversation_id: currentConversationId
            })
        })
        .then(response => {
            if (!response.ok) throw new Error('Erreur réseau');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Ajouter la réponse de l'IA
                messagesContainer.innerHTML += `
                    <div class="flex items-start animate-fade-in">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-brand to-cyan-400 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 max-w-3xl">
                            <div class="bg-gray-800/50 border border-gray-700 rounded-2xl p-6">
                                <div class="prose prose-invert max-w-none text-gray-300">
                                    ${formatResponse(data.response)}
                                </div>
                            </div>
                            <div class="text-xs text-gray-500 mt-2">
                                ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                            </div>
                        </div>
                    </div>
                `;
                
                if (data.conversation_id) {
                    currentConversationId = data.conversation_id;
                }
            } else {
                throw new Error(data.message || 'Erreur inconnue');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            messagesContainer.innerHTML += `
                <div class="flex items-start animate-fade-in">
                    <div class="flex-shrink-0 mr-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-red-500 to-pink-500 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-6">
                            <p class="text-red-300 font-medium">Désolé, une erreur s'est produite</p>
                            <p class="text-red-400/80 text-sm mt-1">Veuillez réessayer dans quelques instants</p>
                        </div>
                    </div>
                </div>
            `;
        })
        .finally(() => {
            sendBtn.disabled = false;
            sendBtn.innerHTML = `
                <span>Envoyer à l'IA</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            `;
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        });
    }

    function clearChat() {
        if (confirm('Voulez-vous vraiment commencer une nouvelle conversation ?')) {
            currentConversationId = null;
            document.getElementById('chat-messages').innerHTML = `
                <div class="flex items-start animate-fade-in">
                    <div class="flex-shrink-0 mr-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-brand to-cyan-400 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="bg-gray-800/50 border border-gray-700 rounded-2xl p-6">
                            <p class="text-white text-lg font-semibold mb-3">🔄 Nouvelle conversation !</p>
                            <p class="text-gray-300">
                                Je suis prêt à répondre à vos questions sur la chimie. 
                                Que souhaitez-vous apprendre aujourd'hui ?
                            </p>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    function loadConversation(id) {
        window.location.href = \`{{ url('ai/conversation') }}/\${id}\`;
    }

    function suggestQuestion(question) {
        document.getElementById('chat-input').value = question;
        document.getElementById('chat-input').focus();
        updateCharCount();
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatResponse(text) {
        return text
            .replace(/\n/g, '<br>')
            .replace(/\*\*(.*?)\*\*/g, '<strong class="text-white">$1</strong>')
            .replace(/\*(.*?)\*/g, '<em class="text-cyan-300">$1</em>')
            .replace(/### (.*?)(?:\n|$)/g, '<h3 class="text-xl font-bold text-white mt-4 mb-2">$1</h3>')
            .replace(/## (.*?)(?:\n|$)/g, '<h2 class="text-2xl font-bold text-white mt-6 mb-3">$1</h2>')
            .replace(/# (.*?)(?:\n|$)/g, '<h1 class="text-3xl font-bold text-white mt-8 mb-4">$1</h1>')
            .replace(/\- (.*?)(?:\n|$)/g, '<li class="flex items-start gap-2 mb-1"><span class="text-brand mt-2">•</span><span>$1</span></li>')
            .replace(/\d+\. (.*?)(?:\n|$)/g, '<li class="mb-1">$1</li>');
    }

    // Compteur de caractères
    function updateCharCount() {
        const input = document.getElementById('chat-input');
        const charCount = document.getElementById('char-count');
        charCount.textContent = input.value.length;
        
        if (input.value.length > 1800) {
            charCount.classList.add('text-red-500');
        } else {
            charCount.classList.remove('text-red-500');
        }
    }

    // Auto-resize textarea
    document.getElementById('chat-input').addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 150) + 'px';
        updateCharCount();
    });

    // Initialiser le compteur
    updateCharCount();
</script>

<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }
    
    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(20px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }

    .prose-invert {
        color: #d1d5db;
    }
    
    .prose-invert strong {
        color: white;
    }
    
    .prose-invert code {
        background-color: rgba(59, 130, 246, 0.2);
        color: #93c5fd;
        padding: 0.2em 0.4em;
        border-radius: 0.25rem;
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
    }
    
    .prose-invert ul, .prose-invert ol {
        margin-top: 1em;
        margin-bottom: 1em;
    }
</style>
@endpush
@endsection