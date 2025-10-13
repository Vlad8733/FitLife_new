<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta tags for character encoding and viewport responsiveness -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page title -->
    <title>FitLife - Welcome</title>
    <title>{{ config('app.name', 'Welcome') }}</title>
    <link rel="icon" href="{{ asset('favicon.PNG') }}" type="image/png">
    <!-- External font import -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Inline CSS styles with modernized design: updated color palette for a fresher look, smoother transitions, and subtle gradients -->
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

        html,
        body {
            height: 100%;
            width: 100%;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }

        /* Header styles for authentication buttons */
        header {
            padding: 24px;
            text-align: right;
        }

        .auth-buttons {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        /* General typography styles */
        h2 {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 16px;
        }

        p {
            font-size: 0.95rem;
            color: var(--muted);
            margin-bottom: 12px;
        }

        /* Layout for sections with text and images */
        .flex-layout {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 24px;
            margin: 32px 24px;
            align-items: start;
        }

        .flex-layout.reverse {
            grid-template-columns: 350px 1fr;
        }

        /* Image placeholders with hover effects */
        .image-placeholder {
            width: 100%;
            max-width: 350px;
            height: 220px;
            background: linear-gradient(135deg, #e5e7eb, #d1d5db);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            transition: var(--transition);
            overflow: hidden;
        }

        .text-content {
            background: var(--card-bg);
            padding: 24px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            min-width: 0;
        }

        .image-placeholder:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        /* Button styles with hover effects */
        .button {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            background: var(--accent);
            color: #ffffff;
            border: none;
            border-radius: var(--radius);
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
        }

        .button:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        .button.primary {
            background: #ef4444;
        }

        .button.primary:hover {
            background: #dc2626;
        }

        .button svg {
            width: 20px;
            height: 20px;
            stroke: #ffffff;
        }

        /* Footer styles */
        footer {
            padding: 24px;
            background: #111827;
            color: #ffffff;
            text-align: center;
            margin-top: 32px;
        }

        footer p {
            color: #9ca3af;
            margin-bottom: 12px;
        }

        footer a {
            color: #3b82f6;
            font-weight: 500;
            text-decoration: none;
            margin: 0 12px;
            transition: 0.2s ease;
        }

        footer a:hover {
            color: #2563eb;
        }

        /* Intro and closing section styles */
        .intro-section,
        .closing-section {
            margin: 32px 0;
            text-align: left;
        }

        .intro-section h2,
        .closing-section h2 {
            text-align: center;
        }

        .intro-section p,
        .closing-section p {
            margin-left: auto;
            margin-right: auto;
            max-width: 100%;
            padding: 0 24px;
        }

        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            .flex-layout {
                grid-template-columns: 1fr;
            }

            .flex-layout.reverse {
                grid-template-columns: 1fr;
            }

            .image-placeholder {
                margin: 0 auto;
                max-width: 300px;
                height: 200px;
            }

            .intro-section,
            .closing-section {
                margin: 24px 0;
            }

            .intro-section p,
            .closing-section p {
                padding: 0 16px;
            }

            h2 {
                font-size: 1.5rem;
            }

            p {
                font-size: 0.9rem;
            }

            .auth-buttons {
                flex-direction: column;
                gap: 8px;
                align-items: flex-end;
            }

            header {
                padding: 16px;
            }

            footer {
                padding: 16px;
            }

            footer a {
                margin: 0 8px;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 1.25rem;
            }

            p {
                font-size: 0.85rem;
            }

            .button {
                width: 100%;
                justify-content: center;
            }

            .image-placeholder {
                max-width: 250px;
                height: 180px;
            }
        }

        /* Animation for fade-in effect */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <!-- Header with authentication buttons -->
    <header>
        <div class="auth-buttons">
            @if(Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="button primary">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#FFFFFF">
                            <path
                                d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z" />
                        </svg>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#FFFFFF">
                            <path
                                d="M480-120v-80h280v-560H480v-80h280q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H480Zm-80-160-55-58 102-102H120v-80h327L345-622l55-58 200 200-200 200Z" />
                        </svg>
                        Log in
                    </a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="button primary">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#FFFFFF">
                                <path
                                    d="M720-400v-120H600v-80h120v-120h80v120h120v80H800v120h-80Zm-360-80q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm80-80h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0-80Zm0 400Z" />
                            </svg>
                            Sign up
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </header>

    <!-- Introductory section with welcome text -->
    <section class="intro-section">
        <h2 id="intro-heading">Welcome to FitLife</h2>
        <p>FitLife empowers your fitness journey with a sleek platform. Track nutrition, sleep, hydration, and workouts
            with ease. Whether you're starting out or a seasoned athlete, we’ve got the tools to elevate your game.
            Ignite your potential and thrive!</p>
        <p>Life gets busy, but FitLife keeps you on track. Log your meals, plan workouts, and analyze progress—all in
            one hub. Our team builds intuitive features with expert input. Join our community and unlock tips on
            flexibility and recovery!</p>
        <p>Discover guides on strength training, cardio efficiency, and injury avoidance. Watch tutorials for flawless
            form on key exercises!</p>
    </section>

    <!-- Training section with image and text -->
    <div class="flex-layout reverse" aria-labelledby="training-heading">
        <img src="{{ asset('storage/WelcomePhoto/training.jpg') }}" alt="Training photo" class="image-placeholder">
        <div class="text-content">
            <h2 id="training-heading">Training Mastery</h2>
            <p>FitLife turns your workouts into a personalized masterpiece. Get plans for muscle gain, fat loss, or
                endurance. Log every set and let our AI fine-tune your results.</p>
            <p>Start with beginner routines featuring video guides, or build pro-level programs. Mix strength, cardio,
                or yoga with our tools. Boost your energy and track growth from basics to advanced lifts!</p>
            <p>Explore HIIT techniques, optimize rest, and perfect compound lifts. FitLife tracks your milestones and
                suggests recovery breaks.</p>
        </div>
    </div>

    <!-- Nutrition section with text and image -->
    <div class="flex-layout" aria-labelledby="nutrition-heading">
        <div class="text-content">
            <h2 id="nutrition-heading">Nutrition Edge</h2>
            <p>FitLife is your nutrition control center. Track macros, scan foods, and dive into our database. Our AI
                designs diets for your goals and lifestyle.</p>
            <p>Enhance performance with proteins for repair, carbs for power, and fats for balance. Try pre-workout oats
                or post-workout shakes. Swap junk for superfoods with our plans!</p>
            <p>Master carb cycles, vitamin benefits, and hydration tips. FitLife alerts you to replenish electrolytes
                after intense sessions.</p>
        </div>
        <img src="{{ asset('storage/WelcomePhoto/nutrition.jpg') }}" alt="Nutrition photo" class="image-placeholder">
    </div>

    <!-- Community section with image and text -->
    <div class="flex-layout reverse" aria-labelledby="community-heading">
        <img src="{{ asset('storage/WelcomePhoto/community.jpg') }}" alt="Community photo" class="image-placeholder">
        <div class="text-content">
            <h2 id="community-heading">Community Pulse</h2>
            <p>FitLife is a dynamic community for fitness enthusiasts. Share wins, connect, and inspire each other. Post
                updates and join challenges to stay fired up.</p>
            <p>Find workout buddies or recipe swaps! Participate in virtual races, earn rewards, and celebrate every
                step. Our forums cover marathon prep and group sessions. Join monthly expert Q&As!</p>
            <p>Display your progress, debate fitness gear, and get advice. We also organize charity runs for good
                causes.</p>
        </div>
    </div>

    <!-- Sleep section with text and image -->
    <div class="flex-layout" aria-labelledby="sleep-heading">
        <div class="text-content">
            <h2 id="sleep-heading">Sleep Boost</h2>
            <p>FitLife optimizes your sleep for top performance. Track cycles, hours, and quality with our insights.
                Wake up ready to dominate.</p>
            <p>7-9 hours fuels recovery and stamina. Get bedtime reminders and relaxation methods like deep breathing.
                Reduce screen time and perfect your sleep environment!</p>
            <p>Learn sleep stages, manage caffeine, and use naps effectively. FitLife syncs sleep with your workout
                schedule.</p>
        </div>
        <img src="{{ asset('storage/WelcomePhoto/sleep.jpg') }}" alt="Sleep photo" class="image-placeholder">
    </div>

    <!-- Closing section with call to action text -->
    <section class="closing-section">
        <h2 id="start-heading">Start Your FitLife Adventure</h2>
        <p>FitLife is your complete fitness ecosystem. Blend tech and expertise for an amazing journey. Monitor
            everything, refine workouts, nail nutrition, and connect—all here. Join now and evolve!</p>
        <p>We’re adding smartwatch features, custom plans, and live coaching. Check our blog for trends, safety tips,
            and mental strength. FitLife is your lifestyle—dive in!</p>
        <p>Grab our workout guides, join online sessions, and subscribe for daily boosts. Track advanced metrics like
            VO2 max. FitLife drives every goal—start today!</p>
    </section>

    <!-- Footer with copyright, contact, and links -->
    <footer>
        <p>© {{ date('Y') }} FitLife. All rights reserved.</p>
        <p>Contact: supportFitLife@gmail.com | Follow us: @FitLifeOfficial</p>
        <div style="display: inline-block;">
            <a href="#" style="margin: 0 12px;">Privacy</a>
            <a href="#" style="margin: 0 12px;">Terms</a>
            <a href="#" style="margin: 0 12px;">Help</a>
        </div>
    </footer>
</body>

</html>