<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminBankController extends Controller
{
    public function index()
    {
        $banks = collect([]);
        return view('admin.bank.index', compact('banks'));
    }

    public function create()
    {
        return view('admin.bank.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.bank.index')
            ->with('success', 'Data bank berhasil ditambahkan.');
    }

    public function show($id)
    {
        return view('admin.bank.show');
    }

    public function edit($id)
    {
        return view('admin.bank.edit');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.bank.index')
            ->with('success', 'Data bank berhasil diperbarui.');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.bank.index')
            ->with('success', 'Data bank berhasil dihapus.');
    }
}