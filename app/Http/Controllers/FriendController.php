<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function store(Request $request, User $user)
    {
        if (Auth::id() === $user->id) {
            return response()->json(['error' => 'Cannot add yourself as a friend'], 400);
        }

        if (Auth::user()->isFriendWith($user) || Auth::user()->hasPendingRequestTo($user)) {
            return response()->json(['error' => 'Friend request already sent or user is already a friend'], 400);
        }

        Friend::create([
            'user_id' => Auth::id(),
            'friend_id' => $user->id,
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => 'Friend request sent!',
            'action' => 'request_sent',
            'addAction' => route('friends.store', $user),
            'removeAction' => route('friends.remove', $user),
        ], 201);
    }

    public function accept(Request $request, User $user)
    {
        $friendRequest = Friend::where('user_id', $user->id)
                              ->where('friend_id', Auth::id())
                              ->where('status', 'pending')
                              ->first();

        if (!$friendRequest) {
            return response()->json(['error' => 'No pending friend request found'], 404);
        }

        $friendRequest->update(['status' => 'accepted']);

        // Create reciprocal friendship record
        Friend::create([
            'user_id' => Auth::id(),
            'friend_id' => $user->id,
            'status' => 'accepted',
        ]);

        return response()->json([
            'status' => 'Friend request accepted!',
            'action' => 'accepted',
            'removeAction' => route('friends.remove', $user),
        ], 200);
    }

    public function remove(Request $request, User $user)
    {
        $friendship = Friend::where(function ($query) use ($user) {
            $query->where('user_id', Auth::id())->where('friend_id', $user->id)
                  ->orWhere('user_id', $user->id)->where('friend_id', Auth::id());
        })->where('status', 'accepted');

        if ($friendship->count() === 0) {
            return response()->json(['error' => 'Friendship not found'], 404);
        }

        $friendship->delete();

        return response()->json([
            'status' => 'Friend removed',
            'action' => 'removed',
            'addAction' => route('friends.store', $user),
        ], 200);
    }
}