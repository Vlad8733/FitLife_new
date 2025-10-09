@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/show.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="fitlife-container" role="application" aria-label="FitLife User Profile">
    <main id="main-content">

        <!-- ================= User Profile Header ================= -->
        <header class="header">
            <h1 class="header__title">{{ $user->name }}'s Profile</h1>
            <p class="header__username">{{ '@'.$user->username }}</p>
        </header>

        <!-- ================= User Profile Details ================= -->
        <section aria-labelledby="user-profile-heading">
            <div class="profile-card">
                <!-- Banner + Avatar -->
                <div class="banner-section">
                    @if($user->banner)
                        <img src="{{ asset('storage/' . $user->banner) . '?t=' . time() }}"
                             alt="{{ $user->name }}'s Banner"
                             class="banner-section__image">
                    @endif
                    <div class="avatar-section">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) . '?t=' . time() : asset('storage/logo/defaultPhoto.jpg') }}"
                             alt="{{ $user->name }}'s Profile Photo"
                             class="avatar-section__image">
                    </div>
                </div>

                <!-- Profile Info -->
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

        <!-- ================= User Posts (Просмотры только) ================= -->
        <section class="posts-feed" aria-labelledby="user-posts-heading">
            <h3 id="user-posts-heading">{{ $user->name }}'s Posts</h3>

            @forelse($user->posts as $post)
                <article class="post-card" id="post-{{ $post->id }}" data-post-id="{{ $post->id }}">

                    <!-- Post header -->
                    <div class="post-top">
                        <div class="post-top__avatar">
                            <img src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) . '?t=' . time() : asset('storage/logo/defaultPhoto.jpg') }}"
                                 alt="{{ $post->user->name }}'s Avatar">
                        </div>
                        <div class="post-meta">
                            <a href="{{ route('profile.show', $post->user->id) }}" class="post-meta__name">
                                {{ $post->user->name }} <span class="post-meta__username">{{ '@'.$post->user->username }}</span>
                            </a>
                            <div class="post-meta__time">{{ $post->created_at->diffForHumans() }}</div>
                        </div>
                    </div>

                    <!-- Post content -->
                    <div class="post-body">
                        <p>{{ $post->content }}</p>
                        @if($post->photo_path)
                            <img src="{{ asset('storage/' . $post->photo_path) }}" alt="Post image" class="post-body__image" loading="lazy">
                        @endif
                    </div>

                    <!-- Post views only -->
                    <div class="post-actions">
                        <span class="post-actions__button view-count" data-post-id="{{ $post->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#696969">
                                <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/>
                            </svg>
                            <span class="post-actions__count count-view">{{ $post->views }}</span> Views
                        </span>
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