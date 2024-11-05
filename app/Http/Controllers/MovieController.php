<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    private $baseUrl;
    private $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.tmdb.base_url');
        $this->apiKey = config('services.tmdb.api_key');
    }

    public function index()
    {
        $popularMovies = $this->getMovies('popular');
        $topRatedMovies = $this->getMovies('top_rated');
        $upcomingMovies = $this->getMovies('upcoming');

        // Précharger les URLs des images pour tous les films
        $allMovies = [$popularMovies, $topRatedMovies, $upcomingMovies];
        foreach($allMovies as &$movieList) {
            foreach($movieList as &$movie) {
                $movie['poster_url'] = config('services.tmdb.image_base_url') . $movie['poster_path'];
                $movie['vote_average'] = round($movie['vote_average'], 1); // Arrondir la note
                $movie['release_date'] = \Carbon\Carbon::parse($movie['release_date'])->format('d/m/Y');
            }
        }

        return view('movies.index', compact('popularMovies', 'topRatedMovies', 'upcomingMovies'));
    }

    public function show($id)
    {
        $movie = Http::get("{$this->baseUrl}/movie/{$id}", [
            'api_key' => $this->apiKey,
            'language' => 'fr-FR',
            'append_to_response' => 'credits,videos,similar'
        ])->json();

        // Précharger l'URL de l'image
        $movie['poster_url'] = config('services.tmdb.image_base_url') . $movie['poster_path'];

        // Formater la date
        $movie['release_date'] = \Carbon\Carbon::parse($movie['release_date'])->format('d/m/Y');

        // Arrondir la note
        $movie['vote_average'] = round($movie['vote_average'], 1);

        // Limiter le nombre d'acteurs et de films similaires
        $movie['credits']['cast'] = array_slice($movie['credits']['cast'], 0, 5);
        $movie['similar']['results'] = array_slice($movie['similar']['results'], 0, 4);

        return view('movies.show', compact('movie'));
    }

    private function getMovies($endpoint)
    {
        return Http::get("{$this->baseUrl}/movie/{$endpoint}", [
            'api_key' => $this->apiKey,
            'language' => 'fr-FR'
        ])->json()['results'];
    }
}
