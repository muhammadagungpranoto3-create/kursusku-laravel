@extends('layouts.admin')

@section('title', 'Detail Pengguna')
@section('page_title', 'Detail Pengguna')

@section('content')
<section class="admin-panel" style="max-width:720px;">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;margin-bottom:1.25rem;">
        <div>
            <h2 class="admin-panel-title">{{ $user->name }}</h2>
            <p class="admin-panel-sub" style="margin:0;">@{{ $user->username }} · {{ $user->email }}</p>
        </div>
        <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn-admin-warn">Edit</a>
            <a href="{{ route('admin.users.index') }}" class="btn-admin-ghost">Kembali</a>
        </div>
    </div>

    <div class="admin-form-grid" style="gap:1.25rem;">
        <div>
            <div style="font-size:0.75rem;font-weight:600;text-transform:uppercase;color:#6b7280;margin-bottom:0.25rem;">Role</div>
            <span class="badge-role {{ $user->isAdmin() ? 'admin' : 'user' }}">
                {{ $user->isAdmin() ? 'ADMIN' : 'USER' }}
            </span>
        </div>
        <div>
            <div style="font-size:0.75rem;font-weight:600;text-transform:uppercase;color:#6b7280;margin-bottom:0.25rem;">Status</div>
            <span class="badge-status {{ $user->is_active ? '' : 'inactive' }}">
                <span class="dot"></span>
                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>
        <div>
            <div style="font-size:0.75rem;font-weight:600;text-transform:uppercase;color:#6b7280;margin-bottom:0.25rem;">Nomor Telepon</div>
            <div>{{ $user->phone ?: '—' }}</div>
        </div>
        <div>
            <div style="font-size:0.75rem;font-weight:600;text-transform:uppercase;color:#6b7280;margin-bottom:0.25rem;">Login Terakhir</div>
            <div>
                @if ($user->last_login_at)
                    {{ $user->last_login_at->format('d/m/Y H:i') }}
                    <span style="color:#6b7280;font-size:0.85rem;">({{ $user->last_login_at->diffForHumans() }})</span>
                @else
                    Belum pernah
                @endif
            </div>
        </div>
        <div>
            <div style="font-size:0.75rem;font-weight:600;text-transform:uppercase;color:#6b7280;margin-bottom:0.25rem;">Bergabung</div>
            <div>{{ $user->created_at?->format('d/m/Y H:i') ?? '—' }}</div>
        </div>
        <div>
            <div style="font-size:0.75rem;font-weight:600;text-transform:uppercase;color:#6b7280;margin-bottom:0.25rem;">Diperbarui</div>
            <div>{{ $user->updated_at?->format('d/m/Y H:i') ?? '—' }}</div>
        </div>
    </div>

    @if ($user->id !== auth()->id())
        <div style="margin-top:1.75rem;padding-top:1.25rem;border-top:1px solid #e5e7eb;display:flex;gap:0.75rem;flex-wrap:wrap;">
            <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-admin-danger">
                    {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                </button>
            </form>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                  onsubmit="return confirm('Hapus permanen pengguna {{ $user->name }}?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-admin-danger">Hapus Pengguna</button>
            </form>
        </div>
    @endif
</section>
@endsection
