@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="kk-page-head">
    <div>
        <h1>Profil Saya</h1>
        <p>Ringkasan akun dan pintasan ke fitur KursusKu.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm">Dashboard</a>
        <a href="{{ route('profile.edit') }}" class="btn btn-accent btn-sm">Edit Profil</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-soft-danger btn-sm">Keluar</button>
        </form>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <section class="kk-panel kk-profile-card p-4 text-center">
            @include('partials.avatar', ['user' => $user, 'size' => 'xl'])
            <h2 class="kk-profile-name">{{ $user->name }}</h2>
            <p class="kk-muted mb-2">&#64;{{ $user->username ?? 'tanpa-username' }}</p>
            <span class="kk-role {{ $user->isAdmin() ? 'is-admin' : '' }}">{{ $user->isAdmin() ? 'Admin' : 'Pengguna' }}</span>
        </section>
    </div>

    <div class="col-lg-8">
        <section class="kk-panel p-4 mb-4">
            <h2 class="kk-panel-title">Data akun</h2>
            <dl class="kk-dl">
                <div><dt>Nama lengkap</dt><dd>{{ $user->name }}</dd></div>
                <div><dt>Username</dt><dd>{{ $user->username ?? '-' }}</dd></div>
                <div><dt>Email</dt><dd>{{ $user->email }}</dd></div>
                <div><dt>Telepon</dt><dd>{{ $user->phone ?: '-' }}</dd></div>
                <div><dt>Peran</dt><dd>{{ $user->isAdmin() ? 'Admin' : 'Pengguna' }}</dd></div>
                <div><dt>Status</dt><dd>{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</dd></div>
                <div><dt>Login terakhir</dt><dd>{{ $user->last_login_at?->format('d/m/Y H:i') ?? 'Belum pernah' }}</dd></div>
                <div><dt>Bergabung</dt><dd>{{ $user->created_at?->translatedFormat('d F Y') ?? '-' }}</dd></div>
            </dl>
        </section>

        <section class="kk-panel p-4" id="password">
            <h2 class="kk-panel-title">Ubah Kata Sandi</h2>
            <p class="kk-muted mb-3" style="font-size:0.9rem;">Pastikan password baru kuat dan tidak digunakan di layanan lain.</p>

            <form method="POST" action="{{ route('profile.password') }}" class="form-glass p-0" novalidate>
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label" for="current_password">Password Saat Ini</label>
                    <input id="current_password" name="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" required>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password Baru</label>
                    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-accent">Simpan Password</button>
            </form>
        </section>
    </div>
</div>
@endsection
