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
            if ($user->status === 'menunggu_persetujuan') {
                $pesan = 'Akun Anda sedang menunggu persetujuan admin. atau silahkan hubungi admin dengan klik icon WhatsApp yang ada di halaman ini';
            } elseif ($user->status === 'suspend') {
                $until = $user->suspend_until ? $user->suspend_until->locale('id')->isoFormat('D MMMM YYYY, HH:mm') . ' WIB' : 'tidak ditentukan';
                $pesan = "Akun Anda dengan Nama \"{$user->nama}\" dan Email \"{$user->email}\" sedang disuspend sampai {$until}. atau silahkan hubungi admin dengan klik icon WhatsApp yang ada di bawah ini";
            } else {
                $pesan = 'Akun Anda belum diaktifkan oleh admin. Silakan hubungi admin.';
            }
            return redirect()->route('login')->withErrors([
                'email' => $pesan,
            ]);
        }

        return $next($request);
    }
}
