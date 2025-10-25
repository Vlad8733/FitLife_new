<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Like;
use App\Models\User;
use App\Models\Post;

class LikeFactory extends Factory
{
    protected $model = Like::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'is_like' => $this->faker->boolean(),
            'type' => $this->faker->randomElement(['post', 'comment']),
        ];
    }
}
