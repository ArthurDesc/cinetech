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

    private function getCarouselMovies()
    {
        // Récupérer les films tendance pour le carousel
        $trendingMovies = Http::withOptions(['verify' => false])
            ->get("{$this->baseUrl}/trending/movie/week", [
                'api_key' => $this->apiKey,
                'language' => 'fr-FR',
            ])->json()['results'];

        // Formater les données pour le carousel
        $carouselMovies = array_slice($trendingMovies, 0, 5);
        return array_map(function($movie) {
            return [
                'id' => $movie['id'],
                'title' => $movie['title'],
                'overview' => $movie['overview'],
                'image' => 'https://image.tmdb.org/t/p/original' . $movie['backdrop_path'],
            ];
        }, $carouselMovies);
    }

    public function index()
    {
        $popularMovies = Http::withOptions(['verify' => false])
            ->get("{$this->baseUrl}/movie/popular", [
                'api_key' => $this->apiKey,
                'language' => 'fr-FR',
                'page' => 1
            ])->json()['results'];

        $popularShows = Http::withOptions(['verify' => false])
            ->get("{$this->baseUrl}/tv/popular", [
                'api_key' => $this->apiKey,
                'language' => 'fr-FR',
                'page' => 1
            ])->json()['results'];

        // Limiter à 4 éléments chacun
        $popularMovies = array_slice($popularMovies, 0, 4);
        $popularShows = array_slice($popularShows, 0, 4);

        // Récupérer les films du carousel
        $carouselMovies = $this->getCarouselMovies();

        return view('home', compact('popularMovies', 'popularShows', 'carouselMovies'));
    }
}
