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
        $project_id = Project::inRandomOrder()->first()->id;
        $user_id = User::inRandomOrder()->first()->id;

        $projectUser = ProjectUser::whereIn('project_id', [$project_id])
                ->whereIn('user_id', [$user_id])
                ->exists();

        while($projectUser){
            $projectUser = ProjectUser::whereIn('project_id', [$project_id])
                ->whereIn('user_id', [$user_id])
                ->exists();

            $project_id = Project::inRandomOrder()->first()->id;
            $user_id = User::inRandomOrder()->first()->id;
        }

        return [
            'project_id' => $project_id,
            'user_id' => $user_id,
        ];
    }
}
