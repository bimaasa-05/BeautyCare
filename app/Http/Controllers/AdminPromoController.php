<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class AdminPromoController extends Controller
{
    public function index()
    {
        $promos = Promo::orderBy('id_promo', 'desc')->get();

        return view('admin.promo.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_promo'    => 'required|string|max:100',
            'jenis_promo' => 'required|in:Diskon,Cashback,Paket,Buy 1 Get 1,Lainnya',
            'nilai'       => 'required|numeric|min:0',
            'mulai'       => 'required|date',
            'selesai'     => 'required|date|after_or_equal:mulai',
            'status'      => 'required|in:Tersedia,Belum_tersedia,Berakhir',
        ]);

        Promo::create($request->only(['nm_promo', 'jenis_promo', 'nilai', 'mulai', 'selesai', 'status']));

        return redirect()->route('admin.promo.index')
            ->with('success', 'Promo berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return view('admin.promo.edit', compact('promo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nm_promo'    => 'required|string|max:100',
            'jenis_promo' => 'required|in:Diskon,Cashback,Paket,Buy 1 Get 1,Lainnya',
            'nilai'       => 'required|numeric|min:0',
            'mulai'       => 'required|date',
            'selesai'     => 'required|date|after_or_equal:mulai',
            'status'      => 'required|in:Tersedia,Belum_tersedia,Berakhir',
        ]);

        $promo = Promo::findOrFail($id);
        $promo->update($request->only(['nm_promo', 'jenis_promo', 'nilai', 'mulai', 'selesai', 'status']));

        return redirect()->route('admin.promo.index')
            ->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return redirect()->route('admin.promo.index')
            ->with('success', 'Promo berhasil dihapus.');
    }
}
