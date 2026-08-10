<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $hargaDefault = [
            'Silver' => 150000,
            'Gold' => 350000,
            'Platinum' => 750000,
        ];

        foreach ($hargaDefault as $tingkat => $harga) {
            DB::table('membership')
                ->where('tingkat', $tingkat)
                ->where('harga', '<=', 0)
                ->update(['harga' => $harga]);
        }

        DB::table('membership')
            ->where('harga', '<=', 0)
            ->update(['harga' => 100000]);
    }

    public function down(): void
    {
        //
    }
};