<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan', function (Blueprint $table) {
            $table->longText('pusat_bantuan_kategori')->nullable()->after('kebijakan_privasi');
            $table->longText('pusat_bantuan_faq')->nullable()->after('pusat_bantuan_kategori');
        });

        $kategoriDefault = [
            ['nama' => 'Akun & Pendaftaran'],
            ['nama' => 'Booking & Treatment'],
            ['nama' => 'Produk & Pembayaran'],
            ['nama' => 'Membership & Promo'],
            ['nama' => 'Umum'],
        ];

        $faqDefault = [
            ['kategori' => 'Akun & Pendaftaran', 'pertanyaan' => 'Bagaimana cara mendaftar akun di BeautyCare?', 'jawaban' => 'Klik tombol "Daftar" di halaman utama, lengkapi data diri (nama, email, nomor HP, dan password), lalu centang persetujuan syarat & ketentuan. Setelah mendaftar, akun Anda akan diverifikasi oleh admin sebelum dapat digunakan.'],
            ['kategori' => 'Akun & Pendaftaran', 'pertanyaan' => 'Bagaimana jika saya lupa password?', 'jawaban' => 'Gunakan fitur "Lupa Password" pada halaman login untuk mereset password Anda. Jika mengalami kendala, hubungi admin BeautyCare melalui halaman kontak.'],
            ['kategori' => 'Booking & Treatment', 'pertanyaan' => 'Bagaimana cara melakukan booking treatment?', 'jawaban' => 'Setelah login sebagai pelanggan, buka menu "Booking", pilih treatment yang diinginkan, tentukan tanggal dan jam, lalu pilih beautycian yang tersedia dan konfirmasi booking.'],
            ['kategori' => 'Booking & Treatment', 'pertanyaan' => 'Bisakah saya membatalkan atau mengubah jadwal booking?', 'jawaban' => 'Ya. Anda dapat membatalkan atau mengubah jadwal booking melalui menu "Booking" sebelum jadwal diterima/diproses oleh kasir. Hubungi kasir atau admin jika booking sudah dikonfirmasi.'],
            ['kategori' => 'Produk & Pembayaran', 'pertanyaan' => 'Metode pembayaran apa saja yang tersedia?', 'jawaban' => 'Pembayaran dapat dilakukan secara tunai di kasir, transfer bank yang terdaftar pada BeautyCare, maupun melalui saldo akun pelanggan yang tersedia di halaman "Saldo Akun".'],
            ['kategori' => 'Produk & Pembayaran', 'pertanyaan' => 'Bagaimana cara cek status pembayaran pesanan online?', 'jawaban' => 'Buka menu "Pesanan" lalu pilih transaksi yang ingin dicek. Status pembayaran akan ditampilkan beserta detail transaksinya. Anda juga dapat mengunggah bukti pembayaran di halaman tersebut.'],
            ['kategori' => 'Membership & Promo', 'pertanyaan' => 'Bagaimana cara mendapatkan membership?', 'jawaban' => 'Membership dapat diperoleh dengan memenuhi syarat minimal transaksi dan total pembelian, atau bergabung langsung melalui halaman Membership setelah login. Setiap level memberikan diskon dan keuntungan yang semakin besar.'],
            ['kategori' => 'Membership & Promo', 'pertanyaan' => 'Bagaimana cara klaim promo?', 'jawaban' => 'Buka halaman "Promo" pada akun pelanggan Anda, pilih promo yang tersedia, lalu klik tombol "Klaim Promo". Promo yang berhasil diklaim dapat digunakan pada transaksi sesuai dengan syarat yang berlaku.'],
            ['kategori' => 'Umum', 'pertanyaan' => 'Apakah BeautyCare bisa diakses dari HP?', 'jawaban' => 'Ya. BeautyCare dapat diakses melalui browser di perangkat apa pun (desktop, tablet, maupun smartphone). Tampilan sudah responsif di semua ukuran layar.'],
            ['kategori' => 'Umum', 'pertanyaan' => 'Bagaimana dengan keamanan data saya?', 'jawaban' => 'Keamanan adalah prioritas utama. Semua data dienkripsi menggunakan SSL/TLS, disimpan di server aman, dan dilakukan backup data secara rutin.'],
        ];

        DB::table('pengaturan')
            ->whereNull('pusat_bantuan_kategori')
            ->update([
                'pusat_bantuan_kategori' => json_encode($kategoriDefault),
                'pusat_bantuan_faq' => json_encode($faqDefault),
            ]);
    }

    public function down(): void
    {
        Schema::table('pengaturan', function (Blueprint $table) {
            $table->dropColumn(['pusat_bantuan_kategori', 'pusat_bantuan_faq']);
        });
    }
};