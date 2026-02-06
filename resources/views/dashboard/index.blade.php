@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-6 space-y-8">

    <!-- En-tête -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Bonjour, {{ $user->name }} 👋
            </h1>
            <p class="text-gray-500 dark:text-gray-300">
                Niveau actuel : 
                <span class="font-semibold text-indigo-600">
                    {{ $currentLevel?->name ?? 'Non défini' }}
                </span>
            </p>
        </div>

        <div class="mt-4 md:mt-0">
            <a href="{{ route('lesson.index') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Continuer l’apprentissage
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Leçons terminées', 'value' => $progressStats['completed_lessons'], 'total' => $progressStats['total_lessons']],
                ['label' => 'Progression', 'value' => $progressStats['completion_percentage'].'%'],
                ['label' => 'Évaluations réussies', 'value' => $progressStats['passed_assessments']],
                ['label' => 'Streak actuel', 'value' => $progressStats['current_streak'].' jours'],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow">
                <p class="text-sm text-gray-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $stat['value'] }}
                    @isset($stat['total'])
                        <span class="text-sm text-gray-400">/ {{ $stat['total'] }}</span>
                    @endisset
                </p>
            </div>
        @endforeach
    </div>

    <!-- Leçons recommandées -->
    <div>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
            Leçons recommandées 📚
        </h2>

        @if($recommendedLessons->isEmpty())
            <p class="text-gray-500">Aucune leçon recommandée pour le moment.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recommendedLessons as $lesson)
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow hover:shadow-lg transition">
                        <p class="text-sm text-indigo-600 font-medium">
                            {{ $lesson->chapter->title }}
                        </p>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                            {{ $lesson->title }}
                        </h3>

                        <a href="{{ route('lesson.show', $lesson) }}"
                           class="mt-4 inline-block text-indigo-600 hover:underline">
                            Commencer →
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Activité récente + Badges -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Activité récente -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Activité récente 🕒
            </h2>

            @forelse($recentActivity as $activity)
                <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $activity->lesson->title }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $activity->lesson->chapter->title }}
                        </p>
                    </div>

                    <span class="text-xs px-2 py-1 rounded bg-indigo-100 text-indigo-700">
                        {{ ucfirst(str_replace('_', ' ', $activity->status)) }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500">Aucune activité récente.</p>
            @endforelse
        </div>

        <!-- Récompenses -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Récompenses 🏆
            </h2>

            @forelse($recentAchievements as $reward)
                <div class="flex items-center space-x-4 py-3 border-b border-gray-200 dark:border-gray-700">
                    <div class="text-2xl">🏅</div>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $reward->achievement->name }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $reward->achievement->description }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Aucune récompense récente.</p>
            @endforelse
        </div>
    </div>

    <!-- Objectifs hebdomadaires -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            Objectifs de la semaine 🎯
        </h2>

        <p class="text-gray-500 mb-2">
            {{ $weeklyGoals['completed_lessons'] }} / {{ $weeklyGoals['target_lessons'] }} leçons complétées
        </p>

        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
            <div class="bg-indigo-600 h-3 rounded-full"
                 style="width: {{ $weeklyGoals['progress_percentage'] }}%">
            </div>
        </div>

        <p class="text-sm text-gray-500 mt-2">
            Progression : {{ $weeklyGoals['progress_percentage'] }}%
        </p>
    </div>

</div>
@endsection
