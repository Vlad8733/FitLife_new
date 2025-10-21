<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife - Login</title>
    <title>{{ config('app.name', 'FitLife - Login') }}</title>
    <link rel="icon" href="{{ asset('favicon.PNG') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
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
            --hover-bg: #2a2a2a;
            --focus: #33ff33;
            --action-icon: #3b82f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            width: 100%;
            overflow-x: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Login container styles */
        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 1.5rem;
        }

        /* Login card styles with hover effect */
        .login-card {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            text-align: center;
            transition: var(--transition);
        }

        /* Logo styling */
        .login-card .logo {
            width: 80px;
            margin-bottom: 1rem;
            border-radius: var(--radius);
        }

        /* Typography for login card */
        .login-card h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .login-card .subtitle {
            font-size: 0.9rem;
            color: var(--muted);
            margin-bottom: 1.5rem;
        }

        .login-card .subtitle span {
            color: var(--accent);
            font-weight: 600;
        }

        /* Form input labels */
        .login-card label {
            display: block;
            text-align: left;
            font-size: 0.9rem;
            color: var(--muted);
            margin: 0.5rem 0 0.25rem;
        }

        /* Input field styles */
        .login-card input[type="email"],
        .login-card input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: 0.95rem;
            color: var(--text);
            background: var(--card-bg);
            transition: var(--transition);
        }

        .login-card input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        .login-card input::placeholder {
            color: var(--muted);
        }

        /* Remember me checkbox styles */
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

        /* Footer with forgot password link and submit button */
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
            transition: var(--transition);
        }

        .footer a:hover {
            color: #2563eb;
            text-decoration: underline;
        }

        /* Button styles */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: var(--radius);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn svg {
            width: 20px;
            height: 20px;
            stroke: #fff;
        }

        .btn:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        /* Status message styling */
        .status {
            background: #e6ffed;
            color: #2e7d32;
            padding: 12px;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        /* Responsive design for tablets */
        @media (max-width: 768px) {
            .login-wrapper {
                padding: 1rem;
            }

            .login-card {
                padding: 1.5rem;
            }

            .login-card h2 {
                font-size: 1.4rem;
            }
        }

        /* Responsive design for mobile */
        @media (max-width: 480px) {
            .login-card {
                padding: 1rem;
            }

            .login-card h2 {
                font-size: 1.3rem;
            }

            .login-card .subtitle {
                font-size: 0.85rem;
            }
        }

        /* Accessibility: reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .login-card, .btn {
                transition: none;
            }
        }

        /* Accessibility: high contrast */
        @media (prefers-contrast: high) {
            .login-card {
                border: 2px solid var(--text);
            }

            .login-card input {
                border: 2px solid var(--text);
            }

            .btn {
                background: var(--text);
                color: var(--bg);
            }

            .btn svg {
                stroke: var(--bg);
            }

            .footer a {
                color: var(--text);
            }
        }
    </style>
</head>
<body>
    <!-- Main login wrapper -->
    <div class="login-wrapper" role="main" aria-label="FitLife Login">
        <!-- Login card with form -->
        <div class="login-card">
            <img src="{{ asset('favicon.PNG') }}" alt="FitLife Logo" class="logo">
            <h2>Welcome Back</h2>
            <p class="subtitle">Log in to your <span>FitLife account</span></p>

            <!-- Status message display -->
            @if (session('status'))
                <div class="status">{{ session('status') }}</div>
            @endif

            <!-- Login form -->
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                        </svg>
                        Log in
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>