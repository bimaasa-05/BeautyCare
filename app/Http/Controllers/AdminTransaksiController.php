<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\DetailTransaksi;
use App\Models\Layanan;
use App\Models\Produk;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;

class AdminTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $dari    = $request->dari;
        $sampai  = $request->sampai;

        $transaksi = Transaksi::with('pelanggan', 'detail', 'user')
            ->when($keyword, function ($q, $keyword) {
                return $q->where(function ($q) use ($keyword) {
                    $q->where('no_invoice', 'like', "%{$keyword}%")
                        ->orWhereHas('pelanggan', function ($q) use ($keyword) {
                            $q->where('nm_pelanggan', 'like', "%{$keyword}%")
                                ->orWhere('no_hp', 'like', "%{$keyword}%");
                        });
                });
            })
            ->when($dari, fn($q, $d) => $q->whereDate('tanggal', '>=', $d))
            ->when($sampai, fn($q, $s) => $q->whereDate('tanggal', '<=', $s))
            ->orderBy('id_transaksi', 'desc')
            ->paginate(15);

        $totalTransaksi  = Transaksi::count();
        $totalPendapatan = Transaksi::where('status', 'Lunas')->sum('total');

        return view('admin.transaksi.index', compact(
            'transaksi',
            'totalTransaksi',
            'totalPendapatan'
        ));
    }

    public function create()
    {
        $pelanggan = Pelanggan::with('membership')->get();
        $layanan   = Layanan::where('status', 1)->get();
        $produk    = Produk::where('status', 1)->get();

        $bankTujuan = [
            'BRI' => '10101010',
            'BCA' => '20202020',
            'Mandiri' => '30303030',
            'BNI' => '40404040',
            'BSI' => '50505050',
        ];

        return view('admin.transaksi.create', compact('pelanggan', 'layanan', 'produk', 'bankTujuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|integer',
            'tanggal'      => 'required|date',
            'subtotal'     => 'required|numeric|min:0',
            'diskon'       => 'nullable|numeric|min:0',
            'pajak'        => 'nullable|numeric|min:0',
            'total'        => 'required|numeric|min:0',
            'metode_byr'   => 'required|in:Tunai,Transfer,Debit,E-Wallet',
            'dibayar'      => 'required|numeric|min:0',
            'kembali'      => 'required|numeric|min:0',
            'catatan'      => 'nullable|string',
            'bukti_bayar'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'atas_nama'    => 'nullable|string|max:100',
            'dari_rekening'=> 'nullable|string|max:50',
            'ke_rekening'  => 'nullable|string|max:50',
            'bank_asal'    => 'nullable|string|max:50',
            'bank_tujuan'  => 'nullable|string|max:50',
            'no_referensi' => 'nullable|string|max:50',
            'ewallet_type' => 'nullable|string|max:50',
        ]);

        $lastId   = Transaksi::max('id_transaksi') + 1;
        $no_invoice = 'INV-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        $data = [
            'id_booking'   => $lastId,
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
            'status'       => in_array($request->metode_byr, ['Tunai', 'E-Wallet']) ? 'Lunas' : 'Pending',
            'atas_nama'    => $request->atas_nama,
            'dari_rekening'=> $request->dari_rekening,
            'ke_rekening'  => $request->ke_rekening,
            'bank_asal'    => $request->bank_asal ?? $request->ewallet_type,
            'bank_tujuan'  => $request->bank_tujuan,
            'no_referensi' => $request->no_referensi,
        ];

        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('uploads/bukti_bayar', 'public');
        }

        $transaksi = Transaksi::create($data);

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
                    ]);

                    if (($item['jenis'] ?? 'Layanan') === 'Produk') {
                        $produk = Produk::find($item['id_item']);
                        if ($produk && $produk->stok >= ($item['qty'] ?? 1)) {
                            $produk->decrement('stok', $item['qty'] ?? 1);
                        }
                    }
                }
            }
        }

        $msg = in_array($request->metode_byr, ['Tunai', 'E-Wallet'])
            ? 'Transaksi berhasil disimpan!'
            : 'Transaksi berhasil dicatat! Menunggu konfirmasi pembayaran.';

        return redirect()->route('admin.transaksi.index')->with('success', $msg);
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'detail')->findOrFail($id);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with('detail')->findOrFail($id);
        $pelanggan = Pelanggan::with('membership')->get();
        $layanan   = Layanan::where('status', 1)->get();
        $produk    = Produk::where('status', 1)->get();

        $bankTujuan = [
            'BRI' => '10101010',
            'BCA' => '20202020',
            'Mandiri' => '30303030',
            'BNI' => '40404040',
            'BSI' => '50505050',
        ];

        return view('admin.transaksi.edit', compact('transaksi', 'pelanggan', 'layanan', 'produk', 'bankTujuan'));
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
            'metode_byr'   => 'required|in:Tunai,Transfer,Debit,E-Wallet',
            'dibayar'      => 'required|numeric|min:0',
            'kembali'      => 'required|numeric|min:0',
            'catatan'      => 'nullable|string',
            'bukti_bayar'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'atas_nama'    => 'nullable|string|max:100',
            'dari_rekening'=> 'nullable|string|max:50',
            'ke_rekening'  => 'nullable|string|max:50',
            'bank_asal'    => 'nullable|string|max:50',
            'bank_tujuan'  => 'nullable|string|max:50',
            'no_referensi' => 'nullable|string|max:50',
            'ewallet_type' => 'nullable|string|max:50',
            'status'       => 'nullable|in:Lunas,Pending,Batal',
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
            'atas_nama'    => $request->atas_nama,
            'dari_rekening'=> $request->dari_rekening,
            'ke_rekening'  => $request->ke_rekening,
            'bank_asal'    => $request->bank_asal ?? $request->ewallet_type,
            'bank_tujuan'  => $request->bank_tujuan,
            'no_referensi' => $request->no_referensi,
        ];

        if ($request->filled('status')) {
            $data['status'] = $request->status;
        } elseif (in_array($request->metode_byr, ['Tunai', 'E-Wallet'])) {
            $data['status'] = 'Lunas';
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

        ActivityLogger::log('Mengubah', auth()->user()->nama . ' mengubah transaksi ' . $transaksiLama->no_invoice, 'Transaksi', $id, $dataLama, $data);

        if ($request->has('items') && is_array($request->items)) {
            $oldDetails = DetailTransaksi::where('id_transaksi', $id)->get();
            foreach ($oldDetails as $old) {
                if ($old->jenis === 'Produk') {
                    $produk = Produk::find($old->id_item);
                    if ($produk) {
                        $produk->increment('stok', $old->qty);
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
                    ]);

                    if (($item['jenis'] ?? 'Layanan') === 'Produk') {
                        $produk = Produk::find($item['id_item']);
                        if ($produk && $produk->stok >= ($item['qty'] ?? 1)) {
                            $produk->decrement('stok', $item['qty'] ?? 1);
                        }
                    }
                }
            }
        }

        if ($data['status'] === 'Lunas') {
            $transaksi = Transaksi::with('booking')->find($id);
            if ($transaksi && $transaksi->booking && $transaksi->booking->status !== 'selesai') {
                $transaksi->booking->update(['status' => 'selesai']);
            }
        }

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function invoice($id)
    {
        $transaksi = Transaksi::with('pelanggan', 'detail', 'user')->findOrFail($id);
        return view('kasir.invoice.show', compact('transaksi'));
    }

    public function export(Request $request)
    {
        $keyword = $request->keyword;
        $dari    = $request->dari;
        $sampai  = $request->sampai;

        $transaksi = Transaksi::with('pelanggan', 'detail', 'user')
            ->when($keyword, function ($q, $keyword) {
                return $q->where(function ($q) use ($keyword) {
                    $q->where('no_invoice', 'like', "%{$keyword}%")
                        ->orWhereHas('pelanggan', function ($q) use ($keyword) {
                            $q->where('nm_pelanggan', 'like', "%{$keyword}%")
                                ->orWhere('no_hp', 'like', "%{$keyword}%");
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

        $columns = ['No. Invoice', 'Pelanggan', 'Tanggal', 'Subtotal', 'Diskon', 'Pajak', 'Total', 'Metode', 'Dibayar', 'Kembali', 'Status', 'Admin', 'Catatan'];

        $callback = function () use ($transaksi, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, $columns);

            foreach ($transaksi as $t) {
                fputcsv($file, [
                    $t->no_invoice,
                    $t->pelanggan->nm_pelanggan ?? '-',
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

    public function destroy($id)
    {
        $transaksi = Transaksi::with('detail')->findOrFail($id);

        ActivityLogger::log('Menghapus', auth()->user()->nama . ' menghapus transaksi ' . $transaksi->no_invoice, 'Transaksi', $id);

        foreach ($transaksi->detail as $detail) {
            if ($detail->jenis === 'Produk') {
                $produk = Produk::find($detail->id_item);
                if ($produk) {
                    $produk->increment('stok', $detail->qty);
                }
            }
        }

        if ($transaksi->bukti_bayar) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($transaksi->bukti_bayar);
        }
        $transaksi->delete();

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
