@extends('layouts.app')

@section('content')

  <div id="fitlife-container" role="application" aria-label="FitLife Posts">
    <aside id="sidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <h2>FitLife</h2>
        <p>Power Your Performance</p>
      </div>
      <nav class="nav-menu" aria-label="Main menu">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" {{ request()->routeIs('dashboard') ? 'aria-current=page' : '' }} style="--i: 1;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 13h8V3H3z" />
            <path d="M13 21h8V11h-8z" />
            <path d="M13 3v8" />
          </svg>
          <span>Home</span>
        </a>
        <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.*') ? 'active' : '' }}" {{ request()->routeIs('posts.*') ? 'aria-current=page' : '' }} style="--i: 2;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
            <path d="M17 8l4 4-4 4" />
          </svg>
          <span>Community Posts</span>
        </a>
        <a href="{{ route('foods.index') }}" class="{{ request()->routeIs('foods.*') ? 'active' : '' }}" {{ request()->routeIs('foods.*') ? 'aria-current=page' : '' }} style="--i: 3;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M4 21c4-4 6-11 6-17" />
            <path d="M20 7a4 4 0 11-8 0" />
          </svg>
          <span>Meal Tracker</span>
        </a>
        <a href="{{ route('sleep.index') }}" class="{{ request()->routeIs('sleep.*') ? 'active' : '' }}" {{ request()->routeIs('sleep.*') ? 'aria-current=page' : '' }} style="--i: 4;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
          </svg>
          <span>Sleep Tracker</span>
        </a>
        <a href="{{ route('water.index') }}" class="{{ request()->routeIs('water.*') ? 'active' : '' }}" {{ request()->routeIs('water.*') ? 'aria-current=page' : '' }} style="--i: 5;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M12 2s4 5 4 8a4 4 0 01-8 0c0-3 4-8 4-8z" />
          </svg>
          <span>Water Tracker</span>
        </a>
        <a href="{{ route('progress.index') }}" class="{{ request()->routeIs('progress.*') ? 'active' : '' }}" {{ request()->routeIs('progress.*') ? 'aria-current=page' : '' }} style="--i: 6;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M21 3v18H3V3h18z" />
            <path d="M7 14l3-3 2 2 5-5" />
          </svg>
          <span>Progress Photos</span>
        </a>
        <a href="{{ route('goals.index') }}" class="{{ request()->routeIs('goals.*') ? 'active' : '' }}" {{ request()->routeIs('goals.*') ? 'aria-current=page' : '' }} style="--i: 7;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4l3 3" />
          </svg>
          <span>Goals</span>
        </a>
        <a href="{{ route('calories.index') }}" class="{{ request()->routeIs('calories.*') ? 'active' : '' }}" {{ request()->routeIs('calories.*') ? 'aria-current=page' : '' }} style="--i: 8;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M12 2v20" />
            <path d="M5 12h14" />
          </svg>
          <span>Calorie Calculator</span>
        </a>
        <a href="{{ route('biography.edit') }}" class="{{ request()->routeIs('biography.*') ? 'active' : '' }}" {{ request()->routeIs('biography.*') ? 'aria-current=page' : '' }} style="--i: 9;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <circle cx="12" cy="8" r="4" />
            <path d="M6 20v-1a6 6 0 0112 0v1" />
          </svg>
          <span>Biography</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}" {{ request()->routeIs('profile.edit') ? 'aria-current=page' : '' }} style="--i: 10;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
          </svg>
          <span>Profile</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
          @csrf
          <button type="submit" aria-label="Logout">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
              <path d="M16 17l5-5-5-5" />
              <path d="M21 12H9" />
            </svg>
            Logout
          </button>
        </form>
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
          <h1>Community Posts</h1>
          <p class="muted">Share your fitness journey</p>
        </div>
      </header>

      <section aria-labelledby="posts-heading">
        <h3 id="posts-heading">Create a Post</h3>
        <div class="post-form">
          <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="post-form">
            @csrf
            @error('content')
              <div class="error">{{ $message }}</div>
            @enderror
            <textarea name="content" placeholder="What's on your mind? (Max 280 characters)" rows="3" aria-label="New post content" maxlength="280"></textarea>
            <div class="char-count" id="post-char-count">0/280</div>
            @error('photo')
              <div class="error">{{ $message }}</div>
            @enderror
            <input type="file" name="photo" accept="image/*" aria-label="Upload post photo" id="post-photo">
            <img id="image-preview" class="image-preview" alt="Image preview">
            <button type="submit" id="post-submit" aria-label="Submit post">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                <path d="M17 21v-8H7v8" />
                <path d="M7 3v5h8" />
              </svg>
              Post
            </button>
          </form>
        </div>

        @forelse($posts as $post)
          <div class="post-card" aria-label="Post by {{ $post->user->name }}">
            <div class="post-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
                <path d="M17 8l4 4-4 4" />
              </svg>
            </div>
            <div class="post-body">
              <div class="post-header">
                <h4>{{ $post->user->name }}</h4>
                <span class="muted">{{ $post->created_at->diffForHumans() }}</span>
              </div>

              @if($post->photo_path)
                <div class="post-image">
                  <img src="{{ asset('storage/' . $post->photo_path) }}" alt="Post image" loading="lazy" data-desc="{{ $post->content ?? '' }}" data-date="{{ $post->created_at->format('M d, Y H:i') }}">
                </div>
              @endif

              <div class="post-content">
                <div class="value">{{ $post->content }}</div>
              </div>

              <div class="post-actions">
                <form action="{{ route('posts.like', $post) }}" method="POST" class="like-form">
                  @csrf
                  <button type="submit" class="{{ Auth::check() && $post->likes->where('user_id', Auth::id())->where('type', 'like')->isNotEmpty() ? 'active' : '' }}" aria-label="Like post">
                    ❤️ {{ $post->likes->where('type', 'like')->count() }}
                  </button>
                </form>
                <form action="{{ route('posts.dislike', $post) }}" method="POST" class="dislike-form">
                  @csrf
                  <button type="submit" class="{{ Auth::check() && $post->likes->where('user_id', Auth::id())->where('type', 'dislike')->isNotEmpty() ? 'active' : '' }}" aria-label="Dislike post">
                    👎🏻 {{ $post->likes->where('type', 'dislike')->count() }}
                  </button>
                </form>

                @can('update', $post)
                  <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="edit-post-form">
                    @csrf
                    @method('PATCH')
                    @error('content')
                      <div class="error">{{ $message }}</div>
                    @enderror
                    <input type="text" name="content" value="{{ $post->content }}" aria-label="Edit post content">
                    @error('photo')
                      <div class="error">{{ $message }}</div>
                    @enderror
                    <input type="file" name="photo" accept="image/*" aria-label="Update post photo">
                    <button type="submit" aria-label="Update post">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                      </svg>
                      Update
                    </button>
                  </form>
                @endcan
                @can('delete', $post)
                  <form action="{{ route('posts.destroy', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" aria-label="Delete post">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M3 6h18" />
                        <path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-10 0v14a2 2 0 002 2h6a2 2 0 002-2V6" />
                      </svg>
                      Delete
                    </button>
                  </form>
                @endcan
                <button class="comment-toggle" data-post-id="{{ $post->id }}" aria-label="Toggle comments">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
                    <path d="M17 8l4 4-4 4" />
                  </svg>
                  {{ $post->comments->count() }} Comments
                </button>
              </div>

              <div class="comment-section" id="comment-section-{{ $post->id }}">
                @foreach($post->comments as $comment)
                  <div class="comment" aria-label="Comment by {{ $comment->user->name }}">
                    <div class="comment-icon">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
                        <path d="M17 8l4 4-4 4" />
                      </svg>
                    </div>
                    <div class="comment-body">
                      <div class="comment-header">
                        <h4>{{ $comment->user->name }}</h4>
                        <span class="muted">{{ $comment->created_at->diffForHumans() }}</span>
                      </div>
                      <div class="comment-content">
                        {{ $comment->content }}
                      </div>
                      <div class="replies">
                        @foreach($comment->replies as $reply)
                          <div class="reply" aria-label="Reply by {{ $reply->user->name }}">
                            <div class="reply-icon">
                              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
                                <path d="M17 8l4 4-4 4" />
                              </svg>
                            </div>
                            <div class="reply-body">
                              <h4>{{ $reply->user->name }}</h4>
                              <p>{{ $reply->content }}</p>
                            </div>
                          </div>
                        @endforeach
                        <div class="reply-form">
                          <form action="{{ route('posts.comment', $post) }}" method="POST">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            @error('content')
                              <div class="error">{{ $message }}</div>
                            @enderror
                            <input type="text" name="content" placeholder="Reply..." aria-label="Reply to comment">
                            <button type="submit" aria-label="Submit reply">
                              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
                                <path d="M17 8l4 4-4 4" />
                              </svg>
                              Reply
                            </button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach

                <div class="comment-form">
                  <form action="{{ route('posts.comment', $post) }}" method="POST">
                    @csrf
                    @error('content')
                      <div class="error">{{ $message }}</div>
                    @enderror
                    <input type="text" name="content" placeholder="Comment..." aria-label="New comment">
                    <button type="submit" aria-label="Submit comment">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
                        <path d="M17 8l4 4-4 4" />
                      </svg>
                      Comment
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="empty-state">
            No posts yet. <a href="#" onclick="document.querySelector('.post-form textarea').focus()">Be the first to share!</a>
          </div>
        @endforelse
      </section>
    </main>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Mobile sidebar toggle
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

      // Photo meta hover
      const postImages = document.querySelectorAll('.post-image img'),
            metaContainer = document.getElementById('photo-meta-container'),
            metaDesc = document.getElementById('photo-meta-desc'),
            metaDate = document.getElementById('photo-meta-date');

      function showPhotoMeta(img) {
        if (!img) {
          metaContainer.classList.remove('visible');
          return;
        }
        metaDesc.textContent = img.getAttribute('data-desc') || 'No description';
        metaDate.textContent = img.getAttribute('data-date') || '';
        metaContainer.classList.add('visible');
      }

      function hidePhotoMeta() {
        metaContainer.classList.remove('visible');
      }

      postImages.forEach(img => {
        img.addEventListener('mouseenter', () => showPhotoMeta(img));
        img.addEventListener('mouseleave', hidePhotoMeta);
        img.addEventListener('focus', () => showPhotoMeta(img));
        img.addEventListener('blur', hidePhotoMeta);
      });

      // Post form enhancements
      const postForm = document.getElementById('post-form'),
            postTextarea = postForm.querySelector('textarea[name="content"]'),
            postPhoto = document.getElementById('post-photo'),
            imagePreview = document.getElementById('image-preview'),
            postSubmit = document.getElementById('post-submit'),
            charCount = document.getElementById('post-char-count');

      postTextarea.addEventListener('input', () => {
        const count = postTextarea.value.length;
        charCount.textContent = `${count}/280`;
        if (count > 280) {
          charCount.classList.add('exceeded');
          postSubmit.disabled = true;
        } else {
          charCount.classList.remove('exceeded');
          postSubmit.disabled = false;
        }
      });

      postPhoto.addEventListener('change', () => {
        const file = postPhoto.files[0];
        if (file && file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = e => {
            imagePreview.src = e.target.result;
            imagePreview.classList.add('visible');
          };
          reader.readAsDataURL(file);
        } else {
          imagePreview.classList.remove('visible');
          imagePreview.src = '';
        }
      });

      postForm.addEventListener('submit', (e) => {
        postSubmit.disabled = true;
        postSubmit.textContent = 'Posting...';
      });

      // Comment toggle
      document.querySelectorAll('.comment-toggle').forEach(toggle => {
        toggle.addEventListener('click', () => {
          const postId = toggle.getAttribute('data-post-id');
          const commentSection = document.getElementById(`comment-section-${postId}`);
          const isVisible = commentSection.classList.toggle('visible');
          toggle.setAttribute('aria-expanded', isVisible ? 'true' : 'false');
          toggle.textContent = isVisible ? 'Hide Comments' : `${toggle.textContent.split(' ')[0]} Comments`;
        });
      });

      // Like/Dislike feedback
      document.querySelectorAll('.like-form, .dislike-form').forEach(form => {
        form.addEventListener('submit', async (e) => {
          e.preventDefault();
          const button = form.querySelector('button');
          button.disabled = true;
          try {
            const response = await fetch(form.action, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
              }
            });
            const data = await response.json();
            if (response.ok) {
              button.classList.toggle('active', data.type === button.classList.contains('like-form') ? 'like' : 'dislike');
              button.textContent = `${button.textContent.split(' ')[0]} ${data.count}`;
              const otherButton = form.classList.contains('like-form')
                ? form.parentElement.querySelector('.dislike-form button')
                : form.parentElement.querySelector('.like-form button');
              if (otherButton) {
                otherButton.classList.remove('active');
                otherButton.textContent = `${otherButton.textContent.split(' ')[0]} ${data.otherCount}`;
              }
            }
          } catch (error) {
            console.error('Error:', error);
          } finally {
            button.disabled = false;
          }
        });
      });
    });
  </script>
@endsection