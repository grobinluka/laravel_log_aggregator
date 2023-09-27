<?php

namespace Database\Factories;

use App\Models\ApiKey;
use App\Models\ProjectUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApiKey>
 */
class ApiKeyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do{
            $api_key = bin2hex(random_bytes(32));
        } while (ApiKey::where('api_key', $api_key)->exists());

        return [
            'name' => fake()->words(4, true),
            'api_key' => $api_key,
            'project_user_id' => ProjectUser::inRandomOrder()->first()->id,
        ];
    }
}
