@extends('layouts.admin')

@section('title', 'Edit Pengguna')
@section('page_title', 'Edit Pengguna')

@section('content')
<section class="admin-panel" style="max-width:720px;">
    <h2 class="admin-panel-title">Edit: {{ $user->name }}</h2>
    <p class="admin-panel-sub">Perbarui data akun. Kosongkan password jika tidak ingin mengubahnya.</p>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" novalidate>
        @csrf
        @method('PUT')
        <div class="admin-form-grid">
            <div class="admin-form-group">
                <label for="name">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-form-group">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" required>
                @error('username')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-form-group">
                <label for="phone">Nomor Telepon</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
                @error('phone')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required @disabled($user->id === auth()->id())>
                    <option value="user" @selected(old('role', $user->role) === 'user')>User</option>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                </select>
                @if ($user->id === auth()->id())
                    <input type="hidden" name="role" value="{{ $user->role }}">
                @endif
                @error('role')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-form-group">
                <label for="password">Password Baru <span style="font-weight:400;color:#6b7280;">(opsional)</span></label>
                <input id="password" name="password" type="password" autocomplete="new-password">
                @error('password')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
            </div>
        </div>

        <div class="admin-check">
            <input type="checkbox" name="is_active" id="is_active" value="1"
                   @checked(old('is_active', $user->is_active))
                   @disabled($user->id === auth()->id())>
            <label for="is_active" style="margin:0;font-weight:500;">Akun aktif (boleh login)</label>
            @if ($user->id === auth()->id())
                <input type="hidden" name="is_active" value="1">
            @endif
        </div>

        <div style="display:flex;gap:0.75rem;margin-top:1.5rem;flex-wrap:wrap;">
            <button type="submit" class="btn-admin-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.users.show', $user) }}" class="btn-admin-ghost">Batal</a>
        </div>
    </form>
</section>
@endsection
