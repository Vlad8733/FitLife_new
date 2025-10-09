@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/adminposts.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="posts-content">
        <header class="posts-header">
            <h1 class="posts-title">Posts Management</h1>
            <a href="{{ route('admin.dashboard') }}" class="posts-back-btn">← Back to Dashboard</a>
        </header>

        <div class="posts-search">
            <input type="text" id="post-search" placeholder="Search posts..." class="posts-search-input">
        </div>

        <div class="posts-section">
            <div class="posts-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Content</th>
                            <th>Views</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->user->name }}</td>
                                <td>{{ Str::limit($post->content, 50) }}</td>
                                <td>{{ $post->views }}</td>
                                <td>{{ $post->created_at->format('M d, Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.posts.delete', $post) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="posts-btn posts-btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No posts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="posts-pagination">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('post-search').addEventListener('input', function() {
            let search = this.value.toLowerCase();
            document.querySelectorAll('.posts-table tr').forEach(row => {
                let user = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase();
                let content = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase();
                if (user && content && (user.includes(search) || content.includes(search))) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection