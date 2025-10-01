@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="fitlife-container" role="application" aria-label="FitLife Profile Settings">
    <main id="main-content">
        <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <header><h1>Profile Settings</h1></header>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <section aria-labelledby="profile-settings-heading">
            <div class="profile-card">
                <h3 id="profile-settings-heading">Update Profile</h3>

                <div class="profile-banner">
                    <div class="banner-bg" style="background-image: url('{{ $user->banner ? asset("storage/{$user->banner}") : asset('storage/banner/default-banner.jpg') }}');">
                        <img
                            src="{{ $user->avatar ? asset("storage/{$user->avatar}") : asset('storage/logo/defaultPhoto.jpg') }}"
                            alt="Profile Photo"
                            class="banner-avatar"
                            id="bannerAvatar"
                        >
                        <label for="banner" class="change-banner-label">Change Banner</label>
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="profile-form" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="banner">Banner Image</label>
                            <input type="file" id="banner" name="banner" accept="image/*" style="display: none;">
                            @error('banner')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="avatar">Profile Photo</label>
                            <input type="file" id="avatar" name="avatar" accept="image/*">
                            @error('avatar')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required aria-required="true" aria-describedby="name-error">
                            @error('name')
                                <p id="name-error" class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required aria-required="true" aria-describedby="email-error">
                            @error('email')
                                <p id="email-error" class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="save-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                            <path d="M17 21v-8H7v8"/>
                            <path d="M7 3v5h8"/>
                        </svg>
                        Save Profile
                    </button>
                </form>
            </div>

            <div class="profile-card">
                <h3>Update Password</h3>
                <form action="{{ route('password.update') }}" method="POST" class="profile-form">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="save-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                            <path d="M17 21v-8H7v8"/>
                            <path d="M7 3v5h8"/>
                        </svg>
                        Update Password
                    </button>
                </form>
            </div>

            <div class="profile-card">
                <h3>Delete Account</h3>
                <form action="{{ route('profile.destroy') }}" method="POST" class="profile-form">
                    @csrf
                    @method('DELETE')
                    <p class="muted">This action cannot be undone. Permanently delete your account?</p>
                    <button type="submit" class="delete-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2M6 6v15a2 2 0 002 2h8a2 2 0 002-2V6M10 11v6M14 11v6"/>
                        </svg>
                        Delete Account
                    </button>
                </form>
            </div>
        </section>
    </main>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/profile.js') }}"></script>
@endsection