@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="kk-page-head">
    <div>
        <h1>Edit Profil</h1>
        <p>Perbarui informasi identitas akun Anda.</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm">Kembali</a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <section class="kk-panel p-4">
            <form method="POST" action="{{ route('profile.update') }}" novalidate>
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                           class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}"
                           class="form-control @error('username') is-invalid @enderror" required>
                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                           class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" for="phone">Nomor Telepon</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}"
                           class="form-control @error('phone') is-invalid @enderror" placeholder="08xxxxxxxxxx">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-accent">Simpan Perubahan</button>
                    <a href="{{ route('profile') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
