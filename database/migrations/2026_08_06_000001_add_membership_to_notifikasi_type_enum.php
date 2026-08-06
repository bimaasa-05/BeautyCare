<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->enum('type', ['Booking', 'Promo', 'Stok', 'Transaksi', 'Membership', 'Lainnya'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->enum('type', ['Booking', 'Promo', 'Stok', 'Transaksi', 'Lainnya'])->change();
        });
    }
};
