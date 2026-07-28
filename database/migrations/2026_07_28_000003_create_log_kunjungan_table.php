<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_kunjungan', function (Blueprint $table) {
            $table->id('id_log_kunjungan');
            $table->integer('id_user');
            $table->date('tanggal');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_kunjungan');
    }
};
