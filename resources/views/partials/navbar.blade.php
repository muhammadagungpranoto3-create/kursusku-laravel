<nav class="navbar navbar-expand-lg kk-nav navbar-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">KursusKu</a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar"
                aria-controls="mainNavbar"
                aria-expanded="false"
                aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">Daftar Kursus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('enrollments.*') ? 'active' : '' }}" href="{{ route('enrollments.create') }}">Pendaftaran</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
