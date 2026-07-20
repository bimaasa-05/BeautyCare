    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropUnique('booking_id_pelanggan_unique');
            $table->dropUnique('booking_id_karyawan_unique');
        });

        Schema::table('detail_booking', function (Blueprint $table) {
            $table->dropUnique('detail_booking_id_booking_unique');
            $table->dropUnique('detail_booking_id_layanan_unique');
        });
    }

    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->integer('id_pelanggan')->unique()->change();
            $table->integer('id_karyawan')->unique()->change();
        });

        Schema::table('detail_booking', function (Blueprint $table) {
            $table->integer('id_booking')->unique()->change();
            $table->integer('id_layanan')->unique()->change();
        });
    }
};
