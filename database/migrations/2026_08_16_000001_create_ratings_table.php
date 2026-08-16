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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_pelanggan')->nullable();
            $table->string('tipe', 20);
            $table->unsignedBigInteger('id_target');
            $table->tinyInteger('bintang');
            $table->text('komentar')->nullable();
            $table->string('status', 20)->default('aktif');
            $table->timestamps();

            $table->unique(['id_user', 'tipe', 'id_target']);
            $table->index(['tipe', 'id_target']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};