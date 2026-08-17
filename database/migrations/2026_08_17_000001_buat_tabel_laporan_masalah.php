<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_masalah', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->integer('id_user');
            $table->string('role', 20);
            $table->enum('kategori', ['Aplikasi', 'Pembayaran', 'Booking/Reservasi', 'Stok/Produk', 'Akun', 'Lainnya']);
            $table->text('deskripsi');
            $table->json('bukti')->nullable();
            $table->enum('status', ['baru', 'diproses', 'selesai'])->default('baru');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_masalah');
    }
};