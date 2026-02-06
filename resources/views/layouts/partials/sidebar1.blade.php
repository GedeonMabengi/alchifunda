<div class="flex flex-col h-full bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 flex-shrink-0 px-4 border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
            ALCHIFUNDA
        </a>
    </div>

    <!-- Navigation -->
    <div class="flex-1 flex flex-col overflow-y-auto">
        <nav class="flex-1 px-2 py-4 space-y-1">
            <!-- Tableau de bord -->
            <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'bg-indigo-50 dark:bg-gray-700 text-indigo-600 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Tableau de bord
            </a>

            <!-- Apprentissage -->
            <div class="space-y-1">
                <div class="px-2 pt-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Apprentissage
                </div>
                <a href="{{ route('level.index') }}"
                    class="{{ request()->routeIs('level.*') ? 'bg-indigo-50 dark:bg-gray-700 text-indigo-600 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Niveaux
                </a>
                <a href="{{ route('chapter.index') }}"
                    class="{{ request()->routeIs('chapter.*') ? 'bg-indigo-50 dark:bg-gray-700 text-indigo-600 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Chapitres
                </a>
            </div>

            <!-- Progression -->
            <div class="space-y-1">
                <div class="px-2 pt-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Progression
                </div>
                <a href="{{ route('progress.index') }}"
                    class="{{ request()->routeIs('progress.*') ? 'bg-indigo-50 dark:bg-gray-700 text-indigo-600 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Statistiques
                </a>
                <a href="{{ route('achievement.index') }}"
                    class="{{ request()->routeIs('achievement.*') ? 'bg-indigo-50 dark:bg-gray-700 text-indigo-600 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    Récompenses
                </a>
            </div>

            <!-- Aide -->
            <div class="space-y-1">
                <div class="px-2 pt-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Aide
                </div>
                <a href="{{ route('ai.history') }}"
                    class="{{ request()->routeIs('ai.*') ? 'bg-indigo-50 dark:bg-gray-700 text-indigo-600 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    Assistant IA
                </a>
            </div>
        </nav>
    </div>

    <!-- Version -->
    <div class="flex-shrink-0 flex border-t border-gray-200 dark:border-gray-700 p-4">
        <div class="w-full text-center text-xs text-gray-500 dark:text-gray-400">
            ALCHIFUNDA v1.0
        </div>
    </div>
</div>