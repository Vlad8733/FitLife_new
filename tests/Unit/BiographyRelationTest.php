<?php

use App\Models\User;
use App\Models\Biography;
use Tests\TestCase;

uses(TestCase::class);

it('user has one biography', function () {
    $user = User::factory()->create();

    $bio = Biography::create([
        'user_id' => $user->id,
        'full_name' => 'John Doe',
        'age' => 25,
    ]);

    expect($user->biography->id)->toBe($bio->id);
});
