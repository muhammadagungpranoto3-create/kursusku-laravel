@extends('layouts.app')

@section('title', 'Laporan Enrollment - KursusKu')

@section('content')
<div class="kk-page-head">
    <div>
        <h1>Laporan Enrollment KursusKu</h1>
        <p>Nama peserta dan data kursus dibaca lewat relasi, bukan disalin ke tabel enrollments.</p>
    </div>
    <a href="{{ route('enrollments.create') }}" class="btn btn-accent">+ Tambah Enrollment</a>
</div>

<div class="kk-stats">
    <div><span>{{ $stats['enrollments'] }}</span><small>Total pendaftaran</small></div>
    <div><span>{{ $stats['participants'] }}</span><small>Peserta terdata</small></div>
    <div><span>{{ $stats['courses'] }}</span><small>Kursus punya peserta</small></div>
</div>

<div class="kk-panel p-0">
    <form method="GET" action="{{ route('enrollments.index') }}" class="kk-filter">
        <label for="filter-course" class="form-label mb-0">Tampilkan kursus</label>
        <select id="filter-course" name="course" class="form-select">
            <option value="">Semua kursus</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" @selected($courseId == $course->id)>{{ $course->code }} - {{ $course->name }}</option>
            @endforeach
        </select>
        <button class="btn btn-soft" type="submit">Terapkan</button>
        @if ($courseId)
            <a class="btn btn-ghost" href="{{ route('enrollments.index') }}">Reset</a>
        @endif
    </form>

    <div class="table-responsive">
        <table class="table kk-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Participant</th>
                    <th>Course</th>
                    <th>Start Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($enrollments as $enrollment)
                    <tr>
                        <td>
                            <div class="kk-person">
                                <span class="kk-avatar">{{ mb_strtoupper(mb_substr($enrollment->participant->name, 0, 1)) }}</span>
                                <div>
                                    <strong>{{ $enrollment->participant->name }}</strong>
                                    <small>{{ $enrollment->participant->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a class="kk-link" href="{{ route('courses.show', $enrollment->course) }}">{{ $enrollment->course->name }}</a>
                            <small class="d-block text-secondary">{{ $enrollment->course->code }}</small>
                        </td>
                        <td>{{ $enrollment->course->start_date->locale('id')->translatedFormat('d M Y') }}</td>
                        <td>
                            <span class="kk-status {{ $enrollment->status }}">{{ $enrollment->status === 'registered' ? 'Terdaftar' : ucfirst($enrollment->status) }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="kk-empty border-0 my-3">
                                <strong>Belum ada enrollment.</strong>
                                <p>Daftarkan peserta ke sebuah kursus, hasilnya langsung tampil di laporan ini.</p>
                                <a class="btn btn-accent btn-sm" href="{{ route('enrollments.create') }}">Tambah Enrollment</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
