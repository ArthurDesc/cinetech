<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        {{-- Détails du film --}}
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Poster du film et bouton favoris --}}
            <div class="w-full md:w-1/3">
                <img src="{{ config('services.tmdb.image_base_url') . $movie['poster_path'] }}"
                     alt="{{ $movie['title'] }}"
                     class="w-full rounded-lg shadow-lg mb-4">

                <x-favorite-button
                    :tmdbId="$movie['id']"
                    type="movie"
                />
            </div>

            {{-- Informations du film --}}
            <div class="w-full md:w-2/3">
                <h1 class="text-3xl font-bold mb-4 text-white">
                    {{ $movie['title'] }}
                </h1>
                <p class="text-white mb-4">
                    {{ $movie['overview'] }}
                </p>

                {{-- Informations supplémentaires --}}
                <div class="mb-4 space-y-2">
                    <p class="text-gray-300">
                        Date de sortie : <span class="text-primary-500">{{ $movie['release_date'] }}</span>
                    </p>
                    <p class="text-gray-300">
                        Note : <span class="text-primary-500">{{ $movie['vote_average'] }}/10</span>
                    </p>
                    <p class="text-gray-300">
                        Réalisateur : <span class="text-primary-500">
                            {{ collect($movie['credits']['crew'])->where('job', 'Director')->first()['name'] ?? 'Non disponible' }}
                        </span>
                    </p>
                    <p class="text-gray-300">
                        Genres : <span class="text-primary-500">
                            {{ collect($movie['genres'])->pluck('name')->join(', ') }}
                        </span>
                    </p>
                    <p class="text-gray-300">
                        Pays d'origine : <span class="text-primary-500">
                            {{ collect($movie['production_countries'])->pluck('name')->join(', ') }}
                        </span>
                    </p>
                </div>

                {{-- Acteurs principaux --}}
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-white mb-4">Acteurs principaux</h2>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        @foreach(array_slice($movie['credits']['cast'], 0, 5) as $actor)
                            <div class="text-center">
                                <img src="{{ config('services.tmdb.image_base_url') . $actor['profile_path'] }}"
                                     alt="{{ $actor['name'] }}"
                                     class="w-full rounded-lg mb-2">
                                <p class="text-gray-300">{{ $actor['name'] }}</p>
                                <p class="text-white text-sm">{{ $actor['character'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Films similaires --}}
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-white mb-4">Films similaires</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($movie['similar']['results'] as $similar)
                            <x-movie-card :movie="$similar" />
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
    </div>

    {{-- Section Commentaires --}}
    <x-comments :tmdb-id="$movie['id']" type="movie" />
</x-app-layout>
