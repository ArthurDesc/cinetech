<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
} 
