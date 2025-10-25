<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Фабрика для создания пользователей.
 * Применяется при тестировании и сидировании базы данных.
 */
class UserFactory extends Factory
{
    /**
     * Модель, с которой связана фабрика.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Определяет значения по умолчанию для полей модели User.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Основная информация
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),

            // Контактные данные
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),

            // Безопасность
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),

            // Дополнительные данные
            'bio' => fake()->sentence(),
            'avatar' => fake()->imageUrl(200, 200, 'people'),

            // Временные метки
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Состояние для неактивного пользователя.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Состояние администратора.
     *
     * @return static
     */
    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_admin' => true,
        ]);
    }

    /**
     * Состояние пользователя с профилем (био и аватар).
     *
     * @return static
     */
    public function withProfile(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->update([
                'bio' => fake()->realText(100),
                'avatar' => fake()->imageUrl(200, 200, 'people'),
            ]);
        });
    }
}
    