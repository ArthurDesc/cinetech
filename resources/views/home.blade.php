<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        {{-- Carousel Section --}}
        <x-carousel :slides="$carouselMovies" />

        {{-- Hero Section --}}
        <section class="text-center mb-16">
            <h1 class="text-4xl font-bold text-white mb-4">
                Bienvenue sur notre plateforme
            </h1>
            <p class="text-gray-300 text-xl mb-8">
                Découvrez les meilleurs films et séries
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 px-4">
                <a href="{{ route('movies.index') }}"
                   class="w-full sm:w-auto text-center bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg transition duration-300">
                    Explorer les Films
                </a>
                <a href="{{ route('tvshows.index') }}"
                   class="w-full sm:w-auto text-center bg-dark-light hover:bg-dark-lighter text-white px-6 py-3 rounded-lg transition duration-300">
                    Explorer les Séries
                </a>
            </div>
        </section>

        {{-- Featured Content --}}
        <div class="grid md:grid-cols-2 gap-8">
            {{-- Films Populaires --}}
            <section>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-white">Films Populaires</h2>
                    <a href="{{ route('movies.index') }}" class="text-primary-500 hover:text-primary-400">
                        Voir plus
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($popularMovies as $movie)
                        <x-movie-card :movie="$movie" />
                    @endforeach
                </div>
            </section>

            {{-- Séries Populaires --}}
            <section>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-white">Séries Populaires</h2>
                    <a href="{{ route('tvshows.index') }}" class="text-primary-500 hover:text-primary-400">
                        Voir plus
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($popularShows as $show)
                        <x-tv-shows.show-card :show="$show" />
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
