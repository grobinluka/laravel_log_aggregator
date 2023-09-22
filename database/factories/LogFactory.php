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
        $startDate = Carbon::parse('2023-09-01 00:00:00');
        $endDate = Carbon::now();

        return [
            'project_user_id' => ProjectUser::class::inRandomOrder()->first()->id,
            'severity_level_id' => SeverityLevel::class::inRandomOrder()->first()->id,
            'description' => fake()->text(250),
            'created_at' => Carbon::createFromTimestamp(mt_rand($startDate->timestamp, $endDate->timestamp)),
            'updated_at' => $endDate,
        ];
    }
}
