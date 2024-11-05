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

        // Précharger l'URL de l'image
        $show['poster_url'] = config('services.tmdb.image_base_url') . $show['poster_path'];

        // Formater la date
        $show['first_air_date'] = \Carbon\Carbon::parse($show['first_air_date'])->format('d/m/Y');

        // Arrondir la note
        $show['vote_average'] = round($show['vote_average'], 1);

        // Limiter le nombre d'acteurs et de séries similaires
        $show['credits']['cast'] = array_slice($show['credits']['cast'], 0, 5);
        $show['similar']['results'] = array_slice($show['similar']['results'], 0, 4);

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
