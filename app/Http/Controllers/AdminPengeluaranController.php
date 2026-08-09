<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Supplier;
use App\Models\Produk;
use App\Models\Stok;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;

class AdminPengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?: now()->format('Y-m');
        $kategori = $request->kategori;

        $query = Pengeluaran::with('user');

        if ($bulan) {
            $query->where('tanggal', 'like', $bulan . '%');
        }

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $pengeluaran = $query->orderBy('tanggal', 'desc')
            ->orderBy('id_pengeluaran', 'desc')
            ->paginate(15)
            ->withQueryString();

        $totalBulanIni = Pengeluaran::where('tanggal', 'like', now()->format('Y-m') . '%')->sum('nominal');
        $totalSemua = Pengeluaran::sum('nominal');
        $totalKasir = Pengeluaran::count();

        $kategoris = Pengeluaran::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('admin.pengeluaran.index', compact(
            'pengeluaran', 'totalBulanIni', 'totalSemua', 'totalKasir', 'kategoris', 'bulan', 'kategori'
        ));
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

        return view('admin.pengeluaran.pembelian', compact('supplier', 'supplierData'));
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

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' mencatat pembelian stok dari ' . $supplier->nm_supplier . ' sebesar Rp ' . number_format((int) $request->total, 0, ',', '.'), 'Pengeluaran', $pengeluaran->id_pengeluaran);

        return redirect()->route('admin.pengeluaran.index')
            ->with('success', 'Pembelian stok berhasil dicatat! Stok produk telah ditambahkan.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string|max:100',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:500',
            'id_user' => 'nullable|integer',
        ]);

        $pengeluaran = Pengeluaran::create([
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan ?? '',
            'nominal' => (int) $request->nominal,
            'id_user' => $request->id_user ?: auth()->id(),
        ]);

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' mencatat pengeluaran ' . $request->kategori . ' sebesar Rp ' . number_format($request->nominal, 0, ',', '.'), 'Pengeluaran', $pengeluaran->id_pengeluaran);

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran berhasil dicatat!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string|max:100',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $pengeluaran = Pengeluaran::findOrFail($id);

        $pengeluaran->update([
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan ?? '',
            'nominal' => (int) $request->nominal,
        ]);

        ActivityLogger::log('Mengubah', auth()->user()->nama . ' mengubah pengeluaran #' . $id, 'Pengeluaran', $id);

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        ActivityLogger::log('Menghapus', auth()->user()->nama . ' menghapus pengeluaran #' . $id, 'Pengeluaran', $id);

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}
