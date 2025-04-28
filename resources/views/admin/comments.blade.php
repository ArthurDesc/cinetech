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
                    <th class="px-4 py-2">TMDB ID</th>
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
                        <td class="px-4 py-2">{{ $comment->type }}</td>
                        <td class="px-4 py-2">{{ $comment->tmdb_id }}</td>
                        <td class="px-4 py-2 max-w-xs truncate" title="{{ $comment->content }}">{{ $comment->content }}</td>
                        <td class="px-4 py-2">{{ $comment->created_at->format('d/m/Y H:i') }}</td>
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
                    <div class="text-sm text-gray-400">{{ $comment->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="mb-2">
                    <span class="text-gray-400">Par:</span>
                    <span class="text-white">{{ $comment->user->nickname ?? 'Utilisateur supprimé' }}</span>
                </div>
                <div class="mb-2">
                    <span class="text-gray-400">Type:</span>
                    <span class="text-white">{{ $comment->type }}</span>
                    <span class="text-gray-400 ml-2">TMDB ID:</span>
                    <span class="text-white">{{ $comment->tmdb_id }}</span>
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
        {{ $comments->links() }}
    </div>
</div>

<!-- Modal personnalisé -->
<div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden">
    <div class="bg-dark-light rounded-lg shadow-lg p-4 sm:p-8 w-11/12 sm:w-full max-w-md mx-4 relative">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-400 hover:text-white text-2xl font-bold">&times;</button>
        <h2 class="text-lg sm:text-xl font-bold mb-4 text-white">Confirmer la suppression</h2>
        <p class="mb-4 text-gray-300">Voulez-vous vraiment supprimer ce commentaire&nbsp;?</p>
        <div id="modalCommentContent" class="mb-4 p-3 bg-dark rounded text-gray-200 text-sm"></div>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-3 sm:px-4 py-2 rounded bg-gray-500 hover:bg-gray-600 text-white text-sm sm:text-base">Annuler</button>
                <button type="submit" class="px-3 sm:px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white text-sm sm:text-base">Supprimer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(commentId, content) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('modalCommentContent').textContent = content;
        const form = document.getElementById('deleteForm');
        form.action = '/comments/' + commentId;
        // Focus sur le bouton annuler pour accessibilité
        setTimeout(() => {
            form.querySelector('button[type="button"]').focus();
        }, 100);
    }
    
    function closeModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('modalCommentContent').textContent = '';
        document.getElementById('deleteForm').action = '';
    }
    
    // Fermer le modal avec la touche Echap
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });
</script>
@endsection 