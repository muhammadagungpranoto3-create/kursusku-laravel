@extends('layouts.app')

@section('title', 'Dashboard Akun')

@section('content')
<div class="kk-dash-hero">
    <div>
        <p class="kk-dash-eyebrow">Dashboard Personal</p>
        <h1 class="kk-dash-title">Halo, <span>{{ $user->name }}</span></h1>
        <p class="kk-dash-lead">Kelola informasi akun, foto profil, dan keamanan kata sandi Anda dari satu tempat.</p>
    </div>
    <a href="{{ route('courses.index') }}" class="btn btn-accent">Jelajahi Kursus</a>
</div>

<div class="row g-4 mt-1">
    <div class="col-lg-4">
        <section class="kk-panel kk-profile-card p-4 text-center">
            @include('partials.avatar', ['user' => $user, 'size' => 'xl'])
            <h2 class="kk-profile-name mt-3">{{ $user->name }}</h2>
            <p class="kk-muted mb-2">{{ $user->email }}</p>
            <div class="d-flex justify-content-center gap-2 mb-3">
                <span class="kk-role {{ $user->isAdmin() ? 'is-admin' : '' }}">{{ $user->isAdmin() ? 'ADMIN' : 'USER' }}</span>
                <span class="badge-status {{ $user->is_active ? '' : 'inactive' }}" style="font-size:0.8rem;">
                    <span class="dot" style="width:7px;height:7px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn btn-accent w-100">Edit Profil</a>
            <a href="{{ route('profile') }}#password" class="btn btn-ghost w-100 mt-2">Ubah Kata Sandi</a>
        </section>
    </div>

    <div class="col-lg-8">
        <section class="kk-panel p-4">
            <h2 class="kk-panel-title">Informasi Akun</h2>
            <p class="kk-muted mb-3" style="font-size:0.9rem;">Detail identitas dan catatan aktivitas sesi akun Anda.</p>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="kk-info-box">
                        <span class="kk-info-label">Nama Lengkap</span>
                        <strong>{{ $user->name }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="kk-info-box">
                        <span class="kk-info-label">Username</span>
                        <strong>@{{ $user->username }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="kk-info-box">
                        <span class="kk-info-label">Alamat Email</span>
                        <strong>{{ $user->email }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="kk-info-box">
                        <span class="kk-info-label">Nomor Telepon</span>
                        <strong>{{ $user->phone ?: '—' }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="kk-info-box">
                        <span class="kk-info-label">Login Terakhir</span>
                        <strong>
                            @if ($user->last_login_at)
                                {{ $user->last_login_at->format('d/m/Y H:i') }}
                            @else
                                Belum pernah
                            @endif
                        </strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="kk-info-box">
                        <span class="kk-info-label">Bergabung</span>
                        <strong>{{ $user->created_at?->translatedFormat('d F Y') ?? '—' }}</strong>
                    </div>
                </div>
            </div>

            @if ($user->isAdmin())
                <div class="mt-4">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-accent">Buka Admin Dashboard</a>
                </div>
            @endif
        </section>
    </div>
</div>
@endsection
