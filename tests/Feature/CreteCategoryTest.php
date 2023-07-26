<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreteCategoryTest extends TestCase
{
    /**
     * Testa se é possivel criar categorias.
     */
    public function test_categories_can_be_created(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $response = $this->post('/api/category', [
            'category_id'   => '',
            'title'         => 'Personal',
            'description'   => 'Random and personal goals',
        ]);

        // $response->dump();

        $response->assertStatus(201);
    }
}
