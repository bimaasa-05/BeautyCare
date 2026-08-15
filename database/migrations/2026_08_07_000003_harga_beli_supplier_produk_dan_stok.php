<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn("supplier_produk", "harga_beli")) {
            Schema::table("supplier_produk", function (Blueprint $table) {
                $table->unsignedBigInteger("harga_beli")->default(0)->after("id_produk");
            });
        }

        // SQLite doesn"t support JOIN in UPDATE, use subquery instead
        DB::statement("
            UPDATE supplier_produk
            SET harga_beli = (
                SELECT harga_beli FROM produk 
                WHERE produk.id_produk = supplier_produk.id_produk
                LIMIT 1
            )
            WHERE harga_beli = 0
        ");

        if (!Schema::hasColumn("stok", "harga_satuan")) {
            Schema::table("stok", function (Blueprint $table) {
                $table->unsignedBigInteger("harga_satuan")->nullable()->after("id_supplier");
            });
        }

        DB::statement("
            UPDATE stok
            SET harga_satuan = (
                SELECT harga_beli FROM produk 
                WHERE produk.id_produk = stok.id_produk
                LIMIT 1
            )
            WHERE type IN (\"Masuk\", \"Refund\") AND harga_satuan IS NULL
        ");
    }

    public function down(): void
    {
        if (Schema::hasColumn("stok", "harga_satuan")) {
            Schema::table("stok", function (Blueprint $table) {
                $table->dropColumn("harga_satuan");
            });
        }

        if (Schema::hasColumn("supplier_produk", "harga_beli")) {
            Schema::table("supplier_produk", function (Blueprint $table) {
                $table->dropColumn("harga_beli");
            });
        }
    }
};
