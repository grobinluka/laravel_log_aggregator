<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectUser>
 */
class ProjectUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do {
            $project = Project::inRandomOrder()->first();
            $user = User::inRandomOrder()->first();
            $project_id = $project->id;
            $user_id = $user->id;
    
            $projectUser = ProjectUser::where('project_id', $project_id)
                ->where('user_id', $user_id)
                ->exists();
        } while ($projectUser);

        return [
            'project_id' => $project_id,
            'user_id' => $user_id,
        ];
    }
}
