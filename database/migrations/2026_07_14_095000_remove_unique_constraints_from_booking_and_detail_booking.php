<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $indexes = DB::select("SHOW INDEX FROM booking WHERE Key_name = 'booking_id_pelanggan_unique'");
        if (!empty($indexes)) {
            Schema::table('booking', function (Blueprint $table) {
                $table->dropUnique('booking_id_pelanggan_unique');
            });
        }

        $indexes = DB::select("SHOW INDEX FROM booking WHERE Key_name = 'booking_id_karyawan_unique'");
        if (!empty($indexes)) {
            Schema::table('booking', function (Blueprint $table) {
                $table->dropUnique('booking_id_karyawan_unique');
            });
        }

        $indexes = DB::select("SHOW INDEX FROM detail_booking WHERE Key_name = 'detail_booking_id_booking_unique'");
        if (!empty($indexes)) {
            Schema::table('detail_booking', function (Blueprint $table) {
                $table->dropUnique('detail_booking_id_booking_unique');
            });
        }

        $indexes = DB::select("SHOW INDEX FROM detail_booking WHERE Key_name = 'detail_booking_id_layanan_unique'");
        if (!empty($indexes)) {
            Schema::table('detail_booking', function (Blueprint $table) {
                $table->dropUnique('detail_booking_id_layanan_unique');
            });
        }
    }

    public function down(): void
    {
        $indexes = DB::select("SHOW INDEX FROM booking WHERE Key_name = 'booking_id_pelanggan_unique'");
        if (empty($indexes)) {
            Schema::table('booking', function (Blueprint $table) {
                $table->integer('id_pelanggan')->unique()->change();
            });
        }

        $indexes = DB::select("SHOW INDEX FROM booking WHERE Key_name = 'booking_id_karyawan_unique'");
        if (empty($indexes)) {
            Schema::table('booking', function (Blueprint $table) {
                $table->integer('id_karyawan')->unique()->change();
            });
        }

        $indexes = DB::select("SHOW INDEX FROM detail_booking WHERE Key_name = 'detail_booking_id_booking_unique'");
        if (empty($indexes)) {
            Schema::table('detail_booking', function (Blueprint $table) {
                $table->integer('id_booking')->unique()->change();
            });
        }

        $indexes = DB::select("SHOW INDEX FROM detail_booking WHERE Key_name = 'detail_booking_id_layanan_unique'");
        if (empty($indexes)) {
            Schema::table('detail_booking', function (Blueprint $table) {
                $table->integer('id_layanan')->unique()->change();
            });
        }
    }
};
