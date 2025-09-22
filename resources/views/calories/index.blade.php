@extends('layouts.app')

@section('content')
  <div id="fitlife-container" role="application" aria-label="FitLife Calorie Calculator">
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
          <h1><span>FitLife</span> Calorie & Macro Calculator</h1>
          <p class="muted">Calculate your daily calorie and macro needs!</p>
        </div>
        <div class="header-info">
          <div>{{ now()->format('l, F d, Y') }}</div>
          <div>{{ now()->format('H:i') }}</div>
        </div>
      </header>

      <!-- Calculator Form -->
      <section aria-labelledby="calculator-heading">
        <div class="biography-card">
          <h3 id="calculator-heading">
            Calorie Calculator
          </h3>
          <form action="{{ route('calories.calculate') }}" method="POST" class="form-logging">
            @csrf
            <div class="form-group">
              <label>Weight (kg)</label>
              <input type="number" name="weight" placeholder="Weight (kg)" value="{{ old('weight', $user->weight) }}"
                required>
            </div>
            <div class="form-group">
              <label>Height (cm)</label>
              <input type="number" name="height" placeholder="Height (cm)" value="{{ old('height', $user->height) }}"
                required>
            </div>
            <div class="form-group">
              <label>Age</label>
              <input type="number" name="age" placeholder="Age" value="{{ old('age', $user->age) }}" required>
            </div>
            <div class="form-group">
              <label>Activity Level</label>
              <select name="activity_level" required>
                <option value="">Select Activity Level</option>
                <option value="sedentary" {{ old('activity_level', $user->activity_level) == 'sedentary' ? 'selected' : '' }}>
                  Sedentary</option>
                <option value="light" {{ old('activity_level', $user->activity_level) == 'light' ? 'selected' : '' }}>Light
                </option>
                <option value="moderate" {{ old('activity_level', $user->activity_level) == 'moderate' ? 'selected' : '' }}>
                  Moderate</option>
                <option value="active" {{ old('activity_level', $user->activity_level) == 'active' ? 'selected' : '' }}>Active
                </option>
              </select>
            </div>
            <div class="form-group">
              <label>Goal</label>
              <select name="goal_type" required>
                <option value="">Select Goal</option>
                <option value="lose_weight" {{ old('goal_type', $user->goal_type) == 'lose_weight' ? 'selected' : '' }}>Lose
                  Weight</option>
                <option value="maintain" {{ old('goal_type', $user->goal_type) == 'maintain' ? 'selected' : '' }}>Maintain
                </option>
                <option value="gain_weight" {{ old('goal_type', $user->goal_type) == 'gain_weight' ? 'selected' : '' }}>Gain
                  Weight</option>
              </select>
            </div>
            <button type="submit" class="calculate-btn">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M4 2h16a2 2 0 012 2v16a2 2 0 01-2 2H4a2 2 0 01-2-2V4a2 2 0 012-2z" />
                <path d="M8 6h8" />
                <path d="M6 8v8" />
                <path d="M8 16h8" />
                <path d="M16 8v8" />
              </svg>
              Calculate
            </button>
          </form>
        </div>
      </section>

      <!-- Results -->
      @isset($calories)
        <section aria-labelledby="results-heading">
          <h3 id="results-heading">Your Results</h3>
          <div class="kpi-container">
            <div class="kpi-card">
              <h3>Recommended Daily Calories</h3>
              <p>{{ round($calories) }} kcal</p>
            </div>
            <div class="kpi-card">
              <h3>Protein</h3>
              <p>{{ $protein }}g</p>
            </div>
            <div class="kpi-card">
              <h3>Fats</h3>
              <p>{{ $fat }}g</p>
            </div>
            <div class="kpi-card">
              <h3>Carbs</h3>
              <p>{{ $carbs }}g</p>
            </div>
            <div class="kpi-card">
              <h3>Calories Consumed Today</h3>
              <p>{{ $todayCalories }} kcal</p>
            </div>
            <div class="kpi-card">
              <h3>Status</h3>
              <p class="status-text">
                @if($todayCalories < $calories)
                  You can still eat ~{{ round($calories - $todayCalories) }} kcal today.
                @elseif($todayCalories > $calories)
                  You have exceeded your recommended calories by ~{{ round($todayCalories - $calories) }} kcal.
                @else
                  Perfect! You met your target today.
                @endif
              </p>
            </div>
          </div>
        </section>
      @endisset
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