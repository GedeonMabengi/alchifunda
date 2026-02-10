@extends('layouts.app')

@section('title', 'Historique des conversations IA - ALCHIFUNDA')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Historique des conversations IA</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Retrouvez toutes vos interactions avec notre assistant IA
                </p>
            </div>
            
            <div class="mt-4 md:mt-0">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $conversations->total() }} conversation(s)
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl shadow p-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
            <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Filtrer :</span>
                <div class="flex space-x-2">
                    <a href="{{ route('ai.history') }}" 
                       class="px-3 py-1 rounded-full text-sm {{ !request()->has('context') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                        Toutes
                    </a>
                    <a href="{{ route('ai.history', ['context' => 'lesson_help']) }}" 
                       class="px-3 py-1 rounded-full text-sm {{ request('context') == 'lesson_help' ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                        Aide aux leçons
                    </a>
                    <a href="{{ route('ai.history', ['context' => 'general_question']) }}" 
                       class="px-3 py-1 rounded-full text-sm {{ request('context') == 'general_question' ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                        Questions générales
                    </a>
                    <a href="{{ route('ai.history', ['context' => 'feedback']) }}" 
                       class="px-3 py-1 rounded-full text-sm {{ request('context') == 'feedback' ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                        Feedback
                    </a>
                </div>
            </div>
            
            @if(request()->has('lesson_id'))
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Filtre : Leçon spécifique
                </div>
            @endif
        </div>
    </div>

    <!-- Liste des conversations -->
    @if($conversations->count() > 0)
        <div class="space-y-6">
            @foreach($conversations as $conversation)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- En-tête -->
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mr-3">
                                    <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <span class="font-medium text-gray-900 dark:text-white">
                                            @switch($conversation->context)
                                                @case('lesson_help')
                                                    Aide aux leçons
                                                    @break
                                                @case('general_question')
                                                    Question générale
                                                    @break
                                                @case('feedback')
                                                    Feedback
                                                    @break
                                            @endswitch
                                        </span>
                                        @if($conversation->lesson)
                                            <span class="mx-2 text-gray-400">•</span>
                                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $conversation->lesson->title }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-500">
                                        {{ $conversation->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                            
                            @if($conversation->lesson)
                                <a href="{{ route('lesson.show', ['chapterSlug' => $conversation->lesson->chapter->slug, 'lessonSlug' => $conversation->lesson->slug]) }}" 
                                   class="mt-2 sm:mt-0 inline-flex items-center text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                                    Voir la leçon
                                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Contenu -->
                    <div class="p-6">
                        <!-- Question utilisateur -->
                        <div class="mb-6">
                            <div class="flex items-start mb-3">
                                <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-3">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">VO</span>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Vous avez demandé :</div>
                                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                        <p class="text-gray-900 dark:text-white">{{ $conversation->user_message }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Réponse IA -->
                        <div>
                            <div class="flex items-start">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mr-3">
                                    <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Réponse de l'IA :</div>
                                    <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-4 border border-indigo-100 dark:border-indigo-800">
                                        <div class="prose prose-indigo dark:prose-invert max-w-none">
                                            {!! nl2br(e($conversation->ai_response)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($conversations->hasPages())
            <div class="mt-8">
                {{ $conversations->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-16">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
            <h3 class="mt-6 text-lg font-medium text-gray-900 dark:text-white">Aucune conversation</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Vous n'avez pas encore interagi avec notre assistant IA.
            </p>
            <div class="mt-6">
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Revenir au tableau de bord
                </a>
            </div>
        </div>
    @endif

    <!-- Statistiques -->
    @if($conversations->count() > 0)
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $conversations->where('context', 'lesson_help')->count() }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Aides aux leçons</div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $conversations->where('context', 'general_question')->count() }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Questions générales</div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $conversations->where('context', 'feedback')->count() }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Feedback</div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection