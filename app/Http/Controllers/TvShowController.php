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
        $popularShows = $this->getTvShows('popular');
        $topRatedShows = $this->getTvShows('top_rated');
        $onAirShows = $this->getTvShows('on_the_air');

        // Précharger les URLs des images pour toutes les séries
        $allShows = [$popularShows, $topRatedShows, $onAirShows];
        foreach($allShows as &$showList) {
            foreach($showList as &$show) {
                $show['poster_url'] = config('services.tmdb.image_base_url') . $show['poster_path'];
                $show['vote_average'] = round($show['vote_average'], 1);
                $show['first_air_date'] = \Carbon\Carbon::parse($show['first_air_date'])->format('d/m/Y');
            }
        }

        return view('tv-shows.index', compact('popularShows', 'topRatedShows', 'onAirShows'));
    }

    public function show($id)
    {
        $show = Http::get("{$this->baseUrl}/tv/{$id}", [
            'api_key' => $this->apiKey,
            'language' => 'fr-FR',
            'append_to_response' => 'credits,videos,similar'
        ])->json();

        // Précharger les URLs des images pour la série
        $show['poster_url'] = config('services.tmdb.image_base_url') . $show['poster_path'];

        // Traiter les acteurs avec une meilleure gestion des images
        if (isset($show['credits']['cast'])) {
            foreach ($show['credits']['cast'] as &$actor) {
                $actor['profile_url'] = $actor['profile_path']
                    ? config('services.tmdb.image_base_url') . $actor['profile_path']
                    : asset('images/placeholder-actor.jpg'); // Assurez-vous d'avoir une image par défaut
            }
            // Limiter à 5 acteurs
            $show['credits']['cast'] = array_slice($show['credits']['cast'], 0, 5);
        }

        // Traiter les séries similaires
        if (isset($show['similar']['results'])) {
            foreach ($show['similar']['results'] as &$similar) {
                if (isset($similar['poster_path'])) {
                    $similar['poster_path'] = config('services.tmdb.image_base_url') . $similar['poster_path'];
                }
            }
            $show['similar']['results'] = array_slice($show['similar']['results'], 0, 4);
        }

        // Formater la date
        $show['first_air_date'] = \Carbon\Carbon::parse($show['first_air_date'])->format('d/m/Y');
        $show['vote_average'] = round($show['vote_average'], 1);

        // Debug pour vérifier les données
        // dd($show['credits']['cast']);

        return view('tv-shows.show', compact('show'));
    }

    private function getTvShows($endpoint)
    {
        return Http::get("{$this->baseUrl}/tv/{$endpoint}", [
            'api_key' => $this->apiKey,
            'language' => 'fr-FR'
        ])->json()['results'];
    }
}
