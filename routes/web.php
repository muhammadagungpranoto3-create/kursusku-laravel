<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pendaftaran', function () {
    $courses = Course::orderBy('code')->get();

    return view('enrollments.create', compact('courses'));
})->name('enrollments.create');

Route::post('/pendaftaran/preview', function (Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'min:3', 'max:100'],
        'email' => ['required', 'email'],
        'course_id' => ['required', 'integer', 'exists:courses,id'],
    ]);

    return back()
        ->with('success', 'Form lolos validasi. Data peserta belum disimpan. Relasi pendaftaran dibahas pada pertemuan berikutnya.')
        ->withInput();
})->name('enrollments.preview');

Route::get('/courses/{course}/availability', function (Course $course) {
    return response()->json([
        'id' => $course->id,
        'code' => $course->code,
        'name' => $course->name,
        'quota' => $course->quota,
        'status' => $course->status,
    ]);
})->name('courses.availability');

Route::resource('courses', CourseController::class);
