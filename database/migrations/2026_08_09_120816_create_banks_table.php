<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bank', 50);
            $table->string('kode_bank', 3)->unique()->nullable();
            $table->string('no_rekening', 30)->nullable();
            $table->string('atas_nama', 100);
            $table->string('logo')->nullable();
            $table->enum('tipe', ['transfer', 'ewallet', 'qris']);
            $table->string('nomor_telepon', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};