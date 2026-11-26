<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isAdmin()) {
            abort(403, 'Akses ditolak. Hanya administrator yang dapat membuka halaman ini.');
        }

        if (! $user->isActive()) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['login' => 'Akun Anda telah dinonaktifkan.']);
        }

        return $next($request);
    }
}
