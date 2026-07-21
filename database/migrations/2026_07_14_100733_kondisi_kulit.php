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
        Schema::create('kondisi_kulit', function (Blueprint $table) {
            $table->id('id_kondisi');
            $table->integer('id_pelanggan');
            $table->date('tanggal');
            $table->enum('jenis_kulit', ['Berminyak', 'Kering', 'Sensitif', 'Normal', 'Kombinasi']);
            $table->text('catatan');
            $table->string('foto');
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
