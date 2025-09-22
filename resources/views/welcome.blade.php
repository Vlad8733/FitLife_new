```php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitLife Dashboard</title>
    <style>
        /* Reset */
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
            font-family: 'Arial', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #FFFFFF;
            color: #000000;
            line-height: 1.5;
            font-size: 16px;
        }

        :root {
            --bg: #FFFFFF;
            --panel: #F5F5F5;
            --text: #000000;
            --accent: #007BFF;
            --border: #E0E0E0;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            --radius: 8px;
            --transition: all 0.2s ease;
            --font-weight-bold: 600;
            --font-weight-medium: 500;
            --error: #DC3545;
            --success: #28A745;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: var(--panel);
            padding: 15px 30px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            z-index: 1000;
            border-bottom: 1px solid var(--border);
            animation: slideInDown 0.5s ease;
        }

        header nav {
            display: flex;
            gap: 8px;
        }

        header nav a {
            padding: 8px 12px;
            background: #E8F0FE;
            color: var(--text);
            font-size: 0.9rem;
            font-weight: var(--font-weight-medium);
            border-radius: var(--radius);
            text-decoration: none;
            transition: var(--transition);
            animation: fadeIn 0.6s ease;
        }

        header nav a.primary {
            background: var(--accent);
            color: #FFFFFF;
            font-weight: var(--font-weight-bold);
        }

        header nav a:hover {
            background: #D1E0FF;
            color: var(--accent);
            transform: scale(1.05);
        }

        header nav a.primary:hover {
            background: #0056b3;
        }

        .content-container {
            max-width: 1200px;
            margin: 80px auto 40px;
            padding: 0 15px;
        }

        .hero {
            background: var(--panel);
            border-radius: var(--radius);
            padding: 2rem;
            text-align: center;
            border: 1px solid var(--border);
            margin-bottom: 1.5rem;
            animation: fadeIn 0.5s ease;
        }

        .hero:hover {
            box-shadow: var(--shadow);
            transform: translateY(-2px);
        }

        .hero h1 {
            font-size: 2rem;
            color: var(--text);
            font-weight: var(--font-weight-bold);
            margin-bottom: 0.8rem;
        }

        .hero p {
            font-size: 1rem;
            color: #666666;
            margin-bottom: 1.2rem;
        }

        .hero .button {
            padding: 8px 12px;
            background: var(--accent);
            color: #FFFFFF;
            border: none;
            border-radius: var(--radius);
            font-size: 0.9rem;
            font-weight: var(--font-weight-medium);
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            animation: popIn 0.4s ease;
        }

        .hero .button:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        .hero .button svg {
            width: 16px;
            height: 16px;
            stroke: #FFFFFF;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .feature-card {
            background: var(--panel);
            border-radius: var(--radius);
            padding: 1.5rem;
            text-align: center;
            border: 1px solid var(--border);
            transition: var(--transition);
            animation: slideInUp 0.3s ease calc(0.05s * var(--i));
        }

        .feature-card:hover {
            box-shadow: var(--shadow);
            transform: translateY(-5px);
        }

        .feature-card h3 {
            font-size: 1.1rem;
            color: var(--text);
            font-weight: var(--font-weight-bold);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .feature-card h3 svg {
            width: 16px;
            height: 16px;
            stroke: var(--accent);
        }

        .feature-card p {
            font-size: 0.9rem;
            color: #666666;
        }

        footer {
            background: var(--panel);
            border-radius: var(--radius);
            padding: 1.5rem;
            text-align: center;
            border: 1px solid var(--border);
            margin-top: 1.5rem;
            animation: fadeIn 0.5s ease;
        }

        footer p {
            color: #666666;
            margin-bottom: 0.5rem;
        }

        footer a {
            margin: 0 8px;
            color: var(--accent);
            font-weight: var(--font-weight-medium);
            text-decoration: none;
            transition: var(--transition);
        }

        footer a:hover {
            color: #0056b3;
        }

        @media (max-width: 768px) {
            .content-container {
                margin: 70px auto 30px;
                padding: 0 10px;
            }

            .hero {
                padding: 1.5rem;
            }

            .hero h1 {
                font-size: 1.8rem;
            }

            .hero p {
                font-size: 0.9rem;
            }

            .features {
                grid-template-columns: 1fr;
            }

            header {
                padding: 10px 15px;
            }

            header nav {
                gap: 6px;
            }
        }

        @media (max-width: 480px) {
            .hero {
                padding: 1rem;
            }

            .hero h1 {
                font-size: 1.6rem;
            }

            .feature-card {
                padding: 1rem;
            }

            footer {
                padding: 1rem;
            }
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes popIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }
            70% {
                transform: scale(1.05);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after, .hero, .feature-card, .hero .button, header nav a, footer {
                transition: none;
                animation: none;
            }
        }

        @media (prefers-contrast: high) {
            .hero, .feature-card, footer, header {
                border: 2px solid var(--text);
            }

            header nav a, .hero .button {
                background: var(--text);
                color: var(--bg);
            }

            header nav a.primary {
                background: var(--accent);
                color: #FFFFFF;
            }

            .feature-card h3 svg, .hero .button svg {
                stroke: var(--bg);
            }

            .hero h1, .feature-card h3 {
                color: var(--text);
            }

            footer a {
                color: var(--text);
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
```