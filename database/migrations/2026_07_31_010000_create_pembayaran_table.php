<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transaksi')->index();
            $table->string('metode', 20);
            $table->string('provider', 50);
            $table->string('kode_pembayaran', 100)->nullable();
            $table->decimal('nominal', 12);
            $table->string('status', 20)->default('Menunggu');
            $table->dateTime('expires_at');
            $table->dateTime('paid_at')->nullable();
            $table->string('no_referensi', 50)->nullable();
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
