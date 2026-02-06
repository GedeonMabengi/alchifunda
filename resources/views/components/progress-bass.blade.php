@props([
    'percentage' => 0,
    'size' => 'md', // sm, md, lg
    'color' => 'indigo', // indigo, green, blue, red, yellow, purple
    'showLabel' => true,
    'labelPosition' => 'right' // left, right, top, bottom, inside
])

@php
    // Classes de taille
    $sizeClasses = [
        'sm' => 'h-1.5 text-xs',
        'md' => 'h-2 text-sm',
        'lg' => 'h-3 text-base'
    ];
    
    // Classes de couleur
    $colorClasses = [
        'indigo' => 'bg-indigo-500',
        'green' => 'bg-green-500',
        'blue' => 'bg-blue-500',
        'red' => 'bg-red-500',
        'yellow' => 'bg-yellow-500',
        'purple' => 'bg-purple-500'
    ];
    
    // Classes de couleur de texte
    $textColorClasses = [
        'indigo' => 'text-indigo-600 dark:text-indigo-400',
        'green' => 'text-green-600 dark:text-green-400',
        'blue' => 'text-blue-600 dark:text-blue-400',
        'red' => 'text-red-600 dark:text-red-400',
        'yellow' => 'text-yellow-600 dark:text-yellow-400',
        'purple' => 'text-purple-600 dark:text-purple-400'
    ];
    
    // S'assurer que le pourcentage est entre 0 et 100
    $percentage = min(100, max(0, $percentage));
@endphp

<div class="space-y-1" x-data="{ animatedPercentage: 0 }" x-init="
    setTimeout(() => {
        const target = {{ $percentage }};
        const duration = 1000;
        const step = target / (duration / 16);
        let current = 0;
        
        const animate = () => {
            current += step;
            if (current >= target) {
                animatedPercentage = target;
                return;
            }
            animatedPercentage = Math.round(current);
            requestAnimationFrame(animate);
        };
        
        animate();
    }, 300);
">
    @if($showLabel && in_array($labelPosition, ['top', 'left']))
        <div class="flex justify-between items-center">
            @if($labelPosition === 'top')
                <span class="{{ $textColorClasses[$color] }} font-medium" x-text="`${animatedPercentage}%`"></span>
            @endif
            
            @if($labelPosition === 'left')
                <span class="{{ $textColorClasses[$color] }} font-medium mr-3" x-text="`${animatedPercentage}%`"></span>
            @endif
            
            @if($slot->isNotEmpty())
                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $slot }}</span>
            @endif
        </div>
    @endif
    
    <div class="relative">
        <!-- Barre de fond -->
        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full {{ $sizeClasses[$size] }} overflow-hidden">
            <!-- Barre de progression -->
            <div class="h-full rounded-full {{ $colorClasses[$color] }} transition-all duration-500 ease-out"
                 :style="`width: ${animatedPercentage}%`">
            </div>
        </div>
        
        <!-- Label à l'intérieur -->
        @if($showLabel && $labelPosition === 'inside' && $percentage >= 20)
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-xs font-bold text-white" x-text="`${animatedPercentage}%`"></span>
            </div>
        @endif
    </div>
    
    @if($showLabel && in_array($labelPosition, ['bottom', 'right']))
        <div class="flex justify-between items-center">
            @if($labelPosition === 'bottom')
                <span class="{{ $textColorClasses[$color] }} font-medium" x-text="`${animatedPercentage}%`"></span>
            @endif
            
            @if($labelPosition === 'right')
                <span class="{{ $textColorClasses[$color] }} font-medium ml-3" x-text="`${animatedPercentage}%`"></span>
            @endif
            
            @if($slot->isNotEmpty() && $labelPosition === 'bottom')
                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $slot }}</span>
            @endif
        </div>
    @endif
</div>