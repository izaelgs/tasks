<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
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

  /**
   * Testa se é possivel listar categorias.
   */
  public function test_it_returns_a_list_of_categories()
  {

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $this->post('/api/category', [
      'category_id'   => '',
      'title'         => 'Personal',
      'description'   => 'Random and personal goals',
    ]);

    $response = $this->getJson(route('category.index'));

    $response->assertStatus(Response::HTTP_OK)
      ->assertJsonStructure([
        'data' => [
          '*' => [
            'id',
            'category_id',
            'title',
            'description',
          ]
        ]
      ]);
  }
}
