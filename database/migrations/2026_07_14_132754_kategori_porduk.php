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
        Schema::create(
            'kategori_produk',
            function (Blueprint $table) {
                $table->id('id_kategori_produk');
                $table->string('nm_produk', 100);
                $table->enum('status', ['tersedia', 'tidak_tersedia']);
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
