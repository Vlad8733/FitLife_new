<?php

use App\Models\User;
use App\Models\Biography;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows user to create or update biography', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('biography.update'), [
        'full_name' => 'Jane Doe',
        'age' => 23,
        'height' => 165,
        'weight' => 60,
        'gender' => 'female',
    ]);

    $response->assertRedirect(route('biography.edit'));
    expect($user->biography()->exists())->toBeTrue();

    $bio = $user->biography;
    expect($bio->full_name)->toBe('Jane Doe');
});
