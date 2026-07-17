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
        Schema::create('layanan', function (Blueprint $table) {
            $table->id('id_layanan');
            $table->integer('id_kategori')->unique();
            $table->string('nm_layanan', 150);
            $table->integer('durasi');
            $table->decimal('harga', 12);
            $table->string('foto');
            $table->enum('status', ['Tersedia', 'Tidak Tersedia']);
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
