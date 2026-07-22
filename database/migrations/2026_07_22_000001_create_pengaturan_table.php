<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id('id_pengaturan');
            $table->boolean('push_notification')->default(true);
            $table->boolean('sms_notifikasi')->default(false);
            $table->boolean('email_laporan')->default(true);
            $table->boolean('konfirmasi_otomatis')->default(true);
            $table->string('nama_salon', 100)->default('BeautyCare Premium');
            $table->string('telepon', 20)->default('021-1234-5678');
            $table->time('jam_buka')->default('08:00:00');
            $table->time('jam_tutup')->default('20:00:00');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
