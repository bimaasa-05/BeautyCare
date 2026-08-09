<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['bank_asal', 'dari_rekening', 'ke_rekening', 'atas_nama', 'bank_tujuan']);
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('bank_asal')->nullable()->after('metode_byr');
            $table->string('dari_rekening')->nullable()->after('bank_asal');
            $table->string('ke_rekening')->nullable()->after('dari_rekening');
            $table->string('atas_nama')->nullable()->after('ke_rekening');
            $table->string('bank_tujuan')->nullable()->after('atas_nama');
        });
    }
};
