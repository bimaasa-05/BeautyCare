<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Membership;
use Illuminate\Http\Request;

class KasirPelangganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->keyword;


        $TotalPelanggan = Pelanggan::count();
        $pelanggan = Pelanggan::when($search, function ($query, $search) {
            return $query->where('nm_pelanggan', 'like', "%{$search}%")->orwhere('no_hp', 'like', "%{$search}%")->orwhere('email', 'like', "%{$search}%");
        })->orderBy('id_pelanggan', 'desc')->paginate(10);
        return view('kasir.pelanggan.index', compact('pelanggan', 'TotalPelanggan'));
    }

    public function create()
    {
        $memberships = Membership::where('status', 'aktif')->get();
        return view('kasir.pelanggan.create', compact('memberships'));
    }

    public function store(Request $request)
    {
        //
        $request->validate([
            'nm_pelanggan' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggan,email',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required',
            'id_member' => 'nullable|string',
            'catatan_alergi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = [
            'nm_pelanggan' => $request->nm_pelanggan,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'id_member' => $request->id_member,
            'catatan_alergi' => $request->catatan_alergi,
        ];
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads/pelanggan', 'public');
        }
        Pelanggan::create($data);

        buatNotif(auth()->id(), 'Pelanggan Ditambahkan', 'Pelanggan ' . $request->nm_pelanggan . ' berhasil ditambahkan', 'Lainnya', route('kasir.pelanggan.index'));

        return redirect('kasir/pelanggan')->with('message', 'Data BERhasil di buat');
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::with('membership')->findOrFail($id);
        return view('kasir.pelanggan.show', compact('pelanggan'));
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $memberships = Membership::where('status', 'aktif')->get();
        return view('kasir.pelanggan.edit', compact('pelanggan', 'memberships'));
    }

    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'nm_pelanggan' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggan,email,' . $id . ',id_pelanggan',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required',
            'id_member' => 'nullable|string',
            'catatan_alergi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nm_pelanggan' => $request->nm_pelanggan,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'id_member' => $request->id_member,
            'catatan_alergi' => $request->catatan_alergi,
        ];
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads/pelanggan', 'public');
        }
        Pelanggan::where('id_pelanggan', $id)->update($data);
        buatNotif(auth()->id(), 'Pelanggan Diperbarui', 'Data pelanggan berhasil diperbarui', 'Lainnya', route('kasir.pelanggan.index'));

        return redirect('kasir/pelanggan')->with('message', 'data berhasil di Diupdate');
    }

    public function destroy($id)
    {
        //
        $pelanggan = Pelanggan::findOrFail($id);
        $nm = $pelanggan->nm_pelanggan;
        $pelanggan->delete();

        buatNotif(auth()->id(), 'Pelanggan Dihapus', 'Pelanggan ' . $nm . ' berhasil dihapus', 'Lainnya', route('kasir.pelanggan.index'));

        return redirect('/kasir/pelanggan')->with('message', 'data berhasil di hapus');
    }
}
