<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_supplier');
            $table->unsignedBigInteger('id_produk');
            $table->integer('stok')->default(0);
            $table->unique(['id_supplier', 'id_produk']);

            $table->foreign('id_supplier')->references('id_supplier')->on('supplier')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });

        DB::statement('
            INSERT INTO supplier_produk (id_supplier, id_produk, stok)
            SELECT s.id_supplier, s.id_produk,
                   COALESCE((SELECT p.stok FROM produk p WHERE p.id_produk = s.id_produk), 0)
            FROM supplier s
            WHERE s.id_produk IS NOT NULL
        ');

        Schema::table('supplier', function (Blueprint $table) {
            $table->dropForeign(['id_produk']);
            $table->dropUnique(['id_produk']);
            $table->dropColumn('id_produk');
        });
    }

    public function down(): void
    {
        Schema::table('supplier', function (Blueprint $table) {
            $table->unsignedBigInteger('id_produk')->nullable()->after('alamat');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('set null');
            $table->unique('id_produk');
        });

        DB::statement('
            UPDATE supplier s
            JOIN supplier_produk sp ON sp.id_supplier = s.id_supplier
            SET s.id_produk = sp.id_produk
        ');

        Schema::dropIfExists('supplier_produk');
    }
};
