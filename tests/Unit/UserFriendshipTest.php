<?php

use App\Models\User;
use App\Models\Friendship;
use Tests\TestCase;

uses(TestCase::class);

it('detects friendship and pending requests', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    Friendship::create([
        'sender_id' => $userA->id,
        'receiver_id' => $userB->id,
        'status' => 'accepted',
    ]);

    expect($userA->isFriendsWith($userB))->toBeTrue();
    expect($userB->hasPendingFriendRequestFrom($userA))->toBeFalse();
});
