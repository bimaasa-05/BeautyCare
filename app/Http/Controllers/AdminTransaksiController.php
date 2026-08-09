<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Supplier;
use App\Helpers\ActivityLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdminTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $keyword    = $request->keyword;
        $dari       = $request->dari;
        $sampai     = $request->sampai;
        $jenis      = $request->jenis === 'pengeluaran' ? 'Pembelian' : 'Penjualan';

        $transaksi = Transaksi::with('pelanggan', 'supplier', 'detail', 'user')
            ->where('jenis_transaksi', $jenis)
            ->when($keyword, function ($q, $keyword) {
                return $q->where(function ($q) use ($keyword) {
                    $q->where('no_invoice', 'like', "%{$keyword}%")
                        ->orWhereHas('pelanggan', function ($q) use ($keyword) {
                            $q->where('nm_pelanggan', 'like', "%{$keyword}%")
                                ->orWhere('no_hp', 'like', "%{$keyword}%");
                        })
                        ->orWhereHas('supplier', function ($q) use ($keyword) {
                            $q->where('nm_supplier', 'like', "%{$keyword}%");
                        });
                });
            })
            ->when($dari, fn($q, $d) => $q->whereDate('tanggal', '>=', $d))
            ->when($sampai, fn($q, $s) => $q->whereDate('tanggal', '<=', $s))
            ->orderBy('id_transaksi', 'desc')
            ->paginate(15);

        $totalTransaksi   = Transaksi::where('jenis_transaksi', $jenis)->count();
        $totalPendapatan  = Transaksi::where('jenis_transaksi', 'Penjualan')->where('status', 'Lunas')->sum('total');
        $totalPengeluaran = Transaksi::where('jenis_transaksi', 'Pembelian')->sum('total');

        return view('admin.transaksi.index', compact(
            'transaksi',
            'totalTransaksi',
            'totalPendapatan',
            'totalPengeluaran'
        ));
    }

    public function createKeluar()
    {
        $supplier = Supplier::with(['produk' => fn($q) => $q->orderBy('nm_produk')])
            ->where('status', 'Aktif')
            ->orderBy('nm_supplier')
            ->get();

        $supplierData = $supplier->map(fn($s) => [
            'id' => $s->id_supplier,
            'produk' => $s->produk->map(fn($p) => [
                'id' => $p->id_produk,
                'nm' => $p->nm_produk,
                'harga_beli' => (float) $p->pivot->harga_beli,
            ])->values()->all(),
        ])->keyBy('id');

        return view('admin.transaksi.keluar', compact('supplier', 'supplierData'));
    }

    public function storeKeluar(Request $request)
    {
        $request->validate([
            'id_supplier' => 'required|integer|exists:supplier,id_supplier',
            'tanggal'     => 'required|date',
            'metode_byr'  => 'required|string|max:50',
            'subtotal'    => 'required|numeric|min:0',
            'total'       => 'required|numeric|min:0',
            'catatan'     => 'nullable|string',
            'items'       => 'required|array|min:1',
            'items.*.id_produk' => 'required|integer|exists:produk,id_produk',
            'items.*.qty'       => 'required|integer|min:1',
        ]);

        $supplier = Supplier::with('produk')->findOrFail($request->id_supplier);

        $lastId    = Transaksi::max('id_transaksi') + 1;
        $no_invoice = 'TRK-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        $transaksi = Transaksi::create([
            'id_booking'      => null,
            'sumber'          => 'beli',
            'id_pelanggan'    => null,
            'id_supplier'     => $supplier->id_supplier,
            'jenis_transaksi' => 'Pembelian',
            'id_user'         => auth()->user()->id,
            'no_invoice'      => $no_invoice,
            'tanggal'         => $request->tanggal,
            'subtotal'        => $request->subtotal,
            'diskon'          => 0,
            'pajak'           => 0,
            'total'           => $request->total,
            'metode_byr'      => $request->metode_byr,
            'dibayar'         => $request->total,
            'kembali'         => 0,
            'catatan'         => $request->catatan ?? '',
            'status'          => 'Lunas',
        ]);

        foreach ($request->items as $item) {
            $produk = $supplier->produk->firstWhere('id_produk', (int) $item['id_produk']);

            if (!$produk) {
                return back()->withErrors(['items' => 'Produk harus sesuai dengan produk yang disuplai oleh ' . $supplier->nm_supplier . '.']);
            }

            $hargaBeli = (float) $produk->pivot->harga_beli;
            $qty       = (int) $item['qty'];

            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'jenis'        => 'Produk',
                'id_item'      => $produk->id_produk,
                'nm_item'      => $produk->nm_produk,
                'qty'          => $qty,
                'harga'        => $hargaBeli,
                'diskon'       => 0,
                'subtotal'     => $hargaBeli * $qty,
            ]);

            $stokLama = $produk->stok;
            $produk->increment('stok', $qty);
            catatStok(
                $produk->id_produk,
                'Masuk',
                $qty,
                $stokLama,
                $produk->stok,
                'Pembelian stok dari supplier (' . $no_invoice . ')',
                $supplier->id_supplier,
                $transaksi->id_transaksi,
                'Transaksi',
                $hargaBeli
            );
        }

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' membuat transaksi keluar (pembelian stok) ' . $no_invoice, 'Transaksi', $transaksi->id_transaksi);

        return redirect()->route('admin.transaksi.index', ['jenis' => 'pengeluaran'])
            ->with('success', 'Transaksi keluar berhasil disimpan! Stok produk telah ditambahkan.');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'supplier', 'detail')->findOrFail($id);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function invoice($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'supplier', 'detail', 'user')->findOrFail($id);
        return view('kasir.invoice.show', compact('transaksi'));
    }

    public function invoicePdf($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'supplier', 'detail', 'user')->findOrFail($id);
        $pdf = Pdf::loadView('kasir.invoice.pdf', compact('transaksi'));
        return $pdf->download('Invoice-' . $transaksi->no_invoice . '.pdf');
    }

    public function export(Request $request)
    {
        $keyword = $request->keyword;
        $dari    = $request->dari;
        $sampai  = $request->sampai;
        $jenis   = $request->jenis === 'pengeluaran' ? 'Pembelian' : 'Penjualan';

        $transaksi = Transaksi::with('pelanggan', 'supplier', 'detail', 'user')
            ->where('jenis_transaksi', $jenis)
            ->when($keyword, function ($q, $keyword) {
                return $q->where(function ($q) use ($keyword) {
                    $q->where('no_invoice', 'like', "%{$keyword}%")
                        ->orWhereHas('pelanggan', function ($q) use ($keyword) {
                            $q->where('nm_pelanggan', 'like', "%{$keyword}%")
                                ->orWhere('no_hp', 'like', "%{$keyword}%");
                        })
                        ->orWhereHas('supplier', function ($q) use ($keyword) {
                            $q->where('nm_supplier', 'like', "%{$keyword}%");
                        });
                });
            })
            ->when($dari, fn($q, $d) => $q->whereDate('tanggal', '>=', $d))
            ->when($sampai, fn($q, $s) => $q->whereDate('tanggal', '<=', $s))
            ->orderBy('id_transaksi', 'desc')
            ->get();

        $filename = 'transaksi-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = ['Jenis', 'No. Invoice', 'Pelanggan/Supplier', 'Tanggal', 'Subtotal', 'Diskon', 'Pajak', 'Total', 'Metode', 'Dibayar', 'Kembali', 'Status', 'Admin', 'Catatan'];

        $callback = function () use ($transaksi, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, $columns);

            foreach ($transaksi as $t) {
                fputcsv($file, [
                    $t->jenis_transaksi,
                    $t->no_invoice,
                    $t->jenis_transaksi === 'Pembelian'
                        ? ($t->supplier->nm_supplier ?? '-')
                        : ($t->pelanggan->nm_pelanggan ?? '-'),
                    $t->tanggal,
                    $t->subtotal,
                    $t->diskon,
                    $t->pajak,
                    $t->total,
                    $t->metode_byr,
                    $t->dibayar,
                    $t->kembali,
                    $t->status,
                    $t->user->nama ?? '-',
                    $t->catatan,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
