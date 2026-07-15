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
        // pelanggan_membership
        Schema::create('pelanggan_membership', function (Blueprint $table) {
            $table->id('id_pelanggan_membership');
            $table->integer('id_pelanggan')->unique();
            $table->integer('id_member')->unique();
            $table->text('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
