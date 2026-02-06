@extends('layouts.app')

@section('title', 'Historique des leçons - ALCHIFUNDA')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Historique des leçons</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Retracez votre parcours d'apprentissage
                </p>
            </div>
            
            <div class="mt-4 md:mt-0">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $lessonHistory->total() }} activité(s) au total
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
                    <button class="px-3 py-1 rounded-full text-sm bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">
                        Toutes
                    </button>
                    <button class="px-3 py-1 rounded-full text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                        Terminées
                    </button>
                    <button class="px-3 py-1 rounded-full text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                        En cours
                    </button>
                </div>
            </div>
            
            <div class="relative">
                <input type="text" placeholder="Rechercher une leçon..."
                       class="pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Historique -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="grid grid-cols-12 gap-4 text-sm font-medium text-gray-700 dark:text-gray-300">
                <div class="col-span-5">Leçon</div>
                <div class="col-span-2">Statut</div>
                <div class="col-span-2">Progression</div>
                <div class="col-span-3">Dernier accès</div>
            </div>
        </div>
        
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($lessonHistory as $history)
                <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="grid grid-cols-12 gap-4 items-center">
                        <!-- Leçon -->
                        <div class="col-span-5">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-lg bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mr-3">
                                    <span class="font-bold text-indigo-600 dark:text-indigo-300">
                                        {{ $history->lesson->chapter->level->code }}
                                    </span>
                                </div>
                                <div>
                                    <a href="{{ route('lesson.show', ['chapterSlug' => $history->lesson->chapter->slug, 'lessonSlug' => $history->lesson->slug]) }}" 
                                       class="font-medium text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400">
                                        {{ $history->lesson->title }}
                                    </a>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $history->lesson->chapter->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Statut -->
                        <div class="col-span-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                {{ $history->status == 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                   $history->status == 'in_progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                                   'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                                @if($history->status == 'completed')
                                    <svg class="mr-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Terminé
                                @elseif($history->status == 'in_progress')
                                    <svg class="mr-1 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    En cours
                                @else
                                    Non commencé
                                @endif
                            </span>
                        </div>
                        
                        <!-- Progression -->
                        <div class="col-span-2">
                            <div class="flex items-center">
                                <div class="w-16 mr-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $history->progress_percentage }}%
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-indigo-500 h-2 rounded-full" 
                                             style="width: {{ $history->progress_percentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dernier accès -->
                        <div class="col-span-3">
                            <div class="text-sm text-gray-900 dark:text-white">
                                {{ $history->last_accessed_at->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                {{ $history->last_accessed_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">
                        Aucune activité récente.
                    </p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($lessonHistory->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $lessonHistory->links() }}
            </div>
        @endif
    </div>

    <!-- Résumé -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 text-white">
            <div class="text-3xl font-bold mb-2">{{ $lessonHistory->where('status', 'completed')->count() }}</div>
            <div class="text-sm text-indigo-100">Leçons terminées</div>
        </div>
        
        <div class="bg-gradient-to-r from-blue-500 to-cyan-600 rounded-xl p-6 text-white">
            <div class="text-3xl font-bold mb-2">{{ $lessonHistory->where('status', 'in_progress')->count() }}</div>
            <div class="text-sm text-blue-100">Leçons en cours</div>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl p-6 text-white">
            <div class="text-3xl font-bold mb-2">{{ $lessonHistory->sum('access_count') }}</div>
            <div class="text-sm text-green-100">Total des accès</div>
        </div>
    </div>
</div>
@endsection