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
        Schema::table('favorit_produk', function (Blueprint $table) {
            $table->unique(['id_user', 'id_produk']);
            $table->dropUnique('favorit_produk_id_user_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favorit_produk', function (Blueprint $table) {
            $table->dropUnique('favorit_produk_id_user_id_produk_unique');
            $table->unique('id_user');
        });
    }
};
