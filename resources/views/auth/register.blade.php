<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife - Register</title>
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

        /* ====== Register Wrapper ====== */
        .register-wrapper {
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
        }

        /* ====== Register Card ====== */
        .register-card {
            background: var(--panel);
            padding: 2rem;
            border-radius: var(--radius);
            border: 1px solid var(--glass);
            box-shadow: var(--shadow);
            text-align: center;
            animation: fadeIn 0.5s var(--animation-ease);
            transition: var(--transition);
        }
        .register-card:hover {
            box-shadow: var(--glow), var(--shadow);
            transform: translateY(-5px);
        }
        .register-card .logo {
            width: 90px;
            margin-bottom: 1rem;
            border-radius: 8px;
        }
        .register-card h2 {
            font-size: 1.5rem;
            font-weight: var(--font-weight-bold);
            color: var(--neon);
            margin-bottom: 0.5rem;
        }
        .register-card .subtitle {
            font-size: 1.1rem;
            color: var(--muted);
            font-weight: var(--font-weight-medium);
            margin-bottom: 1.5rem;
        }
        .register-card .subtitle span {
            font-weight: var(--font-weight-bold);
            color: var(--accent);
        }

        /* ====== Form Styling ====== */
        .register-card label {
            display: block;
            text-align: left;
            font-size: 0.95rem;
            font-weight: var(--font-weight-medium);
            color: var(--white);
            margin: 0.5rem 0;
        }
        .register-card input[type="text"],
        .register-card input[type="email"],
        .register-card input[type="password"] {
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
        .register-card input:focus {
            outline: none;
            border-color: var(--neon);
            box-shadow: 0 0 0 2px rgba(0, 255, 136, 0.3);
        }
        .register-card input::placeholder {
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
            .register-wrapper {
                padding: 1.5rem;
            }
            .register-card h2 {
                font-size: 2rem;
            }
        }
        @media (max-width: 480px) {
            .register-card {
                padding: 1rem;
            }
            .register-card h2 {
                font-size: 1.8rem;
            }
            .register-card .subtitle {
                font-size: 1rem;
            }
        }

        /* ====== Accessibility ====== */
        @media (prefers-reduced-motion: reduce) {
            .register-card, .btn {
                transition: none;
            }
        }
        @media (prefers-contrast: high) {
            .register-card {
                border: 2px solid var(--white);
            }
            .register-card input {
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
    <div class="register-wrapper" role="main" aria-label="FitLife Register">
        <div class="register-card">
            <img src="{{ asset('storage/logo/logoFitLife.jpg') }}" alt="FitLife Logo" class="logo">
            <h2>Create Your Account ✨</h2>
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
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