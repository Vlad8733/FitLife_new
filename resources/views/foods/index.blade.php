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
  button, .logout-form button, .calculate-btn, .add-food-btn {
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
  button:hover, .logout-form button:hover, .calculate-btn:hover, .add-food-btn:hover {
    box-shadow: 0 0 20px rgba(0, 255, 136, 0.6);
    background: linear-gradient(90deg, var(--accent), var(--neon));
  }
  button::before, .logout-form button::before, .calculate-btn::before, .add-food-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.4s ease;
  }
  button:hover::before, .logout-form button:hover::before, .calculate-btn:hover::before, .add-food-btn:hover::before {
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

  /* ====== Result Widget ====== */
  .result-card {
    background: linear-gradient(135deg, var(--panel), #1A1F26);
    padding: 16px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 12px;
    transition: box-shadow 0.3s ease;
    margin-bottom: 24px;
  }
  .result-card:hover {
    box-shadow: var(--glow), var(--shadow);
  }
  .result-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: linear-gradient(135deg, rgba(0, 255, 136, 0.15), rgba(255, 61, 0, 0.1));
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .result-icon svg {
    width: 24px;
    height: 24px;
    stroke: var(--neon);
    transition: transform 0.3s ease;
  }
  .result-card:hover .result-icon svg {
    transform: rotate(10deg);
  }
  .result-body {
    flex: 1;
  }
  .result-body h4 {
    font-size: 0.9rem;
    color: var(--accent);
    font-weight: var(--font-weight-medium);
    margin: 0;
  }
  .result-body .value {
    font-size: 1.4rem;
    font-weight: var(--font-weight-bold);
    color: var(--neon);
    margin-top: 4px;
  }
  .result-body .muted {
    font-size: 0.8rem;
    color: var(--muted);
  }

  /* ====== Meal Form ====== */
  .meal-grid-form {
    margin-bottom: 24px;
  }
  .meals-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
  }
  .meal-block {
    display: flex;
    flex-direction: column;
    align-items: stretch;
  }
  .meal-card {
    background: linear-gradient(135deg, var(--panel), #1A1F26);
    padding: 16px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    transition: box-shadow 0.3s ease;
    text-align: center;
  }
  .meal-card:hover {
    box-shadow: var(--glow), var(--shadow);
  }
  .meal-card h4 {
    font-size: 0.9rem;
    color: var(--accent);
    font-weight: var(--font-weight-medium);
    margin-bottom: 8px;
  }
  .meal-items {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 12px;
  }
  .meal-item {
    background: var(--glass);
    padding: 8px;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    gap: 6px;
  }
  .food-select, .quantity-input {
    padding: 8px;
    border-radius: 8px;
    border: 1px solid rgba(0, 255, 136, 0.3);
    background: rgba(255, 255, 255, 0.05);
    color: var(--white);
    font-size: 0.9rem;
    transition: var(--transition);
  }
  .food-select:focus, .quantity-input:focus {
    outline: none;
    border-color: var(--neon);
    box-shadow: 0 0 0 2px rgba(0, 255, 136, 0.3);
  }
  .quantity-input::placeholder {
    color: var(--muted);
  }
  .calculate-container {
    margin-top: 12px;
    text-align: center;
  }

  /* ====== Meal History Table ====== */
  .history-table {
    width: 100%;
    border-collapse: collapse;
    background: linear-gradient(135deg, var(--panel), #1A1F26);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    margin-bottom: 24px;
    overflow: hidden;
  }
  .history-table th,
  .history-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid var(--glass);
    font-size: 0.9rem;
    color: var(--white);
  }
  .history-table th {
    background: rgba(0, 255, 136, 0.1);
    color: var(--neon);
    font-weight: var(--font-weight-bold);
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .history-table tr:hover {
    background: rgba(0, 255, 136, 0.08);
    box-shadow: var(--glow);
  }
  .history-table td {
    color: var(--muted);
  }
  .history-table td:first-child {
    color: var(--neon);
  }
  .history-table .no-data {
    text-align: center;
    padding: 24px;
    color: var(--muted);
    font-size: 1rem;
  }

  /* ====== Custom Pagination ====== */
  .pagination {
    display: flex;
    justify-content: center;
    gap: 2px;
    margin-top: 16px;
  }
  .pagination a {
    padding: 2px 4px;
    background: var(--glass);
    color: var(--white);
    border-radius: 2px;
    text-decoration: none;
    font-size: 0.6rem;
    transition: var(--transition);
  }
  .pagination a:hover {
    background: linear-gradient(90deg, var(--neon), var(--accent));
    box-shadow: var(--glow);
  }
  .pagination .disabled {
    color: var(--muted);
    pointer-events: none;
  }

  /* ====== Responsive Design ====== */
  @media (max-width: 1200px) {
    .meals-grid {
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
  }
  @media (max-width: 768px) {
    main {
      padding: 20px;
    }
    .meals-grid {
      grid-template-columns: 1fr;
      gap: 12px;
    }
    .meal-card, .result-card {
      padding: 12px;
    }
    .header-info {
      flex-direction: column;
      gap: 8px;
    }
    .history-table {
      font-size: 0.85rem;
    }
    .history-table th,
    .history-table td {
      padding: 8px;
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
    .meal-card, .result-card {
      min-width: 100%;
    }
    .history-table {
      display: block;
      overflow-x: auto;
    }
    .history-table th,
    .history-table td {
      min-width: 120px;
    }
    .pagination {
      flex-wrap: wrap;
    }
  }

  /* ====== Animations ====== */
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  section, .result-card, .meal-card, .history-table {
    animation: fadeIn 0.5s var(--animation-ease);
  }
</style>

<div id="fitlife-container" role="application" aria-label="FitLife Meal Tracker">
  <!-- Sidebar -->
  <aside id="sidebar" aria-label="Main navigation">
    <div class="sidebar-header">
      <h2>FitLife</h2>
      <p>Power Your Performance</p>
    </div>
    <nav class="nav-menu" aria-label="Main menu">
      <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" {{ request()->routeIs('dashboard') ? 'aria-current=page' : '' }}>
        <svg viewBox="0 0 24 24" fill="none"><path d="M3 13h8V3H3z"/><path d="M13 21h8V11h-8z"/><path d="M13 3v8"/></svg>
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
        <button type="submit" aria-label="Logout">Logout</button>
      </form>
    </nav>
  </aside>

  <!-- Main Content -->
  <main>
    <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">Menu</button>

    <header>
      <div class="header-left">
        <h1><span>FitLife</span> Meal Tracker</h1>
        <p class="muted">Log and analyze your daily nutrition</p>
      </div>
      <div class="header-info">
        <div>{{ now()->format('l, F d, Y') }}</div>
        <div>{{ now()->format('H:i') }}</div>
      </div>
    </header>

    <!-- Meal Form -->
    <section aria-labelledby="meal-form-heading">
      <h3 id="meal-form-heading">Log Your Meals</h3>
      <form action="{{ route('foods.calculate') }}" method="POST" class="meal-grid-form">
        @csrf
        @php $meals = ['Breakfast', 'Lunch', 'Dinner', 'Snack']; @endphp
        <div class="meals-grid">
          @foreach($meals as $meal)
          <div class="meal-block">
            <div class="meal-card" data-meal-block="{{ $meal }}">
              <h4>{{ $meal }}</h4>
              <div class="meal-items" data-meal="{{ $meal }}">
                <div class="meal-item">
                  <select class="food-select" name="meals[{{ $meal }}][0][food]">
                    <option value="">Select Food</option>
                    @foreach($foods as $food => $cal)
                    <option value="{{ $food }}">{{ $food }} ({{ $cal }} kcal)</option>
                    @endforeach
                  </select>
                  <input type="number" class="quantity-input" name="meals[{{ $meal }}][0][quantity]" placeholder="g/ml" style="display:none;">
                </div>
              </div>
              <button type="button" class="add-food-btn" data-meal="{{ $meal }}">Add Item</button>
            </div>
            @if($meal === 'Breakfast')
            <div class="calculate-container">
              <button type="submit" class="calculate-btn">Calculate Calories</button>
            </div>
            @endif
          </div>
          @endforeach
        </div>
      </form>
    </section>

    <!-- Meal History -->
    <section id="history-section" aria-labelledby="history-heading">
      <h3 id="history-heading">Meal History</h3>
      <table class="history-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Meal</th>
            <th>Food</th>
            <th>Quantity</th>
            <th>Calories</th>
          </tr>
        </thead>
        <tbody>
          @if($logs->isEmpty())
          <tr>
            <td colspan="5" class="no-data">No meal history yet. Start logging your meals!</td>
          </tr>
          @else
          @foreach($logs as $log)
          <tr>
            <td>{{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y H:i') }}</td>
            <td>{{ $log->meal }}</td>
            <td>{{ $log->food }}</td>
            <td>{{ $log->quantity }} g/ml</td>
            <td>{{ $log->calories }} kcal</td>
          </tr>
          @endforeach
          @endif
        </tbody>
      </table>
      @if(!$logs->isEmpty())
      <div class="pagination" data-current-page="{{ $logs->currentPage() }}" data-last-page="{{ $logs->lastPage() }}">
        <a href="{{ route('foods.index', ['page' => max(1, $logs->currentPage() - 1)]) }}" class="{{ $logs->onFirstPage() ? 'disabled' : '' }}">Previous</a>
        <span>|</span>
        <a href="{{ route('foods.index', ['page' => min($logs->lastPage(), $logs->currentPage() + 1)]) }}" class="{{ $logs->onLastPage() ? 'disabled' : '' }}">Next</a>
      </div>
      @endif
    </section>

    <!-- Result Widget -->
    @if(session('result'))
    <section aria-labelledby="result-heading">
      <h3 id="result-heading">Your Meal Summary</h3>
      <div class="result-card">
        <div class="result-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 21c4-4 6-11 6-17"/><path d="M20 7a4 4 0 11-8 0"/></svg>
        </div>
        <div class="result-body">
          <h4>Total Calories</h4>
          <div class="value">{{ session('result')['calories'] }} kcal</div>
          <div class="muted">{{ session('result')['comment'] }}</div>
        </div>
      </div>
    </section>
    @endif
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

  /* ===== Food Selection ===== */
  document.querySelectorAll('.food-select').forEach(select => {
    select.addEventListener('change', e => {
      const input = e.target.nextElementSibling;
      input.style.display = e.target.value ? 'block' : 'none';
    });
  });

  /* ===== Add Food Item ===== */
  document.querySelectorAll('.add-food-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const meal = this.dataset.meal;
      const container = this.previousElementSibling;
      const count = container.querySelectorAll('.meal-item').length;
      const div = document.createElement('div');
      div.classList.add('meal-item');
      let selectHTML = `<select class="food-select" name="meals[${meal}][${count}][food]"><option value="">Select Food</option>`;
      @foreach($foods as $food => $cal)
      selectHTML += `<option value="{{ $food }}">{{ $food }} ({{ $cal }} kcal)</option>`;
      @endforeach
      selectHTML += `</select>`;
      div.innerHTML = selectHTML + `<input type="number" class="quantity-input" name="meals[${meal}][${count}][quantity]" placeholder="g/ml" style="display:none;">`;
      container.appendChild(div);
      div.querySelector('.food-select').addEventListener('change', e => {
        const input = e.target.nextElementSibling;
        input.style.display = e.target.value ? 'block' : 'none';
      });
    });
  });

  /* ===== AJAX Pagination ===== */
  document.querySelectorAll('.pagination a').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      if (this.classList.contains('disabled')) return;

      const url = this.getAttribute('href');
      const historySection = document.getElementById('history-section');
      const scrollPosition = window.scrollY;
      const pagination = historySection.querySelector('.pagination');
      const currentPage = parseInt(pagination.getAttribute('data-current-page'));
      const lastPage = parseInt(pagination.getAttribute('data-last-page'));

      fetch(url, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
        .then(response => response.text())
        .then(html => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');
          const newHistorySection = doc.getElementById('history-section');
          if (newHistorySection) {
            historySection.innerHTML = newHistorySection.innerHTML;
            window.scrollTo(0, scrollPosition);
            // Re-attach event listeners for new pagination links
            document.querySelectorAll('.pagination a').forEach(newLink => {
              newLink.addEventListener('click', arguments.callee);
            });
          }
        })
        .catch(error => console.error('Error loading page:', error));
    });
  });
});
</script>
@endsection