<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Pertemuan 13 - search (q), filter status, pagination 10 item.
     * Satu query dipakai untuk halaman penuh dan partial Ajax (?partial=1).
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));
        $status = trim((string) $request->query('status'));
        $allowedStatuses = ['open', 'closed', 'draft'];

        $courses = Course::query()
            ->withCount('enrollments')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->when(
                in_array($status, $allowedStatuses, true),
                fn ($query) => $query->where('status', $status)
            )
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString()
            // Link pagination tidak boleh membawa partial=1 (itu hanya untuk Ajax).
            ->appends(['partial' => null]);

        if ($request->boolean('partial')) {
            return view('courses._results', compact('courses'));
        }

        // Dashboard count (tambahan proyek) - tidak terpengaruh search/filter.
        $stats = [
            'total' => Course::count(),
            'open' => Course::where('status', 'open')->count(),
            'participants' => Participant::count(),
            'enrollments' => Enrollment::count(),
        ];

        return view('courses.index', compact('courses', 'search', 'status', 'stats'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(StoreCourseRequest $request)
    {
        Course::create($request->validated());

        return to_route('courses.index')
            ->with('success', 'Kursus berhasil ditambahkan.');
    }

    public function show(Course $course)
    {
        $course->load(['enrollments' => fn ($query) => $query->latest()->latest('id')->with('participant')]);

        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        return to_route('courses.show', $course)
            ->with('success', 'Kursus berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return to_route('courses.index')
            ->with('success', 'Kursus berhasil dihapus.');
    }
}
