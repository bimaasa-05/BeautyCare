<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pengeluaran;
use App\Models\Supplier;
use App\Exports\AdminTransaksiExport;
use App\Helpers\ActivityLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Services\PengeluaranService;

class AdminTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $keyword    = $request->keyword;
        $dari       = $request->dari;
        $sampai     = $request->sampai;

        $query = Transaksi::with('pelanggan', 'supplier', 'pengeluaran', 'user', 'kasir')
            ->when($keyword, function ($q) use ($keyword) {
                return $q->where(function ($q) use ($keyword) {
                    $q->where('no_invoice', 'like', "%{$keyword}%")
                        ->orWhere('catatan', 'like', "%{$keyword}%")
                        ->orWhereHas('pelanggan', function ($q) use ($keyword) {
                            $q->where('nm_pelanggan', 'like', "%{$keyword}%")
                                ->orWhere('no_hp', 'like', "%{$keyword}%");
                        })
                        ->orWhereHas('supplier', function ($q) use ($keyword) {
                            $q->where('nm_supplier', 'like', "%{$keyword}%");
                        })
                        ->orWhereHas('pengeluaran', function ($q) use ($keyword) {
                            $q->where('kategori', 'like', "%{$keyword}%")
                                ->orWhere('keterangan', 'like', "%{$keyword}%");
                        });
                });
            })
            ->when($dari, fn($q, $d) => $q->whereDate('tanggal', '>=', $d))
            ->when($sampai, fn($q, $s) => $q->whereDate('tanggal', '<=', $s))
            ->orderBy('id_transaksi', 'desc');

        $transaksi = (clone $query)->paginate(15)->withQueryString();

        $totalTransaksi = (clone $query)->count();
        $totalNominal   = (clone $query)->sum('total');

        $snapTotal = Transaksi::count();
        $snapPendapatan = Transaksi::whereIn('jenis_transaksi', ['Penjualan', 'Pemasukan'])
            ->where('status', 'Lunas')
            ->sum('total');
        $snapPengeluaran = Transaksi::where('jenis_transaksi', 'Pengeluaran')->sum('total');
        $snapBersih = $snapPendapatan - $snapPengeluaran;

        return view('admin.transaksi.index', compact(
            'transaksi',
            'totalTransaksi',
            'totalNominal',
            'snapTotal',
            'snapPendapatan',
            'snapPengeluaran',
            'snapBersih'
        ));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'supplier', 'pengeluaran', 'detail')->findOrFail($id);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function invoice($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'supplier', 'detail', 'user', 'kasir')->findOrFail($id);
        return view('kasir.invoice.show', compact('transaksi'));
    }

    public function invoicePdf($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'supplier', 'detail', 'user', 'kasir')->findOrFail($id);
        $pdf = Pdf::loadView('kasir.invoice.pdf', compact('transaksi'));
        return $pdf->download('Invoice-' . $transaksi->no_invoice . '.pdf');
    }


    public function struk($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'supplier', 'detail', 'user', 'kasir')->findOrFail($id);
        return view('kasir.struk.index', compact('transaksi'));
    }
    public function createPembelian()
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

        return view('admin.transaksi.pembelian', compact('supplier', 'supplierData'));
    }

    public function storePembelian(Request $request)
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

        $rincian = [];
        foreach ($request->items as $item) {
            $produk = $supplier->produk->firstWhere('id_produk', (int) $item['id_produk']);

            if (!$produk) {
                return back()->withErrors(['items' => 'Produk harus sesuai dengan produk yang disuplai oleh ' . $supplier->nm_supplier . '.']);
            }

            $rincian[] = $produk->nm_produk . ' x' . (int) $item['qty'];
        }

        $keterangan = 'Pembelian stok dari ' . $supplier->nm_supplier . ' (' . implode(', ', $rincian) . ')';
        if ($request->filled('catatan')) {
            $keterangan .= ' — ' . $request->catatan;
        }

        $pengeluaran = Pengeluaran::create([
            'tanggal'    => $request->tanggal,
            'kategori'   => 'Bahan & Stok',
            'keterangan' => $keterangan,
            'nominal'    => (int) $request->total,
            'id_user'    => auth()->user()->id,
        ]);

        foreach ($request->items as $item) {
            $produk = $supplier->produk->firstWhere('id_produk', (int) $item['id_produk']);

            $hargaBeli = (float) $produk->pivot->harga_beli;
            $qty       = (int) $item['qty'];

            $stokLama = $produk->stok;
            $produk->increment('stok', $qty);
            catatStok(
                $produk->id_produk,
                'Masuk',
                $qty,
                $stokLama,
                $produk->stok,
                'Pembelian stok dari supplier (' . $supplier->nm_supplier . ')',
                $supplier->id_supplier,
                $pengeluaran->id_pengeluaran,
                'Pengeluaran',
                $hargaBeli
            );
        }

        app(PengeluaranService::class)->buatTransaksi($pengeluaran, $supplier->id_supplier, 'admin');

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' mencatat pembelian stok dari ' . $supplier->nm_supplier . ' sebesar Rp ' . number_format((int) $request->total, 0, ',', '.'), 'Pengeluaran', $pengeluaran->id_pengeluaran);

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Pembelian stok berhasil dicatat! Stok produk telah ditambahkan.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis'      => 'required|in:Pengeluaran,Pemasukan',
            'tanggal'    => 'required|date',
            'kategori'   => 'required|string|max:100',
            'nominal'    => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $nominal = (int) $request->nominal;

        if ($request->jenis === 'Pengeluaran') {
            $pengeluaran = Pengeluaran::create([
                'tanggal'    => $request->tanggal,
                'kategori'   => $request->kategori,
                'keterangan' => $request->keterangan ?? '',
                'nominal'    => $nominal,
                'id_user'    => auth()->user()->id,
            ]);

            app(PengeluaranService::class)->buatTransaksi($pengeluaran, null, 'admin');

            ActivityLogger::log('Menambahkan', auth()->user()->nama . ' mencatat pengeluaran ' . $request->kategori . ' sebesar Rp ' . number_format($nominal, 0, ',', '.'), 'Pengeluaran', $pengeluaran->id_pengeluaran);

            return redirect()->route('admin.transaksi.index')
                ->with('success', 'Pengeluaran berhasil dicatat!');
        }

        $noInvoice = 'PMK-' . date('Ymd') . '-' . str_pad(Transaksi::max('id_transaksi') + 1, 4, '0', STR_PAD_LEFT);

        $transaksi = Transaksi::create([
            'id_booking'       => null,
            'sumber'           => 'admin',
            'id_pelanggan'     => null,
            'id_supplier'      => null,
            'jenis_transaksi'  => 'Pemasukan',
            'id_user'          => auth()->user()->id,
            'id_kasir'         => null,
            'no_invoice'       => $noInvoice,
            'tanggal'          => $request->tanggal,
            'subtotal'         => $nominal,
            'diskon'           => 0,
            'pajak'            => 0,
            'total'            => $nominal,
            'metode_byr'       => 'Tunai',
            'dibayar'          => $nominal,
            'kembali'          => 0,
            'catatan'          => $request->kategori . ($request->keterangan ? ' — ' . $request->keterangan : ''),
            'status'           => 'Lunas',
            'no_referensi'     => null,
        ]);

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' mencatat pemasukan ' . $request->kategori . ' sebesar Rp ' . number_format($nominal, 0, ',', '.'), 'Transaksi', $transaksi->id_transaksi);

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Pemasukan berhasil dicatat!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis'      => 'required|in:Pengeluaran,Pemasukan,Penjualan',
            'tanggal'    => 'required|date',
            'kategori'   => 'nullable|string|max:100',
            'nominal'    => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:500',
            'status'     => 'nullable|in:Lunas,Pending,Batal',
        ]);

        $transaksi = Transaksi::with('pengeluaran')->findOrFail($id);

        $nominal = (int) $request->nominal;
        $kategori = $request->kategori ?? '';
        $catatan = $kategori . ($request->keterangan ? ' — ' . $request->keterangan : '');

        $transaksi->update([
            'tanggal'  => $request->tanggal,
            'subtotal' => $nominal,
            'total'    => $nominal,
            'dibayar'  => $nominal,
            'catatan'  => $catatan,
            'status'   => $request->status ?? $transaksi->status,
        ]);

        if ($transaksi->id_pengeluaran && $transaksi->pengeluaran) {
            $transaksi->pengeluaran->update([
                'tanggal'    => $request->tanggal,
                'kategori'   => $kategori ?: $transaksi->pengeluaran->kategori,
                'keterangan' => $request->keterangan ?? $transaksi->pengeluaran->keterangan,
                'nominal'    => $nominal,
            ]);

            app(PengeluaranService::class)->sinkronTransaksi($transaksi->pengeluaran);
        }

        ActivityLogger::log('Mengubah', auth()->user()->nama . ' mengubah transaksi ' . $transaksi->no_invoice, 'Transaksi', $id);

        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::with('pengeluaran')->findOrFail($id);

        if ($transaksi->id_pengeluaran && $transaksi->pengeluaran) {
            app(PengeluaranService::class)->hapusTransaksi($transaksi->pengeluaran);
            $transaksi->pengeluaran->delete();
        }

        $transaksi->delete();

        ActivityLogger::log('Menghapus', auth()->user()->nama . ' menghapus transaksi ' . $transaksi->no_invoice, 'Transaksi', $id);

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }

    public function export(Request $request)
    {
        $keyword = $request->keyword;
        $dari = $request->dari ? \Carbon\Carbon::parse($request->dari)->format('Y-m-d') : null;
        $sampai = $request->sampai ? \Carbon\Carbon::parse($request->sampai)->format('Y-m-d') : null;

        return Excel::download(
            new AdminTransaksiExport($keyword, $dari, $sampai),
            'transaksi-' . now()->format('Y-m-d-His') . '.xlsx'
        );
    }
}
