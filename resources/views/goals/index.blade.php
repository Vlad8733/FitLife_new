@extends('layouts.app')

@section('content')
  <div id="fitlife-container" role="application" aria-label="FitLife Goals">
    <!-- Sidebar -->
    <aside id="sidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <h2>FitLife</h2>
        <p>Power Your Performance</p>
      </div>
      <nav class="nav-menu" aria-label="Main menu">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" {{ request()->routeIs('dashboard') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M3 13h8V3H3zM13 21h8V11h-8zM13 3v8" />
          </svg>
          <span>Home</span>
        </a>
        <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.*') ? 'active' : '' }}" {{ request()->routeIs('posts.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2M17 8l4 4-4 4" />
          </svg>
          <span>Community Posts</span>
        </a>
        <a href="{{ route('foods.index') }}" class="{{ request()->routeIs('foods.*') ? 'active' : '' }}" {{ request()->routeIs('foods.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M4 21c4-4 6-11 6-17M20 7a4 4 0 11-8 0" />
          </svg>
          <span>Meal Tracker</span>
        </a>
        <a href="{{ route('sleep.index') }}" class="{{ request()->routeIs('sleep.*') ? 'active' : '' }}" {{ request()->routeIs('sleep.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
          </svg>
          <span>Sleep Tracker</span>
        </a>
        <a href="{{ route('water.index') }}" class="{{ request()->routeIs('water.*') ? 'active' : '' }}" {{ request()->routeIs('water.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 2s4 5 4 8a4 4 0 01-8 0c0-3 4-8 4-8z" />
          </svg>
          <span>Water Tracker</span>
        </a>
        <a href="{{ route('progress.index') }}" class="{{ request()->routeIs('progress.*') ? 'active' : '' }}" {{ request()->routeIs('progress.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M21 3v18H3V3h18zM7 14l3-3 2 2 5-5" />
          </svg>
          <span>Progress Photos</span>
        </a>
        <a href="{{ route('goals.index') }}" class="{{ request()->routeIs('goals.*') ? 'active' : '' }}" {{ request()->routeIs('goals.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4l3 3" />
          </svg>
          <span>Goals</span>
        </a>
        <a href="{{ route('calories.index') }}" class="{{ request()->routeIs('calories.*') ? 'active' : '' }}" {{ request()->routeIs('calories.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 2v20M5 12h14" />
          </svg>
          <span>Calorie Calculator</span>
        </a>
        <a href="{{ route('biography.edit') }}" class="{{ request()->routeIs('biography.*') ? 'active' : '' }}" {{ request()->routeIs('biography.*') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="8" r="4" />
            <path d="M6 20v-1a6 6 0 0112 0v1" />
          </svg>
          <span>Biography</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}" {{ request()->routeIs('profile.edit') ? 'aria-current=page' : '' }}>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
          </svg>
          <span>Profile</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
          @csrf
          <button type="submit" aria-label="Logout">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" />
            </svg>
            <span>Logout</span>
          </button>
        </form>
      </nav>
    </aside>

    <!-- Main Content -->
    <main>
      <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <header>
        <div class="header-left">
          <h1><span>FitLife</span> Goals</h1>
          <p class="muted">Track your daily progress and stay motivated!</p>
        </div>
        <div class="header-info">
          <div>{{ now()->format('l, F d, Y') }}</div>
          <div>{{ now()->format('H:i') }}</div>
        </div>
      </header>

      <!-- Create Goal Button -->
      <section aria-labelledby="create-goal-heading">
        <h3 id="create-goal-heading">Your Goals</h3>
        <a href="{{ route('goals.create') }}" class="create-btn">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 5v14M5 12h14" />
          </svg>
          New Goal
        </a>
      </section>

      <!-- Goals List -->
      <section aria-labelledby="goals-heading">
        <div class="goals-grid">
          @forelse($goals as $goal)
            <div class="goal-card">
              <h4>{{ ucfirst($goal->type) }} Goal</h4>
              <p><strong>Target:</strong> {{ $goal->target_value }}</p>
              <p><strong>Current:</strong> {{ $goal->current_value }}</p>
              <p><strong>End Date:</strong> {{ $goal->end_date }}</p>
              @if($goal->description)
                <p><em>{{ $goal->description }}</em></p>
              @endif
              <div class="progress-bar">
                <div class="progress" style="width: {{ min($goal->current_value / $goal->target_value * 100, 100) }}%;"></div>
              </div>
              <a href="{{ route('goals.log', $goal) }}" class="log-btn">Log Progress</a>
            </div>
          @empty
            <p class="no-data">No goals set yet. Start creating your goals!</p>
          @endforelse
        </div>
      </section>
    </main>
  </div>

  <style>
    :root {
      --bg: #f8f9fa;
      --text: #1a1a1a;
      --accent: #2563eb;
      --muted: #6b7280;
      --card-bg: #ffffff;
      --border: #e5e7eb;
      --radius: 8px;
      --shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      --transition: 0.2s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--text);
      line-height: 1.6;
    }

    #fitlife-container {
      display: flex;
      min-height: 100vh;
    }

    #sidebar {
      width: 240px;
      background: var(--card-bg);
      padding: 24px;
      border-right: 1px solid var(--border);
      position: fixed;
      height: 100vh;
      overflow-y: auto;
    }

    .sidebar-header {
      margin-bottom: 24px;
    }

    .sidebar-header h2 {
      font-size: 1.5rem;
      font-weight: 600;
    }

    .sidebar-header p {
      font-size: 0.9rem;
      color: var(--muted);
    }

    .nav-menu a,
    .nav-menu button {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 12px;
      color: var(--text);
      text-decoration: none;
      font-size: 0.95rem;
      border-radius: var(--radius);
      transition: var(--transition);
    }

    .nav-menu a svg,
    .nav-menu button svg {
      width: 20px;
      height: 20px;
      stroke: var(--muted);
    }

    .nav-menu a:hover,
    .nav-menu button:hover {
      background: var(--bg);
      color: var(--accent);
    }

    .nav-menu a:hover svg,
    .nav-menu button:hover svg {
      stroke: var(--accent);
    }

    .nav-menu a.active {
      background: var(--accent);
      color: #fff;
    }

    .nav-menu a.active svg {
      stroke: #fff;
    }

    .nav-menu button {
      background: none;
      border: none;
      cursor: pointer;
      width: 100%;
      text-align: left;
    }

    main {
      margin-left: 240px;
      padding: 24px;
      flex: 1;
    }

    #mobile-toggle {
      display: none;
      position: fixed;
      top: 16px;
      left: 16px;
      background: var(--accent);
      color: #fff;
      border: none;
      padding: 8px;
      border-radius: var(--radius);
      cursor: pointer;
    }

    #mobile-toggle svg {
      width: 20px;
      height: 20px;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
    }

    .header-left h1 {
      font-size: 1.75rem;
      font-weight: 600;
    }

    .header-left p.muted {
      font-size: 0.9rem;
      color: var(--muted);
    }

    .header-info {
      text-align: right;
      font-size: 0.9rem;
      color: var(--muted);
    }

    h3 {
      font-size: 1.25rem;
      font-weight: 600;
      margin-bottom: 16px;
    }

    .create-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: var(--accent);
      color: #fff;
      padding: 10px 16px;
      border-radius: var(--radius);
      text-decoration: none;
      font-size: 0.95rem;
      transition: var(--transition);
      margin-bottom: 16px;
    }

    .create-btn svg {
      width: 20px;
      height: 20px;
      stroke: #fff;
    }

    .create-btn:hover {
      background: #1d4ed8;
    }

    .goals-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 16px;
    }

    .goal-card {
      background: var(--card-bg);
      padding: 16px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
      transition: var(--transition);
    }

    .goal-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow);
    }

    .goal-card h4 {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 8px;
    }

    .goal-card p {
      font-size: 0.9rem;
      margin-bottom: 4px;
    }

    .goal-card p em {
      color: var(--muted);
    }

    .progress-bar {
      height: 8px;
      background: var(--border);
      border-radius: var(--radius);
      overflow: hidden;
      margin: 12px 0;
    }

    .progress {
      height: 100%;
      background: var(--accent);
      transition: var(--transition);
    }

    .log-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: var(--accent);
      color: #fff;
      padding: 10px 16px;
      border-radius: var(--radius);
      text-decoration: none;
      font-size: 0.95rem;
      transition: var(--transition);
    }

    .log-btn:hover {
      background: #1d4ed8;
    }

    .no-data {
      padding: 16px;
      text-align: center;
      color: var(--muted);
      font-size: 0.9rem;
    }

    @media (max-width: 768px) {
      #sidebar {
        position: fixed;
        transform: translateX(-100%);
        transition: var(--transition);
      }

      #sidebar.active {
        transform: translateX(0);
      }

      main {
        margin-left: 0;
      }

      #mobile-toggle {
        display: block;
      }

      header {
        flex-direction: column;
        align-items: flex-start;
      }

      .header-info {
        text-align: left;
        margin-top: 12px;
      }
    }

    @media (max-width: 480px) {
      .goals-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const mobileToggle = document.getElementById('mobile-toggle');
      const sidebar = document.getElementById('sidebar');

      mobileToggle.addEventListener('click', () => {
        const isOpen = sidebar.classList.toggle('active');
        mobileToggle.setAttribute('aria-expanded', isOpen);
      });

      document.addEventListener('click', e => {
        if (sidebar.classList.contains('active') && !sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
          sidebar.classList.remove('active');
          mobileToggle.setAttribute('aria-expanded', 'false');
        }
      });

      document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
          sidebar.classList.remove('active');
          mobileToggle.setAttribute('aria-expanded', 'false');
        }
      });
    });
  </script>
@endsection