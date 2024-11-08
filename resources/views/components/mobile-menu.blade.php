<div x-show="open"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="translate-x-full"
     @click.away="open = false"
     class="fixed top-0 right-0 w-3/4 h-full bg-dark-light border-l border-dark-lighter transform z-50 overflow-auto pointer-events-auto">

    <!-- En-tête du menu -->
    <div class="flex items-center justify-between p-6 border-b border-dark-lighter">
        <h2 class="text-2xl font-medium text-gray-400">Menu</h2>
        <button @click="open = false" class="text-gray-400 hover:text-primary-500">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Contenu du menu -->
    <div class="px-6 py-8 space-y-8">
        <!-- Barre de recherche -->
        <div class="mb-8">
            <form action="{{ route('search') }}" method="GET">
                <div class="relative">
                    <input type="text"
                           name="query"
                           placeholder="Rechercher..."
                           value="{{ request('query') }}"
                           class="w-full px-4 py-3 text-lg bg-dark text-gray-400 rounded-lg
                                 border border-dark-lighter focus:outline-none
                                 focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                    <button type="submit"
                            class="absolute right-3 top-1/2 -translate-y-1/2
                                   text-gray-400 hover:text-primary-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        @auth
            <!-- Informations utilisateur -->
            <div class="pb-6 border-b border-dark-lighter text-center">
                <p class="text-xl font-medium text-gray-400">{{ Auth::user()->name }}</p>
            </div>
        @endauth

        <!-- Navigation -->
        <nav class="space-y-6 text-center">
            <a href="{{ route('movies.index') }}"
               class="block text-xl font-medium text-gray-400 hover:text-primary-500 {{ request()->routeIs('movies.index') ? 'text-primary-500' : '' }}">
                Films
            </a>
            <a href="{{ route('tvshows.index') }}"
               class="block text-xl font-medium text-gray-400 hover:text-primary-500 {{ request()->routeIs('tvshows.index') ? 'text-primary-500' : '' }}">
                Séries
            </a>

            @auth
                <a href="{{ route('profile.edit') }}"
                   class="block text-xl font-medium text-gray-400 hover:text-primary-500">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="text-center">
                    @csrf
                    <button type="submit"
                            class="w-full text-center text-xl font-medium text-gray-400 hover:text-primary-500">
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="block text-xl font-medium text-gray-400 hover:text-primary-500">
                    Connexion
                </a>
                <a href="{{ route('register') }}"
                   class="block text-xl font-medium text-gray-400 hover:text-primary-500">
                    Inscription
                </a>
            @endauth
        </nav>
    </div>
</div>

<!-- Overlay sombre -->
<div x-show="open"
     x-transition:enter="transition-opacity ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-in duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="open = false"
     class="fixed inset-0 bg-black bg-opacity-50 z-40 pointer-events-auto">
</div>