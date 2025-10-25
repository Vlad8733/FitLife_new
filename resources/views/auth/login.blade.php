<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>FitLife - Login</title>
    <link rel="icon" href="{{ asset('favicon.PNG') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        :root {
            --bg: #121212;
            --text: #e5e5e5;
            --accent: #00ff00;
            --muted: #a0a0a0;
            --card-bg: #1f1f1f;
            --border: #333333;
            --radius: 12px;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            --transition: 0.3s ease;
            --highlight: #00cc00;
            --danger: #ff5555;
            --success: #00ff00;
            --focus: #33ff33;
            --hover-bg: #000000;
        }

        @media (prefers-color-scheme: light) {
            :root {
                --bg: #f4faff;
                --text: #2c3e50;
                --card-bg: #ffffff;
                --border: #e0e0e0;
                --muted: #7f8c8d;
                --hover-bg: #f0f0f0;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            min-height: 100vh;
            overflow-x: hidden;
            scroll-behavior: smooth;
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
        }

        body {
            flex: 1 0 auto;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--border);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--highlight);
        }

        header {
            background: var(--card-bg);
            padding: 1.5rem 4rem;
            border-bottom: 1px solid var(--border);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: var(--transition);
        }

        .logo {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--accent);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo img {
            width: 50px;
            height: auto;
        }

        .menu-toggle {
            font-size: 1.5rem;
            color: var(--accent);
            cursor: pointer;
            background: none;
            border: none;
            display: none;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .button {
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: var(--shadow);
        }

        .button.login {
            background: var(--accent);
            color: var(--bg);
        }

        .button.signup {
            background: var(--highlight);
            color: var(--bg);
        }

        .button:focus {
            outline: 2px solid var(--focus);
            outline-offset: 2px;
        }

        main {
            flex: 1 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 5rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 1.5rem;
        }

        .login-card {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            text-align: center;
            animation: slideIn 0.5s ease-out;
        }

        /* Логотип в форме — теперь по центру */
        .login-card .logo {
            width: 80px;
            margin: 0 auto 1rem auto;
            display: block;
            border-radius: var(--radius);
        }

        .login-card h2 {
            font-size: 2rem;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 0.5rem;
        }

        .login-card .subtitle {
            font-size: 1rem;
            color: var(--muted);
            margin-bottom: 1.5rem;
        }

        .login-card .subtitle span {
            color: var(--accent);
            font-weight: 600;
        }

        .login-card label {
            display: block;
            text-align: left;
            font-size: 0.9rem;
            color: var(--muted);
            margin: 0.5rem 0 0.25rem;
        }

        .login-card input[type="email"],
        .login-card input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: 1rem;
            color: var(--text);
            background: var(--card-bg);
            transition: var(--transition);
        }

        .login-card input:focus {
            outline: 2px solid var(--focus);
            border-color: var(--accent);
        }

        .login-card input::placeholder {
            color: var(--muted);
        }

        .remember {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember input {
            margin-right: 0.5rem;
        }

        .remember label {
            font-size: 0.9rem;
            color: var(--muted);
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }

        .footer a {
            color: var(--accent);
            font-size: 0.9rem;
            text-decoration: none;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--accent);
            color: var(--bg);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: var(--shadow);
        }

        .btn i {
            font-size: 1rem;
        }

        .btn:focus {
            outline: 2px solid var(--focus);
            outline-offset: 2px;
        }

        .status {
            background: var(--card-bg);
            color: var(--success);
            padding: 0.75rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            font-size: 0.9rem;
            border: 1px solid var(--success);
        }

        footer {
            background: var(--card-bg);
            padding: 1rem 2rem;
            border-top: 1px solid var(--border);
            text-align: center;
            flex-shrink: 0;
        }

        footer p {
            font-size: 0.9rem;
            color: var(--muted);
            margin-bottom: 0.5rem;
        }

        footer .links {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        footer .links a {
            color: var(--accent);
            font-weight: 500;
            text-decoration: none;
        }

        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        a:focus, button:focus, input:focus {
            outline: 2px solid var(--focus);
            outline-offset: 2px;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }

        @media (prefers-contrast: high) {
            :root {
                --accent: #33ff33;
                --highlight: #66ff66;
                --border: #000000;
                --muted: #cccccc;
            }

            .login-card, .status {
                border: 2px solid var(--accent);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .login-card, .btn, .button {
                animation: none;
            }
        }

        @media print {
            header, footer, .menu-toggle {
                display: none;
            }

            .login-card {
                background: none;
                box-shadow: none;
                border: 1px solid #000;
            }
        }

        @media (max-width: 768px) {
            header {
                padding: 1rem;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }

            .logo {
                font-size: 1.5rem;
            }

            .logo img {
                width: 40px;
            }

            .menu-toggle {
                display: block;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: var(--card-bg);
                flex-direction: column;
                padding: 1rem;
                border-bottom: 1px solid var(--border);
                box-shadow: var(--shadow);
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links a {
                padding: 0.75rem;
                font-size: 1rem;
            }

            .auth-buttons {
                flex-direction: row;
                gap: 0.5rem;
            }

            .button {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }

            .login-wrapper {
                padding: 1rem;
            }

            .login-card {
                padding: 1.5rem;
            }

            .login-card h2 {
                font-size: 1.8rem;
            }

            .login-card .subtitle {
                font-size: 0.9rem;
            }

            .login-card label, .login-card input, .remember label, .footer a, .btn {
                font-size: 0.9rem;
            }

            footer {
                padding: 1rem;
            }

            footer p {
                font-size: 0.8rem;
            }

            footer .links a {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .login-card h2 {
                font-size: 1.6rem;
            }

            .login-card .subtitle {
                font-size: 0.85rem;
            }

            .login-card label, .login-card input, .remember label, .footer a, .btn {
                font-size: 0.8rem;
            }

            .login-card .logo {
                width: 60px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile menu toggle
            const menuToggle = document.querySelector('.menu-toggle');
            const navLinks = document.querySelector('.nav-links');

            menuToggle.addEventListener('click', () => {
                navLinks.classList.toggle('active');
            });

            // Close mobile menu on link click
            document.querySelectorAll('.nav-links a').forEach(link => {
                link.addEventListener('click', () => {
                    navLinks.classList.remove('active');
                });
            });

            // Prevent pinch zoom on iOS
            document.addEventListener('gesturestart', (e) => {
                e.preventDefault();
            });
        });
    </script>
</head>

<body>
    <header>
        <div class="logo">
            <img src="{{ asset('favicon.PNG') }}" alt="FitLife Logo">
        </div>
        <button class="menu-toggle"><i class="fas fa-bars"></i></button>
        <div class="nav-links">
            <a href="{{ route('welcome') }}">Home</a>
            <a href="#features">Features</a>
            <a href="#testimonials">Testimonials</a>
            <a href="#about">About</a>
        </div>
        <div class="auth-buttons">
            @if(Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="button login">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="button login">
                        <i class="fas fa-sign-in-alt"></i> Log In
                    </a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="button signup">
                            <i class="fas fa-user-plus"></i> Sign Up
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </header>

    <main>
        <div class="login-wrapper" role="main" aria-label="FitLife Login">
            <div class="login-card">
                <!-- Логотип теперь по центру -->
                <img src="{{ asset('favicon.PNG') }}" alt="FitLife Logo" class="logo">
                <h2>Welcome Back</h2>
                <p class="subtitle">Log in to your <span>FitLife account</span></p>

                @if (session('status'))
                    <div class="status">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required autofocus>

                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="••••••••" required>

                    <div class="remember">
                        <input type="checkbox" id="remember_me" name="remember">
                        <label for="remember_me">Remember me</label>
                    </div>

                    <div class="footer">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Forgot your password?</a>
                        @else
                            <span></span>
                        @endif
                        <button type="submit" class="btn">
                            <i class="fas fa-sign-in-alt"></i> Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>© {{ date('Y') }} FitLife. All rights reserved.</p>
        <div class="links">
            <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
            <a href="{{ route('terms-of-service') }}">Terms of Service</a>
            <a href="mailto:support@fitlife.com">Contact Us</a>
        </div>
    </footer>
</body>
</html>