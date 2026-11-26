@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9 col-lg-6">
        <div class="kk-auth-head text-center">
            <span class="kk-brand-mark kk-auth-mark" aria-hidden="true">K</span>
            <h1>Buat akun baru</h1>
            <p>Data akun disimpan di tabel <code>users</code>, password disimpan dalam bentuk hash.</p>
        </div>

        <form method="POST" action="{{ route('register.store') }}" class="form-glass p-4 p-md-5" novalidate>
            @csrf

            <div class="mb-3">
                <label class="form-label" for="name">Nama Lengkap</label>
                <input id="name" name="name" maxlength="100" autocomplete="name" autofocus
                       value="{{ old('name') }}"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input id="username" name="username" maxlength="30" autocomplete="username"
                           placeholder="huruf, angka, _ atau -"
                           value="{{ old('username') }}"
                           class="form-control @error('username') is-invalid @enderror">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" name="email" type="email" maxlength="255" autocomplete="email"
                           value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <div class="kk-password">
                    <input id="password" name="password" type="password" autocomplete="new-password"
                           class="form-control @error('password') is-invalid @enderror">
                    <button type="button" class="kk-password-toggle" data-toggle-password="#password, #password_confirmation"
                            aria-label="Tampilkan password" aria-pressed="false">
                        <svg class="icon-eye" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg class="icon-eye-off" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17.9 17.9A10.9 10.9 0 0 1 12 19c-6.4 0-10-7-10-7a18.1 18.1 0 0 1 5.1-5.9M9.9 4.2A10.4 10.4 0 0 1 12 4c6.4 0 10 7 10 7a18.2 18.2 0 0 1-2.2 3.2M1 1l22 22"/><path d="M14.1 14.1a3 3 0 1 1-4.2-4.2"/></svg>
                    </button>
                </div>
                <div class="form-text">Minimal 8 karakter.</div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label" for="password_confirmation">Ulangi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                       class="form-control">
            </div>

            <button type="submit" class="btn btn-accent w-100 py-2">Daftar</button>

            <p class="text-center mt-4 mb-0 kk-muted">
                Sudah punya akun? <a class="kk-link" href="{{ route('login') }}">Masuk</a>
            </p>
        </form>
    </div>
</div>
@endsection
