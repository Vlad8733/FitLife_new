@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/posts.css') }}" rel="stylesheet">
@endsection

@section('content')
<main id="main-content">
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
                    <div class="username" style="color: #6b7280; font-size: 0.85rem;">{{ '@'.$post->user->username }}</div>
                    <div class="time">{{ $post->created_at->diffForHumans() }}</div>
                </div>
            </div>

            <div class="post-body" id="post-body-{{ $post->id }}">
                <p>{{ $post->content }}</p>
                @if($post->photo_path)
                    <img src="{{ asset('storage/' . $post->photo_path) }}" alt="Post image" class="post-img" loading="lazy" />
                @endif
            </div>

            <!-- Edit post form -->
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

            <!-- Post actions -->
            <div class="post-actions">
                <button class="action-btn like-btn {{ Auth::check() && $post->likes()->where('user_id', Auth::id())->where('type', 'like')->exists() ? 'active' : '' }}" data-post-id="{{ $post->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" 
                         fill="{{ Auth::check() && $post->likes()->where('user_id', Auth::id())->where('type', 'like')->exists() ? '#ef4444' : 'currentColor' }}">
                        <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/>
                    </svg>
                    <span class="count-like">{{ $post->likes()->where('type', 'like')->count() }}</span>
                </button>

                <button class="action-btn dislike-btn {{ Auth::check() && $post->likes()->where('user_id', Auth::id())->where('type', 'dislike')->exists() ? 'active' : '' }}" data-post-id="{{ $post->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" 
                         fill="{{ Auth::check() && $post->likes()->where('user_id', Auth::id())->where('type', 'dislike')->exists() ? '#ffffffff' : 'currentColor' }}">
                        <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z"/>
                    </svg>
                    <span class="count-dislike">{{ $post->likes()->where('type', 'dislike')->count() }}</span>
                </button>

                <button class="action-btn comment-toggle" data-post-id="{{ $post->id }}" data-count="{{ $post->allComments()->count() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#3b82f6">
                        <path d="M240-400h480v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z"/>
                    </svg>
                    <span class="comment-count">{{ $post->allComments()->count() }}</span> Comments
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

            <!-- Comments -->
            <div class="comments" id="comments-{{ $post->id }}" style="display:none">
                @foreach($post->comments as $comment)
                @include('posts.partials.comment', ['comment' => $comment, 'post' => $post])
                @endforeach

                <!-- Main comment form for post -->
                <form action="{{ route('posts.comment', $post) }}" method="POST" class="comment-form" data-post-id="{{ $post->id }}">
                    @csrf
                    <textarea name="content" placeholder="Write a comment..." rows="1" maxlength="500"></textarea>
                    <button type="submit" class="btn"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#006400"><path d="M120-160v-640l760 320-760 320Zm80-120 474-200-474-200v140l240 60-240 60v140Zm0 0v-400 400Z"/></svg></button>
                </form>
            </div>
        </article>
        @empty
        <p>No posts yet.</p>
        @endforelse
    </section>
</main>
@endsection

@section('scripts')
<script src="{{ asset('js/posts.js') }}"></script>
@endsection