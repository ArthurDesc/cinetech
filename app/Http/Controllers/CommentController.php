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
        )->latest()
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
        $validated = $request->validate([
            'tmdb_id' => 'required|integer',
            'type' => 'required|in:movie,tv',
            'content' => 'required|string|max:1000'
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'tmdb_id' => $validated['tmdb_id'],
            'type' => $validated['type'],
            'content' => $validated['content']
        ]);

        $comment->load('user');

        cache()->forget("comments_{$validated['tmdb_id']}_{$validated['type']}");

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

        // Invalider le cache pour ce média
        cache()->forget("comments_{$comment->tmdb_id}_{$comment->type}");

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'message' => 'Commentaire supprimé',
                'status' => 'success'
            ]);
        }
        
        return redirect()->route('admin.comments')->with('success', 'Commentaire supprimé');
    }
}
