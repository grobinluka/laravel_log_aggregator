<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\ProjectUser;
use App\Models\SeverityLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_user_id' => ProjectUser::class::inRandomOrder()->first()->id,
            'severity_level_id' => SeverityLevel::class::inRandomOrder()->first()->id,
            'description' => fake()->text(250),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
