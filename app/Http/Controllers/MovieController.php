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
        // Récupérer le numéro de page depuis l'URL
        $currentPage = request()->get('page', 1);

        // Récupérer tous les films
        $response = Http::get("{$this->baseUrl}/discover/movie", [
            'api_key' => $this->apiKey,
            'language' => 'fr-FR',
            'page' => $currentPage,
            'sort_by' => 'popularity.desc', // Tri par popularité
            'include_adult' => false
        ])->json();

        return view('movies.index', [
            'movies' => $response['results'],
            'currentPage' => $currentPage,
            'totalPages' => $response['total_pages']
        ]);
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

        return view('movies.show', compact('movie'));
    }
}
