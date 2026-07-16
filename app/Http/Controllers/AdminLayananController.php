<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::orderBy('id_layanan', 'desc')->get();
        return view('admin.layanan.index', compact('layanan'));
    }

    public function create()
    {
        return view('admin.layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'  => 'required|integer|max:100',
            'nm_layanan'         => 'required|string|max:20',
            'durasi'            => 'required|integer',
            'harga'             => 'required|numeric|min:0',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'            => 'required|in:aktif,suspend',
        ]);

        $data = $request->only(['nm_layanan', 'id_kategori', 'durasi', 'harga', 'status']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('layanan', 'public');
        }

        Layanan::create($data);

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nm_layanan'  => 'required|string|max:20',
            'id_kategori' => 'required|integer|max:100',
            'durasi'      => 'required|integer',
            'harga'       => 'required|numeric|min:0',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:aktif,suspend',
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
