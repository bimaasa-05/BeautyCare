<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Karyawan;
use App\Helpers\ActivityLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Services\SaldoAkunService;

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
        $pelanggan = Pelanggan::with('membership')->get();
        $layanan   = Layanan::where('status', 1)->get();
        $produk    = Produk::where('status', 1)->get();
        $karyawan  = Karyawan::with('user')->get();

        return view('admin.transaksi.create', compact('pelanggan', 'layanan', 'produk', 'karyawan'));
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
            
            //Validasi tambahan untuk metode pembayaran tertentu Untuk Pelanggan

            'id_pelanggan' => 'required|integer',
            'tanggal'      => 'required|date',
            'subtotal'     => 'required|numeric|min:0',
            'diskon'       => 'nullable|numeric|min:0',
            'pajak'        => 'nullable|numeric|min:0',
            'total'        => 'required|numeric|min:0',
            'metode_byr'   => 'required|in:Tunai,Transfer,Debit,QRIS,E-Wallet',
            'dibayar'      => 'required|numeric|min:0',
            'kembali'      => 'required|numeric|min:0',
            'catatan'      => 'nullable|string',
            'bukti_bayar'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'no_referensi' => 'nullable|string|max:50',
            'ewallet_type' => 'nullable|in:Dana,GoPay,ShopeePay',
        ]);

        $supplier = Supplier::with('produk')->findOrFail($request->id_supplier);

        $lastId    = Transaksi::max('id_transaksi') + 1;
        $no_invoice = 'TRK-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);
        $status = in_array($request->metode_byr, ['Tunai', 'QRIS', 'E-Wallet']) ? 'Lunas' : 'Proses';

        $data = [
            'id_booking'   => null,
            'id_pelanggan' => $request->id_pelanggan,
            'id_user'      => auth()->user()->id,
            'no_invoice'   => $no_invoice,
            'tanggal'      => $request->tanggal,
            'subtotal'     => $request->subtotal,
            'diskon'       => $request->diskon ?? 0,
            'pajak'        => $request->pajak ?? 0,
            'total'        => $request->total,
            'metode_byr'   => $request->metode_byr,
            'dibayar'      => $request->dibayar,
            'kembali'      => $request->kembali,
            'catatan'      => $request->catatan ?? '',
            'status'       => $status,
            'no_referensi' => $request->no_referensi,
            'ewallet_type' => $request->ewallet_type,
        ];

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
        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' menambahkan transaksi ' . $no_invoice, 'Transaksi', $transaksi->id_transaksi);

        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $item) {
                if (!empty($item['id_item'])) {
                    DetailTransaksi::create([
                        'id_transaksi' => $transaksi->id_transaksi,
                        'jenis'        => $item['jenis'] ?? 'Layanan',
                        'id_item'      => $item['id_item'],
                        'nm_item'      => $item['nm_item'] ?? '',
                        'qty'          => $item['qty'] ?? 1,
                        'harga'        => $item['harga'] ?? 0,
                        'diskon'       => 0,
                        'subtotal'     => $item['subtotal'] ?? 0,
                        'jam'          => $item['jam'] ?? null,
                        'id_karyawan'  => $item['id_karyawan'] ?? null,
                    ]);

                    if (($item['jenis'] ?? 'Layanan') === 'Produk') {
                        $produk = Produk::find($item['id_item']);
                        if ($produk && $produk->stok >= ($item['qty'] ?? 1)) {
                            $stokLama = $produk->stok;
                            $produk->decrement('stok', $item['qty'] ?? 1);
                            catatStok($produk->id_produk, 'Keluar', $item['qty'] ?? 1, $stokLama, $produk->stok, 'Penjualan ' . $no_invoice, null, $transaksi->id_transaksi, 'Transaksi');
                        }
                    }
                }
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
        $msg = in_array($request->metode_byr, ['Tunai', 'QRIS', 'E-Wallet'])
            ? 'Transaksi berhasil disimpan!'
            : 'Transaksi berhasil dicatat! Menunggu konfirmasi pembayaran.';

        return redirect()->route('admin.transaksi.index', ['jenis' => 'pengeluaran'])
            ->with('success', 'Transaksi keluar berhasil disimpan! Stok produk telah ditambahkan.');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'supplier', 'detail')->findOrFail($id);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with('detail')->findOrFail($id);
        $pelanggan = Pelanggan::with('membership')->get();
        $layanan   = Layanan::where('status', 1)->get();
        $produk    = Produk::where('status', 1)->get();
        $karyawan  = Karyawan::with('user')->get();

        return view('admin.transaksi.edit', compact('transaksi', 'pelanggan', 'layanan', 'produk', 'karyawan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pelanggan' => 'required|integer',
            'tanggal'      => 'required|date',
            'subtotal'     => 'required|numeric|min:0',
            'diskon'       => 'nullable|numeric|min:0',
            'pajak'        => 'nullable|numeric|min:0',
            'total'        => 'required|numeric|min:0',
            'metode_byr'   => 'required|in:Tunai,Transfer,Debit,QRIS,E-Wallet',
            'dibayar'      => 'required|numeric|min:0',
            'kembali'      => 'required|numeric|min:0',
            'catatan'      => 'nullable|string',
            'bukti_bayar'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'no_referensi' => 'nullable|string|max:50',
            'ewallet_type' => 'nullable|in:Dana,GoPay,ShopeePay',
            'status'       => 'nullable|in:Lunas,Proses,Batal',
        ]);

        $data = [
            'id_pelanggan' => $request->id_pelanggan,
            'tanggal'      => $request->tanggal,
            'subtotal'     => $request->subtotal,
            'diskon'       => $request->diskon ?? 0,
            'pajak'        => $request->pajak ?? 0,
            'total'        => $request->total,
            'metode_byr'   => $request->metode_byr,
            'dibayar'      => $request->dibayar,
            'kembali'      => $request->kembali,
            'catatan'      => $request->catatan ?? '',
            'no_referensi' => $request->no_referensi,
            'ewallet_type' => $request->ewallet_type,
        ];

        if ($request->filled('status')) {
            $data['status'] = $request->status;
        } elseif (in_array($request->metode_byr, ['Tunai', 'QRIS', 'E-Wallet'])) {
            $data['status'] = 'Lunas';
        } else {
            $data['status'] = 'Proses';
        }

        if ($request->hasFile('bukti_bayar')) {
            $transaksi = Transaksi::findOrFail($id);
            if ($transaksi->bukti_bayar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($transaksi->bukti_bayar);
            }
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('uploads/bukti_bayar', 'public');
        }

        $transaksiLama = Transaksi::findOrFail($id);
        $dataLama = $transaksiLama->toArray();

        Transaksi::where('id_transaksi', $id)->update($data);

        // Proses saldo & cashback jika status jadi Lunas
        $transaksiBaru = Transaksi::findOrFail($id);
        if (($data['status'] ?? $transaksiBaru->status) === 'Lunas' && ($transaksiLama->status !== 'Lunas')) {
            $saldoService = new SaldoAkunService();
            $saldoService->prosesCheckout(
                $transaksiBaru->id_pelanggan,
                (float) $transaksiBaru->total,
                0, // hanya cashback
                $transaksiBaru->id_transaksi,
                $transaksiBaru->detail->firstWhere('id_promo')?->id_promo
            );
        }

        ActivityLogger::log('Mengubah', auth()->user()->nama . ' mengubah transaksi ' . $transaksiLama->no_invoice, 'Transaksi', $id, $dataLama, $data);

        if ($request->has('items') && is_array($request->items)) {
            $oldDetails = DetailTransaksi::where('id_transaksi', $id)->get();
            foreach ($oldDetails as $old) {
                if ($old->jenis === 'Produk') {
                    $produk = Produk::find($old->id_item);
                    if ($produk) {
                        $stokLama = $produk->stok;
                        $produk->increment('stok', $old->qty);
                        catatStok($produk->id_produk, 'Masuk', $old->qty, $stokLama, $produk->stok, 'Pengembalian stok dari perubahan transaksi', null, $id, 'Transaksi');
                    }
                }
            }

            DetailTransaksi::where('id_transaksi', $id)->delete();
            foreach ($request->items as $item) {
                if (!empty($item['id_item'])) {
                    DetailTransaksi::create([
                        'id_transaksi' => $id,
                        'jenis'        => $item['jenis'] ?? 'Layanan',
                        'id_item'      => $item['id_item'],
                        'nm_item'      => $item['nm_item'] ?? '',
                        'qty'          => $item['qty'] ?? 1,
                        'harga'        => $item['harga'] ?? 0,
                        'diskon'       => 0,
                        'subtotal'     => $item['subtotal'] ?? 0,
                        'jam'          => $item['jam'] ?? null,
                        'id_karyawan'  => $item['id_karyawan'] ?? null,
                    ]);

                    if (($item['jenis'] ?? 'Layanan') === 'Produk') {
                        $produk = Produk::find($item['id_item']);
                        if ($produk && $produk->stok >= ($item['qty'] ?? 1)) {
                            $stokLama = $produk->stok;
                            $produk->decrement('stok', $item['qty'] ?? 1);
                            catatStok($produk->id_produk, 'Keluar', $item['qty'] ?? 1, $stokLama, $produk->stok, 'Penjualan pada perubahan transaksi', null, $id, 'Transaksi');
                        }
                    }
                }
            }
        }

        if ($data['status'] === 'Lunas') {
            $transaksi = Transaksi::with('booking')->find($id);
            if ($transaksi && $transaksi->booking && $transaksi->booking->status !== 'selesai') {
                $transaksi->booking->update(['status' => 'selesai', 'jam_selesai_aktual' => now()]);
            }
        }

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil diperbarui');
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
