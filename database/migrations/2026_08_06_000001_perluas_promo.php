<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promo', function (Blueprint $table) {
            $table->string('kode_promo', 30)->nullable()->unique()->after('nm_promo');
            $table->text('deskripsi')->nullable()->after('nilai');
            $table->string('target', 20)->default('semua')->after('deskripsi');
        });

        Schema::create('promo_target', function (Blueprint $table) {
            $table->id('id_promo_target');
            $table->integer('id_promo');
            $table->integer('id_pelanggan');
        });

        $prefix = [
            'Diskon' => 'DSK',
            'Cashback' => 'CB',
            'Paket' => 'PKT',
            'Buy 1 Get 1' => 'BOGO',
            'Lainnya' => 'LNY',
        ];

        foreach (DB::table('promo')->orderBy('id_promo')->get() as $promo) {
            if ($promo->kode_promo) {
                continue;
            }

            $kode = ($prefix[$promo->jenis_promo] ?? 'PRO') . '-' . str_pad($promo->id_promo, 3, '0', STR_PAD_LEFT);
            DB::table('promo')->where('id_promo', $promo->id_promo)->update(['kode_promo' => $kode]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_target');

        Schema::table('promo', function (Blueprint $table) {
            $table->dropColumn(['kode_promo', 'deskripsi', 'target']);
        });
    }
};
