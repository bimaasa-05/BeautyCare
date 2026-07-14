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
        $request->session()->regenerate();

        $base = $request->root();

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