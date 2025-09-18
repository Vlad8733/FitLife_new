<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with(['user','comments.user','comments.replies.user','likes'])->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function store(Request $request) {
        $request->validate([
            'content' => 'nullable|string|max:1000',
            'photo'   => 'nullable|image|max:2048',
        ]);

        $path = $request->hasFile('photo') ? $request->file('photo')->store('posts','public') : null;

        Post::create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'photo_path' => $path,
        ]);

        return back();
    }

    public function update(Request $request, Post $post) {
        $this->authorize('update',$post);

        $request->validate([
            'content' => 'nullable|string|max:1000',
            'photo'   => 'nullable|image|max:2048',
        ]);

        if($request->hasFile('photo')){
            $post->photo_path = $request->file('photo')->store('posts','public');
        }

        $post->content = $request->input('content');
        $post->save();

        return back();
    }

    public function destroy(Post $post) {
        $this->authorize('delete',$post);
        $post->delete();
        return back();
    }

    public function like(Post $post) {
        $like = Like::updateOrCreate(
            ['post_id'=>$post->id,'user_id'=>Auth::id()],
            ['type'=>'like']
        );
        return back();
    }

    public function dislike(Post $post) {
        $like = Like::updateOrCreate(
            ['post_id'=>$post->id,'user_id'=>Auth::id()],
            ['type'=>'dislike']
        );
        return back();
    }

    public function comment(Request $request, Post $post) {
        $request->validate(['content'=>'required|string|max:500']);
        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'parent_id' => $request->input('parent_id'),
            'content' => $request->input('content'),
        ]);
        return back();
    }
}
