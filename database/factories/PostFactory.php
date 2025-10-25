<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'content' => $this->faker->sentence(10),
            'media_path' => $this->faker->optional()->imageUrl(),
            'media_type' => fake()->randomElement(['image', 'video']),
            'views' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
