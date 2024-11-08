<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Afficher les commentaires pour un film/série
     */
    public function index(Request $request)
    {
        // Récupérer uniquement les commentaires locaux
        $comments = Comment::forMedia(
            $request->tmdb_id,
            $request->type
        )->with(['user', 'replies.user'])
        ->latest()
        ->get();

        // Ajouter des informations de débogage en développement
        if (config('app.debug')) {
            return response()->json([
                'debug' => [
                    'total_count' => $comments->count(),
                ],
                'comments' => $comments
            ]);
        }

        return response()->json($comments);
    }

    /**
     * Créer un nouveau commentaire
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tmdb_id' => 'required|integer',
            'type' => 'required|in:movie,tv',
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'tmdb_id' => $validated['tmdb_id'],
            'type' => $validated['type'],
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null
        ]);

        // Important : charger les relations pour l'affichage dynamique
        $comment->load(['user', 'replies.user']);

        return response()->json([
            'comment' => $comment,
            'message' => 'Commentaire ajouté avec succès',
            'status' => 'success'
        ], 201);
    }
    /**
     * Mettre à jour un commentaire
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment->update($validated);

        return response()->json($comment);
    }

    /**
     * Supprimer un commentaire
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json(['message' => 'Commentaire supprimé']);
    }

    /**
     * Répondre à un commentaire
     */
    public function reply(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $reply = Comment::create([
            'user_id' => auth()->id(),
            'tmdb_id' => $comment->tmdb_id,
            'type' => $comment->type,
            'content' => $validated['content'],
            'parent_id' => $comment->id
        ]);

        $reply->load('user');

        return response()->json($reply, 201);
    }
}
