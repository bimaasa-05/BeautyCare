<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('id_pelanggan')->nullable()->change();
            $table->unsignedBigInteger('id_supplier')->nullable()->after('id_pelanggan');
            $table->string('jenis_transaksi', 20)->default('Penjualan')->after('sumber')->index();
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropIndex(['jenis_transaksi']);
            $table->dropColumn('jenis_transaksi');
            $table->dropColumn('id_supplier');
            $table->string('id_pelanggan')->change();
        });
    }
};
