<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promo';
    protected $primaryKey = 'id_promo';
    public $timestamps = false;

    protected $fillable = [
        'nm_promo',
        'kode_promo',
        'jenis_promo',
        'nilai',
        'deskripsi',
        'mulai',
        'selesai',
        'status',
        'target',
    ];

    public function klaim()
    {
        return $this->hasMany(PromoKlaim::class, 'id_promo', 'id_promo');
    }

    public function promoLayanan()
    {
        return $this->hasMany(PromoLayanan::class, 'id_promo', 'id_promo');
    }

    public function promoProduk()
    {
        return $this->hasMany(PromoProduk::class, 'id_promo', 'id_promo');
    }

    public function targetPelanggan()
    {
        return $this->hasMany(PromoTarget::class, 'id_promo', 'id_promo');
    }

    public function berlakuUntuk(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        if ($this->target === 'semua') {
            return true;
        }

        $pelanggan = Pelanggan::dariUser($user);
        if (!$pelanggan) {
            return false;
        }

        if ($this->target === 'membership') {
            return $pelanggan->membershipAktif() !== null;
        }

        return PromoTarget::where('id_promo', $this->id_promo)
            ->where('id_pelanggan', $pelanggan->id_pelanggan)
            ->exists();
    }

    public function itemEligible(string $jenis, $idItem): bool
    {
        $idsLayanan = array_map('intval', $this->promoLayanan->pluck('id_layanan')->all());
        $idsProduk = array_map('intval', $this->promoProduk->pluck('id_produk')->all());
        $kosong = empty($idsLayanan) && empty($idsProduk);

        if ($jenis === 'Produk') {
            if ($this->jenis_promo === 'Paket') {
                return false;
            }
            if ($kosong) {
                return true;
            }
            return in_array((int) $idItem, $idsProduk);
        }

        if ($this->jenis_promo === 'Buy 1 Get 1') {
            return false;
        }
        if ($kosong) {
            return true;
        }
        return in_array((int) $idItem, $idsLayanan);
    }

    /**
     * Hitung diskon hanya atas item yang termasuk dalam promo.
     * $items = [['jenis' => 'Layanan'|'Produk', 'id_item' => int, 'subtotal' => int], ...]
     */
    public function hitungDiskon(array $items): int
    {
        $eligible = 0;

        foreach ($items as $item) {
            $jenis = $item['jenis'] ?? 'Layanan';
            $idItem = $item['id_item'] ?? $item['id_produk'] ?? 0;
            if ($this->itemEligible($jenis, $idItem)) {
                $eligible += (int) ($item['subtotal'] ?? 0);
            }
        }

        if ($eligible <= 0) {
            return 0;
        }

        if ($this->jenis_promo === 'Diskon') {
            return (int) round($eligible * $this->nilai / 100);
        }

        if ($this->jenis_promo === 'Cashback') {
            return 0; // cashback bukan diskon; dikredit ke saldo setelah Lunas
        }

        return (int) round(min($this->nilai, $eligible));
    }

    public function itemLabels(): array
    {
        return [
            'layanan' => $this->promoLayanan->map(fn ($pl) => $pl->layanan->nm_layanan ?? null)->filter()->values()->all(),
            'produk' => $this->promoProduk->map(fn ($pp) => $pp->produk->nm_produk ?? null)->filter()->values()->all(),
        ];
    }

    public function targetLabel(): string
    {
        return match ($this->target) {
            'membership' => 'Khusus Membership',
            'pilih' => 'Pelanggan Terpilih',
            default => 'Semua Pelanggan',
        };
    }
}
