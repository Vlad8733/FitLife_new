@extends('layouts.app')

@section('content')
    <style>
        /* ====== Reset ====== */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body,
        #app {
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

        /* ====== Layout ====== */
        #fitlife-container {
            display: flex;
            min-height: 100vh;
            width: 100vw;
            background: var(--bg);
            overflow: hidden;
        }

        /* ====== Sidebar ====== */
        aside#sidebar {
            width: 280px;
            background: linear-gradient(180deg, #14171C, #0C1014);
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            z-index: 1200;
        }

        @media (max-width: 960px) {
            aside#sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                transform: translateX(-100%);
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.8);
            }

            body.sidebar-open aside#sidebar {
                transform: translateX(0);
            }
        }

        .sidebar-header {
            text-align: center;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--glass);
        }

        .sidebar-header h2 {
            font-size: 1.6rem;
            color: var(--neon);
            font-weight: var(--font-weight-bold);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .sidebar-header p {
            font-size: 0.85rem;
            color: var(--muted);
            margin-top: 4px;
        }

        nav.nav-menu {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 12px;
        }

        nav.nav-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--white);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: var(--font-weight-medium);
            border-radius: 10px;
            background: var(--glass);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        nav.nav-menu a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 255, 136, 0.1), transparent);
            transition: left 0.5s ease;
        }

        nav.nav-menu a:hover::before {
            left: 100%;
        }

        nav.nav-menu a svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: var(--neon);
            transition: transform 0.2s ease, stroke 0.2s ease;
        }

        nav.nav-menu a:hover {
            background: rgba(0, 255, 136, 0.08);
            transform: translateX(6px);
        }

        nav.nav-menu a:hover svg {
            transform: scale(1.1);
            stroke: var(--accent);
        }

        nav.nav-menu a.active {
            background: linear-gradient(90deg, rgba(0, 255, 136, 0.15), rgba(255, 61, 0, 0.1));
            color: var(--neon);
            box-shadow: var(--glow);
        }

        /* ====== Unified Button Styles ====== */
        button,
        .logout-form button,
        .post-actions button,
        .comment-form button,
        .reply-form button {
            padding: 8px 12px;
            background: linear-gradient(90deg, var(--neon), var(--accent));
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
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

        button:hover,
        .logout-form button:hover,
        .post-actions button:hover,
        .comment-form button:hover,
        .reply-form button:hover {
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.6);
            background: linear-gradient(90deg, var(--accent), var(--neon));
        }

        button::before,
        .logout-form button::before,
        .post-actions button::before,
        .comment-form button::before,
        .reply-form button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.4s ease;
        }

        button:hover::before,
        .logout-form button:hover::before,
        .post-actions button:hover::before,
        .comment-form button:hover::before,
        .reply-form button:hover::before {
            left: 100%;
        }

        button svg,
        .logout-form button svg,
        .post-actions button svg,
        .comment-form button svg,
        .reply-form button svg {
            width: 14px;
            height: 14px;
            stroke: var(--white);
        }

        /* ====== Main Content ====== */
        main {
            flex: 1;
            padding: 32px;
            background: var(--bg);
            min-height: 100vh;
            overflow-y: auto;
        }

        #mobile-toggle {
            display: none;
            padding: 8px 12px;
            background: linear-gradient(90deg, var(--neon), var(--accent));
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: var(--font-weight-bold);
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--glow);
            position: relative;
            overflow: hidden;
        }

        #mobile-toggle:hover {
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.6);
            background: linear-gradient(90deg, var(--accent), var(--neon));
        }

        #mobile-toggle::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.4s ease;
        }

        #mobile-toggle:hover::before {
            left: 100%;
        }

        @media (max-width: 960px) {
            #mobile-toggle {
                display: inline-block;
            }
        }

        header {
            background: var(--panel);
            padding: 24px;
            border-radius: var(--radius);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            box-shadow: var(--shadow);
            margin-bottom: 24px;
        }

        .header-left h1 {
            font-size: 1.8rem;
            font-weight: var(--font-weight-bold);
            color: var(--neon);
            margin: 0;
        }

        .header-left p {
            font-size: 0.9rem;
            color: var(--muted);
            margin: 4px 0 0;
        }

        /* ====== Post Form ====== */
        .post-form {
            background: linear-gradient(135deg, var(--panel), #1A1F26);
            padding: 16px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 24px;
            animation: fadeIn 0.5s var(--animation-ease);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .post-form textarea,
        .post-form input[type="text"],
        .post-form input[type="file"] {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: none;
            background: var(--glass);
            color: var(--white);
            font-size: 0.9rem;
            transition: box-shadow 0.3s ease;
        }

        .post-form textarea:focus,
        .post-form input[type="text"]:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--neon);
        }

        .post-form textarea::placeholder,
        .post-form input[type="text"]::placeholder {
            color: var(--muted);
        }

        .post-form input[type="file"] {
            padding: 8px;
        }

        /* ====== Post Card ====== */
        .post-card {
            background: linear-gradient(135deg, var(--panel), #1A1F26);
            padding: 16px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 16px;
            transition: var(--transition);
            animation: fadeIn 0.5s var(--animation-ease);
            display: flex;
            gap: 12px;
        }

        .post-card:hover {
            box-shadow: var(--glow), var(--shadow);
            transform: translateY(-2px);
        }

        .post-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(0, 255, 136, 0.15), rgba(255, 61, 0, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .post-icon svg {
            width: 24px;
            height: 24px;
            stroke: var(--neon);
            transition: transform 0.3s ease;
        }

        .post-card:hover .post-icon svg {
            transform: rotate(10deg);
        }

        .post-body {
            flex: 1;
        }

        .post-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .post-header h4 {
            font-size: 0.9rem;
            color: var(--neon);
            font-weight: var(--font-weight-bold);
            margin: 0;
        }

        .post-header .muted {
            font-size: 0.8rem;
        }

        .post-image {
            margin: 12px 0;
        }

        .post-image img {
            width: 100%;
            max-width: 300px;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: var(--shadow);
            transition: transform 0.4s ease;
        }

        .post-image:hover img {
            transform: scale(1.08);
        }

        .post-content .value {
            font-size: 0.9rem;
            color: var(--white);
            font-weight: var(--font-weight-medium);
            margin-bottom: 8px;
        }

        /* ====== Post Actions ====== */
        .post-actions {
            display: flex;
            gap: 8px;
            margin-top: 8px;
            flex-wrap: wrap;
        }

        .post-actions form {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .post-actions input[type="text"],
        .post-actions input[type="file"] {
            padding: 8px;
            font-size: 0.85rem;
            border-radius: 8px;
            border: none;
            background: var(--glass);
            color: var(--white);
        }

        .post-actions input[type="text"]:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--neon);
        }

        /* ====== Comments ====== */
        .comment-section {
            margin-top: 16px;
            padding: 12px;
            background: var(--glass);
            border-radius: 10px;
            box-shadow: var(--shadow);
        }

        .comment {
            margin-bottom: 12px;
            display: flex;
            gap: 12px;
        }

        .comment-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: linear-gradient(135deg, rgba(0, 255, 136, 0.1), rgba(255, 61, 0, 0.05));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .comment-icon svg {
            width: 18px;
            height: 18px;
            stroke: var(--neon);
            transition: transform 0.3s ease;
        }

        .comment:hover .comment-icon svg {
            transform: rotate(10deg);
        }

        .comment-body {
            flex: 1;
        }

        .comment-header {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 4px;
        }

        .comment-header h4 {
            font-size: 0.85rem;
            color: var(--neon);
            font-weight: var(--font-weight-medium);
        }

        .comment-header .muted {
            font-size: 0.75rem;
        }

        .comment-content {
            font-size: 0.85rem;
            color: var(--white);
        }

        .replies {
            margin-left: 24px;
            margin-top: 8px;
            padding-left: 12px;
            border-left: 1px solid var(--glass);
        }

        .reply {
            display: flex;
            gap: 8px;
            margin-bottom: 8px;
        }

        .reply-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, rgba(0, 255, 136, 0.08), rgba(255, 61, 0, 0.04));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .reply-icon svg {
            width: 16px;
            height: 16px;
            stroke: var(--neon);
            transition: transform 0.3s ease;
        }

        .reply:hover .reply-icon svg {
            transform: rotate(10deg);
        }

        .reply-body h4 {
            font-size: 0.8rem;
            color: var(--neon);
            font-weight: var(--font-weight-medium);
            margin-bottom: 4px;
        }

        .reply-body p {
            font-size: 0.8rem;
            color: var(--white);
        }

        /* ====== Comment Form ====== */
        .comment-form,
        .reply-form {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }

        .comment-form input[type="text"],
        .reply-form input[type="text"] {
            flex: 1;
            padding: 8px;
            font-size: 0.85rem;
            border-radius: 8px;
            border: none;
            background: var(--glass);
            color: var(--white);
        }

        .comment-form input[type="text"]:focus,
        .reply-form input[type="text"]:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--neon);
        }

        /* ====== Divider ====== */
        .divider {
            height: 6px;
            background: var(--glass);
            border-radius: 4px;
            margin: 24px 0;
            position: relative;
            overflow: hidden;
        }

        .divider .fill {
            height: 100%;
            background: linear-gradient(90deg, var(--neon), var(--accent));
            width: 100%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 5px rgba(0, 255, 136, 0.3);
            }

            50% {
                box-shadow: 0 0 15px rgba(0, 255, 136, 0.5);
            }

            100% {
                box-shadow: 0 0 5px rgba(0, 255, 136, 0.3);
            }
        }

        /* ====== Empty State ====== */
        .empty-state {
            background: var(--glass);
            padding: 12px;
            border-radius: 10px;
            box-shadow: var(--shadow);
            font-size: 0.9rem;
            color: var(--muted);
            text-align: center;
            animation: fadeIn 0.5s var(--animation-ease);
        }

        .empty-state a {
            color: var(--neon);
            text-decoration: none;
            font-weight: var(--font-weight-medium);
        }

        .empty-state a:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        /* ====== Responsive Design ====== */
        @media (max-width: 1200px) {
            aside#sidebar {
                width: 240px;
            }
        }

        @media (max-width: 960px) {
            main {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {

            .post-form,
            .post-card,
            .comment-section {
                padding: 12px;
            }

            .post-image img {
                max-width: 200px;
                height: 120px;
            }

            .post-actions {
                flex-direction: column;
                align-items: flex-start;
            }

            .post-actions input[type="text"],
            .post-actions input[type="file"] {
                width: 100%;
                margin-bottom: 8px;
            }

            .comment-section {
                padding-left: 8px;
            }

            .replies {
                margin-left: 12px;
            }

            header {
                flex-direction: column;
                text-align: center;
            }

            .header-left h1 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .post-card {
                flex-direction: column;
            }

            .post-icon {
                align-self: flex-start;
            }

            .post-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }

            .post-image img {
                max-width: 150px;
                height: 100px;
            }

            .comment-form,
            .reply-form {
                flex-direction: column;
            }

            .comment-form input[type="text"],
            .reply-form input[type="text"] {
                width: 100%;
            }
        }

        /* ====== Accessibility ====== */
        @media (prefers-reduced-motion: reduce) {

            .post-card,
            .post-form,
            .post-actions button,
            .comment-form button,
            .reply-form button,
            .divider .fill,
            nav.nav-menu a,
            #mobile-toggle {
                transition: none;
                animation: none;
            }
        }

        @media (prefers-contrast: high) {

            .post-card,
            .post-form,
            .comment-section,
            .empty-state,
            aside#sidebar,
            header {
                border: 2px solid var(--white);
            }

            button,
            .logout-form button,
            .post-actions button,
            .comment-form button,
            .reply-form button,
            nav.nav-menu a,
            #mobile-toggle {
                background: var(--white);
                color: var(--bg);
            }

            button svg,
            .logout-form button svg,
            .post-actions button svg,
            .comment-form button svg,
            .reply-form button svg,
            nav.nav-menu a svg {
                stroke: var(--bg);
            }

            .post-header h4,
            .comment-header h4,
            .reply-body h4,
            .sidebar-header h2,
            .header-left h1 {
                color: var(--white);
            }

            .divider {
                background: var(--white);
            }
        }

        /* ====== Animations ====== */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>

    <div id="fitlife-container" role="application" aria-label="FitLife Posts">
        <!-- Sidebar -->
        <aside id="sidebar" aria-label="Main navigation">
            <div class="sidebar-header">
                <h2>FitLife</h2>
                <p>Power Your Performance</p>
            </div>
            <nav class="nav-menu" aria-label="Main menu">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" {{ request()->routeIs('dashboard') ? 'aria-current=page' : '' }}>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M3 13h8V3H3z" />
                        <path d="M13 21h8V11h-8z" />
                        <path d="M13 3v8" />
                    </svg>
                    <span>Home</span>
                </a>
                <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.*') ? 'active' : '' }}" {{ request()->routeIs('posts.*') ? 'aria-current=page' : '' }}>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path
                            d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
                        <path d="M17 8l4 4-4 4" />
                    </svg>
                    <span>Community Posts</span>
                </a>
                <a href="{{ route('foods.index') }}" class="{{ request()->routeIs('foods.*') ? 'active' : '' }}" {{ request()->routeIs('foods.*') ? 'aria-current=page' : '' }}>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M4 21c4-4 6-11 6-17" />
                        <path d="M20 7a4 4 0 11-8 0" />
                    </svg>
                    <span>Meal Tracker</span>
                </a>
                <a href="{{ route('sleep.index') }}" class="{{ request()->routeIs('sleep.*') ? 'active' : '' }}" {{ request()->routeIs('sleep.*') ? 'aria-current=page' : '' }}>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                    </svg>
                    <span>Sleep Tracker</span>
                </a>
                <a href="{{ route('water.index') }}" class="{{ request()->routeIs('water.*') ? 'active' : '' }}" {{ request()->routeIs('water.*') ? 'aria-current=page' : '' }}>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M12 2s4 5 4 8a4 4 0 01-8 0c0-3 4-8 4-8z" />
                    </svg>
                    <span>Water Tracker</span>
                </a>
                <a href="{{ route('progress.index') }}" class="{{ request()->routeIs('progress.*') ? 'active' : '' }}" {{ request()->routeIs('progress.*') ? 'aria-current=page' : '' }}>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M21 3v18H3V3h18z" />
                        <path d="M7 14l3-3 2 2 5-5" />
                    </svg>
                    <span>Progress Photos</span>
                </a>
                <a href="{{ route('goals.index') }}" class="{{ request()->routeIs('goals.*') ? 'active' : '' }}" {{ request()->routeIs('goals.*') ? 'aria-current=page' : '' }}>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8v4l3 3" />
                    </svg>
                    <span>Goals</span>
                </a>
                <a href="{{ route('calories.index') }}" class="{{ request()->routeIs('calories.*') ? 'active' : '' }}" {{ request()->routeIs('calories.*') ? 'aria-current=page' : '' }}>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M12 2v20" />
                        <path d="M5 12h14" />
                    </svg>
                    <span>Calorie Calculator</span>
                </a>
                <a href="{{ route('biography.edit') }}" class="{{ request()->routeIs('biography.*') ? 'active' : '' }}" {{ request()->routeIs('biography.*') ? 'aria-current=page' : '' }}>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <circle cx="12" cy="8" r="4" />
                        <path d="M6 20v-1a6 6 0 0112 0v1" />
                    </svg>
                    <span>Biography</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}" {{ request()->routeIs('profile.edit') ? 'aria-current=page' : '' }}>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                    </svg>
                    <span>Profile</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" aria-label="Logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                            <path d="M16 17l5-5-5-5" />
                            <path d="M21 12H9" />
                        </svg>
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main>
            <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">Menu</button>
            <header>
                <div class="header-left">
                    <h1>Community Posts</h1>
                    <p class="muted">Share your journey</p>
                </div>
            </header>

            <section aria-labelledby="posts-heading">
                <h3 id="posts-heading">Create a Post</h3>
                <div class="post-form">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <textarea name="content" placeholder="Write something..." rows="3"
                            aria-label="New post content"></textarea>
                        <input type="file" name="photo" accept="image/*" aria-label="Upload post photo">
                        <button type="submit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                                <path d="M17 21v-8H7v8" />
                                <path d="M7 3v5h8" />
                            </svg>
                            Post
                        </button>
                    </form>
                </div>

                <div class="divider">
                    <div class="fill"></div>
                </div>

                @forelse($posts as $post)
                    <div class="post-card" aria-label="Post by {{ $post->user->name }}">
                        <div class="post-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path
                                    d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
                                <path d="M17 8l4 4-4 4" />
                            </svg>
                        </div>
                        <div class="post-body">
                            <div class="post-header">
                                <h4>{{ $post->user->name }}</h4>
                                <span class="muted">{{ $post->created_at->diffForHumans() }}</span>
                            </div>

                            @if($post->photo_path)
                                <div class="post-image">
                                    <img src="{{ asset('storage/' . $post->photo_path) }}" alt="Post image" loading="lazy">
                                </div>
                            @endif

                            <div class="post-content">
                                <div class="value">{{ $post->content }}</div>
                            </div>

                            <div class="post-actions">
                                <form action="{{ route('posts.like', $post) }}" method="POST">
                                    @csrf
                                    <button type="submit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                            <path
                                                d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-1.7l1.38-9a2 2 0 00-2-2.3zM7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3" />
                                        </svg>
                                        Like ({{ $post->likes->where('type', 'like')->count() }})
                                    </button>
                                </form>
                                <form action="{{ route('posts.dislike', $post) }}" method="POST">
                                    @csrf
                                    <button type="submit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                            <path
                                                d="M10 15v4a3 3 0 003 3l4-9V2H5.72a2 2 0 00-2 1.7l-1.38 9a2 2 0 002 2.3zm7-13h2.67A2.31 2.31 0 0122 4v7a2.31 2.31 0 01-2.33 2H17" />
                                        </svg>
                                        Dislike ({{ $post->likes->where('type', 'dislike')->count() }})
                                    </button>
                                </form>

                                @can('update', $post)
                                    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="content" value="{{ $post->content }}"
                                            aria-label="Edit post content">
                                        <input type="file" name="photo" accept="image/*" aria-label="Update post photo">
                                        <button type="submit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                            Update
                                        </button>
                                    </form>
                                @endcan
                                @can('delete', $post)
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-10 0v14a2 2 0 002 2h6a2 2 0 002-2V6" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                            </div>

                            <div class="comment-section">
                                @foreach($post->comments as $comment)
                                    <div class="comment" aria-label="Comment by {{ $comment->user->name }}">
                                        <div class="comment-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                                <path
                                                    d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
                                                <path d="M17 8l4 4-4 4" />
                                            </svg>
                                        </div>
                                        <div class="comment-body">
                                            <div class="comment-header">
                                                <h4>{{ $comment->user->name }}</h4>
                                                <span class="muted">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="comment-content">
                                                {{ $comment->content }}
                                            </div>
                                            <div class="replies">
                                                @foreach($comment->replies as $reply)
                                                    <div class="reply" aria-label="Reply by {{ $reply->user->name }}">
                                                        <div class="reply-icon">
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="1.6">
                                                                <path
                                                                    d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
                                                                <path d="M17 8l4 4-4 4" />
                                                            </svg>
                                                        </div>
                                                        <div class="reply-body">
                                                            <h4>{{ $reply->user->name }}</h4>
                                                            <p>{{ $reply->content }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="reply-form">
                                                    <form action="{{ route('posts.comment', $post) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                        <input type="text" name="content" placeholder="Reply..."
                                                            aria-label="Reply to comment">
                                                        <button type="submit">
                                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="1.6">
                                                                <path
                                                                    d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
                                                                <path d="M17 8l4 4-4 4" />
                                                            </svg>
                                                            Reply
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="comment-form">
                                    <form action="{{ route('posts.comment', $post) }}" method="POST">
                                        @csrf
                                        <input type="text" name="content" placeholder="Comment..." aria-label="New comment">
                                        <button type="submit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                                <path
                                                    d="M21 11.5a8.38 8.38 0 01-8.5 8 8.38 8.38 0 01-8.5-8 8.38 8.38 0 018.5-8c3.1 0 5.8 1.7 7.2 4.2" />
                                                <path d="M17 8l4 4-4 4" />
                                            </svg>
                                            Comment
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        No posts yet. <a href="#" onclick="document.querySelector('.post-form textarea').focus()">Be the first
                            to share!</a>
                    </div>
                @endforelse
            </section>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            /* ===== Sidebar Mobile Toggle ===== */
            const mobileToggle = document.getElementById('mobile-toggle');
            const body = document.body;
            const sidebar = document.getElementById('sidebar');

            mobileToggle.addEventListener('click', () => {
                const opened = body.classList.toggle('sidebar-open');
                mobileToggle.setAttribute('aria-expanded', opened ? 'true' : 'false');
            });

            document.addEventListener('click', (e) => {
                if (!body.classList.contains('sidebar-open')) return;
                if (sidebar.contains(e.target) || mobileToggle.contains(e.target)) return;
                body.classList.remove('sidebar-open');
                mobileToggle.setAttribute('aria-expanded', 'false');
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && body.classList.contains('sidebar-open')) {
                    body.classList.remove('sidebar-open');
                    mobileToggle.setAttribute('aria-expanded', 'false');
                }
            });
        });
    </script>
@endsection