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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id('id_karyawan');
            $table->foreignId('id_user')->unique()->constrained('users', 'id')->onDelete('cascade');
            $table->string('NIP');
            $table->string('jabatan', 50);
            $table->string('alamat', 255);
            $table->date('tgl_lahir');
            $table->decimal('gaji', 12);
            $table->decimal('komisi', 5);
            $table->date('tgl_masuk');
            $table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
