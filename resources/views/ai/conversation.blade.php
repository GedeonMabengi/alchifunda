@extends('layouts.app')

@section('title', 'Conversation - ALCHIFUNDA')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    
    {{-- En-tête --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Conversation</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $conversation->created_at->format('d/m/Y à H:i') }}
            </p>
        </div>
        <a href="{{ route('ai.assistant') }}" 
           class="text-indigo-600 dark:text-indigo-400 hover:underline">
            ← Retour à l'assistant
        </a>
    </div>

    {{-- Messages --}}
    <div class="space-y-6">
        {{-- Message utilisateur --}}
        <div class="flex justify-end">
            <div class="max-w-3xl">
                <div class="bg-indigo-600 text-white rounded-lg py-3 px-4">
                    <p>{{ $conversation->user_message }}</p>
                </div>
                <div class="text-right text-xs text-gray-500 mt-1">
                    Vous • {{ $conversation->created_at->format('H:i') }}
                </div>
            </div>
        </div>

        {{-- Réponse IA --}}
        <div class="flex justify-start">
            <div class="max-w-3xl">
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg py-3 px-4 prose dark:prose-invert max-w-none">
                    {!! Str::markdown($conversation->ai_response) !!}
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    Assistant IA
                </div>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="mt-8 flex gap-4">
        <a href="{{ route('ai.assistant', ['conversation_id' => $conversation->id]) }}" 
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
            Continuer cette conversation
        </a>
        <a href="{{ route('ai.assistant') }}" 
           class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white px-4 py-2 rounded-lg transition">
            Nouvelle conversation
        </a>
    </div>
</div>
@endsection