<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('aktif', 'non_aktif', 'suspend', 'menunggu_persetujuan') DEFAULT 'menunggu_persetujuan' NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('aktif', 'non_aktif', 'suspend') DEFAULT 'suspend' NOT NULL");
    }
};
