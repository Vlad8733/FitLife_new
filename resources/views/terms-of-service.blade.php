<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>FitLife - Terms of Service</title>
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
            position: relative;
            transition: var(--transition);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: var(--accent);
            transition: var(--transition);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-links a:hover {
            color: var(--accent);
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
            transition: var(--transition);
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

        .button:hover {
            transform: translateY(-2px);
            background: var(--hover-bg);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.3);
        }

        .button:focus {
            outline: 2px solid var(--focus);
            outline-offset: 2px;
        }

        .content-section {
            padding: 8rem 2rem 5rem;
            max-width: 900px;
            margin: 0 auto;
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            animation: slideIn 0.5s ease-out;
        }

        .content-section h1 {
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .content-section h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--text);
            margin: 2rem 0 1rem;
        }

        .content-section p {
            font-size: 1rem;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        .content-section ul {
            list-style: disc;
            padding-left: 2rem;
            margin-bottom: 1rem;
            color: var(--muted);
        }

        .content-section li {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .content-section a {
            color: var(--accent);
            text-decoration: none;
            transition: var(--transition);
        }

        .content-section a:hover {
            color: var(--highlight);
            text-decoration: underline;
        }

        footer {
            background: var(--card-bg);
            padding: 3rem 2rem;
            border-top: 1px solid var(--border);
            text-align: center;
        }

        footer .logo {
            font-size: 1.5rem;
            margin-bottom: 1rem;
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
            transition: var(--transition);
        }

        footer .links a:hover {
            color: var(--highlight);
            text-decoration: underline;
        }

        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        a:focus, button:focus {
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
        }

        @media (prefers-reduced-motion: reduce) {
            .content-section {
                transition: none;
                animation: none;
            }
        }

        @media print {
            header, footer, .menu-toggle {
                display: none;
            }

            .content-section {
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

            .content-section {
                padding: 5rem 1rem 3rem;
            }

            .content-section h1 {
                font-size: 2rem;
            }

            .content-section h2 {
                font-size: 1.5rem;
            }

            .content-section p, .content-section li {
                font-size: 0.9rem;
            }

            footer {
                padding: 2rem 1rem;
            }

            footer .logo {
                font-size: 1.3rem;
            }

            footer p {
                font-size: 0.8rem;
            }

            footer .links a {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .content-section h1 {
                font-size: 1.8rem;
            }

            .content-section h2 {
                font-size: 1.3rem;
            }

            .content-section p, .content-section li {
                font-size: 0.8rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Header scroll effect
            window.addEventListener('scroll', () => {
                const header = document.querySelector('header');
            });

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
        <section class="content-section">
            <h1>Terms of Service</h1>
            <p>Last updated: October 22, 2025</p>

            <h2>1. Acceptance of Terms</h2>
            <p>By accessing or using FitLife, you agree to be bound by these Terms of Service. If you do not agree, please do not use our services.</p>

            <h2>2. Use of Services</h2>
            <p>You agree to use FitLife only for lawful purposes and in accordance with these Terms. You must:</p>
            <ul>
                <li>Be at least 13 years old to use our services.</li>
                <li>Provide accurate and complete information when creating an account.</li>
                <li>Not use our services to engage in illegal activities or violate the rights of others.</li>
            </ul>

            <h2>3. Account Responsibilities</h2>
            <p>You are responsible for maintaining the confidentiality of your account credentials and for all activities under your account.</p>

            <h2>4. User Content</h2>
            <p>You retain ownership of content you submit, such as posts, comments, or progress photos. By submitting content, you grant FitLife a non-exclusive, royalty-free license to use, display, and distribute it in connection with our services.</p>

            <h2>5. Prohibited Conduct</h2>
            <p>You agree not to:</p>
            <ul>
                <li>Post harmful, offensive, or unlawful content.</li>
                <li>Attempt to gain unauthorized access to our systems.</li>
                <li>Use automated scripts to scrape or collect data.</li>
            </ul>

            <h2>6. Intellectual Property</h2>
            <p>All content and materials on FitLife, including logos, designs, and software, are owned by FitLife or its licensors and protected by intellectual property laws.</p>

            <h2>7. Termination</h2>
            <p>We may suspend or terminate your account if you violate these Terms or engage in conduct that harms FitLife or its users.</p>

            <h2>8. Disclaimer of Warranties</h2>
            <p>FitLife is provided "as is" without warranties of any kind. We do not guarantee that our services will be uninterrupted or error-free.</p>

            <h2>9. Limitation of Liability</h2>
            <p>FitLife is not liable for any indirect, incidental, or consequential damages arising from your use of our services.</p>

            <h2>10. Governing Law</h2>
            <p>These Terms are governed by the laws of [Insert Jurisdiction]. Any disputes will be resolved in the courts of [Insert Jurisdiction].</p>

            <h2>11. Changes to Terms</h2>
            <p>We may update these Terms from time to time. We will notify you of significant changes via email or a notice on our website.</p>

            <h2>12. Contact Us</h2>
            <p>If you have questions about these Terms, please contact us at <a href="mailto:support@fitlife.com">support@fitlife.com</a>.</p>
        </section>
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