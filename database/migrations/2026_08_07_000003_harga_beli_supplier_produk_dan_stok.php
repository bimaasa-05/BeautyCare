<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supplier_produk', function (Blueprint $table) {
            $table->unsignedBigInteger('harga_beli')->default(0)->after('id_produk');
        });

        DB::statement('
            UPDATE supplier_produk sp
            JOIN produk p ON p.id_produk = sp.id_produk
            SET sp.harga_beli = p.harga_beli
            WHERE sp.harga_beli = 0
        ');

        Schema::table('stok', function (Blueprint $table) {
            $table->unsignedBigInteger('harga_satuan')->nullable()->after('id_supplier');
        });

        DB::statement('
            UPDATE stok s
            JOIN produk p ON p.id_produk = s.id_produk
            SET s.harga_satuan = p.harga_beli
            WHERE s.type IN (\'Masuk\', \'Refund\') AND s.harga_satuan IS NULL
        ');
    }

    public function down(): void
    {
        Schema::table('stok', function (Blueprint $table) {
            $table->dropColumn('harga_satuan');
        });

        Schema::table('supplier_produk', function (Blueprint $table) {
            $table->dropColumn('harga_beli');
        });
    }
};
