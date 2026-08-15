<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (config("database.default") === "sqlite") {
            DB::statement("
                UPDATE detail_transaksi
                SET jam = (
                    SELECT jam FROM booking
                    WHERE booking.id_booking = (
                        SELECT id_booking FROM transaksi
                        WHERE transaksi.id_transaksi = detail_transaksi.id_transaksi
                        LIMIT 1
                    )
                    LIMIT 1
                ),
                id_karyawan = (
                    SELECT id_karyawan FROM booking
                    WHERE booking.id_booking = (
                        SELECT id_booking FROM transaksi
                        WHERE transaksi.id_transaksi = detail_transaksi.id_transaksi
                        LIMIT 1
                    )
                    LIMIT 1
                )
                WHERE id_karyawan IS NULL
                AND jam IS NULL
                AND (
                    SELECT id_booking FROM transaksi
                    WHERE transaksi.id_transaksi = detail_transaksi.id_transaksi
                    LIMIT 1
                ) IS NOT NULL
            ");
        } else {
            DB::statement(
                "UPDATE detail_transaksi dt
                 JOIN transaksi t ON t.id_transaksi = dt.id_transaksi
                 JOIN booking b ON b.id_booking = t.id_booking
                 SET dt.jam = b.jam, dt.id_karyawan = b.id_karyawan
                 WHERE dt.id_karyawan IS NULL AND dt.jam IS NULL AND t.id_booking IS NOT NULL"
            );
        }
    }

    public function down(): void
    {
        if (config("database.default") === "sqlite") {
            DB::statement("
                UPDATE detail_transaksi
                SET jam = NULL, id_karyawan = NULL
                WHERE (
                    SELECT id_booking FROM transaksi
                    WHERE transaksi.id_transaksi = detail_transaksi.id_transaksi
                    LIMIT 1
                ) IS NOT NULL
            ");
        } else {
            DB::statement(
                "UPDATE detail_transaksi dt
                 JOIN transaksi t ON t.id_transaksi = dt.id_transaksi
                 JOIN booking b ON b.id_booking = t.id_booking
                 SET dt.jam = NULL, dt.id_karyawan = NULL
                 WHERE t.id_booking IS NOT NULL"
            );
        }
    }
};
