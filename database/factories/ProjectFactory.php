<?php

namespace Database\Factories;

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
        $title = fake()->unique()->sentence(3, true);
        $slug = fake()->unique()->colorName;
        
        return [
            'title' => $title,
            'slug' => $slug,
            'description' => $this->faker->text(300),
        ];
    }
}
