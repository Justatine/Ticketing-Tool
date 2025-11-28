<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tickets>
 */
class TicketsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3, 6),
            'description' => fake()->paragraphs(2, true),
            'status' => fake()->randomElement(['Open', 'In Progress', 'Resolved', 'Closed']),
            'priority' => fake()->randomElement(['Low', 'Medium', 'High', 'Critical']),
            'assignee_id' => User::factory(),
            'reporter_id' => User::factory(),
        ];
    }
}
