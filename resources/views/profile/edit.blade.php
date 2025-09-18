@extends('layouts.app')

@section('content')
  <style>
    /* ====== Reset ====== */
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html,
    body,
    #app {
      height: 100%;
      width: 100%;
      overflow-x: hidden;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      background: linear-gradient(180deg, #0A0C10, #1A1F26);
      color: #E6ECEF;
      line-height: 1.6;
    }

    /* ====== Palette & Variables ====== */
    :root {
      --bg: #0A0C10;
      --panel: #14171C;
      --muted: #8A94A6;
      --neon: #00FF88;
      --accent: #FF3D00;
      --white: #F5F7FA;
      --glass: rgba(255, 255, 255, 0.04);
      --shadow: 0 6px 20px rgba(0, 0, 0, 0.7);
      --glow: 0 0 15px rgba(0, 255, 136, 0.4);
      --radius: 14px;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      --font-size-base: 16px;
      --font-weight-bold: 700;
      --font-weight-medium: 500;
    }

    /* ====== Layout ====== */
    #fitlife-container {
      display: flex;
      min-height: 100vh;
      width: 100%;
      background: var(--bg);
      overflow-x: hidden;
    }

    /* ====== Sidebar ====== */
    aside#sidebar {
      width: 280px;
      background: linear-gradient(180deg, #14171C, #0C1014);
      padding: 24px;
      display: flex;
      flex-direction: column;
      gap: 14px;
      box-shadow: var(--shadow);
      transition: var(--transition);
      z-index: 1200;
    }

    @media (max-width: 960px) {
      aside#sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        transform: translateX(-100%);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.8);
      }

      body.sidebar-open aside#sidebar {
        transform: translateX(0);
      }
    }

    .sidebar-header {
      text-align: center;
      padding-bottom: 12px;
      border-bottom: 1px solid var(--glass);
    }

    .sidebar-header h2 {
      font-size: 1.6rem;
      color: var(--neon);
      font-weight: var(--font-weight-bold);
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .sidebar-header p {
      font-size: 0.85rem;
      color: var(--muted);
      margin-top: 4px;
    }

    nav.nav-menu {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 8px;
      margin-top: 12px;
    }

    nav.nav-menu a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 16px;
      color: var(--white);
      text-decoration: none;
      font-size: 0.95rem;
      font-weight: var(--font-weight-medium);
      border-radius: 10px;
      background: var(--glass);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    nav.nav-menu a::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(0, 255, 136, 0.1), transparent);
      transition: left 0.5s ease;
    }

    nav.nav-menu a:hover::before {
      left: 100%;
    }

    nav.nav-menu a svg {
      width: 16px;
      height: 16px;
      fill: none;
      stroke: var(--neon);
      transition: transform 0.2s ease, stroke 0.2s ease;
    }

    nav.nav-menu a:hover {
      background: rgba(0, 255, 136, 0.08);
      transform: translateX(6px);
    }

    nav.nav-menu a:hover svg {
      transform: scale(1.1);
      stroke: var(--accent);
    }

    nav.nav-menu a.active {
      background: linear-gradient(90deg, rgba(0, 255, 136, 0.15), rgba(255, 61, 0, 0.1));
      color: var(--neon);
      box-shadow: var(--glow);
    }

    /* ====== Unified Button Styles ====== */
    button,
    .logout-form button,
    .save-btn,
    .delete-btn {
      padding: 6px 10px;
      background: linear-gradient(90deg, var(--neon), var(--accent));
      color: var(--white);
      border: none;
      border-radius: 8px;
      font-size: 0.8rem;
      font-weight: var(--font-weight-bold);
      cursor: pointer;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      box-shadow: var(--glow);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      text-align: center;
      white-space: nowrap;
      line-height: 1.2;
    }

    button:hover,
    .logout-form button:hover,
    .save-btn:hover,
    .delete-btn:hover {
      box-shadow: 0 0 20px rgba(0, 255, 136, 0.6);
      background: linear-gradient(90deg, var(--accent), var(--neon));
    }

    button::before,
    .logout-form button::before,
    .save-btn::before,
    .delete-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.4s ease;
    }

    button:hover::before,
    .logout-form button:hover::before,
    .save-btn:hover::before,
    .delete-btn:hover::before {
      left: 100%;
    }

    .delete-btn {
      background: linear-gradient(90deg, #ef4444, #f87171);
    }

    .delete-btn:hover {
      background: linear-gradient(90deg, #f87171, #ef4444);
      box-shadow: 0 0 20px rgba(239, 68, 68, 0.6);
    }

    button svg,
    .save-btn svg,
    .delete-btn svg {
      width: 14px;
      height: 14px;
      stroke: var(--white);
    }

    /* ====== Main Content ====== */
    main {
      flex: 1;
      padding: 32px;
      background: var(--bg);
      min-height: 100vh;
      overflow-y: auto;
    }

    #mobile-toggle {
      display: none;
    }

    @media (max-width: 960px) {
      #mobile-toggle {
        display: inline-block;
        padding: 6px 10px;
        font-size: 0.8rem;
        background: linear-gradient(90deg, var(--neon), var(--accent));
        color: var(--white);
        border-radius: 8px;
        box-shadow: var(--glow);
      }

      #mobile-toggle:hover {
        background: linear-gradient(90deg, var(--accent), var(--neon));
        box-shadow: 0 0 20px rgba(0, 255, 136, 0.6);
      }
    }

    header {
      background: var(--panel);
      padding: 24px;
      border-radius: var(--radius);
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
      box-shadow: var(--shadow);
      margin-bottom: 24px;
    }

    .header-left h1 {
      font-size: 1.8rem;
      font-weight: var(--font-weight-bold);
      color: var(--neon);
      margin: 0;
    }

    .header-left h1 span {
      font-weight: 300;
      color: var(--white);
    }

    .header-info {
      display: flex;
      gap: 16px;
      font-size: 0.9rem;
      color: var(--muted);
    }

    .header-info div {
      background: var(--glass);
      padding: 6px 12px;
      border-radius: 8px;
    }

    /* ====== Form Styling ====== */
    .form-group {
      background: linear-gradient(135deg, var(--panel), #1A1F26);
      padding: 24px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      transition: box-shadow 0.3s ease;
      margin-bottom: 24px;
    }

    .form-group:hover {
      box-shadow: var(--glow), var(--shadow);
    }

    .form-group h3 {
      font-size: 1.4rem;
      color: var(--neon);
      font-weight: var(--font-weight-bold);
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-group h3 svg {
      width: 14px;
      height: 14px;
      stroke: var(--neon);
    }

    .form-group label {
      font-size: 0.95rem;
      color: var(--white);
      font-weight: var(--font-weight-medium);
      margin-bottom: 8px;
      display: block;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid var(--glass);
      background: rgba(255, 255, 255, 0.05);
      color: var(--white);
      font-size: 0.9rem;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-group input:focus {
      outline: none;
      border-color: var(--neon);
      box-shadow: 0 0 0 2px rgba(0, 255, 136, 0.3);
    }

    .form-group input::placeholder {
      color: var(--muted);
    }

    /* ====== Success Message ====== */
    .success-msg {
      text-align: center;
      padding: 16px;
      background: var(--glass);
      border-radius: var(--radius);
      color: var(--neon);
      font-size: 0.95rem;
      font-weight: var(--font-weight-medium);
      margin-bottom: 24px;
      box-shadow: var(--shadow);
    }

    /* ====== Responsive Design ====== */
    @media (max-width: 768px) {
      main {
        padding: 20px;
      }

      .header-info {
        flex-direction: column;
        gap: 8px;
      }
    }

    @media (max-width: 480px) {
      header {
        flex-direction: column;
        text-align: center;
      }

      .header-left h1 {
        font-size: 1.5rem;
      }

      .form-group {
        padding: 16px;
      }
    }

    /* ====== Animations ====== */
    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    section,
    .form-group,
    .success-msg {
      animation: fadeIn 0.5s var(--animation-ease);
    }

    /* ====== Accessibility ====== */
    @media (prefers-reduced-motion: reduce) {

      .form-group,
      button,
      aside#sidebar {
        transition: none;
      }
    }

    @media (prefers-contrast: high) {
      .form-group {
        border: 2px solid var(--white);
      }

      .form-group input {
        border: 1px solid var(--white);
      }

      nav.nav-menu a.active,
      .save-btn {
        background: var(--white);
        color: var(--bg);
      }

      .delete-btn {
        background: #ef4444;
        color: var(--white);
      }
    }
  </style>

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