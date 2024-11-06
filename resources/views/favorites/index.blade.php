<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-white mb-8">Mes Favoris</h1>

        {{-- Films favoris --}}
        <section class="mb-12">
            <h2 class="text-xl font-semibold text-white mb-4">Films</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @forelse($movieFavorites as $movie)
                    <x-movie-card :movie="$movie" />
                @empty
                    <p class="text-gray-400 col-span-full">Aucun film en favoris</p>
                @endforelse
            </div>
        </section>

        {{-- Séries favorites --}}
        <section class="mb-12">
            <h2 class="text-xl font-semibold text-white mb-4">Séries</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @forelse($tvFavorites as $show)
                    <x-tv-shows.show-card :show="$show" />
                @empty
                    <p class="text-gray-400 col-span-full">Aucune série en favoris</p>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
