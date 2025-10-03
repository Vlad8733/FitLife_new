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
    // Show all posts with cache
    public function index()
    {
        try {
            $posts = Cache::remember('posts_index', 60, fn() => Post::with(['user', 'comments.user', 'likes'])->latest()->get());
            return view('posts.index', compact('posts'));
        } catch (\Exception $e) {
            \Log::error('Failed to load posts: ' . $e->getMessage());
            return back()->with('error', 'Failed to load posts.');
        }
    }

    // Create a new post
    public function store(Request $request)
    {
        try {
            $request->validate([
                'content' => 'nullable|string|max:1000',
                'photo'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $path = $this->handlePhotoUpload($request->file('photo'));

            $post = Post::create([
                'user_id'    => Auth::id(),
                'content'    => $request->input('content'),
                'photo_path' => $path,
                'views'      => 0,
            ]);

            Cache::forget('posts_index');

            return response()->json([
                'success' => true,
                'post'    => $this->formatPostResponse($post),
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Post creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create post, but it may have been added.',
            ], 200);
        }
    }

    // Update an existing post
    public function update(Request $request, Post $post)
    {
        try {
            if (Auth::id() !== $post->user_id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 200);
            }

            $request->validate([
                'content'      => 'nullable|string|max:1000',
                'photo'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_photo' => 'nullable|boolean',
            ]);

            if ($request->hasFile('photo')) {
                $this->deletePhoto($post->photo_path);
                $post->photo_path = $this->handlePhotoUpload($request->file('photo'));
            } elseif ($request->remove_photo) {
                $this->deletePhoto($post->photo_path);
                $post->photo_path = null;
            }

            $post->content = $request->input('content');
            $post->save();
            Cache::forget('posts_index');

            return response()->json([
                'success' => true,
                'post' => [
                    'id' => $post->id,
                    'content' => $post->content,
                    'photo_path' => $post->photo_path,
                ],
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Post update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update post, but it may have been saved.',
            ], 200);
        }
    }

    // Delete a post
    public function destroy(Post $post)
    {
        try {
            if (Auth::id() !== $post->user_id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 200);
            }

            $this->deletePhoto($post->photo_path);
            $post->delete();
            Cache::forget('posts_index');

            return response()->json(['success' => true, 'message' => 'Post deleted successfully'], 200);

        } catch (\Exception $e) {
            \Log::error('Post deletion failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete post, but it may have been removed.',
            ], 200);
        }
    }

    // Like or dislike a post
    public function toggleReaction(Request $request, Post $post)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 200);
            }

            $request->validate(['type' => 'required|in:like,dislike']);
            $userId = Auth::id();
            $existing = Like::where('post_id', $post->id)->where('user_id', $userId)->first();
            $type = $request->type;

            if ($existing && $existing->type === $type) {
                $existing->delete();
                $type = null;
            } else {
                Like::updateOrCreate(['post_id' => $post->id, 'user_id' => $userId], ['type' => $type]);
            }

            Cache::forget("post_{$post->id}_like_count");
            Cache::forget("post_{$post->id}_dislike_count");

            return response()->json([
                'success' => true,
                'type' => $type,
                'likeCount' => $post->likes()->where('type', 'like')->count(),
                'dislikeCount' => $post->likes()->where('type', 'dislike')->count(),
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Reaction toggle failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle reaction, but the change may have applied.',
            ], 200);
        }
    }

    // Add a comment
    public function comment(Request $request, Post $post)
    {
        try {
            $request->validate([
                'content'   => 'required|string|max:500',
                'parent_id' => 'nullable|exists:comments,id',
            ]);

            $comment = Comment::create([
                'post_id'   => $post->id,
                'user_id'   => Auth::id(),
                'parent_id' => $request->input('parent_id'),
                'content'   => $request->input('content'),
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
                'success' => false,
                'message' => 'Failed to add comment, but it may have been created.',
            ], 200);
        }
    }

    // Helpers
    private function handlePhotoUpload($file)
    {
        if (!$file) return null;
        $filename = uniqid('post_') . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('posts', $filename, 'public');
    }

    private function deletePhoto($path)
    {
        if ($path) Storage::disk('public')->delete($path);
    }

    private function formatPostResponse($post)
    {
        $user = Auth::user();
        return [
            'id' => $post->id,
            'content' => $post->content,
            'photo_path' => $post->photo_path,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
                'profile_url' => route('profile.show', $user->id),
            ],
            'created_at' => $post->created_at->diffForHumans(),
        ];
    }
}
