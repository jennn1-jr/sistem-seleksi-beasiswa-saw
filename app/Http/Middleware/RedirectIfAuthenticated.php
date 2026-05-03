<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Redirect user yang sudah login ke dashboard sesuai role-nya.
     * Mencegah akses ke halaman login/guest jika sudah terautentikasi.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Redirect sesuai role (SRS: FR-01)
                if ($user->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->route('mahasiswa.dashboard');
            }
        }

        return $next($request);
    }
}
