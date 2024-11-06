<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggle(Request $request)
    {
        $user = auth()->user();
        $tmdbId = $request->tmdb_id;
        $type = $request->type;

        $favorite = $user->favorites()
            ->where('tmdb_id', $tmdbId)
            ->where('type', $type)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        }

        $user->favorites()->create([
            'tmdb_id' => $tmdbId,
            'type' => $type
        ]);

        return response()->json(['status' => 'added']);
    }

    public function check(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['isFavorite' => false]);
        }

        $isFavorite = auth()->user()
            ->favorites()
            ->where('tmdb_id', $request->tmdb_id)
            ->where('type', $request->type)
            ->exists();

        return response()->json(['isFavorite' => $isFavorite]);
    }

    public function index()
    {
        $user = auth()->user();

        // Récupérer tous les favoris de l'utilisateur
        $favorites = $user->favorites()
            ->orderBy('created_at', 'desc')
            ->get();

        // Séparer les films et séries
        $movieFavorites = collect();
        $tvFavorites = collect();

        foreach ($favorites as $favorite) {
            $response = Http::get(config('services.tmdb.base_url') . '/' . $favorite->type . '/' . $favorite->tmdb_id, [
                'api_key' => config('services.tmdb.api_key'),
                'language' => 'fr-FR'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                // Ajouter l'URL du poster
                $data['poster_url'] = $data['poster_path']
                    ? config('services.tmdb.image_base_url') . $data['poster_path']
                    : null;

                if ($favorite->type === 'movie') {
                    $movieFavorites->push($data);
                } else {
                    $tvFavorites->push($data);
                }
            }
        }

        return view('favorites.index', compact('movieFavorites', 'tvFavorites'));
    }
}
