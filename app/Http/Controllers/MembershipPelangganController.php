<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Notifikasi;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class MembershipPelangganController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pelanggan = Pelanggan::dariUser($user);

        if (!$pelanggan) {
            $pelanggan = Pelanggan::create([
                'nm_pelanggan' => $user->nama,
                'email' => $user->email,
                'no_hp' => $user->no_hp ?? '',
                'alamat' => '',
                'catatan_alergi' => '',
                'id_user' => $user->id,
                'id_member' => null,
            ]);
        }

        $totalTransaksi = 0;
        $totalBelanja = 0;
        $memberSaatIni = null;
        $memberKadaluarsa = null;
        $diskonMember = 0;
        $masaAkhir = null;
        $sisaHariMember = 0;
        $sisaDetikMember = 0;

        if ($pelanggan) {
            $totalTransaksi = Transaksi::where('id_pelanggan', $pelanggan->id_pelanggan)
                ->where('status', 'Lunas')
                ->whereHas('detail', function ($q) {
                    $q->where('jenis', 'Produk');
                })
                ->count();

            $totalBelanja = Transaksi::where('id_pelanggan', $pelanggan->id_pelanggan)
                ->where('status', 'Lunas')
                ->whereHas('detail', function ($q) {
                    $q->where('jenis', 'Produk');
                })
                ->sum('total');

            if ($pelanggan->id_member) {
                $member = Membership::find($pelanggan->id_member);
                if ($member) {
                    $masaAkhir = $member->tanggalBerakhir($pelanggan->tgl_mulai_member);
                    $sisaHariMember = $member->sisaHari($pelanggan->tgl_mulai_member);
                    $sisaDetikMember = $member->sisaWaktu($pelanggan->tgl_mulai_member);

                    $memberAktif = $pelanggan->membershipAktif();
                    if ($memberAktif) {
                        $memberSaatIni = $memberAktif;
                        $diskonMember = $memberAktif->diskon;

                        if ($sisaDetikMember > 0 && $sisaDetikMember < 600) {
                            $menitSisa = max(1, (int) ceil($sisaDetikMember / 60));
                            $judul = 'Membership Akan Berakhir';
                            $sudahAda = Notifikasi::forUser($user->id)
                                ->where('type', 'Membership')
                                ->where('judul', $judul)
                                ->where('created_at', '>', now()->subDay())
                                ->exists();

                            if (!$sudahAda) {
                                buatNotif(
                                    $user->id,
                                    $judul,
                                    "Membership {$memberAktif->tingkat} Anda akan berakhir dalam {$menitSisa} menit. Segera perpanjang agar keuntungan member tetap aktif!",
                                    'Membership',
                                    route('pelanggan.membership')
                                );
                            }
                        }
                    } else {
                        $memberKadaluarsa = $member;
                    }
                }
            }
        }

        $semuaMember = Membership::where('status', 'aktif')
            ->orderBy('min_transaksi')
            ->orderBy('min_pembelian')
            ->get();

        $nextTier = null;
        if ($memberSaatIni) {
            $levels = ['Silver', 'Gold', 'Platinum'];
            $currentIndex = array_search($memberSaatIni->tingkat, $levels);
            if ($currentIndex !== false && $currentIndex < count($levels) - 1) {
                $nextTierName = $levels[$currentIndex + 1];
                $nextTier = $semuaMember->firstWhere('tingkat', $nextTierName);
            }
        } elseif ($memberKadaluarsa) {
            $levels = ['Silver', 'Gold', 'Platinum'];
            $lastIdx = array_search($memberKadaluarsa->tingkat, $levels);
            if ($lastIdx !== false && $lastIdx < count($levels) - 1) {
                $nextTierName = $levels[$lastIdx + 1];
                $nextTier = $semuaMember->firstWhere('tingkat', $nextTierName);
            }
        } elseif ($totalTransaksi > 0 || $totalBelanja > 0) {
            $nextTier = $semuaMember->first();
        }

        $levels = ['Silver', 'Gold', 'Platinum'];
        $isMaxTier = $memberSaatIni && $memberSaatIni->tingkat === end($levels);
        $progressBelanja = 0;
        $progressTransaksi = 0;
        $sisaBelanja = 0;
        $sisaTransaksi = 0;

        $targetBelanja = $isMaxTier ? $memberSaatIni->min_pembelian : ($nextTier?->min_pembelian ?? 0);
        $targetTransaksi = $isMaxTier ? $memberSaatIni->min_transaksi : ($nextTier?->min_transaksi ?? 0);

        if ($isMaxTier) {
            $progressBelanja = 100;
            $progressTransaksi = 100;
        } elseif ($nextTier) {
            $progressBelanja = $nextTier->min_pembelian > 0
                ? (int) min(100, round($totalBelanja / $nextTier->min_pembelian * 100))
                : 0;
            $progressTransaksi = $nextTier->min_transaksi > 0
                ? (int) min(100, round($totalTransaksi / $nextTier->min_transaksi * 100))
                : 0;
            $sisaBelanja = max(0, $nextTier->min_pembelian - $totalBelanja);
            $sisaTransaksi = max(0, $nextTier->min_transaksi - $totalTransaksi);
        }

        return view('pelanggan.membership.index', compact(
            'totalTransaksi',
            'totalBelanja',
            'diskonMember',
            'memberSaatIni',
            'memberKadaluarsa',
            'masaAkhir',
            'sisaHariMember',
            'sisaDetikMember',
            'semuaMember',
            'nextTier',
            'pelanggan',
            'isMaxTier',
            'progressBelanja',
            'progressTransaksi',
            'sisaBelanja',
            'sisaTransaksi',
            'targetBelanja',
            'targetTransaksi'
        ));
    }
}
