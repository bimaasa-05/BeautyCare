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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::create('kategori_layanan', function (Blueprint $table) {
            $table->id('id_kategori_layanan');
            $table->string('nm_layanan');
            $table->string('deskripsi');
            $table->enum('status', ['tersedia', 'belum_tersedia']);
        });
    }
};
