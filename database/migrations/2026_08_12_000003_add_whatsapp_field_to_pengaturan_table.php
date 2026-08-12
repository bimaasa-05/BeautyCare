<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan', function (Blueprint $table) {
            $table->string('no_wa', 20)->nullable()->after('telepon');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan', function (Blueprint $table) {
            $table->dropColumn('no_wa');
        });
    }
};