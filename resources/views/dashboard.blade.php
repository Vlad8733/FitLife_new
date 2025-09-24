@extends('layouts.app')

@section('content')
  <div id="fitlife-container">
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
            <path
              d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2M17 8l4 4-4 4" />
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
    <main>
      <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      <header>
        <h1>Hello, {{ Auth::user()->name }}!</h1>
      </header>
      <section class="stats">
        <h3>Your Stats</h3>
        @php $bio = Auth::user()->biography; @endphp
        <div class="stats-grid">
          <div><span>Name</span>{{ $bio->full_name ?? Auth::user()->name }}</div>
          <div><span>Age</span>{{ $bio->age ?? 'Not set' }}</div>
          <div><span>Height</span>{{ $bio->height ?? 'Not set' }} cm</div>
          <div><span>Weight</span>{{ $bio->weight ?? 'Not set' }} kg</div>
          <div><span>Gender</span>{{ ucfirst($bio->gender ?? 'Not set') }}</div>
        </div>
      </section>
      <section class="metrics">
        <h3>Metrics</h3>
        <div class="metrics-grid">
          <div class="metric-card">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#0000FF">
              <path
                d="M240-400q0 52 21 98.5t60 81.5q-1-5-1-9v-9q0-32 12-60t35-51l113-111 113 111q23 23 35 51t12 60v9q0 4-1 9 39-35 60-81.5t21-98.5q0-50-18.5-94.5T648-574q-20 13-42 19.5t-45 6.5q-62 0-107.5-41T401-690q-39 33-69 68.5t-50.5 72Q261-513 250.5-475T240-400Zm240 52-57 56q-11 11-17 25t-6 29q0 32 23.5 55t56.5 23q33 0 56.5-23t23.5-55q0-16-6-29.5T537-292l-57-56Zm0-492v132q0 34 23.5 57t57.5 23q18 0 33.5-7.5T622-658l18-22q74 42 117 117t43 163q0 134-93 227T480-80q-134 0-227-93t-93-227q0-129 86.5-245T480-840Z" />
            </svg>
            </svg>
            <h4>Calories</h4>
            <span class="value" data-target="{{ $totalCalories ?? 0 }}">0</span>
            <span>kcal</span>
          </div>
          <div class="metric-card">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#0000FF">
              <path
                d="M40-280v-400h80v320h320v-320h320q66 0 113 47t47 113v240H40Zm480-80h320v-160q0-33-23.5-56.5T760-600H520v240Zm0-240v240-240ZM280-400q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm0-80q-17 0-28.5-11.5T240-520q0-17 11.5-28.5T280-560q17 0 28.5 11.5T320-520q0 17-11.5 28.5T280-480Zm0-40Z" />
            </svg>
            <h4>Sleep</h4>
            <span class="value" data-target="{{ round($totalSleep ?? 0, 1) }}">0</span>
            <span>hours</span>
          </div>
          <div class="metric-card">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#0000FF">
              <path
                d="M491-200q12-1 20.5-9.5T520-230q0-14-9-22.5t-23-7.5q-41 3-87-22.5T343-375q-2-11-10.5-18t-19.5-7q-14 0-23 10.5t-6 24.5q17 91 80 130t127 35ZM480-80q-137 0-228.5-94T160-408q0-100 79.5-217.5T480-880q161 137 240.5 254.5T800-408q0 140-91.5 234T480-80Zm0-80q104 0 172-70.5T720-408q0-73-60.5-165T480-774Q361-665 300.5-573T240-408q0 107 68 177.5T480-160Zm0-320Z" />
            </svg>
            <h4>Water</h4>
            <span class="value" data-target="{{ $totalWater ?? 0 }}">0</span>
            <span>ml</span>
          </div>
        </div>
      </section>
      <section class="gallery">
        <h3>Progress</h3>
        <div class="gallery-grid">
          @forelse($photos as $idx => $photo)
            <div class="photo-item" role="button" tabindex="0" data-idx="{{ $idx }}"
              data-img="{{ asset('storage/' . $photo->photo) }}" data-desc="{{ $photo->description ?? '' }}"
              data-date="{{ $photo->created_at->format('M d, Y') }}">
              <img src="{{ asset('storage/' . $photo->photo) }}" alt="Progress photo" loading="lazy">
            </div>
          @empty
            <p>No photos yet. <a href="{{ route('progress.index') }}">Add one</a></p>
          @endforelse
        </div>
      </section>
      <section class="goals">
        <h3>Goals</h3>
        @if($goals->isEmpty())
          <p>No goals set. <a href="{{ route('goals.index') }}">Set one</a></p>
        @else
          <div class="goals-grid">
            @foreach($goals as $goal)
              @php $percent = min(100, max(0, (int) $goal->progressPercent())); @endphp
              <div class="goal-item">
                <span>{{ $goal->type }}</span>
                <div class="goal-progress">
                  <div class="progress-bar" data-progress="{{ $percent }}">
                    <div class="progress-fill"></div>
                  </div>
                  <span>{{ round($goal->current_value, 1) }} / {{ $goal->target_value }}</span>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </section>
      <div id="lightbox" role="dialog" aria-hidden="true">
        <div class="lightbox-content">
          <button class="lightbox-close" aria-label="Close">×</button>
          <img id="lightbox-img" src="" alt="">
          <div class="lightbox-info">
            <p id="lightbox-desc"></p>
            <p id="lightbox-date"></p>
          </div>
          <button class="lightbox-nav prev" aria-label="Previous">←</button>
          <button class="lightbox-nav next" aria-label="Next">→</button>
        </div>
      </div>
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

    header h1 {
      font-size: 1.75rem;
      font-weight: 600;
      margin-bottom: 24px;
    }

    .stats,
    .metrics,
    .gallery,
    .goals {
      margin-bottom: 32px;
    }

    h3 {
      font-size: 1.25rem;
      font-weight: 600;
      margin-bottom: 16px;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 16px;
    }

    .stats-grid div {
      background: var(--card-bg);
      padding: 16px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
      font-size: 0.9rem;
    }

    .stats-grid div span {
      display: block;
      color: var(--muted);
      font-size: 0.85rem;
      margin-bottom: 4px;
    }

    .metrics-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 16px;
    }

    .metric-card {
      background: var(--card-bg);
      padding: 16px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
      text-align: center;
    }

    .metric-card svg {
      width: 24px;
      height: 24px;
      stroke: var(--accent);
      margin-bottom: 8px;
    }

    .metric-card h4 {
      font-size: 1rem;
      font-weight: 500;
      margin-bottom: 8px;
    }

    .metric-card .value {
      font-size: 1.5rem;
      font-weight: 600;
    }

    .metric-card span:last-child {
      display: block;
      color: var(--muted);
      font-size: 0.85rem;
    }

    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
      gap: 12px;
    }

    .photo-item {
      cursor: pointer;
      border-radius: var(--radius);
      overflow: hidden;
      border: 1px solid var(--border);
      transition: var(--transition);
    }

    .photo-item:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow);
    }

    .photo-item img {
      width: 100%;
      height: 140px;
      object-fit: cover;
    }

    .goals-grid {
      display: grid;
      gap: 12px;
    }

    .goal-item {
      background: var(--card-bg);
      padding: 16px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
    }

    .goal-item span:first-child {
      font-size: 0.95rem;
      font-weight: 500;
    }

    .goal-progress {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-top: 8px;
    }

    .progress-bar {
      flex: 1;
      height: 6px;
      background: var(--border);
      border-radius: 3px;
      overflow: hidden;
    }

    .progress-fill {
      height: 100%;
      background: var(--accent);
      width: 0;
      transition: width 0.5s ease;
    }

    .goal-item span:last-child {
      font-size: 0.85rem;
      color: var(--muted);
    }

    #lightbox {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.85);
      align-items: center;
      justify-content: center;
      padding: 16px;
    }

    #lightbox[aria-hidden="false"] {
      display: flex;
    }

    .lightbox-content {
      max-width: 800px;
      width: 100%;
      background: var(--card-bg);
      border-radius: var(--radius);
      padding: 16px;
      position: relative;
    }

    .lightbox-close {
      position: absolute;
      top: 8px;
      right: 8px;
      background: none;
      border: none;
      font-size: 1.5rem;
      color: var(--text);
      cursor: pointer;
    }

    .lightbox-img {
      width: 100%;
      max-height: 70vh;
      object-fit: contain;
    }

    .lightbox-info {
      margin-top: 12px;
      text-align: center;
    }

    .lightbox-info p {
      font-size: 0.9rem;
      color: var(--muted);
    }

    .lightbox-nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: var(--accent);
      color: #fff;
      border: none;
      padding: 8px;
      border-radius: var(--radius);
      cursor: pointer;
    }

    .lightbox-nav.prev {
      left: 8px;
    }

    .lightbox-nav.next {
      right: 8px;
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
    }

    @media (max-width: 480px) {

      .stats-grid,
      .metrics-grid {
        grid-template-columns: 1fr;
      }

      .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
      }

      .photo-item img {
        height: 120px;
      }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const mobileToggle = document.getElementById('mobile-toggle');
      const sidebar = document.getElementById('sidebar');
      const body = document.body;

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

      const values = document.querySelectorAll('.value');
      values.forEach(val => {
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

      const progressBars = document.querySelectorAll('.progress-bar');
      progressBars.forEach(bar => {
        const percent = parseInt(bar.dataset.progress, 10);
        bar.querySelector('.progress-fill').style.width = `${percent}%`;
      });

      const photos = document.querySelectorAll('.photo-item');
      const lightbox = document.getElementById('lightbox');
      const lightboxImg = document.getElementById('lightbox-img');
      const lightboxDesc = document.getElementById('lightbox-desc');
      const lightboxDate = document.getElementById('lightbox-date');
      const closeBtn = document.querySelector('.lightbox-close');
      const prevBtn = document.querySelector('.lightbox-nav.prev');
      const nextBtn = document.querySelector('.lightbox-nav.next');
      let currentIdx = -1;

      const openLightbox = idx => {
        if (idx < 0 || idx >= photos.length) return;
        currentIdx = idx;
        const photo = photos[idx];
        lightboxImg.src = photo.dataset.img;
        lightboxDesc.textContent = photo.dataset.desc || 'No description';
        lightboxDate.textContent = photo.dataset.date || '';
        lightbox.setAttribute('aria-hidden', 'false');
      };

      const closeLightbox = () => {
        lightbox.setAttribute('aria-hidden', 'true');
        currentIdx = -1;
      };

      photos.forEach((photo, idx) => {
        photo.addEventListener('click', () => openLightbox(idx));
        photo.addEventListener('keydown', e => {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            openLightbox(idx);
          }
        });
      });

      closeBtn.addEventListener('click', closeLightbox);
      lightbox.addEventListener('click', e => {
        if (e.target === lightbox) closeLightbox();
      });

      prevBtn.addEventListener('click', () => openLightbox((currentIdx - 1 + photos.length) % photos.length));
      nextBtn.addEventListener('click', () => openLightbox((currentIdx + 1) % photos.length));

      document.addEventListener('keydown', e => {
        if (lightbox.getAttribute('aria-hidden') === 'false') {
          if (e.key === 'Escape') closeLightbox();
          if (e.key === 'ArrowLeft') prevBtn.click();
          if (e.key === 'ArrowRight') nextBtn.click();
        }
      });
    });
  </script>
@endsection