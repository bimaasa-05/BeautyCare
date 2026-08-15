<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->enum('status_pembayaran', ['belum', 'menunggu', 'dp', 'lunas'])->default('belum')->after('status');
            $table->enum('tipe_pembayaran', ['dp', 'full'])->nullable()->after('status_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropColumn(['status_pembayaran', 'tipe_pembayaran']);
        });
    }
};