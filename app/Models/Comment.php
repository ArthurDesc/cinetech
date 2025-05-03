<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Comment extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'tmdb_id',
        'type',
        'content'
    ];

    /**
     * Relation avec l'utilisateur qui a créé le commentaire
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Récupère tous les commentaires pour un film/série spécifique
     */
    public function scopeForMedia($query, int $tmdbId, string $type)
    {
        return $query->where('tmdb_id', $tmdbId)
                    ->where('type', $type)
                    ->with(['user:id,nickname']); // On ne charge plus les réponses
    }

    public function getMediaTitleAttribute()
    {
        $cacheKey = "tmdb_title_{$this->type}_{$this->tmdb_id}";
        return Cache::remember($cacheKey, 60 * 24, function () {
            $apiKey = config('services.tmdb.api_key');
            $baseUrl = config('services.tmdb.base_url');
            $lang = 'fr-FR';

            if ($this->type === 'movie') {
                $url = "{$baseUrl}/movie/{$this->tmdb_id}?api_key={$apiKey}&language={$lang}";
                $response = Http::get($url);
                return $response->json('title') ?? 'Film inconnu';
            } elseif ($this->type === 'tv') {
                $url = "{$baseUrl}/tv/{$this->tmdb_id}?api_key={$apiKey}&language={$lang}";
                $response = Http::get($url);
                return $response->json('name') ?? 'Série inconnue';
            }
            return 'Inconnu';
        });
    }
} 
