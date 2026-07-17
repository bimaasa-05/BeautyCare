<?php

namespace App\Http\Controllers;

use App\Models\KategoriLayanan;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLayananController extends Controller
{
    public function index(Request $request)
    {
        $layanan = Layanan::orderBy('id_layanan', 'desc');
        $kategoriLayanan = KategoriLayanan::where('status', 'tersedia')->get();

        if ($request->filled('search')) {
            $search = $request->search;
            $layanan->where('nm_layanan', 'like', "%{$search}%");
        }

        if ($request->filled('filter_kategori')) {
            $layanan->where('id_kategori', $request->filter_kategori);
        }

        if ($request->filled('filter_status')) {
            $layanan->where('status', $request->filter_status);
        }

        $layanan = $layanan->get();

        if ($request->ajax()) {
            return view('admin.layanan.partials.grid', compact('layanan', 'kategoriLayanan'));
        }

        return view('admin.layanan.index', compact('layanan', 'kategoriLayanan'));
    }

    public function create()
    {
        $kategoriLayanan = KategoriLayanan::where('status', 'tersedia')->get();
        return view('admin.layanan.create', compact('kategoriLayanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'  => 'required|integer|max:100',
            'nm_layanan'         => 'required|string|max:20',
            'durasi'            => 'required|integer',
            'harga'             => 'required|numeric|min:0',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'            => 'required|in:Tersedia,Tidak Tersedia',
        ]);

        $data = $request->only(['nm_layanan', 'id_kategori', 'durasi', 'harga', 'status']);
        $data['foto'] = null;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('layanan', 'public');
        }

        Layanan::create($data);

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Layanan $layanan)
    {
        $kategoriLayanan = KategoriLayanan::where('status', 'tersedia')->get();
        return view('admin.layanan.edit', compact('layanan', 'kategoriLayanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nm_layanan'  => 'sometimes|required|string|max:20',
            'id_kategori' => 'sometimes|required|integer|max:100',
            'durasi'      => 'sometimes|required|integer',
            'harga'       => 'sometimes|required|numeric|min:0',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'sometimes|required|in:Tersedia,Tidak Tersedia',
        ]);

        $data = $request->only(['nm_layanan', 'id_kategori', 'durasi', 'harga', 'status']);

        if ($request->hasFile('foto')) {
            if ($layanan->foto) {
                Storage::disk('public')->delete($layanan->foto);
            }
            $data['foto'] = $request->file('foto')->store('layanan', 'public');
        }

        $layanan->update($data);

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        if ($layanan->foto) {
            Storage::disk('public')->delete($layanan->foto);
        }

        $layanan->delete();

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
