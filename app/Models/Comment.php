<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'content',
        'parent_id'
    ];

    /**
     * Relation avec l'utilisateur qui a créé le commentaire
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le commentaire parent (si c'est une réponse)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Relation avec les réponses à ce commentaire
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Vérifie si le commentaire est une réponse
     */
    public function isReply(): bool
    {
        return !is_null($this->parent_id);
    }

    /**
     * Récupère tous les commentaires pour un film/série spécifique
     */
    public function scopeForMedia($query, int $tmdbId, string $type)
    {
        return $query->where('tmdb_id', $tmdbId)
                    ->where('type', $type)
                    ->whereNull('parent_id') // Commentaires principaux uniquement
                    ->with(['user', 'replies.user']); // Charge les relations
    }
} 
