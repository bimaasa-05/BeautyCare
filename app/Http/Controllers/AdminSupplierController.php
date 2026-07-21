<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class AdminSupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();
        return view('admin.supplier.index', compact('supplier'));
    }

    public function create()
    {
        return view('admin.supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_supplier' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        Supplier::create($request->all());

        buatNotif(auth()->id(), 'Supplier Ditambahkan', 'Supplier ' . $request->nm_supplier . ' berhasil ditambahkan', 'Lainnya', route('admin.supplier.index'));

        return redirect()->route('admin.supplier.index')
            ->with('success', 'Supplier created successfully.');
    }


    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nm_supplier' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
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
