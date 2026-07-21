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
                $table->integer('id_user');
                $table->unsignedBigInteger('aktor_id')->nullable();
                $table->string('judul', 150);
                $table->text('isi');
                $table->text('url')->nullable();
                $table->enum('type', ['Booking', 'Promo', 'Stok', 'Transaksi', 'Lainnya']);
                $table->tinyInteger('status');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();

                $table->foreign('aktor_id')->references('id')->on('users')->onDelete('set null');
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
