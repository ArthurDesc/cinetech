<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'tmdb_id' => $this->faker->numberBetween(100, 9999),
            'type' => $this->faker->randomElement(['movie', 'tv']),
            'content' => $this->faker->sentence(12),
            'parent_id' => null, // Pour la seed initiale, pas de réponses
        ];
    }
} 