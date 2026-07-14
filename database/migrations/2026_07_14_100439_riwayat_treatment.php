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
        Schema::create('riwayat_treatment', function (Blueprint $table) {
            $table->id('id_rwayat');
            $table->integer('id_booking')->unique();
            $table->string('sebelum_foto');
            $table->string('sesudah_foto');
            $table->text('produk_digunakan');
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
