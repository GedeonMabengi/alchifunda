@extends('layouts.app')

@section('title', 'Mes Récompenses - ALCHIFUNDA')

@section('page-title', 'Mes Récompenses')
@section('page-subtitle', 'Suivez vos accomplissements en chimie')

@section('content')
<div class="space-y-8">
    {{-- Bannière d'en-tête avec statistiques --}}
    <div class="bg-gradient-to-r from-brand/20 to-amber-500/20 border border-brand/30 rounded-2xl p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">🏆 Mes Récompenses</h1>
                <p class="text-gray-300">
                    Célébrez vos accomplissements dans l'apprentissage de la chimie
                </p>
                <div class="flex items-center gap-4 mt-4">
                    <div class="inline-flex items-center gap-2 bg-black/30 border border-white/10 px-3 py-1 rounded-full text-xs">
                        <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        <span class="text-gray-300">{{ $earnedAchievements->count() }} récompenses obtenues</span>
                    </div>
                    <div class="inline-flex items-center gap-2 bg-black/30 border border-white/10 px-3 py-1 rounded-full text-xs">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="text-gray-300">{{ $lockedAchievements->count() }} récompenses à débloquer</span>
                    </div>
                </div>
            </div>
            
            {{-- Statistiques --}}
            <div class="flex items-center gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">{{ $totalPoints }}</div>
                    <div class="text-xs text-gray-400">Points totaux</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">{{ $earnedAchievements->count() }}</div>
                    <div class="text-xs text-gray-400">Débloquées</div>
                </div>
                <div class="text-center">
                    @php
                        $totalAchievements = $earnedAchievements->count() + $lockedAchievements->count();
                        $completionRate = $totalAchievements > 0 ? round(($earnedAchievements->count() / $totalAchievements) * 100) : 0;
                    @endphp
                    <div class="text-2xl font-bold text-white">{{ $completionRate }}%</div>
                    <div class="text-xs text-gray-400">Taux de complétion</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Barre de progression globale --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
        <div class="mb-4">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-bold text-white">Progression des récompenses</h3>
                <span class="text-sm font-bold text-white">{{ $completionRate }}%</span>
            </div>
            <div class="w-full h-3 bg-gray-800 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-amber-500 to-yellow-500 transition-all duration-1000" 
                     style="width: {{ $completionRate }}%"></div>
            </div>
            <div class="flex items-center justify-between mt-2 text-sm text-gray-400">
                <span>{{ $earnedAchievements->count() }} débloquées</span>
                <span>{{ $totalAchievements }} total</span>
            </div>
        </div>
    </div>

    {{-- Récompenses débloquées --}}
    <div>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">✅ Récompenses débloquées</h2>
                <p class="text-gray-400 mt-1">Félicitations pour ces accomplissements !</p>
            </div>
            <span class="text-sm px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400">
                {{ $earnedAchievements->count() }} obtenues
            </span>
        </div>

        @if($earnedAchievements->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($earnedAchievements as $achievement)
                    <div class="group bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-2xl overflow-hidden hover:border-amber-500/50 transition-all">
                        {{-- En-tête de la récompense --}}
                        <div class="relative p-6">
                            {{-- Effet de lumière --}}
                            <div class="absolute inset-0 bg-gradient-to-r from-amber-500/10 to-yellow-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            
                            <div class="relative flex items-start justify-between">
                                <div>
                                    <div class="inline-flex items-center gap-2 mb-3">
                                        @switch($achievement->rarity)
                                            @case('common')
                                                <span class="px-2 py-1 rounded-full bg-gray-700 text-gray-300 text-xs">Commun</span>
                                                @break
                                            @case('rare')
                                                <span class="px-2 py-1 rounded-full bg-blue-500/20 text-blue-400 text-xs">Rare</span>
                                                @break
                                            @case('epic')
                                                <span class="px-2 py-1 rounded-full bg-purple-500/20 text-purple-400 text-xs">Épique</span>
                                                @break
                                            @case('legendary')
                                                <span class="px-2 py-1 rounded-full bg-amber-500/20 text-amber-400 text-xs">Légendaire</span>
                                                @break
                                        @endswitch
                                        
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-xs">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $achievement->points_reward }} pts
                                        </span>
                                    </div>
                                    
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $achievement->name }}</h3>
                                    <p class="text-gray-300 text-sm">{{ $achievement->description }}</p>
                                </div>
                                
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-r from-amber-500 to-yellow-500 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Informations supplémentaires --}}
                        <div class="border-t border-gray-800 p-6">
                            @if($achievement->earned_at)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-400">Obtenue le</span>
                                    <span class="text-white">{{ \Carbon\Carbon::parse($achievement->earned_at)->format('d/m/Y') }}</span>
                                </div>
                            @endif
                            
                            @if($achievement->category)
                                <div class="flex items-center justify-between text-sm mt-2">
                                    <span class="text-gray-400">Catégorie</span>
                                    <span class="text-white capitalize">{{ $achievement->category }}</span>
                                </div>
                            @endif
                            
                            {{-- CRITÈRES CORRIGÉ : Vérification si c'est un tableau ou une chaîne --}}
                            @if($achievement->criteria)
                                <div class="mt-4">
                                    <p class="text-xs text-gray-500 mb-2">Critères de déblocage :</p>
                                    <div class="text-sm text-gray-400">
                                        @if(is_array($achievement->criteria))
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach($achievement->criteria as $criterion)
                                                    <li>{{ $criterion }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>{{ $achievement->criteria }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mt-4 pt-4 border-t border-gray-800">
                                <div class="flex items-center gap-2 text-sm text-emerald-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Récompense débloquée</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Aucune récompense débloquée --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-12 text-center">
                <div class="w-16 h-16 mx-auto rounded-full bg-gray-800 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Aucune récompense débloquée</h3>
                <p class="text-gray-400">Commencez à apprendre pour débloquer vos premières récompenses !</p>
                <a href="{{ route('level.index') }}" class="inline-block mt-4 px-6 py-3 bg-brand text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Commencer à apprendre
                </a>
            </div>
        @endif
    </div>

    {{-- Récompenses à débloquer --}}
    <div>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">🔒 Récompenses à débloquer</h2>
                <p class="text-gray-400 mt-1">Continuez à progresser pour obtenir ces récompenses</p>
            </div>
            <span class="text-sm px-3 py-1 rounded-full bg-gray-800 text-gray-400">
                {{ $lockedAchievements->count() }} restantes
            </span>
        </div>

        @if($lockedAchievements->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($lockedAchievements as $achievement)
                    <div class="group bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden hover:border-gray-700 transition-all">
                        {{-- En-tête de la récompense --}}
                        <div class="relative p-6 bg-gradient-to-br from-gray-900 to-gray-800">
                            <div class="relative flex items-start justify-between">
                                <div>
                                    <div class="inline-flex items-center gap-2 mb-3">
                                        @switch($achievement->rarity)
                                            @case('common')
                                                <span class="px-2 py-1 rounded-full bg-gray-700 text-gray-300 text-xs">Commun</span>
                                                @break
                                            @case('rare')
                                                <span class="px-2 py-1 rounded-full bg-blue-500/20 text-blue-400 text-xs">Rare</span>
                                                @break
                                            @case('epic')
                                                <span class="px-2 py-1 rounded-full bg-purple-500/20 text-purple-400 text-xs">Épique</span>
                                                @break
                                            @case('legendary')
                                                <span class="px-2 py-1 rounded-full bg-amber-500/20 text-amber-400 text-xs">Légendaire</span>
                                                @break
                                        @endswitch
                                        
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-700 text-gray-300 text-xs">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $achievement->points_reward }} pts
                                        </span>
                                    </div>
                                    
                                    <h3 class="text-xl font-bold text-gray-400 mb-2">{{ $achievement->name }}</h3>
                                    <p class="text-gray-500 text-sm">{{ $achievement->description }}</p>
                                </div>
                                
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 rounded-full bg-gray-800 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Informations supplémentaires --}}
                        <div class="border-t border-gray-800 p-6">
                            @if($achievement->category)
                                <div class="flex items-center justify-between text-sm mb-4">
                                    <span class="text-gray-500">Catégorie</span>
                                    <span class="text-gray-400 capitalize">{{ $achievement->category }}</span>
                                </div>
                            @endif
                            
                            {{-- CRITÈRES CORRIGÉ : Vérification si c'est un tableau ou une chaîne --}}
                            @if($achievement->criteria)
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 mb-2">Critères de déblocage :</p>
                                    <div class="text-sm text-gray-400">
                                        @if(is_array($achievement->criteria))
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach($achievement->criteria as $criterion)
                                                    <li>{{ $criterion }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>{{ $achievement->criteria }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mt-4 pt-4 border-t border-gray-800">
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <span>À débloquer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Toutes les récompenses sont débloquées --}}
            <div class="bg-gradient-to-r from-amber-500/20 to-yellow-500/20 border border-amber-500/30 rounded-2xl p-12 text-center">
                <div class="w-16 h-16 mx-auto rounded-full bg-gradient-to-r from-amber-500 to-yellow-500 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">🎉 Toutes les récompenses débloquées !</h3>
                <p class="text-gray-300 mb-6">Félicitations ! Vous avez débloqué toutes les récompenses disponibles.</p>
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-black/30 rounded-full">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    <span class="text-white font-bold">{{ $totalPoints }} points accumulés</span>
                </div>
            </div>
        @endif
    </div>

    {{-- Catégories de récompenses --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
        <h3 class="text-xl font-bold text-white mb-6">📊 Répartition par catégorie</h3>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $categories = [
                    'learning' => ['name' => 'Apprentissage', 'color' => 'from-brand to-blue-500', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                    'assessment' => ['name' => 'Évaluations', 'color' => 'from-emerald-500 to-green-500', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                    'streak' => ['name' => 'Séries', 'color' => 'from-amber-500 to-yellow-500', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                    'mastery' => ['name' => 'Maîtrise', 'color' => 'from-purple-500 to-pink-500', 'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z']
                ];
            @endphp
            
            @foreach($categories as $key => $category)
                @php
                    $earnedInCategory = $earnedAchievements->where('category', $key)->count();
                    $totalInCategory = $earnedAchievements->where('category', $key)->count() + 
                                      $lockedAchievements->where('category', $key)->count();
                    $percentage = $totalInCategory > 0 ? round(($earnedInCategory / $totalInCategory) * 100) : 0;
                @endphp
                
                <div class="bg-gray-800/50 border border-gray-700 rounded-xl p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r {{ $category['color'] }} flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $category['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-white">{{ $category['name'] }}</h4>
                            <p class="text-xs text-gray-400">{{ $earnedInCategory }}/{{ $totalInCategory }}</p>
                        </div>
                    </div>
                    
                    <div class="w-full h-2 bg-gray-700 rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-gradient-to-r {{ $category['color'] }}" style="width: {{ $percentage }}%"></div>
                    </div>
                    
                    <div class="text-right">
                        <span class="text-sm font-bold text-white">{{ $percentage }}%</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Prochaines récompenses à débloquer --}}
    @if($lockedAchievements->count() > 0)
        <div class="bg-gradient-to-r from-brand/10 to-cyan-400/10 border border-brand/20 rounded-2xl p-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h3 class="text-2xl font-bold text-white mb-2">🎯 Prochaines récompenses à débloquer</h3>
                    <p class="text-gray-300">
                        Continuez votre progression pour obtenir ces récompenses
                    </p>
                </div>
                <a href="{{ route('level.index') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-brand to-cyan-500 text-white font-bold rounded-lg hover:opacity-90 transition-opacity">
                    Continuer à apprendre
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                @foreach($lockedAchievements->take(3) as $achievement)
                    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-white">{{ $achievement->name }}</h4>
                                <p class="text-xs text-gray-400">{{ $achievement->points_reward }} points</p>
                            </div>
                        </div>
                        
                        {{-- CRITÈRES CORRIGÉ pour la section prochaines récompenses --}}
                        @if($achievement->criteria)
                            <div class="text-sm text-gray-300 mt-3">
                                @if(is_array($achievement->criteria))
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach($achievement->criteria as $criterion)
                                            <li>{{ $criterion }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>{{ $achievement->criteria }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
    
    .glow-effect {
        box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
    }
</style>
@endpush