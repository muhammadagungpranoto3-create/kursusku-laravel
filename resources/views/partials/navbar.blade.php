<nav class="navbar navbar-expand-lg kk-nav">
    <div class="container">
        <a class="kk-brand" href="{{ route('home') }}">
            <span class="kk-brand-mark" aria-hidden="true">K</span>
            <span>KursusKu</span>
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar"
                aria-controls="mainNavbar"
                aria-expanded="false"
                aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">Kursus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('enrollments.index') ? 'active' : '' }}" href="{{ route('enrollments.index') }}">Laporan</a>
                </li>
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a class="btn btn-accent btn-sm" href="{{ route('enrollments.create') }}">Daftarkan peserta</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
