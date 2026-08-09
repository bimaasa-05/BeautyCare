<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id('id_konsultasi');
            $table->integer('id_pelanggan');
            $table->integer('id_karyawan')->nullable();
            $table->date('tanggal');
            $table->time('jam');
            $table->enum('mode', ['offline', 'online'])->default('online');
            $table->enum('media', ['whatsapp_chat', 'whatsapp_video'])->nullable();
            $table->string('topik', 200);
            $table->text('pesan')->nullable();
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'selesai', 'ditolak'])->default('menunggu');
            $table->string('periode', 7)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};
