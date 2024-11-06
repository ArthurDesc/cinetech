<x-app-layout>
    <div class="container mx-auto px-4 py-8 bg-dark">
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
                <p class="text-gray-400 mb-4">
                    {{ $show['overview'] }}
                </p>

                {{-- Informations supplémentaires --}}
                <div class="mb-4 space-y-2">
                    <p class="text-gray-300">
                        Première diffusion : <span class="text-primary-500">{{ $show['first_air_date'] }}</span>
                    </p>
                    <p class="text-gray-300">
                        Note : <span class="text-primary-500">{{ $show['vote_average'] }}/10</span>
                    </p>
                    <p class="text-gray-300">
                        Créateur : <span class="text-primary-500">
                            {{ collect($show['created_by'])->pluck('name')->join(', ') ?: 'Non disponible' }}
                        </span>
                    </p>
                    <p class="text-gray-300">
                        Genres : <span class="text-primary-500">
                            {{ collect($show['genres'])->pluck('name')->join(', ') }}
                        </span>
                    </p>
                    <p class="text-gray-300">
                        Pays d'origine : <span class="text-primary-500">
                            {{ collect($show['origin_country'])->join(', ') }}
                        </span>
                    </p>
                    <p class="text-gray-300">
                        Chaîne de diffusion : <span class="text-primary-500">
                            {{ collect($show['networks'])->pluck('name')->join(', ') }}
                        </span>
                    </p>
                    <p class="text-gray-300">
                        Nombre de saisons : <span class="text-primary-500">{{ $show['number_of_seasons'] }}</span>
                    </p>
                    <p class="text-gray-300">
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
                                     onerror="this.src='{{ asset('images/placeholder-actor.jpg') }}'">
                                <p class="text-gray-300">{{ $actor['name'] }}</p>
                                <p class="text-gray-400 text-sm">{{ $actor['character'] }}</p>
                            </div>
                        @empty
                            <p class="text-gray-400 col-span-5">Aucun acteur disponible</p>
                        @endforelse
                    </div>
                </div>

                {{-- Séries similaires --}}
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-white mb-4">Séries similaires</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($show['similar']['results'] as $similar)
                            <x-tv-shows.show-card :show="$similar" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Commentaires --}}
    <div class="container mx-auto px-4 py-8 bg-dark">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-semibold text-white mb-6">Commentaires</h2>

            {{-- Formulaire d'ajout de commentaire --}}
            @auth
                <form x-data="{ content: '' }"
                      @submit.prevent="
                        fetch('{{ route('comments.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                tmdb_id: {{ $show['id'] }},
                                type: 'tv',
                                content: content
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            content = '';
                            window.location.reload();
                        })">
                    <div class="mb-4">
                        <textarea x-model="content"
                                class="w-full px-4 py-2 rounded-lg bg-dark-lighter text-gray-300 border border-dark-lighter focus:outline-none focus:border-primary-500"
                                rows="3"
                                placeholder="Ajouter un commentaire..."></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition"
                                :disabled="!content.trim()">
                            Publier
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center py-4 bg-dark-lighter rounded-lg">
                    <p class="text-gray-400">
                        <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-400">Connectez-vous</a>
                        pour laisser un commentaire
                    </p>
                </div>
            @endauth

            {{-- Liste des commentaires --}}
            <div x-data="{ comments: [] }"
                 x-init="
                    fetch('{{ route('comments.index') }}?tmdb_id={{ $show['id'] }}&type=tv')
                        .then(response => response.json())
                        .then(data => comments = data)">
                <template x-for="comment in comments" :key="comment.id">
                    <div class="mt-6 bg-dark-lighter rounded-lg p-4">
                        {{-- En-tête du commentaire --}}
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <span class="text-primary-500 font-semibold" x-text="comment.user.name"></span>
                                <span class="text-gray-400 text-sm" x-text="new Date(comment.created_at).toLocaleDateString()"></span>
                            </div>

                            {{-- Options du commentaire --}}
                            @auth
                                <template x-if="comment.user_id === {{ auth()->id() }}">
                                    <div class="flex items-center gap-2">
                                        <button @click="
                                            if(confirm('Supprimer ce commentaire ?')) {
                                                fetch(`/comments/${comment.id}`, {
                                                    method: 'DELETE',
                                                    headers: {
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    }
                                                }).then(() => window.location.reload())
                                            }"
                                            class="text-red-500 hover:text-red-400">
                                            Supprimer
                                        </button>
                                    </div>
                                </template>
                            @endauth
                        </div>

                        {{-- Contenu du commentaire --}}
                        <p class="text-gray-300" x-text="comment.content"></p>

                        {{-- Réponses --}}
                        <template x-if="comment.replies && comment.replies.length > 0">
                            <div class="mt-4 ml-8 space-y-4">
                                <template x-for="reply in comment.replies" :key="reply.id">
                                    <div class="bg-dark rounded-lg p-3">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-primary-500" x-text="reply.user.name"></span>
                                            <span class="text-gray-400 text-sm" x-text="new Date(reply.created_at).toLocaleDateString()"></span>
                                        </div>
                                        <p class="text-gray-300" x-text="reply.content"></p>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>
