<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('stok')->where('type', 'Penyesuaian')->update(['type' => 'Keluar']);

        Schema::table('stok', function (Blueprint $table) {
            $table->enum('type', ['Masuk', 'Keluar', 'Refund'])->default('Masuk')->change();
        });
    }

    public function down(): void
    {
        DB::table('stok')->where('type', 'Refund')->update(['type' => 'Keluar']);

        Schema::table('stok', function (Blueprint $table) {
            $table->enum('type', ['Masuk', 'Keluar', 'Penyesuaian'])->default('Masuk')->change();
        });
    }
};
