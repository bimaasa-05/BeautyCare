<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership', function (Blueprint $table) {
            $table->id('id_member');
            $table->string('nm_member', 100);
            $table->string('tingkat', 50);
            $table->decimal('diskon')->default(0);
            $table->integer('min_transaksi')->default(0);
            $table->decimal('min_pembelian', 12)->default(0);
            $table->text('deskripsi')->nullable();
            $table->bigInteger('masa_berlaku');
            $table->enum('status', ['aktif', 'non_aktif', 'suspend'])->default('non_aktif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership');
    }
};
