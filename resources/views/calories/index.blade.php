@extends('layouts.app')

@section('content')
<style>
  /* ====== Reset ====== */
  *, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  html, body, #app {
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
    gap: 12px;
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
    width: 20px;
    height: 20px;
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
  button, .logout-form button, .calculate-btn {
    padding: 8px 12px;
    background: linear-gradient(90deg, var(--neon), var(--accent));
    color: var(--white);
    border: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: var(--font-weight-bold);
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
    box-shadow: var(--glow);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-align: center;
  }
  button:hover, .logout-form button:hover, .calculate-btn:hover {
    box-shadow: 0 0 20px rgba(0, 255, 136, 0.6);
    background: linear-gradient(90deg, var(--accent), var(--neon));
  }
  button::before, .logout-form button::before, .calculate-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.4s ease;
  }
  button:hover::before, .logout-form button:hover::before, .calculate-btn:hover::before {
    left: 100%;
  }
  .calculate-btn {
    padding: 6px 10px;
    font-size: 0.8rem;
    white-space: nowrap;
    line-height: 1.2;
  }
  .calculate-btn svg {
    width: 16px;
    height: 16px;
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
  .header-left p {
    font-size: 0.9rem;
    color: var(--muted);
    margin: 4px 0 0;
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

  /* ====== Calculator Form ====== */
  .biography-card {
    background: linear-gradient(135deg, var(--panel), #1A1F26);
    padding: 24px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    transition: box-shadow 0.3s ease;
    margin-bottom: 24px;
  }
  .biography-card:hover {
    box-shadow: var(--glow), var(--shadow);
  }
  .biography-card h3 {
    font-size: 1.4rem;
    color: var(--neon);
    font-weight: var(--font-weight-bold);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .form-logging {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }
  .form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }
  .form-group label {
    font-size: 0.95rem;
    color: var(--white);
    font-weight: var(--font-weight-medium);
  }
  .form-group input,
  .form-group select {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid var(--glass);
    background: rgba(255, 255, 255, 0.05);
    color: var(--white);
    font-size: 0.9rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }
  .form-group input:focus,
  .form-group select:focus {
    outline: none;
    border-color: var(--neon);
    box-shadow: 0 0 0 2px rgba(0, 255, 136, 0.3);
  }
  .form-group input::placeholder {
    color: var(--muted);
  }

  /* ====== KPI Container ====== */
  .kpi-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 24px;
  }
  .kpi-card {
    background: linear-gradient(135deg, var(--panel), #1A1F26);
    padding: 16px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    transition: box-shadow 0.3s ease;
    text-align: center;
  }
  .kpi-card:hover {
    box-shadow: var(--glow), var(--shadow);
  }
  .kpi-card h3 {
    font-size: 0.9rem;
    color: var(--accent);
    font-weight: var(--font-weight-medium);
    margin-bottom: 8px;
    text-transform: uppercase;
  }
  .kpi-card p {
    font-size: 1.5rem;
    font-weight: var(--font-weight-bold);
    color: var(--neon);
  }
  .kpi-card p.status-text {
    font-size: 0.95rem;
    color: var(--neon);
    font-weight: var(--font-weight-medium);
  }

  /* ====== Responsive Design ====== */
  @media (max-width: 768px) {
    main {
      padding: 20px;
    }
    .kpi-container {
      grid-template-columns: 1fr;
      gap: 1rem;
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
    .biography-card, .kpi-card {
      padding: 16px;
    }
  }

  /* ====== Animations ====== */
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  section, .biography-card, .kpi-container, .kpi-card {
    animation: fadeIn 0.5s var(--animation-ease);
  }

  /* ====== Accessibility ====== */
  @media (prefers-reduced-motion: reduce) {
    .biography-card, .kpi-card, button, aside#sidebar {
      transition: none;
    }
  }
  @media (prefers-contrast: high) {
    .biography-card, .kpi-card {
      border: 2px solid var(--white);
    }
    .form-group input, .form-group select {
      border: 1px solid var(--white);
    }
    nav.nav-menu a.active, .calculate-btn {
      background: var(--white);
      color: var(--bg);
    }
  }
</style>

<div id="fitlife-container" role="application" aria-label="FitLife Calorie Calculator">
  <!-- Sidebar -->
  <aside id="sidebar" aria-label="Main navigation">
    <div class="sidebar-header">
      <h2>FitLife</h2>
      <p>Power Your Performance</p>
    </div>
    <nav class="nav-menu" aria-label="Main menu">
      <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" {{ request()->routeIs('dashboard') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 13h8V3H3z"/><path d="M13 21h8V11h-8z"/><path d="M13 3v8"/></svg>
        <span>Dashboard</span>
      </a>
      <a href="{{ route('foods.index') }}" class="{{ request()->routeIs('foods.*') ? 'active' : '' }}" {{ request()->routeIs('foods.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 21c4-4 6-11 6-17"/><path d="M20 7a4 4 0 11-8 0"/></svg>
        <span>Nutrition</span>
      </a>
      <a href="{{ route('sleep.index') }}" class="{{ request()->routeIs('sleep.*') ? 'active' : '' }}" {{ request()->routeIs('sleep.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
        <span>Recovery</span>
      </a>
      <a href="{{ route('water.index') }}" class="{{ request()->routeIs('water.*') ? 'active' : '' }}" {{ request()->routeIs('water.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2s4 5 4 8a4 4 0 01-8 0c0-3 4-8 4-8z"/></svg>
        <span>Hydration</span>
      </a>
      <a href="{{ route('progress.index') }}" class="{{ request()->routeIs('progress.*') ? 'active' : '' }}" {{ request()->routeIs('progress.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 3v18H3V3h18z"/><path d="M7 14l3-3 2 2 5-5"/></svg>
        <span>Progress</span>
      </a>
      <a href="{{ route('goals.index') }}" class="{{ request()->routeIs('goals.*') ? 'active' : '' }}" {{ request()->routeIs('goals.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
        <span>Goals</span>
      </a>
      <a href="{{ route('calories.index') }}" class="{{ request()->routeIs('calories.*') ? 'active' : '' }}" {{ request()->routeIs('calories.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2v20"/><path d="M5 12h14"/></svg>
        <span>Energy</span>
      </a>
      <a href="{{ route('biography.edit') }}" class="{{ request()->routeIs('biography.*') ? 'active' : '' }}" {{ request()->routeIs('biography.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4"/><path d="M6 20v-1a6 6 0 0112 0v1"/></svg>
        <span>Bio</span>
      </a>
      <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}" {{ request()->routeIs('profile.edit') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/></svg>
        <span>Profile</span>
      </a>
      <form method="POST" action="{{ route('logout') }}" class="logout-form">
        @csrf
        <button type="submit" aria-label="Logout">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
          Logout
        </button>
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
            <input type="number" name="weight" placeholder="Weight (kg)" value="{{ old('weight', $user->weight) }}" required>
          </div>
          <div class="form-group">
            <label>Height (cm)</label>
            <input type="number" name="height" placeholder="Height (cm)" value="{{ old('height', $user->height) }}" required>
          </div>
          <div class="form-group">
            <label>Age</label>
            <input type="number" name="age" placeholder="Age" value="{{ old('age', $user->age) }}" required>
          </div>
          <div class="form-group">
            <label>Activity Level</label>
            <select name="activity_level" required>
              <option value="">Select Activity Level</option>
              <option value="sedentary" {{ old('activity_level', $user->activity_level)=='sedentary'?'selected':'' }}>Sedentary</option>
              <option value="light" {{ old('activity_level', $user->activity_level)=='light'?'selected':'' }}>Light</option>
              <option value="moderate" {{ old('activity_level', $user->activity_level)=='moderate'?'selected':'' }}>Moderate</option>
              <option value="active" {{ old('activity_level', $user->activity_level)=='active'?'selected':'' }}>Active</option>
            </select>
          </div>
          <div class="form-group">
            <label>Goal</label>
            <select name="goal_type" required>
              <option value="">Select Goal</option>
              <option value="lose_weight" {{ old('goal_type', $user->goal_type)=='lose_weight'?'selected':'' }}>Lose Weight</option>
              <option value="maintain" {{ old('goal_type', $user->goal_type)=='maintain'?'selected':'' }}>Maintain</option>
              <option value="gain_weight" {{ old('goal_type', $user->goal_type)=='gain_weight'?'selected':'' }}>Gain Weight</option>
            </select>
          </div>
          <button type="submit" class="calculate-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path d="M4 2h16a2 2 0 012 2v16a2 2 0 01-2 2H4a2 2 0 01-2-2V4a2 2 0 012-2z"/>
              <path d="M8 6h8"/><path d="M6 8v8"/><path d="M8 16h8"/><path d="M16 8v8"/>
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
document.addEventListener("DOMContentLoaded", function() {
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