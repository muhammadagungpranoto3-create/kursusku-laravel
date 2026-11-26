@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-5">
        <div class="kk-auth-head text-center">
            <span class="kk-brand-mark kk-auth-mark" aria-hidden="true">K</span>
            <h1>Masuk ke KursusKu</h1>
            <p>Gunakan username atau email akun Anda.</p>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="form-glass p-4 p-md-5" novalidate>
            @csrf

            <div class="mb-3">
                <label class="form-label" for="login">Username atau Email</label>
                <input id="login" name="login" type="text" autocomplete="username" autofocus
                       placeholder="contoh: admin"
                       value="{{ old('login') }}"
                       class="form-control @error('login') is-invalid @enderror">
                @error('login')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <div class="kk-password">
                    <input id="password" name="password" type="password" autocomplete="current-password"
                           placeholder="Masukkan password"
                           class="form-control @error('password') is-invalid @enderror">
                    <button type="button" class="kk-password-toggle" data-toggle-password="#password"
                            aria-label="Tampilkan password" aria-pressed="false">
                        <svg class="icon-eye" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg class="icon-eye-off" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17.9 17.9A10.9 10.9 0 0 1 12 19c-6.4 0-10-7-10-7a18.1 18.1 0 0 1 5.1-5.9M9.9 4.2A10.4 10.4 0 0 1 12 4c6.4 0 10 7 10 7a18.2 18.2 0 0 1-2.2 3.2M1 1l22 22"/><path d="M14.1 14.1a3 3 0 1 1-4.2-4.2"/></svg>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                <div class="form-check m-0">
                    <input class="form-check-input kk-check" type="checkbox" name="remember" id="remember" value="1" @checked(old('remember'))>
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
                <a class="kk-link" href="{{ route('password.request') }}">Lupa password?</a>
            </div>

            <button type="submit" class="btn btn-accent w-100 py-2">Masuk</button>

            <p class="text-center mt-4 mb-0 kk-muted">
                Belum punya akun? <a class="kk-link" href="{{ route('register') }}">Daftar sekarang</a>
            </p>
        </form>

        @if (app()->environment('local'))
            <p class="text-center mt-3 kk-muted small">
                Akun demo: <code>admin</code> / <code>admin123</code> (jalankan <code>php artisan db:seed --class=UserSeeder</code>)
            </p>
        @endif
    </div>
</div>
@endsection
