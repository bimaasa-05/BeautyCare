<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\PromoKlaim;
use Illuminate\Http\Request;

class PelangganPromoController extends Controller
{
    public function index()
    {
        $promos = Promo::orderBy('id_promo', 'desc')->get();
        $claimedIds = PromoKlaim::where('id_user', auth()->id())
            ->whereIn('status', ['tersedia', 'digunakan'])
            ->pluck('id_promo')
            ->toArray();
        $usedIds = PromoKlaim::where('id_user', auth()->id())
            ->where('status', 'digunakan')
            ->pluck('id_promo')
            ->toArray();

        return view('pelanggan.promo.index', compact('promos', 'claimedIds', 'usedIds'));
    }

    public function claim(Request $request)
    {
        $request->validate(['id_promo' => 'required|integer|exists:promo,id_promo']);

        $userId = auth()->id();
        $idPromo = $request->id_promo;

        $existing = PromoKlaim::where('id_user', $userId)
            ->where('id_promo', $idPromo)
            ->first();

        if ($existing) {
            if ($existing->status === 'tersedia') {
                return response()->json(['success' => true, 'action' => 'already_claimed']);
            }
            return response()->json(['success' => false, 'message' => 'Promo sudah digunakan', 'action' => 'used']);
        }

        $promo = Promo::find($idPromo);
        if (!$promo || $promo->status !== 'Tersedia') {
            return response()->json(['success' => false, 'message' => 'Promo tidak tersedia']);
        }

        PromoKlaim::create([
            'id_user' => $userId,
            'id_promo' => $idPromo,
            'status' => 'tersedia',
        ]);

        return response()->json(['success' => true, 'action' => 'claimed']);
    }
}
