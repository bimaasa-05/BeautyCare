<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo_klaim', function (Blueprint $table) {
            $table->id('id_promo_klaim');
            $table->integer('id_user');
            $table->integer('id_promo');
            $table->enum('status', ['tersedia', 'digunakan', 'kedaluwarsa'])->default('tersedia');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_klaim');
    }
};
