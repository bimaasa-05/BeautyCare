<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Pelanggan;
use App\Models\User;
use App\Models\VerificationCode;
use App\Support\LoginSupport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class VerificationController extends Controller
{
    public static function kirimOtp(string $email, bool $force = false): string
    {
        if (! $force) {
            $existing = VerificationCode::where('email', $email)
                ->where('used', false)
                ->latest('id')
                ->first();

            if ($existing && $existing->isValid()) {
                return 'reuse';
            }
        }

        $code = (string) random_int(100000, 999999);

        VerificationCode::where('email', $email)->where('used', false)->delete();

        VerificationCode::create([
            'email' => $email,
            'code' => Hash::make($code),
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($email)->send(new OtpMail($code));

        return $code;
    }

    public function show(Request $request): View|RedirectResponse
    {
        $email = session('otp_email', $request->query('email'));

        if (! $email) {
            return redirect()->route('register')->with('status', 'Silakan daftar dulu untuk lanjut ke verifikasi.');
        }

        $user = User::where('email', $email)->first();
        if (! $user || $user->status !== 'menunggu_persetujuan') {
            return redirect()->route('login')->with('status', 'Akun tidak ditemukan atau sudah diproses.');
        }

        return view('login.otp-verification', compact('email'));
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:6'],
        ]);

        $record = VerificationCode::where('email', $request->email)
            ->where('used', false)
            ->latest('id')
            ->first();

        if (! $record || ! $record->isValid() || ! Hash::check($request->code, $record->code)) {
            return back()->withErrors(['code' => 'Kode OTP salah. Periksa kembali kode yang telah dikirim ke email Anda.']);
        }

        $record->update(['used' => true]);

        $user = User::where('email', $request->email)->first();

        if (! $user || $user->status !== 'menunggu_persetujuan') {
            return redirect()->route('login')->withErrors(['email' => 'Akun tidak ditemukan atau sudah diproses. Silakan masuk.']);
        }

        $user->update(['email_verified_at' => now()]);

        $existingPelanggan = Pelanggan::where('email', $user->email)->whereNull('id_user')->first();
        if ($existingPelanggan) {
            $existingPelanggan->update(['id_user' => $user->id]);
        } else {
            Pelanggan::create([
                'nm_pelanggan' => $user->nama,
                'email' => $user->email,
                'no_hp' => $user->no_hp ?? '',
                'alamat' => '',
                'catatan_alergi' => '',
                'id_user' => $user->id,
            ]);
        }

        buatNotifRole('admin', 'Pelanggan Terverifikasi', $user->nama . ' (' . $user->email . ') telah memverifikasi email dan menunggu persetujuan admin.', 'Registrasi', route('admin.pelanggan.index'));

        Auth::login($user);

        session()->forget(['otp_email']);

        return redirect()->route('login')->withErrors([
            'email' => 'Verifikasi email berhasil! Akun Anda sedang menunggu persetujuan admin. Silakan hubungi admin.',
        ]);
    }

    public function resend(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        if (! User::where('email', $request->email)->where('status', 'menunggu_persetujuan')->exists()) {
            return redirect()->route('verification.otp.show', ['email' => $request->email])
                ->withErrors(['email' => 'Akun tidak ditemukan atau sudah diverifikasi.']);
        }

        self::kirimOtp($request->email, true);

        return redirect()->route('verification.otp.show', ['email' => $request->email])
            ->with('status', 'Kode verifikasi baru telah dikirim ke email Anda.');
    }
}