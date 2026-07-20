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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id('id_detail_transaksi');
            $table->integer('id_transaksi')->index();
            $table->enum('jenis', ['Layanan', 'Produk']);
            $table->integer('id_item');
            $table->string('nm_item', 150);
            $table->integer('qty');
            $table->decimal('harga', 12);
            $table->decimal('diskon', 5)->default(0);
            $table->decimal('subtotal', 12);
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
