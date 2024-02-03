<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\ProjectList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProjectListTest extends TestCase
{
  use RefreshDatabase;

  private User $user;

  protected function setUp(): void
  {
    parent::setUp();

    // Crie um usuário para autenticar
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
  }

  /**
   * Testa se é possível criar uma lista de projeto.
   */
  public function test_it_creates_a_project_list()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $this->post('/api/project', [
      "project_id" => Project::factory()->create(['user_id' => $user->id])->id,
      "title" => 'Personal List',
      "description" => 'Random and personal list',
      "icon" => 'material-symbols:sentiment-very-satisfied-outline',
      "color_hex" => '#C246F2',
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
   * Testa se é possível listar as listas de projeto.
   */
  public function test_it_returns_a_list_of_project_lists()
  {
    $project = Project::factory()->create(['user_id' => $this->user->id]);

    $this->postJson(route('list.store'), [
      'user_id' => $this->user->id,
      'project_id' => $project->id,
      'title' => 'Test Project List',
      'description' => 'Test Project List Description',
      'icon' => 'test-icon',
      'color_hex' => '#ffffff',
    ]);

    $response = $this->getJson(route('list.index'));

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
   * Testa se é possível visualizar uma lista de projeto.
   */
  public function test_it_shows_a_project_list()
  {
    $project = Project::factory()->create(['user_id' => $this->user->id]);
    $projectList = ProjectList::factory()->create(['user_id' => $this->user->id, 'project_id' => $project->id]);

    $response = $this->getJson(route('list.show', ['list' => $projectList->id]));

    $response->assertStatus(Response::HTTP_OK)
      ->assertJson([
        'data' => [
          'id' => $projectList->id,
          'title' => $projectList->title,
          // Adicione outras propriedades conforme necessário
        ]
      ]);
  }

  /**
   * Testa se é possível atualizar uma lista de projeto.
   */
  public function test_it_updates_a_project_list()
  {
    $project = Project::factory()->create(['user_id' => $this->user->id]);
    $projectList = ProjectList::factory()->create(['user_id' => $this->user->id, 'project_id' => $project->id]);
    $updatedData = ['title' => 'Updated Project List', ...$projectList->toArray()];

    $this->putJson(route('list.update', ['list' => $projectList->id]), $updatedData);

    $response = $this->getJson(route('list.show', ['list' => $projectList->id]));

    $response->assertStatus(Response::HTTP_OK)
      ->assertJson([
        'data' => [
          'id' => $projectList->id,
          'title' => $projectList->title,
          // Adicione outras propriedades conforme necessário
        ]
      ]);

    $this->assertDatabaseHas('project_lists', array_merge(['id' => $projectList->id], $updatedData));
  }

  // /**
  //  * Testa se é possível deletar uma lista de projeto.
  //  */
  // public function test_it_deletes_a_project_list()
  // {
  //     $project = Project::factory()->create(['user_id' => $this->user->id]);
  //     $projectList = ProjectList::factory()->create(['user_id' => $this->user->id, 'project_id' => $project->id]);

  //     $response = $this->deleteJson(route('list.destroy', ['id' => $projectList->id]));

  //     $response->assertStatus(Response::HTTP_CREATED)
  //         ->assertJson([
  //             'message' => __('model.destroy_success', ['model' => 'Lista de Projeto', 'artigo_definido' => 'a']),
  //         ]);

  //     $this->assertDatabaseMissing('project_lists', ['id' => $projectList->id]);
  // }
}
