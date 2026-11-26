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
                    <a class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">Daftar Kursus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('enrollments.create') ? 'active' : '' }}" href="{{ route('enrollments.create') }}">Pendaftaran</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                @endauth
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a class="btn btn-accent btn-sm" href="{{ route('enrollments.create') }}">Daftarkan peserta</a>
                </li>

                @auth
                    <li class="nav-item dropdown ms-lg-2 mt-2 mt-lg-0">
                        <a class="kk-user-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menu profil">
                            @include('partials.avatar', ['user' => auth()->user(), 'size' => 'sm'])
                            <span class="kk-user-name">{{ auth()->user()->username ?? auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end kk-dropdown">
                            <li class="kk-dropdown-head">
                                <strong>{{ auth()->user()->name }}</strong>
                                <small>{{ auth()->user()->email }}</small>
                            </li>
                            <li><a class="dropdown-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('profile*') ? 'active' : '' }}" href="{{ route('profile') }}">Profil Saya</a></li>
                            @if (auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item kk-logout">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item ms-lg-1 mt-2 mt-lg-0">
                        <a class="btn btn-ghost btn-sm" href="{{ route('login') }}">Masuk</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
