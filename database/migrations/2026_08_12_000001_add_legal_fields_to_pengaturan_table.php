<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan', function (Blueprint $table) {
            $table->longText('syarat_ketentuan')->nullable()->after('jam_tutup');
            $table->longText('kebijakan_privasi')->nullable()->after('syarat_ketentuan');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan', function (Blueprint $table) {
            $table->dropColumn(['syarat_ketentuan', 'kebijakan_privasi']);
        });
    }
};