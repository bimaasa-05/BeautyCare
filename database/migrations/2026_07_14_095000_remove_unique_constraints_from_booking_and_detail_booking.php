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
            } catch (\Exception $e) {}
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
    }
};
