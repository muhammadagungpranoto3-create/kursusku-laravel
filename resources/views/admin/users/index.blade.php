@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')
@section('page_title', 'Manajemen Pengguna')

@section('content')
<section class="admin-panel">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;margin-bottom:1.25rem;">
        <div>
            <h2 class="admin-panel-title">Daftar Pengguna</h2>
            <p class="admin-panel-sub" style="margin:0;">Kelola akun administrator dan peserta terdaftar.</p>
        </div>
        <div style="display:flex;align-items:center;gap:0.75rem;">
            <span class="btn-admin-ghost" style="cursor:default;">{{ $totalCount }} Pengguna</span>
            <a href="{{ route('admin.users.create') }}" class="btn-admin-primary">+ Tambah Pengguna</a>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.users.index') }}" class="admin-filters">
        <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Cari nama, username, atau email...">
        <select name="role">
            <option value="">Semua Role</option>
            <option value="admin" @selected($filters['role'] === 'admin')>Admin</option>
            <option value="user" @selected($filters['role'] === 'user')>User</option>
        </select>
        <select name="status">
            <option value="">Semua Status</option>
            <option value="active" @selected($filters['status'] === 'active')>Aktif</option>
            <option value="inactive" @selected($filters['status'] === 'inactive')>Nonaktif</option>
        </select>
        <button type="submit" class="btn-admin-primary">Terapkan</button>
        <a href="{{ route('admin.users.index') }}" class="btn-admin-ghost">Reset</a>
    </form>

    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Pengguna</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Login Terakhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $i => $u)
                    <tr>
                        <td>{{ $users->firstItem() + $i }}</td>
                        <td class="user-cell">
                            <strong>{{ $u->name }}</strong>
                            <span>{{ $u->email }}</span>
                        </td>
                        <td>@{{ $u->username }}</td>
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
                            @if ($u->last_login_at)
                                {{ $u->last_login_at->format('d/m/Y H:i') }}
                            @else
                                <span style="color:#9ca3af;">Belum pernah</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
                                <a href="{{ route('admin.users.show', $u) }}" class="btn-admin-ghost">Detail</a>
                                <a href="{{ route('admin.users.edit', $u) }}" class="btn-admin-warn">Edit</a>
                                @if ($u->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.toggle', $u) }}" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-admin-danger">
                                            {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2.5rem;color:#6b7280;">
                            Tidak ada pengguna yang cocok dengan filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div style="margin-top:1.25rem;">
            {{ $users->links() }}
        </div>
    @endif
</section>
@endsection
