@extends('layouts.app')

@section('content')
  <div id="fitlife-container" role="application" aria-label="FitLife Profile Settings">
    <!-- Sidebar -->
    <aside id="sidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <h2>FitLife</h2>
        <p>Power Your Performance</p>
      </div>
      <nav class="nav-menu" aria-label="Main menu">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" {{ request()->routeIs('dashboard') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M3 13h8V3H3z" />
            <path d="M13 21h8V11h-8z" />
            <path d="M13 3v8" />
          </svg>
          <span>Home</span>
        </a>
        <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.*') ? 'active' : '' }}" {{ request()->routeIs('posts.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
            <path d="M17 8l4 4-4 4" />
          </svg>
          <span>Community Posts</span>
        </a>
        <a href="{{ route('foods.index') }}" class="{{ request()->routeIs('foods.*') ? 'active' : '' }}" {{ request()->routeIs('foods.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M4 21c4-4 6-11 6-17" />
            <path d="M20 7a4 4 0 11-8 0" />
          </svg>
          <span>Meal Tracker</span>
        </a>
        <a href="{{ route('sleep.index') }}" class="{{ request()->routeIs('sleep.*') ? 'active' : '' }}" {{ request()->routeIs('sleep.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
          </svg>
          <span>Sleep Tracker</span>
        </a>
        <a href="{{ route('water.index') }}" class="{{ request()->routeIs('water.*') ? 'active' : '' }}" {{ request()->routeIs('water.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M12 2s4 5 4 8a4 4 0 01-8 0c0-3 4-8 4-8z" />
          </svg>
          <span>Water Tracker</span>
        </a>
        <a href="{{ route('progress.index') }}" class="{{ request()->routeIs('progress.*') ? 'active' : '' }}" {{ request()->routeIs('progress.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M21 3v18H3V3h18z" />
            <path d="M7 14l3-3 2 2 5-5" />
          </svg>
          <span>Progress Photos</span>
        </a>
        <a href="{{ route('goals.index') }}" class="{{ request()->routeIs('goals.*') ? 'active' : '' }}" {{ request()->routeIs('goals.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4l3 3" />
          </svg>
          <span>Goals</span>
        </a>
        <a href="{{ route('calories.index') }}" class="{{ request()->routeIs('calories.*') ? 'active' : '' }}" {{ request()->routeIs('calories.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M12 2v20" />
            <path d="M5 12h14" />
          </svg>
          <span>Calorie Calculator</span>
        </a>
        <a href="{{ route('biography.edit') }}" class="{{ request()->routeIs('biography.*') ? 'active' : '' }}" {{ request()->routeIs('biography.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <circle cx="12" cy="8" r="4" />
            <path d="M6 20v-1a6 6 0 0112 0v1" />
          </svg>
          <span>Biography</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}" {{ request()->routeIs('profile.edit') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
          </svg>
          <span>Profile</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
          @csrf
          <button type="submit" aria-label="Logout">Logout</button>
        </form>
      </nav>
    </aside>

    <!-- Main Content -->
    <main>
      <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">Menu</button>

      <header>
        <div class="header-left">
          <h1><span>FitLife</span> Profile Settings</h1>
        </div>
        <div class="header-info">
          <div>{{ now()->format('l, F d, Y') }}</div>
          <div>{{ now()->format('H:i') }}</div>
        </div>
      </header>

      <section aria-labelledby="profile-settings-heading">
        @if(session('status'))
          <div class="success-msg">{{ session('status') }}</div>
        @endif

        <!-- Profile Form -->
        <div class="form-group">
          <h3 id="profile-settings-heading">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
            </svg>
            Update Profile
          </h3>
          <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <button type="submit" class="save-btn">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                <path d="M17 21v-8H7v8" />
                <path d="M7 3v5h8" />
              </svg>
              Save Profile
            </button>
          </form>
        </div>

        <!-- Password Change Form -->
        <div class="form-group">
          <h3>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path d="M12 2a5 5 0 00-5 5v2a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2v-7a2 2 0 00-2-2V7a5 5 0 00-5-5z" />
              <path d="M12 15a2 2 0 110-4 2 2 0 010 4z" />
            </svg>
            Update Password
          </h3>
          <form action="{{ route('password.update') }}" method="POST">
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
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                <path d="M17 21v-8H7v8" />
                <path d="M7 3v5h8" />
              </svg>
              Update Password
            </button>
          </form>
        </div>

        <!-- Delete Account Form -->
        <div class="form-group">
          <h3>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path d="M3 6h18" />
              <path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2" />
              <path d="M6 6v15a2 2 0 002 2h8a2 2 0 002-2V6" />
              <path d="M10 11v6" />
              <path d="M14 11v6" />
            </svg>
            Delete Account
          </h3>
          <form action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-btn">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M3 6h18" />
                <path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2" />
                <path d="M6 6v15a2 2 0 002 2h8a2 2 0 002-2V6" />
                <path d="M10 11v6" />
                <path d="M14 11v6" />
              </svg>
              Delete Account
            </button>
          </form>
        </div>
      </section>
    </main>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      /* ===== Sidebar Mobile Toggle ===== */
      const mobileToggle = document.getElementById('mobile-toggle');
      const body = document.body;
      const sidebar = document.getElementById('sidebar');

      mobileToggle.addEventListener('click', () => {
        const opened = body.classList.toggle('sidebar-open');
        mobileToggle.setAttribute('aria-expanded', opened ? 'true' : 'false');
      });

      document.addEventListener('click', (e) => {
        if (!body.classList.contains('sidebar-open')) return;
        if (sidebar.contains(e.target) || mobileToggle.contains(e.target)) return;
        body.classList.remove('sidebar-open');
        mobileToggle.setAttribute('aria-expanded', 'false');
      });

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && body.classList.contains('sidebar-open')) {
          body.classList.remove('sidebar-open');
          mobileToggle.setAttribute('aria-expanded', 'false');
        }
      });
    });
  </script>
@endsection