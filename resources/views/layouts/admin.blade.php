<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - KursusKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --admin-sidebar: #0f0f0f;
            --admin-accent: #e11d48;
            --admin-bg: #f4f5f7;
            --admin-card: #ffffff;
            --admin-text: #1f2937;
            --admin-muted: #6b7280;
            --admin-border: #e5e7eb;
        }
        body.admin-body {
            margin: 0;
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--admin-bg);
            color: var(--admin-text);
            min-height: 100vh;
        }
        .admin-shell {
            display: flex;
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 260px;
            background: var(--admin-sidebar);
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 40;
        }
        .admin-brand {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 1.25rem 1.25rem 1.5rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: #fff;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .admin-brand-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            display: grid; place-items: center;
            font-size: 0.85rem; font-weight: 800;
        }
        .admin-nav-section {
            padding: 1.25rem 1rem 0.5rem;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: rgba(255,255,255,.45);
        }
        .admin-nav a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 1rem;
            margin: 0.15rem 0.65rem;
            border-radius: 10px;
            color: rgba(255,255,255,.78);
            text-decoration: none;
            font-size: 0.925rem;
            font-weight: 500;
            transition: background .15s, color .15s;
        }
        .admin-nav a:hover { background: rgba(255,255,255,.08); color: #fff; }
        .admin-nav a.active {
            background: var(--admin-accent);
            color: #fff;
        }
        .admin-nav svg { width: 18px; height: 18px; flex-shrink: 0; opacity: .9; }
        .admin-main {
            margin-left: 260px;
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }
        .admin-topbar {
            background: #fff;
            border-bottom: 1px solid var(--admin-border);
            padding: 0.9rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 30;
        }
        .admin-topbar h1 {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--admin-text);
        }
        .admin-topbar-right {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }
        .admin-topbar-user {
            font-size: 0.875rem;
            color: var(--admin-muted);
        }
        .admin-topbar-user strong { color: var(--admin-text); }
        .btn-logout-outline {
            border: 1.5px solid var(--admin-accent);
            color: var(--admin-accent);
            background: transparent;
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s, color .15s;
        }
        .btn-logout-outline:hover {
            background: var(--admin-accent);
            color: #fff;
        }
        .admin-content {
            padding: 1.5rem 1.75rem 2.5rem;
            flex: 1;
        }
        .admin-flash {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            margin-bottom: 1.25rem;
            font-size: 0.925rem;
        }
        .admin-flash-error {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }
        /* Cards & stats */
        .admin-stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        @media (max-width: 1100px) {
            .admin-stat-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .admin-stat-grid { grid-template-columns: 1fr; }
            .admin-sidebar { width: 72px; }
            .admin-main { margin-left: 72px; }
            .admin-brand span, .admin-nav-section, .admin-nav a span { display: none; }
            .admin-nav a { justify-content: center; padding: 0.75rem; }
        }
        .admin-stat-card {
            background: var(--admin-card);
            border-radius: 14px;
            padding: 1.15rem 1.25rem;
            border: 1px solid var(--admin-border);
            box-shadow: 0 1px 2px rgba(0,0,0,.04);
        }
        .admin-stat-card .label {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: var(--admin-muted);
            margin-bottom: 0.35rem;
        }
        .admin-stat-card .value {
            font-size: 1.85rem;
            font-weight: 700;
            line-height: 1.1;
        }
        .admin-stat-card .hint {
            font-size: 0.8rem;
            color: var(--admin-muted);
            margin-top: 0.25rem;
        }
        .admin-stat-card.is-accent {
            border-color: #fecdd3;
            background: linear-gradient(180deg, #fff 0%, #fff5f6 100%);
        }
        .admin-stat-card.is-accent .value { color: var(--admin-accent); }
        .admin-panel {
            background: var(--admin-card);
            border-radius: 14px;
            border: 1px solid var(--admin-border);
            box-shadow: 0 1px 2px rgba(0,0,0,.04);
            padding: 1.25rem 1.35rem;
        }
        .admin-panel-title {
            font-size: 1.05rem;
            font-weight: 700;
            margin: 0 0 0.25rem;
        }
        .admin-panel-sub {
            font-size: 0.85rem;
            color: var(--admin-muted);
            margin-bottom: 1rem;
        }
        .btn-admin-primary {
            background: var(--admin-accent);
            color: #fff;
            border: none;
            padding: 0.55rem 1.1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: filter .15s;
        }
        .btn-admin-primary:hover { filter: brightness(1.05); color: #fff; }
        .btn-admin-ghost {
            background: #fff;
            border: 1px solid var(--admin-border);
            color: var(--admin-text);
            padding: 0.45rem 0.85rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-admin-ghost:hover { background: #f9fafb; }
        .btn-admin-danger {
            background: #fff;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 0.45rem 0.85rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
        }
        .btn-admin-danger:hover { background: #fef2f2; }
        .btn-admin-warn {
            background: #fff;
            border: 1px solid #fde68a;
            color: #b45309;
            padding: 0.45rem 0.85rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
        }
        .badge-role {
            display: inline-block;
            padding: 0.2rem 0.55rem;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: .03em;
            text-transform: uppercase;
        }
        .badge-role.admin { background: #1f2937; color: #fff; }
        .badge-role.user { background: #111827; color: #fff; }
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
            background: #d1fae5;
            color: #065f46;
        }
        .badge-status.inactive {
            background: #fee2e2;
            color: #991b1b;
        }
        .badge-status .dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: currentColor;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }
        .admin-table thead th {
            background: #111827;
            color: #fff;
            text-align: left;
            padding: 0.75rem 1rem;
            font-weight: 600;
            font-size: 0.78rem;
            letter-spacing: .04em;
            text-transform: uppercase;
        }
        .admin-table thead th:first-child { border-radius: 10px 0 0 0; }
        .admin-table thead th:last-child { border-radius: 0 10px 0 0; }
        .admin-table tbody td {
            padding: 0.9rem 1rem;
            border-bottom: 1px solid var(--admin-border);
            vertical-align: middle;
        }
        .admin-table tbody tr:hover { background: #fafafa; }
        .user-cell strong { display: block; font-weight: 600; }
        .user-cell span { font-size: 0.8rem; color: var(--admin-muted); }
        .admin-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
            margin-bottom: 1.15rem;
            align-items: center;
        }
        .admin-filters input,
        .admin-filters select {
            border: 1px solid var(--admin-border);
            border-radius: 10px;
            padding: 0.55rem 0.85rem;
            font-size: 0.9rem;
            background: #fff;
            color: var(--admin-text);
            min-width: 0;
        }
        .admin-filters input { flex: 1; min-width: 180px; }
        .admin-filters select { min-width: 140px; }
        .admin-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        @media (max-width: 700px) {
            .admin-form-grid { grid-template-columns: 1fr; }
        }
        .admin-form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.35rem;
            color: var(--admin-text);
        }
        .admin-form-group input,
        .admin-form-group select {
            width: 100%;
            border: 1px solid var(--admin-border);
            border-radius: 10px;
            padding: 0.6rem 0.85rem;
            font-size: 0.925rem;
            background: #fff;
        }
        .admin-form-group .error {
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }
        .admin-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        .login-activity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--admin-border);
            gap: 1rem;
        }
        .login-activity-item:last-child { border-bottom: none; }
        .login-activity-item .meta { font-size: 0.8rem; color: var(--admin-muted); }
        .login-activity-item .time { font-size: 0.8rem; color: var(--admin-muted); white-space: nowrap; }
    </style>
</head>
<body class="admin-body">
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand">
            <span class="admin-brand-icon">K</span>
            <span>KursusKu.</span>
        </a>

        <div class="admin-nav">
            <div class="admin-nav-section">Administrasi</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                <span>Admin Dashboard</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span>Manajemen Pengguna</span>
            </a>
            <a href="{{ route('courses.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                <span>Kelola Kursus</span>
            </a>
            <a href="{{ route('enrollments.index') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                <span>Laporan Enrollment</span>
            </a>

            <div class="admin-nav-section">Akun Saya</div>
            <a href="{{ route('dashboard') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span>Dashboard Personal</span>
            </a>
            <a href="{{ route('profile.edit') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                <span>Edit Profil</span>
            </a>
            <a href="{{ route('home') }}" target="_blank">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>Lihat Situs Publik</span>
            </a>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <h1>@yield('page_title', 'Admin Dashboard')</h1>
            <div class="admin-topbar-right">
                <div class="admin-topbar-user">
                    <strong>ADMIN</strong> {{ auth()->user()->name }}
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout-outline">Logout</button>
                </form>
            </div>
        </header>

        <div class="admin-content">
            @if (session('success'))
                <div class="admin-flash">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="admin-flash admin-flash-error">
                    <ul style="margin:0;padding-left:1.1rem;">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
