@extends('layouts.app')

@section('title', 'Niveaux d’apprentissage')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
        Niveaux d’apprentissage
    </h1>

    @if($levels->isEmpty())
        <div class="p-6 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 rounded">
            Aucun niveau disponible pour le moment.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($levels as $level)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border-l-4
                    {{ $currentLevel && $currentLevel->id === $level->id ? 'border-indigo-500' : 'border-gray-200 dark:border-gray-700' }}">
                    
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            {{ $level->name }}
                        </h2>
                        @if($currentLevel && $currentLevel->id === $level->id)
                            <span class="text-xs font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-100 dark:bg-indigo-900 px-2 py-1 rounded">
                                Niveau actuel
                            </span>
                        @endif
                    </div>

                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                        {{ $level->chapters_count }} chapitre{{ $level->chapters_count > 1 ? 's' : '' }}
                    </p>

                    <a href="{{ route('level.show', $level->code) }}"
                        class="inline-block mt-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded shadow">
                        Voir les chapitres
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
