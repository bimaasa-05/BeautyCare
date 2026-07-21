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
        //
        Schema::create('stok', function (Blueprint $table) {
            $table->id('id_stok');
            $table->integer('id_produk');
            $table->date('tanggal');
            $table->enum('type', ['Masuk', 'Keluar', 'Penyesuaian']);
            $table->integer('jumlah');
            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');
            $table->text('keterangan');
            $table->integer('ref_id');
            $table->string('ref_type', 50);
            $table->tinyInteger('status');
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
