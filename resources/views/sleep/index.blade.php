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
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
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
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
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

      /* ===== Count Up Animation for Average Sleep ===== */
      const countUps = document.querySelectorAll('.count-up');
      countUps.forEach(el => {
        const target = parseFloat(el.getAttribute('data-target') || '0');
        let started = false;
        const run = () => {
          if (started) return;
          started = true;
          const duration = 1200;
          const start = performance.now();
          const initial = 0;
          function step(ts) {
            const progress = Math.min((ts - start) / duration, 1);
            const value = initial + (target - initial) * progress;
            el.textContent = Number.isInteger(target) ? Math.round(value) : (Math.round(value * 10) / 10);
            if (progress < 1) requestAnimationFrame(step);
          }
          requestAnimationFrame(step);
        };
        if ('IntersectionObserver' in window) {
          const io = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
              if (entry.isIntersecting) {
                run();
                obs.unobserve(entry.target);
              }
            });
          }, { threshold: 0.4 });
          io.observe(el);
        } else {
          run();
        }
      });
    });
  </script>
@endsection
