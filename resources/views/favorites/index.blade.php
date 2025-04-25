<x-app-layout>
    <div class="container mx-auto px-2 sm:px-4 py-8">
        <h1 class="text-3xl font-extrabold text-primary mb-10 tracking-tight drop-shadow-lg">Mes Favoris</h1>

        <!-- Tabs navigation -->
        <div class="mb-8 flex flex-row flex-wrap gap-2 sm:gap-6">
            <button id="tab-films" type="button" class="tab-btn active" aria-selected="true" aria-controls="panel-films" tabindex="0">
                <span class="flex items-center gap-2">
                    <svg id="icon-films" class="tab-icon h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z" /></svg>
                    Films favoris
                </span>
            </button>
            <button id="tab-series" type="button" class="tab-btn" aria-selected="false" aria-controls="panel-series" tabindex="-1">
                <span class="flex items-center gap-2">
                    <svg id="icon-series" class="tab-icon h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z" /></svg>
                    Séries favorites
                </span>
            </button>
        </div>

        <!-- Tabs panels -->
        <div>
            <section id="panel-films" class="tab-panel" aria-labelledby="tab-films">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($movieFavorites as $movie)
                        <x-movie-card :movie="$movie" />
                    @empty
                        <p class="text-white col-span-full">Aucun film en favoris</p>
                    @endforelse
                </div>
            </section>
            <section id="panel-series" class="tab-panel hidden" aria-labelledby="tab-series">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($tvFavorites as $show)
                        <x-tv-shows.show-card :show="$show" />
                    @empty
                        <p class="text-white col-span-full">Aucune série en favoris</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>

    @push('styles')
    <style>
        .tab-btn {
            @apply px-4 py-2 rounded-lg font-semibold text-white bg-black/40 border-2 border-transparent transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary flex-1 min-w-[140px] text-base whitespace-nowrap;
        }
        .tab-btn.active, .tab-btn[aria-selected="true"] {
            @apply bg-primary text-white border-primary shadow-md;
        }
        .tab-panel { @apply transition-all duration-200; }
        .tab-panel.hidden { display: none; }
        .tab-icon { color: white; transition: color 0.2s; }
        .tab-icon.active { color: var(--color-primary, #ff9800); }
        @media (max-width: 480px) {
            .tab-btn { @apply text-sm px-2 py-2 min-w-[100px]; }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabFilms = document.getElementById('tab-films');
            const tabSeries = document.getElementById('tab-series');
            const panelFilms = document.getElementById('panel-films');
            const panelSeries = document.getElementById('panel-series');
            const iconFilms = document.getElementById('icon-films');
            const iconSeries = document.getElementById('icon-series');

            function setActiveIcon(tab) {
                if(tab === 'films') {
                    iconFilms.classList.add('active');
                    iconSeries.classList.remove('active');
                } else {
                    iconSeries.classList.add('active');
                    iconFilms.classList.remove('active');
                }
            }

            function activateTab(tab) {
                if(tab === 'films') {
                    tabFilms.classList.add('active');
                    tabFilms.setAttribute('aria-selected', 'true');
                    tabFilms.tabIndex = 0;
                    panelFilms.classList.remove('hidden');

                    tabSeries.classList.remove('active');
                    tabSeries.setAttribute('aria-selected', 'false');
                    tabSeries.tabIndex = -1;
                    panelSeries.classList.add('hidden');
                    setActiveIcon('films');
                } else {
                    tabSeries.classList.add('active');
                    tabSeries.setAttribute('aria-selected', 'true');
                    tabSeries.tabIndex = 0;
                    panelSeries.classList.remove('hidden');

                    tabFilms.classList.remove('active');
                    tabFilms.setAttribute('aria-selected', 'false');
                    tabFilms.tabIndex = -1;
                    panelFilms.classList.add('hidden');
                    setActiveIcon('series');
                }
            }

            // Initial state
            setActiveIcon('films');

            tabFilms.addEventListener('click', () => activateTab('films'));
            tabSeries.addEventListener('click', () => activateTab('series'));

            // Accessibilité clavier : flèches gauche/droite
            [tabFilms, tabSeries].forEach(tab => {
                tab.addEventListener('keydown', e => {
                    if(e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
                        e.preventDefault();
                        if(tab === tabFilms) tabSeries.focus();
                        else tabFilms.focus();
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>