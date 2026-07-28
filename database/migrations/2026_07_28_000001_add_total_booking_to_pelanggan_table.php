<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->integer('total_booking')->default(0)->after('catatan_alergi');
        });

        \App\Models\Pelanggan::chunk(100, function ($pelangganList) {
            foreach ($pelangganList as $pelanggan) {
                $count = \App\Models\Booking::where('id_pelanggan', $pelanggan->id_user)->count();
                $pelanggan->total_booking = $count;
                $pelanggan->save();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn('total_booking');
        });
    }
};
