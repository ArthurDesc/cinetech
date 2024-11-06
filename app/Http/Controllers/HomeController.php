<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    private $baseUrl = 'https://api.themoviedb.org/3';
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.api_key');
    }

    public function index()
    {
        // Récupérer quelques films et séries populaires pour la page d'accueil
        $popularMovies = Http::get("{$this->baseUrl}/movie/popular", [
            'api_key' => $this->apiKey,
            'language' => 'fr-FR',
            'page' => 1
        ])->json()['results'];

        $popularShows = Http::get("{$this->baseUrl}/tv/popular", [
            'api_key' => $this->apiKey,
            'language' => 'fr-FR',
            'page' => 1
        ])->json()['results'];

        // Limiter à 4 éléments chacun
        $popularMovies = array_slice($popularMovies, 0, 4);
        $popularShows = array_slice($popularShows, 0, 4);

        return view('home', compact('popularMovies', 'popularShows'));
    }
}
