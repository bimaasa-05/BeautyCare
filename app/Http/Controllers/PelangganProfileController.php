<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganProfileController extends Controller
{
    public function index()
    {
        return view('pelanggan.profile.index', [
            'pelanggan' => Pelanggan::dariUser(auth()->user()),
        ]);
    }

    public function updateAlamat(Request $req)
    {
        $req->validate([
            'alamat' => 'nullable|string|max:255',
            'catatan_alergi' => 'nullable|string|max:500',
        ]);

        $pelanggan = Pelanggan::dariUser(auth()->user());
        if (!$pelanggan) {
            return back()->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $data = [];
        if ($req->has('alamat')) {
            $data['alamat'] = $req->alamat;
            auth()->user()->update(['alamat' => $req->alamat]);
        }
        if ($req->has('catatan_alergi')) {
            $data['catatan_alergi'] = $req->catatan_alergi;
        }
        $pelanggan->update($data);

        buatNotif(auth()->id(), 'Profil Diperbarui', 'Alamat dan catatan alergi berhasil diperbarui.', 'Lainnya', route('pelanggan.profile'));
        return back()->with('success', 'Alamat dan catatan alergi berhasil diperbarui!');
    }

    public function updateFoto(Request $req)
    {
        $req->validate(['foto' => 'required|image|mimes:jpeg,png,jpg|max:2048']);

        $user = auth()->user();
        $path = $req->file('foto')->store('profile-pelanggan', 'public');
        $user->update(['foto' => $path]);

        $pelanggan = Pelanggan::dariUser($user);
        if ($pelanggan) {
            $pelanggan->update(['foto' => $path]);
        }

        buatNotif($user->id, 'Foto Profil Diperbarui', 'Foto profil Anda berhasil diperbarui.', 'Lainnya', route('pelanggan.profile'));
        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function update(Request $req)
    {
        $req->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'no_hp' => 'required|string|max:20',
        ]);

        $user = auth()->user();
        $emailLama = $user->email;
        $namaLama = $user->nama;
        $user->update($req->only(['nama', 'email', 'no_hp']));

        $pelanggan = Pelanggan::where('id_user', $user->id)
            ->orWhere('email', $emailLama)
            ->orWhere('nm_pelanggan', $namaLama)
            ->first();
        if ($pelanggan) {
            $pelanggan->update([
                'nm_pelanggan' => $req->nama,
                'email' => $req->email,
                'no_hp' => $req->no_hp,
                'id_user' => $pelanggan->id_user ?: $user->id,
            ]);
        }

        buatNotif(auth()->id(), 'Profil Diperbarui', 'Data profil Anda berhasil diperbarui.', 'Lainnya', route('pelanggan.profile'));
        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $req)
    {
        $req->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        auth()->user()->update(['password' => bcrypt($req->new_password)]);

        buatNotif(auth()->id(), 'Password Diperbarui', 'Password akun Anda berhasil diperbarui.', 'Lainnya', route('pelanggan.profile'));
        return back()->with('success', 'Password berhasil diperbarui!');
    }
}
