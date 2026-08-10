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
                $table->decimal('saldo', 15, 2)->default(0)->after('tgl_mulai_member');
            });
        }

        $rows = DB::table('saldo_mutasi')
            ->select('id_pelanggan')
            ->selectRaw('SUM(CASE WHEN type = "kredit" THEN nominal ELSE 0 END) - SUM(CASE WHEN type = "debit" THEN nominal ELSE 0 END) as saldo')
            ->groupBy('id_pelanggan')
            ->get();

        foreach ($rows as $row) {
            DB::table('pelanggan')->where('id_pelanggan', $row->id_pelanggan)->update([
                'saldo' => $row->saldo,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn('saldo');
        });
    }
};
