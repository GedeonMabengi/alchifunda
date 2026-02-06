{{-- resources/views/learning/lesson/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Toutes les leçons - ALCHIFUNDA')

@section('page-title', 'Bibliothèque des leçons')
@section('page-subtitle', 'Explorez toutes les leçons disponibles sur ALCHIFUNDA')

@section('content')
<div class="space-y-6">
    {{-- Barre de recherche et filtres --}}
    <div class="glass p-4 rounded-2xl">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="search" placeholder="Rechercher une leçon..."
                        class="w-full pl-10 pr-4 py-2 glass border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent text-white placeholder-gray-400">
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-400">Filtrer par :</span>
                <select class="glass border border-white/10 rounded-lg px-3 py-2 text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-brand">
                    <option value="all" class="text-white">Tous les niveaux</option>
                    <option value="6e">6ème</option>
                    <option value="5e">5ème</option>
                    <option value="4e">4ème</option>
                    <option value="3e">3ème</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Statistiques rapides --}}
    <div class="grid md:grid-cols-3 gap-4">
        <div class="glass p-4 rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-white">{{ $lessons->count() }}</p>
                    <p class="text-sm text-gray-400">Leçons disponibles</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-brand/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="glass p-4 rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-white">{{ $lessons->unique('chapter_id')->count() }}</p>
                    <p class="text-sm text-gray-400">Chapitres</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-cyan-400/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="glass p-4 rounded-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-white">
                        {{ $lessons->sum('estimated_duration_minutes') }} min
                    </p>
                    <p class="text-sm text-gray-400">Contenu total</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Liste des leçons groupées par chapitre --}}
    @foreach($lessons->groupBy('chapter.title') as $chapterTitle => $chapterLessons)
        <div class="glass rounded-2xl overflow-hidden">
            {{-- En-tête du chapitre --}}
            <div class="bg-gradient-to-r from-brand/30 to-brand/10 border-b border-white/10 p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-white">{{ $chapterTitle }}</h2>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="inline-flex items-center gap-1 text-sm text-gray-300">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                {{ $chapterLessons->first()->chapter->level->name ?? '' }}
                            </span>
                            <span class="text-sm text-gray-400">
                                {{ $chapterLessons->count() }} leçons
                            </span>
                        </div>
                    </div>
                    <div class="px-3 py-1 rounded-full bg-white/10 text-sm text-white">
                        Chapitre {{ $chapterLessons->first()->chapter->order ?? '' }}
                    </div>
                </div>
            </div>

            {{-- Liste des leçons --}}
            <div class="divide-y divide-white/10">
                @foreach($chapterLessons as $lesson)
                    <a href="{{ route('lesson.show', [
                        'chapterSlug' => $lesson->chapter->slug, 
                        'lessonSlug' => $lesson->slug
                    ]) }}" class="block p-6 hover:bg-white/5 transition-colors group">
                        <div class="flex justify-between items-center">
                            <div class="flex-1">
                                <div class="flex items-start gap-4">
                                    {{-- Numéro de la leçon avec style --}}
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-r from-brand to-cyan-400 flex items-center justify-center text-white font-bold">
                                        {{ $lesson->order }}
                                    </div>
                                    
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-white group-hover:text-brand transition-colors">
                                            {{ $lesson->title }}
                                        </h3>
                                        <div class="flex items-center gap-4 mt-2">
                                            {{-- Durée --}}
                                            <span class="inline-flex items-center gap-1 text-sm text-gray-400">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $lesson->estimated_duration_minutes }} min
                                            </span>
                                            
                                            {{-- Difficulté --}}
                                            <span class="inline-flex items-center gap-1 text-sm">
                                                @switch($lesson->difficulty)
                                                    @case('facile')
                                                        <span class="text-emerald-400">● Facile</span>
                                                        @break
                                                    @case('moyen')
                                                        <span class="text-yellow-400">● Moyen</span>
                                                        @break
                                                    @case('difficile')
                                                        <span class="text-red-400">● Difficile</span>
                                                        @break
                                                    @default
                                                        <span class="text-gray-400">● {{ $lesson->difficulty }}</span>
                                                @endswitch
                                            </span>
                                            
                                            {{-- Progression --}}
                                            @if($lesson->user_progress && $lesson->user_progress->is_completed)
                                                <span class="inline-flex items-center gap-1 text-sm text-emerald-400">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Complété
                                                </span>
                                            @elseif($lesson->user_progress && $lesson->user_progress->progress_percentage > 0)
                                                <span class="text-sm text-cyan-400">
                                                    {{ $lesson->user_progress->progress_percentage }}% complété
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Badge pour les leçons à venir --}}
                            @if(!$lesson->is_available)
                                <span class="px-3 py-1 rounded-full bg-gray-800 text-gray-400 text-sm">
                                    {{-- Bientôt disponible --}}
                                    .
                                </span>
                            @else
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-brand transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            @endif
                        </div>
                        
                        {{-- Description courte --}}
                        @if($lesson->description)
                            <p class="text-sm text-gray-400 mt-3 ml-14">
                                {{ Str::limit($lesson->description, 150) }}
                            </p>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach

    {{-- Pagination --}}
    @if($lessons instanceof \Illuminate\Pagination\LengthAwarePaginator && $lessons->hasPages())
        <div class="glass p-4 rounded-2xl">
            <div class="flex justify-center">
                <nav class="inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    {{-- Premier --}}
                    @if(!$lessons->onFirstPage())
                        <a href="{{ $lessons->url(1) }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-white/10 bg-gray-900 text-sm font-medium text-gray-300 hover:bg-white/5">
                            <span class="sr-only">Premier</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Précédent --}}
                    @if($lessons->previousPageUrl())
                        <a href="{{ $lessons->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 border border-white/10 bg-gray-900 text-sm font-medium text-gray-300 hover:bg-white/5">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Numéros de page --}}
                    @foreach($lessons->getUrlRange(max(1, $lessons->currentPage() - 2), min($lessons->lastPage(), $lessons->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 border border-white/10 text-sm font-medium {{ $page == $lessons->currentPage() ? 'bg-brand text-white' : 'bg-gray-900 text-gray-300 hover:bg-white/5' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    {{-- Suivant --}}
                    @if($lessons->nextPageUrl())
                        <a href="{{ $lessons->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 border border-white/10 bg-gray-900 text-sm font-medium text-gray-300 hover:bg-white/5">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Dernier --}}
                    @if($lessons->currentPage() < $lessons->lastPage())
                        <a href="{{ $lessons->url($lessons->lastPage()) }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-white/10 bg-gray-900 text-sm font-medium text-gray-300 hover:bg-white/5">
                            <span class="sr-only">Dernier</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endif
                </nav>
            </div>
        </div>
    @endif

    {{-- Message si pas de leçons --}}
    @if($lessons->isEmpty())
        <div class="glass rounded-2xl p-12 text-center">
            <div class="w-16 h-16 mx-auto rounded-full bg-white/5 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-white mb-2">Aucune leçon disponible</h3>
            <p class="text-gray-400">Les leçons seront bientôt ajoutées au système.</p>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .difficulty-badge {
        @apply px-2 py-1 rounded-full text-xs font-medium;
    }
    .difficulty-easy {
        @apply bg-emerald-500/20 text-emerald-400;
    }
    .difficulty-medium {
        @apply bg-yellow-500/20 text-yellow-400;
    }
    .difficulty-hard {
        @apply bg-red-500/20 text-red-400;
    }
</style>
@endpush