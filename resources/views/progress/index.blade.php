@extends('layouts.app')

@section('title', 'Ma progression - ALCHIFUNDA')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Ma progression</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Suivez votre avancement et vos performances
        </p>
    </div>

    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <div class="flex items-center">
                <div class="h-12 w-12 rounded-lg bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mr-4">
                    <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalStudyTime }} min</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Temps total d'étude</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <div class="flex items-center">
                <div class="h-12 w-12 rounded-lg bg-green-100 dark:bg-green-900 flex items-center justify-center mr-4">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">
                        @php
                            $totalLessons = 0;
                            $completedLessons = 0;
                            foreach ($levelProgress as $progress) {
                                $totalLessons += $progress['total'];
                                $completedLessons += $progress['completed'];
                            }
                        @endphp
                        {{ $completedLessons }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Leçons terminées</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <div class="flex items-center">
                <div class="h-12 w-12 rounded-lg bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">
                        @php
                            $avgScore = round($scoreHistory->avg('percentage') ?? 0);
                        @endphp
                        {{ $avgScore }}%
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Score moyen</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <div class="flex items-center">
                <div class="h-12 w-12 rounded-lg bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center mr-4">
                    <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">
                        @php
                            $achievementPoints = Auth::user()->achievements->sum('points_reward');
                        @endphp
                        {{ $achievementPoints }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Points de récompense</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Progression par niveau -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Progression par niveau</h2>
            </div>
            
            <div class="p-6">
                <div class="space-y-6">
                    @foreach($levelProgress as $progress)
                        <div>
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <span>{{ $progress['level']->name }}</span>
                                <span>{{ $progress['completed'] }}/{{ $progress['total'] }} ({{ $progress['percentage'] }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                <div class="bg-linear-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-500" 
                                     style="width: {{ $progress['percentage'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    <a href="{{ route('level.index') }}" 
                       class="inline-flex items-center text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                        Voir tous les niveaux
                        <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Activité de la semaine -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Activité cette semaine</h2>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($weeklyActivity as $activity)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-20 text-sm text-gray-600 dark:text-gray-400">{{ $activity['day'] }}</div>
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-1">
                                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-500 mb-1">
                                                <span>Leçons</span>
                                                <span>{{ $activity['lessons'] }}</span>
                                            </div>
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                <div class="bg-green-500 h-2 rounded-full" 
                                                     style="width: {{ min(100, ($activity['lessons'] / max(1, array_sum(array_column($weeklyActivity, 'lessons'))) * 100)) }}%"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex-1">
                                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-500 mb-1">
                                                <span>Évaluations</span>
                                                <span>{{ $activity['assessments'] }}</span>
                                            </div>
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                <div class="bg-blue-500 h-2 rounded-full" 
                                                     style="width: {{ min(100, ($activity['assessments'] / max(1, array_sum(array_column($weeklyActivity, 'assessments'))) * 100)) }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Évolution des scores -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Évolution de vos scores</h2>
        </div>
        
        <div class="p-6">
            @if($scoreHistory->count() > 0)
                <div class="h-64">
                    <!-- Graphique simplifié -->
                    <div class="relative h-full">
                        <div class="absolute inset-0 flex items-end">
                            @foreach($scoreHistory as $index => $result)
                                <div class="flex-1 flex flex-col items-center mx-1">
                                    <div class="w-8 rounded-t-lg 
    {{ $result->percentage >= 80 ? 'bg-green-500' : ($result->percentage >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}" 
     style="height: {{ $result->percentage }}%">
</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                                        {{ $index + 1 }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-center space-x-8">
                    <div class="flex items-center">
                        <div class="h-3 w-3 rounded-full bg-green-500 mr-2"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">80-100%</span>
                    </div>
                    <div class="flex items-center">
                        <div class="h-3 w-3 rounded-full bg-yellow-500 mr-2"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">60-79%</span>
                    </div>
                    <div class="flex items-center">
                        <div class="h-3 w-3 rounded-full bg-red-500 mr-2"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">0-59%</span>
                    </div>
                </div>
                
                <div class="mt-8">
                    <a href="{{ route('progress.assessments') }}" 
                       class="inline-flex items-center text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                        Voir tous les résultats d'évaluation
                        <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p class="mt-4 text-gray-500 dark:text-gray-400">
                        Aucun résultat d'évaluation pour le moment.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Navigation -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('progress.history') }}" 
           class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="h-12 w-12 rounded-lg bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mr-4">
                    <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Historique des leçons</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Voir toutes vos activités</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('progress.assessments') }}" 
           class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="h-12 w-12 rounded-lg bg-green-100 dark:bg-green-900 flex items-center justify-center mr-4">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Résultats d'évaluation</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Analyse détaillée</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('achievement.index') }}" 
           class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="h-12 w-12 rounded-lg bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center mr-4">
                    <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Mes récompenses</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Voir vos succès</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection