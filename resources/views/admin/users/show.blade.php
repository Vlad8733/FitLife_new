@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="users-content">
        <header class="users-header">
            <h1 class="users-title">User: {{ $user->name }}</h1>
            <a href="{{ route('admin.users') }}" class="users-back-btn">← Back to Users</a>
        </header>

        <div class="users-section">
            <h2 class="users-section-title">User Details</h2>
            <div class="users-details">
                <p><strong>ID:</strong> {{ $user->id }}</p>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> <span class="role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span></p>
                <p><strong>Username:</strong> {{ $user->username ?? 'Not set' }}</p>
                <p><strong>Created:</strong> {{ $user->created_at->format('M d, Y') }}</p>
                <p><strong>Last Login:</strong> {{ $user->last_login ? $user->last_login->format('M d, Y H:i') : 'Never' }}</p>
            </div>
        </div>

        <div class="users-section">
            <h2 class="users-section-title">Biography</h2>
            <div class="users-details">
                <p><strong>Full Name:</strong> {{ $user->biography->full_name ?? 'Not set' }}</p>
                <p><strong>Age:</strong> {{ $user->biography->age ?? 'Not set' }}</p>
                <p><strong>Height:</strong> {{ $user->biography->height ?? 'Not set' }} cm</p>
                <p><strong>Weight:</strong> {{ $user->biography->weight ?? 'Not set' }} kg</p>
                <p><strong>Gender:</strong> {{ $user->biography->gender ?? 'Not set' }}</p>
            </div>
        </div>

        <div class="users-section">
            <h2 class="users-section-title">Posts ({{ $user->posts->count() }})</h2>
            <div class="users-table">
                <table>
                    <thead>
                        <tr>
                            <th>Content</th>
                            <th>Views</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->posts as $post)
                            <tr>
                                <td>{{ Str::limit($post->content, 50) }}</td>
                                <td>{{ $post->views }}</td>
                                <td>{{ $post->created_at->format('M d, Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.posts.delete', $post) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="users-btn users-btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No posts.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="users-section">
            <h2 class="users-section-title">Friends ({{ $user->friends->count() }})</h2>
            <div class="users-table">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->friends as $friend)
                            <tr>
                                <td>{{ $friend->name }}</td>
                                <td>{{ $friend->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">No friends.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection