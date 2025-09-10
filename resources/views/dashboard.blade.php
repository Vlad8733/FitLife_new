@extends('layouts.app')

@section('content')
<div class="dashboard-main" id="dashboard-main">
    <!-- Menu Button -->
    <button class="menu-btn" id="menu-toggle">☰ Menu</button>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1><span>Welcome to</span> FitLife</h1>
        <p>Track your health & progress in one place.</p>
    </div>

    <!-- Motivation Quote -->
    <div class="motivation" id="motivation"></div>

    <!-- Biography -->
    <div class="biography-card">
        <h3>Your Biography</h3>
        @php $bio = Auth::user()->biography; @endphp
        <p><strong>Name:</strong> {{ $bio->full_name ?? Auth::user()->name }}</p>
        <p><strong>Age:</strong> {{ $bio->age ?? 'Not set' }}</p>
        <p><strong>Height:</strong> {{ $bio->height ?? 'Not set' }} cm</p>
        <p><strong>Weight:</strong> {{ $bio->weight ?? 'Not set' }} kg</p>
        <p><strong>Gender:</strong> {{ ucfirst($bio->gender ?? 'Not set') }}</p>
    </div>

    <!-- KPIs -->
    <div class="kpi-container">
        <div class="kpi-card"><h3>Total Calories</h3><p>{{ $totalCalories ?? 0 }}</p></div>
        <div class="kpi-card"><h3>Total Sleep (h)</h3><p>{{ round($totalSleep ?? 0, 1) }}</p></div>
        <div class="kpi-card"><h3>Total Water (ml)</h3><p>{{ $totalWater ?? 0 }}</p></div>
    </div>

    <!-- Histories -->
    <div class="history-section">
        <h2>🍽 Meal History</h2>
        <div id="meal-history-wrapper">@include('profile.partials.meal_table')</div>
    </div>
    <div class="history-section">
        <h2>🛌 Sleep History</h2>
        <div id="sleep-history-wrapper">@include('profile.partials.sleep_table')</div>
    </div>
    <div class="history-section">
        <h2>💧 Water History</h2>
        <div id="water-history-wrapper">@include('profile.partials.water_table')</div>
    </div>

    <!-- Photos -->
    <div class="photos-grid">
        @forelse($photos as $photo)
            <div class="photo-card">
                <img src="{{ asset('storage/'.$photo->photo) }}" alt="Progress Photo">
                @if($photo->description)
                    <div class="photo-description">{{ $photo->description }}</div>
                @endif
                <div class="photo-date">Uploaded: {{ $photo->created_at->format('M d, Y H:i') }}</div>
            </div>
        @empty
            <p class="no-data">No progress photos yet.</p>
        @endforelse
    </div>

    <!-- Goals -->
    <div class="history-section">
        <h2>🎯 Your Goals</h2>
        @if($goals->isEmpty())
            <p class="no-data">No goals yet.</p>
        @else
            @foreach($goals as $goal)
                <div class="goal-card">
                    <h3>{{ ucfirst($goal->type) }} Goal (Deadline: {{ $goal->deadline }})</h3>
                    <div class="progress-bar">
                        <div class="progress-bar-inner" style="width: {{ $goal->progressPercent() }}%;"></div>
                    </div>
                    <small>{{ round($goal->current_value,1) }} / {{ $goal->target_value }}</small>
                </div>
            @endforeach
        @endif
    </div>
</div>

<!-- Sidebar -->
<div class="side-menu" id="side-menu">
    <h3>Navigation</h3>
    <ul>
        <li><a href="{{ route('dashboard') }}">Home</a></li>
        <li><a href="{{ route('foods.index') }}">Meal Tracker</a></li>
        <li><a href="{{ route('sleep.index') }}">Sleep Tracker</a></li>
        <li><a href="{{ route('water.index') }}">Water Tracker</a></li>
        <li><a href="{{ route('progress.index') }}">Progress Photos</a></li>
        <li><a href="{{ route('goals.index') }}">Goals</a></li>
        <li><a href="{{ route('calories.index') }}">Calorie Calculator</a></li>
        <li><a href="{{ route('biography.edit') }}">Biography</a></li>
        <li><a href="{{ route('profile.edit') }}">Profile</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Log Out</button>
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
    display: block;
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

/* --- Motivation Quote --- */
.motivation {
    text-align: center;
    font-size: 1.5rem;
    font-weight: 600;
    color: #d4af37;
    margin: 2rem 0;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease-out;
    text-shadow: 0 2px 8px rgba(216, 175, 55, 0.3);
}

/* --- Biography Card --- */
.biography-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(72, 201, 176, 0.3);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
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
}

.biography-card p {
    font-size: 1.1rem;
    color: #e6e6fa;
    margin-bottom: 1rem;
    line-height: 1.6;
}

.biography-card strong {
    color: #fff;
    font-weight: 600;
}

/* --- KPIs --- */
.kpi-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.kpi-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(216, 175, 55, 0.3);
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.kpi-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(216, 175, 55, 0.3);
    border-color: #d4af37;
}

.kpi-card h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #a3bffa;
    text-transform: uppercase;
    margin-bottom: 0.8rem;
}

.kpi-card p {
    font-size: 2.5rem;
    font-weight: 800;
    color: #d4af37;
}

/* --- Histories --- */
.history-section {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(72, 201, 176, 0.3);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.history-section:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(72, 201, 176, 0.2);
}

.history-section h2 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #48c9b0;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.history-section table {
    width: 100%;
    border-collapse: collapse;
    background: rgba(255, 255, 255, 0.02);
    border-radius: 10px;
    overflow: hidden;
}

.history-section th,
.history-section td {
    padding: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    text-align: left;
}

.history-section th {
    background: rgba(72, 201, 176, 0.1);
    color: #48c9b0;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
}

.history-section tr:hover {
    background: rgba(72, 201, 176, 0.1);
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1.5rem;
}

.pagination a,
.pagination span {
    padding: 0.8rem 1.2rem;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.05);
    color: #e6e6fa;
    font-size: 0.95rem;
    border: 1px solid rgba(216, 175, 55, 0.3);
    transition: all 0.3s ease;
}

.pagination a:hover {
    background: rgba(216, 175, 55, 0.2);
    color: #d4af37;
    transform: scale(1.05);
}

.pagination .active {
    background: #d4af37;
    color: #1c2526;
    border-color: #d4af37;
}

/* --- Progress Bars --- */
.progress-bar {
    background: rgba(255, 255, 255, 0.1);
    height: 12px;
    border-radius: 6px;
    overflow: hidden;
    margin: 1rem 0;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
}

.progress-bar-inner {
    height: 100%;
    background: linear-gradient(90deg, #48c9b0, #2e856e);
    border-radius: 6px;
    transition: width 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    box-shadow: 0 0 10px rgba(72, 201, 176, 0.5);
    position: relative;
}

.progress-bar-inner::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    animation: shimmer 2s infinite;
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
}

.no-data {
    text-align: center;
    color: #6b7280;
    font-size: 1rem;
    padding: 1rem;
}

/* --- Goals --- */
.goal-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(72, 201, 176, 0.3);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.goal-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(72, 201, 176, 0.3);
}

.goal-card h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #48c9b0;
    margin-bottom: 1rem;
}

.goal-card small {
    color: #a3bffa;
    font-size: 0.9rem;
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

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* --- Responsive --- */
@media (max-width: 768px) {
    .dashboard-main {
        padding: 1.5rem;
    }
    .kpi-container {
        grid-template-columns: 1fr;
        gap: 1rem;
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
    .photos-grid {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1rem;
    }
    .photo-card img {
        height: 160px;
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
    .biography-card, .history-section, .goal-card {
        padding: 1rem;
    }
    .kpi-card p {
        font-size: 2rem;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
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

    // Motivation Quote
    const quotes = [
        "Every step counts 🚶",
        "Consistency is key 🔑",
        "Stay focused & strong 💪",
        "Small progress is still progress 📈",
        "Push your limits 🔥"
    ];
    const motivationEl = document.getElementById('motivation');
    motivationEl.textContent = quotes[Math.floor(Math.random() * quotes.length)];
    setTimeout(() => {
        motivationEl.style.opacity = '1';
        motivationEl.style.transform = 'translateY(0)';
    }, 200);

    // Progress Bars Animation
    document.querySelectorAll('.progress-bar-inner').forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => bar.style.width = width, 300);
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

    // AJAX Pagination
    function ajaxPagination(wrapperId) {
        const wrapper = document.getElementById(wrapperId);
        wrapper.addEventListener('click', function(e) {
            const target = e.target;
            if (target.tagName === 'A' && target.closest('.pagination')) {
                e.preventDefault();
                const url = target.getAttribute('href');
                if (!url) return;
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.text())
                    .then(html => {
                        wrapper.innerHTML = html;
                    })
                    .catch(err => console.error(err));
            }
        });
    }
    ajaxPagination('meal-history-wrapper');
    ajaxPagination('sleep-history-wrapper');
    ajaxPagination('water-history-wrapper');
});
</script>
@endsection