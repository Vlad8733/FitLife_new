<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Goal;

class GoalFactory extends Factory
{
    protected $model = Goal::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->text(100),
            'type' => $this->faker->randomElement(['steps', 'calories', 'sleep', 'weight']),
            'target_value' => $this->faker->numberBetween(10, 100),
            'current_value' => $this->faker->numberBetween(0, 10),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'change' => $this->faker->numberBetween(-10, 10),
        ];
    }
}
