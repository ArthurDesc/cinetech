<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

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
} 
