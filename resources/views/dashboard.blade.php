@extends('layouts.app')

@section('content')
  <div id="fitlife-container" role="application" aria-label="FitLife Dashboard">
    <aside id="sidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <h2>FitLife</h2>
        <p>Power Your Performance</p>
      </div>
      <nav class="nav-menu" aria-label="Main menu">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" {{ request()->routeIs('dashboard') ? 'aria-current=page' : '' }} style="--i: 1;"><svg viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 13h8V3H3z" />
            <path d="M13 21h8V11h-8z" />
            <path d="M13 3v8" />
          </svg><span>Home</span></a>
        <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.*') ? 'active' : '' }}" {{ request()->routeIs('posts.*') ? 'aria-current=page' : '' }} style="--i: 2;"><svg viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.6">
            <path d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
            <path d="M17 8l4 4-4 4" />
          </svg><span>Community Posts</span></a>
        <a href="{{ route('foods.index') }}" class="{{ request()->routeIs('foods.*') ? 'active' : '' }}" {{ request()->routeIs('foods.*') ? 'aria-current=page' : '' }} style="--i: 3;"><svg viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.6">
            <path d="M4 21c4-4 6-11 6-17" />
            <path d="M20 7a4 4 0 11-8 0" />
          </svg><span>Meal Tracker</span></a>
        <a href="{{ route('sleep.index') }}" class="{{ request()->routeIs('sleep.*') ? 'active' : '' }}" {{ request()->routeIs('sleep.*') ? 'aria-current=page' : '' }} style="--i: 4;"><svg viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.6">
            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
          </svg><span>Sleep Tracker</span></a>
        <a href="{{ route('water.index') }}" class="{{ request()->routeIs('water.*') ? 'active' : '' }}" {{ request()->routeIs('water.*') ? 'aria-current=page' : '' }} style="--i: 5;"><svg viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.6">
            <path d="M12 2s4 5 4 8a4 4 0 01-8 0c0-3 4-8 4-8z" />
          </svg><span>Water Tracker</span></a>
        <a href="{{ route('progress.index') }}" class="{{ request()->routeIs('progress.*') ? 'active' : '' }}" {{ request()->routeIs('progress.*') ? 'aria-current=page' : '' }} style="--i: 6;"><svg viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.6">
            <path d="M21 3v18H3V3h18z" />
            <path d="M7 14l3-3 2 2 5-5" />
          </svg><span>Progress Photos</span></a>
        <a href="{{ route('goals.index') }}" class="{{ request()->routeIs('goals.*') ? 'active' : '' }}" {{ request()->routeIs('goals.*') ? 'aria-current=page' : '' }} style="--i: 7;"><svg viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.6">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4l3 3" />
          </svg><span>Goals</span></a>
        <a href="{{ route('calories.index') }}" class="{{ request()->routeIs('calories.*') ? 'active' : '' }}" {{ request()->routeIs('calories.*') ? 'aria-current=page' : '' }} style="--i: 8;"><svg viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.6">
            <path d="M12 2v20" />
            <path d="M5 12h14" />
          </svg><span>Calorie Calculator</span></a>
        <a href="{{ route('biography.edit') }}" class="{{ request()->routeIs('biography.*') ? 'active' : '' }}" {{ request()->routeIs('biography.*') ? 'aria-current=page' : '' }} style="--i: 9;"><svg viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.6">
            <circle cx="12" cy="8" r="4" />
            <path d="M6 20v-1a6 6 0 0112 0v1" />
          </svg><span>Biography</span></a>
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}" {{ request()->routeIs('profile.edit') ? 'aria-current=page' : '' }} style="--i: 10;"><svg viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.6">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
          </svg><span>Profile</span></a>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">@csrf<button type="submit"
            aria-label="Logout">Logout</button></form>
      </nav>
      <div id="photo-meta-container">
        <p id="photo-meta-desc"></p>
        <small id="photo-meta-date"></small>
      </div>
    </aside>
    <main>
      <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">Menu</button>
      <header>
        <div class="header-left">
          <h1>Hello, {{ Auth::user()->name }}!</h1>
          <p class="muted">Your FitLife homepage</p>
        </div>
      </header>
      <section aria-labelledby="stats-heading">
        <h3 id="stats-heading">Your Stats</h3>@php $bio = Auth::user()->biography;@endphp<div class="log-card"
          style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;">
          <div>
            <div class="small"><strong>Name:</strong> {{ $bio->full_name ?? Auth::user()->name }}</div>
            <div class="small"><strong>Age:</strong> {{ $bio->age ?? 'Not set' }}</div>
            <div class="small"><strong>Height:</strong> {{ $bio->height ?? 'Not set' }} cm</div>
            <div class="small"><strong>Weight:</strong> {{ $bio->weight ?? 'Not set' }} kg</div>
            <div class="small"><strong>Gender:</strong> {{ ucfirst($bio->gender ?? 'Not set') }}</div>
          </div>
        </div>
      </section>
      <section aria-labelledby="metrics-heading">
        <h3 id="metrics-heading">Performance Metrics</h3>
        <div class="stat-cards">
          <div class="stat-card" aria-hidden="false">
            <div class="stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.6">
                <path d="M3 12h18" />
              </svg></div>
            <div class="stat-body">
              <h4>Energy</h4>
              <div class="value count-up" data-target="{{ $totalCalories ?? 0 }}">0</div>
              <div class="small muted">kcal today</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.6">
                <path d="M12 3v6l4 2" />
              </svg></div>
            <div class="stat-body">
              <h4>Recovery</h4>
              <div class="value count-up" data-target="{{ round($totalSleep ?? 0, 1) }}">0</div>
              <div class="small muted">hours</div>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.6">
                <path d="M12 2s4 5 4 8a4 4 0 01-8 0c0-3 4-8 4-8z" />
              </svg></div>
            <div class="stat-body">
              <h4>Hydration</h4>
              <div class="value count-up" data-target="{{ $totalWater ?? 0 }}">0</div>
              <div class="small muted">ml</div>
            </div>
          </div>
        </div>
      </section>
      <section>
        <h3>Progress Gallery</h3>
        <div class="gallery-grid" id="gallery-grid">@forelse($photos as $idx => $photo)<article class="photo-item"
          role="button" tabindex="0" data-idx="{{ $idx }}" data-img="{{ asset('storage/' . $photo->photo) }}"
          data-desc="{{ $photo->description ?? '' }}" data-date="{{ $photo->created_at->format('M d, Y H:i') }}" style="--i: {{ $idx + 1 }};"><img
            src="{{ asset('storage/' . $photo->photo) }}" alt="Progress photo" loading="lazy">
        </article>@empty<div class="log-card small">No photos yet. <a href="{{ route('progress.index') }}">Add one!</a>
          </div>@endforelse</div>
      </section>
      <section>
        <h3>Your Targets</h3>@if($goals->isEmpty())
        <div class="log-card small">No goals set. <a href="{{ route('goals.index') }}">Set one!</a></div>@else<div
          class="log-card">@foreach($goals as $goal)@php $percent = min(100, max(0, (int) $goal->progressPercent()));@endphp
            <div class="goal-item" aria-label="{{ $goal->type }} goal">
              <div class="small muted" style="margin-top:8px">{{ round($goal->current_value, 1) }} /
                {{ $goal->target_value }}</div>
              <div class="goal-bar" data-progress="{{ $percent }}">
                <div class="fill" style="width:0%;" aria-valuenow="{{ $percent }}" aria-valuemax="100" aria-valuemin="0"
                  role="progressbar"></div>
              </div>
        </div>@endforeach</div>@endif
      </section>
      <div id="photo-lightbox" role="dialog" aria-hidden="true" aria-label="Photo viewer">
        <div class="lightbox-inner" role="document">
          <div class="lightbox-img"><img id="lightbox-image" src="" alt=""></div>
          <aside class="lightbox-side"><button class="lightbox-close" aria-label="Close viewer">Close</button>
            <div id="lightbox-caption" class="small muted">—</div>
            <div id="lightbox-timestamp" class="small muted" style="margin-top:8px"></div>
            <div class="lightbox-nav"><button id="lightbox-prev" aria-label="Previous">Prev</button><button
                id="lightbox-next" aria-label="Next">Next</button></div>
          </aside>
        </div>
      </div>
    </main>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const mobileToggle = document.getElementById('mobile-toggle'),
            body = document.body,
            sidebar = document.getElementById('sidebar');
      mobileToggle.addEventListener('click', () => {
        const opened = body.classList.toggle('sidebar-open');
        mobileToggle.setAttribute('aria-expanded', opened ? 'true' : 'false');
      });
      document.addEventListener('click', e => {
        if (!body.classList.contains('sidebar-open') || sidebar.contains(e.target) || mobileToggle.contains(e.target)) return;
        body.classList.remove('sidebar-open');
        mobileToggle.setAttribute('aria-expanded', 'false');
      });
      document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && body.classList.contains('sidebar-open')) {
          body.classList.remove('sidebar-open');
          mobileToggle.setAttribute('aria-expanded', 'false');
        }
      });
      const countUps = document.querySelectorAll('.count-up');
      countUps.forEach(el => {
        const target = parseFloat(el.getAttribute('data-target') || '0');
        let started = false;
        const run = () => {
          if (started) return;
          started = true;
          const duration = 1200, start = performance.now(), initial = 0;
          function step(ts) {
            const progress = Math.min((ts - start) / duration, 1),
                  value = initial + (target - initial) * progress;
            el.textContent = Number.isInteger(target) ? Math.round(value) : (Math.round(value * 10) / 10);
            if (progress < 1) requestAnimationFrame(step);
          }
          requestAnimationFrame(step);
        };
        if ('IntersectionObserver' in window) {
          new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
              if (entry.isIntersecting) {
                run();
                obs.unobserve(entry.target);
              }
            });
          }, { threshold: 0.4 }).observe(el);
        } else run();
      });
      const bars = document.querySelectorAll('.goal-bar');
      if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries, obs) => {
          entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el = entry.target,
                  percent = parseInt(el.getAttribute('data-progress') || '0', 10),
                  fill = el.querySelector('.fill');
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
          const percent = parseInt(b.getAttribute('data-progress') || '0', 10),
                fill = b.querySelector('.fill');
          if (fill) fill.style.width = percent + '%';
        });
      }
      const gallery = document.getElementById('gallery-grid'),
            items = Array.from(gallery ? gallery.querySelectorAll('.photo-item') : []),
            lightbox = document.getElementById('photo-lightbox'),
            lbImage = document.getElementById('lightbox-image'),
            lbCaption = document.getElementById('lightbox-caption'),
            lbTimestamp = document.getElementById('lightbox-timestamp'),
            lbClose = document.querySelector('.lightbox-close'),
            lbPrev = document.getElementById('lightbox-prev'),
            lbNext = document.getElementById('lightbox-next'),
            metaContainer = document.getElementById('photo-meta-container'),
            metaDesc = document.getElementById('photo-meta-desc'),
            metaDate = document.getElementById('photo-meta-date');
      let currentIndex = -1;
      function openLightbox(idx) {
        if (idx < 0 || idx >= items.length) return;
        const it = items[idx];
        currentIndex = idx;
        lbImage.src = it.getAttribute('data-img');
        lbImage.alt = it.getAttribute('data-desc') || 'No description';
        lbCaption.textContent = lbImage.alt;
        lbTimestamp.textContent = it.getAttribute('data-date') || '';
        lightbox.setAttribute('aria-hidden', 'false');
        lbClose.focus();
        metaContainer.classList.remove('visible');
        preloadImage(items[(idx + 1) % items.length]?.getAttribute('data-img'));
        preloadImage(items[(idx - 1 + items.length) % items.length]?.getAttribute('data-img'));
      }
      function closeLightbox() {
        lightbox.setAttribute('aria-hidden', 'true');
        lbImage.src = '';
        currentIndex = -1;
        metaContainer.classList.remove('visible');
      }
      function preloadImage(url) {
        if (url) new Image().src = url;
      }
      function showPhotoMeta(idx) {
        if (idx < 0 || idx >= items.length) {
          metaContainer.classList.remove('visible');
          return;
        }
        const it = items[idx];
        metaDesc.textContent = it.getAttribute('data-desc') || 'No description';
        metaDate.textContent = it.getAttribute('data-date') || '';
        metaContainer.classList.add('visible');
      }
      function hidePhotoMeta() {
        metaContainer.classList.remove('visible');
      }
      items.forEach((it, idx) => {
        it.addEventListener('mouseenter', () => showPhotoMeta(idx));
        it.addEventListener('mouseleave', hidePhotoMeta);
        it.addEventListener('click', () => openLightbox(idx));
        it.addEventListener('keydown', e => {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            openLightbox(idx);
          }
        });
      });
      lbClose.addEventListener('click', closeLightbox);
      lightbox.addEventListener('click', e => {
        if (e.target === lightbox) closeLightbox();
      });
      lbPrev.addEventListener('click', () => {
        currentIndex = (currentIndex <= 0 ? items.length - 1 : currentIndex - 1);
        openLightbox(currentIndex);
      });
      lbNext.addEventListener('click', () => {
        currentIndex = (currentIndex >= items.length - 1 ? 0 : currentIndex + 1);
        openLightbox(currentIndex);
      });
      document.addEventListener('keydown', e => {
        if (lightbox.getAttribute('aria-hidden') === 'false') {
          if (e.key === 'Escape') closeLightbox();
          if (e.key === 'ArrowLeft') lbPrev.click();
          if (e.key === 'ArrowRight') lbNext.click();
        }
      });
    });
  </script>
@endsection