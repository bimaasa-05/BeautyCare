<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->enum('jenis', ['Layanan', 'Produk', 'Membership', 'TopUp'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->enum('jenis', ['Layanan', 'Produk', 'Membership'])->change();
        });
    }
};