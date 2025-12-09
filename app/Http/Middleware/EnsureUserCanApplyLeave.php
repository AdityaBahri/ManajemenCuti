<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserCanApplyLeave
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

        // Pastikan user sedang login sebelum mengecek role
        if (!$user) {
            return redirect()->route('login');
        }

        // BLOKIR: Admin dan HRD
        // Mereka adalah pengelola, tidak mengajukan cuti lewat sistem ini
        if ($user->isAdmin() || $user->isHrd()) {
            // Redirect ke dashboard dengan pesan error
            return redirect()->route('dashboard')
                ->with('error', 'Akun Admin/HRD tidak dapat mengajukan cuti.');
        }

        // IZINKAN: Karyawan dan Ketua Divisi
        return $next($request);
    }
}