<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitLife - Register</title>
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

        /* --- Register Wrapper --- */
        .register-wrapper {
            position: relative;
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
        }

        /* --- Register Card (Styled like Dashboard Header) --- */
        .register-card {
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

        .register-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 32px rgba(72, 201, 176, 0.2);
            border-color: #48c9b0;
        }

        .register-card .logo {
            width: 90px;
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        .register-card h2 {
            font-size: 3rem;
            font-weight: 800;
            color: #48c9b0;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 8px rgba(72, 201, 176, 0.3);
        }

        .register-card .subtitle {
            font-size: 1.2rem;
            color: #a3bffa;
            font-weight: 400;
            margin-bottom: 1.5rem;
        }

        .register-card .subtitle span {
            font-weight: 600;
            color: #d4af37;
        }

        .register-card label {
            display: block;
            text-align: left;
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            margin: 0.5rem 0;
        }

        .register-card input[type="text"],
        .register-card input[type="email"],
        .register-card input[type="password"] {
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

        .register-card input:focus {
            border-color: #48c9b0;
            outline: none;
        }

        /* --- Footer (Styled like Biography Card) --- */
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

        /* --- Animations --- */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* --- Responsive --- */
        @media (max-width: 768px) {
            .register-wrapper {
                padding: 1.5rem;
            }
            .register-card h2 {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 480px) {
            .register-card {
                padding: 1rem;
            }
            .register-card h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
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
                    <button type="submit" class="btn">Register</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>