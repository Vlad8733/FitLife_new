<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>FitLife - Your Path to Wellness</title>
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

        .hero {
            background: linear-gradient(135deg, var(--card-bg) 0%, var(--border) 100%);
            padding: 8rem 2rem 5rem;
            text-align: center;
            position: relative;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 1.5rem;
            animation: slideIn 0.5s ease-out;
        }

        .hero p {
            font-size: 1.2rem;
            color: var(--muted);
            max-width: 600px;
            margin: 0 auto 2rem;
            animation: slideIn 0.7s ease-out;
        }

        .hero .call-to-action {
            background: var(--accent);
            color: var(--bg);
            padding: 1rem 2rem;
            border-radius: var(--radius);
            font-weight: 600;
            text-decoration: none;
            box-shadow: var(--shadow);
            transition: var(--transition);
            animation: slideIn 0.9s ease-out;
        }

        .hero .call-to-action:hover {
            background: var(--highlight);
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.3);
        }

        .section {
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section h2 {
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--text);
            text-align: center;
            margin-bottom: 1rem;
        }

        .section p {
            font-size: 1.1rem;
            color: var(--muted);
            max-width: 600px;
            margin: 0 auto 2rem;
            text-align: center;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .feature-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            transition: var(--transition);
            overflow: hidden;
        }

        .feature-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: var(--transition);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        .feature-card:hover img {
            transform: scale(1.05);
        }

        .feature-card .content {
            padding: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            font-size: 1rem;
            color: var(--muted);
        }

        .testimonials {
            background: var(--bg);
            padding: 5rem 2rem;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .testimonial-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 2rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            text-align: center;
            transition: var(--transition);
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        .testimonial-card i {
            font-size: 2rem;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .testimonial-card p {
            font-size: 1rem;
            color: var(--muted);
            font-style: italic;
            margin-bottom: 1rem;
        }

        .testimonial-card .author {
            font-size: 1rem;
            font-weight: 600;
            color: var(--success);
        }

        .section#about {
            padding: 5rem 2rem;
        }

        #lightbox {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
            align-items: center;
            justify-content: center;
            padding: 1rem;
            z-index: 2000;
        }

        #lightbox[aria-hidden="false"] {
            display: flex;
        }

        .lightbox-content {
            max-width: 90%;
            width: 100%;
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 1rem;
            box-shadow: var(--shadow);
            position: relative;
        }

        #lightbox-img {
            width: 100%;
            max-height: 80vh;
            object-fit: contain;
            border-radius: var(--radius);
            border: 2px solid var(--accent);
        }

        .lightbox-close {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--accent);
            cursor: pointer;
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: var(--accent);
            color: var(--bg);
            border: none;
            padding: 0.75rem;
            border-radius: var(--radius);
            cursor: pointer;
        }

        .lightbox-nav.prev {
            left: 0.5rem;
        }

        .lightbox-nav.next {
            right: 0.5rem;
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

        a:focus, button:focus, .feature-card img:focus {
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
            .feature-card, .testimonial-card, .hero h1, .hero p, .hero .call-to-action {
                transition: none;
                animation: none;
            }
        }

        @media print {
            #lightbox, header, .menu-toggle {
                display: none;
            }

            .hero, .section, footer {
                background: none;
                border: none;
            }

            .feature-card img {
                border: 1px solid #000;
            }
        }

        /* Mobile and Tablet Optimizations */
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

            .hero {
                padding: 5rem 1rem 3rem;
                min-height: 50vh;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
                max-width: 90%;
            }

            .hero .call-to-action {
                padding: 0.75rem 1.5rem;
            }

            .section {
                padding: 3rem 1rem;
            }

            .section h2 {
                font-size: 1.8rem;
            }

            .section p {
                font-size: 0.9rem;
                max-width: 90%;
            }

            .feature-grid, .testimonial-grid {
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
            }

            .feature-card img {
                height: 180px;
            }

            .feature-card h3 {
                font-size: 1.4rem;
            }

            .feature-card p {
                font-size: 0.9rem;
            }

            .testimonial-card {
                padding: 1.5rem;
            }

            .testimonial-card i {
                font-size: 1.5rem;
            }

            .testimonial-card p, .testimonial-card .author {
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
            .hero h1 {
                font-size: 1.8rem;
            }

            .hero p {
                font-size: 0.9rem;
            }

            .section h2 {
                font-size: 1.6rem;
            }

            .section p {
                font-size: 0.8rem;
            }

            .feature-card h3 {
                font-size: 1.2rem;
            }

            .feature-card p {
                font-size: 0.8rem;
            }

            .testimonial-card p, .testimonial-card .author {
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

            // Lightbox for images
            const images = document.querySelectorAll('.feature-card img');
            const lightbox = document.querySelector('#lightbox');
            const lightboxImg = document.querySelector('#lightbox-img');
            const lightboxClose = document.querySelector('.lightbox-close');
            const prevBtn = document.querySelector('.lightbox-nav.prev');
            const nextBtn = document.querySelector('.lightbox-nav.next');
            let currentIndex = 0;

            images.forEach((img, index) => {
                img.addEventListener('click', () => {
                    currentIndex = index;
                    lightboxImg.src = img.src;
                    lightboxImg.alt = img.alt;
                    lightbox.setAttribute('aria-hidden', 'false');
                });
            });

            lightboxClose.addEventListener('click', () => {
                lightbox.setAttribute('aria-hidden', 'true');
            });

            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                lightboxImg.src = images[currentIndex].src;
                lightboxImg.alt = images[currentIndex].alt;
            });

            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % images.length;
                lightboxImg.src = images[currentIndex].src;
                lightboxImg.alt = images[currentIndex].alt;
            });

            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) {
                    lightbox.setAttribute('aria-hidden', 'true');
                }
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
        <h1 style="position:absolute; left:-9999px;">Welcome</h1>
        <section class="hero">
            <h1>Transform Your Life with FitLife</h1>
            <p>Discover a smarter way to achieve your fitness goals with our all-in-one platform.</p>
        </section>

        <section class="section" id="features">
            <h2>Why FitLife?</h2>
            <p>Tools designed for real results.</p>
            <div class="feature-grid">
                <div class="feature-card">
                    <img src="{{ asset('storage/WelcomePhoto/training.jpg') }}" alt="Person lifting weights" tabindex="0">
                    <div class="content">
                        <h3>Personalized Workouts</h3>
                        <p>Create custom workout plans tailored to your goals. Access tutorials and sync with wearables.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('storage/WelcomePhoto/nutrition.jpg') }}" alt="Healthy meal" tabindex="0">
                    <div class="content">
                        <h3>Smart Nutrition</h3>
                        <p>Log meals, calculate macros, and get personalized diet plans with recipes.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('storage/WelcomePhoto/sleep.jpg') }}" alt="Peaceful bedroom" tabindex="0">
                    <div class="content">
                        <h3>Restful Sleep</h3>
                        <p>Monitor sleep patterns and get insights to optimize recovery.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('storage/WelcomePhoto/community.jpg') }}" alt="Group exercise" tabindex="0">
                    <div class="content">
                        <h3>Vibrant Community</h3>
                        <p>Join a supportive network to share goals and participate in challenges.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('storage/WelcomePhoto/progress.jpg') }}" alt="Progress tracking dashboard" tabindex="0">
                    <div class="content">
                        <h3>Progress Tracking</h3>
                        <p>Visualize your journey with progress charts and analytics.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('storage/WelcomePhoto/goalsetting.jpg') }}" alt="Mindfulness meditation" tabindex="0">
                    <div class="content">
                        <h3>Goal Setting</h3>
                        <p>Set and track fitness goals with personalized updates.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="testimonials section" id="testimonials">
            <h2>What Our Users Say</h2>
            <p>Real stories from FitLife users.</p>
            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <i class="fas fa-quote-left"></i>
                    <p>"FitLife made fitness fun. I lost 15 pounds!"</p>
                    <div class="author">- Anna K.</div>
                </div>
                <div class="testimonial-card">
                    <i class="fas fa-quote-left"></i>
                    <p>"The nutrition tracker is a game-changer."</p>
                    <div class="author">- Mark S.</div>
                </div>
                <div class="testimonial-card">
                    <i class="fas fa-quote-left"></i>
                    <p>"Better sleep improved my workouts."</p>
                    <div class="author">- Lisa M.</div>
                </div>
            </div>
        </section>

        <section class="section" id="about">
            <h2>About FitLife</h2>
            <p>Since 2020, FitLife has empowered millions to live healthier lives.</p>
        </section>
    </main>

    <div id="lightbox" aria-hidden="true">
        <div class="lightbox-content">
            <img id="lightbox-img" src="" alt="">
            <button class="lightbox-close"><i class="fas fa-times"></i></button>
            <button class="lightbox-nav prev"><i class="fas fa-chevron-left"></i></button>
            <button class="lightbox-nav next"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>

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