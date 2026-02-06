{{-- resources/views/learning/lesson/show.blade.php --}}
@extends('layouts.app')

@section('title', $lesson->title . ' - ' . $lesson->chapter->title)

@section('page-title', $lesson->title)
@section('page-subtitle', $lesson->chapter->title)

@section('content')
<div class="space-y-6">
    {{-- Fil d'Ariane --}}
    <nav class="flex items-center text-sm text-gray-400 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Tableau de bord</a>
        <svg class="w-4 h-4 mx-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('level.show', $level->code) }}" class="hover:text-white transition-colors">{{ $level->name }}</a>
        <svg class="w-4 h-4 mx-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('chapter.show', $lesson->chapter->slug) }}" class="hover:text-white transition-colors">{{ $lesson->chapter->title }}</a>
        <svg class="w-4 h-4 mx-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-white">{{ $lesson->title }}</span>
    </nav>

    {{-- En-tête de la leçon --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex-1">
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $lesson->title }}</h1>
                <div class="flex items-center flex-wrap gap-3">
                    <span class="inline-flex items-center gap-1 text-sm text-gray-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $lesson->estimated_duration_minutes }} min
                    </span>
                    
                    <span class="text-gray-500">•</span>
                    
                    <span class="text-sm px-3 py-1 rounded-full 
                        {{ $lesson->difficulty == 'facile' ? 'bg-emerald-500/20 text-emerald-400' : 
                          ($lesson->difficulty == 'moyen' ? 'bg-yellow-500/20 text-yellow-400' : 
                          'bg-red-500/20 text-red-400') }}">
                        {{ ucfirst($lesson->difficulty) }}
                    </span>
                </div>
            </div>
            
            {{-- Progression --}}
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm text-gray-400">Progression</p>
                    <div class="flex items-center gap-2">
                        <div class="w-32 h-2 bg-gray-800 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-brand to-cyan-400" 
                                 style="width: {{ $progress->progress_percentage }}%"></div>
                        </div>
                        <span class="text-sm font-bold text-white">{{ $progress->progress_percentage }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Contenu principal --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Introduction --}}
            @if($lesson->introduction)
                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-white">Introduction</h2>
                    </div>
                    <p class="text-gray-300 leading-relaxed">{{ $lesson->introduction }}</p>
                </div>
            @endif

            {{-- Contenu adapté par l'IA --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-full bg-brand/20 flex items-center justify-center">
                        <svg class="w-4 h-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-white">Contenu adapté par l'IA</h2>
                </div>
                <div class="prose prose-invert max-w-none text-gray-300">
                    {!! $adaptedContent !!}
                </div>
            </div>

            {{-- Démonstrations mathématiques --}}
            @if($lesson->math_demonstrations && is_array($lesson->math_demonstrations) && count($lesson->math_demonstrations) > 0)
                <div class="bg-gray-900 border border-blue-500/30 rounded-2xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500/20 to-blue-600/20 border-b border-blue-500/30 p-6">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-lg font-bold text-white">Démonstrations mathématiques</h2>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        @foreach($lesson->math_demonstrations as $demo)
                            <div class="bg-gray-800/50 border border-gray-700 rounded-xl p-5">
                                <h3 class="font-bold text-white mb-3">{{ $demo['title'] }}</h3>
                                <div class="bg-gray-900 border border-gray-700 rounded-lg p-4 mb-3">
                                    <p class="text-sm text-gray-400 mb-1">Formule :</p>
                                    <code class="text-lg font-mono text-brand">{{ $demo['formula'] }}</code>
                                </div>
                                <p class="text-gray-300 mb-3"><strong class="text-white">Explication :</strong> {{ $demo['explanation'] }}</p>
                                <div class="bg-gray-900/50 border border-cyan-500/30 rounded-lg p-4">
                                    <p class="text-sm text-cyan-400 mb-1">Exemple :</p>
                                    <p class="text-gray-300">{{ $demo['example'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Exemples pratiques --}}
            @if($lesson->practical_examples && is_array($lesson->practical_examples) && count($lesson->practical_examples) > 0)
                <div class="bg-gray-900 border border-emerald-500/30 rounded-2xl overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500/20 to-emerald-600/20 border-b border-emerald-500/30 p-6">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h2 class="text-lg font-bold text-white">Exemples pratiques</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($lesson->practical_examples as $example)
                                <div class="flex items-start gap-3 p-3 bg-gray-800/30 rounded-lg">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center mt-1">
                                        <svg class="w-3 h-3 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-300">{{ $example }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Mini-quiz intégré --}}
            @if($miniQuiz && $miniQuiz->questions->count() > 0)
                <div class="bg-gray-900 border border-yellow-500/30 rounded-2xl overflow-hidden" id="mini-quiz">
                    <div class="bg-gradient-to-r from-yellow-500/20 to-yellow-600/20 border-b border-yellow-500/30 p-6">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-yellow-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-lg font-bold text-white">Mini-quiz de vérification</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <form id="miniQuizForm" class="space-y-6">
                            @foreach($miniQuiz->questions as $index => $question)
                                <div class="bg-gray-800/50 border border-gray-700 rounded-xl p-5 question-block" data-question-id="{{ $question->id }}">
                                    <p class="font-bold text-white mb-4">{{ $index + 1 }}. {{ $question->question_text }}</p>
                                    
                                    @if($question->question_type == 'mcq' || $question->question_type == 'true_false')
                                        @if(is_array($question->options))
                                            <div class="space-y-3">
                                                @foreach($question->options as $key => $option)
                                                    <div class="flex items-center">
                                                        <input type="radio" 
                                                               name="question_{{ $question->id }}" 
                                                               id="q{{ $question->id }}_{{ $key }}" 
                                                               value="{{ $key }}"
                                                               class="hidden peer">
                                                        <label for="q{{ $question->id }}_{{ $key }}" 
                                                               class="flex-1 cursor-pointer p-3 border border-gray-700 rounded-lg peer-checked:border-brand peer-checked:bg-brand/10 peer-checked:text-white text-gray-300 hover:bg-gray-700/50 transition-all">
                                                            <div class="flex items-center gap-3">
                                                                <div class="w-6 h-6 rounded-full border-2 border-gray-600 peer-checked:border-brand flex items-center justify-center">
                                                                    <div class="w-3 h-3 rounded-full bg-brand hidden peer-checked:block"></div>
                                                                </div>
                                                                <span class="font-mono text-sm text-gray-400 mr-2">{{ $key }})</span>
                                                                <span>{{ $option }}</span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @else
                                        <div class="relative">
                                            <input type="text" 
                                                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent"
                                                   name="question_{{ $question->id }}" 
                                                   placeholder="Votre réponse...">
                                        </div>
                                    @endif
                                    
                                    <div class="feedback mt-4 hidden" id="feedback_{{ $question->id }}"></div>
                                </div>
                            @endforeach
                            
                            <div class="flex justify-center">
                                <button type="button" onclick="checkMiniQuiz()" 
                                        class="px-8 py-3 bg-gradient-to-r from-yellow-500 to-amber-500 text-white font-bold rounded-lg hover:opacity-90 transition-opacity">
                                    Vérifier mes réponses
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Résumé --}}
            @if($lesson->summary)
                <div class="bg-gray-900 border border-cyan-500/30 rounded-2xl overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-500/20 to-cyan-600/20 border-b border-cyan-500/30 p-6">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-cyan-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-lg font-bold text-white">Résumé</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-300 leading-relaxed">{{ $lesson->summary }}</p>
                    </div>
                </div>
            @endif

            {{-- Navigation entre leçons --}}
            <div class="flex flex-col sm:flex-row justify-between gap-4">
                @if($previousLesson)
                    <a href="{{ route('lesson.show', ['chapterSlug' => $lesson->chapter->slug, 'lessonSlug' => $previousLesson->slug]) }}" 
                       class="group flex-1 bg-gray-900 border border-gray-800 rounded-2xl p-5 hover:border-brand transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-gray-800 group-hover:bg-brand/20 flex items-center justify-center transition-colors">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-400 mb-1">Précédent</p>
                                <p class="font-medium text-white group-hover:text-brand transition-colors">{{ $previousLesson->title }}</p>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="flex-1"></div>
                @endif

                @if($nextLesson)
                    <a href="{{ route('lesson.show', ['chapterSlug' => $lesson->chapter->slug, 'lessonSlug' => $nextLesson->slug]) }}" 
                       class="group flex-1 bg-gray-900 border border-gray-800 rounded-2xl p-5 hover:border-brand transition-all text-right">
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <p class="text-sm text-gray-400 mb-1">Suivant</p>
                                <p class="font-medium text-white group-hover:text-brand transition-colors">{{ $nextLesson->title }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-gray-800 group-hover:bg-brand/20 flex items-center justify-center transition-colors">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="flex-1"></div>
                @endif
            </div>

            {{-- Bouton terminer la leçon --}}
            @if($progress->status != 'completed')
                <form action="{{ route('lesson.complete', $lesson->id) }}" method="POST" class="text-center">
                    @csrf
                    <button type="submit" 
                            class="px-8 py-4 bg-gradient-to-r from-emerald-500 to-green-500 text-white font-bold rounded-full hover:scale-105 transition-transform pulse-glow">
                        <div class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            J'ai terminé cette leçon
                        </div>
                    </button>
                    <p class="text-sm text-gray-400 mt-2">Marquer cette leçon comme terminée</p>
                </form>
            @else
                <div class="bg-gray-900 border border-emerald-500/30 rounded-2xl p-6 text-center">
                    <div class="flex items-center justify-center gap-2 mb-4">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white">Leçon terminée !</h3>
                    </div>
                    @if($lesson->assessments->where('type', 'end_lesson_control')->first())
                        <a href="{{ route('assessment.start', $lesson->assessments->where('type', 'end_lesson_control')->first()->id) }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-brand text-white font-bold rounded-lg hover:bg-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Passer le contrôle
                        </a>
                    @endif
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Chat IA --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden sticky top-6">
                <div class="bg-gradient-to-r from-brand/20 to-cyan-400/20 border-b border-gray-800 p-6">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-brand to-cyan-400 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white">Assistant IA</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div id="ai-chat-messages" class="mb-4 space-y-3" style="max-height: 300px; overflow-y: auto;">
                        <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-4">
                            <p class="text-sm text-gray-300 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Posez-moi des questions sur cette leçon !
                            </p>
                        </div>
                    </div>
                    <form id="ai-chat-form" onsubmit="askAI(event)" class="relative">
                        <input type="text" id="ai-question" 
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent pr-12"
                               placeholder="Votre question..." maxlength="1000" required>
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2 text-gray-400 hover:text-brand transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Informations sur la leçon --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
                <div class="border-b border-gray-800 p-6">
                    <h3 class="text-lg font-bold text-white">Informations</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Chapitre</span>
                        <span class="font-medium text-white">{{ $lesson->chapter->title }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Niveau</span>
                        <span class="font-medium text-white">{{ $level->name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Accès</span>
                        <span class="font-medium text-white">{{ $progress->access_count }} fois</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Temps passé</span>
                        <span class="font-medium text-white">{{ $progress->time_spent_minutes }} min</span>
                    </div>
                </div>
            </div>

            {{-- Mots-clés --}}
            @if($lesson->keywords && (is_array($lesson->keywords) ? count($lesson->keywords) > 0 : $lesson->keywords))
                <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
                    <div class="border-b border-gray-800 p-6">
                        <h3 class="text-lg font-bold text-white">Mots-clés</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-wrap gap-2">
                            @if(is_array($lesson->keywords))
                                @foreach($lesson->keywords as $keyword)
                                    <span class="px-3 py-1 bg-gray-800 text-gray-300 text-sm rounded-full">
                                        {{ $keyword }}
                                    </span>
                                @endforeach
                            @else
                                <span class="px-3 py-1 bg-gray-800 text-gray-300 text-sm rounded-full">
                                    {{ $lesson->keywords }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Scripts pour le mini-quiz et le chat IA --}}
@push('scripts')
<script>
    function checkMiniQuiz() {
        alert('Fonction de vérification à implémenter');
    }

    function askAI(event) {
        event.preventDefault();
        
        const question = document.getElementById('ai-question').value;
        const chatMessages = document.getElementById('ai-chat-messages');
        
        // Ajouter la question de l'utilisateur
        chatMessages.innerHTML += `
            <div class="flex justify-end">
                <div class="max-w-[80%] bg-brand/20 border border-brand/30 rounded-lg p-3">
                    <p class="text-sm text-white">${question}</p>
                </div>
            </div>
        `;
        
        // Afficher un indicateur de chargement
        const loadingId = 'loading-' + Date.now();
        chatMessages.innerHTML += `
            <div id="${loadingId}" class="flex">
                <div class="max-w-[80%] bg-gray-800/50 border border-gray-700 rounded-lg p-3">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse delay-150"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse delay-300"></div>
                    </div>
                </div>
            </div>
        `;
        
        // Faire défiler vers le bas
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        // Envoyer la requête
        fetch('{{ route("lesson.ask-ai", $lesson->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ question: question })
        })
        .then(response => response.json())
        .then(data => {
            // Supprimer l'indicateur de chargement
            document.getElementById(loadingId).remove();
            
            if(data.success) {
                // Ajouter la réponse de l'IA
                chatMessages.innerHTML += `
                    <div class="flex">
                        <div class="max-w-[80%] bg-gray-800/50 border border-gray-700 rounded-lg p-3">
                            <p class="text-sm text-gray-300">${data.response}</p>
                        </div>
                    </div>
                `;
            } else {
                // Afficher une erreur
                chatMessages.innerHTML += `
                    <div class="flex">
                        <div class="max-w-[80%] bg-red-500/20 border border-red-500/30 rounded-lg p-3">
                            <p class="text-sm text-red-300">${data.message || 'Une erreur est survenue'}</p>
                        </div>
                    </div>
                `;
            }
            
            // Réinitialiser le champ et faire défiler
            document.getElementById('ai-question').value = '';
            chatMessages.scrollTop = chatMessages.scrollHeight;
        })
        .catch(error => {
            console.error('Erreur:', error);
            document.getElementById(loadingId).remove();
            
            chatMessages.innerHTML += `
                <div class="flex">
                    <div class="max-w-[80%] bg-red-500/20 border border-red-500/30 rounded-lg p-3">
                        <p class="text-sm text-red-300">Erreur de connexion au serveur</p>
                    </div>
                </div>
            `;
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    }
</script>
@endpush
@endsection

@push('styles')
<style>
    .prose {
        color: #d1d5db;
    }
    .prose h1, .prose h2, .prose h3, .prose h4, .prose strong {
        color: white;
    }
    .prose a {
        color: #3b82f6;
    }
    .prose code {
        background-color: rgba(59, 130, 246, 0.1);
        color: #93c5fd;
        padding: 0.2em 0.4em;
        border-radius: 0.25rem;
    }
</style>
@endpush