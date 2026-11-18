@extends('layouts.app')

@section('title', 'Beranda - KursusKu')

@section('content')
<section class="kk-hero">
    <div class="kk-hero-copy">
        <h1>Pilih kursus, daftarkan peserta, pantau kursinya.</h1>
        <p>
            Setiap pendaftaran tersimpan sebagai relasi antara satu peserta dan satu kursus,
            sehingga tidak ada data ganda dan laporan selalu sinkron.
        </p>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('enrollments.create') }}" class="btn btn-accent btn-lg">Daftarkan peserta</a>
            <a href="{{ route('courses.index') }}" class="btn btn-ghost btn-lg">Kelola kursus</a>
        </div>

        <dl class="kk-facts">
            <div><dt>Kursus dibuka</dt><dd>{{ $stats['courses'] }}</dd></div>
            <div><dt>Peserta</dt><dd>{{ $stats['participants'] }}</dd></div>
            <div><dt>Pendaftaran</dt><dd>{{ $stats['enrollments'] }}</dd></div>
        </dl>
    </div>

    <div class="kk-hero-visual">
        <img src="{{ asset('images/hero-kursus.jpg') }}" alt="" width="640" height="520">

        <aside class="kk-live" aria-label="Pendaftaran terbaru">
            <h2>Pendaftaran terbaru</h2>
            @forelse ($recent as $enrollment)
                <div class="kk-live-row">
                    <span class="kk-avatar">{{ mb_strtoupper(mb_substr($enrollment->participant->name, 0, 1)) }}</span>
                    <div>
                        <strong>{{ $enrollment->participant->name }}</strong>
                        <small>{{ $enrollment->course->name }}</small>
                    </div>
                </div>
            @empty
                <p class="kk-live-empty">Belum ada pendaftaran. Daftarkan peserta pertama.</p>
            @endforelse
        </aside>
    </div>
</section>

<section class="kk-section">
    <div class="kk-section-head">
        <h2>Program yang dibuka</h2>
        <a href="{{ route('courses.index') }}">Lihat semua kursus</a>
    </div>

    <div class="row g-3">
        @forelse ($featured as $course)
            <div class="col-md-6 col-lg-4">
                <article class="kk-course">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <span class="course-code">{{ $course->code }}</span>
                        <span class="kk-date">Mulai {{ $course->start_date->locale('id')->translatedFormat('d M Y') }}</span>
                    </div>
                    <h3>{{ $course->name }}</h3>
                    <p>{{ $course->description }}</p>

                    @include('partials.seat-meter', ['enrolled' => $course->enrollments_count, 'quota' => $course->quota])

                    <div class="kk-course-foot">
                        <strong>Rp {{ number_format($course->fee, 0, ',', '.') }}</strong>
                        <a class="btn btn-accent btn-sm" href="{{ route('enrollments.create', ['course' => $course->id]) }}">Daftar</a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="kk-empty">
                    <strong>Belum ada kursus berstatus open.</strong>
                    <p>Ubah status kursus menjadi open agar muncul di sini dan bisa didaftar.</p>
                    <a class="btn btn-accent btn-sm" href="{{ route('courses.index') }}">Buka daftar kursus</a>
                </div>
            </div>
        @endforelse
    </div>
</section>
@endsection
