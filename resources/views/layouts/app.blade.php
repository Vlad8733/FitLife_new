<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(180deg, #0A0C10, #1A1F26); /* Соответствует dashboard.blade.php */
            color: #E6ECEF; /* Соответствует dashboard.blade.php */
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: 100%;
            padding: 0; /* Убираем отступы для устранения рамок */
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>