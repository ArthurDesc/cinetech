@props(['tmdbId', 'type'])

<div class="container mx-auto px-4 sm:px-4 py-3 sm:py-8">
    <x-magic-card class="relative overflow-hidden rounded-2xl transition-all duration-300 group w-full max-w-full sm:max-w-4xl mx-auto px-4 sm:px-4 py-3 sm:py-8 bg-black shadow-2xl ring-2 ring-orange-700/30">
        <div
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

                    fetch('{{ route('comments.index') }}?tmdb_id={{ $tmdbId }}&type={{ $type }}', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur réseau');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // S'assurer que data est un tableau
                        this.comments = Array.isArray(data) ? data : (data.comments || []);
                        this.isLoading = false;
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        this.comments = [];
                        this.isLoading = false;
                        // Afficher un message d'erreur à l'utilisateur si nécessaire
                        if (window.Alpine.store('notifications')) {
                            window.Alpine.store('notifications').add({
                                type: 'error',
                                message: 'Impossible de charger les commentaires'
                            });
                        }
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

            <h2 class="text-lg sm:text-2xl font-semibold text-white mb-3 sm:mb-6">Commentaires</h2>

            {{-- Formulaire d'ajout de commentaire --}}
            @auth
                <form @submit.prevent="addComment" class="space-y-2 sm:space-y-0">
                    <div>
                        <textarea
                            x-model="content"
                            class="w-full px-3 sm:px-4 py-2 rounded-2xl sm:rounded-lg bg-gray-800/80 text-gray-100 border border-gray-700 focus:outline-none focus:border-primary-500 placeholder-gray-400 shadow-sm text-sm sm:text-base transition-all"
                            :class="{ 'opacity-50': isSubmitting }"
                            rows="3"
                            :disabled="isSubmitting"
                            placeholder="Ajouter un commentaire... (max 500 caractères)"></textarea>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-0 sm:justify-end">
                        <button
                            type="submit"
                            class="w-full sm:w-auto px-4 py-3 sm:py-2 bg-primary-500 text-white rounded-2xl sm:rounded-lg hover:bg-primary-600 transition shadow text-base sm:text-base font-semibold"
                            :class="{ 'opacity-50 cursor-not-allowed': isSubmitting }"
                            :disabled="!content.trim() || isSubmitting">
                            <span x-show="!isSubmitting">Publier</span>
                            <span x-show="isSubmitting">Publication...</span>
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center py-4 bg-gray-900 rounded-lg border border-gray-700 shadow-sm">
                    <p class="text-gray-100 text-sm sm:text-base">
                        <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-400">Connectez-vous</a>
                        pour laisser un commentaire
                    </p>
                </div>
            @endauth

            {{-- Nombre total de commentaires --}}
            <div class="mb-4 sm:mb-6 text-xs sm:text-sm text-gray-300">
                <span>Nombre de commentaires: <span x-text="comments.length"></span></span>
            </div>

            {{-- Liste des commentaires --}}
            <template x-for="comment in comments" :key="comment.id">
                <div class="mt-4 sm:mt-6 rounded-lg p-3 sm:p-4 bg-gray-900 border border-gray-700 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 gap-2 sm:gap-0">
                        <div class="flex items-center gap-2">
                            <span class="text-primary-400 font-semibold text-sm sm:text-base" x-text="comment.user.nickname"></span>
                            <span class="text-gray-400 text-xs sm:text-sm"
                                  x-text="new Date(comment.created_at).toLocaleDateString()">
                            </span>
                        </div>

                        {{-- Options du commentaire --}}
                        <div class="flex items-center gap-2 mt-1 sm:mt-0">
                            @auth
                                <button @click="replyingTo = replyingTo === comment.id ? null : comment.id"
                                        class="text-primary-400 hover:text-primary-300 text-xs sm:text-sm">
                                    Répondre
                                </button>
                                <template x-if="comment.user_id === {{ auth()->id() }}">
                                    <button @click="deleteComment(comment.id)"
                                            class="text-red-400 hover:text-red-300 text-xs sm:text-sm">
                                        Supprimer
                                    </button>
                                </template>
                            @endauth
                        </div>
                    </div>

                    {{-- Contenu du commentaire --}}
                    <p class="text-gray-100 text-sm sm:text-base break-words" x-text="comment.content"></p>

                    {{-- Formulaire de réponse --}}
                    @auth
                        <div x-show="replyingTo === comment.id"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="mt-3 sm:mt-4 ml-2 sm:ml-8">
                            <form @submit.prevent="addReply(comment.id)">
                                <div class="mb-2">
                                    <textarea
                                        x-model="replyContent"
                                        class="w-full px-2 sm:px-3 py-2 rounded-lg bg-gray-800 text-gray-100 border border-gray-700 focus:outline-none focus:border-primary-500 placeholder-gray-400 shadow-sm text-xs sm:text-sm"
                                        :class="{ 'opacity-50': isSubmitting }"
                                        rows="2"
                                        :disabled="isSubmitting"
                                        placeholder="Votre réponse... (max 300 caractères)"></textarea>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-end gap-2">
                                    <button type="button"
                                            @click="replyingTo = null"
                                            class="px-3 py-1 text-xs sm:text-sm text-gray-300 hover:text-white">
                                        Annuler
                                    </button>
                                    <button type="submit"
                                            class="px-3 py-1 text-xs sm:text-sm bg-primary-500 text-white rounded-lg hover:bg-primary-600 shadow"
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
                        <div class="mt-3 sm:mt-4 ml-2 sm:ml-8 space-y-3 sm:space-y-4">
                            <template x-for="reply in comment.replies" :key="reply.id">
                                <div class="bg-gray-800 border border-gray-700 rounded-lg p-2 sm:p-3">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-1 gap-1 sm:gap-0">
                                        <div class="flex items-center gap-2">
                                            <span class="text-primary-400 font-semibold text-xs sm:text-sm" x-text="reply.user.nickname"></span>
                                            <span class="text-gray-400 text-xs sm:text-sm"
                                                  x-text="new Date(reply.created_at).toLocaleDateString()">
                                            </span>
                                        </div>
                                        @auth
                                            <template x-if="reply.user_id === {{ auth()->id() }}">
                                                <button @click="deleteComment(reply.id)"
                                                        class="text-red-400 hover:text-red-300 text-xs sm:text-sm">
                                                    Supprimer
                                                </button>
                                            </template>
                                        @endauth
                                    </div>
                                    <p class="text-gray-100 text-xs sm:text-sm break-words" x-text="reply.content"></p>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </x-magic-card>
</div>
