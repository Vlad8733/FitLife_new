@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="users-content">
        <header class="users-header">
            <h1 class="users-title">Users Management</h1>
            <a href="{{ route('admin.dashboard') }}" class="users-back-btn">← Back to Dashboard</a>
        </header>

        <div class="users-search">
            <input type="text" id="user-search" placeholder="Search users..." class="users-search-input">
            <select id="role-filter" class="users-search-select">
                <option value="">All Roles</option>
                <option value="user">Users</option>
                <option value="admin">Admins</option>
            </select>
        </div>

        <div class="users-section">
            <div class="users-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Posts</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td>{{ $user->posts->count() }}</td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user) }}" class="users-btn users-btn-primary">View</a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="users-btn users-btn-secondary">Edit</a>
                                    <form action="{{ route('admin.users.delete', $user) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="users-btn users-btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="users-pagination">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('user-search').addEventListener('input', function() {
            let search = this.value.toLowerCase();
            document.querySelectorAll('.users-table tr').forEach(row => {
                let name = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase();
                let email = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase();
                if (name && email && (name.includes(search) || email.includes(search))) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        document.getElementById('role-filter').addEventListener('change', function() {
            let role = this.value;
            document.querySelectorAll('.users-table tr').forEach(row => {
                let roleCell = row.querySelector('td:nth-child(4) .role-badge')?.textContent.toLowerCase();
                if (!role || (roleCell && roleCell === role)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection