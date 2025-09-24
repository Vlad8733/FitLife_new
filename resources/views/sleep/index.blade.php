@extends('layouts.app')

@section('content')
  <div id="fitlife-container" role="application" aria-label="FitLife Sleep Tracker">
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
          <h1><span>FitLife</span> Sleep Tracker</h1>
          <p class="muted">Log and track your sleep patterns</p>
        </div>
        <div class="header-info">
          <div>{{ now()->format('l, F d, Y') }}</div>
          <div>{{ now()->format('H:i') }}</div>
        </div>
      </header>

      <!-- Success Message -->
      @if(session('success'))
        <section aria-labelledby="success-heading">
          <h3 id="success-heading">Status</h3>
          <div class="result-card">
            <div class="result-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
              </svg>
            </div>
            <div class="result-body">
              <h4>Success</h4>
              <div class="value">{{ session('success') }}</div>
            </div>
          </div>
        </section>
      @endif

      <!-- Sleep Form -->
      <section aria-labelledby="sleep-form-heading">
        <h3 id="sleep-form-heading">Log Your Sleep</h3>
        <div class="sleep-card">
          <h4>Add Sleep Record</h4>
          <form action="{{ route('sleep.store') }}" method="POST" class="sleep-form">
            @csrf
            <div class="form-group">
              <label for="date">Date</label>
              <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
              <label for="start_time">Start Time</label>
              <input type="time" id="start_time" name="start_time" required>
            </div>
            <div class="form-group">
              <label for="end_time">End Time</label>
              <input type="time" id="end_time" name="end_time" required>
            </div>
            <button type="submit" class="calculate-btn">Add Sleep Record</button>
          </form>
        </div>
      </section>

      <!-- Sleep History -->
      <section id="history-section" aria-labelledby="history-heading">
        <h3 id="history-heading">Sleep History</h3>
        <table class="history-table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Start</th>
              <th>End</th>
              <th>Duration (hrs)</th>
            </tr>
          </thead>
          <tbody>
            @forelse($sleeps as $sleep)
              <tr>
                <td>{{ $sleep->date }}</td>
                <td>{{ $sleep->start_time }}</td>
                <td>{{ $sleep->end_time }}</td>
                <td>{{ round($sleep->duration, 1) }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="no-data">No sleep records yet. Start logging your sleep!</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </section>

      <!-- Average Sleep -->
      @if($average)
        <section aria-labelledby="average-heading">
          <h3 id="average-heading">Sleep Summary</h3>
          <div class="result-card">
            <div class="result-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
              </svg>
            </div>
            <div class="result-body">
              <h4>Average Sleep</h4>
              <div class="value count-up" data-target="{{ round($average, 1) }}">0</div>
              <div class="muted">hours per night</div>
            </div>
          </div>
        </section>
      @endif
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

    .result-card {
      background: var(--card-bg);
      padding: 16px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 16px;
    }

    .result-icon svg {
      width: 24px;
      height: 24px;
      stroke: var(--accent);
    }

    .result-body h4 {
      font-size: 1rem;
      font-weight: 500;
      margin-bottom: 8px;
    }

    .result-body .value {
      font-size: 1.5rem;
      font-weight: 600;
    }

    .result-body .muted {
      font-size: 0.85rem;
      color: var(--muted);
    }

    .sleep-card {
      background: var(--card-bg);
      padding: 16px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
      margin-bottom: 16px;
    }

    .sleep-card h4 {
      font-size: 1rem;
      font-weight: 500;
      margin-bottom: 12px;
    }

    .sleep-form {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
      align-items: flex-end;
    }

    .form-group {
      flex: 1;
      min-width: 200px;
    }

    .form-group label {
      display: block;
      font-size: 0.9rem;
      margin-bottom: 4px;
      color: var(--muted);
    }

    .form-group input {
      width: 100%;
      padding: 8px;
      border: 1px solid var(--border);
      border-radius: var(--radius);
      font-size: 0.95rem;
      transition: var(--transition);
    }

    .form-group input:focus {
      outline: none;
      border-color: var(--accent);
      box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
    }

    .calculate-btn {
      background: var(--accent);
      color: #fff;
      border: none;
      padding: 10px 16px;
      border-radius: var(--radius);
      font-size: 0.95rem;
      cursor: pointer;
      transition: var(--transition);
    }

    .calculate-btn:hover {
      background: #1d4ed8;
    }

    .history-table {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
      width: 100%;
    }

    .history-table table {
      width: 100%;
      border-collapse: collapse;
    }

    .history-table th,
    .history-table td {
      padding: 12px;
      text-align: left;
      font-size: 0.9rem;
      border-bottom: 1px solid var(--border);
    }

    .history-table th {
      background: var(--bg);
      font-weight: 600;
      color: var(--text);
    }

    .history-table .no-data {
      padding: 16px;
      text-align: center;
      color: var(--muted);
      font-size: 0.9rem;
    }

    .history-table tbody tr:hover {
      background: var(--bg);
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
      .sleep-form {
        flex-direction: column;
        align-items: stretch;
      }

      .form-group {
        min-width: 100%;
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
        if (e.key === 'Escape' && sidebar.classList.contains('active')) {
          sidebar.classList.remove('active');
          mobileToggle.setAttribute('aria-expanded', 'false');
        }
      });

      const countUps = document.querySelectorAll('.count-up');
      countUps.forEach(val => {
        const target = parseFloat(val.dataset.target || 0);
        let current = 0;
        const step = target / 50;
        const update = () => {
          current += step;
          if (current >= target) {
            current = target;
            val.textContent = Number.isInteger(target) ? target : target.toFixed(1);
            return;
          }
          val.textContent = Number.isInteger(target) ? Math.round(current) : current.toFixed(1);
          requestAnimationFrame(update);
        };
        requestAnimationFrame(update);
      });
    });
  </script>
@endsection