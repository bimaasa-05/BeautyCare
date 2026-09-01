<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Membership;
use App\Models\Transaksi;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;

class KasirPelangganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->keyword;
        $dari = $request->dari;
        $sampai = $request->sampai;

        $TotalPelanggan = Pelanggan::count();

        // Periode: default 30 hari terakhir kalau nggak diisi
        $startDate = $dari ?: date('Y-m-d', strtotime('-30 days'));
        $endDate = $sampai ?: date('Y-m-d');

        $PelangganBaru = Pelanggan::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count();

        $PelangganMember = Pelanggan::whereNotNull('id_member')->count();

        $TransaksiPelanggan = Transaksi::whereNotNull('id_pelanggan')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->count();

        $pelanggan = Pelanggan::when($search, function ($query, $search) {
            return $query->where('nm_pelanggan', 'like', "%{$search}%")->orwhere('no_hp', 'like', "%{$search}%")->orwhere('email', 'like', "%{$search}%");
        })->orderBy('id_pelanggan', 'desc')->paginate(10);
        return view('kasir.pelanggan.index', compact('pelanggan', 'TotalPelanggan', 'PelangganBaru', 'PelangganMember', 'TransaksiPelanggan', 'startDate', 'endDate', 'dari', 'sampai'));
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
            'catatan_alergi' => $request->catatan_alergi ?? '',
        ];
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads/pelanggan', 'public');
        }
        Pelanggan::create($data);

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' menambahkan pelanggan ' . $request->nm_pelanggan, 'Pelanggan');

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

        $pelanggan = Pelanggan::findOrFail($id);
        $dataLama = $pelanggan->toArray();

        $data = [
            'nm_pelanggan' => $request->nm_pelanggan,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'id_member' => $request->id_member,
            'catatan_alergi' => $request->catatan_alergi ?? '',
        ];
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads/pelanggan', 'public');
        }
        $pelanggan->update($data);
        if ($pelanggan->id_user) {
            $pelanggan->user()->update([
                'nama' => $request->nm_pelanggan,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        }
        ActivityLogger::log('Mengubah', auth()->user()->nama . ' mengubah data pelanggan ' . ($request->nm_pelanggan ?? ''), 'Pelanggan', $id, $dataLama, $data);
        buatNotif(auth()->id(), 'Pelanggan Diperbarui', 'Data pelanggan berhasil diperbarui', 'Lainnya', route('kasir.pelanggan.index'));

        return redirect('kasir/pelanggan')->with('message', 'data berhasil di Diupdate');
    }

    public function destroy($id)
    {
        //
        $pelanggan = Pelanggan::findOrFail($id);
        $nm = $pelanggan->nm_pelanggan;
        $pelanggan->delete();

        ActivityLogger::log('Menghapus', auth()->user()->nama . ' menghapus pelanggan ' . $nm, 'Pelanggan', $id);

        buatNotif(auth()->id(), 'Pelanggan Dihapus', 'Pelanggan ' . $nm . ' berhasil dihapus', 'Lainnya', route('kasir.pelanggan.index'));

        return redirect('/kasir/pelanggan')->with('message', 'data berhasil di hapus');
    }
}
