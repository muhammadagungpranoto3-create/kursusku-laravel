<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KursusKu')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.navbar')

    <main class="container kk-main">
        @if (session('success'))
            <div class="kk-flash" role="status">
                <span class="kk-flash-icon" aria-hidden="true">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="kk-footer">
        <div class="container">
            <strong>KursusKu</strong>
            <span>Praktikum Pemrograman Web III, PTIK UIN Syech M. Djamil Djambek Bukittinggi</span>
        </div>
    </footer>
</body>
</html>
