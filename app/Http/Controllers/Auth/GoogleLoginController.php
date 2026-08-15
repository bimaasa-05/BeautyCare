<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\User;
use App\Support\LoginSupport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\UserDeniedAuthorizationRequestException;

class GoogleLoginController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'consent'])
            ->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        try {
            $g = Socialite::driver('google')->user();
        } catch (UserDeniedAuthorizationRequestException) {
            return \redirect()->route('login')->withErrors([
                'email' => 'Login Google dibatalkan. Silakan coba lagi untuk memilih akun.',
            ]);
        } catch (InvalidStateException) {
            return \redirect()->route('login')->withErrors([
                'email' => 'Sesi login tidak valid. Silakan coba lagi.',
            ]);
        } catch (\Throwable $e) {
            Log::error('Google login error: ' . $e->getMessage());

            return \redirect()->route('login')->withErrors([
                'email' => 'Login Google gagal. Silakan coba lagi atau gunakan form login.',
            ]);
        }

        if (! $g->getEmail()) {
            return \redirect()->route('login')->withErrors([
                'email' => 'Email tidak ditemukan pada akun Google Anda.',
            ]);
        }

        $googleNama = mb_substr(trim((string) $g->getName()) ?: 'Pengguna Google', 0, 50);

        $user = User::where('email', $g->getEmail())->first();

        if ($user) {
            $user->update([
                'provider' => 'google',
                'provider_id' => $g->getId(),
                'avatar' => $g->getAvatar(),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);

            Auth::login($user, true);

            $rejected = LoginSupport::rejectNonActive($user, $request);
            if ($rejected) {
                return $rejected;
            }

            return LoginSupport::afterLogin($user, $request);
        }

        $tempPassword = 'Beautycare123';

        $user = User::create([
            'nama' => $googleNama,
            'email' => $g->getEmail(),
            'no_hp' => null,
            'password' => Hash::make($tempPassword),
            'role' => 'pelanggan',
            'status' => 'menunggu_verifikasi',
            'provider' => 'google',
            'provider_id' => $g->getId(),
            'avatar' => $g->getAvatar(),
        ]);

        VerificationController::kirimOtp($user->email);

        return redirect()->route('verification.otp.show')->with('otp_email', $user->email);
    }
}