<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPelangganController extends Controller
{
    public function index(Request $request)
    {
        $pelanggan = Pelanggan::orderBy('id_pelanggan', $request->filter_sort === 'asc' ? 'asc' : 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $pelanggan->where(function ($q) use ($search) {
                $q->where('nm_pelanggan', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('filter_member')) {
            if ($request->filter_member === 'yes') {
                $pelanggan->whereNotNull('id_member');
            } elseif ($request->filter_member === 'no') {
                $pelanggan->whereNull('id_member');
            }
        }

        $pelanggan = $pelanggan->get();

        if ($request->ajax()) {
            return view('admin.pelanggan.partials.table', compact('pelanggan'));
        }

        return view('admin.pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_pelanggan'  => 'required|string|max:100',
            'no_hp'         => 'nullable|string|max:20',
            'email'         => 'required|email|max:100',
            'alamat'        => 'required|string',
            'id_member'     => 'nullable|integer',
            'catatan_alergi'=> 'required|string',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nm_pelanggan', 'no_hp', 'email', 'alamat', 'id_member', 'catatan_alergi']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pelanggan', 'public');
        }

        Pelanggan::create($data);

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nm_pelanggan'  => 'required|string|max:100',
            'no_hp'         => 'nullable|string|max:20',
            'email'         => 'required|email|max:100',
            'alamat'        => 'required|string',
            'id_member'     => 'nullable|integer',
            'catatan_alergi'=> 'required|string',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nm_pelanggan', 'no_hp', 'email', 'alamat', 'id_member', 'catatan_alergi']);

        if ($request->hasFile('foto')) {
            if ($pelanggan->foto) {
                Storage::disk('public')->delete($pelanggan->foto);
            }
            $data['foto'] = $request->file('foto')->store('pelanggan', 'public');
        }

        $pelanggan->update($data);

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        if ($pelanggan->foto) {
            Storage::disk('public')->delete($pelanggan->foto);
        }

        $pelanggan->delete();

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
