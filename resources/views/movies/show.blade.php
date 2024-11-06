<x-app-layout>
    <div class="container mx-auto px-4 py-8 bg-dark">
        {{-- Détails du film --}}
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Poster du film --}}
            <div class="w-full md:w-1/3">
                <img src="{{ config('services.tmdb.image_base_url') . $movie['poster_path'] }}"
                     alt="{{ $movie['title'] }}"
                     class="w-full rounded-lg shadow-lg">
            </div>

            {{-- Informations du film --}}
            <div class="w-full md:w-2/3">
                <h1 class="text-3xl font-bold mb-4 text-white">
                    {{ $movie['title'] }}
                </h1>
                <p class="text-gray-400 mb-4">
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

                {{-- Ajouter près des informations du film --}}
                @auth
                    <button
                        x-data="{ isFavorite: false }"
                        x-init="
                            fetch('{{ route('favorites.check') }}?tmdb_id={{ $movie['id'] }}&type=movie')
                                .then(response => response.json())
                                .then(data => isFavorite = data.isFavorite)
                        "
                        @click="
                            fetch('{{ route('favorites.toggle') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    tmdb_id: {{ $movie['id'] }},
                                    type: 'movie'
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                isFavorite = data.status === 'added';
                            });
                        "
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition duration-300"
                        :class="isFavorite ? 'bg-primary-600 text-white' : 'bg-dark-lighter text-gray-300'"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="isFavorite ? 'fill-current' : 'stroke-current'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span x-text="isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris'"></span>
                    </button>
                @else
                    <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-400">
                        Connectez-vous pour ajouter aux favoris
                    </a>
                @endauth

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
                                <p class="text-gray-400 text-sm">{{ $actor['character'] }}</p>
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
</x-app-layout>
