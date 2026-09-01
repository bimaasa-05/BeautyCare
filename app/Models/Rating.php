<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $fillable = [
        'id_user',
        'id_pelanggan',
        'tipe',
        'id_target',
        'bintang',
        'komentar',
        'status',
    ];

    protected $casts = [
        'bintang' => 'integer',
    ];

    public const TIPE_LAYANAN = 'layanan';
    public const TIPE_PRODUK = 'produk';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_target', 'id_layanan')
            ->where('tipe', self::TIPE_LAYANAN);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_target', 'id_produk')
            ->where('tipe', self::TIPE_PRODUK);
    }

    public function getNamaPemberiAttribute(): string
    {
        return $this->user?->nama ?? ($this->pelanggan?->nm_pelanggan ?? 'Pelanggan');
    }

    public function getFotoPemberiAttribute(): string
    {
        if ($this->user) {
            return $this->user->foto_url;
        }
        return $this->pelanggan?->foto_url ?? 'https://ui-avatars.com/api/?name=P&background=FF4F87&color=fff&size=140';
    }

    public function getNamaObjekAttribute(): string
    {
        if ($this->tipe === self::TIPE_LAYANAN) {
            $objek = Layanan::find($this->id_target);
            return $objek?->nm_layanan ?? 'Layanan';
        }
        $objek = Produk::find($this->id_target);
        return $objek?->nm_produk ?? 'Produk';
    }

    public function getTipeLabelAttribute(): string
    {
        return $this->tipe === self::TIPE_LAYANAN ? 'Layanan' : 'Produk';
    }

    public function getTingkatMemberAttribute(): ?string
    {
        return $this->pelanggan?->membershipAktif()?->tingkat;
    }

    /**
     * Ringkasan rating sebuah objek: rata-rata, jumlah, distribusi per bintang.
     */
    public static function ringkasan(string $tipe, $idTarget): array
    {
        $data = static::where('tipe', $tipe)
            ->where('id_target', (int) $idTarget)
            ->where('status', 'aktif')
            ->selectRaw('COALESCE(AVG(bintang), 0) as rata, COUNT(*) as jumlah')
            ->first();

        $distribusi = static::where('tipe', $tipe)
            ->where('id_target', (int) $idTarget)
            ->where('status', 'aktif')
            ->selectRaw('bintang, COUNT(*) as total')
            ->groupBy('bintang')
            ->pluck('total', 'bintang');

        $dist = [];
        for ($b = 5; $b >= 1; $b--) {
            $dist[$b] = (int) ($distribusi[$b] ?? 0);
        }

        return [
            'rata' => round((float) ($data->rata ?? 0), 1),
            'jumlah' => (int) ($data->jumlah ?? 0),
            'distribusi' => $dist,
        ];
    }

    /**
     * Ulasan terbaru sebuah objek.
     */
    public static function terbaru(string $tipe, $idTarget, int $limit = 10)
    {
        return static::with(['user', 'pelanggan.membership'])
            ->where('tipe', $tipe)
            ->where('id_target', (int) $idTarget)
            ->where('status', 'aktif')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Ulasan terbaru semua objek (untuk landing page & halaman "Lihat Semua Ulasan").
     */
    public static function semuaTerbaru(int $limit = 20)
    {
        return static::with(['user', 'pelanggan.membership'])
            ->where('status', 'aktif')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Ringkasan keseluruhan (semua layanan + produk).
     */
    public static function ringkasanGlobal(): array
    {
        $data = static::where('status', 'aktif')
            ->selectRaw('COALESCE(AVG(bintang), 0) as rata, COUNT(*) as jumlah')
            ->first();

        $distribusi = static::where('status', 'aktif')
            ->selectRaw('bintang, COUNT(*) as total')
            ->groupBy('bintang')
            ->pluck('total', 'bintang');

        $dist = [];
        for ($b = 5; $b >= 1; $b--) {
            $dist[$b] = (int) ($distribusi[$b] ?? 0);
        }

        return [
            'rata' => round((float) ($data->rata ?? 0), 1),
            'jumlah' => (int) ($data->jumlah ?? 0),
            'distribusi' => $dist,
        ];
    }

    /**
     * Booking selesai terbaru milik pelanggan yang berisi layanan tsb
     * (dipakai untuk tombol rating pada dashboard pelanggan).
     */
    public static function bookingLayananTerbaru($idPelanggan, $idLayanan): ?Booking
    {
        return DetailBooking::where('id_layanan', (int) $idLayanan)
            ->whereHas('booking', function ($q) use ($idPelanggan) {
                $q->where('id_pelanggan', (int) $idPelanggan)
                    ->where('status', 'selesai');
            })
            ->with('booking')
            ->get()
            ->sortByDesc(fn($d) => $d->booking?->id_booking ?? 0)
            ->first()?->booking;
    }

    public static function sudahRating($userId, string $tipe, $idTarget): bool
    {
        return static::where('id_user', (int) $userId)
            ->where('tipe', $tipe)
            ->where('id_target', (int) $idTarget)
            ->exists();
    }

    public static function ratingSaya($userId, string $tipe, $idTarget): ?self
    {
        return static::where('id_user', (int) $userId)
            ->where('tipe', $tipe)
            ->where('id_target', (int) $idTarget)
            ->first();
    }

    /**
     * Apakah pelanggan berhak memberi rating sebuah layanan
     * (punya booking dengan status selesai yang berisi layanan tsb).
     */
    public static function bisaRatingLayanan($idPelanggan, $idLayanan): bool
    {
        return DetailBooking::where('id_layanan', (int) $idLayanan)
            ->whereHas('booking', function ($q) use ($idPelanggan) {
                $q->where('id_pelanggan', (int) $idPelanggan)
                    ->where('status', 'selesai');
            })
            ->exists();
    }

    /**
     * Apakah pelanggan berhak memberi rating sebuah produk
     * (punya transaksi Lunas yang berisi produk tsb).
     */
    public static function bisaRatingProduk($idPelanggan, $idProduk): bool
    {
        return DetailTransaksi::where('jenis', 'Produk')
            ->where('id_item', (int) $idProduk)
            ->whereHas('transaksi', function ($q) use ($idPelanggan) {
                $q->where('id_pelanggan', (int) $idPelanggan)
                    ->where('status', 'Lunas');
            })
            ->exists();
    }

    /**
     * Daftar layanan & produk yang sudah pernah dipakai/dibeli pelanggan
     * tetapi belum diberi rating oleh user tsb. Untuk dashboard pelanggan.
     */
    public static function belumDirating($userId, $idPelanggan): array
    {
        $sudahRatingLayanan = static::where('id_user', (int) $userId)
            ->where('tipe', self::TIPE_LAYANAN)
            ->pluck('id_target')
            ->toArray();

        $layananIds = DetailBooking::whereHas('booking', function ($q) use ($idPelanggan) {
            $q->where('id_pelanggan', (int) $idPelanggan)->where('status', 'selesai');
        })
            ->pluck('id_layanan')
            ->unique()
            ->values()
            ->toArray();

        $layananBelum = collect();
        if ($layananIds) {
            $idsBelum = array_values(array_diff($layananIds, $sudahRatingLayanan));
            if ($idsBelum) {
                $layananBelum = Layanan::whereIn('id_layanan', $idsBelum)->get();

                $bookingTerbaru = DetailBooking::whereIn('id_layanan', $idsBelum)
                    ->whereHas('booking', function ($q) use ($idPelanggan) {
                        $q->where('id_pelanggan', (int) $idPelanggan)->where('status', 'selesai');
                    })
                    ->with('booking')
                    ->get()
                    ->sortByDesc(fn($d) => $d->booking?->id_booking ?? 0)
                    ->groupBy('id_layanan');

                $layananBelum->each(function ($layanan) use ($bookingTerbaru) {
                    $detail = $bookingTerbaru->get($layanan->id_layanan)?->first();
                    $layanan->booking_id = $detail?->booking?->id_booking;
                });
            }
        }

        $sudahRatingProduk = static::where('id_user', (int) $userId)
            ->where('tipe', self::TIPE_PRODUK)
            ->pluck('id_target')
            ->toArray();

        $produkIds = DetailTransaksi::where('jenis', 'Produk')
            ->whereHas('transaksi', function ($q) use ($idPelanggan) {
                $q->where('id_pelanggan', (int) $idPelanggan)->where('status', 'Lunas');
            })
            ->pluck('id_item')
            ->unique()
            ->values()
            ->toArray();

        $produkBelum = collect();
        if ($produkIds) {
            $idsBelum = array_values(array_diff($produkIds, $sudahRatingProduk));
            if ($idsBelum) {
                $produkBelum = Produk::whereIn('id_produk', $idsBelum)->get();
            }
        }

        return [
            'layanan' => $layananBelum,
            'produk' => $produkBelum,
        ];
    }
}