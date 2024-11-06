<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class TvShowController extends Controller
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

        // Récupérer toutes les séries
        $response = Http::get("{$this->baseUrl}/discover/tv", [
            'api_key' => $this->apiKey,
            'language' => 'fr-FR',
            'page' => $currentPage,
            'sort_by' => 'popularity.desc',
            'include_adult' => false
        ])->json();

        // Précharger les URLs des images
        $shows = collect($response['results'])->map(function($show) {
            $show['poster_url'] = config('services.tmdb.image_base_url') . $show['poster_path'];
            return $show;
        });

        return view('tv-shows.index', [
            'shows' => $shows,
            'currentPage' => $currentPage,
            'totalPages' => $response['total_pages']
        ]);
    }

    public function show($id)
    {
        $show = Http::get("{$this->baseUrl}/tv/{$id}", [
            'api_key' => $this->apiKey,
            'language' => 'fr-FR',
            'append_to_response' => 'credits,videos,similar'
        ])->json();

        // Précharger les URLs des images
        $show['poster_url'] = config('services.tmdb.image_base_url') . $show['poster_path'];

        // Traiter les acteurs
        if (isset($show['credits']['cast'])) {
            foreach ($show['credits']['cast'] as &$actor) {
                $actor['profile_url'] = $actor['profile_path']
                    ? config('services.tmdb.image_base_url') . $actor['profile_path']
                    : asset('images/placeholder-actor.jpg');
            }
            $show['credits']['cast'] = array_slice($show['credits']['cast'], 0, 5);
        }

        // Traiter les séries similaires
        if (isset($show['similar']['results'])) {
            foreach ($show['similar']['results'] as &$similar) {
                $similar['poster_url'] = $similar['poster_path']
                    ? config('services.tmdb.image_base_url') . $similar['poster_path']
                    : asset('images/placeholder-poster.jpg');
            }
            $show['similar']['results'] = array_slice($show['similar']['results'], 0, 4);
        }

        // Formater la date et la note
        $show['first_air_date'] = \Carbon\Carbon::parse($show['first_air_date'])->format('d/m/Y');
        $show['vote_average'] = round($show['vote_average'], 1);

        return view('tv-shows.show', compact('show'));
    }
}
