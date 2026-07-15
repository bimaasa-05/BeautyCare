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
        Schema::create(
            'notifikasi',
            function (Blueprint $table) {
                $table->id('id_notif');
                $table->integer('id_user')->unique();
                $table->string('judul', 150);
                $table->text('isi');
                $table->enum('type', ['Booking', 'Promo', 'Stok', 'Transaksi', 'Lainnya']);
                $table->tinyInteger('status');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
