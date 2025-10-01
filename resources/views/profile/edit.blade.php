@extends('layouts.app')

@section('content')
  <div id="fitlife-container" role="application" aria-label="FitLife Profile Settings">
    <main id="main-content">
      <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>

      <header><h1>Profile Settings</h1></header>

      @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
      @endif

      <section aria-labelledby="profile-settings-heading">
        <div class="profile-card">
          <h3 id="profile-settings-heading">Update Profile</h3>

          <div class="profile-banner">
            <div class="banner-bg" style="background-image: url('{{ $user->banner ? asset("storage/{$user->banner}") : asset('storage/banner/default-banner.jpg') }}');">
              <img
                src="{{ $user->avatar ? asset("storage/{$user->avatar}") : asset('storage/logo/defaultPhoto.jpg') }}"
                alt="Profile Photo"
                class="banner-avatar"
                id="bannerAvatar"
              >
              <label for="banner" class="change-banner-label">Change Banner</label>
            </div>
          </div>

          <form action="{{ route('profile.update') }}" method="POST" class="profile-form" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-grid">
              <div class="form-group">
                <label for="banner">Banner Image</label>
                <input type="file" id="banner" name="banner" accept="image/*" style="display: none;">
                @error('banner')
                  <p class="error-text">{{ $message }}</p>
                @enderror
              </div>

              <div class="form-group">
                <label for="avatar">Profile Photo</label>
                <input type="file" id="avatar" name="avatar" accept="image/*">
                @error('avatar')
                  <p class="error-text">{{ $message }}</p>
                @enderror
              </div>

              <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required aria-required="true" aria-describedby="name-error">
                @error('name')
                  <p id="name-error" class="error-text">{{ $message }}</p>
                @enderror
              </div>

              <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required aria-required="true" aria-describedby="email-error">
                @error('email')
                  <p id="email-error" class="error-text">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <button type="submit" class="save-btn">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                <path d="M17 21v-8H7v8"/>
                <path d="M7 3v5h8"/>
              </svg>
              Save Profile
            </button>
          </form>
        </div>

        <div class="profile-card">
          <h3>Update Password</h3>
          <form action="{{ route('password.update') }}" method="POST" class="profile-form">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="current_password">Current Password</label>
              <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
              <label for="password">New Password</label>
              <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
              <label for="password_confirmation">Confirm Password</label>
              <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="save-btn">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                <path d="M17 21v-8H7v8"/>
                <path d="M7 3v5h8"/>
              </svg>
              Update Password
            </button>
          </form>
        </div>

        <div class="profile-card">
          <h3>Delete Account</h3>
          <form action="{{ route('profile.destroy') }}" method="POST" class="profile-form">
            @csrf
            @method('DELETE')
            <p class="muted">This action cannot be undone. Permanently delete your account?</p>
            <button type="submit" class="delete-btn">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2M6 6v15a2 2 0 002 2h8a2 2 0 002-2V6M10 11v6M14 11v6"/>
              </svg>
              Delete Account
            </button>
          </form>
        </div>
      </section>
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
      --danger: #dc2626; 
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; }
    #fitlife-container { display: flex; min-height: 100vh; }
    #sidebar { width: 240px; background: var(--card-bg); padding: 24px; border-right: 1px solid var(--border); position: fixed; height: 100vh; overflow-y: auto; }
    .sidebar-header { margin-bottom: 24px; }
    .sidebar-header h2 { font-size: 1.5rem; font-weight: 600; }
    .sidebar-header p { font-size: 0.9rem; color: var(--muted); }
    .nav-menu a, .nav-menu button { display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: var(--text); text-decoration: none; font-size: 0.95rem; border-radius: var(--radius); transition: var(--transition); }
    .nav-menu a svg, .nav-menu button svg { width: 20px; height: 20px; stroke: var(--muted); }
    .nav-menu a:hover, .nav-menu button:hover { background: var(--bg); color: var(--accent); }
    .nav-menu a:hover svg, .nav-menu button:hover svg { stroke: var(--accent); }
    .nav-menu a.active { background: var(--accent); color: #fff; }
    .nav-menu a.active svg { stroke: #fff; }
    .nav-menu button { background: none; border: none; cursor: pointer; width: 100%; text-align: left; }
    main { margin-left: 240px; padding: 32px; flex: 1; }
    #mobile-toggle { display: none; position: fixed; top: 16px; left: 16px; background: var(--accent); color: #fff; border: none; padding: 8px; border-radius: var(--radius); cursor: pointer; }
    #mobile-toggle svg { width: 20px; height: 20px; }
    header { margin-bottom: 32px; }
    header h1 { font-size: 1.75rem; font-weight: 600; }
    h3 { font-size: 1.25rem; font-weight: 600; margin-bottom: 16px; }
    .profile-card { background: var(--card-bg); padding: 24px; border-radius: var(--radius); border: 1px solid var(--border); margin-bottom: 24px; box-shadow: var(--shadow); }
    .profile-form { display: flex; flex-wrap: wrap; gap: 24px; }
    .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; width: 100%; }
    .form-group { flex: 1; }
    .form-group label { display: block; font-size: 0.95rem; font-weight: 500; margin-bottom: 8px; color: var(--muted); }
    .form-group input { width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: var(--radius); font-size: 0.95rem; transition: var(--transition); }
    .form-group input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2); }
    .save-btn { display: inline-flex; align-items: center; gap: 8px; background: var(--accent); color: #fff; border: none; padding: 12px 20px; border-radius: var(--radius); font-size: 0.95rem; cursor: pointer; transition: var(--transition); }
    .save-btn svg { width: 20px; height: 20px; stroke: #fff; }
    .save-btn:hover { background: #1d4ed8; }
    .delete-btn { display: inline-flex; align-items: center; gap: 8px; background: var(--danger); color: #fff; border: none; padding: 12px 20px; border-radius: var(--radius); font-size: 0.95rem; cursor: pointer; transition: var(--transition); }
    .delete-btn svg { width: 20px; height: 20px; stroke: #fff; }
    .delete-btn:hover { background: #b91c1c; }
    .alert.alert-success { background: #e6ffed; color: #2e7d32; padding: 12px; border-radius: var(--radius); margin-bottom: 24px; font-size: 0.9rem; }
    .error-text { color: var(--danger); font-size: 0.85rem; margin-top: 6px; }

    .profile-banner {
      position: relative;
      height: 250px;
      margin-bottom: 24px;
      overflow: hidden;
      border-radius: var(--radius);
    }
    .banner-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      filter: brightness(0.8);
    }
    .banner-avatar {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #fff;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .change-banner-label {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: #fff;
      font-size: 1.2rem;
      font-weight: 500;
      opacity: 0;
      transition: opacity 0.3s ease;
      cursor: pointer;
      background: rgba(0, 0, 0, 0.6);
      padding: 10px 20px;
      border-radius: 6px;
    }
    .banner-bg:hover .change-banner-label {
      opacity: 1;
    }

    @media (max-width: 768px) {
      #sidebar { position: fixed; transform: translateX(-100%); transition: var(--transition); }
      #sidebar.active { transform: translateX(0); }
      main { margin-left: 0; padding: 24px; }
      #mobile-toggle { display: block; }
      header { flex-direction: column; align-items: flex-start; }
      .profile-banner { height: 200px; }
      .banner-avatar { width: 100px; height: 100px; }
    }
    @media (max-width: 480px) {
      .profile-form { flex-direction: column; gap: 16px; }
      .form-grid { grid-template-columns: 1fr; gap: 16px; }
      .form-group { min-width: 100%; }
      .save-btn, .delete-btn { width: 100%; }
      .profile-banner { height: 150px; }
      .banner-avatar { width: 80px; height: 80px; }
    }
  </style>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const mobileToggle = document.getElementById('mobile-toggle');
      const sidebar = document.getElementById('sidebar');

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
        }
      });

      const avatarInput = document.getElementById('avatar');
      const bannerAvatar = document.getElementById('bannerAvatar');
      avatarInput.addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
          const url = URL.createObjectURL(file);
          bannerAvatar.src = url;
        }
      });

      const bannerInput = document.getElementById('banner');
      const changeBannerLabel = document.querySelector('.change-banner-label');
      changeBannerLabel.addEventListener('click', () => {
        bannerInput.click();
      });

      bannerInput.addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            document.querySelector('.banner-bg').style.backgroundImage = `url(${e.target.result})`;
          };
          reader.readAsDataURL(file);
        }
      });
    });
  </script>
@endsection