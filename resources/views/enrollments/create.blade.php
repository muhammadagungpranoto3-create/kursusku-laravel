@extends('layouts.app')

@section('title', 'Pendaftaran - KursusKu')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <h1 class="h3 mb-3 fw-bold">Pendaftaran</h1>
        <p class="text-secondary">Pilih kursus untuk melihat kuota dari database. Data peserta belum disimpan.</p>

        <form method="POST" action="{{ route('enrollments.preview') }}" class="form-glass p-4">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="name">Nama</label>
                <input class="form-control" id="name" name="name" value="{{ old('name') }}" required minlength="3" maxlength="100">
                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="course_id">Kursus</label>
                <select class="form-select" id="course_id" name="course_id" required>
                    <option value="">Pilih kursus</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>
                            {{ $course->code }} — {{ $course->name }}
                        </option>
                    @endforeach
                </select>
                @error('course_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div id="availability" class="alert alert-secondary">
                Pilih kursus untuk melihat kuota dan status.
            </div>

            <button class="btn btn-accent" type="submit">Periksa formulir</button>
        </form>
    </div>
</div>
@endsection
