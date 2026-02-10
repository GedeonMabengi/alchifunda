@extends('layouts.app')

@section('title', 'Chapitres - ALCHIFUNDA')

@section('page-title', 'Bibliothèque des chapitres')
@section('page-subtitle', 'Explorez tous les chapitres de chimie')

@section('content')
<div class="space-y-8">
    {{-- Bannière d'en-tête --}}
    <div class="bg-gradient-to-r from-brand/20 to-cyan-400/20 border border-brand/30 rounded-2xl p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Chapitres de Chimie</h1>
                <p class="text-gray-300">
                    {{ $currentLevel ? 'Niveau : ' . $currentLevel->name : 'Tous les niveaux' }}
                </p>
                <div class="flex items-center gap-4 mt-4">
                    <div class="inline-flex items-center gap-2 bg-black/30 border border-white/10 px-3 py-1 rounded-full text-xs">
                        <svg class="w-4 h-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span class="text-gray-300">{{ $chapters->count() }} chapitres</span>
                    </div>
                    @php
                        $totalLessons = $chapters->sum('total_lessons');
                        $completedLessons = $chapters->sum('completed_lessons');
                    @endphp
                    <div class="inline-flex items-center gap-2 bg-black/30 border border-white/10 px-3 py-1 rounded-full text-xs">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-gray-300">{{ $completedLessons }}/{{ $totalLessons }} leçons terminées</span>
                    </div>
                </div>
            </div>
            
            {{-- Statistiques globales --}}
            <div class="flex items-center gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">{{ $chapters->count() }}</div>
                    <div class="text-xs text-gray-400">Chapitres</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">{{ $totalLessons }}</div>
                    <div class="text-xs text-gray-400">Leçons</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">
                        {{ $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0 }}%
                    </div>
                    <div class="text-xs text-gray-400">Progression</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtres par niveau --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-white mb-2">Filtrer par niveau</h3>
                <p class="text-sm text-gray-400">Sélectionnez un niveau pour voir ses chapitres</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('chapter.index') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all
                          {{ !request()->has('level') ? 'bg-brand text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                    Tous les niveaux
                </a>
                @foreach(['6e', '5e', '4e', '3e'] as $levelCode)
                    <a href="{{ route('chapter.by-level', $levelCode) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all
                              {{ request()->has('level') && request('level') == $levelCode ? 'bg-brand text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                        {{ $levelCode }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Liste des chapitres --}}
    @if($chapters->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($chapters as $chapter)
                <a href="{{ route('chapter.show', $chapter->slug) }}" 
                   class="group bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden hover:border-brand transition-all">
                    {{-- En-tête du chapitre --}}
                    <div class="relative p-6 bg-gradient-to-r from-brand/10 to-cyan-400/10 border-b border-gray-800">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="inline-block px-3 py-1 rounded-full bg-black/30 text-xs font-medium text-brand mb-2">
                                    {{ $chapter->level->name }}
                                </span>
                                <h3 class="text-xl font-bold text-white group-hover:text-brand transition-colors">
                                    {{ $chapter->title }}
                                </h3>
                                <p class="text-sm text-gray-400 mt-2">
                                    {{ $chapter->subtitle ?? 'Chapitre de chimie' }}
                                </p>
                            </div>
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-r from-brand to-cyan-400 flex items-center justify-center text-white font-bold text-lg">
                                {{ $chapter->order }}
                            </div>
                        </div>
                    </div>

                    {{-- Contenu du chapitre --}}
                    <div class="p-6">
                        {{-- Statistiques --}}
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-400">Progression</span>
                                <span class="text-sm font-bold text-white">{{ $chapter->progress_percentage }}%</span>
                            </div>
                            <div class="w-full h-2 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-brand to-cyan-400 transition-all duration-500" 
                                     style="width: {{ $chapter->progress_percentage }}%"></div>
                            </div>
                            <div class="flex items-center justify-between mt-2 text-xs text-gray-500">
                                <span>{{ $chapter->completed_lessons }}/{{ $chapter->total_lessons }} leçons terminées</span>
                            </div>
                        </div>

                        {{-- Description --}}
                        @if($chapter->description)
                            <p class="text-sm text-gray-300 line-clamp-2 mb-4">
                                {{ $chapter->description }}
                            </p>
                        @endif

                        {{-- Informations --}}
                        <div class="flex items-center justify-between pt-4 border-t border-gray-800">
                            <div class="flex items-center gap-4">
                                <span class="inline-flex items-center gap-1 text-sm text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $chapter->estimated_duration_hours ?? 1 }}h
                                </span>
                                <span class="text-gray-500">•</span>
                                <span class="text-sm text-gray-400">
                                    {{ $chapter->difficulty ?? 'Standard' }}
                                </span>
                            </div>
                            <svg class="w-5 h-5 text-gray-600 group-hover:text-brand transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        {{-- Aucun chapitre --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-12 text-center">
            <div class="w-16 h-16 mx-auto rounded-full bg-gray-800 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-white mb-2">Aucun chapitre disponible</h3>
            <p class="text-gray-400">Les chapitres seront bientôt ajoutés au système.</p>
            @if($currentLevel)
                <a href="{{ route('level.index') }}" class="inline-block mt-4 px-6 py-2 bg-brand text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Voir tous les niveaux
                </a>
            @endif
        </div>
    @endif

    {{-- Pagination si nécessaire --}}
    @if($chapters instanceof \Illuminate\Pagination\LengthAwarePaginator && $chapters->hasPages())
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
            <div class="flex justify-center">
                {{ $chapters->links() }}
            </div>
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
</style>
@endpush