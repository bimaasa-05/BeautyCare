<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('membership', function (Blueprint $table) {
            $table->integer('min_transaksi')->default(0)->after('diskon');
            $table->decimal('min_pembelian', 12)->default(0)->after('min_transaksi');
        });
    }

    public function down(): void
    {
        Schema::table('membership', function (Blueprint $table) {
            $table->dropColumn(['min_transaksi', 'min_pembelian']);
        });
    }
};
