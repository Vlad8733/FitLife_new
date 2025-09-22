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