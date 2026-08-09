<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class AdminProdukController extends Controller
{
    public function index(Request $request)
    {
        $produk = Produk::with('kategori', 'supplier')->orderBy('id_produk', 'desc')->get();
        return view('admin.produk.index', compact('produk'));
    }

    public function create()
    {
        $kategori = KategoriProduk::all();
        return view('admin.produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori_produk' => 'required|integer|exists:kategori_produk,id_kategori_produk',
            'nm_produk'          => 'required|string|max:50',
            'satuan'             => 'required|string|max:50',
            'harga_jual'         => 'required|string|regex:/^[0-9.,]+$/',
            'status'             => 'required|string|in:Tersedia,Habis,Belum Restok',
            'deskripsi'          => 'nullable|string',
        ]);

        $request->merge([
            'harga_jual' => (int) str_replace('.', '', $request->harga_jual),
        ]);

        $data = $request->all();
        $data['stok'] = 0;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk = Produk::create($data);

        buatNotif(auth()->id(), 'Produk Ditambahkan', 'Produk ' . $request->nm_produk . ' berhasil ditambahkan', 'Lainnya', route('admin.produk.index'));

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan. Tambah stok melalui menu Transaksi → Pengeluaran (Transaksi Keluar).');
    }

    public function edit(Produk $produk)
    {
        $kategori = KategoriProduk::all();
        return view('admin.produk.edit', compact('produk', 'kategori'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'id_kategori_produk' => 'required|integer|exists:kategori_produk,id_kategori_produk',
            'nm_produk'          => 'required|string|max:50',
            'satuan'             => 'required|string|max:50',
            'harga_jual'         => 'required|string|regex:/^[0-9.,]+$/',
            'status'             => 'required|string|in:Tersedia,Habis,Belum Restok',
            'deskripsi'          => 'nullable|string',
        ]);

        $request->merge([
            'harga_jual' => (int) str_replace('.', '', $request->harga_jual),
        ]);

        $data = $request->except(['stok', 'foto']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk->update($data);

        buatNotif(auth()->id(), 'Produk Diperbarui', 'Produk ' . $produk->nm_produk . ' berhasil diperbarui', 'Lainnya', route('admin.produk.edit', $produk->id_produk));

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $nm = $produk->nm_produk;
        $produk->delete();

        buatNotif(auth()->id(), 'Produk Dihapus', 'Produk ' . $nm . ' berhasil dihapus dari sistem', 'Lainnya', route('admin.produk.index'));

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
