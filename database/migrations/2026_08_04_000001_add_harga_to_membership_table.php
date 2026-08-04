<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('membership', function (Blueprint $table) {
            $table->decimal('harga', 12)->default(0)->after('min_pembelian');
        });

        $hargaDefault = [
            'Silver' => 150000,
            'Gold' => 350000,
            'Platinum' => 750000,
        ];

        foreach ($hargaDefault as $tingkat => $harga) {
            DB::table('membership')->where('tingkat', $tingkat)->update(['harga' => $harga]);
        }
    }

    public function down(): void
    {
        Schema::table('membership', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
    }
};
