<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife - Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8f9fa;
            --text: #1a1a1a;
            --accent: #2563eb;
            --muted: #6b7280;
            --card-bg: #ffffff;
            --border: #e5e7eb;
            --radius: 8px;
            --shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            --transition: 0.2s ease;
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

        .register-wrapper {
            width: 100%;
            max-width: 450px;
            padding: 1.5rem;
        }

        .register-card {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            text-align: center;
            transition: var(--transition);
        }

        .register-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .register-card .logo {
            width: 80px;
            margin-bottom: 1rem;
            border-radius: var(--radius);
        }

        .register-card h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .register-card .subtitle {
            font-size: 0.9rem;
            color: var(--muted);
            margin-bottom: 1.5rem;
        }

        .register-card .subtitle span {
            color: var(--accent);
            font-weight: 600;
        }

        .register-card label {
            display: block;
            text-align: left;
            font-size: 0.9rem;
            color: var(--muted);
            margin: 0.5rem 0 0.25rem;
        }

        .register-card input[type="text"],
        .register-card input[type="email"],
        .register-card input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: 0.95rem;
            color: var(--text);
            background: var(--card-bg);
            transition: var(--transition);
        }

        .register-card input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        .register-card input::placeholder {
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
            transition: var(--transition);
        }

        .footer a:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

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
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .register-wrapper {
                padding: 1rem;
            }

            .register-card {
                padding: 1.5rem;
            }

            .register-card h2 {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 480px) {
            .register-card {
                padding: 1rem;
            }

            .register-card h2 {
                font-size: 1.3rem;
            }

            .register-card .subtitle {
                font-size: 0.85rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .register-card, .btn {
                transition: none;
            }
        }

        @media (prefers-contrast: high) {
            .register-card {
                border: 2px solid var(--text);
            }

            .register-card input {
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
    <div class="register-wrapper" role="main" aria-label="FitLife Register">
        <div class="register-card">
            <img src="{{ asset('storage/logo/logoFitLife.jpg') }}" alt="FitLife Logo" class="logo">
            <h2>Create Your Account</h2>
            <p class="subtitle">Join <span>FitLife</span> and start your journey</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">

                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">

                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">

                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">

                <div class="footer">
                    <a href="{{ route('login') }}">Already registered?</a>
                    <button type="submit" class="btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                            <path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/>
                        </svg>
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>