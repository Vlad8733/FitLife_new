<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CommentController extends Controller
{
    public function update(Request $request, Comment $comment)
    {
        try {
            if (Auth::id() !== $comment->user_id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            $request->validate([
                'content' => 'required|string|max:500',
            ]);

            $comment->update(['content' => $request->input('content')]);

            Cache::forget('posts_index');

            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                ],
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Comment update failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to update comment: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Comment $comment)
    {
        try {
            if (Auth::id() !== $comment->user_id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            $comment->delete();
            Cache::forget('posts_index');
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            \Log::error('Comment deletion failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to delete comment: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function toggleReaction(Request $request, Comment $comment)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $request->validate(['type' => 'required|in:like,dislike']);
            $userId = Auth::id();
            $cacheKeyLike = "comment_{$comment->id}_like_count";
            $cacheKeyDislike = "comment_{$comment->id}_dislike_count";

            $existingLike = CommentLike::where('comment_id', $comment->id)->where('user_id', $userId)->first();

            if ($existingLike && $existingLike->type === $request->type) {
                $existingLike->delete();
                Cache::decrement($cacheKeyLike, $request->type === 'like' ? 1 : 0);
                Cache::decrement($cacheKeyDislike, $request->type === 'dislike' ? 1 : 0);
                $type = null;
            } else {
                CommentLike::updateOrCreate(
                    ['comment_id' => $comment->id, 'user_id' => $userId],
                    ['type' => $request->type]
                );
                if ($existingLike && $existingLike->type !== $request->type) {
                    Cache::decrement($cacheKeyLike, $existingLike->type === 'like' ? 1 : 0);
                    Cache::decrement($cacheKeyDislike, $existingLike->type === 'dislike' ? 1 : 0);
                }
                Cache::increment($cacheKeyLike, $request->type === 'like' ? 1 : 0);
                Cache::increment($cacheKeyDislike, $request->type === 'dislike' ? 1 : 0);
                $type = $request->type;
            }

            $likeCount = Cache::get($cacheKeyLike, fn() => $comment->likes()->where('type', 'like')->count());
            $dislikeCount = Cache::get($cacheKeyDislike, fn() => $comment->likes()->where('type', 'dislike')->count());

            return response()->json([
                'success' => true,
                'type' => $type,
                'likeCount' => $likeCount,
                'dislikeCount' => $dislikeCount,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Comment reaction toggle failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to toggle comment reaction: ' . $e->getMessage(),
            ], 500);
        }
    }
}