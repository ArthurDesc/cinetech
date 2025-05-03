@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 py-4 sm:py-8">
    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold mb-2 sm:mb-4">Gestion des commentaires</h1>
    @if(session('success'))
        <div class="mb-4 p-2 bg-green-600 text-white rounded">{{ session('success') }}</div>
    @endif

    <!-- Version desktop -->
    <div class="hidden lg:block overflow-x-auto">
        <table class="min-w-full bg-dark-light text-white rounded shadow">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Utilisateur</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Média</th>
                    <th class="px-4 py-2">Contenu</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                    <tr class="border-b border-dark-lighter">
                        <td class="px-4 py-2">{{ $comment->id }}</td>
                        <td class="px-4 py-2">{{ $comment->user->nickname ?? 'Utilisateur supprimé' }}</td>
                        <td class="px-4 py-2">{{ $comment->type === 'movie' ? 'Film' : 'Série' }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ $comment->type === 'movie' ? route('movies.show', $comment->tmdb_id) : route('tvshows.show', $comment->tmdb_id) }}"
                               class="text-primary-400 hover:underline"
                               target="_blank"
                               rel="noopener">
                                {{ $comment->media_title }}
                            </a>
                        </td>
                        <td class="px-4 py-2 max-w-xs truncate" title="{{ $comment->content }}">{{ $comment->content }}</td>
                        <td class="px-4 py-2">{{ $comment->created_at->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">
                            <button type="button" 
                                onclick="openModal({{ $comment->id }}, this.dataset.content)" 
                                data-content="{{ htmlspecialchars($comment->content, ENT_QUOTES) }}" 
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded focus:outline-none focus:ring-2 focus:ring-red-400">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Aucun commentaire trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Version mobile & tablette -->
    <div class="lg:hidden space-y-4">
        @forelse($comments as $comment)
            <div class="bg-dark-light rounded-lg p-4 shadow">
                <div class="flex justify-between items-start mb-2">
                    <div class="text-sm text-gray-400">ID: {{ $comment->id }}</div>
                    <div class="text-sm text-gray-400">{{ $comment->created_at->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}</div>
                </div>
                <div class="mb-2">
                    <span class="text-gray-400">Par:</span>
                    <span class="text-white">{{ $comment->user->nickname ?? 'Utilisateur supprimé' }}</span>
                </div>
                <div class="mb-2">
                    <span class="text-gray-400">Type:</span>
                    <span class="text-white">{{ $comment->type === 'movie' ? 'Film' : 'Série' }}</span>
                    <span class="text-gray-400 ml-2">Média:</span>
                    <span class="text-white">
                        <a href="{{ $comment->type === 'movie' ? route('movies.show', $comment->tmdb_id) : route('tvshows.show', $comment->tmdb_id) }}"
                           class="text-primary-400 hover:underline"
                           target="_blank"
                           rel="noopener">
                            {{ $comment->media_title }}
                        </a>
                    </span>
                </div>
                <div class="mb-3">
                    <div class="text-gray-400 mb-1">Contenu:</div>
                    <div class="text-white text-sm bg-dark rounded p-2">{{ $comment->content }}</div>
                </div>
                <div class="flex justify-end">
                    <button type="button" 
                        onclick="openModal({{ $comment->id }}, this.dataset.content)" 
                        data-content="{{ htmlspecialchars($comment->content, ENT_QUOTES) }}" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-red-400">
                        Supprimer
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-4 text-gray-400">Aucun commentaire trouvé.</div>
        @endforelse
    </div>

    <div class="mt-4">
        <x-pagination :currentPage="$currentPage" :totalPages="$totalPages" route="admin.comments" />
    </div>
</div>

<!-- Modal de confirmation -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center h-screen">
    <!-- Overlay qui recouvre tout -->
    <div class="fixed inset-0 bg-black bg-opacity-50"></div>
    <!-- Contenu du modal -->
    <div class="bg-dark-light rounded-lg p-6 max-w-lg w-full mx-4 z-10">
        <h2 class="text-xl font-bold mb-4 text-white">Confirmer la suppression</h2>
        <p class="text-gray-300 mb-4">Êtes-vous sûr de vouloir supprimer ce commentaire ?</p>
        <div class="bg-dark rounded p-3 mb-4">
            <p id="commentContent" class="text-gray-300 text-sm"></p>
        </div>
        <div class="flex justify-end gap-3">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                Annuler
            </button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Confirmer
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(commentId, content) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const contentElement = document.getElementById('commentContent');
    
    form.action = `/comments/${commentId}`;
    contentElement.textContent = content;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection 