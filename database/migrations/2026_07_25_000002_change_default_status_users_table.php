<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('aktif', 'non_aktif', 'suspend') DEFAULT 'suspend' NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('aktif', 'non_aktif', 'suspend') DEFAULT 'non_aktif' NOT NULL");
    }
};