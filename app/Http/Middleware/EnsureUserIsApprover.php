<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsApprover
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Pastikan user terautentikasi
        if (!$user) {
            return redirect()->route('login');
        }

        // IZINKAN: Admin, HRD, dan Ketua Divisi
        if ($user->isHrd() || $user->isDivisionHead()) {
            return $next($request);
        }

        // BLOKIR: Karyawan Biasa
        abort(403, 'Anda tidak memiliki akses untuk memverifikasi cuti.');
    }
}