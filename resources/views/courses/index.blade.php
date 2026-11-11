@extends('layouts.app')

@section('title', 'Daftar Kursus')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h1 class="h3 mb-1 fw-bold">Daftar Kursus</h1>
        <p class="text-secondary mb-0">Data diambil dari MySQL melalui Eloquent.</p>
    </div>
    <a href="{{ route('courses.create') }}" class="btn btn-accent">+ Tambah Kursus</a>
</div>

<div class="form-glass p-0">
    <div class="table-responsive">
        <table class="table table-striped mb-0 align-middle">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Biaya</th>
                    <th>Kuota</th>
                    <th>Mulai</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($courses as $course)
                    <tr>
                        <td><span class="course-code">{{ $course->code }}</span></td>
                        <td>{{ $course->name }}</td>
                        <td>Rp {{ number_format($course->fee, 0, ',', '.') }}</td>
                        <td>{{ $course->quota }}</td>
                        <td>{{ $course->start_date->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $statusClass = match ($course->status) {
                                    'open' => 'ok',
                                    'draft' => 'low',
                                    default => 'full',
                                };
                            @endphp
                            <span class="seat-pill {{ $statusClass }}">{{ ucfirst($course->status) }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap justify-content-end">
                                <a href="{{ route('courses.show', $course) }}"
                                   class="btn btn-sm btn-outline-primary">Detail</a>
                                <a href="{{ route('courses.edit', $course) }}"
                                   class="btn btn-sm btn-outline-warning">Edit</a>
                                <form method="POST"
                                      action="{{ route('courses.destroy', $course) }}"
                                      onsubmit="return confirm('Hapus kursus ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-secondary">
                            Belum ada data kursus.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
