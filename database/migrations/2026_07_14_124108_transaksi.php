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
            $table->integer('id_booking')->unique();
            $table->integer('id_pelanggan')->unique();
            $table->integer('id_user')->unique(); //Untuk Id Role Kasir Jangan Mengguankan Yang Lainnya;
            $table->string('no_invoice', 30);
            $table->date('tanggal');
            $table->decimal('subtotal', 12);
            $table->decimal('diskon', 12);
            $table->decimal('pajak', 12)->default(0);
            $table->decimal('total', 12)->default(0);
            $table->enum('metode_byr', ['Tunai', 'Qris', 'Transfer', 'Debit', 'Kredit']);
            $table->decimal('dibayar', 12);
            $table->decimal('kembali', 12);
            $table->text('catatan');

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
