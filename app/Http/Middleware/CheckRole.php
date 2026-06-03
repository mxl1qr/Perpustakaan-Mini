<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Memastikan pengguna memiliki role yang sesuai dengan rute yang diakses.
     * Admin  → hanya boleh akses /dashboard dan rute-rute admin.
     * Anggota → hanya boleh akses /portal dan rute-rute anggota.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($user->role !== $role) {
            // Jika admin mencoba akses portal anggota → redirect ke dashboard admin
            if ($user->role === 'admin') {
                return redirect()->route('dashboard')
                    ->with('warning', 'Area ini khusus untuk anggota siswa.');
            }

            // Jika anggota mencoba akses area admin → redirect ke portal anggota
            if ($user->role === 'anggota') {
                return redirect()->route('anggota.portal')
                    ->with('warning', 'Anda tidak memiliki izin untuk mengakses area admin.');
            }

            // Fallback: paksa logout
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Akses ditolak. Silakan login kembali.');
        }

        return $next($request);
    }
}
