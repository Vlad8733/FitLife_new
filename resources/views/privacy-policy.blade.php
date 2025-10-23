<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitLife - Privacy Policy</title>
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

        header.scrolled {
            box-shadow: var(--shadow);
            padding: 1rem 4rem;
        }

        .logo {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--accent);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
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

        @media (max-width: 768px) {
            header {
                padding: 1rem 2rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .logo {
                margin-bottom: 1rem;
            }

            .nav-links {
                flex-direction: column;
                gap: 1rem;
                width: 100%;
                display: none;
            }

            .nav-links.active {
                display: flex;
            }

            .auth-buttons {
                flex-direction: column;
                width: 100%;
                gap: 0.8rem;
            }

            .button {
                width: 100%;
                justify-content: center;
            }

            .content-section {
                padding: 6rem 1.5rem 4rem;
            }

            .content-section h1 {
                font-size: 2rem;
            }

            .content-section h2 {
                font-size: 1.5rem;
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
                font-size: 0.9rem;
            }
        }

        @media (prefers-contrast: high) {
            :root {
                --accent: #33ff33;
                --highlight: #66ff66;
                --border: #000000;
                --muted: #cccccc;
            }

            .content-section, footer {
                border-color: var(--accent);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .content-section {
                animation: none;
                transition: none;
            }
        }

        @media print {
            header, footer {
                display: none;
            }

            .content-section {
                background: none;
                box-shadow: none;
                border: 1px solid #000;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.addEventListener('scroll', () => {
                const header = document.querySelector('header');
                header.classList.toggle('scrolled', window.scrollY > 50);
            });

            const menuToggle = document.createElement('i');
            menuToggle.classList.add('fas', 'fa-bars');
            menuToggle.style.cursor = 'pointer';
            menuToggle.style.fontSize = '1.5rem';
            menuToggle.style.color = 'var(--accent)';
            menuToggle.style.display = 'none';
            document.querySelector('header').appendChild(menuToggle);

            if (window.innerWidth <= 768) {
                menuToggle.style.display = 'block';
            }

            menuToggle.addEventListener('click', () => {
                document.querySelector('.nav-links').classList.toggle('active');
            });
        });
    </script>
</head>

<body>
    <header>
        <img src="{{ asset('favicon.PNG') }}" alt="FitLife Logo" style="width: 50px; height: auto; display: block;">
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
            <h1>Privacy Policy</h1>
            <p>Last updated: October 22, 2025</p>

            <h2>1. Introduction</h2>
            <p>At FitLife, we are committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our website and services.</p>

            <h2>2. Information We Collect</h2>
            <p>We may collect the following types of information:</p>
            <ul>
                <li><strong>Personal Information:</strong> Name, email address, age, gender, and other information you provide when registering or updating your profile.</li>
                <li><strong>Health Data:</strong> Information about your workouts, nutrition, sleep, and other fitness-related data you input.</li>
                <li><strong>Usage Data:</strong> Information about how you interact with our website, such as IP address, browser type, and pages visited.</li>
                <li><strong>Device Data:</strong> Information about the devices you use to access our services, including device type and operating system.</li>
            </ul>

            <h2>3. How We Use Your Information</h2>
            <p>We use your information to:</p>
            <ul>
                <li>Provide and improve our services, such as personalized workout and nutrition plans.</li>
                <li>Communicate with you, including sending updates and notifications.</li>
                <li>Analyze usage patterns to enhance user experience.</li>
                <li>Ensure the security of our platform.</li>
            </ul>

            <h2>4. Sharing Your Information</h2>
            <p>We do not sell your personal information. We may share your information with:</p>
            <ul>
                <li><strong>Service Providers:</strong> Third-party vendors who assist with hosting, analytics, or payment processing.</li>
                <li><strong>Legal Authorities:</strong> When required by law or to protect our rights.</li>
                <li><strong>Community Features:</strong> Information you choose to share publicly, such as posts or comments.</li>
            </ul>

            <h2>5. Data Security</h2>
            <p>We implement industry-standard security measures to protect your data, including encryption and secure servers. However, no method of transmission over the internet is 100% secure.</p>

            <h2>6. Your Choices</h2>
            <p>You can:</p>
            <ul>
                <li>Access, update, or delete your personal information via your account settings.</li>
                <li>Opt out of promotional communications.</li>
                <li>Disable cookies through your browser settings, though this may affect functionality.</li>
            </ul>

            <h2>7. Cookies and Tracking</h2>
            <p>We use cookies to enhance your experience, such as remembering your preferences. You can manage cookie settings in your browser.</p>

            <h2>8. Third-Party Links</h2>
            <p>Our website may contain links to third-party sites. We are not responsible for their privacy practices.</p>

            <h2>9. Children’s Privacy</h2>
            <p>Our services are not intended for individuals under 13. We do not knowingly collect data from children.</p>

            <h2>10. Changes to This Policy</h2>
            <p>We may update this Privacy Policy from time to time. We will notify you of significant changes via email or a notice on our website.</p>

            <h2>11. Contact Us</h2>
            <p>If you have questions about this Privacy Policy, please contact us at <a href="mailto:support@fitlife.com">support@fitlife.com</a>.</p>
        </section>
    </main>

    <footer>
        <div class="logo">FitLife</div>
        <p>© {{ date('Y') }} FitLife. All rights reserved.</p>
        <div class="links">
            <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
            <a href="{{ route('terms-of-service') }}">Terms of Service</a>
            <a href="mailto:support@fitlife.com">Contact Us</a>
        </div>
    </footer>
</body>
</html>