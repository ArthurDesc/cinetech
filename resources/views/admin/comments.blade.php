@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Gestion des commentaires</h1>
    @if(session('success'))
        <div class="mb-4 p-2 bg-green-600 text-white rounded">{{ session('success') }}</div>
    @endif
    <div class="overflow-x-auto">
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
                            <button type="button" onclick="openModal({{ $comment->id }}, this.dataset.content)" data-content="{{ htmlspecialchars($comment->content, ENT_QUOTES) }}" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded focus:outline-none focus:ring-2 focus:ring-red-400">Supprimer</button>
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
    <div class="mt-4">
        {{ $comments->links() }}
    </div>
</div>

<!-- Modal personnalisé -->
<div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden">
    <div class="bg-dark-light rounded-lg shadow-lg p-8 w-full max-w-md relative">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-400 hover:text-white text-2xl font-bold">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-white">Confirmer la suppression</h2>
        <p class="mb-4 text-gray-300">Voulez-vous vraiment supprimer ce commentaire&nbsp;?</p>
        <div id="modalCommentContent" class="mb-4 p-3 bg-dark rounded text-gray-200 text-sm"></div>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 rounded bg-gray-500 hover:bg-gray-600 text-white">Annuler</button>
                <button type="submit" class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white">Supprimer</button>
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