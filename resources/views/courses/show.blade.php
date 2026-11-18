@extends('layouts.app')

@section('title', 'Detail Kursus')

{{-- Flash message "success" sudah ditampilkan oleh layouts/app.blade.php --}}
@section('content')
@php
    $statusClass = match ($course->status) {
        'open' => 'ok',
        'draft' => 'low',
        default => 'full',
    };
@endphp

<div class="kk-page-head">
    <div>
        <h1>{{ $course->name }}</h1>
        <p><span class="course-code">{{ $course->code }}</span> <span class="seat-pill {{ $statusClass }} ms-1">{{ ucfirst($course->status) }}</span></p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('courses.index') }}" class="btn btn-ghost">Kembali</a>
        <a href="{{ route('courses.edit', $course) }}" class="btn btn-accent">Edit</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="kk-panel h-100">
            <h2 class="kk-panel-title">Informasi kursus</h2>
            <dl class="kk-detail">
                <div><dt>Kode</dt><dd><span class="course-code">{{ $course->code }}</span></dd></div>
                <div><dt>Nama</dt><dd>{{ $course->name }}</dd></div>
                <div><dt>Deskripsi</dt><dd>{{ $course->description ?: '-' }}</dd></div>
                <div><dt>Biaya</dt><dd>Rp {{ number_format($course->fee, 0, ',', '.') }}</dd></div>
                <div><dt>Kuota</dt><dd>{{ $course->quota }} peserta</dd></div>
                <div><dt>Tanggal Mulai</dt><dd>{{ $course->start_date?->format('d-m-Y') }}</dd></div>
                <div><dt>Status</dt><dd><span class="seat-pill {{ $statusClass }}">{{ ucfirst($course->status) }}</span></dd></div>
            </dl>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="kk-panel h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="kk-panel-title mb-0">Peserta terdaftar</h2>
                @if ($course->status === 'open')
                    <a class="btn btn-accent btn-sm" href="{{ route('enrollments.create', ['course' => $course->id]) }}">Daftarkan</a>
                @endif
            </div>

            @include('partials.seat-meter', ['enrolled' => $course->enrollments->count(), 'quota' => $course->quota])

            <ul class="kk-people">
                @forelse ($course->enrollments as $enrollment)
                    <li>
                        <span class="kk-avatar">{{ mb_strtoupper(mb_substr($enrollment->participant->name, 0, 1)) }}</span>
                        <div>
                            <strong>{{ $enrollment->participant->name }}</strong>
                            <small>{{ $enrollment->participant->email }}</small>
                        </div>
                    </li>
                @empty
                    <li class="kk-people-empty">Belum ada peserta di kursus ini.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
