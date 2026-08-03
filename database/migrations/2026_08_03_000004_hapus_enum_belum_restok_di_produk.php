<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('produk')
            ->where('status', 'Belum Restok')
            ->update(['status' => DB::raw('CASE WHEN stok > 0 THEN "Tersedia" ELSE "Habis" END')]);

        Schema::table('produk', function (Blueprint $table) {
            $table->enum('status', ['Tersedia', 'Habis'])->default('Habis')->change();
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->enum('status', ['Tersedia', 'Habis', 'Belum Restok'])->default('Tersedia')->change();
        });
    }
};
