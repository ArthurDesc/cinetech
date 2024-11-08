@props(['tmdbId', 'type'])

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto"
         x-data="{
            comments: [],
            content: '',
            isSubmitting: false,

            // Initialisation des commentaires
            init() {
                fetch('{{ route('comments.index') }}?tmdb_id={{ $tmdbId }}&type={{ $type }}')
                    .then(response => response.json())
                    .then(data => {
                        this.comments = data.comments || data;
                    });
            },

            // Ajout d'un commentaire
            async addComment() {
                if (this.isSubmitting) return;
                this.isSubmitting = true;

                try {
                    const response = await fetch('{{ route('comments.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            tmdb_id: {{ $tmdbId }},
                            type: '{{ $type }}',
                            content: this.content
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        // Ajouter le nouveau commentaire au début
                        this.comments.unshift(data.comment);
                        this.content = '';

                        if (window.Alpine.store('notifications')) {
                            window.Alpine.store('notifications').add({
                                type: 'success',
                                message: data.message
                            });
                        }
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    if (window.Alpine.store('notifications')) {
                        window.Alpine.store('notifications').add({
                            type: 'error',
                            message: 'Erreur lors de l\'ajout du commentaire'
                        });
                    }
                } finally {
                    this.isSubmitting = false;
                }
            },

            // Suppression d'un commentaire
            async deleteComment(commentId) {
                if (!confirm('Voulez-vous vraiment supprimer ce commentaire ?')) return;

                try {
                    const response = await fetch(`/comments/${commentId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    if (response.ok) {
                        this.comments = this.comments.filter(c => c.id !== commentId);

                        if (window.Alpine.store('notifications')) {
                            window.Alpine.store('notifications').add({
                                type: 'success',
                                message: 'Commentaire supprimé avec succès'
                            });
                        }
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                }
            }
         }">

        <h2 class="text-2xl font-semibold text-white mb-6">Commentaires</h2>

        {{-- Formulaire d'ajout de commentaire --}}
        @auth
            <form @submit.prevent="addComment">
                <div class="mb-4">
                    <textarea
                        x-model="content"
                        class="w-full px-4 py-2 rounded-lg bg-dark-lighter text-gray-300 border border-dark-lighter focus:outline-none focus:border-primary-500"
                        :class="{ 'opacity-50': isSubmitting }"
                        rows="3"
                        :disabled="isSubmitting"
                        placeholder="Ajouter un commentaire..."></textarea>
                </div>
                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition"
                        :class="{ 'opacity-50 cursor-not-allowed': isSubmitting }"
                        :disabled="!content.trim() || isSubmitting">
                        <span x-show="!isSubmitting">Publier</span>
                        <span x-show="isSubmitting">Publication...</span>
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

        {{-- Nombre total de commentaires --}}
        <div class="mb-6 text-sm text-gray-400">
            <span>Nombre de commentaires: <span x-text="comments.length"></span></span>
        </div>

        {{-- Liste des commentaires --}}
        <template x-for="comment in comments" :key="comment.id">
            <div class="mt-6 rounded-lg p-4 bg-dark-lighter"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <span class="text-primary-500 font-semibold" x-text="comment.user.name"></span>
                        <span class="text-gray-400 text-sm"
                              x-text="new Date(comment.created_at).toLocaleDateString()">
                        </span>
                    </div>

                    {{-- Options du commentaire (pour l'auteur) --}}
                    @auth
                        <template x-if="comment.user_id === {{ auth()->id() }}">
                            <button @click="deleteComment(comment.id)"
                                    class="text-red-500 hover:text-red-400">
                                Supprimer
                            </button>
                        </template>
                    @endauth
                </div>

                {{-- Contenu du commentaire --}}
                <p class="text-gray-300" x-text="comment.content"></p>

                {{-- Section réponses --}}
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
</div>
