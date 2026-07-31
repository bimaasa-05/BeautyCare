<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn('id_supplier');

            $table->unsignedBigInteger('id_kategori_produk')->change();
            $table->foreign('id_kategori_produk')->references('id_kategori_produk')->on('kategori_produk')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropForeign(['id_kategori_produk']);

            $table->integer('id_kategori_produk')->change();
            $table->integer('id_supplier')->nullable()->after('id_kategori_produk');
        });
    }
};
