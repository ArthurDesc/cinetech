<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        {{-- Films Populaires --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Films Populaires</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($popularMovies as $movie)
                    <div class="movie-card">
                        <a href="{{ route('movies.show', $movie['id']) }}">
                        <img src="{{ config('services.tmdb.image_base_url') . $movie['poster_path'] }}"
                             alt="{{ $movie['title'] }}">
                        <h3>{{ $movie['title'] }}</h3>
                        Voir plus</a>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Films les mieux notés --}}
        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Films les mieux notés</h2>
            {{-- Même structure que pour les films populaires --}}
        </section>
    </div>
</x-app-layout>
