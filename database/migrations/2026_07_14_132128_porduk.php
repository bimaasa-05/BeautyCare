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
        //
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->integer('id_kategori_produk')->unique();
            $table->integer('id_supplier')->unique();
            $table->string('barcode', 50);
            $table->string('nm_produk', 50);
            $table->string('satuan', 50);
            $table->decimal('harga_beli', 12);
            $table->decimal('harga_jual', 12);
            $table->integer('stok');
            $table->string('foto');
            $table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
