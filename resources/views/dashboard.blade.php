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
    --bg: #0A0C10; /* Deep charcoal */
    --panel: #14171C; /* Sidebar/card background */
    --muted: #8A94A6; /* Muted text */
    --neon: #00FF88; /* Neon green */
    --accent: #FF3D00; /* Vibrant orange */
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
    width: 100vw;
    background: var(--bg);
    overflow: hidden;
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
  button, .logout-form button, .informer-action a {
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
  button:hover, .logout-form button:hover, .informer-action a:hover {
    box-shadow: 0 0 20px rgba(0, 255, 136, 0.6);
    background: linear-gradient(90deg, var(--accent), var(--neon));
  }
  button::before, .logout-form button::before, .informer-action a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.4s ease;
  }
  button:hover::before, .logout-form button:hover::before, .informer-action a:hover::before {
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

  /* ====== KPI and Informer Cards ====== */
  .stat-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
  }
  .stat-card, .informer-card {
    background: linear-gradient(135deg, var(--panel), #1A1F26);
    padding: 16px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 12px;
    transition: box-shadow 0.3s ease;
  }
  .stat-card:hover, .informer-card:hover {
    box-shadow: var(--glow), var(--shadow);
  }
  .stat-icon, .informer-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: linear-gradient(135deg, rgba(0, 255, 136, 0.15), rgba(255, 61, 0, 0.1));
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .stat-icon svg, .informer-icon svg {
    width: 24px;
    height: 24px;
    stroke: var(--neon);
    transition: transform 0.3s ease;
  }
  .stat-card:hover .stat-icon svg, .informer-card:hover .informer-icon svg {
    transform: rotate(10deg);
  }
  .stat-body, .informer-body {
    flex: 1;
  }
  .stat-body h4, .informer-body h4 {
    font-size: 0.9rem;
    color: var(--accent);
    font-weight: var(--font-weight-medium);
    margin: 0;
  }
  .stat-body .value, .informer-body .value {
    font-size: 1.4rem;
    font-weight: var(--font-weight-bold);
    color: var(--neon);
    margin-top: 4px;
  }
  .stat-body .muted, .informer-body .muted {
    font-size: 0.8rem;
    color: var(--muted);
  }
  .informer-bar {
    background: rgba(255, 255, 255, 0.05);
    height: 6px;
    border-radius: 4px;
    overflow: hidden;
    margin-top: 8px;
    position: relative;
  }
  .informer-bar .fill {
    height: 100%;
    background: linear-gradient(90deg, var(--neon), var(--accent));
    transition: width 1.2s ease;
    position: relative;
    animation: pulse 2s infinite;
  }
  .informer-action {
    margin-top: 8px;
  }

  /* ====== Sections ====== */
  section {
    margin-bottom: 32px;
  }
  section h3 {
    font-size: 1.3rem;
    font-weight: var(--font-weight-bold);
    color: var(--neon);
    margin-bottom: 12px;
    position: relative;
  }
  section h3::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 40px;
    height: 2px;
    background: var(--accent);
    transition: width 0.3s ease;
  }
  section:hover h3::after {
    width: 60px;
  }

  /* ====== Gallery Grid ====== */
  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 16px;
  }
  .photo-item {
    border-radius: var(--radius);
    overflow: hidden;
    position: relative;
    cursor: pointer;
    background: var(--glass);
    box-shadow: var(--shadow);
    transition: box-shadow 0.3s ease;
  }
  .photo-item:hover {
    box-shadow: var(--glow), var(--shadow);
  }
  .photo-item img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
  }
  .photo-item:hover img {
    transform: scale(1.08);
  }
  .photo-meta {
    padding: 10px;
    background: rgba(0, 0, 0, 0.3);
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  .photo-item:hover .photo-meta {
    opacity: 1;
  }
  .photo-meta p {
    font-size: 0.85rem;
    color: var(--white);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .photo-meta small {
    font-size: 0.75rem;
    color: var(--muted);
  }

  /* ====== Lightbox ====== */
  #photo-lightbox {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 1500;
    background: linear-gradient(rgba(10, 12, 16, 0.9), rgba(10, 12, 16, 0.95));
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    align-items: center;
    justify-content: center;
    padding: 24px;
  }
  #photo-lightbox[aria-hidden="false"] {
    display: flex;
  }
  .lightbox-inner {
    max-width: 1200px;
    width: 100%;
    display: flex;
    gap: 24px;
    align-items: center;
    background: var(--panel);
    border-radius: var(--radius);
    padding: 16px;
    box-shadow: var(--shadow);
  }
  .lightbox-img {
    flex: 1;
    border-radius: 10px;
    overflow: hidden;
  }
  .lightbox-img img {
    width: 100%;
    height: auto;
    max-height: 80vh;
    object-fit: contain;
    display: block;
    border-radius: 10px;
  }
  .lightbox-side {
    width: 340px;
    max-width: 340px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    color: var(--muted);
  }
  .lightbox-close, .lightbox-nav button {
    padding: 10px 16px;
    background: linear-gradient(90deg, var(--neon), var(--accent));
    color: var(--white);
    border: none;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: var(--font-weight-bold);
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
    box-shadow: var(--glow);
  }
  .lightbox-close:hover, .lightbox-nav button:hover {
    box-shadow: 0 0 20px rgba(0, 255, 136, 0.6);
    background: linear-gradient(90deg, var(--accent), var(--neon));
  }
  .lightbox-close::before, .lightbox-nav button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.4s ease;
  }
  .lightbox-close:hover::before, .lightbox-nav button:hover::before {
    left: 100%;
  }
  .lightbox-nav {
    display: flex;
    gap: 10px;
  }

  /* ====== Goals ====== */
  .goal-item {
    background: var(--glass);
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 12px;
    transition: box-shadow 0.3s ease;
  }
  .goal-item:hover {
    box-shadow: var(--glow), var(--shadow);
  }
  .goal-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
  }
  .goal-meta strong {
    font-size: 1rem;
    color: var(--neon);
    font-weight: var(--font-weight-bold);
  }
  .goal-bar {
    background: rgba(255, 255, 255, 0.05);
    height: 12px;
    border-radius: 8px;
    overflow: hidden;
    margin-top: 10px;
    position: relative;
  }
  .goal-bar .fill {
    height: 100%;
    background: linear-gradient(90deg, var(--neon), var(--accent));
    transition: width 1.2s ease;
    position: relative;
    animation: pulse 2s infinite;
  }
  @keyframes pulse {
    0% { box-shadow: 0 0 5px rgba(0, 255, 136, 0.3); }
    50% { box-shadow: 0 0 15px rgba(0, 255, 136, 0.5); }
    100% { box-shadow: 0 0 5px rgba(0, 255, 136, 0.3); }
  }

  /* ====== Helpers ====== */
  .muted { color: var(--muted); font-size: 0.9rem; }
  .small { font-size: 0.8rem; color: var(--muted); }
  a.small { color: var(--neon); text-decoration: none; }
  a.small:hover { text-decoration: underline; }

  /* ====== Responsive Design ====== */
  @media (max-width: 1200px) {
    .stat-cards { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); }
    .lightbox-inner { flex-direction: column; }
    .lightbox-side { width: 100%; max-width: 100%; text-align: center; }
  }
  @media (max-width: 768px) {
    main { padding: 20px; }
    .gallery-grid { grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); }
    .photo-item img { height: 140px; }
    .stat-card, .informer-card { flex-direction: column; text-align: center; }
    .header-info { flex-direction: column; gap: 8px; }
  }
  @media (max-width: 480px) {
    header { flex-direction: column; text-align: center; }
    .header-left h1 { font-size: 1.5rem; }
    .stat-card, .informer-card { min-width: 100%; }
    .photo-item img { height: 120px; }
  }

  /* ====== Animations ====== */
  @keyframes slideInDown {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
  }
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  section, .stat-card, .informer-card, .photo-item {
    animation: fadeIn 0.5s var(--animation-ease);
  }
</style>

<div id="fitlife-container" role="application" aria-label="FitLife Dashboard">
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
      <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.*') ? 'active' : '' }}" {{ request()->routeIs('posts.*') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
          <path d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2"/>
          <path d="M17 8l4 4-4 4"/>
        </svg>
        <span>Community Posts</span>
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
        <h1>Hello, {{ Auth::user()->name }}!</h1>
        <p class="muted">Your FitLife dashboard</p>
      </div>
      <div class="header-info">
        <div>{{ now()->format('l, F d, Y') }}</div>
        <div>{{ now()->format('H:i') }}</div>
      </div>
    </header>

    <!-- Personal Stats -->
    <section aria-labelledby="stats-heading">
      <h3 id="stats-heading">Your Stats</h3>
      @php $bio = Auth::user()->biography; @endphp
      <div class="log-card" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <div>
          <div class="small"><strong>Name:</strong> {{ $bio->full_name ?? Auth::user()->name }}</div>
          <div class="small"><strong>Age:</strong> {{ $bio->age ?? 'Not set' }}</div>
          <div class="small"><strong>Height:</strong> {{ $bio->height ?? 'Not set' }} cm</div>
          <div class="small"><strong>Weight:</strong> {{ $bio->weight ?? 'Not set' }} kg</div>
          <div class="small"><strong>Gender:</strong> {{ ucfirst($bio->gender ?? 'Not set') }}</div>
        </div>
      </div>
    </section>

    <!-- KPI Cards -->
    <section aria-labelledby="metrics-heading">
      <h3 id="metrics-heading">Performance Metrics</h3>
      <div class="stat-cards">
        <div class="stat-card" aria-hidden="false">
          <div class="stat-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 12h18"/></svg>
          </div>
          <div class="stat-body">
            <h4>Energy</h4>
            <div class="value count-up" data-target="{{ $totalCalories ?? 0 }}">0</div>
            <div class="small muted">kcal today</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 3v6l4 2"/></svg>
          </div>
          <div class="stat-body">
            <h4>Recovery</h4>
            <div class="value count-up" data-target="{{ round($totalSleep ?? 0, 1) }}">0</div>
            <div class="small muted">hours</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2s4 5 4 8a4 4 0 01-8 0c0-3 4-8 4-8z"/></svg>
          </div>
          <div class="stat-body">
            <h4>Hydration</h4>
            <div class="value count-up" data-target="{{ $totalWater ?? 0 }}">0</div>
            <div class="small muted">ml</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Trackers -->
    <section aria-labelledby="trackers-heading">
      <h3 id="trackers-heading">Trackers</h3>
      <div class="stat-cards">
        <!-- Nutrition Informer -->
        <div class="informer-card" id="nutrition-informer">
          @if($mealLogs->isEmpty())
            <div class="informer-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 21c4-4 6-11 6-17"/><path d="M20 7a4 4 0 11-8 0"/></svg>
            </div>
            <div class="informer-body">
              <h4>Nutrition</h4>
              <div class="value">0 kcal</div>
              <div class="small muted">No meals logged</div>
              <div class="informer-action">
                <a href="{{ route('foods.index') }}">Log Meal</a>
              </div>
            </div>
          @else
            @php
              $dailyCalories = $mealLogs->sum('calories');
              $calorieGoal = 2000; // Adjust based on user settings if available
              $calorieProgress = min(100, ($dailyCalories / $calorieGoal) * 100);
            @endphp
            <div class="informer-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 21c4-4 6-11 6-17"/><path d="M20 7a4 4 0 11-8 0"/></svg>
            </div>
            <div class="informer-body">
              <h4>Nutrition</h4>
              <div class="value">{{ $dailyCalories }} kcal</div>
              <div class="small muted">Fueling strong!</div>
              <div class="informer-bar" data-progress="{{ $calorieProgress }}">
                <div class="fill" style="width:0%;" aria-valuenow="{{ $calorieProgress }}" aria-valuemax="100" aria-valuemin="0" role="progressbar"></div>
              </div>
            </div>
          @endif
        </div>
        <!-- Recovery Informer -->
        <div class="informer-card" id="recovery-informer">
          @if($sleepLogs->isEmpty())
            <div class="informer-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
            </div>
            <div class="informer-body">
              <h4>Recovery</h4>
              <div class="value">0 hrs</div>
              <div class="small muted">No sleep logged</div>
              <div class="informer-action">
                <a href="{{ route('sleep.index') }}">Log Sleep</a>
              </div>
            </div>
          @else
            @php
              $dailySleep = $sleepLogs->sum('duration');
              $sleepGoal = 8; // Adjust based on user settings if available
              $sleepProgress = min(100, ($dailySleep / $sleepGoal) * 100);
            @endphp
            <div class="informer-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
            </div>
            <div class="informer-body">
              <h4>Recovery</h4>
              <div class="value">{{ round($dailySleep, 1) }} hrs</div>
              <div class="small muted">Great rest!</div>
              <div class="informer-bar" data-progress="{{ $sleepProgress }}">
                <div class="fill" style="width:0%;" aria-valuenow="{{ $sleepProgress }}" aria-valuemax="100" aria-valuemin="0" role="progressbar"></div>
              </div>
            </div>
          @endif
        </div>
        <!-- Hydration Informer -->
        <div class="informer-card" id="hydration-informer">
          @if($waterLogs->isEmpty())
            <div class="informer-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2s4 5 4 8a4 4 0 01-8 0c0-3 4-8 4-8z"/></svg>
            </div>
            <div class="informer-body">
              <h4>Hydration</h4>
              <div class="value">0 ml</div>
              <div class="small muted">No water logged</div>
              <div class="informer-action">
                <a href="{{ route('water.index') }}">Log Water</a>
              </div>
            </div>
          @else
            @php
              $dailyWater = $waterLogs->sum('amount');
              $waterGoal = 2000; // Adjust based on user settings if available
              $waterProgress = min(100, ($dailyWater / $waterGoal) * 100);
            @endphp
            <div class="informer-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2s4 5 4 8a4 4 0 01-8 0c0-3 4-8 4-8z"/></svg>
            </div>
            <div class="informer-body">
              <h4>Hydration</h4>
              <div class="value">{{ $dailyWater }} ml</div>
              <div class="small muted">Keep sipping!</div>
              <div class="informer-bar" data-progress="{{ $waterProgress }}">
                <div class="fill" style="width:0%;" aria-valuenow="{{ $waterProgress }}" aria-valuemax="100" aria-valuemin="0" role="progressbar"></div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </section>

    <!-- Gallery -->
    <section>
      <h3>Progress Gallery</h3>
      <div class="gallery-grid" id="gallery-grid">
        @forelse($photos as $idx => $photo)
          <article class="photo-item" role="button" tabindex="0"
            data-idx="{{ $idx }}"
            data-img="{{ asset('storage/'.$photo->photo) }}"
            data-desc="{{ $photo->description ?? '' }}"
            data-date="{{ $photo->created_at->format('M d, Y H:i') }}">
            <img src="{{ asset('storage/'.$photo->photo) }}" alt="Progress photo" loading="lazy">
            <div class="photo-meta">
              <p>{{ $photo->description ?? 'No description' }}</p>
              <small>{{ $photo->created_at->format('M d, Y') }}</small>
            </div>
          </article>
        @empty
          <div class="log-card small">No photos yet. <a href="{{ route('progress.index') }}">Add one!</a></div>
        @endforelse
      </div>
    </section>

    <!-- Goals -->
    <section>
      <h3>Your Targets</h3>
      @if($goals->isEmpty())
        <div class="log-card small">No goals set. <a href="{{ route('goals.index') }}">Set one!</a></div>
      @else
        <div class="log-card">
          @foreach($goals as $goal)
            @php $percent = min(100, max(0, (int)$goal->progressPercent())); @endphp
            <div class="goal-item" aria-label="{{ $goal->type }} goal">
              <div class="goal-meta">
                <strong>{{ ucfirst($goal->type) }} Target</strong>
                <span class="small muted">Deadline: {{ $goal->deadline }}</span>
              </div>
              <div class="small muted" style="margin-top:8px">{{ round($goal->current_value, 1) }} / {{ $goal->target_value }}</div>
              <div class="goal-bar" data-progress="{{ $percent }}">
                <div class="fill" style="width:0%;" aria-valuenow="{{ $percent }}" aria-valuemax="100" aria-valuemin="0" role="progressbar"></div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </section>

    <!-- Lightbox -->
    <div id="photo-lightbox" role="dialog" aria-hidden="true" aria-label="Photo viewer">
      <div class="lightbox-inner" role="document">
        <div class="lightbox-img">
          <img id="lightbox-image" src="" alt="">
        </div>
        <aside class="lightbox-side">
          <button class="lightbox-close" aria-label="Close viewer">Close</button>
          <div id="lightbox-caption" class="small muted">—</div>
          <div id="lightbox-timestamp" class="small muted" style="margin-top:8px"></div>
          <div class="lightbox-nav">
            <button id="lightbox-prev" aria-label="Previous">Prev</button>
            <button id="lightbox-next" aria-label="Next">Next</button>
          </div>
        </aside>
      </div>
    </div>
  </main>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
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

    /* ===== Count Up Animation for KPI ===== */
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

    /* ===== Progress Bar Animation ===== */
    const bars = document.querySelectorAll('.goal-bar, .informer-bar');
    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
          if (!entry.isIntersecting) return;
          const el = entry.target;
          const percent = parseInt(el.getAttribute('data-progress') || '0', 10);
          const fill = el.querySelector('.fill');
          if (fill) {
            fill.style.width = percent + '%';
            fill.setAttribute('aria-valuenow', percent);
          }
          obs.unobserve(el);
        });
      }, { threshold: 0.4 });
      bars.forEach(b => observer.observe(b));
    } else {
      bars.forEach(b => {
        const percent = parseInt(b.getAttribute('data-progress') || '0', 10);
        const fill = b.querySelector('.fill');
        if (fill) fill.style.width = percent + '%';
      });
    }

    /* ===== Gallery / Lightbox ===== */
    const gallery = document.getElementById('gallery-grid');
    const items = Array.from(gallery ? gallery.querySelectorAll('.photo-item') : []);
    const lightbox = document.getElementById('photo-lightbox');
    const lbImage = document.getElementById('lightbox-image');
    const lbCaption = document.getElementById('lightbox-caption');
    const lbTimestamp = document.getElementById('lightbox-timestamp');
    const lbClose = document.querySelector('.lightbox-close');
    const lbPrev = document.getElementById('lightbox-prev');
    const lbNext = document.getElementById('lightbox-next');
    let currentIndex = -1;

    function openLightbox(idx) {
      if (idx < 0 || idx >= items.length) return;
      const it = items[idx];
      currentIndex = idx;
      const src = it.getAttribute('data-img');
      const desc = it.getAttribute('data-desc') || 'No description';
      const date = it.getAttribute('data-date') || '';
      lbImage.src = src;
      lbImage.alt = desc;
      lbCaption.textContent = desc;
      lbTimestamp.textContent = date;
      lightbox.setAttribute('aria-hidden', 'false');
      lbClose.focus();
      preloadImage(items[(idx + 1) % items.length]?.getAttribute('data-img'));
      preloadImage(items[(idx - 1 + items.length) % items.length]?.getAttribute('data-img'));
    }

    function closeLightbox() {
      lightbox.setAttribute('aria-hidden', 'true');
      lbImage.src = '';
      currentIndex = -1;
    }

    function preloadImage(url) {
      if (!url) return;
      const i = new Image();
      i.src = url;
    }

    if (items.length) {
      items.forEach((it, idx) => {
        it.addEventListener('click', () => openLightbox(idx));
        it.addEventListener('keydown', (e) => {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            openLightbox(idx);
          }
        });
      });
    }

    lbClose.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', (e) => {
      if (e.target === lightbox) closeLightbox();
    });

    lbPrev.addEventListener('click', () => {
      if (currentIndex <= 0) currentIndex = items.length - 1;
      else currentIndex--;
      openLightbox(currentIndex);
    });
    lbNext.addEventListener('click', () => {
      if (currentIndex >= items.length - 1) currentIndex = 0;
      else currentIndex++;
      openLightbox(currentIndex);
    });

    document.addEventListener('keydown', (e) => {
      if (lightbox.getAttribute('aria-hidden') === 'false') {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') lbPrev.click();
        if (e.key === 'ArrowRight') lbNext.click();
      }
    });
  });
</script>
@endsection