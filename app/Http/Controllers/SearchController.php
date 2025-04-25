<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    private $baseUrl;
    private $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.tmdb.base_url');
        $this->apiKey = config('services.tmdb.api_key');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $currentPage = $request->get('page', 1);

        if (empty($query)) {
            return view('search.index');
        }

        // Recherche multi (films et séries)
        $response = Http::get("{$this->baseUrl}/search/multi", [
            'api_key' => $this->apiKey,
            'language' => 'fr-FR',
            'query' => $query,
            'page' => $currentPage,
            'include_adult' => false
        ])->json();

        // Formater les résultats
        $results = collect($response['results'])->map(function($item) {
            $item['poster_url'] = $item['poster_path']
                ? config('services.tmdb.image_base_url') . $item['poster_path']
                : asset('images/placeholder-poster.jpg');

            // Ajouter le type pour différencier films et séries
            $item['media_type'] = $item['media_type'] ?? 'movie';

            // Uniformiser les titres
            $item['title'] = $item['title'] ?? $item['name'] ?? 'Sans titre';

            return $item;
        });

        return view('search.index', [
            'results' => $results,
            'query' => $query,
            'currentPage' => $currentPage,
            'totalPages' => $response['total_pages']
        ]);
    }

    /**
     * Autocomplétion pour la barre de recherche (API)
     */
    public function autocomplete(Request $request)
    {
        $query = $request->get('query');
        if (!$query || mb_strlen($query) < 2) {
            return response()->json([]);
        }

        $response = Http::get("{$this->baseUrl}/search/multi", [
            'api_key' => $this->apiKey,
            'language' => 'fr-FR',
            'query' => $query,
            'page' => 1,
            'include_adult' => false
        ]);

        if (!$response->successful()) {
            return response()->json([]);
        }

        $results = collect($response->json('results'))
            ->filter(function($item) {
                return in_array($item['media_type'] ?? 'movie', ['movie', 'tv']);
            })
            ->take(5)
            ->map(function($item) {
                return [
                    'id' => $item['id'],
                    'title' => $item['title'] ?? $item['name'] ?? 'Sans titre',
                    'media_type' => $item['media_type'] ?? 'movie',
                    'poster_url' => isset($item['poster_path']) && $item['poster_path']
                        ? config('services.tmdb.image_base_url') . $item['poster_path']
                        : asset('images/placeholder-poster.jpg'),
                ];
            })
            ->values();

        return response()->json($results);
    }
} 
