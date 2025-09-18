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
    display: inline-block;
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

  /* ====== Goal Form ====== */
  .goal-form {
    margin-bottom: 24px;
  }
  .goal-card {
    background: linear-gradient(135deg, var(--panel), #1A1F26);
    padding: 16px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    transition: box-shadow 0.3s ease;
    text-align: center;
  }
  .goal-card:hover {
    box-shadow: var(--glow), var(--shadow);
  }
  .goal-card h4 {
    font-size: 0.9rem;
    color: var(--accent);
    font-weight: var(--font-weight-medium);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }
  .form-group {
    margin-bottom: 12px;
    text-align: left;
  }
  .form-group label {
    font-size: 0.9rem;
    color: var(--white);
    font-weight: var(--font-weight-medium);
    margin-bottom: 6px;
    display: block;
  }
  .form-group input,
  .form-group select,
  .form-group textarea {
    padding: 8px;
    border-radius: 8px;
    border: 1px solid rgba(0, 255, 136, 0.3);
    background: rgba(255, 255, 255, 0.05);
    color: var(--white);
    font-size: 0.9rem;
    width: 100%;
    transition: var(--transition);
  }
  .form-group input:focus,
  .form-group select:focus,
  .form-group textarea:focus {
    outline: none;
    border-color: var(--neon);
    box-shadow: 0 0 0 2px rgba(0, 255, 136, 0.3);
  }
  .form-group input::placeholder,
  .form-group textarea::placeholder {
    color: var(--muted);
  }
  .form-group textarea {
    resize: vertical;
  }

  /* ====== Responsive Design ====== */
  @media (max-width: 768px) {
    main {
      padding: 20px;
    }
    .goal-card {
      padding: 12px;
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
    .goal-card {
      min-width: 100%;
    }
  }

  /* ====== Animations ====== */
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  section, .goal-card {
    animation: fadeIn 0.5s var(--animation-ease);
  }
</style>

<div id="fitlife-container" role="application" aria-label="FitLife Create Goal">
  <!-- Sidebar -->
  <aside id="sidebar" aria-label="Main navigation">
    <div class="sidebar-header">
      <h2>FitLife</h2>
      <p>Power Your Performance</p>
    </div>
 <nav class="nav-menu" aria-label="Main menu">
      <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" {{ request()->routeIs('dashboard') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 13h8V3H3z"/><path d="M13 21h8V11h-8z"/><path d="M13 3v8"/></svg>
        <span>Home</span>
      </a>
      <a href="{{ route('foods.index') }}" class="{{ request()->routeIs('foods.*') ? 'active' : '' }}" {{ request()->routeIs('foods.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 21c4-4 6-11 6-17"/><path d="M20 7a4 4 0 11-8 0"/></svg>
        <span>Meal Tracker</span>
      </a>
      <a href="{{ route('sleep.index') }}" class="{{ request()->routeIs('sleep.*') ? 'active' : '' }}" {{ request()->routeIs('sleep.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
        <span>Sleep Tracker</span>
      </a>
      <a href="{{ route('water.index') }}" class="{{ request()->routeIs('water.*') ? 'active' : '' }}" {{ request()->routeIs('water.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2s4 5 4 8a4 4 0 01-8 0c0-3 4-8 4-8z"/></svg>
        <span>Water Tracker</span>
      </a>
      <a href="{{ route('progress.index') }}" class="{{ request()->routeIs('progress.*') ? 'active' : '' }}" {{ request()->routeIs('progress.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 3v18H3V3h18z"/><path d="M7 14l3-3 2 2 5-5"/></svg>
        <span>Progress Photos</span>
      </a>
      <a href="{{ route('goals.index') }}" class="{{ request()->routeIs('goals.*') ? 'active' : '' }}" {{ request()->routeIs('goals.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
        <span>Goals</span>
      </a>
      <a href="{{ route('calories.index') }}" class="{{ request()->routeIs('calories.*') ? 'active' : '' }}" {{ request()->routeIs('calories.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2v20"/><path d="M5 12h14"/></svg>
        <span>Calorie Calculator</span>
      </a>
      <a href="{{ route('biography.edit') }}" class="{{ request()->routeIs('biography.*') ? 'active' : '' }}" {{ request()->routeIs('biography.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4"/><path d="M6 20v-1a6 6 0 0112 0v1"/></svg>
        <span>Biography</span>
      </a>
      <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}" {{ request()->routeIs('profile.edit') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/></svg>
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
        <h1><span>FitLife</span> Create Goal</h1>
        <p class="muted">Set a new goal to stay motivated!</p>
      </div>
      <div class="header-info">
        <div>{{ now()->format('l, F d, Y') }}</div>
        <div>{{ now()->format('H:i') }}</div>
      </div>
    </header>

    <!-- Goal Form -->
    <section aria-labelledby="goal-form-heading">
      <h3 id="goal-form-heading">Create New Goal</h3>
      <div class="goal-card">
        <form action="{{ route('goals.store') }}" method="POST" class="goal-form">
          @csrf
          <div class="form-group">
            <label for="type">Goal Type</label>
            <select id="type" name="type" required>
              <option value="">Select goal</option>
              <option value="steps">Steps</option>
              <option value="calories">Calories</option>
              <option value="sleep">Sleep (hours)</option>
              <option value="weight">Weight (kg)</option>
            </select>
          </div>
          <div class="form-group">
            <label for="target_value">Target Value</label>
            <input type="number" id="target_value" name="target_value" step="0.01" placeholder="Enter target value" required>
          </div>
          <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" required>
          </div>
          <div class="form-group">
            <label for="description">Description (optional)</label>
            <textarea id="description" name="description" rows="3" placeholder="Add a description">{{ old('description') }}</textarea>
          </div>
          <button type="submit" class="calculate-btn">Create Goal</button>
        </form>
      </div>
    </section>
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