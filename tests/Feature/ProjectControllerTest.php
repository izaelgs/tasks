<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
  use RefreshDatabase;

  private User $user;

  protected function setUp(): void
  {
    parent::setUp();

    // Crie um usuário para autenticar
    $this->user = User::factory()->create();

    // Autentique o usuário
    $this->actingAs($this->user);
  }

  /**
   * Testa se é possível criar um projeto.
   */
  public function test_it_creates_a_project()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $this->post('/api/project', [
      'category_id'   => Category::factory()->create(['user_id' => $user->id])->id,
      'team_id'       => '',
      'title'         => 'Personal',
      'description'   => 'Random and personal goals',
      'priority'      => '1',
      'deadline'      => '2021-10-10',
    ]);

    $response = $this->getJson(route('project.index'));

    $response->assertStatus(Response::HTTP_OK)
      ->assertJsonStructure([
        'data' => [
          '*' => [
            'id',
            'user_id',
            'category_id',
            'team_id',

            'title',
            'description',
            'priority',
            'deadline',
          ]
        ]
      ]);
  }

  /**
   * Testa se é possível listar projetos.
   */
  public function test_it_returns_a_list_of_projects()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $this->post('/api/project', [
      'category_id'   => Category::factory()->create(['user_id' => $user->id])->id,
      'team_id'       => '',
      'title'         => 'Personal',
      'description'   => 'Random and personal goals',
      'priority'      => '1',
      'deadline'      => '2021-10-10',
    ]);

    $response = $this->getJson(route('project.index'));

    $response->assertStatus(Response::HTTP_OK)
      ->assertJsonStructure([
        'data' => [
          '*' => [
            'id',
            'title',
            // Adicione outras propriedades conforme necessário
          ]
        ]
      ]);
  }

  /**
   * Testa se é possível visualizar um projeto.
   */
  public function test_it_shows_a_project()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $project = Project::factory()->create(['user_id' => $user->id]);

    $response = $this->getJson(route('project.show', ['project' => $project->id]));

    $response->assertStatus(Response::HTTP_OK)
      ->assertJson([
        'data' => [
          'id' => $project->id,
          'title' => $project->title,
          // Adicione outras propriedades conforme necessário
        ]
      ]);
  }

  /**
   * Testa se é possível listar as listas de um projeto.
   */
  public function test_it_lists_project_lists()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $project = Project::factory()->create(['user_id' => $user->id]);

    $response = $this->getJson(route('project.lists', ['id' => $project->id]));

    $response->assertStatus(Response::HTTP_OK)
      ->assertJsonStructure([
        'data' => [
          '*' => [
            'id',
            'title',
            // Adicione outras propriedades conforme necessário
          ]
        ]
      ]);
  }

  /**
   * Testa se é possível atualizar um projeto.
   */
  public function test_it_updates_a_project()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $project = Project::factory()->create(['user_id' => $user->id]);
    $updatedData = ['title' => 'Updated Project'];

    $response = $this->putJson(route('project.update', ['project' => $project->id]), $updatedData);

    $response->assertStatus(Response::HTTP_CREATED)
      ->assertJson([
        'message' => __('model.update_success', ['model' => 'Projeto', 'artigo_definido' => 'o']),
      ]);

    $this->assertDatabaseHas('projects', array_merge(['id' => $project->id], $updatedData));
  }

  /**
   * Testa se é possível deletar um projeto.
   */
  public function test_it_deletes_a_project()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $project = Project::factory()->create(['user_id' => $user->id]);

    $response = $this->deleteJson(route('project.destroy', ['project' => $project->id]));

    $response->assertStatus(Response::HTTP_CREATED)
      ->assertJson([
        'message' => __('model.destroy_success', ['model' => 'Projeto', 'artigo_definido' => 'o']),
      ]);

    $this->assertDatabaseMissing('projects', ['id' => $project->id]);
  }
}
