<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                'id_member' => null,
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

    public function upgrade(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|string|in:Silver,Gold,Platinum',
            'metode' => 'required|string',
        ]);

        $user = Auth::user();
        $pelanggan = Pelanggan::with('membership')
            ->where('email', $user->email)
            ->orWhere('nm_pelanggan', $user->nama)
            ->first();

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelanggan tidak ditemukan.',
            ], 404);
        }

        $targetTier = Membership::where('tingkat', $request->tingkat)
            ->where('status', 'aktif')
            ->first();

        if (!$targetTier) {
            return response()->json([
                'success' => false,
                'message' => 'Level membership tidak tersedia.',
            ], 404);
        }

        $totalTransaksi = Transaksi::where('id_pelanggan', $pelanggan->id_pelanggan)
            ->where('status', 'Lunas')
            ->count();

        $totalBelanja = Transaksi::where('id_pelanggan', $pelanggan->id_pelanggan)
            ->where('status', 'Lunas')
            ->sum('total');

        if ($totalTransaksi < $targetTier->min_transaksi || $totalBelanja < $targetTier->min_pembelian) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum memenuhi syarat untuk upgrade ke ' . $request->tingkat . '.',
            ], 400);
        }

        $levels = ['Silver', 'Gold', 'Platinum'];
        $currentTingkat = $pelanggan->membership ? $pelanggan->membership->tingkat : null;

        if ($currentTingkat) {
            $currentIdx = array_search($currentTingkat, $levels);
            $targetIdx = array_search($request->tingkat, $levels);
            if ($targetIdx <= $currentIdx) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat upgrade ke level yang sama atau lebih rendah.',
                ], 400);
            }
        }

        try {
            DB::beginTransaction();

            $pelanggan->id_member = $targetTier->id_member;
            $pelanggan->tgl_mulai_member = now();
            $pelanggan->save();

            buatNotif(
                $user->id,
                'Upgrade Membership Berhasil',
                'Selamat! Membership Anda telah di-upgrade ke level ' . $request->tingkat . '. Nikmati semua keuntungannya!',
                'Membership',
                route('pelanggan.membership'),
                $user->id
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Selamat! Membership Anda berhasil di-upgrade ke ' . $request->tingkat . '!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Membership upgrade gagal: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'pelanggan_id' => $pelanggan->id_pelanggan,
                'target_tier' => $request->tingkat,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat upgrade membership.',
            ], 500);
        }
    }
}
