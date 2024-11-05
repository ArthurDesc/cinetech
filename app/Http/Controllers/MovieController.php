<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function index()
    {
        // Films populaires
        $popularMovies = Http::get(config('services.tmdb.base_url') . '/movie/popular', [
            'api_key' => config('services.tmdb.api_key'),
            'language' => 'fr-FR'
        ])->json()['results'];

        // Films les mieux notés
        $topRatedMovies = Http::get(config('services.tmdb.base_url') . '/movie/top_rated', [
            'api_key' => config('services.tmdb.api_key'),
            'language' => 'fr-FR'
        ])->json()['results'];

        // Films à venir
        $upcomingMovies = Http::get(config('services.tmdb.base_url') . '/movie/upcoming', [
            'api_key' => config('services.tmdb.api_key'),
            'language' => 'fr-FR'
        ])->json()['results'];

        return view('movies.index', compact('popularMovies', 'topRatedMovies', 'upcomingMovies'));
    }

    public function show($id)
    {
        // Récupérer les détails d'un film
        $response = Http::get(config('services.tmdb.base_url') . '/movie/' . $id, [
            'api_key' => config('services.tmdb.api_key'),
            'language' => 'fr-FR',
            'append_to_response' => 'credits,similar'
        ]);

        $movie = $response->json();

        return view('movies.show', compact('movie'));
    }
}
