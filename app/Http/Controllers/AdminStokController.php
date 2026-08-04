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
        $countRefund      = Stok::where('type', 'Refund')->count();

        return view('admin.stok.index', compact(
            'stok',
            'totalMasuk',
            'totalKeluar',
            'totalMutasi',
            'countMasuk',
            'countKeluar',
            'countRefund'
        ));
    }

    public function create()
    {
        $produk   = Produk::orderBy('nm_produk')->get();
        $supplier = Supplier::with('produk')->where('status', 'Aktif')->whereNotNull('id_produk')->orderBy('nm_supplier')->get();

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

        $supplier = Supplier::findOrFail($request->id_supplier);

        if ($supplier->id_produk != $request->id_produk) {
            return back()->withErrors(['id_produk' => 'Produk harus sesuai dengan produk yang disuplai oleh ' . $supplier->nm_supplier . '.']);
        }

        $produk    = Produk::findOrFail($request->id_produk);
        $stokLama  = $produk->stok;
        $produk->increment('stok', $request->jumlah);

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

    public function refundCreate()
    {
        $produk   = Produk::orderBy('nm_produk')->get();
        $supplier = Supplier::with('produk')->where('status', 'Aktif')->whereNotNull('id_produk')->orderBy('nm_supplier')->get();

        return view('admin.stok.refund', compact('produk', 'supplier'));
    }

    public function refundStore(Request $request)
    {
        $request->validate([
            'id_produk'   => 'required|integer|exists:produk,id_produk',
            'id_supplier' => 'required|integer|exists:supplier,id_supplier',
            'tanggal'     => 'nullable|date',
            'jumlah'      => 'required|integer|min:1',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        $supplier = Supplier::findOrFail($request->id_supplier);

        if ($supplier->id_produk != $request->id_produk) {
            return back()->withErrors(['id_produk' => 'Produk harus sesuai dengan produk yang disuplai oleh ' . $supplier->nm_supplier . '.']);
        }

        $produk   = Produk::findOrFail($request->id_produk);
        $stokLama = $produk->stok;

        if ($request->jumlah > $stokLama) {
            return back()->withErrors(['jumlah' => 'Jumlah refund melebihi stok tersedia (' . $stokLama . ').']);
        }

        $produk->decrement('stok', $request->jumlah);

        catatStok(
            $produk->id_produk,
            'Refund',
            $request->jumlah,
            $stokLama,
            $produk->stok,
            $request->keterangan ?? 'Barang rusak / tidak sesuai dikembalikan ke supplier',
            $request->id_supplier,
            $produk->id_produk,
            'Refund'
        );

        buatNotif(auth()->id(), 'Refund Stok', $produk->nm_produk . ' -' . $request->jumlah . ' di-refund ke supplier', 'Lainnya', route('admin.stok.index'));

        return redirect()->route('admin.stok.index')
            ->with('success', 'Refund stok berhasil dicatat.');
    }
}
