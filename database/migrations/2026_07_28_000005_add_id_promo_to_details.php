<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_booking', function (Blueprint $table) {
            $table->integer('id_promo')->nullable()->after('subtotal');
        });

        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->integer('id_promo')->nullable()->after('subtotal');
        });
    }

    public function down(): void
    {
        Schema::table('detail_booking', function (Blueprint $table) {
            $table->dropColumn('id_promo');
        });

        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->dropColumn('id_promo');
        });
    }
};
