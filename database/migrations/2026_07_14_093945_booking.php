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
        Schema::create('booking', function (Blueprint $table) {
            $table->id('id_booking');
            $table->integer('id_pelanggan')->unique();
            $table->integer('id_karyawan')->unique();
            $table->date('tanggal');
            $table->time('jam');
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'diproses', 'selesai', 'dibatalkan']);
            $table->text('catatan');
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
