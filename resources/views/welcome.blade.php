<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitLife Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* ====== Reset ====== */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        html, body {
            height: 100%;
            width: 100%;
            overflow-x: hidden;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background: linear-gradient(180deg, #0A0C10, #1A1F26);
            color: #E6ECEF;
            line-height: 1.6;
        }

        /* ====== Palette & Variables ====== */
        :root {
            --bg: #0A0C10;
            --panel: #14171C;
            --muted: #8A94A6;
            --neon: #00FF88;
            --accent: #FF3D00;
            --white: #F5F7FA;
            --glass: rgba(255, 255, 255, 0.04);
            --shadow: 0 6px 20px rgba(0, 0, 0, 0.7);
            --glow: 0 0 15px rgba(0, 255, 136, 0.4);
            --radius: 14px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font-size-base: 16px;
            --font-weight-bold: 700;
            --font-weight-medium: 500;
        }

        /* ====== Header ====== */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: var(--panel);
            padding: 20px 40px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            z-index: 1000;
            border-bottom: 1px solid var(--glass);
            box-shadow: var(--shadow);
        }
        header nav {
            display: flex;
            gap: 10px;
        }
        header nav a {
            padding: 6px 12px;
            background: var(--glass);
            color: var(--white);
            font-size: 0.8rem;
            font-weight: var(--font-weight-medium);
            border-radius: 8px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            text-align: center;
            white-space: nowrap;
        }
        header nav a.primary {
            background: linear-gradient(90deg, var(--neon), var(--accent));
            color: var(--white);
            font-weight: var(--font-weight-bold);
            box-shadow: var(--glow);
        }
        header nav a:hover {
            background: rgba(0, 255, 136, 0.08);
            transform: scale(1.05);
        }
        header nav a.primary:hover {
            background: linear-gradient(90deg, var(--accent), var(--neon));
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.6);
        }
        header nav a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.4s ease;
        }
        header nav a:hover::before {
            left: 100%;
        }

        /* ====== Main Content ====== */
        .content-container {
            max-width: 1200px;
            margin: 100px auto 50px;
            padding: 0 20px;
        }

        /* ====== Hero Section ====== */
        .hero {
            background: var(--panel);
            border-radius: var(--radius);
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            animation: fadeIn 0.5s var(--animation-ease);
        }
        .hero h1 {
            font-size: 2.5rem;
            color: var(--neon);
            font-weight: var(--font-weight-bold);
            margin-bottom: 1rem;
        }
        .hero p {
            font-size: 1.1rem;
            color: var(--muted);
            margin-bottom: 1.5rem;
        }
        .hero .button {
            padding: 6px 12px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(90deg, var(--neon), var(--accent));
            color: var(--white);
            font-size: 0.8rem;
            font-weight: var(--font-weight-bold);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            box-shadow: var(--glow);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .hero .button svg {
            width: 14px;
            height: 14px;
            stroke: var(--white);
        }
        .hero .button:hover {
            background: linear-gradient(90deg, var(--accent), var(--neon));
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.6);
            transform: scale(1.05);
        }
        .hero .button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.4s ease;
        }
        .hero .button:hover::before {
            left: 100%;
        }

        /* ====== Features Section ====== */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
        }
        .feature-card {
            background: var(--panel);
            border-radius: var(--radius);
            padding: 1.5rem;
            text-align: center;
            box-shadow: var(--shadow);
            transition: var(--transition);
            animation: fadeIn 0.5s var(--animation-ease);
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--glow), var(--shadow);
        }
        .feature-card h3 {
            font-size: 1.2rem;
            color: var(--neon);
            font-weight: var(--font-weight-bold);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .feature-card h3 svg {
            width: 14px;
            height: 14px;
            stroke: var(--neon);
        }
        .feature-card p {
            font-size: 0.95rem;
            color: var(--muted);
        }

        /* ====== Footer ====== */
        footer {
            background: var(--panel);
            border-radius: var(--radius);
            padding: 2rem 1rem;
            text-align: center;
            box-shadow: var(--shadow);
            margin-top: 2rem;
        }
        footer p {
            color: var(--muted);
            margin-bottom: 0.5rem;
        }
        footer a {
            margin: 0 10px;
            color: var(--neon);
            font-weight: var(--font-weight-medium);
            transition: var(--transition);
        }
        footer a:hover {
            color: var(--accent);
        }

        /* ====== Animations ====== */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        :root {
            --animation-ease: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ====== Responsive Design ====== */
        @media (max-width: 768px) {
            .content-container {
                margin: 80px auto 30px;
                padding: 0 15px;
            }
            .hero h1 {
                font-size: 2rem;
            }
            .hero p {
                font-size: 1rem;
            }
            .features {
                grid-template-columns: 1fr;
            }
            header {
                padding: 15px 20px;
            }
            header nav {
                gap: 8px;
            }
        }
        @media (max-width: 480px) {
            .hero {
                padding: 1.5rem;
            }
            .hero h1 {
                font-size: 1.8rem;
            }
            .feature-card {
                padding: 1rem;
            }
            footer {
                padding: 1.5rem 1rem;
            }
        }

        /* ====== Accessibility ====== */
        @media (prefers-reduced-motion: reduce) {
            .feature-card, .hero .button, header nav a {
                transition: none;
            }
        }
        @media (prefers-contrast: high) {
            .hero, .feature-card, footer {
                border: 2px solid var(--white);
            }
            header nav a.primary, .hero .button {
                background: var(--white);
                color: var(--bg);
            }
            header nav a {
                border: 1px solid var(--white);
            }
            footer a {
                color: var(--white);
            }
        }
    </style>
</head>
<body>

<header>
    @if(Route::has('login'))
        <nav aria-label="Main navigation">
            @auth
                <a href="{{ route('dashboard') }}" class="primary">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Log in</a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="primary">Sign up</a>
                @endif
            @endauth
        </nav>
    @endif
</header>

<div class="content-container" role="main" aria-label="FitLife Welcome Content">
    <!-- Hero -->
    <section class="hero" aria-labelledby="hero-heading">
        <h1 id="hero-heading">Welcome to FitLife</h1>
        <p>Track meals, sleep, hydration, and goals. Glow through your fitness journey!</p>
        @guest
            <a href="{{ route('register') }}" class="button">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                    <path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/>
                </svg>
                Get Started
            </a>
        @endguest
    </section>

    <!-- Features -->
    <section class="features" aria-labelledby="features-heading">
        <h2 id="features-heading" style="display: none;">Features</h2>
        <div class="feature-card">
            <h3>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M4 21c4-4 6-11 6-17"/><path d="M20 7a4 4 0 11-8 0"/>
                </svg>
                Meal Tracker
            </h3>
            <p>Log and analyze your meals with AI-powered insights.</p>
        </div>
        <div class="feature-card">
            <h3>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
                Sleep Monitor
            </h3>
            <p>Track your sleep cycles and improve recovery.</p>
        </div>
        <div class="feature-card">
            <h3>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M12 2s4 5 4 8a4 4 0 01-8 0c0-3 4-8 4-8z"/>
                </svg>
                Hydration
            </h3>
            <p>Stay hydrated by tracking daily water intake.</p>
        </div>
        <div class="feature-card">
            <h3>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M21 3v18H3V3h18z"/><path d="M7 14l3-3 2 2 5-5"/>
                </svg>
                Dashboard
            </h3>
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