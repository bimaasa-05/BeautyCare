<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kategori_produk', function (Blueprint $table) {
            $table->renameColumn('nm_kategori', 'nm_produk');
        });
    }

    public function down(): void
    {
        Schema::table('kategori_produk', function (Blueprint $table) {
            $table->renameColumn('nm_produk', 'nm_kategori');
        });
    }
};
