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
        Schema::create('membership', function (Blueprint $table) {
            $table->id('id_member');
            $table->string('nm_member', 100);
            $table->enum('tingkat', ['Silver', 'Gold', 'Platinum']);
            $table->decimal('diskon')->default(0);
            $table->bigInteger('masa_berlaku');
            $table->enum('status', ['aktif', 'non_aktif', 'suspend'])->default('non_aktif');
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
