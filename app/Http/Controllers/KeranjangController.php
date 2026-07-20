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
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}
