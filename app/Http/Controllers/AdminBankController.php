<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class AdminBankController extends Controller
{
    public function index()
    {
        $banks = Bank::withTrashed()->paginate(15);
        return view('admin.bank.index', compact('banks'));
    }

    public function create()
    {
        return view('admin.bank.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:50',
            'kode_bank' => 'nullable|string|max:3|unique:banks,kode_bank',
            'no_rekening' => 'nullable|string|max:30',
            'atas_nama' => 'required|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'tipe' => 'required|in:transfer,ewallet,qris',
            'nomor_telepon' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['nama_bank', 'kode_bank', 'no_rekening', 'atas_nama', 'tipe', 'nomor_telepon', 'is_active']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('uploads/bank-logo', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');

        Bank::create($data);

        return redirect()->route('admin.bank.index')
            ->with('success', 'Data bank berhasil ditambahkan.');
    }

    public function show($id)
    {
        $bank = Bank::withTrashed()->findOrFail($id);
        return view('admin.bank.show', compact('bank'));
    }

    public function edit($id)
    {
        $bank = Bank::withTrashed()->findOrFail($id);
        return view('admin.bank.edit', compact('bank'));
    }

    public function update(Request $request, $id)
    {
        $bank = Bank::withTrashed()->findOrFail($id);

        $request->validate([
            'nama_bank' => 'required|string|max:50',
            'kode_bank' => 'nullable|string|max:3|unique:banks,kode_bank,' . $id . ',id,deleted_at,NULL',
            'no_rekening' => 'nullable|string|max:30',
            'atas_nama' => 'required|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'tipe' => 'required|in:transfer,ewallet,qris',
            'nomor_telepon' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['nama_bank', 'kode_bank', 'no_rekening', 'atas_nama', 'tipe', 'nomor_telepon', 'is_active']);

        if ($request->hasFile('logo')) {
            if ($bank->logo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($bank->logo);
            }
            $data['logo'] = $request->file('logo')->store('uploads/bank-logo', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');

        $bank->update($data);

        return redirect()->route('admin.bank.index')
            ->with('success', 'Data bank berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();

        return redirect()->route('admin.bank.index')
            ->with('success', 'Data bank berhasil dihapus (soft delete).');
    }
}