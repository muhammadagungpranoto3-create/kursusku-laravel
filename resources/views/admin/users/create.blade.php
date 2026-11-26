@extends('layouts.admin')

@section('title', 'Tambah Pengguna')
@section('page_title', 'Tambah Pengguna')

@section('content')
<section class="admin-panel" style="max-width:720px;">
    <h2 class="admin-panel-title">Form Tambah Pengguna</h2>
    <p class="admin-panel-sub">Buat akun baru untuk administrator atau peserta.</p>

    <form method="POST" action="{{ route('admin.users.store') }}" novalidate>
        @csrf
        <div class="admin-form-grid">
            <div class="admin-form-group">
                <label for="name">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required>
                @error('name')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-form-group">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" value="{{ old('username') }}" required>
                @error('username')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-form-group">
                <label for="phone">Nomor Telepon</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                @error('phone')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="user" @selected(old('role', 'user') === 'user')>User</option>
                    <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                </select>
                @error('role')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-form-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
                @error('password')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required>
            </div>
        </div>

        <div class="admin-check">
            <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', true))>
            <label for="is_active" style="margin:0;font-weight:500;">Akun aktif (boleh login)</label>
        </div>

        <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
            <button type="submit" class="btn-admin-primary">Simpan Pengguna</button>
            <a href="{{ route('admin.users.index') }}" class="btn-admin-ghost">Batal</a>
        </div>
    </form>
</section>
@endsection
