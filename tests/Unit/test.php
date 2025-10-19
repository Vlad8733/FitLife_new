<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Test extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест успешного сохранения данных биографии пользователя.
     */
    public function testSuccessfullySavesUserBiographyData()
    {
        // Создаем тестового пользователя
        $user = User::factory()->create();

        // Имитируем авторизацию пользователя
        $this->actingAs($user);

        // Данные для биографии
        $data = [
            'full_name' => 'John Doe',
            'age' => 30,
            'height' => 175.5,
            'weight' => 70.2,
            'gender' => 'male',
        ];

        // Отправляем PATCH-запрос на обновление биографии
        $response = $this->patch(route('biography.update'), $data);

        // Проверяем, что запрос успешно перенаправляет на страницу редактирования
        $response->assertRedirect(route('biography.edit'));

        // Проверяем, что данные сохранены в базе данных
        $this->assertDatabaseHas('users', array_merge($data, ['id' => $user->id]));

        // Проверяем, что отображается сообщение об успехе
        $response->assertSessionHas('success', 'Biogrāfija veiksmīgi saglabāta!');
    }

    /**
     * Тест провала сохранения биографии с неполными данными.
     */
    public function testFailsToSaveBiographyWithIncompleteData()
    {
        // Создаем тестового пользователя
        $user = User::factory()->create();

        // Имитируем авторизацию пользователя
        $this->actingAs($user);

        // Данные с пропущенным полем (например, возраст)
        $data = [
            'full_name' => 'John Doe',
            'age' => '', // Пропущено
            'height' => 175.5,
            'weight' => 70.2,
            'gender' => 'male',
        ];

        // Отправляем PATCH-запрос
        $response = $this->patch(route('biography.update'), $data);

        // Проверяем, что запрос перенаправляет обратно с ошибкой
        $response->assertRedirect(route('biography.edit'));

        // Проверяем, что есть ошибка валидации для поля 'age'
        $response->assertSessionHasErrors(['age']);

        // Проверяем, что данные не сохранены в базе (возраст остается пустым)
        $this->assertDatabaseMissing('users', array_merge($data, ['id' => $user->id, 'age' => null]));
    }
}