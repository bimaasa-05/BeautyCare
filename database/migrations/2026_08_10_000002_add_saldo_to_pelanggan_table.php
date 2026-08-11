<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pelanggan', 'saldo')) {
            Schema::table('pelanggan', function (Blueprint $table) {
                $table->decimal('saldo', 15, 2)->default(0)->after('id_user');
            });
        }

        $rows = DB::table('saldo_mutasi as m')
            ->select('m.id_pelanggan', 'm.saldo_sesudah')
            ->whereRaw('m.id_mutasi = (select max(m2.id_mutasi) from saldo_mutasi m2 where m2.id_pelanggan = m.id_pelanggan)')
            ->get();

        foreach ($rows as $row) {
            DB::table('pelanggan')->where('id_pelanggan', $row->id_pelanggan)
                ->update(['saldo' => $row->saldo_sesudah]);
        }
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn('saldo');
        });
    }
};