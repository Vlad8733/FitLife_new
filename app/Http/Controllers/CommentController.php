<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CommentController extends Controller
{
    // Update comment
    public function update(Request $request, Comment $comment)
    {
        try {
            if (Auth::id() !== $comment->user_id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 200);
            }

            $request->validate(['content' => 'required|string|max:500']);
            $comment->update(['content' => $request->input('content')]);
            Cache::forget('posts_page_1');

            return response()->json([
                'success' => true,
                'comment' => ['id' => $comment->id, 'content' => $comment->content]
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Comment update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update comment, but it may have been saved.',
            ], 200);
        }
    }

    // Delete comment
    public function destroy(Comment $comment)
    {
        try {
            if (Auth::id() !== $comment->user_id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 200);
            }

            $comment->delete();
            Cache::forget('posts_page_1');

            return response()->json(['success' => true], 200);

        } catch (\Exception $e) {
            \Log::error('Comment deletion failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete comment, but it may have been removed.',
            ], 200);
        }
    }

    // Like/dislike comment
    public function toggleReaction(Request $request, Comment $comment)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 200);
            }

            $request->validate(['type' => 'required|in:like,dislike']);
            $userId = Auth::id();
            $type = $request->type;

            $cacheKeys = [
                'like' => "comment_{$comment->id}_like_count",
                'dislike' => "comment_{$comment->id}_dislike_count",
            ];

            $existing = CommentLike::where('comment_id', $comment->id)
                                   ->where('user_id', $userId)
                                   ->first();

            if ($existing && $existing->type === $type) {
                $existing->delete();
                Cache::decrement($cacheKeys[$type]);
                $type = null;
            } else {
                CommentLike::updateOrCreate(
                    ['comment_id' => $comment->id, 'user_id' => $userId],
                    ['type' => $type]
                );
                if ($existing && $existing->type !== $type) {
                    Cache::decrement($cacheKeys[$existing->type]);
                }
                Cache::increment($cacheKeys[$type]);
            }

            $likeCount = Cache::remember($cacheKeys['like'], 60, fn() =>
                $comment->likes()->where('type', 'like')->count()
            );
            $dislikeCount = Cache::remember($cacheKeys['dislike'], 60, fn() =>
                $comment->likes()->where('type', 'dislike')->count()
            );

            Cache::forget('posts_page_1');

            return response()->json([
                'success' => true,
                'type' => $type,
                'likeCount' => $likeCount,
                'dislikeCount' => $dislikeCount,
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Comment reaction toggle failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle comment reaction, but it may have applied.',
            ], 200);
        }
    }
}