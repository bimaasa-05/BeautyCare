<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Produk;
use App\Models\PromoKlaim;
use App\Models\Transaksi;
use App\Models\Troli;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public static function bankTujuan()
    {
        return [
            'BRI' => '10101010',
            'BCA' => '20202020',
            'Mandiri' => '30303030',
            'BNI' => '40404040',
            'BSI' => '50505050',
        ];
    }

    public static function generateKodePembayaran($metode, $idTransaksi)
    {
        $digits = str_pad((string) $idTransaksi, 8, '0', STR_PAD_LEFT);

        if ($metode === 'Transfer') {
            return '8802' . $digits;
        }
        if ($metode === 'QRIS') {
            return 'QR-' . $digits;
        }

        return 'EP-' . $digits;
    }

    public function create(Request $request)
    {
        $items = $this->resolveItems($request);

        if (empty($items)) {
            return redirect()->route('pelanggan.keranjang')->with('error', 'Keranjang Anda kosong.');
        }

        $subtotal = collect($items)->sum('subtotal');

        $claimedPromos = PromoKlaim::with('promo')
            ->where('id_user', auth()->id())
            ->where('status', 'tersedia')
            ->get()
            ->filter(function ($klaim) {
                return $klaim->promo && $klaim->promo->jenis_promo !== 'Paket';
            });

        $bankTujuan = self::bankTujuan();

        $memberInfo = $this->hitungDiskonMember($this->getOrCreatePelanggan(auth()->user()), $subtotal);

        return view('pelanggan.checkout.index', compact('items', 'subtotal', 'claimedPromos', 'bankTujuan', 'memberInfo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'metode' => 'required|in:QRIS,Transfer,E-Wallet',
            'provider' => 'required|string|max:50',
            'id_promo' => 'nullable|integer',
            'beli' => 'nullable|integer',
            'qty' => 'nullable|integer|min:1',
        ]);

        $providers = [
            'QRIS' => ['QRIS'],
            'Transfer' => array_keys(self::bankTujuan()),
            'E-Wallet' => ['Dana', 'GoPay', 'OVO', 'ShopeePay'],
        ];

        abort_unless(in_array($request->provider, $providers[$request->metode]), 422);

        $items = $this->resolveItems($request);

        if (empty($items)) {
            return back()->with('error', 'Tidak ada produk yang valid untuk diproses.');
        }

        foreach ($items as $item) {
            $produk = Produk::find($item['id_produk']);
            if (!$produk || $produk->stok < $item['qty']) {
                return back()->with('error', 'Stok ' . $item['nm_produk'] . ' tidak mencukupi (sisa ' . ($produk->stok ?? 0) . ').');
            }
        }

        $user = auth()->user();
        $pelanggan = $this->getOrCreatePelanggan($user);

        $subtotal = collect($items)->sum('subtotal');
        $idPromo = $request->id_promo;

        $promoDiskon = $this->hitungPromo($idPromo, $user->id, $subtotal, false);
        if ($promoDiskon < 0) {
            return back()->with('error', 'Promo Paket tidak berlaku untuk pembelian produk.');
        }

        $memberInfo = $this->hitungDiskonMember($pelanggan, $subtotal);
        $memberDiskon = $memberInfo['diskon'];

        $pakaiPromo = $promoDiskon > 0 && $promoDiskon >= $memberDiskon;
        $diskon = $pakaiPromo ? $promoDiskon : $memberDiskon;

        $catatanDiskon = '';
        if ($pakaiPromo) {
            $this->tandaiPromo($idPromo, $user->id);
            $catatanDiskon = 'Diskon: Promo';
        } elseif ($memberDiskon > 0) {
            $catatanDiskon = 'Diskon: Member ' . $memberInfo['level'] . ' ' . (float) $memberInfo['diskon_pct'] . '%';
        }

        $total = $subtotal - $diskon;

        $lastId = Transaksi::max('id_transaksi') + 1;
        $noInvoice = 'INV-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        $transaksi = Transaksi::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'id_user' => $user->id,
            'sumber' => 'online',
            'no_invoice' => $noInvoice,
            'tanggal' => now()->toDateString(),
            'subtotal' => $subtotal,
            'diskon' => $promoDiskon,
            'pajak' => 0,
            'total' => $total,
            'metode_byr' => $request->provider,
            'dibayar' => 0,
            'kembali' => 0,
            'catatan' => $catatanDiskon,
            'status' => 'Menunggu Pembayaran',
        ]);

        foreach ($items as $item) {
            $itemSubtotal = $item['subtotal'];
            $itemDiskon = 0;
            $itemIdPromo = null;
            if ($diskon > 0 && $subtotal > 0) {
                $itemDiskon = (int) round($diskon * $itemSubtotal / $subtotal);
                $itemIdPromo = $pakaiPromo ? $idPromo : null;
            }
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'jenis' => 'Produk',
                'id_item' => $item['id_produk'],
                'nm_item' => $item['nm_produk'],
                'qty' => $item['qty'],
                'harga' => $item['harga_satuan'],
                'diskon' => $itemDiskon,
                'subtotal' => $itemSubtotal - $itemDiskon,
                'id_promo' => $itemIdPromo,
            ]);
        }

        $expiresAt = in_array($request->metode, ['QRIS', 'E-Wallet'])
            ? now()->addMinutes(10)
            : now()->addHours(24);

        Pembayaran::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'metode' => $request->metode,
            'provider' => $request->provider,
            'kode_pembayaran' => self::generateKodePembayaran($request->metode, $transaksi->id_transaksi),
            'nominal' => $total,
            'status' => 'Menunggu',
            'expires_at' => $expiresAt,
        ]);

        if (!$request->beli) {
            Troli::where('id_user', $user->id)->delete();
        }

        ActivityLogger::log('Menambahkan', $user->nama . ' membuat pesanan ' . $noInvoice . ' via ' . $request->provider . ' (menunggu pembayaran)', 'Transaksi', $transaksi->id_transaksi);

        buatNotif($user->id, 'Pesanan Dibuat', 'Pesanan ' . $noInvoice . ' berhasil dibuat. Silakan selesaikan pembayaran.', 'Transaksi', route('pelanggan.pembayaran.show', $transaksi->id_transaksi));

        $petugas = \App\Models\User::whereIn('role', ['kasir', 'admin'])->get();
        foreach ($petugas as $petugasUser) {
            buatNotif($petugasUser->id, 'Pesanan Baru', $user->nama . ' membuat pesanan ' . $noInvoice . ' menunggu pembayaran (' . $request->provider . ').', 'Transaksi', route('kasir.pembayaran.pesanan-online'));
        }

        return redirect()->route('pelanggan.pembayaran.show', $transaksi->id_transaksi);
    }

    protected function resolveItems(Request $request)
    {
        $items = [];

        if ($request->beli) {
            $produk = Produk::with('kategori')->find($request->beli);
            if (!$produk || $produk->status !== 'Tersedia') {
                return [];
            }
            $qty = max(1, (int) $request->qty);
            $items[] = [
                'id_produk' => $produk->id_produk,
                'nm_produk' => $produk->nm_produk,
                'kategori' => $produk->kategori->nm_produk ?? 'Produk',
                'harga_satuan' => (int) $produk->harga_jual,
                'qty' => $qty,
                'subtotal' => (int) $produk->harga_jual * $qty,
                'stok' => $produk->stok,
            ];

            return $items;
        }

        $troli = Troli::where('id_user', auth()->id())->get();

        foreach ($troli as $t) {
            $produk = $t->id_produk
                ? Produk::with('kategori')->find($t->id_produk)
                : Produk::with('kategori')->where('nm_produk', $t->nm_produk)->first();

            if (!$produk || $produk->status !== 'Tersedia' || $produk->stok <= 0) {
                continue;
            }

            $harga = (int) $produk->harga_jual;
            $items[] = [
                'id_produk' => $produk->id_produk,
                'nm_produk' => $produk->nm_produk,
                'kategori' => $produk->kategori->nm_produk ?? 'Produk',
                'harga_satuan' => $harga,
                'qty' => (int) $t->qty,
                'subtotal' => $harga * (int) $t->qty,
                'stok' => $produk->stok,
            ];
        }

        return $items;
    }

    protected function getOrCreatePelanggan($user)
    {
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

        return $pelanggan;
    }

    protected function hitungPromo($idPromo, $userId, $subtotal, $markUsed = true)
    {
        if (!$idPromo) {
            return 0;
        }

        $promoKlaim = PromoKlaim::with('promo')
            ->where('id_user', $userId)
            ->where('id_promo', $idPromo)
            ->where('status', 'tersedia')
            ->first();

        if (!$promoKlaim) {
            return 0;
        }

        $promo = $promoKlaim->promo;
        $diskon = 0;

        if ($promo->jenis_promo === 'Paket') {
            return -1;
        }

        if ($promo->jenis_promo === 'Diskon') {
            $diskon = (int) round($subtotal * $promo->nilai / 100);
        } else {
            $diskon = (int) round(min($promo->nilai, $subtotal));
        }

        if ($markUsed) {
            $this->tandaiPromo($idPromo, $userId);
        }

        return $diskon;
    }

    protected function tandaiPromo($idPromo, $userId)
    {
        if (!$idPromo) {
            return;
        }

        PromoKlaim::where('id_user', $userId)
            ->where('id_promo', $idPromo)
            ->where('status', 'tersedia')
            ->update(['status' => 'digunakan']);
    }

    protected function hitungPembelianProduk($pelangganId)
    {
        return Transaksi::where('id_pelanggan', $pelangganId)
            ->where('status', 'Lunas')
            ->whereHas('detail', function ($q) {
                $q->where('jenis', 'Produk');
            })
            ->count();
    }

    protected function hitungDiskonMember($pelanggan, $subtotal)
    {
        $result = [
            'diskon' => 0,
            'aktif' => false,
            'level' => null,
            'diskon_pct' => 0,
            'sisa' => 0,
        ];

        if (!$pelanggan || !$pelanggan->id_member) {
            return $result;
        }

        $member = $pelanggan->membership;
        if (!$member || $member->status !== 'aktif') {
            return $result;
        }

        $result['level'] = $member->tingkat;
        $result['diskon_pct'] = (float) $member->diskon;

        $jmlPembelian = $this->hitungPembelianProduk($pelanggan->id_pelanggan);

        if ($jmlPembelian >= (int) $member->min_transaksi) {
            $result['aktif'] = true;
            $result['diskon'] = (int) round($subtotal * $member->diskon / 100);
        } else {
            $result['sisa'] = max(0, (int) $member->min_transaksi - $jmlPembelian);
        }

        return $result;
    }
}
