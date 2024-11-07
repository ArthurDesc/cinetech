<x-app-layout>
    {{-- Contenu principal --}}
    <div class="container mx-auto px-4 py-8">
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

        {{-- Section Carousel intégrée --}}
        <section class="mb-16">
            <h2 class="text-2xl font-bold text-white mb-6">À l'affiche</h2>
            <div class="rounded-xl overflow-hidden shadow-xl">
                <x-carousel>
                    @foreach($carouselMovies as $movie)
                        <div class="embla__slide">
                            <div class="relative h-[400px] w-full">
                                {{-- Overlay sombre pour améliorer la lisibilité --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent z-10"></div>

                                {{-- Image de fond --}}
                                <img src="{{ $movie['image'] }}"
                                     alt="{{ $movie['title'] }}"
                                     class="w-full h-full object-cover">

                                {{-- Contenu du slide --}}
                                <div class="absolute inset-x-0 bottom-0 z-20 p-6">
                                    <div class="max-w-3xl mx-auto">
                                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-2">
                                            {{ $movie['title'] }}
                                        </h3>
                                        <p class="text-sm md:text-base text-gray-200 mb-4 line-clamp-2">
                                            {{ $movie['overview'] }}
                                        </p>
                                        <a href="{{ route('movies.show', $movie['id']) }}"
                                           class="inline-block bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition duration-300 text-sm">
                                            En savoir plus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </x-carousel>
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
