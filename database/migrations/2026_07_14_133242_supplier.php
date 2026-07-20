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
            'supplier',
            function (Blueprint $table) {
                $table->id('id_supplier');
                $table->string('nm_supplier', 100);
                $table->string('no_hp', 20);
                $table->text('alamat');
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
