<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FitLife')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #121212;
            --text: #e5e5e5;
            --accent: #00ff00;
            --card-bg: #1f1f1f;
            --border: rgba(51, 51, 51, 0.5);
            --radius: 24px;
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            --notch-bg: rgba(26, 26, 26, 0.7);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); overflow-x: hidden; }

        /* === USER INFO (вверху справа) === */
        .user-info {
            position: fixed;
            top: 16px; right: 16px;
            z-index: 1100;
            background: var(--notch-bg);
            backdrop-filter: blur(12px);
            border-radius: var(--radius);
            padding: 8px 12px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            max-width: 200px;
        }

        .user-info img {
            width: 32px; height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent);
        }

        .user-info span {
            font-weight: 500;
            font-size: 0.85rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 130px;
        }

        .user-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: var(--notch-bg);
            backdrop-filter: blur(12px);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            min-width: 160px;
            z-index: 1200;
            flex-direction: column;
            padding: 8px;
        }

        .user-dropdown.active { display: flex; }

        .user-dropdown a,
        .user-dropdown button {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 12px;
            color: var(--text);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: var(--radius);
            background: none;
            border: none;
            cursor: pointer;
            text-align: left;
            width: 100%;
        }

        .user-dropdown a:hover,
        .user-dropdown button:hover {
            background: rgba(31, 31, 31, 0.5);
            color: var(--accent);
        }

        .user-dropdown svg {
            width: 18px; height: 18px; fill: var(--text);
        }

        .user-dropdown a:hover svg,
        .user-dropdown button:hover svg {
            fill: var(--accent);
        }

        /* === NAVIGATION === */
        #navbar {
            position: sticky;
            top: 16px;
            z-index: 1000;
            display: flex;
            justify-content: center;
            padding: 8px 16px;
        }

        .navbar-container {
            background: var(--notch-bg);
            backdrop-filter: blur(12px);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            max-width: 1150px;
            width: calc(100% - 32px);
            border: 1px solid var(--border);
        }

        .nav-menu {
            display: flex;
            gap: 6px;
        }

        .nav-menu a {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 8px 12px;
            color: var(--text);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 500;
            border-radius: var(--radius);
            min-width: 70px;
        }

        .nav-menu a svg {
            width: 20px; height: 20px; fill: var(--text);
        }

        .nav-menu a:hover {
            background: rgba(31, 31, 31, 0.5);
            color: var(--accent);
        }

        .nav-menu a:hover svg { fill: var(--accent); }

        .nav-menu a.active {
            background: var(--accent);
            color: white;
        }

        .nav-menu a.active svg { fill: white; }

        /* === MAIN CONTENT === */
        main {
            padding: 24px 16px 100px;
            max-width: 2000px;
            margin: 0 auto;
        }

        main h1, main h2, main h3 { margin-top: 0; }

        /* === MOBILE: НАВБАР ВНИЗУ + УМНЫЕ ОТСТУПЫ === */
        @media (max-width: 768px) {
            #navbar {
                position: fixed;
                bottom: 16px;
                top: auto;
                left: 50%;
                transform: translateX(-50%);
                width: calc(100% - 32px);
                padding: 0;
                z-index: 1000;
            }

            .navbar-container {
                flex-direction: row;
                overflow-x: auto;
                overflow-y: hidden;
                white-space: nowrap;
                padding: 12px 16px;
                width: 100%;
                max-width: none;
                justify-content: flex-start;
                gap: 8px;
                scrollbar-width: none;
            }

            .navbar-container::-webkit-scrollbar { display: none; }

            .nav-menu {
                display: flex;
                flex-direction: row;
                gap: 8px;
                width: max-content;
            }

            .nav-menu a {
                min-width: 90px;
                padding: 10px 6px;
                font-size: 0.7rem;
            }

            .nav-menu a svg {
                width: 18px; height: 18px;
            }

            .user-info {
                top: 16px; right: 16px;
                max-width: 160px;
            }

            .user-info span {
                font-size: 0.8rem;
                max-width: 100px;
            }

            .user-dropdown {
                right: 16px;
                min-width: 150px;
            }

            main {
                padding: 60px 16px 100px 16px; /* 60px — ровно под аватарку */
            }
        }

        @media (max-width: 480px) {
            main { padding: 50px 12px 90px 12px; }
            .nav-menu a { min-width: 80px; font-size: 0.65rem; }
            .nav-menu a svg { width: 16px; height: 16px; }
            .user-info img { width: 28px; height: 28px; }
            .user-info span { font-size: 0.75rem; max-width: 85px; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div id="fitlife-container">
        @auth
        <div class="user-info" id="user-info" aria-controls="user-dropdown" aria-expanded="false">
            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) . '?t=' . time() : asset('storage/logo/defaultPhoto.jpg') }}" alt="Avatar">
            <span title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</span>

            <div class="user-dropdown" id="user-dropdown">
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm246-164q-59 0-99.5-40.5T340-580q0-59 40.5-99.5T480-720q59 0 99.5 40.5T620-580q0 59-40.5 99.5T480-440Zm0 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q53 0 100-15.5t86-44.5q-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160Zm0-360q26 0 43-17t17-43q0-26-17-43t-43-17q-26 0-43 17t-17 43q0 26 17 43t43 17Zm0-60Zm0 360Z"/></svg>
                    <span>Profile</span>
                </a>

                @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M680-280q25 0 42.5-17.5T740-340q0-25-17.5-42.5T680-400q-25 0-42.5 17.5T620-340q0 25 17.5 42.5T680-280Zm0 120q31 0 57-14.5t42-38.5q-22-13-47-20t-52-7q-27 0-52 7t-47 20q16 24 42 38.5t57 14.5ZM480-80q-139-35-229.5-159.5T160-516v-244l320-120 320 120v227q-19-8-39-14.5t-41-9.5v-147l-240-90-240 90v188q0 47 12.5 94t35 89.5Q310-290 342-254t71 60q11 32 29 61t41 52q-1 0-1.5.5t-1.5.5Zm200 0q-83 0-141.5-58.5T480-280q0-83 58.5-141.5T680-480q83 0 141.5 58.5T880-280q0 83-58.5 141.5T680-80ZM480-494Z"/></svg>
                    <span>Admin Panel</span>
                </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <nav id="navbar">
            <div class="navbar-container">
                <div class="nav-menu">
                    @foreach([
                        ['route' => 'dashboard', 'label' => 'Home', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M200-160v-366L88-440l-48-64 440-336 160 122v-82h120v174l160 122-48 64-112-86v366H520v-240h-80v240H200Zm80-80h80v-240h240v240h80v-347L480-739 280-587v347Zm120-319h160q0-32-24-52.5T480-632q-32 0-56 20.5T400-559Zm-40 319v-240h240v240-240H360v240Z"/></svg>'],
                        ['route' => 'posts.index', 'label' => 'Community', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M38-428q-18-36-28-73T0-576q0-112 76-188t188-76q63 0 120 26.5t96 73.5q39-47 96-73.5T696-840q112 0 188 76t76 188q0 38-10 75t-28 73q-11-19-26-34t-35-24q9-23 14-45t5-45q0-78-53-131t-131-53q-81 0-124.5 44.5T480-616q-48-56-91.5-100T264-760q-78 0-131 53T80-576q0 23 5 45t14 45q-20 9-35 24t-26 34ZM0-80v-63q0-44 44.5-70.5T160-240q13 0 25 .5t23 2.5q-14 20-21 43t-7 49v65H0Zm240 0v-65q0-65 66.5-105T480-290q108 0 174 40t66 105v65H240Zm540 0v-65q0-26-6.5-49T754-237q11-2 22.5-2.5t23.5-.5q72 0 116 26.5t44 70.5v63H780ZM480-210q-57 0-102 15t-53 35h311q-9-20-53.5-35T480-210Zm-320-70q-33 0-56.5-23.5T80-360q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T160-280Zm640 0q-33 0-56.5-23.5T720-360q0-34 23.5-57t56.5-23q34 0 57 23t23 57q0 33-23 56.5T800-280Zm-320-40q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T600-440q0 50-34.5 85T480-320Zm0-160q-17 0-28.5 11.5T440-440q0 17 11.5 28.5T480-400q17 0 28.5-11.5T520-440q0-17-11.5-28.5T480-480Zm0 40Zm1 280Z"/></svg>'],
                        ['route' => 'activity-calendar', 'label' => 'Calendar', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M180-80q-24 0-42-18t-18-42v-620q0-24 18-42t42-18h65v-60h65v60h340v-60h65v60h65q24 0 42 18t18 42v620q0 24-18 42t-42 18H180Zm0-60h600v-430H180v430Zm0-490h600v-130H180v130Zm0 0v-130 130Zm60 280v-80h80v80h-80Zm0 120v-80h80v80h-80Zm0 120v-80h80v80h-80Zm120-240v-80h80v80h-80Zm0 120v-80h80v80h-80Zm0 120v-80h80v80h-80Zm120-240v-80h80v80h-80Zm0 120v-80h80v80h-80Zm0 120v-80h80v80h-80Zm120-240v-80h80v80h-80Zm0 120v-80h80v80h-80Zm0 120v-80h80v80h-80Z"/></svg>'],
                        ['route' => 'foods.index', 'label' => 'Meal', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M322-400q-100 0-171-70T80-640q0-100 71-170t172-70h16q-22 25-34 56t-12 64q0 75 52.5 127.5T473-580q23 0 45-5.5t42-16.5q-14 88-81 145t-157 57Zm-1-80q24 0 47.5-6.5T412-507q-87-21-142-90.5T213-756q-26 23-39.5 53T160-640q0 66 47 113t114 47Zm399-40h80v-120h-80v120Zm40 160q17 0 28.5-11.5T800-400v-40h-80v40q0 17 11.5 28.5T760-360ZM234-160h172q14 0 25-8t14-22l13-50H182l13 50q3 14 14 22t25 8Zm86 0ZM40-80v-80h80q-1-3-1.5-5.5T117-171L80-320h480l-37 149q-1 3-1.5 5.5T520-160h200v-127q-36-13-58-44t-22-69v-320h240v320q0 38-22 69t-58 44v127h120v80H40Zm246-538Zm474 178Z"/></svg>'],
                        ['route' => 'sleep.index', 'label' => 'Sleep', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M600-640 480-760l120-120 120 120-120 120Zm200 120-80-80 80-80 80 80-80 80ZM483-80q-84 0-157.5-32t-128-86.5Q143-253 111-326.5T79-484q0-146 93-257.5T409-880q-18 99 11 193.5T520-521q71 71 165.5 100T879-410q-26 144-138 237T483-80Zm0-80q88 0 163-44t118-121q-86-8-163-43.5T463-465q-61-61-97-138t-43-163q-77 43-120.5 118.5T159-484q0 135 94.5 229.5T483-160Zm-20-305Z"/></svg>'],
                        ['route' => 'water.index', 'label' => 'Water', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M491-200q12-1 20.5-9.5T520-230q0-14-9-22.5t-23-7.5q-41 3-87-22.5T343-375q-2-11-10.5-18t-19.5-7q-14 0-23 10.5t-6 24.5q17 91 80 130t127 35ZM480-80q-137 0-228.5-94T160-408q0-100 79.5-217.5T480-880q161 137 240.5 254.5T800-408q0 140-91.5 234T480-80Zm0-80q104 0 172-70.5T720-408q0-73-60.5-165T480-774Q361-665 300.5-573T240-408q0 107 68 177.5T480-160Zm0-320Z"/></svg>'],
                        ['route' => 'progress.index', 'label' => 'Progress Photos', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M360-400h400L622-580l-92 120-62-80-108 140Zm-40 160q-33 0-56.5-23.5T240-320v-480q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H320Zm0-80h480v-480H320v480ZM160-80q-33 0-56.5-23.5T80-160v-640h80v640h560v80H160Zm160-720v480-480Z"/></svg>'],
                        ['route' => 'goals.index', 'label' => 'Goals', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-80q-100 0-170-70t-70-170q0-100 70-170t170-70q100 0 170 70t70 170q0 100-70 170t-170 70Zm0-80q66 0 113-47t47-113q0-66-47-113t-113-47q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-80q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Z"/></svg>'],
                        ['route' => 'calories.index', 'label' => 'Calculator', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M320-240h60v-80h80v-60h-80v-80h-60v80h-80v60h80v80Zm200-30h200v-60H520v60Zm0-100h200v-60H520v60Zm44-152 56-56 56 56 42-42-56-58 56-56-42-42-56 56-56-56-42 42 56 56-56 58 42 42Zm-314-70h200v-60H250v60Zm-50 472q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>'],
                        ['route' => 'biography.edit', 'label' => 'Biography', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M480-240q-56 0-107 17.5T280-170v10h400v-10q-42-35-93-52.5T480-240Zm0-80q69 0 129 21t111 59v-560H240v560q51-38 111-59t129-21Zm0-160q-25 0-42.5-17.5T420-540q0-25 17.5-42.5T480-600q25 0 42.5 17.5T540-540q0 25-17.5 42.5T480-480ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h480q33 0 56.5 23.5T800-800v640q0 33-23.5 56.5T720-80H240Zm240-320q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41Zm0-140Z"/></svg>'],
                    ] as $item)
                        <a href="{{ route($item['route']) }}"
                           class="{{ request()->routeIs($item['route'] . ($item['route'] === 'dashboard' ? '' : '.*')) ? 'active' : '' }}">
                            {!! $item['icon'] !!}
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </nav>
        @endauth

        <main>
            @if(session('success'))
                <div style="padding:12px 20px; margin:16px 0; background:#e6ffed; color:#2e7d32; border-radius:16px; font-size:0.9rem;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="padding:12px 20px; margin:16px 0; background:#fee2e2; color:#dc2626; border-radius:16px; font-size:0.9rem;">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const userInfo = document.getElementById('user-info');
            const dropdown = document.getElementById('user-dropdown');

            userInfo?.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.classList.toggle('active');
                userInfo.setAttribute('aria-expanded', dropdown.classList.contains('active'));
            });

            document.addEventListener('click', () => {
                if (dropdown.classList.contains('active')) {
                    dropdown.classList.remove('active');
                    userInfo.setAttribute('aria-expanded', 'false');
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && dropdown.classList.contains('active')) {
                    dropdown.classList.remove('active');
                    userInfo.setAttribute('aria-expanded', 'false');
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>