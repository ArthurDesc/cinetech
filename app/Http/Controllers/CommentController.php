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
        // Optimiser les requêtes
        $comments = Comment::forMedia(
            $request->tmdb_id,
            $request->type
        )->whereNull('parent_id')
        ->with(['user:id,name', 'replies.user:id,name']) // Sélectionner uniquement les champs nécessaires
        ->latest()
        ->get();

        // Mise en cache courte durée si nécessaire
        return cache()->remember("comments_{$request->tmdb_id}_{$request->type}", 60, function() use ($comments) {
            return response()->json($comments);
        });
    }

    /**
     * Créer un nouveau commentaire
     */
    public function store(Request $request)
    {
        try {
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

            $comment->load(['user', 'replies.user']);

            return response()->json([
                'comment' => $comment,
                'message' => 'Commentaire ajouté avec succès',
                'status' => 'success'
            ], 201);

        } catch (\Exception $e) {
            // Log l'erreur

            // Retourner une réponse JSON même en cas d'erreur
            return response()->json([
                'message' => 'Une erreur est survenue',
                'error' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
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

        // Si c'est un commentaire parent, supprimer aussi les réponses
        if ($comment->parent_id === null) {
            $comment->replies()->delete();
        }

        $comment->delete();

        return response()->json([
            'message' => $comment->parent_id
                ? 'Réponse supprimée'
                : 'Commentaire et réponses supprimés',
            'status' => 'success'
        ]);
    }

    /**
     * Répondre à un commentaire
     */
    public function reply(Request $request, Comment $comment)
    {
        // Vérifier que le commentaire est un parent
        if ($comment->parent_id !== null) {
            return response()->json([
                'message' => 'Impossible de répondre à une réponse',
                'status' => 'error'
            ], 422);
        }

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

        return response()->json([
            'reply' => $reply,
            'message' => 'Réponse ajoutée avec succès',
            'status' => 'success'
        ], 201);
    }
}
