<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_booking', function (Blueprint $table) {
            $table->id('id_log_booking');
            $table->integer('id_pelanggan');
            $table->date('tanggal');
            $table->timestamp('created_at')->useCurrent();
        });

        \App\Models\Booking::chunk(100, function ($bookings) {
            foreach ($bookings as $booking) {
                \Illuminate\Support\Facades\DB::table('log_booking')->insert([
                    'id_pelanggan' => $booking->id_pelanggan,
                    'tanggal' => $booking->tanggal,
                    'created_at' => $booking->tanggal . ' ' . ($booking->jam ?? '00:00:00'),
                ]);
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_booking');
    }
};
