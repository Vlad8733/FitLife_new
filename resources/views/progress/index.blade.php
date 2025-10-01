@extends('layouts.app')

@section('content')
  <div id="fitlife-container" role="application" aria-label="FitLife Progress Photos">
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
            <div class="photo-item" data-idx="{{ $idx }}" data-img="{{ asset('storage/' . $progress->photo) }}"
              data-desc="{{ $progress->description ?? '' }}" data-date="{{ $progress->created_at->format('M d, Y') }}">
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