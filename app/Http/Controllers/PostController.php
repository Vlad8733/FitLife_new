<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'comments.user', 'likes'])->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
        ]);

        $path = $request->hasFile('photo') ? $request->file('photo')->store('posts', 'public') : null;

        Post::create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'photo_path' => $path,
            'views' => 0,
        ]);

        return response()->json(['success' => 'Post created successfully.']);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $request->validate([
            'content' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $post->photo_path = $request->file('photo')->store('posts', 'public');
        }

        $post->content = $request->input('content');
        $post->save();

        return response()->json(['success' => 'Post updated successfully.']);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json(['success' => 'Post deleted successfully.']);
    }

    public function toggleReaction(Request $request, Post $post)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $type = $request->input('type');
        if (!in_array($type, ['like', 'dislike'])) {
            return response()->json(['error' => 'Invalid reaction type'], 400);
        }

        $userId = Auth::id();
        $cacheKeyLike = "post_{$post->id}_like_count";
        $cacheKeyDislike = "post_{$post->id}_dislike_count";

        $existingLike = Like::where('post_id', $post->id)->where('user_id', $userId)->first();

        if ($existingLike && $existingLike->type === $type) {
            $existingLike->delete();
            Cache::decrement($cacheKeyLike, $type === 'like' ? 1 : 0);
            Cache::decrement($cacheKeyDislike, $type === 'dislike' ? 1 : 0);
            $type = null;
        } else {
            Like::updateOrCreate(
                ['post_id' => $post->id, 'user_id' => $userId],
                ['type' => $type]
            );
            if ($existingLike && $existingLike->type !== $type) {
                Cache::decrement($cacheKeyLike, $existingLike->type === 'like' ? 1 : 0);
                Cache::decrement($cacheKeyDislike, $existingLike->type === 'dislike' ? 1 : 0);
            }
            Cache::increment($cacheKeyLike, $type === 'like' ? 1 : 0);
            Cache::increment($cacheKeyDislike, $type === 'dislike' ? 1 : 0);
        }

        $likeCount = Cache::get($cacheKeyLike, fn() => $post->likes()->where('type', 'like')->count());
        $dislikeCount = Cache::get($cacheKeyDislike, fn() => $post->likes()->where('type', 'dislike')->count());

        return response()->json([
            'type' => $type,
            'likeCount' => $likeCount,
            'dislikeCount' => $dislikeCount,
        ]);
    }

    public function comment(Request $request, Post $post)
    {
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

        return response()->json([
            'success' => 'Comment added successfully.',
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'user_name' => Auth::user()->name,
                'created_at' => $comment->created_at->diffForHumans(),
                'parent_id' => $comment->parent_id,
            ],
        ]);
    }

    public function incrementView(Post $post, Request $request)
    {
        $sessionId = $request->session()->getId();
        $cacheKey = "post_view_{$post->id}_{$sessionId}";

        if (!Cache::has($cacheKey)) {
            $post->increment('views');
            Cache::put($cacheKey, true, now()->addHours(24));
        }

        return response()->json(['views' => $post->views]);
    }

    public function getViews(Post $post)
    {
        return response()->json(['views' => $post->views]);
    }
}