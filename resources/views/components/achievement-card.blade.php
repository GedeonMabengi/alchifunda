{{-- resources/views/components/achievement-card.blade.php --}}
@props([
    'achievement' => null,
    'earned' => false,
    'compact' => false
])

@if($achievement)
    <div class="group {{ $compact ? 'p-4' : 'p-6' }} bg-gray-900 border {{ $earned ? 'border-amber-500/30' : 'border-gray-800' }} rounded-2xl hover:border-amber-500/50 transition-all">
        <div class="flex items-start gap-4">
            {{-- Icône --}}
            <div class="shrink-0">
                <div class="{{ $compact ? 'w-12 h-12' : 'w-16 h-16' }} rounded-full {{ $earned ? 'bg-linear-to-r from-amber-500 to-yellow-500' : 'bg-gray-800' }} flex items-center justify-center">
                    <svg class="{{ $compact ? 'w-6 h-6' : 'w-8 h-8' }} {{ $earned ? 'text-white' : 'text-gray-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
            </div>
            
            {{-- Contenu --}}
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
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
                    
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full {{ $earned ? 'bg-emerald-500/20 text-emerald-400' : 'bg-gray-700 text-gray-300' }} text-xs">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $achievement->points_reward }} pts
                    </span>
                </div>
                
                <h4 class="{{ $compact ? 'text-md' : 'text-lg' }} font-bold {{ $earned ? 'text-white' : 'text-gray-400' }} mb-1">
                    {{ $achievement->name }}
                </h4>
                
                <p class="text-sm {{ $earned ? 'text-gray-300' : 'text-gray-500' }} mb-3">
                    {{ $achievement->description }}
                </p>
                
                {{-- Informations supplémentaires --}}
                <div class="flex items-center justify-between text-xs text-gray-500">
                    @if($achievement->category)
                        <span class="capitalize">{{ $achievement->category }}</span>
                    @endif
                    
                    @if($earned && $achievement->earned_at)
                        <span>Obtenue le {{ \Carbon\Carbon::parse($achievement->earned_at)->format('d/m/Y') }}</span>
                    @elseif(!$earned && $achievement->criteria)
                        <span class="text-amber-500">À débloquer</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif