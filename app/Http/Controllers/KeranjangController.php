<?php

namespace App\Http\Controllers;

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
        if ($request->nm_produk) {
            buatNotif(auth()->id(), 'Pembelian Langsung', 'Pembelian ' . $request->nm_produk . ' (' . $request->qty . ' pcs) via ' . $request->metode . ' berhasil', 'Transaksi', route('pelanggan.produk'));

            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                buatNotif($admin->id, 'Pembelian Langsung', auth()->user()->nama . ' membeli ' . $request->nm_produk . ' (' . $request->qty . ' pcs) via ' . $request->metode, 'Transaksi', url('/admin/dashboard'));
            }

            Troli::where('id_user', auth()->id())
                ->where('nm_produk', $request->nm_produk)
                ->delete();
        } else {
            $itemCount = Troli::where('id_user', auth()->id())->count();

            buatNotif(auth()->id(), 'Checkout Berhasil', $itemCount . ' produk berhasil di-checkout', 'Transaksi', route('pelanggan.produk'));

            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                buatNotif($admin->id, 'Checkout Pelanggan', auth()->user()->nama . ' melakukan checkout ' . $itemCount . ' produk', 'Transaksi', url('/admin/dashboard'));
            }

            Troli::where('id_user', auth()->id())->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Checkout berhasil!',
        ]);
    }
}
