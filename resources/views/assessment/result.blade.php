@extends('layouts.app')

@section('title', 'Résultat - ' . $result->assessment->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête du résultat -->
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center h-24 w-24 rounded-full 
            {{ $result->passed ? 'bg-green-100 dark:bg-green-900' : 'bg-red-100 dark:bg-red-900' }} 
            mb-6">
            @if($result->passed)
                <svg class="h-12 w-12 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            @else
                <svg class="h-12 w-12 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            @endif
        </div>
        
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
            {{ $result->passed ? '🎉 Félicitations !' : '😔 Presque !' }}
        </h1>
        
        <p class="text-xl text-gray-600 dark:text-gray-400 mb-6">
            {{ $result->passed ? 'Vous avez réussi l\'évaluation !' : 'Vous n\'avez pas atteint le score requis.' }}
        </p>
        
        <!-- Score principal -->
        <div class="inline-flex items-center px-6 py-3 rounded-full 
            {{ $result->passed ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 
               'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }} 
            text-2xl font-bold">
            {{ $result->percentage }}%
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $result->score }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Points obtenus</div>
                <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">sur {{ $result->assessment->questions->sum('points') }} points</div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ $result->attempt_number }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Tentative</div>
                <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">sur {{ $result->assessment->max_attempts }} maximum</div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    @if($result->time_taken_minutes)
                        {{ $result->time_taken_minutes }} min
                    @else
                        -
                    @endif
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Temps pris</div>
                <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                    @if($result->assessment->time_limit_minutes)
                        limite : {{ $result->assessment->time_limit_minutes }} min
                    @else
                        pas de limite
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Analyse par question -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Détail par question</h2>
        </div>
        
        <div class="p-6">
            <div class="space-y-6">
                @foreach($result->assessment->questions as $index => $question)
                    @php
                        $userAnswer = $result->answers[$question->id] ?? null;
                        $isCorrect = $userAnswer ? ($result->answers[$question->id]['correct'] ?? false) : false;
                        $pointsEarned = $userAnswer ? ($result->answers[$question->id]['points'] ?? 0) : 0;
                    @endphp
                    
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 
                        {{ $isCorrect ? 'bg-green-50 dark:bg-green-900/20' : 'bg-red-50 dark:bg-red-900/20' }}">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center">
                                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full 
                                    {{ $isCorrect ? 'bg-green-100 dark:bg-green-800 text-green-600 dark:text-green-300' : 
                                       'bg-red-100 dark:bg-red-800 text-red-600 dark:text-red-300' }} 
                                    font-bold mr-3">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $question->question_text }}</h3>
                                    <div class="flex items-center mt-1">
                                        <span class="text-xs px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            {{ $question->question_type }}
                                        </span>
                                        <span class="mx-2 text-gray-400">•</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $question->points }} point(s)</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <div class="text-lg font-bold 
                                    {{ $isCorrect ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $pointsEarned }}/{{ $question->points }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-500">
                                    {{ $isCorrect ? 'Correct' : 'Incorrect' }}
                                </div>
                            </div>
                        </div>

                        <!-- Réponses -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Votre réponse :</h4>
                                <div class="p-3 bg-white dark:bg-gray-800 rounded border 
                                    {{ $isCorrect ? 'border-green-200 dark:border-green-800' : 'border-red-200 dark:border-red-800' }}">
                                    <p class="text-gray-900 dark:text-white">
                                        @if($userAnswer && isset($userAnswer['answer']))
                                            {{ $userAnswer['answer'] }}
                                        @else
                                            <span class="text-gray-500 dark:text-gray-500">Non répondue</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Réponse correcte :</h4>
                                <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded border border-green-200 dark:border-green-800">
                                    <p class="text-gray-900 dark:text-white">{{ $question->correct_answer }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Explication IA -->
                        @if($result->questionAnswers->where('question_id', $question->id)->first()?->ai_explanation)
                            <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Explication :</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $result->questionAnswers->where('question_id', $question->id)->first()->ai_explanation }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Feedback IA -->
    @if($result->ai_feedback)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg mb-8">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Analyse de notre IA</h2>
            </div>
            
            <div class="p-6">
                <div class="flex">
                    <svg class="h-6 w-6 text-indigo-500 dark:text-indigo-400 flex-shrink-0 mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="prose prose-indigo dark:prose-invert max-w-none">
                        {!! nl2br(e($result->ai_feedback)) !!}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Recommandations -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-8 text-white mb-8">
        <h2 class="text-2xl font-bold mb-4">🎯 Recommandations</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold mb-2">Points forts :</h3>
                <ul class="space-y-1">
                    @if(count($result->strong_points) > 0)
                        @foreach($result->assessment->questions->whereIn('id', $result->strong_points)->take(3) as $question)
                            <li class="flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ Str::limit($question->question_text, 50) }}
                            </li>
                        @endforeach
                    @else
                        <li class="flex items-center">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Aucun point fort identifié
                        </li>
                    @endif
                </ul>
            </div>
            
            <div>
                <h3 class="font-semibold mb-2">À améliorer :</h3>
                <ul class="space-y-1">
                    @if(count($result->weak_points) > 0)
                        @foreach($result->assessment->questions->whereIn('id', $result->weak_points)->take(3) as $question)
                            <li class="flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                {{ Str::limit($question->question_text, 50) }}
                            </li>
                        @endforeach
                    @else
                        <li class="flex items-center">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Aucun point faible identifié
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        @if($result->assessment->lesson)
            <a href="{{ route('lesson.show', ['chapterSlug' => $result->assessment->lesson->chapter->slug, 'lessonSlug' => $result->assessment->lesson->slug]) }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Revoir la leçon
            </a>
        @endif
        
        @if(!$result->passed && $result->attempt_number < $result->assessment->max_attempts)
            <a href="{{ route('assessment.retry', $result->assessment->id) }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Réessayer
            </a>
        @endif
        
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            Retour au tableau de bord
            <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    </div>
</div>
@endsection