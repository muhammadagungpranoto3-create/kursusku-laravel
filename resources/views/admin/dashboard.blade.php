@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Admin Dashboard')

@section('content')
<div class="admin-stat-grid">
    <div class="admin-stat-card">
        <div class="label">Total Pengguna</div>
        <div class="value">{{ $stats['total'] }}</div>
        <div class="hint">Seluruh akun terdaftar</div>
    </div>
    <div class="admin-stat-card">
        <div class="label">Pengguna Aktif</div>
        <div class="value" style="color:#059669">{{ $stats['active'] }}</div>
        <div class="hint">Diizinkan masuk sistem</div>
    </div>
    <div class="admin-stat-card">
        <div class="label">Pengguna Nonaktif</div>
        <div class="value">{{ $stats['inactive'] }}</div>
        <div class="hint">Akses dibatasi sementara</div>
    </div>
    <div class="admin-stat-card is-accent">
        <div class="label">Total Administrator</div>
        <div class="value">{{ $stats['admins'] }}</div>
        <div class="hint">Hak akses penuh</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1.4fr 1fr;gap:1.25rem;">
    <section class="admin-panel">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;margin-bottom:0.5rem;">
            <div>
                <h2 class="admin-panel-title">Pengguna Terbaru</h2>
                <p class="admin-panel-sub" style="margin:0;">5 akun yang paling baru dibuat di sistem.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn-admin-primary">Kelola Pengguna</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentUsers as $u)
                    <tr>
                        <td class="user-cell">
                            <strong>{{ $u->name }}</strong>
                            <span>{{ $u->email }}</span>
                        </td>
                        <td>
                            <span class="badge-role {{ $u->isAdmin() ? 'admin' : 'user' }}">
                                {{ $u->isAdmin() ? 'ADMIN' : 'USER' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-status {{ $u->is_active ? '' : 'inactive' }}">
                                <span class="dot"></span>
                                {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $u) }}" class="btn-admin-ghost">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#6b7280;padding:2rem;">Belum ada pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <section class="admin-panel">
        <h2 class="admin-panel-title">Aktivitas Login Terbaru</h2>
        <p class="admin-panel-sub">Catatan waktu masuk terakhir pengguna.</p>

        <a href="{{ route('admin.users.create') }}" class="btn-admin-ghost" style="margin-bottom:1rem;display:inline-flex;">+ Tambah Akun</a>

        @forelse ($recentLogins as $u)
            <div class="login-activity-item">
                <div>
                    <strong style="display:block;font-size:0.9rem;">{{ $u->name }}</strong>
                    <span class="meta">{{ $u->email }}</span>
                </div>
                <span class="time">{{ $u->last_login_at?->diffForHumans() ?? '—' }}</span>
            </div>
        @empty
            <p style="color:#6b7280;font-size:0.9rem;margin:1rem 0 0;">Belum ada aktivitas login.</p>
        @endforelse
    </section>
</div>
@endsection
