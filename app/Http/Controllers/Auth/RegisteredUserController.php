<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('login.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed',],

        ]);

        $user = User::create([
            'nama' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'status' => 'menunggu_persetujuan',
        ]);

        $existingPelanggan = Pelanggan::where('email', $request->email)->whereNull('id_user')->first();
        if ($existingPelanggan) {
            $existingPelanggan->update(['id_user' => $user->id]);
        } else {
            Pelanggan::create([
                'nm_pelanggan'   => $request->name,
                'email'          => $request->email,
                'no_hp'          => $request->no_hp,
                'alamat'         => '',
                'catatan_alergi' => '',
                'id_user'        => $user->id,
            ]);
        }

        event(new Registered($user));
        return  \redirect()->route('login')->with('status', "Register Telah berhasil silahkan login");
    }
}
