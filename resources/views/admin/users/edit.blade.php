@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="users-content">
        <header class="users-header">
            <h1 class="users-title">Edit User: {{ $user->name }}</h1>
            <a href="{{ route('admin.users.show', $user) }}" class="users-back-btn">← Back to User</a>
        </header>

        <div class="users-section">
            <h2 class="users-section-title">Edit User Details</h2>
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="users-form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="users-input" required>
                    @error('name')
                        <span class="users-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="users-form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="users-input" required>
                    @error('email')
                        <span class="users-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="users-form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" class="users-select" required>
                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <span class="users-error">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="users-btn users-btn-success">Update User</button>
            </form>
        </div>
    </div>
@endsection