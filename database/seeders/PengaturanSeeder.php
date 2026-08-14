<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        $pengaturan = Pengaturan::firstOrNew([]);

        $syaratKetentuan = <<<'TXT'
1. Penerimaan Ketentuan
Dengan mengakses dan menggunakan platform BeautyCare, Anda dianggap telah membaca, memahami, dan menyetujui seluruh Syarat & Ketentuan ini. Apabila Anda tidak menyetujui sebagian atau seluruh ketentuan, mohon untuk tidak menggunakan layanan BeautyCare.

2. Layanan
BeautyCare menyediakan layanan reservasi treatment kecantikan, pembelian produk kecantikan, konsultasi, serta program membership bagi pelanggan. Ketersediaan layanan, jadwal, dan tarif dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.

3. Akun Pengguna
Setiap pelanggan wajib mendaftar dan memiliki akun yang valid sebelum melakukan booking atau pembelian. Informasi yang diberikan harus benar dan lengkap. Akun bersifat pribadi dan tidak boleh dipindahtangankan. Anda bertanggung jawab atas seluruh aktivitas yang terjadi pada akun Anda.

4. Reservasi & Treatment
Reservasi dapat dibatalkan atau diubah selama statusnya masih menunggu konfirmasi kasir. Jika booking sudah dikonfirmasi atau diproses, perubahan jadwal harus melalui konfirmasi pihak BeautyCare. Ketidakhadiran tanpa pemberitahuan dapat dikenakan kebijakan sesuai ketentuan salon.

5. Pembayaran & Saldo Akun
Pembayaran dapat dilakukan secara tunai di kasir, transfer bank yang terdaftar, maupun menggunakan saldo akun. Saldo akun bersifat deposit dan dapat digunakan untuk transaksi selanjutnya sesuai ketentuan yang berlaku. Pengisian saldo (top-up) diproses setelah pembayaran terverifikasi.

6. Membership & Promo
Membership diberikan berdasarkan syarat minimal transaksi dan pembelian yang telah ditentukan. Setiap level membership memiliki diskon dan keuntungan yang berbeda. Promo hanya berlaku sesuai ketentuan yang tertera pada masing-masing promo, tidak dapat digabungkan dengan promo lain kecuali dinyatakan lain.

7. Pengembalian & Refund
Produk yang telah dibeli dapat ditukar atau dikembalikan sesuai kebijakan salon dengan menyertakan bukti pembelian. Refund diproses berdasarkan evaluasi dari pihak BeautyCare.

8. Larangan
Pengguna dilarang menyalahgunakan platform untuk tindakan ilegal, mengganggu keamanan sistem, atau menggunakan data pihak lain tanpa izin. Pelanggaran dapat berakibat pemblokiran akun.

9. Perubahan Ketentuan
BeautyCare berhak mengubah Syarat & Ketentuan ini sewaktu-waktu. Perubahan akan diumumkan melalui platform ini dan berlaku sejak tanggal diperbarui.

10. Hubungi Kami
Apabila Anda memiliki pertanyaan mengenai Syarat & Ketentuan ini, silakan hubungi kami melalui halaman kontak atau kanal resmi BeautyCare.
TXT;

        $kebijakanPrivasi = <<<'TXT'
1. Informasi yang Kami Kumpulkan
Kami mengumpulkan data pribadi yang Anda berikan saat mendaftar atau menggunakan layanan, antara lain nama, alamat email, nomor HP, alamat, riwayat booking, riwayat transaksi, dan informasi lain yang relevan dengan layanan BeautyCare.

2. Penggunaan Data
Data pribadi Anda digunakan untuk: memproses booking dan pembayaran, mengelola akun dan saldo, memberikan informasi promo dan membership, menyesuaikan layanan dengan kebutuhan Anda, serta meningkatkan kualitas layanan BeautyCare.

3. Penyimpanan & Keamanan Data
Seluruh data disimpan di server yang aman dan dilindungi menggunakan enkripsi SSL/TLS. Kami melakukan backup data secara rutin serta membatasi akses hanya kepada pihak yang berwenang.

4. Pembagian Data
Kami tidak menjual, menyewakan, atau membagikan data pribadi Anda kepada pihak ketiga, kecuali: diperlukan untuk pemrosesan transaksi (misalnya bank), diminta oleh hukum yang berlaku, atau atas persetujuan tertulis dari Anda.

5. Hak Anda
Anda berhak mengakses, memperbaiki, atau meminta penghapusan data pribadi Anda. Anda juga dapat menonaktifkan akun kapan saja melalui dukungan BeautyCare.

6. Cookie & Teknologi Pelacakan
Platform kami dapat menggunakan cookie untuk meningkatkan pengalaman pengguna, menganalisis lalu lintas, dan mengingat preferensi Anda. Anda dapat menonaktifkan cookie melalui pengaturan browser.

7. Privasi Anak di Bawah Umur
Layanan BeautyCare ditujukan untuk pengguna berusia 17 tahun ke atas. Kami tidak mengumpulkan data anak di bawah umur secara sengaja.

8. Perubahan Kebijakan Privasi
Kebijakan Privasi ini dapat diperbarui sewaktu-waktu. Pembaruan akan diumumkan melalui platform dan berlaku sejak tanggal diperbarui.

9. Hubungi Kami
Jika Anda memiliki pertanyaan terkait kebijakan privasi, silakan hubungi BeautyCare melalui halaman kontak.
TXT;

        $kategori = [
            ['nama' => 'Akun & Pendaftaran'],
            ['nama' => 'Booking & Treatment'],
            ['nama' => 'Produk & Pembayaran'],
            ['nama' => 'Saldo & Membership'],
            ['nama' => 'Umum'],
        ];

        $faq = [
            ['kategori' => 'Akun & Pendaftaran', 'pertanyaan' => 'Bagaimana cara mendaftar akun di BeautyCare?', 'jawaban' => 'Klik tombol "Daftar" di halaman utama, lengkapi data diri (nama, email, nomor HP, dan password), lalu centang persetujuan syarat & ketentuan. Setelah mendaftar, akun Anda akan diverifikasi oleh admin sebelum dapat digunakan.'],
            ['kategori' => 'Akun & Pendaftaran', 'pertanyaan' => 'Bagaimana jika saya lupa password?', 'jawaban' => 'Gunakan fitur "Lupa Password" pada halaman login untuk mereset password Anda. Jika mengalami kendala, hubungi admin BeautyCare melalui halaman kontak.'],
            ['kategori' => 'Akun & Pendaftaran', 'pertanyaan' => 'Bagaimana cara mengubah data profil saya?', 'jawaban' => 'Masuk ke menu profil pada akun pelanggan Anda, kemudian perbarui data seperti nama, nomor HP, atau alamat. Simpan perubahan agar data tersimpan otomatis.'],
            ['kategori' => 'Booking & Treatment', 'pertanyaan' => 'Bagaimana cara melakukan booking treatment?', 'jawaban' => 'Setelah login sebagai pelanggan, buka menu "Booking", pilih treatment yang diinginkan, tentukan tanggal dan jam, lalu pilih beautycian yang tersedia dan konfirmasi booking.'],
            ['kategori' => 'Booking & Treatment', 'pertanyaan' => 'Bisakah saya membatalkan atau mengubah jadwal booking?', 'jawaban' => 'Ya. Anda dapat membatalkan atau mengubah jadwal booking melalui menu "Booking" sebelum jadwal diterima/diproses oleh kasir. Hubungi kasir atau admin jika booking sudah dikonfirmasi.'],
            ['kategori' => 'Booking & Treatment', 'pertanyaan' => 'Kapan pembayaran treatment dilakukan?', 'jawaban' => 'Pembayaran dilakukan setelah treatment selesai, yaitu di kasir salon. Anda juga dapat menggunakan saldo akun sebagai metode pembayaran.'],
            ['kategori' => 'Produk & Pembayaran', 'pertanyaan' => 'Metode pembayaran apa saja yang tersedia?', 'jawaban' => 'Pembayaran dapat dilakukan secara tunai di kasir, transfer bank yang terdaftar pada BeautyCare, maupun melalui saldo akun pelanggan yang tersedia di halaman "Saldo Akun".'],
            ['kategori' => 'Produk & Pembayaran', 'pertanyaan' => 'Bagaimana cara cek status pembayaran pesanan online?', 'jawaban' => 'Buka menu "Pesanan" lalu pilih transaksi yang ingin dicek. Status pembayaran akan ditampilkan beserta detail transaksinya. Anda juga dapat mengunggah bukti pembayaran di halaman tersebut.'],
            ['kategori' => 'Saldo & Membership', 'pertanyaan' => 'Bagaimana cara mengisi saldo akun?', 'jawaban' => 'Buka menu "Saldo Akun", pilih nominal yang diinginkan, lalu selesaikan pembayaran melalui metode yang tersedia. Saldo akan masuk setelah pembayaran terverifikasi oleh admin.'],
            ['kategori' => 'Saldo & Membership', 'pertanyaan' => 'Bagaimana cara mendapatkan membership?', 'jawaban' => 'Membership dapat diperoleh dengan memenuhi syarat minimal transaksi dan total pembelian, atau bergabung langsung melalui halaman Membership setelah login. Setiap level memberikan diskon dan keuntungan yang semakin besar.'],
            ['kategori' => 'Saldo & Membership', 'pertanyaan' => 'Apakah saldo akun bisa dicairkan?', 'jawaban' => 'Saldo akun bersifat deposit dan dapat digunakan untuk transaksi di BeautyCare, namun tidak dapat dicairkan menjadi uang tunai kecuali ada kebijakan khusus yang ditetapkan.'],
            ['kategori' => 'Umum', 'pertanyaan' => 'Apakah BeautyCare bisa diakses dari HP?', 'jawaban' => 'Ya. BeautyCare dapat diakses melalui browser di perangkat apa pun (desktop, tablet, maupun smartphone). Tampilan sudah responsif di semua ukuran layar.'],
            ['kategori' => 'Umum', 'pertanyaan' => 'Bagaimana dengan keamanan data saya?', 'jawaban' => 'Keamanan adalah prioritas utama. Semua data dienkripsi menggunakan SSL/TLS, disimpan di server aman, dan dilakukan backup data secara rutin.'],
            ['kategori' => 'Umum', 'pertanyaan' => 'Bagaimana cara menghubungi BeautyCare?', 'jawaban' => 'Anda dapat menghubungi kami melalui halaman kontak di situs, mengirim pesan ke email resmi, atau melalui kanal sosial media yang tertera pada halaman beranda.'],
        ];

        $sosmed = [
            ['platform' => 'instagram', 'url' => 'https://instagram.com/beautycare'],
            ['platform' => 'facebook', 'url' => 'https://facebook.com/beautycare'],
            ['platform' => 'whatsapp', 'url' => 'https://wa.me/6281234567890'],
        ];

        $data = [
            'nama_salon' => $pengaturan->nama_salon ?: 'BeautyCare Premium',
            'telepon' => $pengaturan->telepon ?: '021-1234-5678',
            'alamat' => $pengaturan->alamat ?: 'Jl. Sudirman No. 123, Jakarta Pusat 10220',
            'email' => $pengaturan->email ?: 'cs@beautycare.id',
            'jam_buka' => $pengaturan->jam_buka ?: '08:00:00',
            'jam_tutup' => $pengaturan->jam_tutup ?: '20:00:00',
            'syarat_ketentuan' => $pengaturan->syarat_ketentuan ?: $syaratKetentuan,
            'kebijakan_privasi' => $pengaturan->kebijakan_privasi ?: $kebijakanPrivasi,
            'pusat_bantuan_kategori' => $pengaturan->pusat_bantuan_kategori ?: json_encode($kategori, JSON_UNESCAPED_UNICODE),
            'pusat_bantuan_faq' => $pengaturan->pusat_bantuan_faq ?: json_encode($faq, JSON_UNESCAPED_UNICODE),
            'sosmed' => $pengaturan->sosmed ?: json_encode($sosmed, JSON_UNESCAPED_UNICODE),
        ];

        Pengaturan::updateOrCreate(['id_pengaturan' => $pengaturan->id_pengaturan ?? 1], $data);
    }
}
