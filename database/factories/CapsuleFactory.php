<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Capsule>
 */
class CapsuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'message' => $this->faker->sentence,
            'openeing_time' => $this->faker->dateTimeBetween('+1 day', '+1 year'),
            'created_by' => User::factory(),
            'opened_at' => null,
            'opened_by' => null,
        ];
    }
}
