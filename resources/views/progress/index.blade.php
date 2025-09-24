@extends('layouts.app')

@section('content')
  <div id="fitlife-container" role="application" aria-label="FitLife Progress Photos">
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
        <div class="gallery-grid">
          @forelse($progressPhotos as $idx => $progress)
            <div class="photo-item" data-idx="{{ $idx }}"
              data-img="{{ asset('storage/' . $progress->photo) }}" data-desc="{{ $progress->description ?? '' }}"
              data-date="{{ $progress->created_at->format('M d, Y') }}">
              <img src="{{ asset('storage/' . $progress->photo) }}" alt="Progress photo" loading="lazy" class="photo-img">
              <div class="photo-description">{{ $progress->description ?? 'No description' }}</div>
              <div class="photo-date">Uploaded: {{ $progress->created_at->format('M d, Y H:i') }}</div>
              <form action="{{ route('progress.update', $progress->id) }}" method="POST" class="photo-form">
                @csrf
                @method('PATCH')
                <div class="form-group">
                  <label for="description-{{ $progress->id }}">Update Description</label>
                  <input type="text" id="description-{{ $progress->id }}" name="description"
                    value="{{ $progress->description }}" placeholder="Enter description">
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
            <p class="no-data">No progress photos yet. Start uploading your journey!</p>
          @endforelse
        </div>
      </section>

      <!-- Lightbox -->
      <div id="lightbox" role="dialog" aria-hidden="true">
        <div class="lightbox-content">
          <button class="lightbox-close" aria-label="Close">×</button>
          <img id="lightbox-img" src="" alt="Enlarged Progress Photo">
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

    .photo-card {
      background: var(--card-bg);
      padding: 16px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
      margin-bottom: 16px;
    }

    .photo-form {
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

    .calculate-btn,
    .update-btn,
    .delete-btn {
      background: var(--accent);
      color: #fff;
      border: none;
      padding: 10px 16px;
      border-radius: var(--radius);
      font-size: 0.95rem;
      cursor: pointer;
      transition: var(--transition);
    }

    .calculate-btn:hover,
    .update-btn:hover {
      background: #1d4ed8;
    }

    .delete-btn {
      background: #dc2626;
    }

    .delete-btn:hover {
      background: #b91c1c;
    }

    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
      gap: 12px;
    }

    .photo-item {
      border-radius: var(--radius);
      overflow: hidden;
      border: 1px solid var(--border);
      transition: var(--transition);
    }

    .photo-item:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow);
    }

    .photo-img {
      width: 100%;
      height: 140px;
      object-fit: cover;
      cursor: pointer;
    }

    .photo-description,
    .photo-date {
      padding: 8px;
      font-size: 0.85rem;
      color: var(--muted);
    }

    .photo-description {
      font-weight: 500;
    }

    .no-data {
      padding: 16px;
      text-align: center;
      color: var(--muted);
      font-size: 0.9rem;
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

    #lightbox-img {
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
      .photo-form {
        flex-direction: column;
        align-items: stretch;
      }

      .form-group {
        min-width: 100%;
      }

      .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
      }

      .photo-img {
        height: 120px;
      }
    }
  </style>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const mobileToggle = document.getElementById('mobile-toggle');
      const sidebar = document.getElementById('sidebar');
      const lightbox = document.getElementById('lightbox');
      const lightboxImg = document.getElementById('lightbox-img');
      const lightboxDesc = document.getElementById('lightbox-desc');
      const lightboxDate = document.getElementById('lightbox-date');
      const closeBtn = document.querySelector('.lightbox-close');
      const prevBtn = document.querySelector('.lightbox-nav.prev');
      const nextBtn = document.querySelector('.lightbox-nav.next');
      const photos = document.querySelectorAll('.photo-item');
      let currentIdx = -1;

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
          lightbox.setAttribute('aria-hidden', 'true');
        }
      });

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
        const img = photo.querySelector('.photo-img');
        img.addEventListener('click', () => openLightbox(idx));
        img.addEventListener('keydown', e => {
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