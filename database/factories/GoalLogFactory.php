<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Goal;
use App\Models\GoalLog;

class GoalLogFactory extends Factory
{
    protected $model = GoalLog::class;

    public function definition(): array
    {
        return [
            'goal_id' => Goal::factory(),
            'change' => fake()->numberBetween(1, 10),
            'description' => fake()->sentence(),
        ];
    }
}
