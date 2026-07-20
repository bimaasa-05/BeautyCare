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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->string('id_booking');
            $table->string('id_pelanggan');
            $table->string('id_user');
            $table->string('id_produk')->nullable();
            $table->string('no_invoice', 30);
            $table->date('tanggal');
            $table->decimal('subtotal', 12);
            $table->decimal('diskon', 12);
            $table->decimal('pajak', 12)->default(0);
            $table->decimal('total', 12)->default(0);
            $table->enum('metode_byr', ['Tunai', 'Transfer', 'Debit', 'E-Wallet']);
            $table->decimal('dibayar', 12);
            $table->decimal('kembali', 12);
            $table->text('catatan');
            $table->enum('status', ['Pending', 'Lunas', 'Batal'])->default('Pending');
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
