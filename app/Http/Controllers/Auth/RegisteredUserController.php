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
            'password' => ['required', 'string', 'min:6', 'confirmed'],

        ]);

        $user = User::create([
            'nama' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan',
            'status' => 'menunggu_persetujuan',
        ]);

        VerificationController::kirimOtp($user->email);

        $existingPelanggan = Pelanggan::where('email', $request->email)->whereNull('id_user')->first();
        if ($existingPelanggan) {
            $existingPelanggan->update(['id_user' => $user->id]);
        } else {
            Pelanggan::create([
                'nm_pelanggan' => $request->name,
                'email' => $request->email,
                'no_hp' => $request->no_hp ?? '',
                'alamat' => '',
                'catatan_alergi' => '',
                'id_user' => $user->id,
            ]);
        }

        buatNotifRole('admin', 'Pelanggan Baru Mendaftar', $request->name.' ('.$request->email.') baru saja mendaftar dan menunggu persetujuan admin.', 'Registrasi', route('admin.pelanggan.index'));

        event(new Registered($user));

        session(['otp_email' => $user->email]);

        return \redirect()->route('verification.otp.show', ['email' => $user->email])
            ->with('status', 'Akun Anda telah dibuat. Silakan verifikasi email Anda terlebih dahulu.');
    }
}