<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dateTime('jam_mulai_aktual')->nullable()->after('jam');
            $table->dateTime('jam_selesai_aktual')->nullable()->after('jam_mulai_aktual');
        });
    }

    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropColumn(['jam_mulai_aktual', 'jam_selesai_aktual']);
        });
    }
};
