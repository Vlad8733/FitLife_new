<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitLife - Your Path to Wellness</title>
    <link rel="icon" href="{{ asset('favicon.PNG') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        :root {
            --bg: #121212; /* Dark background */
            --text: #e5e5e5; /* Light text */
            --accent: #00ff00; /* Salatovy green accent */
            --muted: #a0a0a0; /* Muted text */
            --card-bg: #1f1f1f; /* Dark card background */
            --border: #333333; /* Dark border */
            --radius: 12px; /* Rounded corners */
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            --transition: 0.3s ease; /* Smooth transitions */
            --highlight: #00cc00; /* Darker green for hover */
            --danger: #ff5555; /* Red for alerts */
            --success: #00ff00; /* Green for success */
            --focus: #33ff33; /* Focus state green */
            --hover-bg: #000000; /* Hover background */
        }

        /* Light mode support */
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

        /* Scrollbar */
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

        /* Header */
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

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--card-bg) 0%, var(--border) 100%);
            padding: 20rem 2rem 6rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            min-height: 80vh;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(0, 255, 0, 0.1) 0%, transparent 70%);
            opacity: 0.3;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero p {
            font-size: 1.3rem;
            color: var(--muted);
            max-width: 800px;
            margin: 0 auto 2rem;
            font-weight: 300;
        }

        .hero .call-to-action {
            background: var(--accent);
            color: var(--bg);
            padding: 1rem 2.5rem;
            border-radius: var(--radius);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: var(--shadow);
        }

        .hero .call-to-action:hover {
            background: var(--highlight);
            transform: scale(1.05);
        }

        /* Sections */
        .section {
            padding: 5rem 2rem;
            max-width: 1300px;
            margin: 0 auto;
            min-height: 50vh; /* Ensure sections are visible */
        }

        .section h2 {
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--text);
            text-align: center;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--accent);
            padding-bottom: 0.5rem;
        }

        .section p {
            font-size: 1.2rem;
            color: var(--muted);
            max-width: 900px;
            margin: 0 auto 2rem;
            text-align: center;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            transition: var(--transition);
            overflow: hidden;
            position: relative;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            border-color: var(--accent);
        }

        .feature-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: var(--transition);
        }

        .feature-card:hover img {
            transform: scale(1.05);
        }

        .feature-card .content {
            padding: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 0.5rem;
        }

        .feature-card p {
            font-size: 1rem;
            color: var(--muted);
            text-align: left;
        }

        /* Testimonials Section */
        .testimonials {
            background: var(--bg);
            padding: 5rem 2rem;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1300px;
            margin: 2rem auto 0;
        }

        .testimonial-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 2rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent);
        }

        .testimonial-card i {
            font-size: 2rem;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .testimonial-card p {
            font-size: 1.1rem;
            color: var(--muted);
            font-style: italic;
            margin-bottom: 1rem;
        }

        .testimonial-card .author {
            font-size: 1rem;
            font-weight: 600;
            color: var(--success);
        }

        /* Pricing Section */
        .pricing {
            padding: 5rem 2rem;
            background: linear-gradient(to bottom, var(--bg), var(--card-bg));
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1300px;
            margin: 2rem auto 0;
        }

        .pricing-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 2rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
        }

        .pricing-card.popular {
            border: 2px solid var(--accent);
            transform: scale(1.05);
        }

        .pricing-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.3);
        }

        .pricing-card h3 {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .pricing-card .price {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .pricing-card ul {
            list-style: none;
            margin-bottom: 1.5rem;
        }

        .pricing-card li {
            font-size: 1rem;
            color: var(--muted);
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .pricing-card li i {
            color: var(--success);
        }

        .pricing-card .call-to-action {
            background: var(--accent);
            color: var(--bg);
            padding: 0.8rem 2rem;
            border-radius: var(--radius);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .pricing-card .call-to-action:hover {
            background: var(--highlight);
        }

        /* FAQ Section */
        .faq {
            padding: 5rem 2rem;
        }

        .faq-accordion {
            max-width: 900px;
            margin: 2rem auto 0;
        }

        .faq-item {
            background: var(--card-bg);
            border-radius: var(--radius);
            margin-bottom: 1rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .faq-question {
            padding: 1.5rem 2rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            color: var(--text);
            transition: var(--transition);
        }

        .faq-question:hover {
            background: var(--hover-bg);
        }

        .faq-question i {
            color: var(--accent);
            transition: var(--transition);
        }

        .faq-question.active i {
            transform: rotate(180deg);
        }

        .faq-answer {
            display: none;
            padding: 0 2rem 1.5rem;
            font-size: 1rem;
            color: var(--muted);
        }

        .faq-answer.active {
            display: block;
        }

        /* Lightbox */
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
            max-width: 900px;
            width: 100%;
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 1rem;
            box-shadow: var(--shadow);
            position: relative;
        }

        #lightbox-img {
            width: 100%;
            max-height: 70vh;
            object-fit: contain;
            border-radius: var(--radius);
            border: 2px solid var(--accent);
            transition: var(--transition);
        }

        #lightbox-img:hover {
            border-color: var(--highlight);
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
            transition: var(--transition);
        }

        .lightbox-close:hover {
            color: var(--highlight);
            transform: scale(1.1);
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: var(--accent);
            color: var(--bg);
            border: none;
            padding: 0.5rem;
            border-radius: var(--radius);
            cursor: pointer;
            transition: var(--transition);
        }

        .lightbox-nav:hover {
            background: var(--highlight);
            transform: translateY(-50%) scale(1.1);
        }

        .lightbox-nav.prev {
            left: 0.5rem;
        }

        .lightbox-nav.next {
            right: 0.5rem;
        }

        /* Footer */
        footer {
            background: var(--card-bg);
            padding: 3rem 2rem;
            border-top: 1px solid var(--border);
            text-align: center;
            min-height: 200px; /* Ensure footer is visible */
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

        footer .social-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        footer .social-links a {
            color: var(--text);
            font-size: 1.3rem;
            transition: var(--transition);
        }

        footer .social-links a:hover {
            color: var(--accent);
            transform: scale(1.2);
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

        /* Animations */
        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .hero h1, .section, .feature-card, .testimonial-card, .pricing-card, .faq-item {
            animation: slideIn 0.5s ease-out;
        }

        /* Accessibility */
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

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero h1 {
                font-size: 3rem;
            }

            .section h2 {
                font-size: 2rem;
            }

            .feature-card img {
                height: 200px;
            }
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

            .hero {
                padding: 6rem 1.5rem 4rem;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .feature-grid, .testimonial-grid, .pricing-grid {
                grid-template-columns: 1fr;
            }

            .pricing-card.popular {
                transform: none;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 2rem;
            }

            .section h2 {
                font-size: 1.8rem;
            }

            .section p {
                font-size: 1rem;
            }

            .feature-card img {
                height: 180px;
            }
        }

        /* High Contrast Mode */
        @media (prefers-contrast: high) {
            :root {
                --accent: #33ff33;
                --highlight: #66ff66;
                --border: #000000;
                --muted: #cccccc;
            }

            .feature-card, .pricing-card, .testimonial-card, .faq-item {
                border-color: var(--accent);
            }
        }

        /* Reduced Motion */
        @media (prefers-reduced-motion: reduce) {
            .feature-card, .pricing-card, .testimonial-card, .faq-item, .hero h1 {
                transition: none;
                animation: none;
            }
        }

        /* Print Styles */
        @media print {
            #lightbox {
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
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Header scroll effect
            window.addEventListener('scroll', () => {
                const header = document.querySelector('header');
                header.classList.toggle('scrolled', window.scrollY > 50);
            });

            // Mobile menu toggle
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

            // FAQ accordion
            document.querySelectorAll('.faq-question').forEach(question => {
                question.addEventListener('click', () => {
                    question.classList.toggle('active');
                    const answer = question.nextElementSibling;
                    answer.classList.toggle('active');
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
        });
    </script>
</head>

<body>
    <header>
        <img src="{{ asset('favicon.PNG') }}" alt="FitLife Logo" style="width: 50px; height: auto; display: block;">
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
        <section class="hero">
            <h1>Transform Your Life with FitLife</h1>
            <p>Discover a smarter way to achieve your fitness goals with our all-in-one platform. Track workouts, nutrition, and sleep, and join a vibrant community to stay motivated.</p>
        </section>

        <section class="section" id="features">
            <h2>Why FitLife?</h2>
            <p>Empower your wellness journey with tools designed for real results.</p>
            <div class="feature-grid">
                <div class="feature-card">
                    <img src="{{ asset('storage/WelcomePhoto/training.jpg') }}" alt="Person lifting weights" tabindex="0">
                    <div class="content">
                        <h3>Personalized Workouts</h3>
                        <p>Create custom workout plans tailored to your goals strength, endurance, or weight loss. Access video tutorials, track progress, and sync with wearables for real-time analytics.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('storage/WelcomePhoto/nutrition.jpg') }}" alt="Healthy meal" tabindex="0">
                    <div class="content">
                        <h3>Smart Nutrition</h3>
                        <p>Log meals with our extensive food database, calculate macros, and get personalized diet plans. Discover recipes and hydration tips to fuel your body.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('storage/WelcomePhoto/sleep.jpg') }}" alt="Peaceful bedroom" tabindex="0">
                    <div class="content">
                        <h3>Restful Sleep</h3>
                        <p>Monitor sleep patterns and get insights to improve rest. Sync with devices to analyze sleep quality and optimize recovery.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('storage/WelcomePhoto/community.jpg') }}" alt="Group exercise" tabindex="0">
                    <div class="content">
                        <h3>Vibrant Community</h3>
                        <p>Join a supportive network to share goals, participate in challenges, and connect with fitness enthusiasts worldwide.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('storage/WelcomePhoto/progress.jpg') }}" alt="Progress tracking dashboard" tabindex="0">
                    <div class="content">
                        <h3>Progress Tracking</h3>
                        <p>Visualize your fitness journey with detailed progress charts and analytics. Set milestones and celebrate your achievements with data-driven insights.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('storage/WelcomePhoto/goalsetting.jpg') }}" alt="Mindfulness meditation" tabindex="0">
                    <div class="content">
                        <h3>Goal Setting</h3>
                        <p>Set and track your fitness goals with ease. Define milestones, monitor achievements, and stay motivated with personalized progress updates.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="testimonials section" id="testimonials">
            <h2>What Our Users Say</h2>
            <p>Real stories from people who transformed their lives with FitLife.</p>
            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <i class="fas fa-quote-left"></i>
                    <p>"FitLife made fitness fun and achievable. I lost 15 pounds and feel stronger than ever!"</p>
                    <div class="author">- Anna K., Fitness Enthusiast</div>
                </div>
                <div class="testimonial-card">
                    <i class="fas fa-quote-left"></i>
                    <p>"The nutrition tracker is a game-changer. It helped me balance my diet effortlessly."</p>
                    <div class="author">- Mark S., Busy Professional</div>
                </div>
                <div class="testimonial-card">
                    <i class="fas fa-quote-left"></i>
                    <p>"Better sleep improved my workouts. FitLife's insights are incredible!"</p>
                    <div class="author">- Lisa M., Marathon Runner</div>
                </div>
            </div>
        </section>

        <section class="section" id="about">
            <h2>About FitLife</h2>
            <p>Since 2020, FitLife has empowered millions to live healthier lives with intuitive tools and a supportive community. Our mission is to make wellness accessible to all.</p>
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
        <div class="logo">FitLife</div>
        <p>© {{ date('Y') }} FitLife. All rights reserved.</p>

        <div class="links">
            <a href="https://fitlife.com/privacy" target="_blank">Privacy Policy</a>
            <a href="https://fitlife.com/terms" target="_blank">Terms of Service</a>
            <a href="mailto:support@fitlife.com">Contact Us</a>
        </div>
    </footer>
</body>
</html>