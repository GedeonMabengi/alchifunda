<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 relative">
        <svg class="h-5 w-5 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <span id="unread-notifications-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">
            0
        </span>
    </button>

    <div x-show="open" @click.away="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-md shadow-lg overflow-hidden z-50 border border-gray-200 dark:border-gray-700">
        
        <div class="py-2">
            <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Notifications</h3>
                    <a href="{{ route('notification.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                        Voir tout
                    </a>
                </div>
            </div>
            
            <div class="max-h-96 overflow-y-auto">
                {{-- // $notifications = Auth::user()->notifications()->latest()->take(5)->get(); --}}
                @php
                    // @php
                    $notifications = Auth::check() 
    ? \App\Models\Notification::where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get() 
    : collect([]);

                    // @endphp
                @endphp
                
                @if($notifications->isEmpty())
                    <div class="px-4 py-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Aucune notification
                        </p>
                    </div>
                @else
                    @foreach($notifications as $notification)
                        <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700 {{ !$notification->is_read ? 'bg-blue-50 dark:bg-gray-700' : '' }}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @switch($notification->type)
                                        @case('achievement')
                                            <svg class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                            </svg>
                                            @break
                                        @case('lesson_completed')
                                            <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            @break
                                        @case('assessment')
                                            <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                            </svg>
                                            @break
                                        @default
                                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                    @endswitch
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $notification->message }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                @if(!$notification->is_read)
                                    <form method="POST" action="{{ route('notification.read', $notification->id) }}">
                                        @csrf
                                        <button type="submit" class="ml-2 text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                                            Marquer lu
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            
            @if($notifications->isNotEmpty())
                <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('notification.read-all') }}">
                        @csrf
                        <button type="submit" class="w-full text-center text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                            Tout marquer comme lu
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>