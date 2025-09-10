<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitLife Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* === Reset & Base === */
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter', sans-serif; background:#121212; color:#e5e5e5; overflow-x:hidden; }
        a { text-decoration:none; }

        /* === Header === */
        header {
            position: fixed; top:0; left:0; width:100%;
            background:#1c1c1c; padding:20px 40px;
            display:flex; justify-content:flex-end; z-index:1000; border-bottom:1px solid #2f2f2f;
        }
        header nav a {
            margin-left:15px; padding:10px 18px; border-radius:8px;
            font-weight:600; background:#2a2a2a; color:#d1d5db; transition: all 0.2s ease;
        }
        header nav a:hover { background:#374151; color:#fff; }
        header nav a.primary { background:#8ab4f8; color:#000; font-weight:700; }

        /* === Main container === */
        .content-container { max-width:1200px; margin:100px auto 50px; padding:0 20px; }

        /* === Hero Section === */
        .hero {
            background:#1e1e1e; border-radius:14px; padding:2rem; text-align:center;
            box-shadow:0 4px 12px rgba(0,0,0,0.6); margin-bottom:2rem;
        }
        .hero h1 { font-size:2.5rem; color:#8ab4f8; margin-bottom:1rem; }
        .hero p { font-size:1.1rem; color:#d1d5db; margin-bottom:1.5rem; }
        .hero .button {
            padding:12px 24px; border-radius:10px; border:none;
            background:linear-gradient(90deg,#8ab4f8,#3b82f6); color:#000; font-weight:700;
            cursor:pointer; transition: all 0.2s ease;
        }
        .hero .button:hover { background:linear-gradient(90deg,#5a99e0,#2563eb); }

        /* === Features Section === */
        .features {
            display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1rem;
        }
        .feature-card {
            background:#1e1e1e; border-radius:14px; padding:1.5rem; text-align:center;
            box-shadow:0 4px 12px rgba(0,0,0,0.6); transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .feature-card:hover { transform: translateY(-5px); box-shadow:0 6px 18px rgba(0,0,0,0.8); }
        .feature-card h3 { font-size:1.2rem; color:#8ab4f8; margin-bottom:0.5rem; }
        .feature-card p { font-size:0.95rem; color:#d1d5db; }

        /* === Footer === */
        footer {
            background:#1e1e1e; border-radius:14px; padding:2rem 1rem;
            text-align:center; box-shadow:0 4px 12px rgba(0,0,0,0.6); margin-top:2rem;
        }
        footer p { color:#9ca3af; margin-bottom:0.5rem; }
        footer a { margin:0 10px; color:#8ab4f8; font-weight:600; transition:0.2s; }
        footer a:hover { color:#d1d5db; }

        @media(max-width:768px){
            .hero h1 { font-size:2rem; }
            .hero p { font-size:1rem; }
            .features { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

<header>
    @if(Route::has('login'))
        <nav>
            @auth
                <a href="{{ url('/dashboard') }}" class="primary">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Log in</a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="primary">Sign up</a>
                @endif
            @endauth
        </nav>
    @endif
</header>

<div class="content-container">

    <!-- Hero -->
    <section class="hero">
        <h1>Welcome to FitLife</h1>
        <p>Track meals, sleep, hydration, and goals. Glow through your fitness journey!</p>
        @guest
            <a href="{{ route('register') }}" class="button">Get Started</a>
        @endguest
    </section>

    <!-- Features -->
    <section class="features">
        <div class="feature-card">
            <h3>🥗 Meal Tracker</h3>
            <p>Log and analyze your meals with AI-powered insights.</p>
        </div>
        <div class="feature-card">
            <h3>🛌 Sleep Monitor</h3>
            <p>Track your sleep cycles and improve recovery.</p>
        </div>
        <div class="feature-card">
            <h3>💧 Hydration</h3>
            <p>Stay hydrated by tracking daily water intake.</p>
        </div>
        <div class="feature-card">
            <h3>📊 Dashboard</h3>
            <p>Visualize your progress with detailed stats.</p>
        </div>
    </section>

</div>

<footer>
    <p>Glow through your fitness journey. All rights reserved &copy; {{ date('Y') }}</p>
    <div>
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Service</a>
    </div>
</footer>

</body>
</html>
