<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\User;
use App\Support\LoginSupport;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $pengaturan = \App\Models\Pengaturan::first();

        return view('login.register', compact('pengaturan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::create([
            'nama' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'status' => 'menunggu_verifikasi',
        ]);

        \App\Http\Controllers\Auth\VerificationController::kirimOtp($user->email);

        event(new Registered($user));

        return redirect()->route('verification.otp.show')->with('otp_email', $user->email);
    }
}