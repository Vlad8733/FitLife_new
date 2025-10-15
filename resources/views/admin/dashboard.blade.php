@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/admindashboard.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="admindashboard-content">
        <header class="admindashboard-header">
            <h1 class="admindashboard-title">Admin Dashboard</h1>
            <p class="admindashboard-subtitle">Manage users, posts, and events</p>
        </header>

        <div class="admindashboard-stats-grid">
            <div class="admindashboard-stat-card">
                <div class="admindashboard-stat-icon">👥</div>
                <h3 class="admindashboard-stat-number">{{ $totalUsers }}</h3>
                <p class="admindashboard-stat-label">Total Users</p>
                <a href="{{ route('admin.users') }}" class="admindashboard-btn admindashboard-btn-primary">Manage Users</a>
            </div>
            <div class="admindashboard-stat-card">
                <div class="admindashboard-stat-icon">📝</div>
                <h3 class="admindashboard-stat-number">{{ $totalPosts }}</h3>
                <p class="admindashboard-stat-label">Total Posts</p>
                <a href="{{ route('admin.posts') }}" class="admindashboard-btn admindashboard-btn-primary">Manage Posts</a>
            </div>
            <div class="admindashboard-stat-card">
                <div class="admindashboard-stat-icon">🟢</div>
                <h3 class="admindashboard-stat-number">{{ $activeUsers }}</h3>
                <p class="admindashboard-stat-label">Active Users (30 days)</p>
            </div>
        </div>

        <div class="admindashboard-sections">
            <div class="admindashboard-section">
                <h2 class="admindashboard-section-title">Recent Posts</h2>
                <div class="admindashboard-table">
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Content</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPosts as $post)
                                <tr>
                                    <td>{{ $post->user->name }}</td>
                                    <td>{{ Str::limit($post->content, 50) }}</td>
                                    <td>{{ $post->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('profile.show', $post->user) }}" class="admindashboard-btn admindashboard-btn-primary">View Profile</a>
                                        <form action="{{ route('admin.posts.delete', $post) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admindashboard-btn admindashboard-btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No recent posts.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection