<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Periksa role user sebelum masuk route.
     * Sesuai SRS: Admin hanya bisa akses /admin/*, Mahasiswa hanya /mahasiswa/*
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            // Redirect ke dashboard sesuai role masing-masing
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Akses tidak diizinkan.');
            }

            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}