@extends('layouts.app')

@section('content')
    <!-- Main container for community layout -->
    <div id="fitlife-container">
        <!-- Main content area -->
        <main id="main-content">
            <!-- Mobile menu toggle button -->
            <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <!-- Header -->
            <header>
                <h1>Community</h1>
            </header>

            <!-- Alert container for messages -->
            <div class="alert-container" style="display: none;"></div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Create post section -->
            <section class="create-post">
                <form id="post-form" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @error('content') <div class="error">{{ $message }}</div> @enderror
                    @error('photo') <div class="error">{{ $message }}</div> @enderror
                    <textarea name="content" placeholder="What's on your mind?" rows="3" maxlength="1000"></textarea>
                    <div class="create-footer">
                        <div class="left-controls">
                            <label class="file-label" title="Attach photo">
                                <input type="file" name="photo" accept="image/*" id="post-photo">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                                    <path d="M160-160q-33 0-56.5-23.5T80-240v-400q0-33 23.5-56.5T160-720h240l80-80h320q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm73-280h207v-207L233-440Zm-73-40 160-160H160v160Zm0 120v120h640v-480H520v280q0 33-23.5 56.5T440-360H160Zm280-160Z"/>
                                </svg>
                            </label>
                            <div class="char-count" id="post-char-count">0/1000</div>
                        </div>
                        <button type="submit" class="btn">Post</button>
                    </div>
                    <div class="preview-container" style="position: relative; display: none;">
                        <img id="image-preview" alt="Image preview" />
                        <button id="remove-photo" type="button" aria-label="Remove photo">×</button>
                    </div>
                </form>
            </section>

            <!-- Posts feed section -->
            <section class="posts-feed">
                @forelse($posts as $post)
                    <article class="post-card" id="post-{{ $post->id }}" data-post-id="{{ $post->id }}">
                        <div class="post-top">
                            <div class="avatar">
                                <img src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : asset('storage/logo/defaultPhoto.jpg') }}"
                                     alt="{{ $post->user->name }}'s Avatar">
                            </div>
                            <div class="meta">
                                <a href="{{ route('profile.show', $post->user->id) }}" class="name">{{ $post->user->name }}</a>
                                <div class="time">{{ $post->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="post-body" id="post-body-{{ $post->id }}">
                            <p>{{ $post->content }}</p>
                            @if($post->photo_path)
                                <img src="{{ asset('storage/' . $post->photo_path) }}" alt="Post image" class="post-img" loading="lazy" />
                            @endif
                        </div>
                        <!-- Edit post form, hidden initially -->
                        <form id="edit-post-form-{{ $post->id }}" action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" style="display: none;">
                            @csrf
                            @method('PUT')
                            <textarea name="content" rows="3" maxlength="1000">{{ $post->content }}</textarea>
                            <div class="preview-container" style="position: relative;">
                                @if($post->photo_path)
                                    <img id="edit-image-preview-{{ $post->id }}" src="{{ asset('storage/' . $post->photo_path) }}" alt="Image preview" />
                                    <button type="button" class="remove-photo" data-post-id="{{ $post->id }}">×</button>
                                @else
                                    <img id="edit-image-preview-{{ $post->id }}" alt="Image preview" style="display: none;" />
                                @endif
                            </div>
                            <label class="file-label" title="Attach photo">
                                <input type="file" name="photo" accept="image/*" class="edit-post-photo">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                                    <path d="M160-160q-33 0-56.5-23.5T80-240v-400q0-33 23.5-56.5T160-720h240l80-80h320q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm73-280h207v-207L233-440Zm-73-40 160-160H160v160Zm0 120v120h640v-480H520v280q0 33-23.5 56.5T440-360H160Zm280-160Z"/>
                                </svg>
                            </label>
                            <button type="submit" class="btn">Save</button>
                            <button type="button" class="btn cancel-edit" data-post-id="{{ $post->id }}">Cancel</button>
                        </form>
                        <div class="post-actions">
                            <button class="action-btn like-btn {{ Auth::check() && $post->likes()->where('user_id', Auth::id())->where('type', 'like')->exists() ? 'active' : '' }}"
                                    data-post-id="{{ $post->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"
                                     fill="{{ Auth::check() && $post->likes()->where('user_id', Auth::id())->where('type', 'like')->exists() ? '#ef4444' : 'currentColor' }}">
                                    <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
                                </svg>
                                <span class="count-like">{{ $post->likes()->where('type', 'like')->count() }}</span>
                            </button>
                            <button class="action-btn dislike-btn {{ Auth::check() && $post->likes()->where('user_id', Auth::id())->where('type', 'dislike')->exists() ? 'active' : '' }}"
                                    data-post-id="{{ $post->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"
                                     fill="{{ Auth::check() && $post->likes()->where('user_id', Auth::id())->where('type', 'dislike')->exists() ? '#111827' : 'currentColor' }}">
                                    <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
                                </svg>
                                <span class="count-dislike">{{ $post->likes()->where('type', 'dislike')->count() }}</span>
                            </button>
                            <button class="action-btn comment-toggle" data-post-id="{{ $post->id }}"
                                    data-count="{{ $post->comments()->count() }}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                                    <path d="M240-400h480v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z"/>
                                </svg>
                                <span class="comment-count">{{ $post->comments()->count() }}</span> Comments
                            </button>
                            <span class="view-count">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#6b7280">
                                    <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/>
                                </svg>
                                <span class="count-view">{{ $post->views }}</span> Views
                            </span>
                            @can('update', $post)
                                <button type="button" class="action-btn edit-post-btn" data-post-id="{{ $post->id }}">Edit</button>
                            @endcan
                            @can('delete', $post)
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-form delete-post-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn delete-btn">Delete</button>
                                </form>
                            @endcan
                        </div>
                        <!-- Comments section -->
                        <div class="comments" id="comments-{{ $post->id }}" style="display:none">
                            @foreach($post->comments as $comment)
                                <div class="comment" id="comment-{{ $comment->id }}" data-comment-id="{{ $comment->id }}" style="margin-left: {{ $comment->parent_id ? '20px' : '0' }};">
                                    <div class="comment-head">
                                        <strong>{{ $comment->user->name }}</strong>
                                        <span class="time">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="comment-body">
                                        <p>{{ $comment->content }}</p>
                                    </div>
                                    <!-- Edit comment form, hidden initially -->
                                    <form id="edit-comment-form-{{ $comment->id }}" action="{{ route('comments.update', $comment) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="content" rows="2" maxlength="500">{{ $comment->content }}</textarea>
                                        <button type="submit" class="btn">Save</button>
                                        <button type="button" class="btn cancel-edit-comment" data-comment-id="{{ $comment->id }}">Cancel</button>
                                    </form>
                                    <div class="comment-actions">
                                        <button class="action-btn like-btn {{ Auth::check() && $comment->likes()->where('user_id', Auth::id())->where('type', 'like')->exists() ? 'active' : '' }}"
                                                data-comment-id="{{ $comment->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"
                                                 fill="{{ Auth::check() && $comment->likes()->where('user_id', Auth::id())->where('type', 'like')->exists() ? '#ef4444' : 'currentColor' }}">
                                                <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
                                            </svg>
                                            <span class="count-like">{{ $comment->likes()->where('type', 'like')->count() }}</span>
                                        </button>
                                        <button class="action-btn dislike-btn {{ Auth::check() && $comment->likes()->where('user_id', Auth::id())->where('type', 'dislike')->exists() ? 'active' : '' }}"
                                                data-comment-id="{{ $comment->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20"
                                                 fill="{{ Auth::check() && $comment->likes()->where('user_id', Auth::id())->where('type', 'dislike')->exists() ? '#111827' : 'currentColor' }}">
                                                <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
                                            </svg>
                                            <span class="count-dislike">{{ $comment->likes()->where('type', 'dislike')->count() }}</span>
                                        </button>
                                        @can('update', $comment)
                                            <button type="button" class="action-btn edit-comment-btn" data-comment-id="{{ $comment->id }}">Edit</button>
                                        @endcan
                                        @can('delete', $comment)
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline-form delete-comment-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="action-btn delete-btn">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                    <form action="{{ route('posts.comment', $post) }}" method="POST" class="comment-form" data-post-id="{{ $post->id }}" data-parent-id="{{ $comment->id }}">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <textarea name="content" placeholder="Write a reply..." rows="1" maxlength="500"></textarea>
                                        <button type="submit" class="btn reply-btn">Reply</button>
                                    </form>
                                </div>
                            @endforeach
                            <!-- Main comment form for post -->
                            <form action="{{ route('posts.comment', $post) }}" method="POST" class="comment-form" data-post-id="{{ $post->id }}">
                                @csrf
                                <textarea name="content" placeholder="Write a comment..." rows="1" maxlength="500"></textarea>
                                <button type="submit" class="btn">Comment</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p>No posts yet.</p>
                @endforelse
            </section>
        </main>
    </div>

    <!-- Inline CSS styles -->
    <style>
        :root {
            --bg: #f9fafb;
            --text: #111827;
            --accent: #3b82f6;
            --muted: #6b7280;
            --card-bg: #ffffff;
            --border: #d1d5db;
            --radius: 12px;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --transition: 0.3s ease;
            --success: #22c55e;
            --danger: #ef4444;
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

        /* Sidebar styling */
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
            fill: #fff;
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

        header h1 {
            font-size: 1.75rem;
            font-weight: 600;
        }

        .alert-container {
            margin-bottom: 16px;
        }

        .alert {
            padding: 12px;
            border-radius: var(--radius);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .alert-success {
            background: var(--success);
            color: #fff;
        }

        .alert-error {
            background: var(--danger);
            color: #fff;
        }

        .create-post {
            background: var(--card-bg);
            padding: 16px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            margin-bottom: 24px;
        }

        .create-post textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 8px;
            resize: vertical;
            font-size: 1rem;
            margin-bottom: 8px;
        }

        .create-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .left-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .file-label {
            cursor: pointer;
        }

        .file-label input {
            display: none;
        }

        .char-count {
            font-size: 0.9rem;
            color: var(--muted);
        }

        .btn {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: var(--radius);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn:hover {
            background: #2563eb;
        }

        .preview-container {
            position: relative;
        }

        #image-preview,
        .post-img,
        [id^="edit-image-preview-"] {
            max-height: 300px;
            width: auto;
            display: block;
            margin: 0 auto 8px;
            object-fit: contain;
            border-radius: var(--radius);
        }

        #remove-photo,
        .remove-photo {
            position: absolute;
            top: 8px;
            right: 8px;
            background: var(--danger);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            font-size: 1rem;
            line-height: 24px;
            text-align: center;
            display: none;
        }

        .posts-feed {
            display: grid;
            gap: 16px;
        }

        .post-card {
            background: var(--card-bg);
            padding: 16px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
        }

        .post-top {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .avatar img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border);
        }

        .meta {
            display: flex;
            flex-direction: column;
        }

        .name {
            font-weight: 600;
            color: var(--accent);
            text-decoration: none;
        }

        .name:hover {
            text-decoration: underline;
        }

        .time {
            font-size: 0.85rem;
            color: var(--muted);
        }

        .post-body p {
            margin-bottom: 12px;
        }

        .post-actions {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-top: 12px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 4px;
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .action-btn.active,
        .action-btn:hover {
            color: var(--accent);
        }

        .count-like,
        .count-dislike,
        .count-view {
            font-weight: 500;
        }

        .view-count {
            display: flex;
            align-items: center;
            gap: 4px;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .edit-post-btn,
        .edit-comment-btn {
            color: var(--accent);
        }

        .delete-btn {
            color: var(--danger);
        }

        .comments {
            margin-top: 12px;
        }

        .comment {
            background: var(--bg);
            padding: 8px;
            border-radius: var(--radius);
            margin-top: 8px;
        }

        .comment-head {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
        }

        .comment-actions {
            display: flex;
            gap: 8px;
            margin-top: 4px;
        }

        .comment-form {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }

        .comment-form textarea {
            flex: 1;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 4px;
            font-size: 0.9rem;
        }

        .reply-btn {
            padding: 4px 8px;
        }

        .inline-form {
            display: inline;
        }

        .error {
            color: var(--danger);
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        [id^="edit-post-form-"],
        [id^="edit-comment-form-"] {
            margin-top: 8px;
        }

        .cancel-edit {
            background: var(--muted);
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

            .posts-feed {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- JavaScript for interactive features -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const mobileToggle = document.getElementById('mobile-toggle');
            const sidebar = document.getElementById('sidebar');
            const postForm = document.getElementById('post-form');
            const postPhoto = document.getElementById('post-photo');
            const imagePreview = document.getElementById('image-preview');
            const removePhoto = document.getElementById('remove-photo');
            const previewContainer = imagePreview.parentElement;
            const postCharCount = document.getElementById('post-char-count');
            const postTextarea = postForm.querySelector('textarea[name="content"]');
            const alertContainer = document.querySelector('.alert-container');

            // Local storage for viewed posts
            let viewedPosts = new Set(JSON.parse(localStorage.getItem('viewedPosts') || '[]'));

            // Show alert message
            function showAlert(message, type) {
                alertContainer.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
                alertContainer.style.display = 'block';
                setTimeout(() => {
                    alertContainer.style.display = 'none';
                    alertContainer.innerHTML = '';
                }, 5000);
            }

            // Fetch with retry
            async function fetchWithRetry(url, options, retries = 3, delay = 1000) {
                for (let i = 0; i < retries; i++) {
                    try {
                        const controller = new AbortController();
                        const timeoutId = setTimeout(() => controller.abort(), 20000);
                        const response = await fetch(url, { ...options, signal: controller.signal });
                        clearTimeout(timeoutId);
                        if (!response.ok) {
                            const errorText = await response.text();
                            throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
                        }
                        return await response.json();
                    } catch (error) {
                        if (i === retries - 1) throw error;
                        await new Promise(resolve => setTimeout(resolve, delay * Math.pow(2, i)));
                    }
                }
            }

            // Mobile toggle
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

            // Image preview and remove
            postPhoto.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        previewContainer.style.display = 'block';
                        removePhoto.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.style.display = 'none';
                    removePhoto.style.display = 'none';
                }
            });

            removePhoto.addEventListener('click', function () {
                postPhoto.value = '';
                previewContainer.style.display = 'none';
                removePhoto.style.display = 'none';
            });

            // Character count
            postTextarea.addEventListener('input', function () {
                postCharCount.textContent = `${this.value.length}/1000`;
            });

            // Toggle comments
            document.querySelectorAll('.comment-toggle').forEach(button => {
                button.addEventListener('click', function () {
                    const postId = this.dataset.postId;
                    const comments = document.getElementById(`comments-${postId}`);
                    comments.style.display = comments.style.display === 'none' ? 'block' : 'none';
                });
            });

            // Post like/dislike
            document.querySelectorAll('.post-card .like-btn, .post-card .dislike-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const postId = this.dataset.postId;
                    const type = this.classList.contains('like-btn') ? 'like' : 'dislike';
                    fetchWithRetry(`/posts/${postId}/reaction`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ type })
                    }).then(data => {
                        const likeBtn = button.closest('.post-actions').querySelector('.like-btn');
                        const dislikeBtn = button.closest('.post-actions').querySelector('.dislike-btn');
                        likeBtn.classList.toggle('active', data.type === 'like');
                        dislikeBtn.classList.toggle('active', data.type === 'dislike');
                        likeBtn.querySelector('.count-like').textContent = data.likeCount;
                        dislikeBtn.querySelector('.count-dislike').textContent = data.dislikeCount;
                        likeBtn.querySelector('svg').setAttribute('fill', data.type === 'like' ? '#ef4444' : 'currentColor');
                        dislikeBtn.querySelector('svg').setAttribute('fill', data.type === 'dislike' ? '#111827' : 'currentColor');
                    }).catch(error => {
                        showAlert('Failed to update reaction.', 'error');
                    });
                });
            });

            // Comment like/dislike
            document.querySelectorAll('.comment .like-btn, .comment .dislike-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const commentId = this.dataset.commentId;
                    const type = this.classList.contains('like-btn') ? 'like' : 'dislike';
                    fetchWithRetry(`/comments/${commentId}/toggle-reaction`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ type })
                    }).then(data => {
                        const likeBtn = button.closest('.comment-actions').querySelector('.like-btn');
                        const dislikeBtn = button.closest('.comment-actions').querySelector('.dislike-btn');
                        likeBtn.classList.toggle('active', data.type === 'like');
                        dislikeBtn.classList.toggle('active', data.type === 'dislike');
                        likeBtn.querySelector('.count-like').textContent = data.likeCount;
                        dislikeBtn.querySelector('.count-dislike').textContent = data.dislikeCount;
                        likeBtn.querySelector('svg').setAttribute('fill', data.type === 'like' ? '#ef4444' : 'currentColor');
                        dislikeBtn.querySelector('svg').setAttribute('fill', data.type === 'dislike' ? '#111827' : 'currentColor');
                    }).catch(error => {
                        showAlert('Failed to update comment reaction.', 'error');
                    });
                });
            });

            // Auto view count with IntersectionObserver
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const postId = entry.target.dataset.postId;
                        if (!viewedPosts.has(postId)) {
                            const timer = setTimeout(() => {
                                fetchWithRetry(`/posts/${postId}/views`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                }).then(data => {
                                    entry.target.querySelector('.count-view').textContent = data.views;
                                    viewedPosts.add(postId);
                                    localStorage.setItem('viewedPosts', JSON.stringify([...viewedPosts]));
                                }).catch(error => {
                                    console.error('Error incrementing view:', error);
                                });
                            }, 5000);
                            entry.target.dataset.viewTimer = timer;
                        }
                    } else {
                        clearTimeout(entry.target.dataset.viewTimer);
                    }
                });
            }, { threshold: 0.5 });

            document.querySelectorAll('.post-card').forEach(post => {
                observer.observe(post);
            });

            // Post creation
            postForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetchWithRetry(this.action, {
                    method: 'POST',
                    body: formData
                }).then(data => {
                    if (data.success) {
                        showAlert(data.success, 'success');
                        this.reset();
                        previewContainer.style.display = 'none';
                        removePhoto.style.display = 'none';
                        postCharCount.textContent = '0/1000';

                        // Add new post to feed
                        const postsFeed = document.querySelector('.posts-feed');
                        const newPost = document.createElement('article');
                        newPost.className = 'post-card';
                        newPost.id = `post-${data.post.id}`;
                        newPost.dataset.postId = data.post.id;
                        newPost.innerHTML = `
                            <div class="post-top">
                                <div class="avatar">
                                    <img src="${data.post.user.avatar ? '/storage/' + data.post.user.avatar : '/storage/logo/defaultPhoto.jpg'}" alt="${data.post.user.name}'s Avatar">
                                </div>
                                <div class="meta">
                                    <a href="${data.post.user.profile_url}" class="name">${data.post.user.name}</a>
                                    <div class="time">just now</div>
                                </div>
                            </div>
                            <div class="post-body" id="post-body-${data.post.id}">
                                <p>${data.post.content}</p>
                                ${data.post.photo_path ? `<img src="/storage/${data.post.photo_path}" alt="Post image" class="post-img" loading="lazy" />` : ''}
                            </div>
                            <form id="edit-post-form-${data.post.id}" action="/posts/${data.post.id}" method="POST" enctype="multipart/form-data" style="display: none;">
                                @csrf
                                @method('PUT')
                                <textarea name="content" rows="3" maxlength="1000">${data.post.content}</textarea>
                                <div class="preview-container" style="position: relative;">
                                    ${data.post.photo_path ? `<img id="edit-image-preview-${data.post.id}" src="/storage/${data.post.photo_path}" alt="Image preview" />` : `<img id="edit-image-preview-${data.post.id}" alt="Image preview" style="display: none;" />`}
                                    <button type="button" class="remove-photo" data-post-id="${data.post.id}">×</button>
                                </div>
                                <label class="file-label" title="Attach photo">
                                    <input type="file" name="photo" accept="image/*" class="edit-post-photo">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                                        <path d="M160-160q-33 0-56.5-23.5T80-240v-400q0-33 23.5-56.5T160-720h240l80-80h320q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm73-280h207v-207L233-440Zm-73-40 160-160H160v160Zm0 120v120h640v-480H520v280q0 33-23.5 56.5T440-360H160Zm280-160Z"/>
                                    </svg>
                                </label>
                                <button type="submit" class="btn">Save</button>
                                <button type="button" class="btn cancel-edit" data-post-id="${data.post.id}">Cancel</button>
                            </form>
                            <div class="post-actions">
                                <button class="action-btn like-btn" data-post-id="${data.post.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="currentColor">
                                        <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
                                    </svg>
                                    <span class="count-like">0</span>
                                </button>
                                <button class="action-btn dislike-btn" data-post-id="${data.post.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="currentColor">
                                        <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
                                    </svg>
                                    <span class="count-dislike">0</span>
                                </button>
                                <button class="action-btn comment-toggle" data-post-id="${data.post.id}" data-count="0">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                                        <path d="M240-400h480v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z"/>
                                    </svg>
                                    <span class="comment-count">0</span> Comments
                                </button>
                                <span class="view-count">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#6b7280">
                                        <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/>
                                    </svg>
                                    <span class="count-view">0</span> Views
                                </span>
                                ${data.can_update ? `<button type="button" class="action-btn edit-post-btn" data-post-id="${data.post.id}">Edit</button>` : ''}
                                ${data.can_delete ? `
                                    <form action="/posts/${data.post.id}" method="POST" class="inline-form delete-post-form">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn delete-btn">Delete</button>
                                    </form>
                                ` : ''}
                            </div>
                            <div class="comments" id="comments-${data.post.id}" style="display:none">
                                <form action="/posts/${data.post.id}/comment" method="POST" class="comment-form" data-post-id="${data.post.id}">
                                    @csrf
                                    <textarea name="content" placeholder="Write a comment..." rows="1" maxlength="500"></textarea>
                                    <button type="submit" class="btn">Comment</button>
                                </form>
                            </div>
                        `;
                        postsFeed.insertBefore(newPost, postsFeed.firstChild);
                        attachPostEventListeners(newPost);
                        observer.observe(newPost);
                    } else {
                        showAlert(data.error || 'Failed to create post.', 'error');
                    }
                }).catch(error => {
                    showAlert('Failed to create post.', 'error');
                });
            });

            // Comment submission
            function attachCommentFormListeners(form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const postId = this.dataset.postId;
                    const textarea = this.querySelector('textarea');
                    if (!textarea.value.trim()) return showAlert('Please enter a comment.', 'error');

                    const formData = new FormData(this);
                    fetchWithRetry(this.action, {
                        method: 'POST',
                        body: formData
                    }).then(data => {
                        if (data.success) {
                            showAlert(data.success, 'success');
                            textarea.value = '';
                            const commentsContainer = document.getElementById(`comments-${postId}`);
                            const commentElement = document.createElement('div');
                            commentElement.className = 'comment';
                            commentElement.id = `comment-${data.comment.id}`;
                            commentElement.dataset.commentId = data.comment.id;
                            commentElement.style.marginLeft = data.comment.parent_id ? '20px' : '0';
                            commentElement.innerHTML = `
                                <div class="comment-head">
                                    <strong>${data.comment.user_name}</strong>
                                    <span class="time">just now</span>
                                </div>
                                <div class="comment-body">
                                    <p>${data.comment.content}</p>
                                </div>
                                <form id="edit-comment-form-${data.comment.id}" action="/comments/${data.comment.id}" method="POST" style="display: none;">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="content" rows="2" maxlength="500">${data.comment.content}</textarea>
                                    <button type="submit" class="btn">Save</button>
                                    <button type="button" class="btn cancel-edit-comment" data-comment-id="${data.comment.id}">Cancel</button>
                                </form>
                                <div class="comment-actions">
                                    <button class="action-btn like-btn" data-comment-id="${data.comment.id}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="currentColor">
                                            <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
                                        </svg>
                                        <span class="count-like">0</span>
                                    </button>
                                    <button class="action-btn dislike-btn" data-comment-id="${data.comment.id}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="currentColor">
                                            <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
                                        </svg>
                                        <span class="count-dislike">0</span>
                                    </button>
                                    ${data.can_update ? `<button type="button" class="action-btn edit-comment-btn" data-comment-id="${data.comment.id}">Edit</button>` : ''}
                                    ${data.can_delete ? `
                                        <form action="/comments/${data.comment.id}" method="POST" class="inline-form delete-comment-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn">Delete</button>
                                        </form>
                                    ` : ''}
                                </div>
                                <form action="/posts/${postId}/comment" method="POST" class="comment-form" data-post-id="${postId}" data-parent-id="${data.comment.id}">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="${data.comment.id}">
                                    <textarea name="content" placeholder="Write a reply..." rows="1" maxlength="500"></textarea>
                                    <button type="submit" class="btn reply-btn">Reply</button>
                                </form>
                            `;
                            const parentComment = data.comment.parent_id ? document.querySelector(`#comment-${data.comment.parent_id}`) : null;
                            if (parentComment) {
                                parentComment.insertAdjacentElement('afterend', commentElement);
                            } else {
                                commentsContainer.insertBefore(commentElement, commentsContainer.lastElementChild);
                            }
                            attachCommentEventListeners(commentElement);
                            const commentToggle = document.querySelector(`.comment-toggle[data-post-id="${postId}"]`);
                            commentToggle.querySelector('.comment-count').textContent = parseInt(commentToggle.dataset.count) + 1;
                            commentToggle.dataset.count = parseInt(commentToggle.dataset.count) + 1;
                            if (commentsContainer.style.display !== 'block') {
                                commentsContainer.style.display = 'block';
                            }
                        } else {
                            showAlert(data.error || 'Failed to add comment.', 'error');
                        }
                    }).catch(error => {
                        showAlert('Failed to add comment.', 'error');
                    });
                });
            }

            // Edit post
            function attachPostEventListeners(postElement) {
                const postId = postElement.dataset.postId;
                const editBtn = postElement.querySelector('.edit-post-btn');
                const editForm = postElement.querySelector(`#edit-post-form-${postId}`);
                const postBody = postElement.querySelector(`#post-body-${postId}`);
                const cancelEdit = postElement.querySelector(`.cancel-edit[data-post-id="${postId}"]`);
                const editPhotoInput = postElement.querySelector('.edit-post-photo');
                const editImagePreview = postElement.querySelector(`#edit-image-preview-${postId}`);
                const removeEditPhoto = postElement.querySelector(`.remove-photo[data-post-id="${postId}"]`);

                if (editBtn) {
                    editBtn.addEventListener('click', () => {
                        postBody.style.display = 'none';
                        editForm.style.display = 'block';
                        if (editImagePreview.src && editImagePreview.src !== window.location.origin + '/storage/logo/defaultPhoto.jpg') {
                            removeEditPhoto.style.display = 'block';
                        }
                    });
                }

                if (cancelEdit) {
                    cancelEdit.addEventListener('click', () => {
                        postBody.style.display = 'block';
                        editForm.style.display = 'none';
                        editImagePreview.src = postElement.querySelector('.post-img') ? postElement.querySelector('.post-img').src : '';
                        removeEditPhoto.style.display = editImagePreview.src ? 'block' : 'none';
                        editPhotoInput.value = '';
                    });
                }

                if (editPhotoInput) {
                    editPhotoInput.addEventListener('change', function () {
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                editImagePreview.src = e.target.result;
                                editImagePreview.style.display = 'block';
                                removeEditPhoto.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }

                if (removeEditPhoto) {
                    removeEditPhoto.addEventListener('click', function () {
                        editPhotoInput.value = '';
                        editImagePreview.style.display = 'none';
                        removeEditPhoto.style.display = 'none';
                    });
                }

                // Edit post submission
                editForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    fetchWithRetry(this.action, {
                        method: 'POST',
                        body: formData
                    }).then(data => {
                        if (data.success) {
                            showAlert(data.success, 'success');
                            postBody.innerHTML = `
                                <p>${data.post.content}</p>
                                ${data.post.photo_path ? `<img src="/storage/${data.post.photo_path}" alt="Post image" class="post-img" loading="lazy" />` : ''}
                            `;
                            postBody.style.display = 'block';
                            editForm.style.display = 'none';
                        } else {
                            showAlert(data.error || 'Failed to update post.', 'error');
                        }
                    }).catch(error => {
                        showAlert('Failed to update post.', 'error');
                    });
                });

                // Delete post
                const deleteForm = postElement.querySelector('.delete-post-form');
                if (deleteForm) {
                    deleteForm.addEventListener('submit', function (e) {
                        e.preventDefault();
                        if (confirm('Are you sure you want to delete this post?')) {
                            fetchWithRetry(this.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: new FormData(this)
                            }).then(data => {
                                if (data.success) {
                                    showAlert(data.success, 'success');
                                    postElement.remove();
                                } else {
                                    showAlert(data.error || 'Failed to delete post.', 'error');
                                }
                            }).catch(error => {
                                showAlert('Failed to delete post.', 'error');
                            });
                        }
                    });
                }
            }

            // Edit comment
            function attachCommentEventListeners(commentElement) {
                const commentId = commentElement.dataset.commentId;
                const editBtn = commentElement.querySelector('.edit-comment-btn');
                const editForm = commentElement.querySelector(`#edit-comment-form-${commentId}`);
                const commentBody = commentElement.querySelector('.comment-body');
                const cancelEdit = commentElement.querySelector(`.cancel-edit-comment[data-comment-id="${commentId}"]`);

                if (editBtn) {
                    editBtn.addEventListener('click', () => {
                        commentBody.style.display = 'none';
                        editForm.style.display = 'block';
                    });
                }

                if (cancelEdit) {
                    cancelEdit.addEventListener('click', () => {
                        commentBody.style.display = 'block';
                        editForm.style.display = 'none';
                    });
                }

                // Edit comment submission
                if (editForm) {
                    editForm.addEventListener('submit', function (e) {
                        e.preventDefault();
                        const formData = new FormData(this);
                        fetchWithRetry(this.action, {
                            method: 'POST',
                            body: formData
                        }).then(data => {
                            if (data.success) {
                                showAlert(data.success, 'success');
                                commentBody.innerHTML = `<p>${data.comment.content}</p>`;
                                commentBody.style.display = 'block';
                                editForm.style.display = 'none';
                            } else {
                                showAlert(data.error || 'Failed to update comment.', 'error');
                            }
                        }).catch(error => {
                            showAlert('Failed to update comment.', 'error');
                        });
                    });
                }

                // Delete comment
                const deleteForm = commentElement.querySelector('.delete-comment-form');
                if (deleteForm) {
                    deleteForm.addEventListener('submit', function (e) {
                        e.preventDefault();
                        if (confirm('Are you sure you want to delete this comment?')) {
                            fetchWithRetry(this.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: new FormData(this)
                            }).then(data => {
                                if (data.success) {
                                    showAlert(data.success, 'success');
                                    commentElement.remove();
                                    const postId = commentElement.closest('.post-card').dataset.postId;
                                    const commentToggle = document.querySelector(`.comment-toggle[data-post-id="${postId}"]`);
                                    commentToggle.querySelector('.comment-count').textContent = parseInt(commentToggle.dataset.count) - 1;
                                    commentToggle.dataset.count = parseInt(commentToggle.dataset.count) - 1;
                                } else {
                                    showAlert(data.error || 'Failed to delete comment.', 'error');
                                }
                            }).catch(error => {
                                showAlert('Failed to delete comment.', 'error');
                            });
                        }
                    });
                }

                // Comment like/dislike
                const likeBtn = commentElement.querySelector('.like-btn');
                const dislikeBtn = commentElement.querySelector('.dislike-btn');
                if (likeBtn) {
                    likeBtn.addEventListener('click', function () {
                        const commentId = this.dataset.commentId;
                        fetchWithRetry(`/comments/${commentId}/toggle-reaction`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ type: 'like' })
                        }).then(data => {
                            likeBtn.classList.toggle('active', data.type === 'like');
                            dislikeBtn.classList.toggle('active', data.type === 'dislike');
                            likeBtn.querySelector('.count-like').textContent = data.likeCount;
                            dislikeBtn.querySelector('.count-dislike').textContent = data.dislikeCount;
                            likeBtn.querySelector('svg').setAttribute('fill', data.type === 'like' ? '#ef4444' : 'currentColor');
                            dislikeBtn.querySelector('svg').setAttribute('fill', data.type === 'dislike' ? '#111827' : 'currentColor');
                        }).catch(error => {
                            showAlert('Failed to update comment reaction.', 'error');
                        });
                    });
                }

                if (dislikeBtn) {
                    dislikeBtn.addEventListener('click', function () {
                        const commentId = this.dataset.commentId;
                        fetchWithRetry(`/comments/${commentId}/toggle-reaction`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ type: 'dislike' })
                        }).then(data => {
                            likeBtn.classList.toggle('active', data.type === 'like');
                            dislikeBtn.classList.toggle('active', data.type === 'dislike');
                            likeBtn.querySelector('.count-like').textContent = data.likeCount;
                            dislikeBtn.querySelector('.count-dislike').textContent = data.dislikeCount;
                            likeBtn.querySelector('svg').setAttribute('fill', data.type === 'like' ? '#ef4444' : 'currentColor');
                            dislikeBtn.querySelector('svg').setAttribute('fill', data.type === 'dislike' ? '#111827' : 'currentColor');
                        }).catch(error => {
                            showAlert('Failed to update comment reaction.', 'error');
                        });
                    });
                }
            }

            // Attach listeners to existing posts and comments
            document.querySelectorAll('.post-card').forEach(post => {
                attachPostEventListeners(post);
                post.querySelectorAll('.comment').forEach(comment => {
                    attachCommentEventListeners(comment);
                });
                post.querySelectorAll('.comment-form').forEach(form => {
                    attachCommentFormListeners(form);
                });
            });

            // Infinite scroll for posts
            let page = 2;
            let loading = false;
            window.addEventListener('scroll', () => {
                if (loading || document.querySelector('.posts-feed').childElementCount === 0) return;
                if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                    loading = true;
                    fetchWithRetry(`/posts?page=${page}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(data => {
                        if (data.posts && data.posts.length > 0) {
                            const postsFeed = document.querySelector('.posts-feed');
                            data.posts.forEach(post => {
                                const postElement = document.createElement('article');
                                postElement.className = 'post-card';
                                postElement.id = `post-${post.id}`;
                                postElement.dataset.postId = post.id;
                                postElement.innerHTML = `
                                    <div class="post-top">
                                        <div class="avatar">
                                            <img src="${post.user.avatar ? '/storage/' + post.user.avatar : '/storage/logo/defaultPhoto.jpg'}" alt="${post.user.name}'s Avatar">
                                        </div>
                                        <div class="meta">
                                            <a href="${post.user.profile_url}" class="name">${post.user.name}</a>
                                            <div class="time">${post.created_at_diff}</div>
                                        </div>
                                    </div>
                                    <div class="post-body" id="post-body-${post.id}">
                                        <p>${post.content}</p>
                                        ${post.photo_path ? `<img src="/storage/${post.photo_path}" alt="Post image" class="post-img" loading="lazy" />` : ''}
                                    </div>
                                    <form id="edit-post-form-${post.id}" action="/posts/${post.id}" method="POST" enctype="multipart/form-data" style="display: none;">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="content" rows="3" maxlength="1000">${post.content}</textarea>
                                        <div class="preview-container" style="position: relative;">
                                            ${post.photo_path ? `<img id="edit-image-preview-${post.id}" src="/storage/${post.photo_path}" alt="Image preview" />` : `<img id="edit-image-preview-${post.id}" alt="Image preview" style="display: none;" />`}
                                            <button type="button" class="remove-photo" data-post-id="${post.id}">×</button>
                                        </div>
                                        <label class="file-label" title="Attach photo">
                                            <input type="file" name="photo" accept="image/*" class="edit-post-photo">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                                                <path d="M160-160q-33 0-56.5-23.5T80-240v-400q0-33 23.5-56.5T160-720h240l80-80h320q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm73-280h207v-207L233-440Zm-73-40 160-160H160v160Zm0 120v120h640v-480H520v280q0 33-23.5 56.5T440-360H160Zm280-160Z"/>
                                            </svg>
                                        </label>
                                        <button type="submit" class="btn">Save</button>
                                        <button type="button" class="btn cancel-edit" data-post-id="${post.id}">Cancel</button>
                                    </form>
                                    <div class="post-actions">
                                        <button class="action-btn like-btn ${post.user_liked ? 'active' : ''}" data-post-id="${post.id}">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="${post.user_liked ? '#ef4444' : 'currentColor'}">
                                                <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
                                            </svg>
                                            <span class="count-like">${post.like_count}</span>
                                        </button>
                                        <button class="action-btn dislike-btn ${post.user_disliked ? 'active' : ''}" data-post-id="${post.id}">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="${post.user_disliked ? '#111827' : 'currentColor'}">
                                                <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
                                            </svg>
                                            <span class="count-dislike">${post.dislike_count}</span>
                                        </button>
                                        <button class="action-btn comment-toggle" data-post-id="${post.id}" data-count="${post.comment_count}">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                                                <path d="M240-400h480v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z"/>
                                            </svg>
                                            <span class="comment-count">${post.comment_count}</span> Comments
                                        </button>
                                        <span class="view-count">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#6b7280">
                                                <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/>
                                            </svg>
                                            <span class="count-view">${post.views}</span> Views
                                        </span>
                                        ${post.can_update ? `<button type="button" class="action-btn edit-post-btn" data-post-id="${post.id}">Edit</button>` : ''}
                                        ${post.can_delete ? `
                                            <form action="/posts/${post.id}" method="POST" class="inline-form delete-post-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="action-btn delete-btn">Delete</button>
                                            </form>
                                        ` : ''}
                                    </div>
                                    <div class="comments" id="comments-${post.id}" style="display:none">
                                        ${post.comments.map(comment => `
                                            <div class="comment" id="comment-${comment.id}" data-comment-id="${comment.id}" style="margin-left: ${comment.parent_id ? '20px' : '0'};">
                                                <div class="comment-head">
                                                    <strong>${comment.user_name}</strong>
                                                    <span class="time">${comment.created_at_diff}</span>
                                                </div>
                                                <div class="comment-body">
                                                    <p>${comment.content}</p>
                                                </div>
                                                <form id="edit-comment-form-${comment.id}" action="/comments/${comment.id}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="content" rows="2" maxlength="500">${comment.content}</textarea>
                                                    <button type="submit" class="btn">Save</button>
                                                    <button type="button" class="btn cancel-edit-comment" data-comment-id="${comment.id}">Cancel</button>
                                                </form>
                                                <div class="comment-actions">
                                                    <button class="action-btn like-btn ${comment.user_liked ? 'active' : ''}" data-comment-id="${comment.id}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="${comment.user_liked ? '#ef4444' : 'currentColor'}">
                                                            <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
                                                        </svg>
                                                        <span class="count-like">${comment.like_count}</span>
                                                    </button>
                                                    <button class="action-btn dislike-btn ${comment.user_disliked ? 'active' : ''}" data-comment-id="${comment.id}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="${comment.user_disliked ? '#111827' : 'currentColor'}">
                                                            <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
                                                        </svg>
                                                        <span class="count-dislike">${comment.dislike_count}</span>
                                                    </button>
                                                    ${comment.can_update ? `<button type="button" class="action-btn edit-comment-btn" data-comment-id="${comment.id}">Edit</button>` : ''}
                                                    ${comment.can_delete ? `
                                                        <form action="/comments/${comment.id}" method="POST" class="inline-form delete-comment-form">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="action-btn delete-btn">Delete</button>
                                                        </form>
                                                    ` : ''}
                                                </div>
                                                <form action="/posts/${post.id}/comment" method="POST" class="comment-form" data-post-id="${post.id}" data-parent-id="${comment.id}">
                                                    @csrf
                                                    <input type="hidden" name="parent_id" value="${comment.id}">
                                                    <textarea name="content" placeholder="Write a reply..." rows="1" maxlength="500"></textarea>
                                                    <button type="submit" class="btn reply-btn">Reply</button>
                                                </form>
                                            </div>
                                        `).join('')}
                                        <form action="/posts/${post.id}/comment" method="POST" class="comment-form" data-post-id="${post.id}">
                                            @csrf
                                            <textarea name="content" placeholder="Write a comment..." rows="1" maxlength="500"></textarea>
                                            <button type="submit" class="btn">Comment</button>
                                        </form>
                                    </div>
                                `;
                                postsFeed.appendChild(postElement);
                                attachPostEventListeners(postElement);
                                postElement.querySelectorAll('.comment').forEach(comment => {
                                    attachCommentEventListeners(comment);
                                });
                                postElement.querySelectorAll('.comment-form').forEach(form => {
                                    attachCommentFormListeners(form);
                                });
                                observer.observe(postElement);
                            });
                            page++;
                            loading = false;
                        } else {
                            loading = false;
                        }
                    }).catch(error => {
                        showAlert('', 'error');
                        loading = false;
                    });
                }
            });
        });
    </script>
@endsection