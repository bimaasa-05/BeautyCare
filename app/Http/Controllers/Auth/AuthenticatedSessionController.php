<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('login.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $user = Auth::user();

        if ($user->status === 'suspend' && $user->suspend_until && now()->greaterThanOrEqualTo($user->suspend_until)) {
            $user->update(['status' => 'aktif', 'suspend_until' => null]);
        }

        if ($user->status !== 'aktif') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $pesan = $user->status === 'menunggu_persetujuan'
                ? 'Akun Anda sedang menunggu persetujuan admin. Silakan hubungi admin.'
                : 'Akun Anda belum diaktifkan oleh admin. Silakan hubungi admin.';
            return back()->withErrors([
                'email' => $pesan,
            ]);
        }

        $request->session()->regenerate();

        \Illuminate\Support\Facades\DB::table('log_kunjungan')->insert([
            'id_user' => $user->id,
            'tanggal' => now()->toDateString(),
        ]);

        $base = $request->root();

        // Jangan ikuti intended URL yang menunjuk endpoint JSON notifikasi (mis. dari polling
        // background saat session habis) — login harus selalu mendarat ke dashboard role.
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

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}