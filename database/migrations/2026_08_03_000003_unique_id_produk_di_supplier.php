<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicates = DB::table('supplier')
            ->select('id_produk')
            ->whereNotNull('id_produk')
            ->groupBy('id_produk')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('id_produk');

        foreach ($duplicates as $idProduk) {
            $minId = DB::table('supplier')->where('id_produk', $idProduk)->min('id_supplier');
            DB::table('supplier')
                ->where('id_produk', $idProduk)
                ->where('id_supplier', '>', $minId)
                ->update(['id_produk' => null]);
        }

        Schema::table('supplier', function (Blueprint $table) {
            $table->unique('id_produk');
        });
    }

    public function down(): void
    {
        Schema::table('supplier', function (Blueprint $table) {
            $table->dropUnique(['id_produk']);
        });
    }
};
