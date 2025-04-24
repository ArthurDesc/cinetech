<x-app-layout>
    <div class="container mx-auto px-2 sm:px-4 py-8">
        <h1 class="text-3xl font-extrabold text-primary mb-10 tracking-tight drop-shadow-lg">Mes Favoris</h1>

        {{-- Films favoris --}}
        <section class="mb-12 bg-black/60 rounded-xl p-6 shadow-lg" aria-labelledby="fav-films-title">
            <h2 id="fav-films-title" class="text-2xl font-bold text-primary mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z" />
                </svg>
                Films
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($movieFavorites as $movie)
                <x-movie-card :movie="$movie" />
                @empty
                <p class="text-white col-span-full">Aucun film en favoris</p>
                @endforelse
            </div>
        </section>

        {{-- Séries favorites --}}
        <section class="mb-12 bg-black/60 rounded-xl p-6 shadow-lg" aria-labelledby="fav-series-title">
            <h2 id="fav-series-title" class="text-2xl font-bold text-primary mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z" />
                </svg>
                Séries
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($tvFavorites as $show)
                <x-tv-shows.show-card :show="$show" />
                @empty
                <p class="text-white col-span-full">Aucune série en favoris</p>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>