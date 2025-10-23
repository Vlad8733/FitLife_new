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
    public function index(Request $request)
    {
        try {
            $perPage = 10;
            $page = $request->input('page', 1);
            $cacheKey = "posts_page_{$page}";
            $posts = Cache::remember($cacheKey, 60, function () use ($perPage) {
                return Post::with(['user', 'comments' => function ($query) {
                    $query->whereNull('parent_id')->with(['replies.user', 'user', 'replies.replies.user', 'parent.user']);
                }, 'likes'])->latest()->paginate($perPage);
            });

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'posts' => $posts->items()->map(function ($post) {
                        return $this->formatPostForJson($post);
                    }),
                ]);
            }

            return view('posts.index', compact('posts'));
        } catch (\Exception $e) {
            \Log::error('Failed to load posts: ' . $e->getMessage());
            return back()->with('error', 'Failed to load posts: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'content' => 'nullable|string|max:1000',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'video' => 'nullable|mimetypes:video/mp4,video/mpeg,video/ogg,video/webm|max:10240',
            ]);

            $media = $this->handleMediaUpload($request->file('photo'), $request->file('video'));

            $post = Post::create([
                'user_id' => Auth::id(),
                'content' => $request->input('content'),
                'media_path' => $media['path'],
                'media_type' => $media['type'],
                'views' => 0,
            ]);

            Cache::forget('posts_page_1');

            return response()->json([
                'success' => true,
                'post' => $this->formatPostResponse($post),
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Post creation validation failed: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->errors()['photo'] ?? $e->errors()['video'] ?? ['Unknown error']),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Post creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create post: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Post $post)
    {
        try {
            if (Auth::id() !== $post->user_id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $request->validate([
                'content' => 'nullable|string|max:1000',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'video' => 'nullable|mimetypes:video/mp4,video/mpeg,video/ogg,video/webm|max:10240',
                'remove_media' => 'nullable|boolean',
            ]);

            $mediaPath = $post->media_path;
            $mediaType = $post->media_type;

            if ($request->hasFile('photo') || $request->hasFile('video')) {
                $this->deleteMedia($post->media_path);
                $media = $this->handleMediaUpload($request->file('photo'), $request->file('video'));
                $mediaPath = $media['path'];
                $mediaType = $media['type'];
            } elseif ($request->input('remove_media')) {
                $this->deleteMedia($post->media_path);
                $mediaPath = null;
                $mediaType = null;
            }

            $post->update([
                'content' => $request->input('content'),
                'media_path' => $mediaPath,
                'media_type' => $mediaType,
            ]);

            Cache::forget('posts_page_1');

            return response()->json([
                'success' => true,
                'post' => [
                    'id' => $post->id,
                    'content' => $post->content,
                    'media_path' => $post->media_path,
                    'media_type' => $post->media_type,
                ],
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Post update validation failed: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->errors()['photo'] ?? $e->errors()['video'] ?? ['Unknown error']),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Post update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update post: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Post $post)
    {
        try {
            if (Auth::id() !== $post->user_id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $this->deleteMedia($post->media_path);
            $post->delete();
            Cache::forget('posts_page_1');

            return response()->json(['success' => true, 'message' => 'Post deleted successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Post deletion failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete post: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function toggleReaction(Request $request, Post $post)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $request->validate(['type' => 'required|in:like,dislike']);
            $userId = Auth::id();
            $existing = Like::where('post_id', $post->id)->where('user_id', $userId)->first();
            $type = $request->input('type');

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
                'message' => 'Failed to toggle reaction: ' . $e->getMessage(),
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

            $existingComment = Comment::where([
                'post_id' => $post->id,
                'user_id' => Auth::id(),
                'content' => $request->input('content'),
                'parent_id' => $request->input('parent_id'),
            ])->first();

            if ($existingComment) {
                return response()->json([
                    'success' => true,
                    'comment' => $this->formatCommentForJson($existingComment),
                ], 200);
            }

            $comment = Comment::create([
                'post_id' => $post->id,
                'user_id' => Auth::id(),
                'parent_id' => $request->input('parent_id'),
                'content' => $request->input('content'),
            ]);

            $comment->load('parent.user');

            Cache::forget('posts_page_1');

            return response()->json([
                'success' => true,
                'comment' => $this->formatCommentForJson($comment),
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Comment creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add comment: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function incrementViews(Request $request, Post $post)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $userId = Auth::id();
            $cacheKey = "post_view_{$post->id}_{$userId}";

            if (!Cache::has($cacheKey)) {
                $post->increment('views');
                Cache::put($cacheKey, true, now()->addMinutes(60));
                Cache::forget("posts_page_1");
            }

            return response()->json([
                'success' => true,
                'views' => $post->views,
            ], 200);
        } catch (\Exception $e) {
            \Log::error('View increment failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to increment views: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function handleMediaUpload($photo, $video)
    {
        if ($photo) {
            $filename = uniqid('post_') . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('posts', $filename, 'public');
            return ['path' => $path, 'type' => 'image'];
        } elseif ($video) {
            $filename = uniqid('post_') . '.' . $video->getClientOriginalExtension();
            $path = $video->storeAs('posts', $filename, 'public');
            return ['path' => $path, 'type' => 'video'];
        }
        return ['path' => null, 'type' => null];
    }

    private function deleteMedia($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function formatPostResponse($post)
    {
        $user = Auth::user();
        return [
            'id' => $post->id,
            'content' => $post->content,
            'media_path' => $post->media_path,
            'media_type' => $post->media_type,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
                'username' => $user->username,
                'profile_url' => route('profile.show', $user->id),
            ],
            'created_at_diff' => $post->created_at->diffForHumans(),
            'views' => $post->views,
            'like_count' => $post->likes()->where('type', 'like')->count(),
            'dislike_count' => $post->likes()->where('type', 'dislike')->count(),
            'comment_count' => $post->allComments()->count(),
            'user_liked' => $post->isLikedBy(Auth::id()),
            'user_disliked' => $post->isDislikedBy(Auth::id()),
            'can_update' => Auth::id() === $post->user_id,
            'can_delete' => Auth::id() === $post->user_id,
        ];
    }

    private function formatPostForJson($post)
    {
        return [
            'id' => $post->id,
            'content' => $post->content,
            'media_path' => $post->media_path,
            'media_type' => $post->media_type,
            'user' => [
                'name' => $post->user->name,
                'username' => $post->user->username,
                'avatar' => $post->user->avatar,
                'profile_url' => route('profile.show', $post->user->id),
            ],
            'created_at_diff' => $post->created_at->diffForHumans(),
            'views' => $post->views,
            'like_count' => $post->likes()->where('type', 'like')->count(),
            'dislike_count' => $post->likes()->where('type', 'dislike')->count(),
            'comment_count' => $post->allComments()->count(),
            'user_liked' => $post->isLikedBy(Auth::id()),
            'user_disliked' => $post->isDislikedBy(Auth::id()),
            'can_update' => Auth::id() === $post->user_id,
            'can_delete' => Auth::id() === $post->user_id,
            'comments' => $post->allComments->map(function ($comment) {
                return $this->formatCommentForJson($comment);
            })->toArray(),
        ];
    }

    private function formatCommentForJson($comment)
    {
        $comment->load('parent.user');
        return [
            'id' => $comment->id,
            'content' => $comment->content,
            'user_name' => $comment->user->name,
            'user' => [
                'username' => $comment->user->username,
                'profile_url' => route('profile.show', $comment->user->id),
            ],
            'created_at_diff' => $comment->created_at->diffForHumans(),
            'parent_id' => $comment->parent_id,
            'parent_username' => $comment->parent ? $comment->parent->user->username : null,
            'parent_profile_url' => $comment->parent ? route('profile.show', $comment->parent->user->id) : null,
            'reply_count' => $comment->replies()->count(),
            'like_count' => $comment->likes()->where('type', 'like')->count(),
            'dislike_count' => $comment->likes()->where('type', 'dislike')->count(),
            'user_liked' => $comment->likes()->where('user_id', Auth::id())->where('type', 'like')->exists(),
            'user_disliked' => $comment->likes()->where('user_id', Auth::id())->where('type', 'dislike')->exists(),
            'can_update' => Auth::id() === $comment->user_id,
            'can_delete' => Auth::id() === $comment->user_id,
        ];
    }
}