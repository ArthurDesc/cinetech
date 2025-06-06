<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        {{-- Détails de la série --}}
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Poster de la série --}}
            <div class="w-full md:w-1/3">
                <img src="{{ $show['poster_url'] }}"
                     alt="{{ $show['name'] }}"
                     class="w-full rounded-lg shadow-lg mb-4">

                {{-- Bouton Favoris normal --}}
                <x-favorite-button
                    :tmdbId="$show['id']"
                    type="tv"
                />
            </div>

            {{-- Informations de la série --}}
            <div class="w-full md:w-2/3">
                <h1 class="text-3xl font-bold mb-4 text-white">
                    {{ $show['name'] }}
                </h1>
                <p class="text-white mb-4">
                    {{ $show['overview'] }}
                </p>

                {{-- Informations supplémentaires --}}
                <div class="mb-4 space-y-2">
                    <p class="text-white">
                        Première diffusion : <span class="text-primary-500">{{ $show['first_air_date'] }}</span>
                    </p>
                    <p class="text-white">
                        Note : <span class="text-primary-500">{{ $show['vote_average'] }}/10</span>
                    </p>
                    <p class="text-white">
                        Créateur : <span class="text-primary-500">
                            {{ collect($show['created_by'])->pluck('name')->join(', ') ?: 'Non disponible' }}
                        </span>
                    </p>
                    <p class="text-white">
                        Genres : <span class="text-primary-500">
                            {{ collect($show['genres'])->pluck('name')->join(', ') }}
                        </span>
                    </p>
                    <p class="text-white">
                        Pays d'origine : <span class="text-primary-500">
                            {{ collect($show['origin_country'])->join(', ') }}
                        </span>
                    </p>
                    <p class="text-white">
                        Chaîne de diffusion : <span class="text-primary-500">
                            {{ collect($show['networks'])->pluck('name')->join(', ') }}
                        </span>
                    </p>
                    <p class="text-white">
                        Nombre de saisons : <span class="text-primary-500">{{ $show['number_of_seasons'] }}</span>
                    </p>
                    <p class="text-white">
                        Nombre d'épisodes : <span class="text-primary-500">{{ $show['number_of_episodes'] }}</span>
                    </p>
                </div>

                {{-- Acteurs principaux --}}
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-white mb-4">Acteurs principaux</h2>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        @forelse($show['credits']['cast'] as $actor)
                            <div class="text-center">
                                <img src="{{ $actor['profile_url'] }}"
                                     alt="{{ $actor['name'] }}"
                                     class="w-full h-48 object-cover rounded-lg mb-2"
                                     onerror='this.src="{{ asset('images/placeholder-actor.jpg') }}"'>
                                <p class="text-white">{{ $actor['name'] }}</p>
                                <p class="text-white text-sm">{{ $actor['character'] }}</p>
                            </div>
                        @empty
                            <p class="text-white col-span-5">Aucun acteur disponible</p>
                        @endforelse
                    </div>
                </div>

                {{-- Séries similaires --}}
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-white mb-4">Séries similaires</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach(array_slice($show['similar']['results'], 0, 4) as $similar)
                            <x-tv-shows.show-card :show="$similar" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Commentaires --}}
    <x-comments :tmdb-id="$show['id']" type="tv" />
</x-app-layout>
