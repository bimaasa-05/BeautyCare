<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $indexes = DB::select("SHOW INDEX FROM transaksi WHERE Key_name = 'transaksi_id_booking_unique'");
            if (!empty($indexes)) {
                $table->dropUnique(['id_booking']);
            }
            $indexes = DB::select("SHOW INDEX FROM transaksi WHERE Key_name = 'transaksi_id_pelanggan_unique'");
            if (!empty($indexes)) {
                $table->dropUnique(['id_pelanggan']);
            }
            $indexes = DB::select("SHOW INDEX FROM transaksi WHERE Key_name = 'transaksi_id_user_unique'");
            if (!empty($indexes)) {
                $table->dropUnique(['id_user']);
            }

            $table->string('bukti_bayar')->nullable()->after('kembali');
            $table->string('atas_nama', 100)->nullable()->after('bukti_bayar');
            $table->string('dari_rekening', 50)->nullable()->after('atas_nama');
            $table->string('ke_rekening', 50)->nullable()->after('dari_rekening');
            $table->string('bank_asal', 50)->nullable()->after('ke_rekening');
            $table->string('bank_tujuan', 50)->nullable()->after('bank_asal');
            $table->string('no_referensi', 50)->nullable()->after('bank_tujuan');
        });
    }


    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['bukti_bayar', 'atas_nama', 'dari_rekening', 'ke_rekening', 'bank_asal', 'bank_tujuan', 'no_referensi']);

            $indexes = DB::select("SHOW INDEX FROM transaksi WHERE Key_name = 'transaksi_id_booking_unique'");
            if (empty($indexes)) {
                $table->unique('id_booking');
            }
            $indexes = DB::select("SHOW INDEX FROM transaksi WHERE Key_name = 'transaksi_id_pelanggan_unique'");
            if (empty($indexes)) {
                $table->unique('id_pelanggan');
            }
            $indexes = DB::select("SHOW INDEX FROM transaksi WHERE Key_name = 'transaksi_id_user_unique'");
            if (empty($indexes)) {
                $table->unique('id_user');
            }
        });
    }
};
