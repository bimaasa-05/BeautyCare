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

            buatNotif(auth()->id(), 'Kategori Ditambahkan', 'Kategori layanan ' . $request->nm_layanan . ' berhasil ditambahkan', 'Lainnya', route('admin.kategori.index'));

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Kategori layanan berhasil ditambahkan.');
        } else {
            $request->validate([
                'nm_produk' => 'required|string|max:100|unique:kategori_produk,nm_produk',
                'status'    => 'required|in:tersedia,tidak_tersedia',
            ]);

            KategoriProduk::create($request->only(['nm_produk', 'status']));

            buatNotif(auth()->id(), 'Kategori Ditambahkan', 'Kategori produk ' . $request->nm_produk . ' berhasil ditambahkan', 'Lainnya', route('admin.kategori.index'));

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

            buatNotif(auth()->id(), 'Kategori Diperbarui', 'Kategori layanan ' . $request->nm_layanan . ' berhasil diperbarui', 'Lainnya', route('admin.kategori.index'));

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Kategori layanan berhasil diperbarui.');
        } else {
            $request->validate([
                'nm_produk' => 'required|string|max:100|unique:kategori_produk,nm_produk,'.$id.',id_kategori_produk',
                'status'    => 'required|in:tersedia,tidak_tersedia',
            ]);

            $kategori = KategoriProduk::findOrFail($id);
            $kategori->update($request->only(['nm_produk', 'status']));

            buatNotif(auth()->id(), 'Kategori Diperbarui', 'Kategori produk ' . $request->nm_produk . ' berhasil diperbarui', 'Lainnya', route('admin.kategori.index'));

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Kategori produk berhasil diperbarui.');
        }
    }

    public function destroy(Request $request, $id)
    {
        $type = $request->query('type', 'layanan');

        if ($type === 'layanan') {
            $kategori = KategoriLayanan::findOrFail($id);
            $nm = $kategori->nm_layanan;
            $kategori->delete();

            buatNotif(auth()->id(), 'Kategori Dihapus', 'Kategori layanan ' . $nm . ' berhasil dihapus', 'Lainnya', route('admin.kategori.index'));

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Kategori layanan berhasil dihapus.');
        } else {
            $kategori = KategoriProduk::findOrFail($id);
            $nm = $kategori->nm_produk;
            $kategori->delete();

            buatNotif(auth()->id(), 'Kategori Dihapus', 'Kategori produk ' . $nm . ' berhasil dihapus', 'Lainnya', route('admin.kategori.index'));

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Kategori produk berhasil dihapus.');
        }
    }
}
