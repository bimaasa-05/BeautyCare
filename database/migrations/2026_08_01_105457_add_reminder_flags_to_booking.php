<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->boolean('reminder_h1')->default(false)->after('catatan');
            $table->boolean('reminder_jam')->default(false)->after('reminder_h1');
        });
    }

    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropColumn(['reminder_h1', 'reminder_jam']);
        });
    }
};
