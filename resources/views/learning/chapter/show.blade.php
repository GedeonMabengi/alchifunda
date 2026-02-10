@extends('layouts.app')

@section('title', $chapter->title . ' - ALCHIFUNDA')

@section('page-title', $chapter->title)
@section('page-subtitle', $chapter->level->name)

@section('content')
<div class="space-y-8">
    {{-- Fil d'Ariane --}}
    <nav class="flex items-center text-sm text-gray-400 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Tableau de bord</a>
        <svg class="w-4 h-4 mx-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('level.index') }}" class="hover:text-white transition-colors">Niveaux</a>
        <svg class="w-4 h-4 mx-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-white">{{ $chapter->title }}</span>
    </nav>

    {{-- En-tête du chapitre --}}
    <div class="bg-linear-to-r from-brand/20 to-cyan-400/20 border border-brand/30 rounded-2xl p-8">
        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-8">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-3 py-1 rounded-full bg-black/30 text-sm font-medium text-brand">
                        {{ $chapter->level->name }}
                    </span>
                    <span class="text-sm text-gray-400">Chapitre {{ $chapter->order }}</span>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">{{ $chapter->title }}</h1>
                
                @if($chapter->subtitle)
                    <p class="text-xl text-gray-300 mb-6">{{ $chapter->subtitle }}</p>
                @endif
                
                @if($chapter->description)
                    <p class="text-gray-300 leading-relaxed">{{ $chapter->description }}</p>
                @endif
            </div>
            
            {{-- Statistiques du chapitre --}}
            <div class="lg:w-80 space-y-4">
                @php
                    $totalLessons = $chapter->lessons->count();
                    $completedLessons = $chapter->lessons->where('user_status', 'completed')->count();
                    $progressPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                @endphp
                
                <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">📊 Progression du chapitre</h3>
                    
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-400">Avancement</span>
                            <span class="text-lg font-bold text-white">{{ $progressPercentage }}%</span>
                        </div>
                        <div class="w-full h-3 bg-gray-800 rounded-full overflow-hidden">
                            <div class="h-full bg-linear-to-r from-brand to-cyan-400 transition-all duration-1000" 
                                 style="width: {{ $progressPercentage }}%"></div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ $totalLessons }}</div>
                            <div class="text-xs text-gray-400">Leçons</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ $completedLessons }}</div>
                            <div class="text-xs text-gray-400">Terminées</div>
                        </div>
                    </div>
                </div>
                
                {{-- Informations rapides --}}
                <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-4">
                    <div class="space-y-3">
                        @if($chapter->estimated_duration_hours)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400">Durée estimée</span>
                                <span class="text-sm font-medium text-white">{{ $chapter->estimated_duration_hours }} heures</span>
                            </div>
                        @endif
                        
                        @if($chapter->difficulty)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400">Difficulté</span>
                                <span class="text-sm font-medium 
                                    {{ $chapter->difficulty == 'facile' ? 'text-emerald-400' : 
                                       ($chapter->difficulty == 'moyen' ? 'text-yellow-400' : 
                                       'text-red-400') }}">
                                    {{ ucfirst($chapter->difficulty) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Navigation entre chapitres --}}
    <div class="flex flex-col sm:flex-row justify-between gap-4">
        @if($previousChapter)
            <a href="{{ route('chapter.show', $previousChapter->slug) }}" 
               class="group flex-1 bg-gray-900 border border-gray-800 rounded-2xl p-5 hover:border-brand transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-gray-800 group-hover:bg-brand/20 flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-400 mb-1">Chapitre précédent</p>
                        <p class="font-medium text-white group-hover:text-brand transition-colors">{{ $previousChapter->title }}</p>
                    </div>
                </div>
            </a>
        @else
            <div class="flex-1"></div>
        @endif

        @if($nextChapter)
            <a href="{{ route('chapter.show', $nextChapter->slug) }}" 
               class="group flex-1 bg-gray-900 border border-gray-800 rounded-2xl p-5 hover:border-brand transition-all text-right">
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <p class="text-sm text-gray-400 mb-1">Chapitre suivant</p>
                        <p class="font-medium text-white group-hover:text-brand transition-colors">{{ $nextChapter->title }}</p>
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

    {{-- Liste des leçons --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
        <div class="bg-linear-to-r from-brand/20 to-cyan-400/20 border-b border-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">📚 Leçons du chapitre</h2>
                    <p class="text-gray-400 mt-1">
                        {{ $chapter->lessons->count() }} leçons disponibles
                    </p>
                </div>
                <div class="text-sm text-gray-400">
                    {{ $completedLessons }}/{{ $totalLessons }} terminées
                </div>
            </div>
        </div>
        
        <div class="divide-y divide-gray-800">
            @forelse($chapter->lessons as $lesson)
                <a href="{{ route('lesson.show', ['chapterSlug' => $chapter->slug, 'lessonSlug' => $lesson->slug]) }}" 
                   class="block p-6 hover:bg-gray-800/50 transition-colors group">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-4">
                            {{-- Statut de la leçon --}}
                            <div class="shrink-0">
                                @if($lesson->user_status == 'completed')
                                    <div class="w-10 h-10 rounded-full bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                @elseif($lesson->user_status == 'in_progress')
                                    <div class="w-10 h-10 rounded-full bg-brand/20 border border-brand/30 flex items-center justify-center">
                                        <div class="w-5 h-5 border-2 border-brand border-t-transparent rounded-full animate-spin"></div>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center">
                                        <span class="text-lg font-bold text-gray-400">{{ $lesson->order }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Contenu de la leçon --}}
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-bold text-white group-hover:text-brand transition-colors">
                                        {{ $lesson->title }}
                                    </h3>
                                    @if($lesson->difficulty)
                                        <span class="text-xs px-2 py-1 rounded-full 
                                            {{ $lesson->difficulty == 'facile' ? 'bg-emerald-500/20 text-emerald-400' : 
                                               ($lesson->difficulty == 'moyen' ? 'bg-yellow-500/20 text-yellow-400' : 
                                               'bg-red-500/20 text-red-400') }}">
                                            {{ ucfirst($lesson->difficulty) }}
                                        </span>
                                    @endif
                                </div>
                                
                                @if($lesson->description)
                                    <p class="text-sm text-gray-400 mb-3 line-clamp-2">
                                        {{ $lesson->description }}
                                    </p>
                                @endif
                                
                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $lesson->estimated_duration_minutes }} min
                                    </span>
                                    
                                    @if($lesson->user_status == 'in_progress')
                                        <span class="text-brand">
                                            {{ $lesson->user_progress }}% complété
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        {{-- Actions --}}
                        <div class="flex items-center gap-3">
                            @if($lesson->user_status == 'completed')
                                <span class="text-xs px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400">
                                    Terminée
                                </span>
                            @endif
                            
                            <svg class="w-5 h-5 text-gray-600 group-hover:text-brand transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                    </div>
                    
                    {{-- Barre de progression --}}
                    @if($lesson->user_status == 'in_progress')
                        <div class="mt-4 ml-14">
                            <div class="w-full h-2 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-linear-to-r from-brand to-cyan-400" 
                                     style="width: {{ $lesson->user_progress }}%"></div>
                            </div>
                        </div>
                    @endif
                </a>
            @empty
                <div class="p-8 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-gray-800 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Aucune leçon disponible</h3>
                    <p class="text-gray-400">Les leçons seront bientôt ajoutées à ce chapitre.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Ressources additionnelles --}}
    @if($chapter->learning_objectives || $chapter->prerequisites)
        <div class="grid md:grid-cols-2 gap-6">
            @if($chapter->learning_objectives)
                <div class="bg-gray-900 border border-cyan-500/30 rounded-2xl overflow-hidden">
                    <div class="bg-linear-to-r from-cyan-500/20 to-cyan-600/20 border-b border-cyan-500/30 p-6">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-cyan-500/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white">Objectifs d'apprentissage</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="prose prose-invert max-w-none">
                            @if(is_array($chapter->learning_objectives))
                                <ul class="space-y-2">
                                    @foreach($chapter->learning_objectives as $objective)
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-cyan-400 mt-1 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span class="text-gray-300">{{ $objective }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-300">{{ $chapter->learning_objectives }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if($chapter->prerequisites)
                <div class="bg-gray-900 border border-brand/30 rounded-2xl overflow-hidden">
                    <div class="bg-linear-to-r from-brand/20 to-blue-500/20 border-b border-brand/30 p-6">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-brand/20 flex items-center justify-center">
                                <svg class="w-4 h-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white">Prérequis recommandés</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="prose prose-invert max-w-none">
                            @if(is_array($chapter->prerequisites))
                                <ul class="space-y-2">
                                    @foreach($chapter->prerequisites as $prerequisite)
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-brand mt-1 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-gray-300">{{ $prerequisite }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-300">{{ $chapter->prerequisites }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    {{-- CTA pour commencer --}}
    @if($chapter->lessons->count() > 0)
        <div class="bg-linear-to-r from-brand/20 to-emerald-500/20 border border-brand/30 rounded-2xl p-8 text-center">
            <h3 class="text-2xl font-bold text-white mb-4">Prêt à commencer ce chapitre ?</h3>
            <p class="text-gray-300 mb-6">
                Commencez par la première leçon pour progresser dans votre apprentissage de la chimie.
            </p>
            @php
                $firstLesson = $chapter->lessons->sortBy('order')->first();
            @endphp
            <a href="{{ route('lesson.show', ['chapterSlug' => $chapter->slug, 'lessonSlug' => $firstLesson->slug]) }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-linear-to-r from-brand to-cyan-500 text-white font-bold rounded-full hover:scale-105 transition-transform pulse-glow">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Commencer la première leçon
            </a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .prose-invert {
        color: #d1d5db;
    }
    
    .prose-invert ul {
        list-style-type: none;
        padding-left: 0;
    }
</style>
@endpush