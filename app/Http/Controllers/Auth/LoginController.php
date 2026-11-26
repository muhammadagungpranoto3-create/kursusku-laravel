<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Username atau email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Batasi percobaan login: maksimal 5 kali per menit per akun + IP.
        $throttleKey = Str::lower($data['login']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'login' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        // Pengguna boleh masuk dengan username ATAU email.
        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Auth::attempt membandingkan password dengan HASH di database (Hash::check).
        // Argumen kedua = fitur "ingat saya" (remember_token + cookie).
        if (! Auth::attempt([$field => $data['login'], 'password' => $data['password']], $request->boolean('remember'))) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'login' => 'Username/email atau password salah.',
            ]);
        }

        $user = Auth::user();

        // Cek status aktif
        if (! $user->isActive()) {
            Auth::logout();
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'login' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.',
            ]);
        }

        // Catat waktu login terakhir
        $user->forceFill(['last_login_at' => now()])->save();

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate(); // cegah session fixation

        $destination = $user->isAdmin()
            ? route('admin.dashboard')
            : route('dashboard');

        return redirect()->intended($destination)
            ->with('success', 'Selamat datang, '.$user->name.'.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda berhasil keluar.');
    }
}
