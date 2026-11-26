@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-5">
        <div class="kk-auth-head text-center">
            <span class="kk-brand-mark kk-auth-mark" aria-hidden="true">K</span>
            <h1>Lupa password?</h1>
            <p>Masukkan email akun Anda untuk membuat tautan reset password.</p>
        </div>

        <form method="POST" action="{{ route('password.email') }}" class="form-glass p-4 p-md-5" novalidate>
            @csrf

            @if (session('status'))
                <div class="kk-notice" role="status">{{ session('status') }}</div>
            @endif

            @if (session('reset_link'))
                <div class="kk-notice kk-notice-link">
                    <span>Tautan reset password:</span>
                    <a class="btn btn-ghost btn-sm mt-2" href="{{ session('reset_link') }}">Buka halaman reset password</a>
                </div>
            @endif

            <div class="mb-4">
                <label class="form-label" for="email">Email</label>
                <input id="email" name="email" type="email" autocomplete="email" autofocus
                       value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-accent w-100 py-2">Buat tautan reset</button>

            <p class="text-center mt-4 mb-0 kk-muted">
                <a class="kk-link" href="{{ route('login') }}">&larr; Kembali ke halaman masuk</a>
            </p>
        </form>
    </div>
</div>
@endsection
