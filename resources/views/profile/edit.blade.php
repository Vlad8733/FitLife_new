@extends('layouts.app')

@section('content')
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

/* --- Content Wrapper (Dashboard Header Style) --- */
.content-wrapper {
    text-align: center;
    margin-bottom: 3rem;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 16px;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    animation: fadeIn 0.8s ease-out;
}

.content-wrapper h1 {
    font-size: 3rem;
    font-weight: 800;
    color: #48c9b0;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 8px rgba(72, 201, 176, 0.3);
}

.content-wrapper h1 span {
    font-weight: 300;
    color: #a3bffa;
}

/* --- Form Groups (Styled like Biography Card) --- */
.form-group {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(72, 201, 176, 0.3);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.form-group:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 32px rgba(72, 201, 176, 0.2);
    border-color: #48c9b0;
}

.form-group label {
    font-size: 1.1rem;
    font-weight: 600;
    color: #fff;
    margin-bottom: 0.5rem;
    display: block;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="password"] {
    width: 100%;
    padding: 0.8rem;
    border-radius: 8px;
    border: 1px solid rgba(72, 201, 176, 0.3);
    background: rgba(255, 255, 255, 0.05);
    color: #e6e6fa;
    font-size: 1rem;
    transition: border-color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.form-group input:focus {
    border-color: #48c9b0;
    outline: none;
}

/* --- Buttons (Styled like KPI Card Buttons) --- */
.save-btn, .delete-btn {
    width: 100%;
    padding: 0.8rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.save-btn {
    background: linear-gradient(90deg, #48c9b0, #2e856e);
    color: #1c2526;
}

.save-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(72, 201, 176, 0.3);
    border-color: #48c9b0;
}

.delete-btn {
    background: linear-gradient(90deg, #ef4444, #f87171);
    color: #fff;
    margin-top: 1rem;
}

.delete-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
}

/* --- Success Message (Styled like No-data) --- */
.success-msg {
    text-align: center;
    color: #a3bffa;
    font-size: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    margin-bottom: 1.5rem;
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
    .side-menu {
        width: 100%;
        right: -100%;
    }
    .side-menu.active {
        right: 0;
    }
    .content-wrapper h1 {
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
    .content-wrapper {
        padding: 1rem;
    }
    .form-group {
        padding: 1rem;
    }
}
</style>

<!-- Sidebar -->
<div class="side-menu" id="side-menu">
    <h3>Navigation</h3>
    <ul>
        <li><a href="{{ route('dashboard') }}">Home Page</a></li>
        <li><a href="{{ route('foods.index') }}">Meal Tracker</a></li>
        <li><a href="{{ route('sleep.index') }}">Sleep Tracker</a></li>
        <li><a href="{{ route('water.index') }}">Water Tracker</a></li>
        <li><a href="{{ route('progress.index') }}">Progress Photo</a></li>
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

<!-- Content -->
<div class="dashboard-main" id="dashboard-main">
    <button class="menu-btn" id="menu-toggle">☰ Menu</button>

    <div class="content-wrapper">
        <h1><span>Profile</span> Settings</h1>

        @if(session('status'))
            <div class="success-msg">{{ session('status') }}</div>
        @endif

        <!-- Profile -->
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <button type="submit" class="save-btn">Save Profile</button>
        </form>

        <!-- Password Change -->
        <form action="{{ route('password.update') }}" method="POST" style="margin-top:30px;">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" required>
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="save-btn">Update Password</button>
        </form>

        <!-- Delete Account -->
        <form action="{{ route('profile.destroy') }}" method="POST" style="margin-top:30px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-btn">Delete Account</button>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){
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
});
</script>
@endsection