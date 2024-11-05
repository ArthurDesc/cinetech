<x-app-layout>
    <div class="container mx-auto px-4 py-8 bg-dark">
        {{-- Films Populaires --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-100">Films Populaires</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($popularMovies as $movie)
                    <x-movie-card :movie="$movie" />
                @endforeach
            </div>
        </section>

        {{-- Films les mieux notés --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-100">Films les mieux notés</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($topRatedMovies as $movie)
                    <x-movie-card :movie="$movie" />
                @endforeach
            </div>
        </section>

        {{-- Films à venir --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-100">Films à venir</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($upcomingMovies as $movie)
                    <x-movie-card :movie="$movie" />
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>
