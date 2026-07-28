<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_treatment', function (Blueprint $table) {
            $table->string('sebelum_foto')->nullable()->change();
            $table->string('sesudah_foto')->nullable()->change();
            $table->text('produk_digunakan')->nullable()->change();
            $table->text('catatan')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_treatment', function (Blueprint $table) {
            $table->string('sebelum_foto')->nullable(false)->change();
            $table->string('sesudah_foto')->nullable(false)->change();
            $table->text('produk_digunakan')->nullable(false)->change();
            $table->text('catatan')->nullable(false)->change();
        });
    }
};
