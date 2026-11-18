<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Alamat lama pertemuan 9 tetap bisa dibuka.
Route::redirect('/pendaftaran', '/enrollments/create');

Route::get('/courses/{course}/availability', [EnrollmentController::class, 'availability'])
    ->name('courses.availability');

Route::resource('courses', CourseController::class);

Route::resource('enrollments', EnrollmentController::class)
    ->only(['index', 'create', 'store']);
