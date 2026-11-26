<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Alamat lama pertemuan 9 tetap bisa dibuka.
Route::redirect('/pendaftaran', '/enrollments/create');

Route::get('/courses/{course}/availability', [EnrollmentController::class, 'availability'])
    ->name('courses.availability');

Route::resource('courses', CourseController::class);

Route::resource('enrollments', EnrollmentController::class)
    ->only(['index', 'create', 'store']);

/*
|--------------------------------------------------------------------------
| UAS Project Akhir - Autentikasi
|--------------------------------------------------------------------------
| Halaman kursus, laporan, dan pendaftaran tetap terbuka untuk semua orang
| (semua fitur navigasi tetap bisa diakses). Hanya halaman profil yang
| mewajibkan login.
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'email'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
