<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Halaman "Lihat Semua Ulasan" (publik).
     */
    public function index()
    {
        $ringkasan = Rating::ringkasanGlobal();
        $ulasans = Rating::semuaTerbaru(50);

        return view('landing.ulasan', compact('ringkasan', 'ulasans'));
    }

    /**
     * Simpan / perbarui rating (upsert). Hanya pelanggan yang punya riwayat
     * nyata (booking selesai / transaksi Lunas) yang berhak.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipe' => ['required', 'in:layanan,produk'],
            'id_target' => ['required', 'integer'],
            'bintang' => ['required', 'integer', 'between:1,5'],
            'komentar' => ['nullable', 'string', 'max:500'],
        ]);

        $tipe = $request->tipe;
        $idTarget = (int) $request->id_target;
        $userId = (int) auth()->id();

        if ($tipe === Rating::TIPE_LAYANAN) {
            $objek = Layanan::where('status', 'Tersedia')->find($idTarget);
            if (!$objek) {
                return back()->with('error', 'Layanan tidak ditemukan.');
            }
        } else {
            $objek = Produk::where('status', 'Tersedia')->find($idTarget);
            if (!$objek) {
                return back()->with('error', 'Produk tidak ditemukan.');
            }
        }

        $pelanggan = Pelanggan::dariUser(auth()->user());
        if (!$pelanggan) {
            return back()->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $bisaRating = $tipe === Rating::TIPE_LAYANAN
            ? Rating::bisaRatingLayanan($pelanggan->id_pelanggan, $idTarget)
            : Rating::bisaRatingProduk($pelanggan->id_pelanggan, $idTarget);

        if (!$bisaRating) {
            return back()->with('error', 'Anda hanya bisa memberi rating setelah menyelesaikan treatment / pembelian layanan atau produk tersebut.');
        }

        $rating = Rating::updateOrCreate(
            [
                'id_user' => $userId,
                'tipe' => $tipe,
                'id_target' => $idTarget,
            ],
            [
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'bintang' => (int) $request->bintang,
                'komentar' => $request->komentar ? trim($request->komentar) : null,
                'status' => 'aktif',
            ]
        );

        $dibuat = $rating->wasRecentlyCreated;

        $pesan = $dibuat
            ? 'Terima kasih! Rating Anda berhasil dikirim.'
            : 'Rating Anda berhasil diperbarui.';

        if ($tipe === Rating::TIPE_LAYANAN) {
            buatNotifRole('admin', 'Rating Layanan Baru', auth()->user()->nama . ' memberi rating ' . $rating->bintang . ' bintang untuk layanan "' . ($objek->nm_layanan ?? '') . '".', 'Lainnya', url('/admin/riwayat'));
        } else {
            buatNotifRole('admin', 'Rating Produk Baru', auth()->user()->nama . ' memberi rating ' . $rating->bintang . ' bintang untuk produk "' . ($objek->nm_produk ?? '') . '".', 'Lainnya', url('/admin/riwayat'));
        }

        return back()->with('success', $pesan);
    }

    /**
     * Hapus rating milik sendiri.
     */
    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);

        if ((int) $rating->id_user !== (int) auth()->id()) {
            abort(403);
        }

        $rating->delete();

        return back()->with('success', 'Rating berhasil dihapus.');
    }
}