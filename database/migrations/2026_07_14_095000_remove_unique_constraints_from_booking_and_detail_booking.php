<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $indexes = ['booking_id_pelanggan_unique', 'booking_id_karyawan_unique', 'detail_booking_id_booking_unique', 'detail_booking_id_layanan_unique'];

        foreach ($indexes as $index) {
            try {
                DB::statement("DROP INDEX IF EXISTS \"$index\"");
            } catch (\Exception $e) {
            }
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
    }

    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->unique('id_pelanggan');
            $table->unique('id_karyawan');
        });

        Schema::table('detail_booking', function (Blueprint $table) {
            $table->unique('id_booking');
            $table->unique('id_layanan');
        });
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
