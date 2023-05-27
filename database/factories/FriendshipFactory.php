<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Friendship>
 */
class FriendshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'from_id' => fake()->numberBetween(1, User::count()),
            'to_id' => fake()->numberBetween(1, User::count()),
            'status' => fake()->randomElement(["pending", "approved"]),
        ];
    }
}
