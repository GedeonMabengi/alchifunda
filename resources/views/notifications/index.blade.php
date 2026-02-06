@extends('layouts.app')

@section('title', 'Notifications - ALCHIFUNDA')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Notifications</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Restez informé de vos activités et progrès
                </p>
            </div>
            
            <div class="mt-4 md:mt-0">
                @if($notifications->where('is_read', false)->count() > 0)
                    <form action="{{ route('notification.read-all') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Tout marquer comme lu
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $notifications->count() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Total</div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $notifications->where('is_read', false)->count() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Non lues</div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $notifications->where('is_read', true)->count() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Lues</div>
            </div>
        </div>
    </div>

    <!-- Liste des notifications -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
        @if($notifications->count() > 0)
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($notifications as $notification)
                    <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition 
                        {{ !$notification->is_read ? 'bg-blue-50 dark:bg-gray-700' : '' }}">
                        <div class="flex">
                            <!-- Icône -->
                            <div class="flex-shrink-0 mr-4">
                                @switch($notification->type)
                                    @case('achievement')
                                        <div class="h-10 w-10 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-yellow-600 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                            </svg>
                                        </div>
                                        @break
                                    @case('lesson_completed')
                                        <div class="h-10 w-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        @break
                                    @case('assessment')
                                        <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                            </svg>
                                        </div>
                                        @break
                                    @case('reminder')
                                        <div class="h-10 w-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-purple-600 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        @break
                                    @default
                                        <div class="h-10 w-10 rounded-full bg-gray-100 dark:bg-gray-900 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                @endswitch
                            </div>
                            
                            <!-- Contenu -->
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <div>
                                        <p class="text-gray-900 dark:text-white">
                                            {{ $notification->message }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    
                                    <div class="flex items-start space-x-2">
                                        @if(!$notification->is_read)
                                            <form action="{{ route('notification.read', $notification->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" 
                                                        class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                                                    Marquer lu
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('notification.destroy', $notification->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-xs text-red-600 dark:text-red-400 hover:underline">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                @if($notification->data)
                                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        @php
                                            $data = json_decode($notification->data, true);
                                        @endphp
                                        @if(isset($data['lesson_title']))
                                            <div class="inline-flex items-center text-xs px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                                {{ $data['lesson_title'] }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $notifications->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <h3 class="mt-6 text-lg font-medium text-gray-900 dark:text-white">Aucune notification</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Vous n'avez pas encore de notification.
                </p>
            </div>
        @endif
    </div>

    <!-- Actions supplémentaires -->
    @if($notifications->count() > 0)
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-between">
            <form action="{{ route('notification.read-all') }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tout marquer comme lu
                </button>
            </form>
            
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Les notifications sont automatiquement supprimées après 30 jours.
            </div>
        </div>
    @endif
</div>
@endsection