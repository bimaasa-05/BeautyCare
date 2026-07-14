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
        Schema::create('detail_booking', function (Blueprint $table) {
            $table->id('id_detail_booking');
            $table->integer('id_booking')->unique();
            $table->integer('id_layanan')->unique();
            $table->decimal('harga', 12);
            $table->decimal('diskon', 12)->default(0);
            $table->decimal('subtotal', 12);
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
