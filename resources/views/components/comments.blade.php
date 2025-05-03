@props(['tmdbId', 'type'])

<div class="container mx-auto px-4 sm:px-4 py-3 sm:py-8">
    <x-magic-card class="relative overflow-hidden rounded-2xl transition-all duration-300 group w-full max-w-full sm:max-w-4xl mx-auto px-4 sm:px-4 py-3 sm:py-8 bg-black shadow-2xl ring-2 ring-orange-700/30">
        <div
            x-data="{
                comments: [],
                content: '',
                isSubmitting: false,
                isLoading: true,
                showDeleteModal: false,
                commentToDelete: null,

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
                        this.isLoading = false;
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

                // Ouvrir le modal de confirmation de suppression
                openDeleteModal(comment) {
                    this.commentToDelete = comment;
                    this.showDeleteModal = true;
                },

                // Fermer le modal de confirmation de suppression
                closeDeleteModal() {
                    this.showDeleteModal = false;
                    this.commentToDelete = null;
                },

                // Suppression d'un commentaire
                async deleteComment() {
                    if (!this.commentToDelete) return;
                    const commentId = this.commentToDelete.id;

                    try {
                        const response = await fetch(`/comments/${commentId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        if (response.ok) {
                            // Mettre à jour la liste des commentaires immédiatement
                            this.comments = this.comments.filter(c => c.id !== commentId);
                            this.closeDeleteModal();

                            if (window.Alpine.store('notifications')) {
                                window.Alpine.store('notifications').add({
                                    type: 'success',
                                    message: 'Commentaire supprimé avec succès'
                                });
                            }
                        } else {
                            throw new Error('Erreur lors de la suppression du commentaire');
                        }
                    } catch (error) {
                        console.error('Erreur:', error);
                        if (window.Alpine.store('notifications')) {
                            window.Alpine.store('notifications').add({
                                type: 'error',
                                message: error.message
                            });
                        }
                    }
                }
            }"
            x-init="init()"
            x-cloak>

            <h2 class="text-lg sm:text-2xl font-semibold text-white mb-3 sm:mb-6">Commentaires</h2>

            {{-- Formulaire d'ajout de commentaire --}}
            @auth
                <form @submit.prevent="addComment" class="mb-6">
                    <div class="mb-2">
                        <textarea
                            x-model="content"
                            class="w-full px-3 py-2 rounded-lg bg-gray-800 text-gray-100 border border-gray-700 focus:outline-none focus:border-primary-500 placeholder-gray-400 shadow-sm"
                            :class="{ 'opacity-50': isSubmitting }"
                            rows="3"
                            :disabled="isSubmitting"
                            placeholder="Votre commentaire... (max 1000 caractères)"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            :disabled="isSubmitting || !content.trim()"
                            class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!isSubmitting">Publier</span>
                            <span x-show="isSubmitting">Publication...</span>
                        </button>
                    </div>
                </form>
            @else
                <div class="mb-6 p-4 bg-gray-800 rounded-lg text-center">
                    <p class="text-gray-300">
                        <a href="{{ route('login') }}" class="text-primary-400 hover:text-primary-300">Connectez-vous</a>
                        pour laisser un commentaire.
                    </p>
                </div>
            @endauth

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
                                <template x-if="comment.user_id === {{ auth()->id() }}">
                                    <button @click="openDeleteModal(comment)"
                                            class="text-red-400 hover:text-red-300 text-xs sm:text-sm">
                                        Supprimer
                                    </button>
                                </template>
                            @endauth
                        </div>
                    </div>

                    {{-- Contenu du commentaire --}}
                    <p class="text-gray-100 text-sm sm:text-base break-words" x-text="comment.content"></p>
                </div>
            </template>

            {{-- Modal de confirmation de suppression --}}
            <div x-show="showDeleteModal" 
                 class="fixed inset-0 z-50 flex items-center justify-center"
                 x-cloak>
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="closeDeleteModal"></div>
                <div class="bg-dark-light rounded-lg p-6 max-w-lg w-full mx-4 z-10 relative">
                    <h2 class="text-xl font-bold mb-4 text-white">Confirmer la suppression</h2>
                    <p class="text-gray-300 mb-4">Êtes-vous sûr de vouloir supprimer ce commentaire ?</p>
                    <div x-show="commentToDelete" class="bg-dark rounded p-3 mb-4">
                        <p class="text-gray-300 text-sm" x-text="commentToDelete?.content"></p>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button @click="closeDeleteModal" 
                                class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                            Annuler
                        </button>
                        <button @click="deleteComment" 
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Confirmer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-magic-card>
</div>
