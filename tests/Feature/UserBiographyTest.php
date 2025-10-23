<?php

use App\Models\User;
use App\Models\Biography;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('successfully saves user biography', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $data = [
        'full_name' => 'John Doe',
        'age' => 30,
        'height' => 175.5,
        'weight' => 70.2,
        'gender' => 'male',
    ];

    $response = $this->patch(route('biography.update'), $data);

    $response->assertRedirect(route('biography.edit'));
    $response->assertSessionHas('success', 'Biogrāfija veiksmīgi saglabāta!');

    // Проверяем, что запись появилась в таблице biographies
    $this->assertDatabaseHas('biographies', array_merge($data, ['user_id' => $user->id]));
});

it('fails to save biography with incomplete data', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $data = [
        'full_name' => 'John Doe',
        'age' => '', // Пропущено
        'height' => 175.5,
        'weight' => 70.2,
        'gender' => 'male',
    ];

    $response = $this->patch(route('biography.update'), $data);

    $response->assertRedirect(route('biography.edit'));
    $response->assertSessionHasErrors(['age']);

    $this->assertDatabaseMissing('biographies', [
        'user_id' => $user->id,
        'age' => null,
    ]);
});
