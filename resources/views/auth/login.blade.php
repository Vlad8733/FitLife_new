<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife - Login</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
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

        /* ====== Login Wrapper ====== */
        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
        }

        /* ====== Login Card ====== */
        .login-card {
            background: var(--panel);
            padding: 2rem;
            border-radius: var(--radius);
            border: 1px solid var(--glass);
            box-shadow: var(--shadow);
            text-align: center;
            animation: fadeIn 0.5s var(--animation-ease);
            transition: var(--transition);
        }
        .login-card:hover {
            box-shadow: var(--glow), var(--shadow);
            transform: translateY(-5px);
        }
        .login-card .logo {
            width: 90px;
            margin-bottom: 1rem;
            border-radius: 8px;
        }
        .login-card h2 {
            font-size: 1.5rem;
            font-weight: var(--font-weight-bold);
            color: var(--neon);
            margin-bottom: 0.5rem;
        }
        .login-card .subtitle {
            font-size: 1.1rem;
            color: var(--muted);
            font-weight: var(--font-weight-medium);
            margin-bottom: 1.5rem;
        }
        .login-card .subtitle span {
            font-weight: var(--font-weight-bold);
            color: var(--accent);
        }

        /* ====== Form Styling ====== */
        .login-card label {
            display: block;
            text-align: left;
            font-size: 0.95rem;
            font-weight: var(--font-weight-medium);
            color: var(--white);
            margin: 0.5rem 0;
        }
        .login-card input[type="email"],
        .login-card input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid var(--glass);
            background: rgba(255, 255, 255, 0.05);
            color: var(--white);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .login-card input:focus {
            outline: none;
            border-color: var(--neon);
            box-shadow: 0 0 0 2px rgba(0, 255, 136, 0.3);
        }
        .login-card input::placeholder {
            color: var(--muted);
        }

        /* ====== Remember Checkbox ====== */
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

        /* ====== Footer ====== */
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }
        .footer a {
            color: var(--neon);
            font-size: 0.9rem;
            font-weight: var(--font-weight-medium);
            transition: var(--transition);
        }
        .footer a:hover {
            color: var(--accent);
        }

        /* ====== Button Styling ====== */
        .btn {
            padding: 6px 12px;
            background: linear-gradient(90deg, var(--neon), var(--accent));
            color: var(--white);
            border: none;
            border-radius: 8px;
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
        .btn svg {
            width: 14px;
            height: 14px;
            stroke: var(--white);
        }
        .btn:hover {
            background: linear-gradient(90deg, var(--accent), var(--neon));
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.6);
            transform: scale(1.05);
        }
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.4s ease;
        }
        .btn:hover::before {
            left: 100%;
        }

        /* ====== Status Message ====== */
        .status {
            text-align: center;
            padding: 16px;
            background: var(--glass);
            border-radius: var(--radius);
            color: var(--neon);
            font-size: 0.95rem;
            font-weight: var(--font-weight-medium);
            margin-bottom: 1rem;
            box-shadow: var(--shadow);
        }

        /* ====== Animations ====== */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        :root {
            --animation-ease: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ====== Responsive ====== */
        @media (max-width: 768px) {
            .login-wrapper {
                padding: 1.5rem;
            }
            .login-card h2 {
                font-size: 2rem;
            }
        }
        @media (max-width: 480px) {
            .login-card {
                padding: 1rem;
            }
            .login-card h2 {
                font-size: 1.8rem;
            }
            .login-card .subtitle {
                font-size: 1rem;
            }
        }

        /* ====== Accessibility ====== */
        @media (prefers-reduced-motion: reduce) {
            .login-card, .btn {
                transition: none;
            }
        }
        @media (prefers-contrast: high) {
            .login-card {
                border: 2px solid var(--white);
            }
            .login-card input {
                border: 1px solid var(--white);
            }
            .btn {
                background: var(--white);
                color: var(--bg);
            }
            .footer a {
                color: var(--white);
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper" role="main" aria-label="FitLife Login">
        <div class="login-card">
            <img src="{{ asset('storage/logo/logoFitLife.jpg') }}" alt="FitLife Logo" class="logo">
            <h2>Welcome Back ⚡</h2>
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>
                        </svg>
                        Log in
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>