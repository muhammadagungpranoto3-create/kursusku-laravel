<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /** Form "Lupa password": pengguna mengisi email. */
    public function request()
    {
        return view('auth.forgot-password');
    }

    /** Buat token reset lalu kirim tautan ke email. */
    public function email(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        // Mode lokal (praktikum/demo): MAIL_MAILER=log sehingga email tidak benar-benar terkirim.
        // Agar alur tetap bisa didemokan, tautan reset ditampilkan langsung di halaman.
        if (app()->environment('local')) {
            $user = User::where('email', $request->input('email'))->first();

            if (! $user) {
                return back()->withInput()->withErrors(['email' => 'Email tidak terdaftar.']);
            }

            $token = Password::broker()->createToken($user);

            return back()
                ->with('status', 'Mode lokal: email tidak dikirim, gunakan tautan reset di bawah ini.')
                ->with('reset_link', route('password.reset', ['token' => $token, 'email' => $user->email]));
        }

        // Produksi: kirim email berisi tautan reset. Respons dibuat sama agar email tidak bisa ditebak.
        Password::sendResetLink($request->only('email'));

        return back()->with('status', 'Jika email terdaftar, tautan reset password sudah dikirim.');
    }

    /** Form password baru (dibuka dari tautan reset). */
    public function edit(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /** Simpan password baru (di-hash lewat cast 'hashed'). */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60), // akhiri sesi "ingat saya" lama
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PasswordReset) {
            return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan masuk.');
        }

        $message = match ($status) {
            Password::InvalidToken => 'Tautan reset tidak valid atau sudah kedaluwarsa. Minta tautan baru.',
            Password::InvalidUser => 'Email tidak terdaftar.',
            Password::ResetThrottled => 'Terlalu sering mencoba. Tunggu sebentar lalu coba lagi.',
            default => 'Password gagal diubah.',
        };

        return back()->withInput($request->only('email'))->withErrors(['email' => $message]);
    }
}
