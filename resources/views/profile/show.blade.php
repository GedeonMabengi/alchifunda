@extends('layouts.app')

@section('title', 'Mon profil - ALCHIFUNDA')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Mon profil</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Gérer vos informations personnelles et votre compte
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Informations personnelles -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg mb-8">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Informations personnelles</h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nom complet
                            </label>
                            <div class="text-lg text-gray-900 dark:text-white">{{ $user->name }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Email
                            </label>
                            <div class="text-lg text-gray-900 dark:text-white">{{ $user->email }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Âge
                            </label>
                            <div class="text-lg text-gray-900 dark:text-white">{{ $profile->age ?? 'Non spécifié' }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Option scolaire
                            </label>
                            <div class="text-lg text-gray-900 dark:text-white">{{ $profile->school_option ?? 'Non spécifié' }}</div>
                        </div>
                        
                        @if($profile->school_name)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    École
                                </label>
                                <div class="text-lg text-gray-900 dark:text-white">{{ $profile->school_name }}</div>
                            </div>
                        @endif
                        
                        @if($profile->city)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Ville
                                </label>
                                <div class="text-lg text-gray-900 dark:text-white">{{ $profile->city }}</div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-8">
                        <a href="{{ route('profile.edit') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Modifier le profil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Préférences d'apprentissage -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg mb-8">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Préférences d'apprentissage</h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Ton préféré
                            </label>
                            <div class="text-lg text-gray-900 dark:text-white">
                                @switch($preferences->tone)
                                    @case('formal')
                                        Formel
                                        @break
                                    @case('casual')
                                        Décontracté
                                        @break
                                    @case('friendly')
                                        Amical
                                        @break
                                @endswitch
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Niveau de détail
                            </label>
                            <div class="text-lg text-gray-900 dark:text-white">
                                @switch($preferences->detail_level)
                                    @case('concise')
                                        Concis
                                        @break
                                    @case('moderate')
                                        Modéré
                                        @break
                                    @case('detailed')
                                        Détaillé
                                        @break
                                @endswitch
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Style d'exemples
                            </label>
                            <div class="text-lg text-gray-900 dark:text-white">
                                @switch($preferences->example_style)
                                    @case('everyday')
                                        Vie quotidienne
                                        @break
                                    @case('scientific')
                                        Scientifique
                                        @break
                                    @case('mixed')
                                        Mixte
                                        @break
                                @endswitch
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Étapes de calcul
                            </label>
                            <div class="text-lg text-gray-900 dark:text-white">
                                {{ $preferences->show_math_steps ? 'Affichées' : 'Non affichées' }}
                            </div>
                        </div>
                        
                        @if($preferences->preferred_study_time)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Heure d'étude préférée
                                </label>
                                <div class="text-lg text-gray-900 dark:text-white">
                                    {{ date('H:i', strtotime($preferences->preferred_study_time)) }}
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-8">
                        <a href="{{ route('preferences.edit') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Modifier les préférences
                        </a>
                    </div>
                </div>
            </div>

            <!-- Objectifs d'étude -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Objectifs d'étude</h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Temps d'étude quotidien
                            </label>
                            <div class="text-lg text-gray-900 dark:text-white">
                                {{ $profile->study_time_per_day ?? 30 }} minutes
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Jours d'étude par semaine
                            </label>
                            <div class="text-lg text-gray-900 dark:text-white">
                                {{ $profile->study_days_per_week ?? 5 }} jours
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                        <h3 class="font-medium text-gray-900 dark:text-white mb-2">Objectif hebdomadaire</h3>
                        @php
                            $weeklyGoal = ($profile->study_time_per_day ?? 30) * ($profile->study_days_per_week ?? 5);
                        @endphp
                        <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                            {{ $weeklyGoal }} minutes
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Soit environ {{ round($weeklyGoal / 60) }} heures par semaine
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Avatar et info rapide -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <div class="text-center">
                    <div class="h-24 w-24 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-3xl font-bold text-indigo-600 dark:text-indigo-300 mx-auto mb-4">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                    
                    <div class="mt-4">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Membre depuis {{ $user->created_at->format('d/m/Y') }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Dernière connexion : {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Vos statistiques</h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                            <span>Leçons terminées</span>
                            <span>{{ $stats['completed_lessons'] }}/{{ $stats['total_lessons'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" 
                                 style="width: {{ $stats['total_lessons'] > 0 ? round(($stats['completed_lessons'] / $stats['total_lessons']) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                            <span>Évaluations réussies</span>
                            <span>{{ $stats['passed_assessments'] }}/{{ $stats['total_assessments'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" 
                                 style="width: {{ $stats['total_assessments'] > 0 ? round(($stats['passed_assessments'] / $stats['total_assessments']) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                            <span>Score moyen</span>
                            <span>{{ $stats['average_score'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-indigo-500 h-2 rounded-full" 
                                 style="width: {{ $stats['average_score'] }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                            <span>Récompenses</span>
                            <span>{{ $stats['achievements_count'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" 
                                 style="width: {{ min(100, $stats['achievements_count'] * 10) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions rapides</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Modifier le profil</span>
                    </a>
                    
                    <a href="{{ route('preferences.edit') }}" 
                       class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Préférences d'apprentissage</span>
                    </a>
                    
                    <a href="{{ route('progress.index') }}" 
                       class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Ma progression</span>
                    </a>
                    
                    <a href="{{ route('achievement.index') }}" 
                       class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Mes récompenses</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection