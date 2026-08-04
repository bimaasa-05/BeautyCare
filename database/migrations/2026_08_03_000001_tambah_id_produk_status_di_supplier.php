<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supplier', function (Blueprint $table) {
            $table->unsignedBigInteger('id_produk')->nullable()->after('alamat');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('set null');
            $table->enum('status', ['Aktif', 'Non Aktif'])->default('Aktif')->after('id_produk');
        });
    }

    public function down(): void
    {
        Schema::table('supplier', function (Blueprint $table) {
            $table->dropForeign(['id_produk']);
            $table->dropColumn(['id_produk', 'status']);
        });
    }
};
