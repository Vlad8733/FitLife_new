<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $name = $this->faker->name();
        $baseUsername = Str::slug($name); // "Test User" -> "test-user"
        $username = substr($baseUsername . rand(1, 9999), 0, 20);

        return [
            'name' => $name,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'username' => $username,
            'age' => $this->faker->numberBetween(18, 65),
            'weight' => $this->faker->numberBetween(50, 120),
            'height' => $this->faker->numberBetween(150, 200),
            'role' => 'user', // по умолчанию обычный пользователь
            'goal_type' => $this->faker->randomElement(['lose_weight', 'gain_muscle', 'maintain']),
        ];
    }

    /**
     * Состояние для неподтвержденного email
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Состояние для администратора
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }
}
