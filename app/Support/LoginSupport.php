<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginSupport
{
    public static function reactivateIfUnblocked(User $user): void
    {
        if ($user->status === 'suspend' && $user->suspend_until && now()->greaterThanOrEqualTo($user->suspend_until)) {
            $user->update(['status' => 'aktif', 'suspend_until' => null]);
        }
    }

    public static function statusError(User $user): string
    {
        if ($user->status === 'suspend') {
            $until = $user->suspend_until ? $user->suspend_until->locale('id')->isoFormat('D MMMM YYYY, HH:mm') . ' WIB' : 'tidak ditentukan';

            return "Akun Anda dengan Nama \"{$user->nama}\" dan Email \"{$user->email}\" sedang disuspend sampai {$until}. Silakan hubungi admin.";
        }

        if ($user->status === 'menunggu_persetujuan') {
            return 'Akun Anda sedang menunggu persetujuan admin. Silakan hubungi admin.';
        }

        return 'Akun Anda belum diaktifkan oleh admin. Silakan hubungi admin.';
    }

    public static function rejectNonActive(User $user, Request $request): ?RedirectResponse
    {
        self::reactivateIfUnblocked($user);

        if ($user->status !== 'aktif') {
            self::logoutAndFlush($request);

            return back()->withErrors([
                'email' => self::statusError($user),
            ]);
        }

        return null;
    }

    public static function logoutAndFlush(Request $request): void
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public static function afterLogin(User $user, Request $request): RedirectResponse
    {
        $request->session()->regenerate();

        DB::table('log_kunjungan')->insert([
            'id_user' => $user->id,
            'tanggal' => now()->toDateString(),
        ]);

        $base = $request->root();

        $intended = $request->session()->get('url.intended');
        if ($intended && str_contains($intended, '/notif/')) {
            $request->session()->forget('url.intended');
        }

        if ($user->role === 'admin') {
            return \redirect()->intended($base . \route('admin.dashboard', [], false));
        } elseif ($user->role === 'kasir') {
            return \redirect()->intended($base . \route('kasir.dashboard', [], false));
        } elseif ($user->role === 'beautycian') {
            return \redirect()->intended($base . \route('beautycian.dashboard', [], false));
        }

        return \redirect()->intended($base . \route('dashboard', [], false));
    }
}