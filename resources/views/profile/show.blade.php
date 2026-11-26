@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="kk-page-head">
    <div>
        <h1>Profil Saya</h1>
        <p>Ringkasan akun dan pintasan ke fitur KursusKu.</p>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-soft-danger">Keluar</button>
    </form>
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
                <div><dt>Peran</dt><dd>{{ $user->isAdmin() ? 'Admin' : 'Pengguna' }}</dd></div>
                <div><dt>Bergabung</dt><dd>{{ $user->created_at?->translatedFormat('d F Y') ?? '-' }}</dd></div>
            </dl>
        </section>

        <section class="kk-panel p-4">
            <h2 class="kk-panel-title">Ringkasan KursusKu</h2>
            <div class="row g-3 text-center">
                <div class="col-4"><div class="kk-mini-stat"><strong>{{ $stats['courses'] }}</strong><span>Kursus</span></div></div>
                <div class="col-4"><div class="kk-mini-stat"><strong>{{ $stats['participants'] }}</strong><span>Peserta</span></div></div>
                <div class="col-4"><div class="kk-mini-stat"><strong>{{ $stats['enrollments'] }}</strong><span>Pendaftaran</span></div></div>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-4">
                <a class="btn btn-ghost btn-sm" href="{{ route('courses.index') }}">Kelola kursus</a>
                <a class="btn btn-ghost btn-sm" href="{{ route('enrollments.index') }}">Lihat laporan</a>
                <a class="btn btn-ghost btn-sm" href="{{ route('enrollments.create') }}">Daftarkan peserta</a>
            </div>
        </section>
    </div>
</div>
@endsection
