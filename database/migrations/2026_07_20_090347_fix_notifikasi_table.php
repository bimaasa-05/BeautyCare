<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->dropUnique('notifikasi_id_user_unique');
        });

        Schema::table('notifikasi', function (Blueprint $table) {
            $table->text('url')->nullable()->after('isi');
            $table->timestamp('read_at')->nullable()->after('url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->dropColumn(['url', 'read_at', 'created_at', 'updated_at']);
            $table->unique('id_user');
        });
    }
};
