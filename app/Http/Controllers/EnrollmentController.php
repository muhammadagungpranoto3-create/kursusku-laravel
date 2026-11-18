<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnrollmentController extends Controller
{
    /**
     * Langkah 9 - laporan relasional (eager loading: tanpa query berulang).
     */
    public function index(Request $request)
    {
        $courseId = $request->integer('course') ?: null;

        $enrollments = Enrollment::with(['participant', 'course'])
            ->when($courseId, fn ($query) => $query->where('course_id', $courseId))
            ->latest()
            ->latest('id')
            ->get();

        $courses = Course::orderBy('name')->get(['id', 'code', 'name']);

        $stats = [
            'enrollments' => Enrollment::count(),
            'participants' => Participant::count(),
            'courses' => Enrollment::distinct()->count('course_id'),
        ];

        return view('enrollments.index', compact('enrollments', 'courses', 'courseId', 'stats'));
    }

    /**
     * Langkah 6 - form dengan dua dropdown relasional.
     * Di project ini status kursus yang bisa didaftar adalah "open"
     * (panduan menulis "active", tetapi enum courses = draft/open/closed).
     */
    public function create(Request $request)
    {
        $participants = Participant::orderBy('name')->get();

        $courses = Course::where('status', 'open')
            ->withCount('enrollments')
            ->orderBy('name')
            ->get();

        // ?course=ID dari tombol "Daftarkan" pada halaman kursus.
        $selectedCourse = old('course_id', $request->query('course'));

        return view('enrollments.create', compact('participants', 'courses', 'selectedCourse'));
    }

    /**
     * Langkah 6 + 8 - validasi, cegah pendaftaran ganda, simpan.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'participant_id' => ['required', 'exists:participants,id'],
                'course_id' => [
                    'required',
                    Rule::exists('courses', 'id')->where('status', 'open'),
                    Rule::unique('enrollments')->where(
                        fn ($query) => $query->where('participant_id', $request->participant_id)
                    ),
                ],
            ],
            [
                'participant_id.required' => 'Pilih participant terlebih dahulu.',
                'participant_id.exists' => 'Participant tidak ditemukan.',
                'course_id.required' => 'Pilih course terlebih dahulu.',
                'course_id.exists' => 'Course tidak ditemukan atau belum dibuka.',
                'course_id.unique' => 'Participant ini sudah terdaftar pada course tersebut.',
            ]
        );

        // Tambahan: tolak jika kuota sudah penuh.
        $course = Course::withCount('enrollments')->findOrFail($data['course_id']);

        if ($course->enrollments_count >= $course->quota) {
            return back()
                ->withInput()
                ->withErrors(['course_id' => 'Kuota course ini sudah penuh.']);
        }

        $data['status'] = 'registered';

        Enrollment::create($data);

        return redirect()->route('enrollments.index')
            ->with('success', 'Enrollment berhasil disimpan.');
    }

    /**
     * Dipakai Ajax pada form (kartu tiket): kuota, sisa kursi, biaya, jadwal.
     */
    public function availability(Course $course)
    {
        $enrolled = $course->enrollments()->count();

        return response()->json([
            'id' => $course->id,
            'code' => $course->code,
            'name' => $course->name,
            'description' => $course->description,
            'quota' => $course->quota,
            'enrolled' => $enrolled,
            'remaining' => max(0, $course->quota - $enrolled),
            'fee' => $course->fee,
            'start_label' => $course->start_date->locale('id')->translatedFormat('d F Y'),
            'status' => $course->status,
        ]);
    }
}
