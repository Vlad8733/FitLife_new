@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/show.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="fitlife-container" role="application" aria-label="FitLife User Profile">
    <main id="main-content">
        <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <header>
            <h1>{{ $user->name }}'s Profile</h1>
        </header>

        <section aria-labelledby="user-profile-heading">
            <div class="profile-card">
                @if($user->banner)
                    <div class="banner-section">
                        <img src="{{ asset('storage/' . $user->banner) . '?t=' . time() }}"
                             alt="{{ $user->name }}'s Banner"
                             class="banner-preview">
                        <div class="avatar-section">
                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) . '?t=' . time() : asset('storage/logo/defaultPhoto.jpg') }}"
                                 alt="{{ $user->name }}'s Profile Photo"
                                 class="avatar-preview">
                        </div>
                    </div>
                @else
                    <div class="avatar-section">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) . '?t=' . time() : asset('storage/logo/defaultPhoto.jpg') }}"
                             alt="{{ $user->name }}'s Profile Photo"
                             class="avatar-preview">
                    </div>
                @endif
                <h3 id="user-profile-heading">Profile Details</h3>
                <div class="bio-details">
                    <p><strong>Full Name:</strong> {{ $user->biography->full_name ?? 'Not set' }}</p>
                    <p><strong>Age:</strong> {{ $user->biography->age ?? 'Not set' }}</p>
                    <p><strong>Height:</strong> {{ $user->biography->height ?? 'Not set' }} cm</p>
                    <p><strong>Weight:</strong> {{ $user->biography->weight ?? 'Not set' }} kg</p>
                    <p><strong>Gender:</strong> {{ $user->biography->gender ?? 'Not set' }}</p>
                </div>
            </div>
        </section>

        <section class="posts-feed" aria-labelledby="user-posts-heading">
            <h3 id="user-posts-heading">{{ $user->name }}'s Posts</h3>
            @forelse($user->posts as $post)
                <article class="post-card" id="post-{{ $post->id }}" data-post-id="{{ $post->id }}">
                    <div class="post-top">
                        <div class="avatar">
                            <img src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) . '?t=' . time() : asset('storage/logo/defaultPhoto.jpg') }}"
                                 alt="{{ $post->user->name }}'s Avatar"
                                 style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border);">
                        </div>
                        <div class="meta">
                            <a href="{{ route('profile.show', $post->user->id) }}" class="name">{{ $post->user->name }}</a>
                            <div class="time">{{ $post->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <div class="post-body">
                        <p>{{ $post->content }}</p>
                        @if($post->photo_path)
                            <img src="{{ asset('storage/' . $post->photo_path) }}" alt="Post image" class="post-img" loading="lazy" />
                        @endif
                    </div>
                    <div class="post-actions">
                        <button class="action-btn like-btn {{ Auth::check() && $post->isLikedBy(Auth::id()) ? 'active' : '' }}"
                                data-post-id="{{ $post->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                 fill="{{ Auth::check() && $post->isLikedBy(Auth::id()) ? '#FF0000' : 'currentColor' }}">
                                <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z" />
                            </svg>
                            <span class="count-like">{{ $post->likes()->where('type', 'like')->count() }}</span>
                        </button>
                        <button class="action-btn dislike-btn {{ Auth::check() && $post->isDislikedBy(Auth::id()) ? 'active' : '' }}"
                                data-post-id="{{ $post->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                 fill="{{ Auth::check() && $post->isDislikedBy(Auth::id()) ? '#000000' : 'currentColor' }}">
                                <path d="M240-840h440v520L400-40l-50-50q-7-7-11.5-19t-4.5-23v-14l44-174H120q-32 0-56-24t-24-56v-80q0-7 2-15t4-15l120-282q9-20 30-34t44-14Zm360 80H240L120-480v80h360l-54 220 174-174v-406Zm0 406v-406 406Zm80 34v-80h120v-360H680v-80h200v520H680Z" />
                            </svg>
                            <span class="count-dislike">{{ $post->likes()->where('type', 'dislike')->count() }}</span>
                        </button>
                        <button class="action-btn comment-toggle" data-post-id="{{ $post->id }}"
                                data-count="{{ $post->allComments()->count() }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#0000FF">
                                <path d="M240-400h480v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM880-80 720-240H160q-33 0-56.5-23.5T80-320v-480q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v720ZM160-320h594l46 45v-525H160v480Zm0 0v-480 480Z" />
                            </svg>
                            <span class="comment-count">{{ $post->allComments()->count() }}</span> Comments
                        </button>
                        <span class="action-btn view-count" data-post-id="{{ $post->id }}"
                              data-action="{{ route('posts.views', $post) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#696969">
                                <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z" />
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
                                <form action="{{ route('posts.comment', $post) }}" method="POST" class="comment-form">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    <textarea name="content" placeholder="Write a reply..." rows="1" maxlength="500"></textarea>
                                    <button type="submit" class="btn reply-btn">Reply</button>
                                </form>
                            </div>
                        @endforeach
                        <form action="{{ route('posts.comment', $post) }}" method="POST" class="comment-form">
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
@endsection

@section('scripts')
    <script src="{{ asset('js/show.js') }}"></script>
@endsection