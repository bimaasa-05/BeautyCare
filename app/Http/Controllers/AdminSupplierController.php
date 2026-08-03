<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AdminSupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::with('produk')->get();
        $aktif    = Supplier::where('status', 'Aktif')->count();
        $nonAktif = Supplier::where('status', 'Non Aktif')->count();

        return view('admin.supplier.index', compact('supplier', 'aktif', 'nonAktif'));
    }

    public function create()
    {
        $produk   = Produk::orderBy('nm_produk')->get();
        $terpakai = Supplier::whereNotNull('id_produk')->pluck('id_produk')->toArray();
        return view('admin.supplier.create', compact('produk', 'terpakai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_supplier' => 'required',
            'alamat'      => 'required',
            'no_hp'       => 'required',
            'id_produk'   => 'nullable|integer|exists:produk,id_produk',
            'status'      => 'required|string|in:Aktif,Non Aktif',
        ]);

        Supplier::create($request->all());

        buatNotif(auth()->id(), 'Supplier Ditambahkan', 'Supplier ' . $request->nm_supplier . ' berhasil ditambahkan', 'Lainnya', route('admin.supplier.index'));

        return redirect()->route('admin.supplier.index')
            ->with('success', 'Supplier created successfully.');
    }


    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $produk   = Produk::orderBy('nm_produk')->get();
        $terpakai = Supplier::whereNotNull('id_produk')->where('id_supplier', '!=', $supplier->id_supplier)->pluck('id_produk')->toArray();
        return view('admin.supplier.edit', compact('supplier', 'produk', 'terpakai'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nm_supplier' => 'required',
            'alamat'      => 'required',
            'no_hp'       => 'required',
            'id_produk'   => 'nullable|integer|exists:produk,id_produk',
            'status'      => 'required|string|in:Aktif,Non Aktif',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        buatNotif(auth()->id(), 'Supplier Diperbarui', 'Supplier ' . $supplier->nm_supplier . ' berhasil diperbarui', 'Lainnya', route('admin.supplier.edit', $supplier->id_supplier));

        return redirect()->route('admin.supplier.index')
            ->with('success', 'Supplier updated successfully.');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $nm = $supplier->nm_supplier;
        $supplier->delete();

        buatNotif(auth()->id(), 'Supplier Dihapus', 'Supplier ' . $nm . ' berhasil dihapus dari sistem', 'Lainnya', route('admin.supplier.index'));

        return redirect()->route('admin.supplier.index')
            ->with('success', 'Supplier deleted successfully.');
    }
}
