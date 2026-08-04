<?php

namespace App\Http\Controllers;

use App\Models\FavoritProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganFavoritController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate(['id_produk' => 'required|integer|exists:produk,id_produk']);

        $userId = Auth::id();
        $idProduk = (int) $request->id_produk;

        $favorit = FavoritProduk::where('id_user', $userId)
            ->where('id_produk', $idProduk)
            ->first();

        $inFavorit = false;

        if ($favorit) {
            $favorit->delete();
        } else {
            FavoritProduk::create([
                'id_user' => $userId,
                'id_produk' => $idProduk,
            ]);
            $inFavorit = true;
        }

        return response()->json([
            'success' => true,
            'in_favorit' => $inFavorit,
            'favorit_produk_id' => $inFavorit ? $idProduk : null,
            'affected' => [
                ['id_produk' => $idProduk, 'count' => $this->favoritCount($idProduk)],
            ],
        ]);
    }

    private function favoritCount($idProduk)
    {
        return FavoritProduk::where('id_produk', $idProduk)->count();
    }
}
