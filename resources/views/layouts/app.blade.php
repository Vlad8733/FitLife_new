<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FitLife') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @yield('styles')
</head>
<body>
    <div id="fitlife-container">
        @auth
            <aside id="sidebar">
                <div class="sidebar-header">
                    <h2>FitLife</h2>
                    <p>Power Your Performance</p>
                </div>
                <nav class="nav-menu">
                    @foreach([
                        ['route' => 'dashboard', 'label' => 'Home', 'icon' => 'M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z'],
                        ['route' => 'posts.index', 'label' => 'Community Posts', 'icon' => 'M120-120v-720h720v720H120Zm600-160H240v60h480v-60Zm-480-60h480v-60H240v60Zm0-140h480v-240H240v240Zm0 200v60-60Zm0-60v-60 60Zm0-140v-240 240Zm0 80v-80 80Zm0 120v-60 60Z'],
                        ['route' => 'foods.index', 'label' => 'Meal Tracker', 'icon' => 'M322-400q-100 0-171-70T80-640q0-100 71-170t172-70h16q-22 25-34 56t-12 64q0 75 52.5 127.5T473-580q23 0 45-5.5t42-16.5q-14 88-81 145t-157 57Zm-1-80q24 0 47.5-6.5T412-507q-87-21-142-90.5T213-756q-26 23-39.5 53T160-640q0 66 47 113t114 47Zm399-40h80v-120h-80v120Zm40 160q17 0 28.5-11.5T800-400v-40h-80v40q0 17 11.5 28.5T760-360ZM234-160h172q14 0 25-8t14-22l13-50H182l13 50q3 14 14 22t25 8Zm86 0ZM40-80v-80h80q-1-3-1.5-5.5T117-171L80-320h480l-37 149q-1 3-1.5 5.5T520-160h200v-127q-36-13-58-44t-22-69v-320h240v320q0 38-22 69t-58 44v127h120v80H40Zm246-538Zm474 178Z'],
                        ['route' => 'sleep.index', 'label' => 'Sleep Tracker', 'icon' => 'M600-640 480-760l120-120 120 120-120 120Zm200 120-80-80 80-80 80 80-80 80ZM483-80q-84 0-157.5-32t-128-86.5Q143-253 111-326.5T79-484q0-146 93-257.5T409-880q-18 99 11 193.5T520-521q71 71 165.5 100T879-410q-26 144-138 237T483-80Zm0-80q88 0 163-44t118-121q-86-8-163-43.5T463-465q-61-61-97-138t-43-163q-77 43-120.5 118.5T159-484q0 135 94.5 229.5T483-160Zm-20-305Z'],
                        ['route' => 'water.index', 'label' => 'Water Tracker', 'icon' => 'M491-200q12-1 20.5-9.5T520-230q0-14-9-22.5t-23-7.5q-41 3-87-22.5T343-375q-2-11-10.5-18t-19.5-7q-14 0-23 10.5t-6 24.5q17 91 80 130t127 35ZM480-80q-137 0-228.5-94T160-408q0-100 79.5-217.5T480-880q161 137 240.5 254.5T800-408q0 140-91.5 234T480-80Zm0-80q104 0 172-70.5T720-408q0-73-60.5-165T480-774Q361-665 300.5-573T240-408q0 107 68 177.5T480-160Zm0-320Z'],
                        ['route' => 'progress.index', 'label' => 'Progress Photos', 'icon' => 'M360-400h400L622-580l-92 120-62-80-108 140Zm-40 160q-33 0-56.5-23.5T240-320v-480q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H320Zm0-80h480v-480H320v480ZM160-80q-33 0-56.5-23.5T80-160v-560h80v560h560v80H160Zm160-720v480-480Z'],
                        ['route' => 'goals.index', 'label' => 'Goals', 'icon' => 'M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-80q-100 0-170-70t-70-170q0-100 70-170t170-70q100 0 170 70t70 170q0 100-70 170t-170 70Zm0-80q66 0 113-47t47-113q0-66-47-113t-113-47q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-80q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Z'],
                        ['route' => 'calories.index', 'label' => 'Calorie Calculator', 'icon' => 'M240-400q0 52 21 98.5t60 81.5q-1-5-1-9v-9q0-32 12-60t35-51l113-111 113 111q23 23 35 51t12 60v9q0 4-1 9 39-35 60-81.5t21-98.5q0-50-18.5-94.5T648-574q-20 13-42 19.5t-45 6.5q-62 0-107.5-41T401-690q-39 33-69 68.5t-50.5 72Q261-513 250.5-475T240-400Zm240 52-57 56q-11 11-17 25t-6 29q0 32 23.5 55t56.5 23q33 0 56.5-23t23.5-55q0-16-6-29.5T537-292l-57-56Zm0-492v132q0 34 23.5 57t57.5 23q18 0 33.5-7.5T622-658l18-22q74 42 117 117t43 163q0 134-93 227T480-80q-134 0-227-93t-93-227q0-129 86.5-245T480-840Z'],
                        ['route' => 'biography.edit', 'label' => 'Biography', 'icon' => 'M480-240q-56 0-107 17.5T280-170v10h400v-10q-42-35-93-52.5T480-240Zm0-80q69 0 129 21t111 59v-560H240v560q51-38 111-59t129-21Zm0-160q-25 0-42.5-17.5T420-540q0-25 17.5-42.5T480-600q25 0 42.5 17.5T540-540q0 25-17.5 42.5T480-480ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h480q33 0 56.5 23.5T800-800v640q0 33-23.5 56.5T720-80H240Zm240-320q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41Zm0-140Z'],
                        ['route' => 'profile.edit', 'label' => 'Profile', 'icon' => 'M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z']
                    ] as $item)
                        <a href="{{ route($item['route']) }}"
                           class="{{ request()->routeIs($item['route'] . ($item['route'] === 'dashboard' || $item['route'] === 'profile.edit' ? '' : '.*')) ? 'active' : '' }}"
                           {{ request()->routeIs($item['route'] . ($item['route'] === 'dashboard' || $item['route'] === 'profile.edit' ? '' : '.*')) ? 'aria-current=page' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                                <path d="{{ $item['icon'] }}"/>
                            </svg>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" aria-label="Logout">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                                <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </nav>
            </aside>
        @endauth

        <main>
            @auth
                <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="user-info">
                    <a href="{{ route('profile.edit') }}">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) . '?t=' . time() : asset('storage/logo/defaultPhoto.jpg') }}"
                             alt="Avatar">
                    </a>
                    <span>{{ Auth::user()->name }}</span>
                </div>
            @endauth

            @if (session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    <style>
        :root {
            --bg: #f9fafb;
            --text: #111827;
            --accent: #3b82f6;
            --muted: #6b7280;
            --card-bg: #ffffff;
            --border: #d1d5db;
            --radius: 12px;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --transition: 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }

        #fitlife-container {
            display: flex;
            min-height: 100vh;
        }

        #sidebar {
            width: 240px;
            background: var(--card-bg);
            padding: 24px;
            border-right: 1px solid var(--border);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            margin-bottom: 24px;
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .sidebar-header p {
            font-size: 0.9rem;
            color: var(--muted);
        }

        .nav-menu a,
        .nav-menu button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            color: var(--text);
            text-decoration: none;
            font-size: 0.95rem;
            border-radius: var(--radius);
            transition: var(--transition);
        }

        .nav-menu a svg,
        .nav-menu button svg {
            width: 20px;
            height: 20px;
        }

        .nav-menu a:hover,
        .nav-menu button:hover {
            background: var(--bg);
            color: var(--accent);
        }

        .nav-menu a:hover svg,
        .nav-menu button:hover svg {
            fill: var(--accent);
        }

        .nav-menu a.active {
            background: var(--accent);
            color: #fff;
        }

        .nav-menu a.active svg {
            fill: #fff;
        }

        .nav-menu button {
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: left;
        }

        main {
            margin-left: 120px;
            padding: 24px;
            flex: 1;
        }

        #mobile-toggle {
            display: none;
            position: fixed;
            top: 16px;
            left: 16px;
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 8px;
            border-radius: var(--radius);
            cursor: pointer;
        }

        #mobile-toggle svg {
            width: 20px;
            height: 20px;
        }

        .user-info {
            position: absolute;
            top: 16px;
            right: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-info span {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .alert {
            padding: 10px;
            margin: 10px;
            border-radius: var(--radius);
        }

        .alert.success {
            background: #e6ffed;
            color: #2e7d32;
        }

        .alert.error {
            background: #fee2e2;
            color: #dc2626;
        }

        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                transform: translateX(-100%);
                transition: var(--transition);
                z-index: 1000;
            }

            #sidebar.active {
                transform: translateX(0);
            }

            main {
                margin-left: 0;
            }

            #mobile-toggle {
                display: block;
            }

            .user-info {
                top: 64px;
                right: 16px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
            const mobileToggle = document.getElementById('mobile-toggle');
            const sidebar = document.getElementById('sidebar');
            if (mobileToggle && sidebar) {
                mobileToggle.addEventListener('click', () => {
                    const isOpen = sidebar.classList.toggle('active');
                    mobileToggle.setAttribute('aria-expanded', isOpen);
                });
                document.addEventListener('click', e => {
                    if (sidebar.classList.contains('active') && !sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                        sidebar.classList.remove('active');
                        mobileToggle.setAttribute('aria-expanded', 'false');
                    }
                });
                document.addEventListener('keydown', e => {
                    if (e.key === 'Escape' && sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                        mobileToggle.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>