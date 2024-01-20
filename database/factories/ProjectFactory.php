<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
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
        'category_id' => Category::factory(),
        'team_id' => Team::factory(),

        'title' => $this->faker->sentence,
        'description' => $this->faker->paragraph,
        'priority' => $this->faker->randomNumber(1, 5),
        'deadline' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
    ];
    }
}
