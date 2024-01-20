<?php

namespace Tests\Feature;

use App\Models\Category;
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

  /**
   * Testa se é possivel atualizar uma categoria.
   */
  public function test_it_shows_a_category()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $category = Category::factory()->create(['user_id' => $user->id]);

    $response = $this->getJson(route('category.show', ['category' => $category->id]));

    $response->assertStatus(Response::HTTP_OK)
      ->assertJson([
        'data' => [
          'id' => $category->id,
          'title' => $category->title,
        ]
      ]);
  }

  /*
    * Testa se é possivel atualizar uma categoria.
    */
  public function test_it_updates_a_category()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $category = Category::factory()->create(['user_id' => $user->id]);
    $updatedData = ['title' => 'Updated Category'];

    $response = $this->putJson(route('category.update', ['category' => $category->id]), $updatedData);

    $response->assertStatus(Response::HTTP_CREATED)
      ->assertJson([
        'message' => __('model.update_success', ['model' => 'Categoria', 'artigo_definido' => 'a']),
      ]);

    $this->assertDatabaseHas('categories', array_merge(['id' => $category->id], $updatedData));
  }
}
