@extends('layouts.app')

@section('content')
<!-- Font Awesome CDN for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="dashboard-main" id="dashboard-main">
    <!-- Menu Button -->
    <button class="menu-btn" id="menu-toggle"><i class="fas fa-bars"></i> Menu</button>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1><span>FitLife</span> Meal Tracker</h1>
        <p>Log and analyze your daily nutrition</p>
    </div>

    <!-- Result Widget -->
    @if(session('result'))
    <div class="biography-card result-widget">
        <div class="result-icon"><i class="fas fa-fire"></i></div>
        <div class="result-info">
            <h3>Total Calories</h3>
            <p class="calories">{{ session('result')['calories'] }} kcal</p>
            <p class="comment">{{ session('result')['comment'] }}</p>
        </div>
    </div>
    @endif

    <!-- Meal Form -->
    <form action="{{ route('foods.calculate') }}" method="POST" class="meal-grid-form">
        @csrf
        @php $meals = ['Breakfast', 'Lunch', 'Dinner', 'Snack']; @endphp

        <div class="kpi-container meals-grid">
            @foreach($meals as $meal)
            <div class="meal-block">
                <div class="kpi-card meal-card" data-meal-block="{{ $meal }}">
                    <h3>{{ $meal }}</h3>
                    <div class="meal-items" data-meal="{{ $meal }}">
                        <div class="meal-item">
                            <select class="food-select" name="meals[{{ $meal }}][0][food]">
                                <option value="">Select Food</option>
                                @foreach($foods as $food => $cal)
                                <option value="{{ $food }}">{{ $food }} ({{ $cal }} kcal)</option>
                                @endforeach
                            </select>
                            <input type="number" class="quantity-input" name="meals[{{ $meal }}][0][quantity]" placeholder="g/ml" style="display:none;">
                        </div>
                    </div>
                    <button type="button" class="add-food-btn" data-meal="{{ $meal }}">Add Item</button>
                </div>

                <!-- Calculate Button for Breakfast -->
                @if($meal === 'Breakfast')
                <div class="calculate-container">
                    <button type="submit" class="calculate-btn">Calculate Calories</button>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </form>
</div>

<!-- Sidebar -->
<div class="side-menu" id="side-menu">
    <h3>Navigation</h3>
    <ul>
        <li><a href="{{ route('dashboard') }}"><i class="fas fa-home nav-icon"></i> Home</a></li>
        <li><a href="{{ route('foods.index') }}" class="active"><i class="fas fa-utensils nav-icon"></i> Meal Tracker</a></li>
        <li><a href="{{ route('sleep.index') }}"><i class="fas fa-bed nav-icon"></i> Sleep Tracker</a></li>
        <li><a href="{{ route('water.index') }}"><i class="fas fa-tint nav-icon"></i> Water Tracker</a></li>
        <li><a href="{{ route('progress.index') }}"><i class="fas fa-camera nav-icon"></i> Progress Photos</a></li>
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

/* --- Result Widget --- */
.result-widget {
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(72, 201, 176, 0.3);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.result-widget:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 32px rgba(72, 201, 176, 0.2);
    border-color: #48c9b0;
}

.result-icon {
    font-size: 2rem;
    color: #d4af37;
    margin-right: 1rem;
}

.result-info h3 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #48c9b0;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.result-info .calories {
    font-size: 2.5rem;
    font-weight: 800;
    color: #d4af37;
}

.result-info .comment {
    font-size: 1.1rem;
    color: #a3bffa;
    font-style: italic;
}

/* --- Meal Grid Form --- */
.meal-grid-form {
    margin-bottom: 2rem;
}

.meals-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.meal-block {
    display: flex;
    flex-direction: column;
    align-items: stretch;
}

.meal-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(216, 175, 55, 0.3);
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.meal-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(216, 175, 55, 0.3);
    border-color: #d4af37;
}

.meal-card h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #a3bffa;
    text-transform: uppercase;
    margin-bottom: 0.8rem;
}

.meal-items {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
    margin-bottom: 1rem;
}

.meal-item {
    background: rgba(255, 255, 255, 0.02);
    padding: 0.8rem;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.food-select {
    padding: 0.6rem;
    border-radius: 8px;
    border: 1px solid rgba(216, 175, 55, 0.3);
    background: rgba(255, 255, 255, 0.05);
    color: #e6e6fa;
    font-size: 0.95rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.food-select:focus {
    outline: none;
    border-color: #48c9b0;
    box-shadow: 0 0 0 2px rgba(72, 201, 176, 0.3);
}

.quantity-input {
    padding: 0.6rem;
    border-radius: 8px;
    border: 1px solid rgba(216, 175, 55, 0.3);
    background: rgba(255, 255, 255, 0.05);
    color: #e6e6fa;
    font-size: 0.95rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.quantity-input:focus {
    outline: none;
    border-color: #48c9b0;
    box-shadow: 0 0 0 2px rgba(72, 201, 176, 0.3);
}

.quantity-input::placeholder {
    color: #a3bffa;
}

.add-food-btn {
    background: linear-gradient(135deg, #d4af37, #b8860b);
    color: #1c2526;
    padding: 0.6rem 1rem;
    border-radius: 8px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.add-food-btn:hover {
    background: linear-gradient(135deg, #b8860b, #a67c00);
    transform: scale(1.03);
    box-shadow: 0 4px 12px rgba(216, 175, 55, 0.3);
}

.calculate-container {
    margin-top: 1rem;
    text-align: center;
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
    .meals-grid {
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
    .meal-card, .result-widget {
        padding: 1rem;
    }
}

/* --- Accessibility --- */
@media (prefers-reduced-motion: reduce) {
    .meal-card, .result-widget, .menu-btn, .side-menu, .add-food-btn, .calculate-btn {
        transition: none;
    }
}

@media (prefers-contrast: high) {
    .meal-card, .result-widget {
        border: 2px solid #fff;
    }
    .side-menu ul li a.active, .add-food-btn, .calculate-btn {
        background: #fff;
        color: #1c2526;
    }
    .food-select, .quantity-input {
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

    // Food Selection
    document.querySelectorAll('.food-select').forEach(select => {
        select.addEventListener('change', e => {
            const input = e.target.nextElementSibling;
            input.style.display = e.target.value ? 'block' : 'none';
        });
    });

    // Add Food Item
    document.querySelectorAll('.add-food-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const meal = this.dataset.meal;
            const container = this.previousElementSibling;
            const count = container.querySelectorAll('.meal-item').length;
            const div = document.createElement('div');
            div.classList.add('meal-item');

            let selectHTML = `<select class="food-select" name="meals[${meal}][${count}][food]"><option value="">Select Food</option>`;
            @foreach($foods as $food => $cal)
            selectHTML += `<option value="{{ $food }}">{{ $food }} ({{ $cal }} kcal)</option>`;
            @endforeach
            selectHTML += `</select>`;
            div.innerHTML = selectHTML + `<input type="number" class="quantity-input" name="meals[${meal}][${count}][quantity]" placeholder="g/ml" style="display:none;">`;
            container.appendChild(div);

            div.querySelector('.food-select').addEventListener('change', e => {
                const input = e.target.nextElementSibling;
                input.style.display = e.target.value ? 'block' : 'none';
            });
        });
    });

    // Accessibility
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            sideMenu.classList.remove('active');
            dashboardMain.style.marginRight = '0';
            menuBtn.style.right = '20px';
        }
    });
});
</script>
@endsection