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

  <main id="main-content">
    <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
    <header><h1>Community</h1></header>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <section class="create-post">
      <form id="post-form" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @error('content') <div class="error">{{ $message }}</div> @enderror
        <textarea name="content" placeholder="What's on your mind?" rows="3" maxlength="280"></textarea>
        <div class="create-footer">
          <div class="left-controls">
            <label class="file-label" title="Attach photo">
              <input type="file" name="photo" accept="image/*" id="post-photo">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M20 7v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7"/>
              </svg>
            </label>
            <div class="char-count" id="post-char-count">0/280</div>
          </div>
          <button type="submit" class="btn">Post</button>
        </div>
        <img id="image-preview" alt="Image preview" style="display:none"/>
      </form>
    </section>

    <section class="posts-feed">
      @forelse($posts as $post)
        <article class="post-card" id="post-{{ $post->id }}" data-post-id="{{ $post->id }}">
          <div class="post-top">
            <div class="avatar">{{ mb_substr($post->user->name, 0, 1) }}</div>
            <div class="meta">
              <div class="name">{{ $post->user->name }}</div>
              <div class="time">{{ $post->created_at->diffForHumans() }}</div>
            </div>
          </div>
          <div class="post-body">
            <p>{{ $post->content }}</p>
            @if($post->photo_path)
              <img src="{{ asset('storage/' . $post->photo_path) }}" alt="Post image" class="post-img" loading="lazy"/>
            @endif
          </div>
          <div class="post-actions">
            <button class="action-btn like-btn {{ Auth::check() && $post->isLikedBy(Auth::id()) ? 'active' : '' }}"
                    data-post-id="{{ $post->id }}">
              <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="{{ Auth::check() && $post->isLikedBy(Auth::id()) ? '#FF0000' : 'currentColor' }}">
                <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
              </svg>
              <span class="count-like">{{ $post->likes()->where('type', 'like')->count() }}</span>
            </button>
            <button class="action-btn dislike-btn {{ Auth::check() && $post->isDislikedBy(Auth::id()) ? 'active' : '' }}"
                    data-post-id="{{ $post->id }}">
              <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="{{ Auth::check() && $post->isDislikedBy(Auth::id()) ? '#000000' : 'currentColor' }}">
                <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
              </svg>
              <span class="count-dislike">{{ $post->likes()->where('type', 'dislike')->count() }}</span>
            </button>
            <button class="action-btn comment-toggle" data-post-id="{{ $post->id }}" data-count="{{ $post->allComments()->count() }}">
              <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#0000FF">
                <path d="M240-400h480v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z"/>
              </svg>
              <span class="comment-count">{{ $post->allComments()->count() }}</span> Comments
            </button>
            <span class="action-btn view-count" data-post-id="{{ $post->id }}" data-action="{{ route('posts.views', $post) }}">
              <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#696969"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/>
              </svg>
              <span class="count-view">{{ $post->views }}</span> Views
            </span>
            @can('delete', $post)
              <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-form">
                @csrf @method('DELETE')
                <button type="submit" class="action-btn delete-btn">Delete</button>
              </form>
            @endcan
          </div>
          <div class="comments" id="comments-{{ $post->id }}" style="display:none">
            @foreach($post->comments as $comment)
              <div class="comment" style="margin-left: {{ $comment->parent_id ? '20px' : '0' }}">
                <div class="comment-head">
                  <strong>{{ $comment->user->name }}</strong>
                  <span class="time">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p>{{ $comment->content }}</p>
                @if($comment->replies)
                  @foreach($comment->replies as $reply)
                    <div class="comment reply" style="margin-left: 40px">
                      <div class="comment-head">
                        <strong>{{ $reply->user->name }}</strong>
                        <span class="time">{{ $reply->created_at->diffForHumans() }}</span>
                      </div>
                      <p>{{ $reply->content }}</p>
                    </div>
                  @endforeach
                @endif
                <form action="{{ route('posts.comment', $post) }}" method="POST" class="comment-form" style="margin-left: {{ $comment->parent_id ? '20px' : '0' }}">
                  @csrf
                  <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                  <input type="text" name="content" placeholder="Reply to this comment..." required>
                  <button type="submit" class="btn">Reply</button>
                </form>
              </div>
            @endforeach
            <form action="{{ route('posts.comment', $post) }}" method="POST" class="comment-form">
              @csrf
              <input type="hidden" name="parent_id" value="">
              <input type="text" name="content" placeholder="Write a comment..." required>
              <button type="submit" class="btn">Comment</button>
            </form>
          </div>
        </article>
      @empty
        <p class="empty">No posts yet. Be the first to post!</p>
      @endforelse
    </section>
  </main>
</div>

<style>
  :root { --bg: #f8f9fa; --text: #1a1a1a; --accent: #2563eb; --muted: #6b7280; --card-bg: #fff; --border: #e5e7eb; --radius: 8px; --shadow: 0 2px 10px rgba(0,0,0,0.05); --transition: 0.2s ease; }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; }
  #fitlife-container { display: flex; min-height: 100vh; }
  #sidebar { width: 240px; background: var(--card-bg); padding: 24px; border-right: 1px solid var(--border); position: fixed; height: 100vh; overflow-y: auto; }
  .sidebar-header { margin-bottom: 24px; }
  .sidebar-header h2 { font-size: 1.5rem; font-weight: 600; }
  .nav-menu a, .nav-menu button { display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: var(--text); text-decoration: none; font-size: 0.95rem; border-radius: var(--radius); transition: var(--transition); }
  .nav-menu a svg, .nav-menu button svg { width: 20px; height: 20px; stroke: var(--muted); }
  .nav-menu a:hover, .nav-menu button:hover { background: var(--bg); color: var(--accent); }
  .nav-menu a:hover svg, .nav-menu button:hover svg { stroke: var(--accent); }
  .nav-menu a.active { background: var(--accent); color: #fff; }
  .nav-menu a.active svg { stroke: #fff; }
  .nav-menu button { background: none; border: none; cursor: pointer; width: 100%; text-align: left; }
  main { margin-left: 240px; padding: 24px; flex: 1; max-width: 980px; }
  #mobile-toggle { display: none; position: fixed; top: 16px; left: 16px; background: var(--accent); color: #fff; border: none; padding: 8px; border-radius: var(--radius); cursor: pointer; }
  header h1 { font-size: 1.75rem; font-weight: 600; margin-bottom: 24px; }
  .alert { padding: 10px; margin-bottom: 20px; border-radius: var(--radius); }
  .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
  .create-post { background: var(--card-bg); padding: 16px; border-radius: var(--radius); border: 1px solid var(--border); margin-bottom: 20px; }
  .create-post textarea { width: 100%; border: 1px solid var(--border); border-radius: 8px; padding: 10px; resize: none; font-size: 1rem; }
  .create-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 10px; }
  .file-label { display: inline-flex; align-items: center; gap: 8px; cursor: pointer; color: var(--muted); }
  .char-count { margin-left: 8px; color: var(--muted); font-size: 0.9rem; }
  .char-count.exceeded { color: #dc3545; }
  #image-preview { display: none; max-width: 100%; margin-top: 10px; border-radius: 8px; }
  .post-card { background: var(--card-bg); border: 1px solid var(--border); padding: 14px; border-radius: 12px; margin-bottom: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
  .post-top { display: flex; gap: 12px; align-items: center; margin-bottom: 8px; }
  .avatar { width: 44px; height: 44px; border-radius: 50%; background: var(--accent); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 600; }
  .meta .name { font-weight: 600; }
  .meta .time { color: var(--muted); font-size: 0.85rem; }
  .post-img { width: 100%; border-radius: 10px; margin-top: 8px; }
  .post-actions { display: flex; gap: 10px; align-items: center; margin-top: 10px; flex-wrap: wrap; }
  .action-btn { display: inline-flex; align-items: center; gap: 8px; background: none; border: none; padding: 6px 10px; border-radius: 8px; cursor: pointer; color: var(--muted); }
  .action-btn svg { width: 24px; height: 24px; }
  .action-btn.active { color: var(--muted); }
  .like-btn.active svg { fill: #FF0000; }
  .dislike-btn.active svg { fill: #000000; }
  .view-count { display: inline-flex; align-items: center; gap: 8px; color: var(--muted); }
  .inline-form { display: inline-block; margin: 0; }
  .comments { margin-top: 12px; border-top: 1px solid var(--border); padding-top: 12px; }
  .comment.reply { border-left: 2px solid var(--border); padding-left: 10px; }
  .comment-head { display: flex; justify-content: space-between; color: var(--muted); font-size: 0.9rem; }
  .comment-form { display: flex; gap: 8px; margin-top: 8px; }
  .comment-form input[type="text"] { flex: 1; padding: 8px; border: 1px solid var(--border); border-radius: 8px; }
  .btn { background: var(--accent); color: #fff; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; }
  .btn:disabled { background: #6c757d; cursor: not-allowed; }
  .empty { color: var(--muted); text-align: center; padding: 12px; }
  @media (max-width: 768px) {
    #sidebar { position: fixed; transform: translateX(-100%); transition: var(--transition); }
    #sidebar.active { transform: translateX(0); }
    main { margin-left: 0; }
    #mobile-toggle { display: block; }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const mobileToggle = document.getElementById('mobile-toggle'), sidebar = document.getElementById('sidebar');
    if (mobileToggle) {
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
    }

    const postForm = document.getElementById('post-form');
    if (postForm) {
        const textarea = postForm.querySelector('textarea'), submitBtn = postForm.querySelector('.btn');
        const postCharCount = document.getElementById('post-char-count'), postPhoto = document.getElementById('post-photo');
        const imagePreview = document.getElementById('image-preview');
        if (textarea && postCharCount) {
            textarea.addEventListener('input', () => {
                const len = textarea.value.length;
                postCharCount.textContent = `${len}/280`;
                postCharCount.classList.toggle('exceeded', len > 280);
                submitBtn.disabled = len > 280;
            });
        }
        if (postPhoto && imagePreview) {
            postPhoto.addEventListener('change', () => {
                const file = postPhoto.files[0];
                imagePreview.src = file && file.type.startsWith('image/') ? URL.createObjectURL(file) : '';
                imagePreview.style.display = file && file.type.startsWith('image/') ? 'block' : 'none';
            });
        }
        postForm.addEventListener('submit', async e => {
            e.preventDefault();
            if (submitBtn.disabled) return;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Отправка...';
            try {
                const res = await axios.post(postForm.action, new FormData(postForm));
                alert(res.data.success);
                window.location.reload();
            } catch (err) {
                console.error('Ошибка поста:', err);
                alert('Не удалось создать пост. Попробуйте снова.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Post';
            }
        });
    }

    document.querySelectorAll('.comment-toggle').forEach(btn =>
        btn.addEventListener('click', () => {
            const box = document.getElementById(`comments-${btn.dataset.postId}`);
            if (box) box.style.display = box.style.display === 'block' ? 'none' : 'block';
        })
    );

    document.querySelectorAll('.like-btn, .dislike-btn').forEach(btn =>
        btn.addEventListener('click', async () => {
            if (btn.disabled) return;
            btn.disabled = true;
            const postCard = btn.closest('.post-card');
            const likeBtn = postCard.querySelector('.like-btn');
            const dislikeBtn = postCard.querySelector('.dislike-btn');
            const likeSpan = postCard.querySelector('.count-like');
            const dislikeSpan = postCard.querySelector('.count-dislike');
            const isLike = btn.classList.contains('like-btn');
            const type = isLike ? 'like' : 'dislike';
            const action = `{{ route('posts.toggleReaction', ':postId') }}`.replace(':postId', btn.dataset.postId);

            const wasActive = btn.classList.contains('active');
            if (wasActive) {
                btn.classList.remove('active');
                btn.querySelector('svg').setAttribute('fill', 'currentColor');
                (isLike ? likeSpan : dislikeSpan).textContent = parseInt((isLike ? likeSpan : dislikeSpan).textContent) - 1;
            } else {
                if (likeBtn.classList.contains('active')) {
                    likeBtn.classList.remove('active');
                    likeBtn.querySelector('svg').setAttribute('fill', 'currentColor');
                    likeSpan.textContent = parseInt(likeSpan.textContent) - 1;
                } else if (dislikeBtn.classList.contains('active')) {
                    dislikeBtn.classList.remove('active');
                    dislikeBtn.querySelector('svg').setAttribute('fill', 'currentColor');
                    dislikeSpan.textContent = parseInt(dislikeSpan.textContent) - 1;
                }
                btn.classList.add('active');
                btn.querySelector('svg').setAttribute('fill', isLike ? '#FF0000' : '#000000');
                (isLike ? likeSpan : dislikeSpan).textContent = parseInt((isLike ? likeSpan : dislikeSpan).textContent) + 1;
            }

            try {
                const res = await axios.post(action, { type, _token: document.querySelector('meta[name="csrf-token"]')?.content || '' });
                likeSpan.textContent = res.data.likeCount;
                dislikeSpan.textContent = res.data.dislikeCount;
                likeBtn.classList.toggle('active', res.data.type === 'like');
                likeBtn.querySelector('svg').setAttribute('fill', res.data.type === 'like' ? '#FF0000' : 'currentColor');
                dislikeBtn.classList.toggle('active', res.data.type === 'dislike');
                dislikeBtn.querySelector('svg').setAttribute('fill', res.data.type === 'dislike' ? '#000000' : 'currentColor');
            } catch (err) {
                console.error('Ошибка реакции:', err);
                alert(err.response?.data?.error || 'Не удалось обновить реакцию. Попробуйте снова.');
                window.location.reload();
            } finally {
                btn.disabled = false;
            }
        })
    );

    document.querySelectorAll('.comment-form').forEach(form =>
        form.addEventListener('submit', async e => {
            e.preventDefault();
            const submitBtn = form.querySelector('.btn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Отправка...';
            try {
                const res = await axios.post(form.action, new FormData(form));
                const { comment } = res.data;
                const commentsDiv = form.closest('.comments');
                const isReply = comment.parent_id;
                const commentDiv = document.createElement('div');
                commentDiv.className = `comment${isReply ? ' reply' : ''}`;
                commentDiv.style.marginLeft = isReply ? '40px' : (form.style.marginLeft || '0');
                commentDiv.innerHTML = `
                    <div class="comment-head">
                        <strong>${comment.user_name}</strong>
                        <span class="time">${comment.created_at}</span>
                    </div>
                    <p>${comment.content}</p>
                `;
                if (isReply) {
                    const parentComment = form.closest('.comment');
                    parentComment.insertBefore(commentDiv, form);
                } else {
                    commentsDiv.insertBefore(commentDiv, form);
                }
                form.querySelector('input[name="content"]').value = '';
                const commentToggle = document.querySelector(`.comment-toggle[data-post-id="${form.closest('.post-card').dataset.postId}"]`);
                const commentCount = commentToggle.querySelector('.comment-count');
                commentCount.textContent = parseInt(commentCount.textContent) + 1;
            } catch (err) {
                console.error('Ошибка комментария:', err);
                alert('Не удалось добавить комментарий. Попробуйте снова.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Comment';
            }
        })
    );

    const posts = document.querySelectorAll('.post-card'), viewedPosts = new Set();
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const postId = entry.target.dataset.postId;
                if (!viewedPosts.has(postId)) {
                    viewedPosts.add(postId);
                    axios.post(`{{ route('posts.view', ':postId') }}`.replace(':postId', postId), {
                        _token: document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }).then(res => {
                        const viewSpan = entry.target.querySelector('.count-view');
                        if (viewSpan && res.data.views !== undefined) viewSpan.textContent = res.data.views;
                    }).catch(err => console.error('Ошибка просмотра:', err));
                }
            }
        });
    }, { root: null, threshold: 0.5 });
    posts.forEach(post => observer.observe(post));

    const updateViewCounts = () => {
        Array.from(posts).filter(post => {
            const rect = post.getBoundingClientRect();
            return rect.top >= 0 && rect.bottom <= window.innerHeight;
        }).forEach(post => {
            axios.get(`{{ route('posts.views', ':postId') }}`.replace(':postId', post.dataset.postId))
                .then(res => {
                    const viewSpan = post.querySelector('.count-view');
                    if (viewSpan && res.data.views !== undefined) viewSpan.textContent = res.data.views;
                })
                .catch(err => console.error('Ошибка обновления просмотров:', err));
        });
    };
    setInterval(updateViewCounts, 5000);
    updateViewCounts();
});
</script>
@endsection