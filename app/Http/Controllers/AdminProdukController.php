<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use App\Models\Supplier;
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
        $supplier = Supplier::all();
        return view('admin.produk.create', compact('kategori', 'supplier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori_produk' => 'required|integer|exists:kategori_produk,id_kategori_produk',
            'id_supplier'        => 'required|integer|exists:supplier,id_produk',
            'barcode'            => 'required|string|max:50',
            'nm_produk'          => 'required|string|max:50',
            'satuan'             => 'required|string|max:50',
            'harga_beli'         => 'required|numeric',
            'harga_jual'         => 'required|numeric',
            'stok'               => 'required|integer',
            'status'             => 'required|integer',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        Produk::create($data);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        $kategori = KategoriProduk::all();
        $supplier = Supplier::all();
        return view('admin.produk.edit', compact('produk', 'kategori', 'supplier'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'id_kategori_produk' => 'required|integer|exists:kategori_produk,id_kategori_produk',
            'id_supplier'        => 'required|integer|exists:supplier,id_produk',
            'barcode'            => 'required|string|max:50',
            'nm_produk'          => 'required|string|max:50',
            'satuan'             => 'required|string|max:50',
            'harga_beli'         => 'required|numeric',
            'harga_jual'         => 'required|numeric',
            'stok'               => 'required|integer',
            'status'             => 'required|integer',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk->update($data);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
