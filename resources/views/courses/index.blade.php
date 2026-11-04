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
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-secondary">
                            Belum ada data kursus.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
