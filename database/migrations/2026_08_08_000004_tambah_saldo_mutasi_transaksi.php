<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saldo_mutasi', function (Blueprint $table) {
            $table->id('id_mutasi');
            $table->integer('id_pelanggan');
            $table->enum('type', ['kredit', 'debit']);
            $table->decimal('nominal', 15, 2);
            $table->decimal('saldo_sebelum', 15, 2);
            $table->decimal('saldo_sesudah', 15, 2);
            $table->string('keterangan', 255);
            $table->string('ref_type', 50)->nullable();
            $table->integer('ref_id')->nullable();
            $table->timestamps();

            $table->index(['id_pelanggan', 'created_at']);
        });

        Schema::table('transaksi', function (Blueprint $table) {
            $table->decimal('saldo_terpakai', 15, 2)->default(0)->after('total');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn('saldo_terpakai');
        });
        Schema::dropIfExists('saldo_mutasi');
    }
};