<div class="flex flex-col h-full">
    <!-- Logo avec effet spécial -->
    <div class="flex items-center justify-center h-20 flex-shrink-0 px-4 border-b border-white/10">
        <a href="{{ route('dashboard') }}" class="relative group">
            <div class="text-2xl font-bold bg-gradient-to-r from-brand to-cyan-400 bg-clip-text text-transparent">
                ALCHIFUNDA
            </div>
            <div class="absolute -inset-1 bg-brand/20 blur-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </a>
    </div>

    <!-- Navigation -->
    <div class="flex-1 flex flex-col overflow-y-auto py-4">
        <nav class="flex-1 px-4 space-y-2">
            <!-- Tableau de bord -->
            <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'bg-brand/20 text-white border-l-4 border-brand' : 'text-gray-400 hover:text-white hover:bg-white/5' }} group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                <div class="mr-3 flex items-center justify-center w-6 h-6">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                Tableau de bord
            </a>

            <!-- Section Apprentissage -->
            <div class="space-y-2">
                <div class="px-4 pt-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Apprentissage
                </div>
                
                <a href="{{ route('level.index') }}"
                    class="{{ request()->routeIs('level.*') ? 'bg-brand/20 text-white border-l-4 border-brand' : 'text-gray-400 hover:text-white hover:bg-white/5' }} group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <div class="mr-3 flex items-center justify-center w-6 h-6">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    Niveaux
                </a>
                
                <a href="{{ route('chapter.index') }}"
                    class="{{ request()->routeIs('chapter.*') ? 'bg-brand/20 text-white border-l-4 border-brand' : 'text-gray-400 hover:text-white hover:bg-white/5' }} group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <div class="mr-3 flex items-center justify-center w-6 h-6">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    Chapitres
                </a>
            </div>

            <!-- Section Progression -->
            <div class="space-y-2">
                <div class="px-4 pt-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Progression
                </div>
                
                <a href="{{ route('progress.index') }}"
                    class="{{ request()->routeIs('progress.*') ? 'bg-brand/20 text-white border-l-4 border-brand' : 'text-gray-400 hover:text-white hover:bg-white/5' }} group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <div class="mr-3 flex items-center justify-center w-6 h-6">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    Statistiques
                </a>
                
                <a href="{{ route('achievement.index') }}"
                    class="{{ request()->routeIs('achievement.*') ? 'bg-brand/20 text-white border-l-4 border-brand' : 'text-gray-400 hover:text-white hover:bg-white/5' }} group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <div class="mr-3 flex items-center justify-center w-6 h-6">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    Récompenses
                </a>
            </div>

            <!-- Section Aide -->
            <div class="space-y-2">
                <div class="px-4 pt-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Aide & Assistant
                </div>
                
                <a href="{{ route('ai.history') }}"
                    class="{{ request()->routeIs('ai.*') ? 'bg-brand/20 text-white border-l-4 border-brand' : 'text-gray-400 hover:text-white hover:bg-white/5' }} group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <div class="mr-3 flex items-center justify-center w-6 h-6">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    Assistant IA
                </a>
            </div>
        </nav>
    </div>

    <!-- Version et Profil -->
    <div class="flex-shrink-0 border-t border-white/10 p-4">
        <div class="flex items-center justify-between">
            <div class="text-xs text-gray-500">
                ALCHIFUNDA v1.0
            </div>
            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-brand to-cyan-400 flex items-center justify-center text-xs font-bold">
                {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'A' }}
            </div>
        </div>
    </div>
</div>