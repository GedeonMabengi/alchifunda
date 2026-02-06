@props([
    'achievement' => null,
    'size' => 'md', // sm, md, lg
    'showTooltip' => true,
    'earned' => false,
    'earnedAt' => null
])

@php
    // Classes de taille
    $sizeClasses = [
        'sm' => 'h-8 w-8 text-xs',
        'md' => 'h-12 w-12 text-base',
        'lg' => 'h-16 w-16 text-xl'
    ];
    
    // Classes de couleur
    $colorClasses = [
        'bronze' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 border-yellow-200 dark:border-yellow-800',
        'silver' => 'bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-800',
        'gold' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 border-yellow-300 dark:border-yellow-700',
        'platinum' => 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 border-blue-200 dark:border-blue-800',
        'learning' => 'bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 border-indigo-200 dark:border-indigo-800',
        'assessment' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border-green-200 dark:border-green-800',
        'consistency' => 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 border-purple-200 dark:border-purple-800',
        'speed' => 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 border-red-200 dark:border-red-800'
    ];
    
    // Déterminer la couleur basée sur la difficulté ou la catégorie
    $color = 'learning';
    if ($achievement) {
        $color = match($achievement->difficulty ?? $achievement->category) {
            'beginner', 'bronze' => 'bronze',
            'intermediate', 'silver' => 'silver',
            'advanced', 'gold' => 'gold',
            'expert', 'platinum' => 'platinum',
            'learning' => 'learning',
            'assessment' => 'assessment',
            'consistency' => 'consistency',
            'speed' => 'speed',
            default => 'learning'
        };
    }
    
    // Icône par défaut
    $icon = $achievement->icon ?? 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z';
@endphp

<div class="relative inline-block" x-data="{ showTooltip: false }" 
     @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
    
    <!-- Badge -->
    <div class="{{ $sizeClasses[$size] }} rounded-full border-2 flex items-center justify-center {{ $colorClasses[$color] }} 
                {{ !$earned ? 'opacity-50' : '' }} transition-all duration-300 hover:scale-105 cursor-pointer">
        <svg class="{{ $size === 'sm' ? 'h-4 w-4' : ($size === 'md' ? 'h-6 w-6' : 'h-8 w-8') }}" 
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
        </svg>
        
        <!-- Indicateur "gagné" -->
        @if($earned)
            <div class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-green-500 border-2 border-white dark:border-gray-800 flex items-center justify-center">
                <svg class="h-2 w-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        @endif
    </div>
    
    <!-- Tooltip -->
    @if($showTooltip && $achievement)
        <div x-show="showTooltip" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-1"
             class="absolute z-10 w-64 p-4 -mt-2 transform -translate-x-1/2 left-1/2"
             style="display: none;">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 p-4">
                <!-- En-tête -->
                <div class="flex items-start mb-3">
                    <div class="{{ $sizeClasses['sm'] }} rounded-full border flex items-center justify-center {{ $colorClasses[$color] }} mr-3 flex-shrink-0">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900 dark:text-white">{{ $achievement->name }}</h4>
                        <div class="flex items-center mt-1">
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $colorClasses[$color] }}">
                                {{ $achievement->points_reward }} points
                            </span>
                            @if($achievement->difficulty)
                                <span class="mx-2 text-gray-400">•</span>
                                <span class="text-xs text-gray-600 dark:text-gray-400">{{ ucfirst($achievement->difficulty) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $achievement->description }}</p>
                
                <!-- Statut -->
                <div class="text-xs text-gray-500 dark:text-gray-500">
                    @if($earned && $earnedAt)
                        <div class="flex items-center">
                            <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Gagné le {{ $earnedAt->format('d/m/Y') }}
                        </div>
                    @elseif(!$earned)
                        <div class="flex items-center text-red-500">
                            <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            À débloquer
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>