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
        <h2 class="text-2xl font-medium text-white">Menu</h2>
        <button @click="open = false" class="text-white hover:text-primary-500">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Contenu du menu -->
    <div class="px-6 py-8 space-y-8">
        <!-- Barre de recherche -->
        <div class="mb-8">
            <form action="{{ route('search') }}" method="GET" x-data="autocompleteSearchMobile()" @keydown.escape="closeList" autocomplete="off">
                <div class="relative">
                    <input type="text"
                           name="query"
                           placeholder="Rechercher..."
                           x-model="query"
                           @input.debounce.300ms="fetchSuggestions"
                           @focus="openList"
                           @keydown.arrow-down.prevent="highlightNext"
                           @keydown.arrow-up.prevent="highlightPrev"
                           @keydown.enter.prevent="goToHighlighted"
                           @blur="closeListWithDelay"
                           value="{{ request('query') }}"
                           class="w-full px-4 py-3 text-lg bg-dark text-white rounded-lg border border-dark-lighter focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500"
                           aria-autocomplete="list"
                           aria-controls="autocomplete-list-mobile"
                           aria-expanded="open"
                    >
                    <button type="submit"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-white hover:text-primary-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <!-- Suggestions -->
                    <div x-show="open && suggestions.length > 0" x-transition class="absolute left-0 right-0 mt-2 bg-dark-light border border-dark-lighter rounded-lg shadow-lg z-50 max-h-72 overflow-y-auto" @mousedown.away="closeList" id="autocomplete-list-mobile" role="listbox">
                        <template x-for="(item, index) in suggestions" :key="item.id + '-' + item.media_type">
                            <a :href="item.media_type === 'movie' ? '/movies/' + item.id : '/tv-shows/' + item.id"
                               class="flex items-center px-3 py-2 cursor-pointer hover:bg-primary-600/20 transition-colors duration-150"
                               :class="{ 'bg-primary-600/30': highlightedIndex === index }"
                               @mouseenter="highlightedIndex = index"
                               @mouseleave="highlightedIndex = -1"
                               @mousedown.prevent="goTo(index)"
                               role="option"
                               :aria-selected="highlightedIndex === index">
                                <img :src="item.poster_url" alt="" class="w-7 h-10 object-cover rounded mr-2 bg-dark-lighter flex-shrink-0">
                                <div class="flex flex-col">
                                    <span class="text-white text-sm font-medium" x-text="item.title"></span>
                                    <span class="text-xs text-gray-400 capitalize" x-text="item.media_type === 'movie' ? 'Film' : 'Série'"></span>
                                </div>
                            </a>
                        </template>
                    </div>
                    <!-- Aucun résultat -->
                    <div x-show="open && query.length >= 2 && suggestions.length === 0 && !loading" x-transition class="absolute left-0 right-0 mt-2 bg-dark-light border border-dark-lighter rounded-lg shadow-lg z-50 p-3 text-center text-gray-400 text-sm">
                        Aucun résultat trouvé
                    </div>
                    <!-- Chargement -->
                    <div x-show="open && loading" x-transition class="absolute left-0 right-0 mt-2 bg-dark-light border border-dark-lighter rounded-lg shadow-lg z-50 p-3 text-center text-primary-500 text-sm">
                        Recherche...
                    </div>
                </div>
            </form>
        </div>

        @auth
            <!-- Informations utilisateur -->
            <div class="pb-6 border-b border-dark-lighter text-center">
                <p class="text-xl font-medium text-white">{{ Auth::user()->nickname }}</p>
            </div>
        @endauth

        <!-- Navigation -->
        <nav class="space-y-6 text-center">
            <a href="{{ route('movies.index') }}"
               class="block text-xl font-medium text-white hover:text-primary-500 {{ request()->routeIs('movies.index') ? 'text-primary-500' : '' }}">
                Films
            </a>
            <a href="{{ route('tvshows.index') }}"
               class="block text-xl font-medium text-white hover:text-primary-500 {{ request()->routeIs('tvshows.index') ? 'text-primary-500' : '' }}">
                Séries
            </a>

            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="block text-xl font-medium text-white hover:text-primary-500 {{ request()->routeIs('admin.dashboard') ? 'text-primary-500' : '' }}">
                        Administration
                    </a>
                @endif
                <a href="{{ route('profile.edit') }}"
                   class="block text-xl font-medium text-white hover:text-primary-500">
                    Mon compte
                </a>
                <form method="POST" action="{{ route('logout') }}" class="text-center">
                    @csrf
                    <button type="submit"
                            class="w-full text-center text-xl font-medium text-white hover:text-primary-500">
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="block text-xl font-medium text-white hover:text-primary-500">
                    Connexion
                </a>
                <a href="{{ route('register') }}"
                   class="block text-xl font-medium text-white hover:text-primary-500">
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

<script>
function autocompleteSearchMobile() {
    return {
        query: '',
        suggestions: [],
        open: false,
        loading: false,
        highlightedIndex: -1,
        fetchSuggestions() {
            if (this.query.length < 2) {
                this.suggestions = [];
                this.open = false;
                return;
            }
            this.loading = true;
            fetch(`/api/autocomplete?query=${encodeURIComponent(this.query)}`)
                .then(res => res.json())
                .then(data => {
                    this.suggestions = data;
                    this.loading = false;
                    this.open = true;
                    this.highlightedIndex = -1;
                })
                .catch(() => {
                    this.suggestions = [];
                    this.loading = false;
                    this.open = true;
                });
        },
        openList() {
            if (this.suggestions.length > 0) this.open = true;
        },
        closeList() {
            this.open = false;
            this.highlightedIndex = -1;
        },
        closeListWithDelay() {
            setTimeout(() => this.closeList(), 100);
        },
        highlightNext() {
            if (!this.open || this.suggestions.length === 0) return;
            this.highlightedIndex = (this.highlightedIndex + 1) % this.suggestions.length;
        },
        highlightPrev() {
            if (!this.open || this.suggestions.length === 0) return;
            this.highlightedIndex = (this.highlightedIndex - 1 + this.suggestions.length) % this.suggestions.length;
        },
        goToHighlighted() {
            if (this.highlightedIndex >= 0 && this.suggestions[this.highlightedIndex]) {
                this.goTo(this.highlightedIndex);
            }
        },
        goTo(index) {
            const item = this.suggestions[index];
            if (item) {
                window.location.href = item.media_type === 'movie' ? `/movies/${item.id}` : `/tv-shows/${item.id}`;
            }
        }
    }
}
</script>
