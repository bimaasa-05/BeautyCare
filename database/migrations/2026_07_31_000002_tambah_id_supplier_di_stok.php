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
        Schema::table('stok', function (Blueprint $table) {
            $table->unsignedBigInteger('id_produk')->change();
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');

            $table->unsignedBigInteger('id_supplier')->nullable()->after('id_produk');
            $table->foreign('id_supplier')->references('id_supplier')->on('supplier')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok', function (Blueprint $table) {
            $table->dropForeign(['id_supplier']);
            $table->dropColumn('id_supplier');

            $table->dropForeign(['id_produk']);
            $table->integer('id_produk')->change();
        });
    }
};
