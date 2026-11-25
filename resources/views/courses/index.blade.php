@extends('layouts.app')

@section('title', 'Daftar Kursus')

@section('content')
<div class="kk-page-head">
    <div>
        <h1>Daftar Kursus</h1>
        <p>Cari berdasarkan kode atau nama, saring berdasarkan status. Hasil dibagi 10 data per halaman.</p>
    </div>
    <a href="{{ route('courses.create') }}" class="btn btn-accent">+ Tambah Kursus</a>
</div>

{{-- Dashboard count (tidak terpengaruh search/filter) --}}
<div class="kk-stats kk-stats-4">
    <div><span>{{ $stats['total'] }}</span><small>Total kursus</small></div>
    <div><span>{{ $stats['open'] }}</span><small>Kursus open</small></div>
    <div><span>{{ $stats['participants'] }}</span><small>Peserta</small></div>
    <div><span>{{ $stats['enrollments'] }}</span><small>Pendaftaran</small></div>
</div>

{{-- Form GET = fallback tanpa JavaScript. Tidak butuh @csrf (tidak mengubah data). --}}
<form id="course-filter" method="GET" action="{{ route('courses.index') }}" class="row g-2 mb-3">
    <div class="col-md-6">
        <label for="live-search" class="visually-hidden">Cari kursus</label>
        <input id="live-search" type="search" name="q" value="{{ $search }}"
               class="form-control" placeholder="Cari kode atau nama kursus" autocomplete="off">
    </div>
    <div class="col-md-3">
        <label for="status-filter" class="visually-hidden">Status</label>
        <select id="status-filter" name="status" class="form-select">
            <option value="">Semua status</option>
            <option value="open" @selected($status === 'open')>Open</option>
            <option value="closed" @selected($status === 'closed')>Closed</option>
            <option value="draft" @selected($status === 'draft')>Draft</option>
        </select>
    </div>
    <div class="col-md-3 d-flex gap-2">
        <button class="btn btn-accent" type="submit">Cari</button>
        <a href="{{ route('courses.index') }}" class="btn btn-ghost">Reset</a>
    </div>
</form>

<div id="course-error" class="kk-inline-error" role="alert" hidden>
    Gagal memuat hasil. Tekan Cari untuk memuat ulang halaman.
</div>

@include('courses._results')
@endsection
