@extends('layouts.app')

@section('title', 'Préférences d\'apprentissage - ALCHIFUNDA')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Préférences d'apprentissage</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Personnalisez votre expérience ALCHIFUNDA selon vos préférences
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
        <div class="p-8">
            <form action="{{ route('preferences.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-12">
                    <!-- Ton -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                            Ton préféré des explications
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @php
                                $tones = [
                                    [
                                        'value' => 'formal',
                                        'name' => 'Formel',
                                        'description' => 'Explications académiques, terminologie précise',
                                        'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'
                                    ],
                                    [
                                        'value' => 'casual',
                                        'name' => 'Décontracté',
                                        'description' => 'Langage courant, exemples de la vie quotidienne',
                                        'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                                    ],
                                    [
                                        'value' => 'friendly',
                                        'name' => 'Amical',
                                        'description' => 'Ton encourageant, comme un tuteur personnel',
                                        'icon' => 'M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5'
                                    ],
                                ];
                            @endphp
                            
                            @foreach($tones as $tone)
                                <label class="relative">
                                    <input type="radio" name="tone" value="{{ $tone['value'] }}" 
                                           class="sr-only peer"
                                           {{ old('tone', $preferences->tone) == $tone['value'] ? 'checked' : '' }}>
                                    <div class="border-2 border-gray-200 dark:border-gray-700 rounded-xl p-6 cursor-pointer hover:border-indigo-300 dark:hover:border-indigo-700 peer-checked:border-indigo-600 dark:peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 transition h-full">
                                        <div class="flex flex-col items-center text-center">
                                            <div class="h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mb-4">
                                                <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tone['icon'] }}"/>
                                                </svg>
                                            </div>
                                            <h3 class="font-bold text-gray-900 dark:text-white mb-2">{{ $tone['name'] }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $tone['description'] }}</p>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('tone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Niveau de détail -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                            Niveau de détail souhaité
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @php
                                $detailLevels = [
                                    [
                                        'value' => 'concise',
                                        'name' => 'Concis',
                                        'description' => 'L\'essentiel, sans fioritures',
                                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                                    ],
                                    [
                                        'value' => 'moderate',
                                        'name' => 'Modéré',
                                        'description' => 'Explications complètes mais accessibles',
                                        'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                                    ],
                                    [
                                        'value' => 'detailed',
                                        'name' => 'Détaillé',
                                        'description' => 'Tous les détails et approfondissements',
                                        'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
                                    ],
                                ];
                            @endphp
                            
                            @foreach($detailLevels as $level)
                                <label class="relative">
                                    <input type="radio" name="detail_level" value="{{ $level['value'] }}" 
                                           class="sr-only peer"
                                           {{ old('detail_level', $preferences->detail_level) == $level['value'] ? 'checked' : '' }}>
                                    <div class="border-2 border-gray-200 dark:border-gray-700 rounded-xl p-6 cursor-pointer hover:border-indigo-300 dark:hover:border-indigo-700 peer-checked:border-indigo-600 dark:peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 transition h-full">
                                        <div class="flex flex-col items-center text-center">
                                            <div class="h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mb-4">
                                                <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $level['icon'] }}"/>
                                                </svg>
                                            </div>
                                            <h3 class="font-bold text-gray-900 dark:text-white mb-2">{{ $level['name'] }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $level['description'] }}</p>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('detail_level')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Style d'exemples -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                            Style d'exemples préféré
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @php
                                $exampleStyles = [
                                    [
                                        'value' => 'everyday',
                                        'name' => 'Vie quotidienne',
                                        'description' => 'Exemples concrets du quotidien',
                                        'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'
                                    ],
                                    [
                                        'value' => 'scientific',
                                        'name' => 'Scientifique',
                                        'description' => 'Exemples de laboratoire et recherche',
                                        'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'
                                    ],
                                    [
                                        'value' => 'mixed',
                                        'name' => 'Mixte',
                                        'description' => 'Un mélange des deux approches',
                                        'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
                                    ],
                                ];
                            @endphp
                            
                            @foreach($exampleStyles as $style)
                                <label class="relative">
                                    <input type="radio" name="example_style" value="{{ $style['value'] }}" 
                                           class="sr-only peer"
                                           {{ old('example_style', $preferences->example_style) == $style['value'] ? 'checked' : '' }}>
                                    <div class="border-2 border-gray-200 dark:border-gray-700 rounded-xl p-6 cursor-pointer hover:border-indigo-300 dark:hover:border-indigo-700 peer-checked:border-indigo-600 dark:peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/30 transition h-full">
                                        <div class="flex flex-col items-center text-center">
                                            <div class="h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mb-4">
                                                <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $style['icon'] }}"/>
                                                </svg>
                                            </div>
                                            <h3 class="font-bold text-gray-900 dark:text-white mb-2">{{ $style['name'] }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $style['description'] }}</p>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('example_style')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Options supplémentaires -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                            Options supplémentaires
                        </h2>
                        
                        <div class="space-y-6">
                            <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-lg bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">Afficher les étapes de calcul</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Détailler chaque étape des calculs mathématiques</p>
                                    </div>
                                </div>
                                <input type="checkbox" name="show_math_steps" value="1" 
                                       class="h-6 w-6 text-indigo-600 rounded border-gray-300 dark:border-gray-600 focus:ring-indigo-500 dark:bg-gray-700"
                                       {{ old('show_math_steps', $preferences->show_math_steps) ? 'checked' : '' }}>
                            </div>

                            <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-lg bg-green-100 dark:bg-green-900 flex items-center justify-center mr-4">
                                        <svg class="h-5 w-5 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">Activer les notifications</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Recevoir des notifications pour vos activités</p>
                                    </div>
                                </div>
                                <input type="checkbox" name="enable_notifications" value="1" 
                                       class="h-6 w-6 text-indigo-600 rounded border-gray-300 dark:border-gray-600 focus:ring-indigo-500 dark:bg-gray-700"
                                       {{ old('enable_notifications', $preferences->enable_notifications) ? 'checked' : '' }}>
                            </div>

                            <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-lg bg-purple-100 dark:bg-purple-900 flex items-center justify-center mr-4">
                                        <svg class="h-5 w-5 text-purple-600 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">Activer les rappels</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Recevoir des rappels pour étudier</p>
                                    </div>
                                </div>
                                <input type="checkbox" name="enable_reminders" value="1" 
                                       class="h-6 w-6 text-indigo-600 rounded border-gray-300 dark:border-gray-600 focus:ring-indigo-500 dark:bg-gray-700"
                                       {{ old('enable_reminders', $preferences->enable_reminders) ? 'checked' : '' }}>
                            </div>

                            <div>
                                <label for="preferred_study_time" class="block text-lg font-medium text-gray-900 dark:text-white mb-3">
                                    Heure d'étude préférée
                                </label>
                                <div class="mt-1">
                                    <input type="time" name="preferred_study_time" id="preferred_study_time"
                                           value="{{ old('preferred_study_time', $preferences->preferred_study_time) }}"
                                           class="w-full md:w-1/3 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Nous vous enverrons des rappels à cette heure
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-12 flex flex-col sm:flex-row gap-4 justify-between">
                    <a href="{{ route('profile.show') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Annuler
                    </a>
                    
                    <button type="submit"
                            class="inline-flex items-center justify-center px-8 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Enregistrer les préférences
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection