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
  button, .logout-form button, .calculate-btn, .update-btn, .delete-btn {
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
  button:hover, .logout-form button:hover, .calculate-btn:hover, .update-btn:hover, .delete-btn:hover {
    box-shadow: 0 0 20px rgba(0, 255, 136, 0.6);
    background: linear-gradient(90deg, var(--accent), var(--neon));
  }
  button::before, .logout-form button::before, .calculate-btn::before, .update-btn::before, .delete-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.4s ease;
  }
  button:hover::before, .logout-form button:hover::before, .calculate-btn:hover::before, .update-btn:hover::before, .delete-btn:hover::before {
    left: 100%;
  }
  .update-btn {
    background: linear-gradient(90deg, rgba(0, 255, 136, 0.7), rgba(72, 201, 176, 0.7));
  }
  .update-btn:hover {
    background: linear-gradient(90deg, rgba(72, 201, 176, 0.7), rgba(0, 255, 136, 0.7));
  }
  .delete-btn {
    background: linear-gradient(90deg, rgba(255, 107, 107, 0.7), rgba(230, 74, 31, 0.7));
  }
  .delete-btn:hover {
    background: linear-gradient(90deg, rgba(230, 74, 31, 0.7), rgba(255, 107, 107, 0.7));
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

  /* ====== Photo Form ====== */
  .photo-form {
    margin-bottom: 24px;
  }
  .photo-card {
    background: linear-gradient(135deg, var(--panel), #1A1F26);
    padding: 16px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    transition: box-shadow 0.3s ease;
    text-align: center;
  }
  .photo-card:hover {
    box-shadow: var(--glow), var(--shadow);
  }
  .photo-card h4 {
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
  .form-group input {
    padding: 8px;
    border-radius: 8px;
    border: 1px solid rgba(0, 255, 136, 0.3);
    background: rgba(255, 255, 255, 0.05);
    color: var(--white);
    font-size: 0.9rem;
    width: 100%;
    transition: var(--transition);
  }
  .form-group input:focus {
    outline: none;
    border-color: var(--neon);
    box-shadow: 0 0 0 2px rgba(0, 255, 136, 0.3);
  }
  .form-group input::placeholder {
    color: var(--muted);
  }

  /* ====== Photos Grid ====== */
  .photos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.5rem;
    margin-bottom: 24px;
  }
  .photo-card {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }
  .photo-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    transition: var(--transition);
  }
  .photo-card img:hover {
    filter: brightness(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  }
  .photo-description {
    font-size: 0.9rem;
    color: var(--muted);
    font-style: italic;
  }
  .photo-date {
    font-size: 0.85rem;
    color: var(--muted);
  }
  .photo-card .form-group {
    margin-bottom: 8px;
  }
  .photo-card .calculate-btn {
    width: 100%;
  }
  .no-data {
    text-align: center;
    padding: 24px;
    color: var(--muted);
    font-size: 1rem;
  }

  /* ====== Lightbox ====== */
  #lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(8px);
    justify-content: center;
    align-items: center;
    z-index: 2000;
    animation: fadeIn 0.4s ease;
  }
  #lightbox-content {
    max-width: 90%;
    max-height: 90%;
    text-align: center;
  }
  #lightbox-img {
    max-width: 100%;
    max-height: 70vh;
    border: 1px solid var(--neon);
    border-radius: 12px;
    box-shadow: var(--glow);
    transition: var(--transition);
  }
  #lightbox-content:hover #lightbox-img {
    transform: scale(1.02);
  }
  #lightbox-info p {
    color: var(--white);
    margin: 0.5rem 0;
    font-size: 1rem;
  }
  #lightbox-info #lightbox-desc {
    color: var(--muted);
    font-style: italic;
  }

  /* ====== Responsive Design ====== */
  @media (max-width: 768px) {
    main {
      padding: 20px;
    }
    .photo-card {
      padding: 12px;
    }
    .photos-grid {
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      gap: 1rem;
    }
    .photo-card img {
      height: 160px;
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
    .photo-card {
      min-width: 100%;
    }
  }

  /* ====== Animations ====== */
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  section, .photo-card, .photos-grid, #lightbox {
    animation: fadeIn 0.5s var(--animation-ease);
  }
</style>

<div id="fitlife-container" role="application" aria-label="FitLife Progress Photos">
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
        <h1><span>FitLife</span> Progress Photos</h1>
        <p class="muted">Track your transformation and stay motivated!</p>
      </div>
      <div class="header-info">
        <div>{{ now()->format('l, F d, Y') }}</div>
        <div>{{ now()->format('H:i') }}</div>
      </div>
    </header>

    <!-- Add Progress Photo -->
    <section aria-labelledby="photo-form-heading">
      <h3 id="photo-form-heading">Add New Photo</h3>
      <div class="photo-card">
        <form action="{{ route('progress.store') }}" method="POST" enctype="multipart/form-data" class="photo-form">
          @csrf
          <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" id="photo" name="photo" required>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" id="description" name="description" placeholder="Enter description">
          </div>
          <button type="submit" class="calculate-btn">Add Photo</button>
        </form>
      </div>
    </section>

    <!-- List Progress Photos -->
    <section aria-labelledby="photos-heading">
      <h3 id="photos-heading">Your Progress Photos</h3>
      <div class="photos-grid">
        @forelse($progressPhotos as $progress)
        <div class="photo-card">
          <img src="{{ asset('storage/' . $progress->photo) }}" alt="Progress Photo">
          <div class="photo-description">{{ $progress->description ?? 'No description' }}</div>
          <div class="photo-date">Uploaded: {{ $progress->created_at->format('M d, Y H:i') }}</div>
          <form action="{{ route('progress.update', $progress->id) }}" method="POST" class="photo-form">
            @csrf
            @method('PATCH')
            <div class="form-group">
              <label for="description-{{ $progress->id }}">Update Description</label>
              <input type="text" id="description-{{ $progress->id }}" name="description" value="{{ $progress->description }}" placeholder="Enter description">
            </div>
            <button type="submit" class="update-btn">Update</button>
          </form>
          <form action="{{ route('progress.destroy', $progress->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-btn">Delete</button>
          </form>
        </div>
        @empty
        <div class="no-data">No progress photos yet. Start uploading your journey!</div>
        @endforelse
      </div>
    </section>

    <!-- Lightbox -->
    <div id="lightbox" aria-hidden="true">
      <div id="lightbox-content">
        <img id="lightbox-img" src="" alt="Enlarged Progress Photo">
        <div id="lightbox-info">
          <p id="lightbox-date"></p>
          <p id="lightbox-desc"></p>
        </div>
      </div>
    </div>
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
    if (e.key === 'Escape') {
      body.classList.remove('sidebar-open');
      mobileToggle.setAttribute('aria-expanded', 'false');
      lightbox.style.display = 'none';
    }
  });

  /* ===== Lightbox ===== */
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  const lightboxDate = document.getElementById('lightbox-date');
  const lightboxDesc = document.getElementById('lightbox-desc');

  document.querySelectorAll('.photo-card img').forEach(img => {
    img.addEventListener('click', () => {
      lightbox.style.display = 'flex';
      lightboxImg.src = img.src;
      const card = img.closest('.photo-card');
      lightboxDate.textContent = card.querySelector('.photo-date')?.textContent || '';
      lightboxDesc.textContent = card.querySelector('.photo-description')?.textContent || '';
      lightbox.setAttribute('aria-hidden', 'false');
    });
  });

  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) {
      lightbox.style.display = 'none';
      lightbox.setAttribute('aria-hidden', 'true');
    }
  });
});
</script>
@endsection