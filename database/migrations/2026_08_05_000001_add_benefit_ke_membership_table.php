<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('membership', function (Blueprint $table) {
            $table->unsignedInteger('jml_konsultasi')->default(0)->after('masa_berlaku');
            $table->boolean('prioritas_booking')->default(false)->after('jml_konsultasi');
            $table->boolean('undangan_event')->default(false)->after('prioritas_booking');
        });

        $benefitDefault = [
            'Silver' => ['jml_konsultasi' => 1, 'prioritas_booking' => 0, 'undangan_event' => 0],
            'Gold' => ['jml_konsultasi' => 2, 'prioritas_booking' => 1, 'undangan_event' => 0],
            'Platinum' => ['jml_konsultasi' => 4, 'prioritas_booking' => 1, 'undangan_event' => 1],
        ];

        foreach ($benefitDefault as $tingkat => $benefit) {
            DB::table('membership')->where('tingkat', $tingkat)->update($benefit);
        }
    }

    public function down(): void
    {
        Schema::table('membership', function (Blueprint $table) {
            $table->dropColumn(['jml_konsultasi', 'prioritas_booking', 'undangan_event']);
        });
    }
};