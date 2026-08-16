<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement(
            "UPDATE detail_transaksi dt
             JOIN transaksi t ON t.id_transaksi = dt.id_transaksi
             JOIN booking b ON b.id_booking = t.id_booking
             SET dt.jam = b.jam, dt.id_karyawan = b.id_karyawan
             WHERE dt.id_karyawan IS NULL AND dt.jam IS NULL AND t.id_booking IS NOT NULL"
        );
    }

    public function down(): void
    {
        DB::statement(
            "UPDATE detail_transaksi dt
             JOIN transaksi t ON t.id_transaksi = dt.id_transaksi
             JOIN booking b ON b.id_booking = t.id_booking
             SET dt.jam = NULL, dt.id_karyawan = NULL
             WHERE t.id_booking IS NOT NULL"
        );
    }
};
