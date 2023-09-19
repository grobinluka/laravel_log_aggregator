<?php

namespace Database\Factories;

use App\Models\Project;
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

        while(Project::whereTitle($title)->exists()){
            $title = fake()->unique()->sentence(3, true);
        }

        while(Project::whereSlug($slug)->exists()){
            $slug = fake()->unique()->colorName;
        }
        
        return [
            'title' => $title,
            'slug' => $slug,
            'description' => fake()->text(300),
        ];
    }
}
