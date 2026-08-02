<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('troli', function (Blueprint $table) {
            $table->unsignedBigInteger('id_produk')->nullable()->after('produk_slug');

            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('troli', function (Blueprint $table) {
            $table->dropForeign(['id_produk']);
            $table->dropColumn('id_produk');
        });
    }
};
