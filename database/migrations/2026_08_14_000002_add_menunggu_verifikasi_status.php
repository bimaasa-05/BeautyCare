<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (config("database.default") !== "sqlite") {
            if (Schema::hasColumn("users", "status")) {
                $columns = DB::select("SHOW COLUMNS FROM users WHERE field = \"status\"");
                $type = $columns[0]->Type ?? "";
                if (! str_contains($type, "menunggu_verifikasi")) {
                    DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM(\"aktif\",\"non_aktif\",\"suspend\",\"menunggu_persetujuan\",\"menunggu_verifikasi\") DEFAULT \"non_aktif\" NOT NULL");
                }
            }
        }
    }

    public function down(): void
    {
        if (config("database.default") !== "sqlite") {
            if (Schema::hasColumn("users", "status")) {
                DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM(\"aktif\",\"non_aktif\",\"suspend\",\"menunggu_persetujuan\") DEFAULT \"non_aktif\" NOT NULL");
            }
        }
    }
};
