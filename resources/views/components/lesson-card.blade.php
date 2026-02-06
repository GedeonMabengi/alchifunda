@props([
    'lesson' => null,
    'showChapter' => true,
    'showLevel' => true,
    'showProgress' => true,
    'showStatus' => true,
    'compact' => false,
    'clickable' => true
])

@php
    $user = Auth::user();
    $progress = $lesson ? $user->lessonProgress->where('lesson_id', $lesson->id)->first() : null;
    $status = $progress->status ?? 'not_started';
    $progressPercentage = $progress->progress_percentage ?? 0;
    
    // Classes de statut
    $statusClasses = [
        'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        'in_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
        'revision_needed' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        'not_started' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200'
    ];
    
    // Textes de statut
    $statusTexts = [
        'completed' => 'Terminé',
        'in_progress' => 'En cours',
        'revision_needed' => 'Révision nécessaire',
        'not_started' => 'Non commencé'
    ];
    
    // Icônes de statut
    $statusIcons = [
        'completed' => 'M5 13l4 4L19 7',
        'in_progress' => 'M13 10V3L4 14h7v7l9-11h-7z',
        'revision_needed' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z',
        'not_started' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
    ];
    
    // Classes de difficulté
    $difficultyClasses = [
        'beginner' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        'intermediate' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        'advanced' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
    ];
@endphp

@if($lesson)
    <div class="{{ $clickable ? 'cursor-pointer hover:shadow-lg transition-shadow duration-300' : '' }} 
                bg-white dark:bg-gray-800 rounded-xl shadow border border-gray-200 dark:border-gray-700 overflow-hidden
                {{ $compact ? 'p-4' : 'p-6' }}">
        
        @if($clickable)
            <a href="{{ route('lesson.show', ['chapterSlug' => $lesson->chapter->slug, 'lessonSlug' => $lesson->slug]) }}" 
               class="block">
        @endif
        
        <div class="flex flex-col {{ $compact ? 'space-y-2' : 'space-y-4' }}">
            <!-- En-tête -->
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <!-- Titre et métadonnées -->
                    <div class="flex items-start space-x-3">
                        @if(!$compact)
                            <div class="h-10 w-10 rounded-lg bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center flex-shrink-0">
                                <span class="font-bold text-indigo-600 dark:text-indigo-300">
                                    {{ $lesson->order }}
                                </span>
                            </div>
                        @endif
                        
                        <div class="flex-1 min-w-0">
                            <h3 class="{{ $compact ? 'text-sm font-semibold' : 'text-lg font-semibold' }} text-gray-900 dark:text-white truncate">
                                {{ $lesson->title }}
                            </h3>
                            
                            <div class="flex flex-wrap items-center gap-2 mt-1">
                                @if($showChapter)
                                    <span class="text-xs px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                        {{ $lesson->chapter->name }}
                                    </span>
                                @endif
                                
                                @if($showLevel)
                                    <span class="text-xs px-2 py-1 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">
                                        {{ $lesson->chapter->level->code }}
                                    </span>
                                @endif
                                
                                @if($lesson->difficulty && !$compact)
                                    <span class="text-xs px-2 py-1 rounded-full {{ $difficultyClasses[$lesson->difficulty] ?? $difficultyClasses['beginner'] }}">
                                        {{ ucfirst($lesson->difficulty) }}
                                    </span>
                                @endif
                                
                                @if($lesson->estimated_minutes && !$compact)
                                    <span class="text-xs text-gray-600 dark:text-gray-400 flex items-center">
                                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $lesson->estimated_minutes }} min
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    @if($lesson->description && !$compact)
                        <p class="mt-3 text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                            {{ $lesson->description }}
                        </p>
                    @endif
                </div>
                
                <!-- Statut -->
                @if($showStatus)
                    <div class="ml-4 flex-shrink-0">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusClasses[$status] }}">
                            <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusIcons[$status] }}"/>
                            </svg>
                            {{ $statusTexts[$status] }}
                        </span>
                    </div>
                @endif
            </div>
            
            <!-- Progression -->
            @if($showProgress && $status === 'in_progress')
                <div>
                    <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400 mb-1">
                        <span>Progression</span>
                        <span>{{ $progressPercentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                        <div class="bg-indigo-500 h-1.5 rounded-full transition-all duration-300" 
                             style="width: {{ $progressPercentage }}%"></div>
                    </div>
                </div>
            @endif
            
            <!-- Tags -->
            @if($lesson->tags && !$compact)
                <div class="flex flex-wrap gap-1">
                    @foreach($lesson->tags as $tag)
                        <span class="text-xs px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            @endif
            
            <!-- Actions -->
            <div class="flex items-center justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
                <div class="text-xs text-gray-600 dark:text-gray-400">
                    @if($progress && $progress->last_accessed_at)
                        Dernier accès : {{ $progress->last_accessed_at->diffForHumans() }}
                    @else
                        Pas encore commencé
                    @endif
                </div>
                
                @if($clickable)
                    <span class="inline-flex items-center text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                        @if($status === 'completed')
                            Réviser
                        @elseif($status === 'in_progress')
                            Continuer
                        @else
                            Commencer
                        @endif
                        <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                @endif
            </div>
        </div>
        
        @if($clickable)
            </a>
        @endif
    </div>
@endif