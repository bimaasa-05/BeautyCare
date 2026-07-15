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
        Schema::create('promo', function (Blueprint $table) {
            $table->id('id_promo');
            $table->string('nm_promo', 100);
            $table->enum('jenis_promo', ['Diskon', 'Cashback', 'Paket', 'Buy 1 Get 1', 'Lainnya']);
            $table->decimal('nilai', 12)->default(0);
            $table->date('mulai',);
            $table->date('selesai',);
            $table->enum('status', ['Tersedia', 'Belum_tersedia', 'Berakhir']);
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
