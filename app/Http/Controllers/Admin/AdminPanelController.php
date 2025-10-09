<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Calendar;
use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $totalEvents = Calendar::count();
        $activeUsers = User::where('updated_at', '>=', now()->subDays(30))->count(); // Замена last_login на updated_at
        $recentPosts = Post::with('user')->latest()->take(10)->get();
        $recentEvents = Calendar::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPosts',
            'totalEvents',
            'activeUsers',
            'recentPosts',
            'recentEvents'
        ));
    }

    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function usersShow(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function usersEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, User $user)
    {
        $user->update($request->only(['name', 'email', 'role']));
        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    public function usersDelete(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }

    public function posts()
    {
        $posts = Post::with('user')->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function postsDelete(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts')->with('success', 'Post deleted successfully');
    }

    public function events()
    {
        $events = Calendar::with('user')->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function eventsDelete(Calendar $event)
    {
        $event->delete();
        return redirect()->route('admin.events')->with('success', 'Event deleted successfully');
    }

    public function statistics()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('updated_at', '>=', now()->subDays(30))->count(); // Замена last_login на updated_at
        return view('admin.statistics', compact('totalUsers', 'activeUsers'));
    }
}