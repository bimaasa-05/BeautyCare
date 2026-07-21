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
        Schema::create('paket_detail', function (Blueprint $table) {
            $table->id('id_paket_detail');
            $table->integer('id_paket');
            $table->integer('id_layanan');
            $table->integer('urutan');
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
