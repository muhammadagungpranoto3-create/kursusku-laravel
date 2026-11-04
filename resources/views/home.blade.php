@extends('layouts.app')

@section('title', 'Beranda - KursusKu')

@section('content')
<section class="py-4 py-lg-5">
    <div class="row align-items-center g-4">
        <div class="col-lg-8">
            <span class="badge text-bg-success mb-3">Milestone 10 · data dari database</span>
            <h1 class="display-5 fw-bold">Belajar lebih terarah bersama KursusKu</h1>
            <p class="lead text-secondary">
                Pilih kursus, cek ketersediaan, atau tambah data baru lewat form admin.
            </p>
            <a href="{{ route('courses.index') }}" class="btn btn-accent me-2">Daftar Kursus</a>
            <a href="{{ route('enrollments.create') }}" class="btn btn-outline-dark">Pendaftaran</a>
        </div>
    </div>
</section>

<section class="pb-5">
    <h2 class="h4 fw-bold mb-3">Program yang dibuka</h2>
    <div class="row g-3">
        @forelse ($featured as $course)
            <div class="col-md-6 col-lg-4">
                <article class="card h-100 shadow-sm">
                    <div class="card-body">
                        <span class="badge text-bg-light border mb-2">{{ $course->code }}</span>
                        <h3 class="h5">{{ $course->name }}</h3>
                        <p class="text-secondary mb-0">{{ $course->description }}</p>
                    </div>
                </article>
            </div>
        @empty
            <p class="text-secondary">Belum ada kursus berstatus open.</p>
        @endforelse
    </div>
</section>
@endsection
