<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->string('role', 20);
            $table->string('aksi', 100);
            $table->string('tipe', 50)->nullable();
            $table->unsignedBigInteger('id_tipe')->nullable();
            $table->text('deskripsi');
            $table->longText('data_lama')->nullable();
            $table->longText('data_baru')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->index('role');
            $table->index('tipe');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_aktivitas');
    }
};
