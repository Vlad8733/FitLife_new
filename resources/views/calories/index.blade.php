@extends('layouts.app')

@section('content')
<!-- Font Awesome CDN for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="dashboard-main" id="dashboard-main">
    <!-- Menu Button -->
    <button class="menu-btn" id="menu-toggle"><i class="fas fa-bars"></i> Menu</button>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1><span>FitLife</span> Calorie & Macro Calculator</h1>
        <p>Calculate your daily calorie and macro needs!</p>
    </div>

    <!-- Calculator Form -->
    <div class="biography-card">
        <h3><i class="fas fa-calculator"></i> Calorie Calculator</h3>
        <form action="{{ route('calories.calculate') }}" method="POST" class="form-logging">
            @csrf
            <div class="form-group">
                <label>Weight (kg)</label>
                <input type="number" name="weight" placeholder="Weight (kg)" value="{{ old('weight', $user->weight) }}" required>
            </div>
            <div class="form-group">
                <label>Height (cm)</label>
                <input type="number" name="height" placeholder="Height (cm)" value="{{ old('height', $user->height) }}" required>
            </div>
            <div class="form-group">
                <label>Age</label>
                <input type="number" name="age" placeholder="Age" value="{{ old('age', $user->age) }}" required>
            </div>
            <div class="form-group">
                <label>Activity Level</label>
                <select name="activity_level" required>
                    <option value="">Select Activity Level</option>
                    <option value="sedentary" {{ old('activity_level', $user->activity_level)=='sedentary'?'selected':'' }}>Sedentary</option>
                    <option value="light" {{ old('activity_level', $user->activity_level)=='light'?'selected':'' }}>Light</option>
                    <option value="moderate" {{ old('activity_level', $user->activity_level)=='moderate'?'selected':'' }}>Moderate</option>
                    <option value="active" {{ old('activity_level', $user->activity_level)=='active'?'selected':'' }}>Active</option>
                </select>
            </div>
            <div class="form-group">
                <label>Goal</label>
                <select name="goal_type" required>
                    <option value="">Select Goal</option>
                    <option value="lose_weight" {{ old('goal_type', $user->goal_type)=='lose_weight'?'selected':'' }}>Lose Weight</option>
                    <option value="maintain" {{ old('goal_type', $user->goal_type)=='maintain'?'selected':'' }}>Maintain</option>
                    <option value="gain_weight" {{ old('goal_type', $user->goal_type)=='gain_weight'?'selected':'' }}>Gain Weight</option>
                </select>
            </div>
            <button type="submit" class="calculate-btn">Calculate</button>
        </form>
    </div>

    <!-- Results -->
    @isset($calories)
        <div class="kpi-container">
            <div class="kpi-card">
                <h3>Recommended Daily Calories</h3>
                <p>{{ round($calories) }} kcal</p>
            </div>
            <div class="kpi-card">
                <h3>Protein</h3>
                <p>{{ $protein }}g</p>
            </div>
            <div class="kpi-card">
                <h3>Fats</h3>
                <p>{{ $fat }}g</p>
            </div>
            <div class="kpi-card">
                <h3>Carbs</h3>
                <p>{{ $carbs }}g</p>
            </div>
            <div class="kpi-card">
                <h3>Calories Consumed Today</h3>
                <p>{{ $todayCalories }} kcal</p>
            </div>
            <div class="kpi-card">
                <h3>Status</h3>
                <p style="color: #48c9b0; font-weight: 600;">
                    @if($todayCalories < $calories)
                        You can still eat ~{{ round($calories - $todayCalories) }} kcal today.
                    @elseif($todayCalories > $calories)
                        You have exceeded your recommended calories by ~{{ round($todayCalories - $calories) }} kcal.
                    @else
                        Perfect! You met your target today.
                    @endif
                </p>
            </div>
        </div>
    @endisset
</div>

<!-- Sidebar -->
<div class="side-menu" id="side-menu">
    <h3>Navigation</h3>
    <ul>
        <li><a href="{{ route('dashboard') }}"><i class="fas fa-home nav-icon"></i> Home</a></li>
        <li><a href="{{ route('foods.index') }}"><i class="fas fa-utensils nav-icon"></i> Meal Tracker</a></li>
        <li><a href="{{ route('sleep.index') }}"><i class="fas fa-bed nav-icon"></i> Sleep Tracker</a></li>
        <li><a href="{{ route('water.index') }}"><i class="fas fa-tint nav-icon"></i> Water Tracker</a></li>
        <li><a href="{{ route('progress.index') }}"><i class="fas fa-camera nav-icon"></i> Progress Photos</a></li>
        <li><a href="{{ route('goals.index') }}"><i class="fas fa-bullseye nav-icon"></i> Goals</a></li>
        <li><a href="{{ route('calories.index') }}" class="active"><i class="fas fa-calculator nav-icon"></i> Calorie Calculator</a></li>
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

.form-group input,
.form-group select {
    padding: 0.6rem;
    border-radius: 8px;
    border: 1px solid rgba(216, 175, 55, 0.3);
    background: rgba(255, 255, 255, 0.05);
    color: #e6e6fa;
    font-size: 0.95rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
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

/* --- KPI Container --- */
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
    font-size: 1.5rem;
    font-weight: 800;
    color: #d4af37;
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
    .biography-card, .kpi-card {
        padding: 1rem;
    }
}

/* --- Accessibility --- */
@media (prefers-reduced-motion: reduce) {
    .biography-card, .kpi-card, .menu-btn, .side-menu, .calculate-btn {
        transition: none;
    }
}

@media (prefers-contrast: high) {
    .biography-card, .kpi-card {
        border: 2px solid #fff;
    }
    .side-menu ul li a.active, .calculate-btn {
        background: #fff;
        color: #1c2526;
    }
    .form-group input, .form-group select {
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
        }
    });
});
</script>
@endsection