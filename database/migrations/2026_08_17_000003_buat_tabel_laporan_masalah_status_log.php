<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_masalah_status_log', function (Blueprint $table) {
            $table->id('id_log');
            $table->integer('id_laporan');
            $table->string('status', 20);
            $table->text('catatan')->nullable();
            $table->integer('id_admin');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_masalah_status_log');
    }
};