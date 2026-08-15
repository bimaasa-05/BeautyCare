<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->nullable()->after('id_pelanggan');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
        });

        DB::statement('
            UPDATE pelanggan p
            JOIN users u ON u.email = p.email AND u.role = "pelanggan"
            SET p.id_user = u.id
        ');
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropColumn('id_user');
        });
    }
};