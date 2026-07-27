<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipPelangganController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pelanggan = Pelanggan::with('membership')
            ->where('email', $user->email)
            ->orWhere('nm_pelanggan', $user->nama)
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

        $totalTransaksi = 0;
        $totalBelanja = 0;
        $memberSaatIni = null;
        $diskonMember = 0;

        if ($pelanggan) {
            $totalTransaksi = Transaksi::where('id_pelanggan', $pelanggan->id_pelanggan)
                ->where('status', 'Lunas')
                ->count();

            $totalBelanja = Transaksi::where('id_pelanggan', $pelanggan->id_pelanggan)
                ->where('status', 'Lunas')
                ->sum('total');

            if ($pelanggan->id_member) {
                $memberSaatIni = Membership::find($pelanggan->id_member);
                if ($memberSaatIni) {
                    $diskonMember = $memberSaatIni->diskon;
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
        } elseif ($totalTransaksi > 0 || $totalBelanja > 0) {
            $nextTier = $semuaMember->first();
        }

        return view('pelanggan.membership.index', compact(
            'totalTransaksi',
            'totalBelanja',
            'diskonMember',
            'memberSaatIni',
            'semuaMember',
            'nextTier',
            'pelanggan'
        ));
    }
}
