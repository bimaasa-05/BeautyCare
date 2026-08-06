<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('id_kasir', 255)->nullable()->after('id_user');
        });

        DB::statement("UPDATE transaksi SET id_kasir = id_user WHERE sumber = 'kasir' AND id_kasir IS NULL");
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn('id_kasir');
        });
    }
};
