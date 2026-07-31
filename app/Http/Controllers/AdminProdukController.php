<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Stok;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class AdminProdukController extends Controller
{
    public function index(Request $request)
    {
        $produk = Produk::with('kategori')->orderBy('id_produk', 'desc')->get();
        return view('admin.produk.index', compact('produk'));
    }

    public function create()
    {
        $kategori = KategoriProduk::all();
        return view('admin.produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'harga_beli' => (int) str_replace('.', '', $request->harga_beli),
            'harga_jual' => (int) str_replace('.', '', $request->harga_jual),
        ]);

        $request->validate([
            'id_kategori_produk' => 'required|integer|exists:kategori_produk,id_kategori_produk',
            'nm_produk'          => 'required|string|max:50',
            'satuan'             => 'required|string|max:50',
            'harga_beli'         => 'required|numeric',
            'harga_jual'         => 'required|numeric',
            'stok'               => 'required|integer',
            'status'             => 'required|string|in:Tersedia,Habis,Belum Restok',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk = Produk::create($data);

        if ($produk->stok > 0) {
            Stok::create([
                'id_produk'    => $produk->id_produk,
                'id_supplier'  => null,
                'tanggal'      => now()->toDateString(),
                'type'         => 'Masuk',
                'jumlah'       => $produk->stok,
                'stok_sebelum' => 0,
                'stok_sesudah' => $produk->stok,
                'keterangan'   => 'Stok awal saat produk dibuat',
                'ref_id'       => $produk->id_produk,
                'ref_type'     => 'Produk',
                'status'       => 1,
            ]);
        }

        buatNotif(auth()->id(), 'Produk Ditambahkan', 'Produk ' . $request->nm_produk . ' berhasil ditambahkan', 'Lainnya', route('admin.produk.index'));

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        $kategori = KategoriProduk::all();
        return view('admin.produk.edit', compact('produk', 'kategori'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->merge([
            'harga_beli' => (int) str_replace('.', '', $request->harga_beli),
            'harga_jual' => (int) str_replace('.', '', $request->harga_jual),
        ]);

        $request->validate([
            'id_kategori_produk' => 'required|integer|exists:kategori_produk,id_kategori_produk',
            'nm_produk'          => 'required|string|max:50',
            'satuan'             => 'required|string|max:50',
            'harga_beli'         => 'required|numeric',
            'harga_jual'         => 'required|numeric',
            'stok'               => 'required|integer',
            'status'             => 'required|string|in:Tersedia,Habis,Belum Restok',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $stokLama = $produk->stok;
        $produk->update($data);

        if ($produk->stok != $stokLama) {
            Stok::create([
                'id_produk'    => $produk->id_produk,
                'id_supplier'  => null,
                'tanggal'      => now()->toDateString(),
                'type'         => 'Penyesuaian',
                'jumlah'       => abs($produk->stok - $stokLama),
                'stok_sebelum' => $stokLama,
                'stok_sesudah' => $produk->stok,
                'keterangan'   => 'Penyesuaian stok dari ' . $stokLama . ' menjadi ' . $produk->stok,
                'ref_id'       => $produk->id_produk,
                'ref_type'     => 'Produk',
                'status'       => 1,
            ]);
        }

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
