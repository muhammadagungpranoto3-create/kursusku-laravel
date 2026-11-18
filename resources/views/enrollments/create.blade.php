@extends('layouts.app')

@section('title', 'Tambah Enrollment - KursusKu')

@section('content')
<div class="kk-page-head">
    <div>
        <h1>Tambah Enrollment</h1>
        <p>Pilih peserta dan kursus. Kartu di samping menampilkan jadwal, biaya, dan sisa kursi dari database.</p>
    </div>
</div>

<div class="row g-4 align-items-start">
    <div class="col-lg-6">
        {{-- novalidate: validasi browser dimatikan agar validasi server bisa diuji (test matrix 2 dan 3) --}}
        <form method="POST" action="{{ route('enrollments.store') }}" class="kk-panel p-4" novalidate>
            @csrf

            <div class="mb-3">
                <label class="form-label" for="participant_id">Participant</label>
                <select name="participant_id" id="participant_id"
                        class="form-select @error('participant_id') is-invalid @enderror">
                    <option value="">-- Pilih Participant --</option>
                    @foreach ($participants as $participant)
                        <option value="{{ $participant->id }}"
                                data-name="{{ $participant->name }}"
                                @selected(old('participant_id') == $participant->id)>
                            {{ $participant->name }} - {{ $participant->email }}
                        </option>
                    @endforeach
                </select>
                @error('participant_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if ($participants->isEmpty())
                    <div class="form-text">Belum ada participant. Jalankan <code>php artisan db:seed --class=ParticipantSeeder</code>.</div>
                @endif
            </div>

            <div class="mb-4">
                <label class="form-label" for="course_id">Course</label>
                <select name="course_id" id="course_id"
                        class="form-select @error('course_id') is-invalid @enderror">
                    <option value="">-- Pilih Course --</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" @selected($selectedCourse == $course->id)>
                            {{ $course->code }} - {{ $course->name }} (sisa {{ max(0, $course->quota - $course->enrollments_count) }} kursi)
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if ($courses->isEmpty())
                    <div class="form-text">Belum ada kursus berstatus open.</div>
                @endif
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-accent">Simpan Enrollment</button>
                <a href="{{ route('enrollments.index') }}" class="btn btn-ghost">Batal</a>
            </div>
            <p class="form-text mt-3 mb-0">Status awal pendaftaran otomatis <strong>registered</strong>.</p>
        </form>
    </div>

    <div class="col-lg-6">
        <aside class="kk-ticket" id="ticket" aria-live="polite">
            <div class="kk-ticket-top">
                <span class="kk-ticket-code" id="ticket-code">Belum dipilih</span>
                <h2 id="ticket-name">Pilih kursus untuk melihat tiketnya</h2>
                <p id="ticket-desc">Jadwal mulai, biaya, dan sisa kursi akan tampil di sini.</p>
            </div>

            <div class="kk-ticket-tear" aria-hidden="true"></div>

            <div class="kk-ticket-body">
                <dl>
                    <div><dt>Peserta</dt><dd id="ticket-participant">-</dd></div>
                    <div><dt>Mulai</dt><dd id="ticket-date">-</dd></div>
                    <div><dt>Biaya</dt><dd id="ticket-fee">-</dd></div>
                    <div><dt>Status</dt><dd id="ticket-status">-</dd></div>
                </dl>

                <div class="kk-meter" id="ticket-meter">
                    <div class="kk-meter-bar"><span style="width: 0%"></span></div>
                    <small id="ticket-seats">Sisa kursi tampil setelah kursus dipilih.</small>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
