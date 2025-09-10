<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
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
            display: flex;
            align-items: center;
            justify-content: center;
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

        /* --- Login Wrapper --- */
        .login-wrapper {
            position: relative;
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
        }

        /* --- Login Card (Styled like Dashboard Header) --- */
        .login-card {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid rgba(72, 201, 176, 0.3);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: fadeIn 0.8s ease-out;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 32px rgba(72, 201, 176, 0.2);
            border-color: #48c9b0;
        }

        .login-card .logo {
            width: 90px;
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        .login-card h2 {
            font-size: 3rem;
            font-weight: 800;
            color: #48c9b0;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 8px rgba(72, 201, 176, 0.3);
        }

        .login-card .subtitle {
            font-size: 1.2rem;
            color: #a3bffa;
            font-weight: 400;
            margin-bottom: 1.5rem;
        }

        .login-card .subtitle span {
            font-weight: 600;
            color: #d4af37;
        }

        .login-card label {
            display: block;
            text-align: left;
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            margin: 0.5rem 0;
        }

        .login-card input[type="email"],
        .login-card input[type="password"] {
            width: 100%;
            padding: 0.8rem;
            border-radius: 8px;
            border: 1px solid rgba(72, 201, 176, 0.3);
            background: rgba(255, 255, 255, 0.05);
            color: #e6e6fa;
            font-size: 1rem;
            margin-bottom: 1rem;
            transition: border-color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .login-card input:focus {
            border-color: #48c9b0;
            outline: none;
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
            font-size: 0.95rem;
            font-weight: 500;
            color: #a3bffa;
        }

        /* --- Footer --- */
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }

        .footer a {
            color: #a3bffa;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .footer a:hover {
            color: #d4af37;
        }

        .btn {
            background: linear-gradient(90deg, #48c9b0, #2e856e);
            color: #1c2526;
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(72, 201, 176, 0.3);
            border-color: #48c9b0;
        }

        /* --- Divider (Styled like No-data) --- */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: #a3bffa;
            font-size: 0.95rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .divider span {
            padding: 0 0.5rem;
        }

        /* --- Social Buttons (Styled like KPI Card) --- */
        .social {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .social button {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(216, 175, 55, 0.3);
            border-radius: 12px;
            padding: 0.8rem;
            font-size: 1rem;
            font-weight: 600;
            color: #e6e6fa;
            text-transform: uppercase;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .social button:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(216, 175, 55, 0.3);
            border-color: #d4af37;
            color: #d4af37;
        }

        /* --- Status Message (Styled like No-data) --- */
        .status {
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
            .login-wrapper {
                padding: 1.5rem;
            }
            .login-card h2 {
                font-size: 2.2rem;
            }
            .social {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 1rem;
            }
            .login-card h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
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
                <input id="email" type="email" name="email" placeholder="you@example.com" required autofocus>

                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="••••••••" required>

                <div class="remember">
                    <input type="checkbox" id="remember_me" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>

                <div class="footer">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    @endif
                    <button type="submit" class="btn">Log in</button>
                </div>
            </form>

            <div class="divider"><span>or</span></div>

            <div class="social">
                <button class="facebook">Facebook</button>
                <button class="google">Google</button>
            </div>
        </div>
    </div>
</body>
</html>