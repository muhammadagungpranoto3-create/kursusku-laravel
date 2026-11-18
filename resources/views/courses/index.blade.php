@extends('layouts.app')

@section('title', 'Daftar Kursus')

@section('content')
<div class="kk-page-head">
    <div>
        <h1>Daftar Kursus</h1>
        <p>Data diambil dari MySQL melalui Eloquent. Kolom Terisi dihitung dari tabel enrollments.</p>
    </div>
    <a href="{{ route('courses.create') }}" class="btn btn-accent">+ Tambah Kursus</a>
</div>

<div class="kk-panel p-0">
    <div class="table-responsive">
        <table class="table kk-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Biaya</th>
                    <th style="min-width: 190px">Terisi</th>
                    <th>Mulai</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($courses as $course)
                    @php
                        $statusClass = match ($course->status) {
                            'open' => 'ok',
                            'draft' => 'low',
                            default => 'full',
                        };
                    @endphp
                    <tr>
                        <td><span class="course-code">{{ $course->code }}</span></td>
                        <td class="fw-semibold">{{ $course->name }}</td>
                        <td>Rp {{ number_format($course->fee, 0, ',', '.') }}</td>
                        <td>@include('partials.seat-meter', ['enrolled' => $course->enrollments_count, 'quota' => $course->quota])</td>
                        <td>{{ $course->start_date->format('d/m/Y') }}</td>
                        <td><span class="seat-pill {{ $statusClass }}">{{ ucfirst($course->status) }}</span></td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap justify-content-end">
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-soft">Detail</a>
                                <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-soft">Edit</a>
                                <form method="POST"
                                      action="{{ route('courses.destroy', $course) }}"
                                      onsubmit="return confirm('Hapus kursus ini? Data enrollment kursus ini ikut terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-soft-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="kk-empty border-0 my-3">
                                <strong>Belum ada data kursus.</strong>
                                <p>Tambahkan kursus pertama, atau jalankan <code>php artisan db:seed --class=CourseSeeder</code>.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
