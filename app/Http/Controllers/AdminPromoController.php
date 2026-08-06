<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Promo;
use Illuminate\Http\Request;

class AdminPromoController extends Controller
{
    protected const PREFIX_KODE = [
        'Diskon' => 'DSK',
        'Cashback' => 'CB',
        'Paket' => 'PKT',
        'Buy 1 Get 1' => 'BOGO',
        'Lainnya' => 'LNY',
    ];

    public function index()
    {
        Promo::whereDate('selesai', '<', now()->toDateString())->delete();

        $promos = Promo::withCount(['promoLayanan', 'promoProduk'])
            ->orderBy('id_promo', 'desc')
            ->get();

        return view('admin.promo.index', compact('promos'));
    }

    public function create()
    {
        $layanans = Layanan::where('status', 'Tersedia')->orderBy('nm_layanan')->get();
        $produks = Produk::where('status', 'Tersedia')->orderBy('nm_produk')->get();
        $pelanggans = Pelanggan::orderBy('nm_pelanggan')->get();

        return view('admin.promo.create', compact('layanans', 'produks', 'pelanggans'));
    }

    public function store(Request $request)
    {
        $data = $this->validasi($request);

        $promo = Promo::create($data);

        if (empty($promo->kode_promo)) {
            $prefix = self::PREFIX_KODE[$promo->jenis_promo] ?? 'PRO';
            $promo->update([
                'kode_promo' => $prefix . '-' . str_pad($promo->id_promo, 3, '0', STR_PAD_LEFT),
            ]);
        }

        $this->syncItems($promo, $request);

        buatNotif(auth()->id(), 'Promo Ditambahkan', 'Promo ' . $request->nm_promo . ' berhasil ditambahkan', 'Promo', route('admin.promo.index'));

        return redirect()->route('admin.promo.index')
            ->with('success', 'Promo berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $promo = Promo::with(['promoLayanan', 'promoProduk', 'targetPelanggan'])->findOrFail($id);
        $layanans = Layanan::where('status', 'Tersedia')->orderBy('nm_layanan')->get();
        $produks = Produk::where('status', 'Tersedia')->orderBy('nm_produk')->get();
        $pelanggans = Pelanggan::orderBy('nm_pelanggan')->get();

        return view('admin.promo.edit', compact('promo', 'layanans', 'produks', 'pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validasi($request);

        $promo = Promo::findOrFail($id);
        $promo->update($data);

        if (empty($promo->kode_promo)) {
            $prefix = self::PREFIX_KODE[$promo->jenis_promo] ?? 'PRO';
            $promo->update([
                'kode_promo' => $prefix . '-' . str_pad($promo->id_promo, 3, '0', STR_PAD_LEFT),
            ]);
        }

        $this->syncItems($promo, $request);

        buatNotif(auth()->id(), 'Promo Diperbarui', 'Promo ' . $promo->nm_promo . ' berhasil diperbarui', 'Promo', route('admin.promo.edit', $promo->id_promo));

        return redirect()->route('admin.promo.index')
            ->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $nm = $promo->nm_promo;

        $promo->promoLayanan()->delete();
        $promo->promoProduk()->delete();
        $promo->targetPelanggan()->delete();
        $promo->delete();

        buatNotif(auth()->id(), 'Promo Dihapus', 'Promo ' . $nm . ' berhasil dihapus dari sistem', 'Promo', route('admin.promo.index'));

        return redirect()->route('admin.promo.index')
            ->with('success', 'Promo berhasil dihapus.');
    }

    protected function validasi(Request $request): array
    {
        $request->validate([
            'nm_promo'     => 'required|string|max:100',
            'kode_promo'   => 'nullable|string|max:30|unique:promo,kode_promo,' . ($request->route('id') ?? 0),
            'jenis_promo'  => 'required|in:Diskon,Cashback,Paket,Buy 1 Get 1,Lainnya',
            'nilai'        => 'required|numeric|min:0',
            'mulai'        => 'required|date',
            'selesai'      => 'required|date|after_or_equal:mulai',
            'status'       => 'required|in:Tersedia,Belum_tersedia,Berakhir',
            'deskripsi'    => 'nullable|string',
            'target'       => 'required|in:semua,membership,pilih',
            'id_layanan'   => 'nullable|array',
            'id_layanan.*' => 'integer|exists:layanan,id_layanan',
            'id_produk'    => 'nullable|array',
            'id_produk.*'  => 'integer|exists:produk,id_produk',
            'id_pelanggan' => 'nullable|array',
            'id_pelanggan.*' => 'integer|exists:pelanggan,id_pelanggan',
        ]);

        return [
            'nm_promo'    => $request->nm_promo,
            'kode_promo'  => $request->filled('kode_promo') ? strtoupper($request->kode_promo) : null,
            'jenis_promo' => $request->jenis_promo,
            'nilai'       => $request->nilai,
            'deskripsi'   => $request->deskripsi ?? null,
            'mulai'       => $request->mulai,
            'selesai'     => $request->selesai,
            'status'      => $request->status,
            'target'      => $request->target,
        ];
    }

    protected function syncItems(Promo $promo, Request $request): void
    {
        $promo->promoLayanan()->delete();
        foreach ($request->id_layanan ?? [] as $id) {
            $promo->promoLayanan()->create(['id_layanan' => $id]);
        }

        $promo->promoProduk()->delete();
        foreach ($request->id_produk ?? [] as $id) {
            $promo->promoProduk()->create(['id_produk' => $id]);
        }

        $promo->targetPelanggan()->delete();
        if ($request->target === 'pilih') {
            foreach ($request->id_pelanggan ?? [] as $id) {
                $promo->targetPelanggan()->create(['id_pelanggan' => $id]);
            }
        }
    }
}
