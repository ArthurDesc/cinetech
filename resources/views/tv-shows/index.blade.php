<x-app-layout>
    <div class="container mx-auto px-4 py-8 bg-dark">
        {{-- Séries Populaires --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-100">Séries Populaires</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($popularShows as $show)
                    <x-tv-shows.show-card :show="$show" />
                @endforeach
            </div>
        </section>

        {{-- Séries les mieux notées --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-100">Séries les mieux notées</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($topRatedShows as $show)
                    <x-tv-shows.show-card :show="$show" />
                @endforeach
            </div>
        </section>

        {{-- Séries en cours de diffusion --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-100">Séries en cours de diffusion</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($onAirShows as $show)
                    <x-tv-shows.show-card :show="$show" />
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>
