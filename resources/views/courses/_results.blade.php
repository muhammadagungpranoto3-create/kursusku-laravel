{{-- Bagian hasil: dipakai halaman penuh (@include) dan respons Ajax (?partial=1). --}}
<div id="course-results">
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
                            <td colspan="7" class="text-center text-muted py-4">
                                Tidak ada kursus yang sesuai pencarian/filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="kk-result-foot">
            <p class="kk-result-meta mb-0">
                @if ($courses->total() > 0)
                    Menampilkan <strong>{{ $courses->firstItem() }}</strong> sampai <strong>{{ $courses->lastItem() }}</strong> dari <strong>{{ $courses->total() }}</strong> kursus
                @else
                    0 kursus ditemukan
                @endif
            </p>
            {{ $courses->links() }}
        </div>
    </div>
</div>
