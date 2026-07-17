<?php

namespace App\Http\Controllers;

use App\Models\KategoriLayanan;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class AdminKategoriController extends Controller
{
    public function index()
    {
        $kategoriLayanan = KategoriLayanan::orderBy('id_kategori_layanan', 'desc')->get();
        $kategoriProduk = KategoriProduk::orderBy('id_kategori_produk', 'desc')->get();

        return view('admin.kategori.index', compact('kategoriLayanan', 'kategoriProduk'));
    }

    public function create(Request $request)
    {
        $type = $request->query('type', 'layanan');
        return view('admin.kategori.create', compact('type'));
    }

    public function store(Request $request)
    {
        $type = $request->input('type', 'layanan');

        if ($type === 'layanan') {
            $request->validate([
                'nm_layanan' => 'required|string|max:255|unique:kategori_layanan,nm_layanan',
                'status'     => 'required|in:tersedia,belum_tersedia',
            ]);

            KategoriLayanan::create($request->only(['nm_layanan', 'status']));

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Kategori layanan berhasil ditambahkan.');
        } else {
            $request->validate([
                'nm_produk' => 'required|string|max:100|unique:kategori_produk,nm_produk',
                'status'    => 'required|in:tersedia,tidak_tersedia',
            ]);

            KategoriProduk::create($request->only(['nm_produk', 'status']));

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Kategori produk berhasil ditambahkan.');
        }
    }

    public function edit(Request $request, $id)
    {
        $type = $request->query('type', 'layanan');

        if ($type === 'layanan') {
            $kategori = KategoriLayanan::findOrFail($id);
        } else {
            $kategori = KategoriProduk::findOrFail($id);
        }

        return view('admin.kategori.edit', compact('kategori', 'type'));
    }

    public function update(Request $request, $id)
    {
        $type = $request->input('type', 'layanan');

        if ($type === 'layanan') {
            $request->validate([
                'nm_layanan' => 'required|string|max:255|unique:kategori_layanan,nm_layanan,'.$id.',id_kategori_layanan',
                'status'     => 'required|in:tersedia,belum_tersedia',
            ]);

            $kategori = KategoriLayanan::findOrFail($id);
            $kategori->update($request->only(['nm_layanan', 'status']));

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Kategori layanan berhasil diperbarui.');
        } else {
            $request->validate([
                'nm_produk' => 'required|string|max:100|unique:kategori_produk,nm_produk,'.$id.',id_kategori_produk',
                'status'    => 'required|in:tersedia,tidak_tersedia',
            ]);

            $kategori = KategoriProduk::findOrFail($id);
            $kategori->update($request->only(['nm_produk', 'status']));

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Kategori produk berhasil diperbarui.');
        }
    }

    public function destroy(Request $request, $id)
    {
        $type = $request->query('type', 'layanan');

        if ($type === 'layanan') {
            $kategori = KategoriLayanan::findOrFail($id);
            $kategori->delete();

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Kategori layanan berhasil dihapus.');
        } else {
            $kategori = KategoriProduk::findOrFail($id);
            $kategori->delete();

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Kategori produk berhasil dihapus.');
        }
    }
}
