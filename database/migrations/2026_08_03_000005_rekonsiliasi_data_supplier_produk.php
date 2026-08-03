<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('supplier')->update(['id_produk' => null]);

        $terpakai = [];
        $candidates = DB::table('stok')
            ->where('type', 'Masuk')
            ->whereNotNull('id_supplier')
            ->orderByDesc('id_stok')
            ->get(['id_supplier', 'id_produk']);

        foreach ($candidates as $c) {
            if (isset($terpakai[$c->id_produk])) {
                continue;
            }

            DB::table('supplier')
                ->where('id_supplier', $c->id_supplier)
                ->whereNull('id_produk')
                ->update(['id_produk' => $c->id_produk]);

            $terpakai[$c->id_produk] = true;
        }

        $mapProdukSupplier = DB::table('supplier')
            ->whereNotNull('id_produk')
            ->pluck('id_supplier', 'id_produk')
            ->all();

        foreach (DB::table('stok')->get(['id_stok', 'id_produk']) as $row) {
            DB::table('stok')
                ->where('id_stok', $row->id_stok)
                ->update(['id_supplier' => $mapProdukSupplier[$row->id_produk] ?? null]);
        }
    }

    public function down(): void
    {
    }
};
