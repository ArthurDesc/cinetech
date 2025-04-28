<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    /** @test */
    public function ajout_commentaire_valide_reussi()
    {
        $user = User::factory()->create();

        $data = [
            'tmdb_id' => 12345,
            'type' => 'movie',
            'content' => 'Ceci est un commentaire de test.'
        ];

        $response = $this->actingAs($user)
            ->postJson(route('comments.store'), $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'status' => 'success',
                     'comment' => [
                         'content' => $data['content'],
                         'tmdb_id' => $data['tmdb_id'],
                         'type' => $data['type'],
                     ]
                 ]);

        $this->assertDatabaseHas('comments', [
            'content' => $data['content'],
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function ajout_commentaire_vide_echoue()
    {
        $user = User::factory()->create();

        $data = [
            'tmdb_id' => 12345,
            'type' => 'movie',
            'content' => ''
        ];

        $response = $this->actingAs($user)
            ->postJson(route('comments.store'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('content');
    }
} 