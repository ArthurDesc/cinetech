@props(['tmdbId', 'type'])

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto"
         x-data="{
            comments: [],
            content: '',
            replyContent: '',
            replyingTo: null,
            isSubmitting: false,
            isLoading: true,

            // Initialisation des commentaires
            init() {
                this.isLoading = true;

                fetchWithRetry(
                    '{{ route('comments.index') }}?tmdb_id={{ $tmdbId }}&type={{ $type }}',
                    {}
                )
                .then(data => {
                    this.comments = data.comments || data;
                    this.isLoading = false;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    // Réessayer après un délai
                    setTimeout(() => this.init(), 2000);
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
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            tmdb_id: {{ $tmdbId }},
                            type: '{{ $type }}',
                            content: this.content
                        })
                    });

                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('La réponse n\'est pas au format JSON');
                    }

                    const data = await response.json();

                    if (response.ok) {
                        this.comments = [data.comment, ...this.comments];
                        this.content = '';

                        if (window.Alpine.store('notifications')) {
                            window.Alpine.store('notifications').add({
                                type: 'success',
                                message: data.message
                            });
                        }
                    } else {
                        throw new Error(data.message || 'Une erreur est survenue');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    if (window.Alpine.store('notifications')) {
                        window.Alpine.store('notifications').add({
                            type: 'error',
                            message: error.message
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
            },

            // Nouvelle méthode pour répondre
            async addReply(commentId) {
                if (this.isSubmitting) return;
                this.isSubmitting = true;

                try {
                    const response = await fetch(`/comments/${commentId}/reply`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            content: this.replyContent
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        // Ajouter la réponse au commentaire parent
                        const parentComment = this.comments.find(c => c.id === commentId);
                        if (parentComment) {
                            if (!parentComment.replies) parentComment.replies = [];
                            parentComment.replies.push(data.reply);
                        }

                        this.replyContent = '';
                        this.replyingTo = null;

                        if (window.Alpine.store('notifications')) {
                            window.Alpine.store('notifications').add({
                                type: 'success',
                                message: data.message
                            });
                        }
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                } finally {
                    this.isSubmitting = false;
                }
            }
         }"
         x-init="init()"
         x-cloak>

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
                <p class="text-white">
                    <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-400">Connectez-vous</a>
                    pour laisser un commentaire
                </p>
            </div>
        @endauth

        {{-- Nombre total de commentaires --}}
        <div class="mb-6 text-sm text-white">
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
                        <span class="text-white text-sm"
                              x-text="new Date(comment.created_at).toLocaleDateString()">
                        </span>
                    </div>

                    {{-- Options du commentaire --}}
                    <div class="flex items-center gap-2">
                        @auth
                            <button @click="replyingTo = replyingTo === comment.id ? null : comment.id"
                                    class="text-primary-500 hover:text-primary-400 text-sm">
                                Répondre
                            </button>
                            <template x-if="comment.user_id === {{ auth()->id() }}">
                                <button @click="deleteComment(comment.id)"
                                        class="text-red-500 hover:text-red-400 text-sm">
                                    Supprimer
                                </button>
                            </template>
                        @endauth
                    </div>
                </div>

                {{-- Contenu du commentaire --}}
                <p class="text-gray-300" x-text="comment.content"></p>

                {{-- Formulaire de réponse --}}
                @auth
                    <div x-show="replyingTo === comment.id"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="mt-4 ml-8">
                        <form @submit.prevent="addReply(comment.id)">
                            <div class="mb-2">
                                <textarea
                                    x-model="replyContent"
                                    class="w-full px-3 py-2 rounded-lg bg-dark text-gray-300 border border-dark focus:outline-none focus:border-primary-500"
                                    :class="{ 'opacity-50': isSubmitting }"
                                    rows="2"
                                    :disabled="isSubmitting"
                                    placeholder="Votre réponse..."></textarea>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button"
                                        @click="replyingTo = null"
                                        class="px-3 py-1 text-sm text-white hover:text-gray-300">
                                    Annuler
                                </button>
                                <button type="submit"
                                        class="px-3 py-1 text-sm bg-primary-500 text-white rounded-lg hover:bg-primary-600"
                                        :class="{ 'opacity-50 cursor-not-allowed': isSubmitting }"
                                        :disabled="!replyContent.trim() || isSubmitting">
                                    <span x-show="!isSubmitting">Répondre</span>
                                    <span x-show="isSubmitting">Envoi...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                @endauth

                {{-- Liste des réponses --}}
                <template x-if="comment.replies && comment.replies.length > 0">
                    <div class="mt-4 ml-8 space-y-4">
                        <template x-for="reply in comment.replies" :key="reply.id">
                            <div class="bg-dark rounded-lg p-3">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-primary-500" x-text="reply.user.name"></span>
                                        <span class="text-white text-sm"
                                              x-text="new Date(reply.created_at).toLocaleDateString()">
                                        </span>
                                    </div>
                                    @auth
                                        <template x-if="reply.user_id === {{ auth()->id() }}">
                                            <button @click="deleteComment(reply.id)"
                                                    class="text-red-500 hover:text-red-400 text-sm">
                                                Supprimer
                                            </button>
                                        </template>
                                    @endauth
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
