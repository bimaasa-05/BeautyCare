<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Stok;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AdminStokController extends Controller
{
    public function index(Request $request)
    {
        $type   = $request->type;
        $dari   = $request->dari;
        $sampai = $request->sampai;

        $stok = Stok::with('produk', 'supplier')
            ->when($type, fn($q, $t) => $q->where('type', $t))
            ->when($dari, fn($q, $d) => $q->whereDate('tanggal', '>=', $d))
            ->when($sampai, fn($q, $s) => $q->whereDate('tanggal', '<=', $s))
            ->orderBy('id_stok', 'desc')
            ->get();

        $totalMasuk  = Stok::where('type', 'Masuk')->sum('jumlah');
        $totalKeluar = Stok::where('type', 'Keluar')->sum('jumlah');
        $totalMutasi = Stok::count();

        $countMasuk       = Stok::where('type', 'Masuk')->count();
        $countKeluar      = Stok::where('type', 'Keluar')->count();
        $countPenyesuaian = Stok::where('type', 'Penyesuaian')->count();

        return view('admin.stok.index', compact(
            'stok',
            'totalMasuk',
            'totalKeluar',
            'totalMutasi',
            'countMasuk',
            'countKeluar',
            'countPenyesuaian'
        ));
    }

    public function create()
    {
        $produk   = Produk::orderBy('nm_produk')->get();
        $supplier = Supplier::orderBy('nm_supplier')->get();

        return view('admin.stok.create', compact('produk', 'supplier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk'   => 'required|integer|exists:produk,id_produk',
            'id_supplier' => 'required|integer|exists:supplier,id_supplier',
            'tanggal'     => 'nullable|date',
            'jumlah'      => 'required|integer|min:1',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        $produk    = Produk::findOrFail($request->id_produk);
        $stokLama  = $produk->stok;
        $produk->increment('stok', $request->jumlah);

        if (in_array($produk->status, ['Habis', 'Belum Restok']) && $produk->stok > 0) {
            $produk->update(['status' => 'Tersedia']);
        }

        catatStok(
            $produk->id_produk,
            'Masuk',
            $request->jumlah,
            $stokLama,
            $produk->stok,
            $request->keterangan ?? 'Barang masuk dari supplier',
            $request->id_supplier,
            $produk->id_produk,
            'Restok'
        );

        buatNotif(auth()->id(), 'Barang Masuk', $produk->nm_produk . ' +' . $request->jumlah . ' dari supplier', 'Lainnya', route('admin.stok.index'));

        return redirect()->route('admin.stok.index')
            ->with('success', 'Stok masuk berhasil dicatat.');
    }
}
