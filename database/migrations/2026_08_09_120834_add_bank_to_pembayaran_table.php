<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_id')->nullable()->after('provider');
            $table->string('no_rekening_tujuan', 30)->nullable()->after('bank_id');
            $table->string('atas_nama_tujuan', 100)->nullable()->after('no_rekening_tujuan');
            
            $table->foreign('bank_id')->references('id')->on('banks')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropForeign(['bank_id']);
            $table->dropColumn(['bank_id', 'no_rekening_tujuan', 'atas_nama_tujuan']);
        });
    }
};