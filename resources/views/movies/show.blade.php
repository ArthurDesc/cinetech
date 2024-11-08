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

    {{-- Section Commentaires --}}
    <div class="container mx-auto px-4 py-8">
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
                                tmdb_id: {{ $movie['id'] }},
                                type: 'movie',
                                content: content
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            content = '';
                            // Recharger les commentaires
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
                    fetch('{{ route('comments.index') }}?tmdb_id={{ $movie['id'] }}&type=movie')
                        .then(response => response.json())
                        .then(data => {
                            comments = data.comments || data; // Pour gérer le mode debug
                            if (data.debug) {
                                console.log('Debug:', data.debug);
                            }
                        })">

                {{-- Statistiques des commentaires --}}
                <div class="mb-6 flex gap-4 text-sm text-gray-400">
                    <span>Commentaires locaux: <span x-text="comments.filter(c => !c.is_tmdb).length"></span></span>
                    <span>Reviews TMDB: <span x-text="comments.filter(c => c.is_tmdb).length"></span></span>
                </div>

                <template x-if="comments.length === 0">
                    <div class="text-center py-4 text-white">
                        Aucun commentaire pour le moment. Soyez le premier à commenter !
                    </div>
                </template>

                <template x-for="comment in comments" :key="comment.id">
                    <div class="mt-6 rounded-lg p-4"
                         :class="{'bg-dark-lighter': !comment.is_tmdb, 'bg-dark-light/50': comment.is_tmdb}">
                        {{-- En-tête du commentaire --}}
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                {{-- Avatar si disponible --}}
                                <template x-if="comment.user.avatar">
                                    <img :src="'https://image.tmdb.org/t/p/w45' + comment.user.avatar"
                                         class="w-8 h-8 rounded-full"
                                         :alt="comment.user.name">
                                </template>

                                <div class="flex flex-col">
                                    <span class="text-primary-500 font-semibold" x-text="comment.user.name"></span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-400 text-sm"
                                              x-text="new Date(comment.created_at).toLocaleDateString()">
                                        </span>

                                        {{-- Badge TMDB et langue --}}
                                        <template x-if="comment.is_tmdb">
                                            <div class="flex items-center gap-2">
                                                <span class="bg-primary-600 text-xs px-2 py-1 rounded-full">TMDB</span>
                                                <span class="text-xs text-gray-400"
                                                      x-text="comment.language === 'fr' ? '🇫🇷 FR' : '🇬🇧 EN'">
                                                </span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            {{-- Options du commentaire (uniquement pour les commentaires locaux) --}}
                            @auth
                                <template x-if="!comment.is_tmdb && comment.user_id === {{ auth()->id() }}">
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
                        <div class="text-gray-300">
                            <p x-text="comment.is_tmdb ? (comment.content.length > 300 ? comment.content.substring(0, 300) + '...' : comment.content) : comment.content"></p>

                            {{-- Lien "Lire la suite" pour les reviews TMDB --}}
                            <template x-if="comment.is_tmdb && comment.content.length > 300">
                                <a :href="comment.url"
                                   target="_blank"
                                   class="text-primary-500 hover:text-primary-400 mt-2 inline-block">
                                    Lire la suite sur TMDB
                                </a>
                            </template>
                        </div>

                        {{-- Note TMDB si disponible --}}
                        <template x-if="comment.is_tmdb && comment.rating">
                            <div class="mt-2 text-primary-500">
                                Note : <span x-text="comment.rating + '/10'"></span>
                            </div>
                        </template>

                        {{-- Section réponses (uniquement pour les commentaires locaux) --}}
                        <template x-if="!comment.is_tmdb">
                            <div class="mt-4">
                                @auth
                                    <button @click="$refs[`replyForm_${comment.id}`].classList.toggle('hidden')"
                                            class="text-primary-500 hover:text-primary-400 text-sm">
                                        Répondre
                                    </button>

                                    <form :ref="'replyForm_' + comment.id"
                                          class="mt-2 hidden"
                                          @submit.prevent="
                                            fetch('{{ route('comments.store') }}', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                body: JSON.stringify({
                                                    tmdb_id: {{ $movie['id'] }},
                                                    type: 'movie',
                                                    content: content
                                                })
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                content = '';
                                                // Recharger les commentaires
                                                window.location.reload();
                                            })">
                                        <textarea class="w-full px-3 py-2 rounded-lg bg-dark text-gray-300 text-sm"
                                                rows="2"
                                                placeholder="Votre réponse..."></textarea>
                                        <div class="flex justify-end mt-2">
                                            <button type="submit"
                                                    class="px-3 py-1 bg-primary-500 text-white text-sm rounded-lg hover:bg-primary-600">
                                                Envoyer
                                            </button>
                                        </div>
                                    </form>
                                @endauth

                                {{-- Affichage des réponses existantes --}}
                                <template x-if="comment.replies && comment.replies.length > 0">
                                    <div class="mt-4 ml-8 space-y-4">
                                        <template x-for="reply in comment.replies" :key="reply.id">
                                            <div class="bg-dark rounded-lg p-3">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-primary-500" x-text="reply.user.name"></span>
                                                    <span class="text-gray-400 text-sm"
                                                          x-text="new Date(reply.created_at).toLocaleDateString()">
                                                    </span>
                                                </div>
                                                <p class="text-gray-300" x-text="reply.content"></p>
                                            </div>
                                        </template>
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
