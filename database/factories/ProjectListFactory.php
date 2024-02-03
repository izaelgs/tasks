<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectList>
 */
class ProjectListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'user_id' => User::factory(),
          'project_id' => Project::factory(),

          'title' => $this->faker->words(3, true),
          'description' => $this->faker->paragraph,
          'icon' => $this->faker->word,
          'color_hex' => $this->faker->hexColor,
        ];
    }
}
