<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use Tests\TestCase;

uses(TestCase::class);

it('detects like and dislike by user', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    Like::create([
        'user_id' => $user->id,
        'post_id' => $post->id,
        'is_like' => true,
    ]);

    expect($post->isLikedBy($user))->toBeTrue();
    expect($post->isDislikedBy($user))->toBeFalse();
});
