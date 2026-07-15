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
        Schema::create('paket_treatment', function (Blueprint $table) {
            $table->id('id_paket');
            $table->string('nm_paket', 100);
            $table->text('deskripsi');
            $table->decimal('harga');
            $table->decimal('diskon', 12)->default(0);
            $table->string('foto');
            $table->tinyInteger('status');
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
