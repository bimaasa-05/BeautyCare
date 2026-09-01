<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Membership;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Produk;
use App\Models\Promo;
use App\Models\PromoKlaim;
use App\Models\Transaksi;
use App\Models\Troli;
use App\Models\Bank;
use App\Services\SaldoAkunService;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public static function bankTujuan()
    {
        return Bank::active()->transfer()->get(['id', 'nama_bank', 'no_rekening', 'kode_bank', 'logo'])
            ->mapWithKeys(function ($bank) {
                return [$bank->nama_bank => $bank->no_rekening ?? ''];
            })
            ->toArray();
    }

    public static function getBanksForTransfer()
    {
        return Bank::active()->transfer()->get(['id', 'nama_bank', 'no_rekening', 'kode_bank', 'logo']);
    }

    public static function generateKodePembayaran($metode, $idTransaksi, $bank = null)
    {
        $digits = str_pad((string) $idTransaksi, 8, '0', STR_PAD_LEFT);

        if ($metode === 'Transfer') {
            if ($bank && $bank->kode_bank) {
                return $bank->kode_bank . $digits;
            }
            return '8802' . $digits; // fallback
        }
        if ($metode === 'QRIS') {
            return 'QR-' . $digits;
        }

        return 'EP-' . $digits;
    }

    public function create(Request $request)
    {
        $isMembership = false;
        $membership = null;

        if ($request->beli_membership) {
            $member = Membership::where('id_member', $request->beli_membership)
                ->where('status', 'aktif')
                ->first();

            if (!$member || (float) $member->harga <= 0) {
                return redirect()->route('pelanggan.membership')->with('error', 'Paket membership tidak tersedia atau harganya belum diatur.');
            }

            $error = $this->cekSyaratMembership($this->getOrCreatePelanggan(auth()->user()), $member);
            if ($error) {
                return redirect()->route('pelanggan.membership')->with('error', $error);
            }

            $items = $this->membershipItem($member);
            $membership = $member;
            $isMembership = true;
        } else {
            $items = $this->resolveItems($request);

            if (empty($items)) {
                return redirect()->route('pelanggan.keranjang')->with('error', 'Keranjang Anda kosong.');
            }
        }

        $subtotal = collect($items)->sum('subtotal');

        $claimedPromos = $isMembership
            ? collect()
            : PromoKlaim::with('promo')
                ->where('id_user', auth()->id())
                ->where('status', 'tersedia')
                ->get()
                ->filter(function ($klaim) use ($items) {
                    if (!$klaim->promo || $klaim->promo->jenis_promo === 'Paket') {
                        return false;
                    }
                    if (!$klaim->promo->berlakuUntuk(auth()->user())) {
                        return false;
                    }
                    return collect($items)->contains(
                        fn ($item) => $klaim->promo->itemEligible('Produk', $item['id_produk'] ?? 0)
                    );
                })
                ->map(function ($klaim) use ($items) {
                    $eligibleItems = array_values(array_filter(
                        $items,
                        fn ($item) => $klaim->promo->itemEligible('Produk', $item['id_produk'] ?? 0)
                    ));
                    $klaim->diskon_pakai = (int) round($klaim->promo->hitungDiskon($eligibleItems));
                    return $klaim;
                });

        $banks = self::getBanksForTransfer();
        $bankTujuan = self::bankTujuan();

        $pelanggan = $this->getOrCreatePelanggan(auth()->user());
        $saldo = (float) $pelanggan->saldo;

        $memberInfo = $isMembership
            ? ['diskon' => 0, 'aktif' => false, 'level' => null, 'diskon_pct' => 0, 'sisa' => 0]
            : $this->hitungDiskonMember($pelanggan, $subtotal);

        return view('pelanggan.checkout.index', compact('items', 'subtotal', 'claimedPromos', 'banks', 'bankTujuan', 'memberInfo', 'isMembership', 'membership', 'saldo', 'pelanggan'));
    }

    public function pembayaranMembership(Request $request)
    {
        if (!$request->beli_membership) {
            return redirect()->route('pelanggan.membership')->with('error', 'Pilih paket membership terlebih dahulu.');
        }

        $member = Membership::where('id_member', $request->beli_membership)
            ->where('status', 'aktif')
            ->first();

        if (!$member || (float) $member->harga <= 0) {
            return redirect()->route('pelanggan.membership')->with('error', 'Paket membership tidak tersedia atau harganya belum diatur.');
        }

        $error = $this->cekSyaratMembership($this->getOrCreatePelanggan(auth()->user()), $member);
        if ($error) {
            return redirect()->route('pelanggan.membership')->with('error', $error);
        }

        $items = $this->membershipItem($member);
        $subtotal = collect($items)->sum('subtotal');
        $banks = self::getBanksForTransfer();
        $bankTujuan = self::bankTujuan();
        $pelanggan = $this->getOrCreatePelanggan(auth()->user());
        $saldo = (float) $pelanggan->saldo;
        $isRenewal = (int) $pelanggan->id_member === (int) $member->id_member;

        // Validasi alamat - pelanggan harus memiliki alamat sebelum checkout membership
        if (empty($pelanggan->alamat)) {
            return back()->with('error', 'Alamat Anda belum diisi. Silakan tambahkan alamat pada profil Anda sebelum melakukan pemesanan.');
        }

        return view('pelanggan.pembayaran.pembayaran-membership', compact('member', 'items', 'subtotal', 'banks', 'bankTujuan', 'isRenewal', 'saldo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'metode' => 'required|in:QRIS,Transfer,Saldo',
            'provider' => 'required|string|max:50',
            'bank_id' => 'nullable|required_if:metode,Transfer|integer|exists:banks,id',
            'id_promo' => 'nullable|integer',
            'beli' => 'nullable|integer',
            'qty' => 'nullable|integer|min:1',
            'beli_membership' => 'nullable|integer',
            'pakai_saldo' => 'nullable|numeric|min:0',
        ]);

        $providers = [
            'QRIS' => ['QRIS'],
            'Transfer' => Bank::active()->transfer()->pluck('nama_bank')->toArray(),
            'Saldo' => ['Saldo Akun'],
        ];

        abort_unless(in_array($request->provider, $providers[$request->metode]), 422);

        // Get bank object for Transfer
        $bank = null;
        if ($request->metode === 'Transfer' && $request->bank_id) {
            $bank = Bank::find($request->bank_id);
        }

        $user = auth()->user();
        $pelanggan = $this->getOrCreatePelanggan($user);

        // Validasi alamat - pelanggan harus memiliki alamat sebelum checkout
        if (empty($pelanggan->alamat)) {
            return back()->with('error', 'Alamat Anda belum diisi. Silakan tambahkan alamat pada profil Anda sebelum melakukan pemesanan.');
        }

        $isMembership = (bool) $request->beli_membership;

        $promoDiskon = 0;
        $pakaiPromo = false;
        $isCashbackPromo = false;
        $memberInfo = [
            'diskon' => 0,
            'aktif' => false,
            'level' => null,
            'diskon_pct' => 0,
            'sisa' => 0,
        ];
        $memberInfo = ['diskon' => 0, 'aktif' => false, 'level' => null, 'diskon_pct' => 0, 'sisa' => 0];

        if ($isMembership) {
            $member = Membership::where('id_member', $request->beli_membership)
                ->where('status', 'aktif')
                ->first();

            if (!$member || (float) $member->harga <= 0) {
                return back()->with('error', 'Paket membership tidak tersedia atau harganya belum diatur.');
            }

            $error = $this->cekSyaratMembership($pelanggan, $member);
            if ($error) {
                return back()->with('error', $error);
            }

            $items = $this->membershipItem($member);
            $subtotal = collect($items)->sum('subtotal');
            $idPromo = null;
            $diskon = 0;
            $isRenewal = (int) $pelanggan->id_member === (int) $member->id_member;
            $catatanDiskon = ($isRenewal ? 'Perpanjang' : 'Upgrade') . ' membership ke ' . $member->tingkat;
            $total = $subtotal;
        } else {
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

            $subtotal = collect($items)->sum('subtotal');
            $idPromo = $request->id_promo;

            $promoDiskon = $this->hitungPromo($idPromo, $user->id, $items, false);
            if ($promoDiskon === -1) {
                return back()->with('error', 'Promo Paket tidak berlaku untuk pembelian produk.');
            }
            if ($promoDiskon === -2) {
                return back()->with('error', 'Promo yang dipilih tidak berlaku untuk produk yang dibeli.');
            }

            $promoObj = $idPromo ? Promo::find($idPromo) : null;
            $isCashbackPromo = $promoObj && $promoObj->jenis_promo === 'Cashback';

            $memberInfo = $this->hitungDiskonMember($pelanggan, $subtotal);
            $memberDiskon = $memberInfo['diskon'];

            $pakaiPromo = $promoDiskon > 0 && $promoDiskon >= $memberDiskon;
            $diskon = $pakaiPromo ? $promoDiskon : $memberDiskon;

            $catatanDiskon = '';
            if ($isCashbackPromo) {
                $this->tandaiPromo($idPromo, $user->id);
                $catatanDiskon = 'Cashback: ' . number_format((float) $promoObj->nilai, 0, ',', '.') . ' masuk saldo setelah Lunas';
            } elseif ($pakaiPromo) {
                $this->tandaiPromo($idPromo, $user->id);
                $catatanDiskon = 'Diskon: Promo';
            } elseif ($memberDiskon > 0) {
                $catatanDiskon = 'Diskon: Member ' . $memberInfo['level'] . ' ' . (float) $memberInfo['diskon_pct'] . '%';
            }

            $total = $subtotal - $diskon;
        }

        $lastId = Transaksi::max('id_transaksi') + 1;
        $noInvoice = 'INV-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

        return DB::transaction(function () use ($request, $user, $pelanggan, $isMembership, $items, $subtotal, $diskon, $pakaiPromo, $idPromo, $catatanDiskon, $promoDiskon, $memberInfo, $total, $bank, $noInvoice, $isCashbackPromo) {
            // Pembayaran saldo penuh: validasi sebelum transaksi dibuat
            $pakaiSaldo = (float) $request->input('pakai_saldo', 0);
            $bayarSaldoPenuh = $request->metode === 'Saldo';

            if ($bayarSaldoPenuh) {
                $saldoTersedia = (float) $pelanggan->saldo;
                if ($saldoTersedia < (float) $total) {
                    return back()->with('error', 'Saldo akun Anda Rp ' . number_format($saldoTersedia, 0, ',', '.') . ' tidak cukup untuk total Rp ' . number_format((float) $total, 0, ',', '.') . '. Silakan pilih metode kedua untuk sisa pembayaran.');
                }
                $pakaiSaldo = (float) $total;
                $catatanDiskon = trim($catatanDiskon . ($catatanDiskon ? ' | ' : '') . 'Bayar saldo akun');
            }

            $transaksi = Transaksi::create([
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'id_user' => $user->id,
                'sumber' => 'online',
                'jenis_transaksi' => 'Pesanan Online',
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

            // Proses saldo (debit saja di sini); cashback dikredit setelah Lunas
            if ($pakaiSaldo > 0) {
                $saldoService = new SaldoAkunService();
                $saldoResult = $saldoService->prosesCheckout(
                    $pelanggan->id_pelanggan,
                    $total,
                    $pakaiSaldo,
                    $transaksi->id_transaksi,
                    $idPromo,
                    false // jangan kredit cashback saat order masih Menunggu Pembayaran
                );
                $transaksi->update(['saldo_terpakai' => $saldoResult['pakai_saldo']]);
                $total = $saldoResult['sisa_bayar']; // Update total for payment
            }

            foreach ($items as $item) {
                if (!empty($item['id_member'])) {
                    DetailTransaksi::create([
                        'id_transaksi' => $transaksi->id_transaksi,
                        'jenis' => 'Membership',
                        'id_item' => $item['id_member'],
                        'nm_item' => $item['nm_produk'],
                        'qty' => 1,
                        'harga' => $item['harga_satuan'],
                        'diskon' => 0,
                        'subtotal' => $item['subtotal'],
                        'id_promo' => null,
                    ]);
                    continue;
                }

                $itemSubtotal = $item['subtotal'];
                $itemDiskon = 0;
                $itemIdPromo = null;
                if ($diskon > 0 && $subtotal > 0) {
                    $itemDiskon = (int) round($diskon * $itemSubtotal / $subtotal);
                    $itemIdPromo = $pakaiPromo ? $idPromo : null;
                } elseif ($isCashbackPromo) {
                    $itemIdPromo = $idPromo;
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

            $transaksiStatus = 'Menunggu Pembayaran';

            if ($bayarSaldoPenuh) {
                $now = now();
                $pembayaranData = [
                    'id_transaksi' => $transaksi->id_transaksi,
                    'metode' => 'Saldo',
                    'provider' => 'Saldo Akun',
                    'kode_pembayaran' => 'SLD-' . str_pad((string) $transaksi->id_transaksi, 8, '0', STR_PAD_LEFT),
                    'nominal' => 0,
                    'status' => 'Dibayar',
                    'expires_at' => $now,
                    'paid_at' => $now,
                    'no_referensi' => 'SALDO-' . $transaksi->id_transaksi,
                ];

                Pembayaran::create($pembayaranData);

                $transaksiStatus = 'Sedang Diproses';
            } else {
                $expiresAt = $request->metode === 'QRIS'
                    ? now()->addMinutes(3) // Hitung Mundur Dalam 3 Menit
                    : now()->addMinutes(15); // Transfer 15 menit

                $pembayaranData = [
                    'id_transaksi' => $transaksi->id_transaksi,
                    'metode' => $request->metode,
                    'provider' => $request->provider,
                    'kode_pembayaran' => self::generateKodePembayaran($request->metode, $transaksi->id_transaksi, $bank),
                    'nominal' => $total,
                    'status' => 'Menunggu',
                    'expires_at' => $expiresAt,
                ];

                // Add bank info for Transfer
                if ($bank) {
                    $pembayaranData['bank_id'] = $bank->id;
                    $pembayaranData['no_rekening_tujuan'] = $bank->no_rekening;
                    $pembayaranData['atas_nama_tujuan'] = $bank->atas_nama;
                }

                Pembayaran::create($pembayaranData);
            }

            $transaksi->update(['status' => $transaksiStatus]);

            if (!$request->beli && !$isMembership) {
                Troli::where('id_user', $user->id)->delete();
            }

            $targetPesanan = route('pelanggan.pembayaran.show', $transaksi->id_transaksi);

            if ($bayarSaldoPenuh) {
                ActivityLogger::log('Menambahkan', $user->nama . ' membuat pesanan ' . $noInvoice . ' dibayar penuh dengan saldo akun (menunggu verifikasi kasir)', 'Transaksi', $transaksi->id_transaksi);

                buatNotif($user->id, 'Pesanan Dibuat', 'Pesanan ' . $noInvoice . ' dibayar penuh dengan saldo akun. Menunggu verifikasi kasir.', 'Transaksi', $targetPesanan);
            } else {
                ActivityLogger::log('Menambahkan', $user->nama . ' membuat pesanan ' . $noInvoice . ' via ' . $request->provider . ' (menunggu pembayaran)', 'Transaksi', $transaksi->id_transaksi);

                buatNotif($user->id, 'Pesanan Dibuat', 'Pesanan ' . $noInvoice . ' berhasil dibuat. Silakan selesaikan pembayaran.', 'Transaksi', $targetPesanan);
            }

            $petugas = \App\Models\User::whereIn('role', ['kasir', 'admin'])->get();
            foreach ($petugas as $petugasUser) {
                $judulPetugas = $bayarSaldoPenuh ? 'Pesanan Baru (Saldo Akun)' : 'Pesanan Baru';
                $isiPetugas = $bayarSaldoPenuh
                    ? $user->nama . ' membuat pesanan ' . $noInvoice . ' dibayar penuh dengan saldo akun. Segera verifikasi.'
                    : $user->nama . ' membuat pesanan ' . $noInvoice . ' menunggu pembayaran (' . $request->provider . ').';
                buatNotif($petugasUser->id, $judulPetugas, $isiPetugas, 'Transaksi', route('kasir.pembayaran.pesanan-online'));
            }

            return redirect($targetPesanan);
        });
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
        return Pelanggan::dariUserOrCreate($user);
    }

    protected function hitungPromo($idPromo, $userId, $items, $markUsed = true)
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

        if (!$promo->berlakuUntuk(\App\Models\User::find($userId))) {
            return -2;
        }

        if ($promo->jenis_promo === 'Paket') {
            return -1;
        }

        $eligibleItems = array_values(array_map(function ($item) {
            $item['jenis'] = 'Produk';
            $item['id_item'] = $item['id_produk'] ?? 0;
            return $item;
        }, array_filter($items, fn ($item) => $promo->itemEligible('Produk', $item['id_produk'] ?? 0))));

        if (empty($eligibleItems)) {
            return -2;
        }

        $diskon = (int) round($promo->hitungDiskon($eligibleItems));

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

    protected function hitungPembelianProduk(Pelanggan $pelanggan)
    {
        return $pelanggan->totalPembelianProduk();
    }

    protected function hitungTotalBelanja(Pelanggan $pelanggan)
    {
        return $pelanggan->totalBelanjaProduk();
    }

    protected function cekSyaratMembership(?Pelanggan $pelanggan, Membership $member): ?string
    {
        if (!$pelanggan) {
            return 'Data pelanggan tidak ditemukan.';
        }

        $isRenewal = (int) $pelanggan->id_member === (int) $member->id_member;
        if ($isRenewal) {
            return null;
        }

        $totalTransaksi = $this->hitungPembelianProduk($pelanggan);
        $totalBelanja = $this->hitungTotalBelanja($pelanggan);

        if ($totalTransaksi < (int) $member->min_transaksi || $totalBelanja < (int) $member->min_pembelian) {
            return 'Anda belum memenuhi syarat upgrade ke ' . $member->tingkat . '. Syarat: min. '
                . $member->min_transaksi . 'x pembelian produk & min. belanja Rp '
                . number_format($member->min_pembelian, 0, ',', '.') . '.';
        }

        $currentAktif = $pelanggan->membershipAktif();
        if ($currentAktif) {
            $levels = ['Silver', 'Gold', 'Platinum'];
            $currentIdx = array_search($currentAktif->tingkat, $levels);
            $targetIdx = array_search($member->tingkat, $levels);
            if ($currentIdx !== false && $targetIdx !== false && $targetIdx < $currentIdx) {
                return 'Tidak dapat membeli level yang lebih rendah dari membership aktif.';
            }
        }

        return null;
    }

    protected function membershipItem(Membership $member)
    {
        $harga = (int) round((float) $member->harga);

        return [[
            'id_member' => $member->id_member,
            'nm_produk' => 'Membership ' . $member->tingkat . ' (' . $member->nm_member . ')',
            'kategori' => 'Membership',
            'harga_satuan' => $harga,
            'qty' => 1,
            'subtotal' => $harga,
            'stok' => null,
        ]];
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

        $member = $pelanggan->membershipAktif();
        if (!$member) {
            return $result;
        }

        $result['level'] = $member->tingkat;
        $result['diskon_pct'] = (float) $member->diskon;

        $jmlPembelian = $this->hitungPembelianProduk($pelanggan);

        if ($jmlPembelian >= (int) $member->min_transaksi) {
            $result['aktif'] = true;
            $result['diskon'] = (int) round($subtotal * $member->diskon / 100);
        } else {
            $result['sisa'] = max(0, (int) $member->min_transaksi - $jmlPembelian);
        }

        return $result;
    }
}
