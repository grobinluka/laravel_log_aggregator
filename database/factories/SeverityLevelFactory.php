<?php

namespace Database\Factories;

use App\Models\SeverityLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SeverityLevel>
 */
class SeverityLevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $levels = ['Notice', 'Warning', 'Error', 'Critical', 'Emergency'];

        $levelToInsert = '';

        foreach ($levels as $level) {
            if(!SeverityLevel::whereLevel($level)->get()){
                $levelToInsert = $level;
            }
        }

        return [
            'level' => $levelToInsert,
        ];
    }
}
