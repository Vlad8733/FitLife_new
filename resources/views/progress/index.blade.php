@extends('layouts.app')

@section('content')
<!-- Font Awesome CDN for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="dashboard-main" id="dashboard-main">
    <!-- Menu Button -->
    <button class="menu-btn" id="menu-toggle"><i class="fas fa-bars"></i> Menu</button>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1><span>FitLife</span> Progress Photos</h1>
        <p>Track your transformation and stay motivated!</p>
    </div>

    <!-- Add Progress Photo -->
    <div class="biography-card">
        <h3><i class="fas fa-plus"></i> Add New Photo</h3>
        <form action="{{ route('progress.store') }}" method="POST" enctype="multipart/form-data" class="form-logging">
            @csrf
            <div class="form-group">
                <label>Photo:</label>
                <input type="file" name="photo" required>
            </div>
            <div class="form-group">
                <label>Description:</label>
                <input type="text" name="description" placeholder="Description">
            </div>
            <button type="submit" class="calculate-btn">Add Photo</button>
        </form>
    </div>

    <!-- List Progress Photos -->
    <div class="photos-grid">
        @forelse($progressPhotos as $progress)
            <div class="photo-card">
                <img src="{{ asset('storage/' . $progress->photo) }}" alt="Progress Photo">
                <div class="photo-description">{{ $progress->description ?? 'No description' }}</div>
                <div class="photo-date">Uploaded: {{ $progress->created_at->format('M d, Y H:i') }}</div>
                <form action="{{ route('progress.update', $progress->id) }}" method="POST" class="form-logging">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label>Update Description:</label>
                        <input type="text" name="description" value="{{ $progress->description }}" placeholder="Description">
                    </div>
                    <button type="submit" class="calculate-btn update-btn">Update</button>
                </form>
                <form action="{{ route('progress.destroy', $progress->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="calculate-btn delete-btn">Delete</button>
                </form>
            </div>
        @empty
            <p class="no-data">No progress photos yet.</p>
        @endforelse
    </div>
</div>

<!-- Sidebar -->
<div class="side-menu" id="side-menu">
    <h3>Navigation</h3>
    <ul>
        <li><a href="{{ route('dashboard') }}"><i class="fas fa-home nav-icon"></i> Home</a></li>
        <li><a href="{{ route('foods.index') }}"><i class="fas fa-utensils nav-icon"></i> Meal Tracker</a></li>
        <li><a href="{{ route('sleep.index') }}"><i class="fas fa-bed nav-icon"></i> Sleep Tracker</a></li>
        <li><a href="{{ route('water.index') }}"><i class="fas fa-tint nav-icon"></i> Water Tracker</a></li>
        <li><a href="{{ route('progress.index') }}" class="active"><i class="fas fa-camera nav-icon"></i> Progress Photos</a></li>
        <li><a href="{{ route('goals.index') }}"><i class="fas fa-bullseye nav-icon"></i> Goals</a></li>
        <li><a href="{{ route('calories.index') }}"><i class="fas fa-calculator nav-icon"></i> Calorie Calculator</a></li>
        <li><a href="{{ route('biography.edit') }}"><i class="fas fa-user-edit nav-icon"></i> Biography</a></li>
        <li><a href="{{ route('profile.edit') }}"><i class="fas fa-cog nav-icon"></i> Profile</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"><i class="fas fa-sign-out-alt nav-icon"></i> Log Out</button>
            </form>
        </li>
    </ul>
</div>

<!-- Lightbox -->
<div id="lightbox">
    <div id="lightbox-content">
        <img id="lightbox-img" src="" alt="">
        <div id="lightbox-info">
            <p id="lightbox-date"></p>
            <p id="lightbox-desc"></p>
        </div>
    </div>
</div>

<style>
/* --- General Reset & Base --- */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Inter', sans-serif;
}

body {
    background: linear-gradient(135deg, #0d1117 0%, #1c2526 100%);
    color: #e6e6fa;
    min-height: 100vh;
    overflow-x: hidden;
}

a {
    text-decoration: none;
    color: inherit;
}

button {
    cursor: pointer;
    border: none;
    background: none;
    font-family: inherit;
}

/* --- Dashboard Layout --- */
.dashboard-main {
    padding: 2.5rem;
    transition: margin-right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    z-index: 1;
}

/* --- Menu Button --- */
.menu-btn {
    position: fixed;
    top: 20px;
    right: 20px;
    background: linear-gradient(135deg, #d4af37, #b8860b);
    color: #1c2526;
    padding: 0.8rem 1.2rem;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(216, 175, 55, 0.4);
    z-index: 1001;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.menu-btn:hover {
    background: linear-gradient(135deg, #b8860b, #a67c00);
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(216, 175, 55, 0.6);
}

.menu-btn i {
    margin-right: 0.5rem;
}

/* --- Sidebar --- */
.side-menu {
    position: fixed;
    top: 0;
    right: -300px;
    width: 300px;
    height: 100vh;
    background: rgba(13, 17, 23, 0.95);
    backdrop-filter: blur(12px);
    border-left: 1px solid rgba(216, 175, 55, 0.3);
    padding: 2rem 1.5rem;
    transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
    overflow-y: auto;
}

.side-menu.active {
    right: 0;
}

.side-menu h3 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #48c9b0;
    margin-bottom: 1.5rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.side-menu ul {
    list-style: none;
}

.side-menu ul li {
    margin-bottom: 0.5rem;
}

.side-menu ul li a,
.side-menu ul li button {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 1rem 1.2rem;
    border-radius: 10px;
    color: #e6e6fa;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.side-menu ul li a:hover,
.side-menu ul li button:hover {
    background: rgba(72, 201, 176, 0.2);
    color: #48c9b0;
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(72, 201, 176, 0.3);
}

.side-menu ul li a.active {
    background: rgba(216, 175, 55, 0.2);
    color: #d4af37;
}

.nav-icon {
    margin-right: 0.8rem;
    font-size: 1.2rem;
}

/* --- Dashboard Header --- */
.dashboard-header {
    text-align: center;
    margin-bottom: 3rem;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 16px;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    animation: fadeIn 0.8s ease-out;
}

.dashboard-header h1 {
    font-size: 3rem;
    font-weight: 800;
    color: #48c9b0;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 8px rgba(72, 201, 176, 0.3);
}

.dashboard-header h1 span {
    font-weight: 300;
    color: #a3bffa;
}

.dashboard-header p {
    font-size: 1.2rem;
    color: #a3bffa;
    font-weight: 400;
}

/* --- Form --- */
.biography-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(72, 201, 176, 0.3);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.biography-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 32px rgba(72, 201, 176, 0.2);
    border-color: #48c9b0;
}

.biography-card h3 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #48c9b0;
    margin-bottom: 1.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-logging {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-size: 1.1rem;
    color: #e6e6fa;
    font-weight: 600;
}

.form-group input {
    padding: 0.6rem;
    border-radius: 8px;
    border: 1px solid rgba(216, 175, 55, 0.3);
    background: rgba(255, 255, 255, 0.05);
    color: #e6e6fa;
    font-size: 0.95rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-group input:focus {
    outline: none;
    border-color: #48c9b0;
    box-shadow: 0 0 0 2px rgba(72, 201, 176, 0.3);
}

.form-group input::placeholder {
    color: #a3bffa;
}

.calculate-btn {
    background: linear-gradient(135deg, #d4af37, #b8860b);
    color: #1c2526;
    padding: 0.8rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.calculate-btn:hover {
    background: linear-gradient(135deg, #b8860b, #a67c00);
    transform: scale(1.03);
    box-shadow: 0 4px 12px rgba(216, 175, 55, 0.3);
}

.update-btn {
    background: linear-gradient(135deg, #48c9b0, #2e856e);
}

.update-btn:hover {
    background: linear-gradient(135deg, #2e856e, #1a6450);
    box-shadow: 0 4px 12px rgba(72, 201, 176, 0.3);
}

.delete-btn {
    background: linear-gradient(135deg, #ff6b6b, #e64a1f);
}

.delete-btn:hover {
    background: linear-gradient(135deg, #e64a1f, #cc3a1a);
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
}

/* --- Photos Grid --- */
.photos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.photo-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(216, 175, 55, 0.3);
    border-radius: 12px;
    padding: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.photo-card:hover {
    transform: scale(1.03);
    box-shadow: 0 8px 20px rgba(216, 175, 55, 0.3);
    border-color: #d4af37;
}

.photo-card img {
    width: 100%;
    height: 200px;
    border-radius: 8px;
    object-fit: cover;
    cursor: pointer;
    transition: all 0.3s ease;
}

.photo-card img:hover {
    filter: brightness(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.photo-description {
    font-size: 0.95rem;
    color: #a3bffa;
    margin-top: 0.8rem;
    font-style: italic;
}

.photo-date {
    font-size: 0.85rem;
    color: #6b7280;
    margin-top: 0.5rem;
}

.no-data {
    text-align: center;
    color: #6b7280;
    font-size: 1rem;
    padding: 1rem;
}

/* --- Lightbox --- */
#lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(8px);
    justify-content: center;
    align-items: center;
    z-index: 2000;
    animation: fadeIn 0.4s ease;
}

#lightbox-content {
    max-width: 90%;
    max-height: 90%;
    text-align: center;
}

#lightbox-img {
    max-width: 100%;
    max-height: 70vh;
    border: 1px solid #d4af37;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(216, 175, 55, 0.3);
    transition: transform 0.3s ease;
}

#lightbox-content:hover #lightbox-img {
    transform: scale(1.02);
}

#lightbox-info p {
    color: #e6e6fa;
    margin: 0.5rem 0;
    font-size: 1.1rem;
}

#lightbox-info #lightbox-desc {
    color: #a3bffa;
    font-style: italic;
}

/* --- Animations --- */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* --- Responsive --- */
@media (max-width: 768px) {
    .dashboard-main {
        padding: 1.5rem;
    }
    .photos-grid {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1rem;
    }
    .photo-card img {
        height: 160px;
    }
    .side-menu {
        width: 100%;
        right: -100%;
    }
    .side-menu.active {
        right: 0;
    }
    .dashboard-header h1 {
        font-size: 2.2rem;
    }
    .menu-btn {
        top: 15px;
        right: 15px;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .dashboard-header {
        padding: 1rem;
    }
    .biography-card, .photo-card {
        padding: 1rem;
    }
}

/* --- Accessibility --- */
@media (prefers-reduced-motion: reduce) {
    .biography-card, .photo-card, .menu-btn, .side-menu, .calculate-btn, #lightbox-img {
        transition: none;
    }
}

@media (prefers-contrast: high) {
    .biography-card, .photo-card {
        border: 2px solid #fff;
    }
    .side-menu ul li a.active, .calculate-btn {
        background: #fff;
        color: #1c2526;
    }
    .form-group input {
        border: 1px solid #fff;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Sidebar Toggle
    const menuBtn = document.getElementById('menu-toggle');
    const sideMenu = document.getElementById('side-menu');
    const dashboardMain = document.getElementById('dashboard-main');

    menuBtn.addEventListener('click', () => {
        sideMenu.classList.toggle('active');
        const open = sideMenu.classList.contains('active');
        dashboardMain.style.marginRight = open ? '300px' : '0';
        menuBtn.style.right = open ? '320px' : '20px';
    });

    document.addEventListener('click', (e) => {
        if (!sideMenu.contains(e.target) && !menuBtn.contains(e.target)) {
            sideMenu.classList.remove('active');
            dashboardMain.style.marginRight = '0';
            menuBtn.style.right = '20px';
        }
    });

    // Accessibility
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            sideMenu.classList.remove('active');
            dashboardMain.style.marginRight = '0';
            menuBtn.style.right = '20px';
            lightbox.style.display = 'none';
        }
    });

    // Lightbox
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
        });
    });

    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) {
            lightbox.style.display = 'none';
        }
    });
});
</script>
@endsection