<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\SaldoMutasi;
use Illuminate\Http\Request;

class PelangganSaldoController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::dariUser(auth()->user());

        if (!$pelanggan) {
            return redirect()->route('pelanggan.konsultasi.index')->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $mutasi = SaldoMutasi::with('transaksi')
            ->where('id_pelanggan', $pelanggan->id_pelanggan)
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('pelanggan.saldo.index', [
            'pelanggan' => $pelanggan,
            'mutasi' => $mutasi,
        ]);
    }
}