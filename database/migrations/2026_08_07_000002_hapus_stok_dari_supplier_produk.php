<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supplier_produk', function (Blueprint $table) {
            $table->dropColumn('stok');
        });
    }

    public function down(): void
    {
        Schema::table('supplier_produk', function (Blueprint $table) {
            $table->integer('stok')->default(0)->after('id_produk');
        });
    }
};
