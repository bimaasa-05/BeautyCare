<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Troli;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $troli = Troli::where('id_user', auth()->id())->latest()->get();
        $total = $troli->sum('total_harga');

        if (request()->ajax()) {
            return response()->json([
                'count' => $troli->count(),
                'total' => $total,
            ]);
        }

        return view('pelanggan.keranjang.index', compact('troli', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_produk' => 'required|string',
            'produk_slug' => 'required|string',
            'kategori' => 'required|string',
            'harga_satuan' => 'required|integer',
            'qty' => 'required|integer|min:1',
        ]);

        $qty = (int) $request->qty;
        $harga = (int) $request->harga_satuan;
        $total = $harga * $qty;

        $existing = Troli::where('id_user', auth()->id())
            ->where('nm_produk', $request->nm_produk)
            ->first();

        if ($existing) {
            $existing->increment('qty', $qty);
            $existing->total_harga = $existing->harga_satuan * $existing->qty;
            $existing->save();
        } else {
            Troli::create([
                'id_user' => auth()->id(),
                'nm_produk' => $request->nm_produk,
                'produk_slug' => $request->produk_slug,
                'kategori' => $request->kategori,
                'harga_satuan' => $harga,
                'qty' => $qty,
                'total_harga' => $total,
            ]);
        }

        $count = Troli::where('id_user', auth()->id())->count();

        buatNotif(auth()->id(), 'Produk Ditambahkan', 'Produk ' . $request->nm_produk . ' berhasil ditambahkan ke keranjang', 'Transaksi', route('pelanggan.keranjang'));

        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            buatNotif($admin->id, 'Produk Dibeli', $request->nm_produk . ' ditambahkan ke keranjang oleh ' . auth()->user()->nama, 'Transaksi', url('/admin/dashboard'));
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'count' => $count,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['qty' => 'required|integer|min:1']);

        $item = Troli::where('id', $id)->where('id_user', auth()->id())->firstOrFail();
        $item->qty = (int) $request->qty;
        $item->total_harga = $item->harga_satuan * $item->qty;
        $item->save();

        $total_all = Troli::where('id_user', auth()->id())->sum('total_harga');

        return response()->json([
            'success' => true,
            'total_item' => $item->total_harga,
            'total_all' => $total_all,
        ]);
    }

    public function batchDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada produk yang dipilih.']);
        }

        Troli::whereIn('id', $ids)->where('id_user', auth()->id())->delete();

        $total_all = Troli::where('id_user', auth()->id())->sum('total_harga');
        $count = Troli::where('id_user', auth()->id())->count();

        buatNotif(auth()->id(), 'Produk Dihapus', count($ids) . ' produk berhasil dihapus dari keranjang', 'Transaksi', route('pelanggan.keranjang'));

        return response()->json([
            'success' => true,
            'message' => count($ids) . ' produk berhasil dihapus!',
            'total_all' => $total_all,
            'count' => $count,
        ]);
    }

    public function destroy($id)
    {
        Troli::where('id', $id)->where('id_user', auth()->id())->delete();

        buatNotif(auth()->id(), 'Produk Dihapus', 'Produk berhasil dihapus dari keranjang', 'Transaksi', route('pelanggan.keranjang'));

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function checkoutNotif(Request $request)
    {
        $user = auth()->user();

        $pelanggan = Pelanggan::where('email', $user->email)
            ->orWhere('nm_pelanggan', $user->nama)
            ->orWhere('id_user', $user->id)
            ->first();

        if (!$pelanggan) {
            $pelanggan = Pelanggan::create([
                'nm_pelanggan' => $user->nama,
                'email' => $user->email,
                'no_hp' => $user->no_hp ?? '',
                'alamat' => '',
                'catatan_alergi' => '',
                'id_user' => $user->id,
                'id_member' => 1,
            ]);
        }

        $lastId = Transaksi::max('id_transaksi') + 1;
        $no_invoice = 'INV-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);
        $metode = $request->metode ?? 'Transfer';
        $items = [];

        if ($request->nm_produk) {
            $produkId = $request->id_produk;
            $produk = null;
            if ($produkId) {
                $produk = Produk::find($produkId);
            }
            if (!$produk) {
                $produk = Produk::where('nm_produk', $request->nm_produk)->first();
            }
            if ($produk) {
                $qty = (int) $request->qty;
                $items[] = [
                    'jenis' => 'Produk',
                    'id_item' => $produk->id_produk,
                    'nm_item' => $produk->nm_produk,
                    'qty' => $qty,
                    'harga' => $produk->harga_jual,
                    'subtotal' => $produk->harga_jual * $qty,
                ];
            }
        } else {
            $troliItems = Troli::where('id_user', $user->id)->get();
            foreach ($troliItems as $tItem) {
                $produk = Produk::where('nm_produk', $tItem->nm_produk)->first();
                $items[] = [
                    'jenis' => 'Produk',
                    'id_item' => $produk ? $produk->id_produk : 0,
                    'nm_item' => $tItem->nm_produk,
                    'qty' => $tItem->qty,
                    'harga' => $tItem->harga_satuan,
                    'subtotal' => $tItem->total_harga,
                ];
            }
        }

        if (empty($items)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada produk untuk diproses.',
            ], 400);
        }

        $subtotal = collect($items)->sum('subtotal');
        $total = $subtotal;

        $transaksi = Transaksi::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'id_user' => $user->id,
            'no_invoice' => $no_invoice,
            'tanggal' => now()->toDateString(),
            'subtotal' => $subtotal,
            'diskon' => 0,
            'pajak' => 0,
            'total' => $total,
            'metode_byr' => $metode,
            'dibayar' => $total,
            'kembali' => 0,
            'catatan' => '',
            'status' => 'Lunas',
        ]);

        foreach ($items as $item) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'jenis' => $item['jenis'],
                'id_item' => $item['id_item'],
                'nm_item' => $item['nm_item'],
                'qty' => $item['qty'],
                'harga' => $item['harga'],
                'diskon' => 0,
                'subtotal' => $item['subtotal'],
            ]);

            if ($item['jenis'] === 'Produk' && $item['id_item'] > 0) {
                $produk = Produk::find($item['id_item']);
                if ($produk && $produk->stok >= $item['qty']) {
                    $produk->decrement('stok', $item['qty']);
                }
            }
        }

        if ($request->nm_produk) {
            buatNotif($user->id, 'Pembelian Langsung', 'Pembelian ' . $request->nm_produk . ' (' . $request->qty . ' pcs) via ' . $metode . ' berhasil', 'Transaksi', route('pelanggan.produk'));

            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                buatNotif($admin->id, 'Pembelian Langsung', $user->nama . ' membeli ' . $request->nm_produk . ' (' . $request->qty . ' pcs) via ' . $metode, 'Transaksi', url('/admin/dashboard'));
            }
        } else {
            $itemCount = count($items);
            buatNotif($user->id, 'Checkout Berhasil', $itemCount . ' produk berhasil di-checkout', 'Transaksi', route('pelanggan.produk'));

            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                buatNotif($admin->id, 'Checkout Pelanggan', $user->nama . ' melakukan checkout ' . $itemCount . ' produk', 'Transaksi', url('/admin/dashboard'));
            }

            Troli::where('id_user', $user->id)->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Checkout berhasil!',
        ]);
    }
}
