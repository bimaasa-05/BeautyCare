<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        if ($user->status === 'suspend' && $user->suspend_until && now()->greaterThanOrEqualTo($user->suspend_until)) {
            $user->update(['status' => 'aktif', 'suspend_until' => null]);
        }

        if ($user->status !== 'aktif') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda belum diaktifkan oleh admin. Silakan hubungi admin.',
            ]);
        }

        return $next($request);
    }
}
