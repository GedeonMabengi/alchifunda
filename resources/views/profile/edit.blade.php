@extends('layouts.app')

@section('title', 'Modifier le profil - ALCHIFUNDA')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Modifier le profil</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Mettez à jour vos informations personnelles
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
        <div class="p-8">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-8">
                    <!-- Informations de base -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Informations de base</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nom complet *
                                </label>
                                <input type="text" name="name" id="name" required
                                       value="{{ old('name', $user->name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Adresse email *
                                </label>
                                <input type="email" name="email" id="email" required
                                       value="{{ old('email', $user->email) }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informations personnelles -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Informations personnelles</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="age" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Âge
                                </label>
                                <input type="number" name="age" id="age" min="10" max="100"
                                       value="{{ old('age', $profile->age) }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                @error('age')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="school_option" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Option scolaire
                                </label>
                                <select name="school_option" id="school_option"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Sélectionnez une option</option>
                                    <option value="Scientifique" {{ old('school_option', $profile->school_option) == 'Scientifique' ? 'selected' : '' }}>Scientifique</option>
                                    <option value="Littéraire" {{ old('school_option', $profile->school_option) == 'Littéraire' ? 'selected' : '' }}>Littéraire</option>
                                    <option value="Technique" {{ old('school_option', $profile->school_option) == 'Technique' ? 'selected' : '' }}>Technique</option>
                                    <option value="Générale" {{ old('school_option', $profile->school_option) == 'Générale' ? 'selected' : '' }}>Générale</option>
                                    <option value="Autre" {{ old('school_option', $profile->school_option) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('school_option')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="school_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nom de l'école
                                </label>
                                <input type="text" name="school_name" id="school_name"
                                       value="{{ old('school_name', $profile->school_name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                @error('school_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ville
                                </label>
                                <input type="text" name="city" id="city"
                                       value="{{ old('city', $profile->city) }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                @error('city')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Objectifs d'étude -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Objectifs d'étude</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="study_time_per_day" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Temps d'étude quotidien (minutes)
                                </label>
                                <input type="range" name="study_time_per_day" id="study_time_per_day" 
                                       min="10" max="480" step="10" 
                                       value="{{ old('study_time_per_day', $profile->study_time_per_day ?? 30) }}"
                                       class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer">
                                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mt-2">
                                    <span>10 min</span>
                                    <span id="time_value">{{ old('study_time_per_day', $profile->study_time_per_day ?? 30) }} min</span>
                                    <span>8h</span>
                                </div>
                                @error('study_time_per_day')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="study_days_per_week" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jours d'étude par semaine
                                </label>
                                <input type="range" name="study_days_per_week" id="study_days_per_week" 
                                       min="1" max="7" 
                                       value="{{ old('study_days_per_week', $profile->study_days_per_week ?? 5) }}"
                                       class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer">
                                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mt-2">
                                    <span>1 jour</span>
                                    <span id="days_value">{{ old('study_days_per_week', $profile->study_days_per_week ?? 5) }} jours</span>
                                    <span>7 jours</span>
                                </div>
                                @error('study_days_per_week')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6 bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900 dark:text-white mb-2">Objectif hebdomadaire calculé</h3>
                            <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400" id="weekly_goal">
                                {{ ($profile->study_time_per_day ?? 30) * ($profile->study_days_per_week ?? 5) }} minutes
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Soit environ <span id="weekly_hours">{{ round((($profile->study_time_per_day ?? 30) * ($profile->study_days_per_week ?? 5)) / 60) }}</span> heures par semaine
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-12 flex flex-col sm:flex-row gap-4 justify-between">
                    <a href="{{ route('profile.show') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Annuler
                    </a>
                    
                    <div class="flex gap-4">
                        <button type="submit"
                                class="inline-flex items-center justify-center px-8 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Mise à jour des valeurs des sliders
    function updateWeeklyGoal() {
        const timePerDay = parseInt(document.getElementById('study_time_per_day').value);
        const daysPerWeek = parseInt(document.getElementById('study_days_per_week').value);
        const weeklyMinutes = timePerDay * daysPerWeek;
        const weeklyHours = Math.round(weeklyMinutes / 60);
        
        document.getElementById('time_value').textContent = timePerDay + ' min';
        document.getElementById('days_value').textContent = daysPerWeek + ' jours';
        document.getElementById('weekly_goal').textContent = weeklyMinutes + ' minutes';
        document.getElementById('weekly_hours').textContent = weeklyHours;
    }
    
    document.getElementById('study_time_per_day').addEventListener('input', updateWeeklyGoal);
    document.getElementById('study_days_per_week').addEventListener('input', updateWeeklyGoal);
    
    // Initialiser
    updateWeeklyGoal();
</script>
@endpush
@endsection