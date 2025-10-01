<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        try {
            $posts = Cache::remember('posts_index', 60, function () {
                return Post::with(['user', 'comments.user', 'likes'])
                    ->latest()
                    ->get();
            });
            return view('posts.index', compact('posts'));
        } catch (\Exception $e) {
            \Log::error('Failed to load posts: ' . $e->getMessage());
            return back()->with('error', 'Failed to load posts.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'content' => 'nullable|string|max:1000',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $path = null;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = uniqid('post_') . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('posts', $filename, 'public');
            }

            $post = Post::create([
                'user_id' => Auth::id(),
                'content' => $request->input('content'),
                'photo_path' => $path,
                'views' => 0,
            ]);

            Cache::forget('posts_index');

            return response()->json([
                'success' => 'Post created successfully.',
                'post' => [
                    'id' => $post->id,
                    'content' => $post->content,
                    'photo_path' => $post->photo_path,
                    'user' => [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'avatar' => Auth::user()->avatar,
                        'profile_url' => route('profile.show', Auth::user()->id),
                    ],
                    'created_at' => $post->created_at->diffForHumans(),
                ],
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Post creation failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to create post: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Post $post)
    {
        try {
            if (Auth::id() !== $post->user_id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            $request->validate([
                'content' => 'nullable|string|max:1000',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_photo' => 'nullable|boolean',
            ]);

            if ($request->hasFile('photo')) {
                if ($post->photo_path) {
                    Storage::disk('public')->delete($post->photo_path);
                }
                $file = $request->file('photo');
                $filename = uniqid('post_') . '.' . $file->getClientOriginalExtension();
                $post->photo_path = $file->storeAs('posts', $filename, 'public');
            } elseif ($request->remove_photo) {
                if ($post->photo_path) {
                    Storage::disk('public')->delete($post->photo_path);
                }
                $post->photo_path = null;
            }

            $post->content = $request->input('content');
            $post->save();

            Cache::forget('posts_index');

            return response()->json([
                'success' => 'Post updated successfully.',
                'post' => [
                    'id' => $post->id,
                    'content' => $post->content,
                    'photo_path' => $post->photo_path,
                ],
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Post update failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to update post: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Post $post)
    {
        try {
            if (Auth::id() !== $post->user_id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            if ($post->photo_path) {
                Storage::disk('public')->delete($post->photo_path);
            }
            $post->delete();
            Cache::forget('posts_index');
            return response()->json(['success' => 'Post deleted successfully.'], 200);
        } catch (\Exception $e) {
            \Log::error('Post deletion failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to delete post: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function toggleReaction(Request $request, Post $post)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $request->validate(['type' => 'required|in:like,dislike']);
            $userId = Auth::id();
            $cacheKeyLike = "post_{$post->id}_like_count";
            $cacheKeyDislike = "post_{$post->id}_dislike_count";

            $existingLike = Like::where('post_id', $post->id)->where('user_id', $userId)->first();

            if ($existingLike && $existingLike->type === $request->type) {
                $existingLike->delete();
                Cache::decrement($cacheKeyLike, $request->type === 'like' ? 1 : 0);
                Cache::decrement($cacheKeyDislike, $request->type === 'dislike' ? 1 : 0);
                $type = null;
            } else {
                Like::updateOrCreate(
                    ['post_id' => $post->id, 'user_id' => $userId],
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

            $likeCount = Cache::get($cacheKeyLike, fn() => $post->likes()->where('type', 'like')->count());
            $dislikeCount = Cache::get($cacheKeyDislike, fn() => $post->likes()->where('type', 'dislike')->count());

            return response()->json([
                'success' => true,
                'type' => $type,
                'likeCount' => $likeCount,
                'dislikeCount' => $dislikeCount,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Reaction toggle failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to toggle reaction: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function comment(Request $request, Post $post)
    {
        try {
            $request->validate([
                'content' => 'required|string|max:500',
                'parent_id' => 'nullable|exists:comments,id',
            ]);

            $comment = Comment::create([
                'post_id' => $post->id,
                'user_id' => Auth::id(),
                'parent_id' => $request->input('parent_id'),
                'content' => $request->input('content'),
            ]);

            Cache::forget('posts_index');

            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user_name' => Auth::user()->name,
                    'user_id' => Auth::id(),
                    'created_at' => $comment->created_at->diffForHumans(),
                    'parent_id' => $comment->parent_id,
                ],
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Comment creation failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to add comment: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function incrementView(Post $post, Request $request)
    {
        try {
            $sessionId = $request->session()->getId();
            $cacheKey = "post_view_{$post->id}_{$sessionId}";

            if (!Cache::has($cacheKey)) {
                $post->increment('views');
                Cache::put($cacheKey, true, now()->addHours(24));
            }

            Cache::forget('posts_index');

            return response()->json(['success' => true, 'views' => $post->views], 200);
        } catch (\Exception $e) {
            \Log::error('View count failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to update views: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getViews(Post $post)
    {
        try {
            return response()->json(['success' => true, 'views' => $post->views], 200);
        } catch (\Exception $e) {
            \Log::error('View count retrieval failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to retrieve views: ' . $e->getMessage(),
            ], 500);
        }
    }
}