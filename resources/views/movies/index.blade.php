<x-app-layout>
    <div class="container mx-auto px-4 py-8 bg-white dark:bg-gray-900">
        {{-- Films Populaires --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Films Populaires</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($popularMovies as $movie)
                    <x-movie-card :movie="$movie" />
                @endforeach
            </div>
        </section>

        {{-- Films les mieux notés --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Films les mieux notés</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($topRatedMovies as $movie)
                    <x-movie-card :movie="$movie" />
                @endforeach
            </div>
        </section>

        {{-- Films à venir --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Films à venir</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($upcomingMovies as $movie)
                    <x-movie-card :movie="$movie" />
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>
