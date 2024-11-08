<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    private function getTmdbComments($type, $tmdbId)
    {
        $allReviews = [];

        try {
            // 1. Reviews standards
            $reviews = Http::withToken(config('services.tmdb.token'))
                ->get("https://api.themoviedb.org/3/{$type}/{$tmdbId}/reviews", [
                    'language' => 'fr-FR',
                    'page' => 1
                ])
                ->json()['results'] ?? [];

            // 2. Reviews en anglais
            $englishReviews = Http::withToken(config('services.tmdb.token'))
                ->get("https://api.themoviedb.org/3/{$type}/{$tmdbId}/reviews", [
                    'language' => 'en-US',
                    'page' => 1
                ])
                ->json()['results'] ?? [];

            // 3. Guest Reviews
            $guestReviews = Http::withToken(config('services.tmdb.token'))
                ->get("https://api.themoviedb.org/3/{$type}/{$tmdbId}/guest_reviews")
                ->json()['results'] ?? [];

            // Fusionner toutes les reviews
            $allReviews = array_merge($reviews, $englishReviews, $guestReviews);

            // Supprimer les doublons basés sur l'ID
            $allReviews = collect($allReviews)->unique('id')->values()->all();

            // Formater les reviews
            return collect($allReviews)->map(function ($review) {
                return [
                    'id' => 'tmdb_' . $review['id'],
                    'content' => $review['content'],
                    'created_at' => $review['created_at'],
                    'user' => [
                        'name' => $review['author'],
                        'avatar' => $review['author_details']['avatar_path'] ?? null,
                    ],
                    'is_tmdb' => true,
                    'rating' => $review['author_details']['rating'] ?? null,
                    'url' => $review['url'] ?? null,
                    'language' => $review['iso_639_1'] ?? 'en',
                    'replies' => [],
                ];
            });

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des reviews TMDB:', [
                'error' => $e->getMessage(),
                'type' => $type,
                'tmdb_id' => $tmdbId
            ]);
            return collect([]);
        }
    }

    /**
     * Afficher les commentaires pour un film/série
     */
    public function index(Request $request)
    {
        // Récupérer les commentaires locaux
        $localComments = Comment::forMedia(
            $request->tmdb_id,
            $request->type
        )->with(['user', 'replies.user'])
        ->latest()
        ->get();

        // Récupérer tous les commentaires TMDB
        $tmdbComments = $this->getTmdbComments($request->type, $request->tmdb_id);

        // Combiner et trier tous les commentaires
        $allComments = $localComments->concat($tmdbComments)
            ->sortByDesc('created_at')
            ->values();

        // Ajouter des informations de débogage en développement
        if (config('app.debug')) {
            return response()->json([
                'debug' => [
                    'local_count' => $localComments->count(),
                    'tmdb_count' => $tmdbComments->count(),
                    'total_count' => $allComments->count(),
                ],
                'comments' => $allComments
            ]);
        }

        return response()->json($allComments);
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

        $comment->load(['user', 'replies.user']);

        return response()->json($comment, 201);
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
        // Vérifier que le commentaire n'est pas une review TMDB
        if (str_starts_with($comment->id, 'tmdb_')) {
            return response()->json(['message' => 'Impossible de répondre à une review TMDB'], 422);
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

        return response()->json($reply, 201);
    }
}
