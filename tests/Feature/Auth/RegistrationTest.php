<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

it('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    // Проверка авторизации
    $this->assertAuthenticated();

    // Проверка редиректа на dashboard
    $response->assertRedirect(route('dashboard', absolute: false));

    // Проверка записи в базе
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
});
