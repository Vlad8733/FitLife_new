<?php

use App\Models\User;
use App\Models\Friend;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('handles friendship requests and acceptance', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    // A sends friend request
    Friend::create(['user_id' => $userA->id, 'friend_id' => $userB->id, 'status' => 'pending']);
    expect($userA->hasPendingRequestTo($userB))->toBeTrue();

    // B accepts
    Friend::where('user_id', $userA->id)->update(['status' => 'accepted']);
    expect($userA->isFriendWith($userB))->toBeTrue();
});
