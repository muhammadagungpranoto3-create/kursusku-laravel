@extends('layouts.app')

@section('title', 'Tambah Kursus')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h1 class="h3 mb-3 fw-bold">Tambah Kursus</h1>

        {{-- novalidate: validasi browser dimatikan agar validasi server (Form Request) bisa diuji --}}
        <form method="POST" action="{{ route('courses.store') }}" class="form-glass p-4 p-md-5" novalidate>
            @csrf

            <div class="mb-3">
                <label class="form-label" for="code">Kode Kursus</label>
                <input id="code" name="code" maxlength="20" placeholder="Contoh: WEB-101"
                       value="{{ old('code') }}"
                       class="form-control @error('code') is-invalid @enderror">
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="name">Nama Kursus</label>
                <input id="name" name="name" maxlength="120"
                       value="{{ old('name') }}"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Deskripsi</label>
                <textarea id="description" name="description" rows="3"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="fee">Biaya</label>
                    <input id="fee" type="number" name="fee" min="0"
                           value="{{ old('fee', 0) }}"
                           class="form-control @error('fee') is-invalid @enderror">
                    @error('fee')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="quota">Kuota</label>
                    <input id="quota" type="number" name="quota" min="1" max="500"
                           value="{{ old('quota', 20) }}"
                           class="form-control @error('quota') is-invalid @enderror">
                    @error('quota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="start_date">Tanggal Mulai</label>
                    <input id="start_date" type="date" name="start_date"
                           value="{{ old('start_date') }}"
                           class="form-control @error('start_date') is-invalid @enderror">
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="status">Status</label>
                    <select id="status" name="status"
                            class="form-select @error('status') is-invalid @enderror">
                        @foreach (['draft' => 'Draft', 'open' => 'Open', 'closed' => 'Closed'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', 'draft') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-2">
                <button class="btn btn-accent" type="submit">Simpan Kursus</button>
                <a class="btn btn-outline-secondary" href="{{ route('courses.index') }}">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
