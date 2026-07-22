<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use App\Models\KategoriLayanan;
use App\Models\KategoriProduk;
use App\Models\Layanan;
use App\Models\Membership;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\Promo;
use App\Models\Supplier;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\User;
use Illuminate\Database\Seeder;

class KasirSeeder extends Seeder
{
    public function run(): void
    {
        $this->kategoriLayanan();
        $this->layanan();
        $this->supplier();
        $this->kategoriProduk();
        $this->produk();
        $this->membership();
        $this->pelanggan();
        $this->karyawan();
        $this->promo();
        $this->transaksiDanDetail();
    }

    private function kategoriLayanan(): void
    {
        $data = [
            ['nm_layanan' => 'Facial & Perawatan Wajah', 'status' => 'tersedia'],
            ['nm_layanan' => 'Body Massage & Spa', 'status' => 'tersedia'],
            ['nm_layanan' => 'Hair & Salon', 'status' => 'tersedia'],
            ['nm_layanan' => 'Nail Art & Manicure', 'status' => 'tersedia'],
            ['nm_layanan' => 'Makeup & Brow', 'status' => 'tersedia'],
        ];
        foreach ($data as $d) {
            KategoriLayanan::create($d);
        }
    }

    private function layanan(): void
    {
        $data = [
            ['id_kategori' => 1, 'nm_layanan' => 'Facial Basic', 'durasi' => 45, 'harga' => 150000, 'status' => 'Tersedia'],
            ['id_kategori' => 1, 'nm_layanan' => 'Facial Acne', 'durasi' => 60, 'harga' => 200000, 'status' => 'Tersedia'],
            ['id_kategori' => 1, 'nm_layanan' => 'Facial Anti Aging', 'durasi' => 75, 'harga' => 300000, 'status' => 'Tersedia'],
            ['id_kategori' => 1, 'nm_layanan' => 'Hifu Treatment', 'durasi' => 60, 'harga' => 500000, 'status' => 'Tersedia'],
            ['id_kategori' => 2, 'nm_layanan' => 'Body Massage 60min', 'durasi' => 60, 'harga' => 180000, 'status' => 'Tersedia'],
            ['id_kategori' => 2, 'nm_layanan' => 'Body Massage 90min', 'durasi' => 90, 'harga' => 250000, 'status' => 'Tersedia'],
            ['id_kategori' => 2, 'nm_layanan' => 'Hot Stone Massage', 'durasi' => 90, 'harga' => 350000, 'status' => 'Tersedia'],
            ['id_kategori' => 2, 'nm_layanan' => 'Body Scrub & Mask', 'durasi' => 60, 'harga' => 200000, 'status' => 'Tersedia'],
            ['id_kategori' => 3, 'nm_layanan' => 'Haircut & Styling', 'durasi' => 45, 'harga' => 120000, 'status' => 'Tersedia'],
            ['id_kategori' => 3, 'nm_layanan' => 'Hair Coloring', 'durasi' => 120, 'harga' => 450000, 'status' => 'Tersedia'],
            ['id_kategori' => 3, 'nm_layanan' => 'Hair Treatment Keratin', 'durasi' => 90, 'harga' => 350000, 'status' => 'Tersedia'],
            ['id_kategori' => 3, 'nm_layanan' => 'Blow Dry & Set', 'durasi' => 30, 'harga' => 80000, 'status' => 'Tersedia'],
            ['id_kategori' => 4, 'nm_layanan' => 'Manicure Classic', 'durasi' => 45, 'harga' => 100000, 'status' => 'Tersedia'],
            ['id_kategori' => 4, 'nm_layanan' => 'Pedicure Classic', 'durasi' => 45, 'harga' => 100000, 'status' => 'Tersedia'],
            ['id_kategori' => 4, 'nm_layanan' => 'Nail Art Design', 'durasi' => 60, 'harga' => 150000, 'status' => 'Tersedia'],
            ['id_kategori' => 5, 'nm_layanan' => 'Makeup Natural', 'durasi' => 45, 'harga' => 200000, 'status' => 'Tersedia'],
            ['id_kategori' => 5, 'nm_layanan' => 'Makeup Glamour', 'durasi' => 60, 'harga' => 350000, 'status' => 'Tersedia'],
            ['id_kategori' => 5, 'nm_layanan' => 'Eyebrow Embroidery', 'durasi' => 90, 'harga' => 400000, 'status' => 'Tersedia'],
            ['id_kategori' => 5, 'nm_layanan' => 'Lash Lift & Tint', 'durasi' => 45, 'harga' => 175000, 'status' => 'Tersedia'],
        ];
        foreach ($data as $d) {
            Layanan::create($d);
        }
    }

    private function supplier(): void
    {
        $data = [
            ['nm_supplier' => 'PT. Cosmetica Indah', 'no_hp' => '021-5551001', 'alamat' => 'Jl. Industri Raya No. 10, Jakarta'],
            ['nm_supplier' => 'CV. Bahan Baku Sehat', 'no_hp' => '021-5551002', 'alamat' => 'Jl. Niaga Timur No. 25, Bandung'],
            ['nm_supplier' => 'UD. Salon Perkasa', 'no_hp' => '031-5552001', 'alamat' => 'Jl. Komersial No. 8, Surabaya'],
            ['nm_supplier' => 'PT. Natural Beauty Supply', 'no_hp' => '061-5553001', 'alamat' => 'Jl. Sentral No. 15, Medan'],
            ['nm_supplier' => 'Toko Indah Jaya', 'no_hp' => '0274-555401', 'alamat' => 'Jl. Pasar Besar No. 3, Yogyakarta'],
        ];
        foreach ($data as $d) {
            Supplier::create($d);
        }
    }

    private function kategoriProduk(): void
    {
        $data = [
            ['nm_produk' => 'Skincare', 'status' => 'tersedia'],
            ['nm_produk' => 'Hair Care', 'status' => 'tersedia'],
            ['nm_produk' => 'Body Care', 'status' => 'tersedia'],
            ['nm_produk' => 'Nail Care', 'status' => 'tersedia'],
            ['nm_produk' => 'Makeup', 'status' => 'tersedia'],
        ];
        foreach ($data as $d) {
            KategoriProduk::create($d);
        }
    }

    private function produk(): void
    {
        $data = [
            ['id_kategori_produk' => 1, 'id_supplier' => 1, 'barcode' => '8991001001001', 'nm_produk' => 'Serum Vitamin C 15ml', 'satuan' => 'Botol', 'harga_beli' => 45000, 'harga_jual' => 85000, 'stok' => 45, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 1, 'id_supplier' => 1, 'barcode' => '8991001001002', 'nm_produk' => 'Moisturizer Cream 50ml', 'satuan' => 'Botol', 'harga_beli' => 35000, 'harga_jual' => 75000, 'stok' => 30, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 1, 'id_supplier' => 2, 'barcode' => '8991001001003', 'nm_produk' => 'Sunscreen SPF 50 30ml', 'satuan' => 'Tube', 'harga_beli' => 40000, 'harga_jual' => 80000, 'stok' => 50, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 1, 'id_supplier' => 2, 'barcode' => '8991001001004', 'nm_produk' => 'Toner Face Mist 100ml', 'satuan' => 'Botol', 'harga_beli' => 25000, 'harga_jual' => 55000, 'stok' => 60, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 1, 'id_supplier' => 5, 'barcode' => '8991001001005', 'nm_produk' => 'Retinol Night Cream 30ml', 'satuan' => 'Botol', 'harga_beli' => 55000, 'harga_jual' => 110000, 'stok' => 25, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 2, 'id_supplier' => 3, 'barcode' => '8991001002001', 'nm_produk' => 'Shampoo Premium 200ml', 'satuan' => 'Botol', 'harga_beli' => 30000, 'harga_jual' => 65000, 'stok' => 40, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 2, 'id_supplier' => 3, 'barcode' => '8991001002002', 'nm_produk' => 'Conditioner Premium 200ml', 'satuan' => 'Botol', 'harga_beli' => 30000, 'harga_jual' => 65000, 'stok' => 35, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 2, 'id_supplier' => 3, 'barcode' => '8991001002003', 'nm_produk' => 'Hair Mask Sachet 50ml', 'satuan' => 'Sachet', 'harga_beli' => 10000, 'harga_jual' => 25000, 'stok' => 100, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 2, 'id_supplier' => 1, 'barcode' => '8991001002004', 'nm_produk' => 'Hair Serum Argan Oil 30ml', 'satuan' => 'Botol', 'harga_beli' => 40000, 'harga_jual' => 90000, 'stok' => 20, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 3, 'id_supplier' => 4, 'barcode' => '8991001003001', 'nm_produk' => 'Body Lotion 250ml', 'satuan' => 'Botol', 'harga_beli' => 28000, 'harga_jual' => 60000, 'stok' => 55, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 3, 'id_supplier' => 4, 'barcode' => '8991001003002', 'nm_produk' => 'Body Scrub Sugar 200gr', 'satuan' => 'Jar', 'harga_beli' => 22000, 'harga_jual' => 50000, 'stok' => 30, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 3, 'id_supplier' => 4, 'barcode' => '8991001003003', 'nm_produk' => 'Hand Body Cream 100ml', 'satuan' => 'Tube', 'harga_beli' => 18000, 'harga_jual' => 40000, 'stok' => 70, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 4, 'id_supplier' => 5, 'barcode' => '8991001004001', 'nm_produk' => 'Nail Polish Set 6 Warna', 'satuan' => 'Set', 'harga_beli' => 35000, 'harga_jual' => 75000, 'stok' => 25, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 4, 'id_supplier' => 5, 'barcode' => '8991001004002', 'nm_produk' => 'Nail Art Sticker Pack', 'satuan' => 'Pack', 'harga_beli' => 8000, 'harga_jual' => 20000, 'stok' => 80, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 4, 'id_supplier' => 5, 'barcode' => '8991001004003', 'nm_produk' => 'Cuticle Oil 10ml', 'satuan' => 'Botol', 'harga_beli' => 12000, 'harga_jual' => 30000, 'stok' => 40, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 5, 'id_supplier' => 1, 'barcode' => '8991001005001', 'nm_produk' => 'Lipstick Matte 12 Warna', 'satuan' => 'Pcs', 'harga_beli' => 25000, 'harga_jual' => 55000, 'stok' => 35, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 5, 'id_supplier' => 1, 'barcode' => '8991001005002', 'nm_produk' => 'Face Powder Loose', 'satuan' => 'Pcs', 'harga_beli' => 40000, 'harga_jual' => 90000, 'stok' => 20, 'foto' => '', 'status' => 'Tersedia'],
            ['id_kategori_produk' => 5, 'id_supplier' => 2, 'barcode' => '8991001005003', 'nm_produk' => 'Setting Spray 50ml', 'satuan' => 'Botol', 'harga_beli' => 30000, 'harga_jual' => 70000, 'stok' => 30, 'foto' => '', 'status' => 'Tersedia'],
        ];
        foreach ($data as $d) {
            Produk::create($d);
        }
    }

    private function membership(): void
    {
        $data = [
            ['nm_member' => 'Silver Member', 'tingkat' => 'Silver', 'diskon' => 5.00, 'masa_berlaku' => 365, 'status' => 'aktif'],
            ['nm_member' => 'Gold Member', 'tingkat' => 'Gold', 'diskon' => 10.00, 'masa_berlaku' => 365, 'status' => 'aktif'],
            ['nm_member' => 'Platinum Member', 'tingkat' => 'Platinum', 'diskon' => 15.00, 'masa_berlaku' => 365, 'status' => 'aktif'],
        ];
        foreach ($data as $d) {
            Membership::create($d);
        }
    }

    private function pelanggan(): void
    {
        $data = [
            ['nm_pelanggan' => 'Sinta Dewi', 'no_hp' => '081234567801', 'email' => 'sinta@email.com', 'alamat' => 'Jl. Merpati No. 1, Jakarta', 'id_member' => 1, 'catatan_alergi' => 'Alergi pewangi buatan'],
            ['nm_pelanggan' => 'Dian Sari', 'no_hp' => '081234567802', 'email' => 'dian@email.com', 'alamat' => 'Jl. Kenanga No. 5, Bandung', 'id_member' => 2, 'catatan_alergi' => 'Tidak ada'],
            ['nm_pelanggan' => 'Rina Melati', 'no_hp' => '081234567803', 'email' => 'rina@email.com', 'alamat' => 'Jl. Anggrek No. 10, Surabaya', 'id_member' => 3, 'catatan_alergi' => 'Alergi lateks'],
            ['nm_pelanggan' => 'Ani Wijaya', 'no_hp' => '081234567804', 'email' => 'ani@email.com', 'alamat' => 'Jl. Mawar No. 15, Medan', 'id_member' => null, 'catatan_alergi' => 'Tidak ada'],
            ['nm_pelanggan' => 'Bayu Segara', 'no_hp' => '081234567805', 'email' => 'bayu@email.com', 'alamat' => 'Jl. Melati No. 20, Yogyakarta', 'id_member' => 1, 'catatan_alergi' => 'Kulit sensitif'],
            ['nm_pelanggan' => 'Rudi Hartono', 'no_hp' => '081234567806', 'email' => 'rudi@email.com', 'alamat' => 'Jl. Dahlia No. 8, Semarang', 'id_member' => null, 'catatan_alergi' => 'Tidak ada'],
            ['nm_pelanggan' => 'Nina Zahra', 'no_hp' => '081234567807', 'email' => 'nina@email.com', 'alamat' => 'Jl. Cempaka No. 12, Bali', 'id_member' => 2, 'catatan_alergi' => 'Alergi bahan kimia tertentu'],
            ['nm_pelanggan' => 'Maya Anggraini', 'no_hp' => '081234567808', 'email' => 'maya@email.com', 'alamat' => 'Jl. Flamboyan No. 3, Makassar', 'id_member' => null, 'catatan_alergi' => 'Tidak ada'],
            ['nm_pelanggan' => 'Adi Putra', 'no_hp' => '081234567809', 'email' => 'adi@email.com', 'alamat' => 'Jl. Kamboja No. 7, Palembang', 'id_member' => null, 'catatan_alergi' => 'Tidak ada'],
            ['nm_pelanggan' => 'Sari Indah', 'no_hp' => '081234567810', 'email' => 'sari@email.com', 'alamat' => 'Jl. Teratai No. 2, Aceh', 'id_member' => 3, 'catatan_alergi' => 'Alergi wewangian'],
        ];
        foreach ($data as $d) {
            Pelanggan::create($d);
        }
    }

    private function karyawan(): void
    {
        $kasir = User::where('email', 'k@gmail.com')->first();
        $beautycian = User::where('email', 'b@gmail.com')->first();

        if ($kasir && !Karyawan::where('id_user', $kasir->id)->exists()) {
            Karyawan::create([
                'id_user' => $kasir->id,
                'NIP' => 'KSR-001',
                'jabatan' => 'Kasir',
                'alamat' => 'Jl. Kasir No. 1, Jakarta',
                'tgl_lahir' => '1998-05-12',
                'gaji' => 3500000,
                'komisi' => 0.50,
                'tgl_masuk' => '2024-01-15',
                'status' => 'Tersedia',
            ]);
        }

        if ($beautycian && !Karyawan::where('id_user', $beautycian->id)->exists()) {
            Karyawan::create([
                'id_user' => $beautycian->id,
                'NIP' => 'BCT-001',
                'jabatan' => 'Beautycian',
                'alamat' => 'Jl. Beautycian No. 1, Bandung',
                'tgl_lahir' => '1996-08-22',
                'gaji' => 4000000,
                'komisi' => 2.00,
                'tgl_masuk' => '2024-02-01',
                'status' => 'Tersedia',
            ]);
        }
    }

    private function promo(): void
    {
        $data = [
            ['nm_promo' => 'Promo Akhir Tahun', 'jenis_promo' => 'Diskon', 'nilai' => 20, 'mulai' => '2026-12-01', 'selesai' => '2026-12-31', 'status' => 'Tersedia'],
            ['nm_promo' => 'Paket Facial + Masker', 'jenis_promo' => 'Paket', 'nilai' => 50000, 'mulai' => '2026-01-01', 'selesai' => '2026-12-31', 'status' => 'Tersedia'],
            ['nm_promo' => 'Cashback Weekend', 'jenis_promo' => 'Cashback', 'nilai' => 25000, 'mulai' => '2026-07-01', 'selesai' => '2026-09-30', 'status' => 'Tersedia'],
        ];
        foreach ($data as $d) {
            Promo::create($d);
        }
    }

    private function transaksiDanDetail(): void
    {
        $userId = User::where('email', 'k@gmail.com')->value('id');
        if (!$userId) return;

        $metodes = ['Tunai', 'Transfer', 'Debit', 'E-Wallet'];
        $statuses = ['Lunas', 'Lunas', 'Lunas', 'Lunas', 'Pending', 'Batal'];
        $invoiceNum = 1;

        $items = [
            // [id_pelanggan, items: [[jenis, id_item, nm_item, qty, harga], ...], metode index, status index]
            [1, [['Layanan', 1, 'Facial Basic', 1, 150000], ['Layanan', 13, 'Manicure Classic', 1, 100000], ['Produk', 1, 'Serum Vitamin C 15ml', 1, 85000]], 0, 0],
            [2, [['Layanan', 5, 'Body Massage 60min', 1, 180000], ['Layanan', 8, 'Body Scrub & Mask', 1, 200000]], 2, 0],
            [3, [['Layanan', 9, 'Haircut & Styling', 1, 120000], ['Layanan', 12, 'Blow Dry & Set', 1, 80000], ['Produk', 6, 'Shampoo Premium 200ml', 1, 65000]], 3, 0],
            [4, [['Layanan', 2, 'Facial Acne', 1, 200000], ['Produk', 2, 'Moisturizer Cream 50ml', 1, 75000], ['Produk', 3, 'Sunscreen SPF 50 30ml', 1, 80000]], 0, 0],
            [5, [['Layanan', 7, 'Hot Stone Massage', 1, 350000]], 1, 0],
            [6, [['Layanan', 10, 'Hair Coloring', 1, 450000], ['Produk', 9, 'Hair Serum Argan Oil 30ml', 1, 90000]], 2, 1],
            [7, [['Layanan', 16, 'Makeup Natural', 1, 200000], ['Layanan', 19, 'Lash Lift & Tint', 1, 175000]], 0, 0],
            [8, [['Layanan', 14, 'Pedicure Classic', 1, 100000], ['Layanan', 15, 'Nail Art Design', 1, 150000], ['Produk', 13, 'Nail Polish Set 6 Warna', 1, 75000]], 3, 0],
            [9, [['Layanan', 3, 'Facial Anti Aging', 1, 300000], ['Produk', 5, 'Retinol Night Cream 30ml', 1, 110000]], 1, 0],
        ];

        foreach ($items as $idx => $item) {
            $pelangganId = $item[0];
            $detailItems = $item[1];
            $metode = $metodes[$item[2]];
            $status = $statuses[$item[3]];

            $subtotal = collect($detailItems)->sum(fn($i) => $i[3] * $i[4]);
            $diskon = $status === 'Lunas' ? rand(0, 1) * 10000 : 0;
            $pajak = $status === 'Lunas' ? round($subtotal * 0.01) : 0;
            $total = $subtotal - $diskon + $pajak;
            $dibayar = $status === 'Lunas' ? $total : ($status === 'Pending' ? $total * 0.5 : 0);
            $kembali = $status === 'Lunas' ? $dibayar - $total : 0;

            $date = date('Y-m-d', strtotime("-" . (20 - $idx) . " days"));

            $noInv = 'INV-' . date('Ymd', strtotime($date)) . '-' . str_pad($invoiceNum++, 4, '0', STR_PAD_LEFT);

            $transaksi = Transaksi::create([
                'id_booking' => $idx + 1,
                'id_pelanggan' => $pelangganId,
                'id_user' => $userId,
                'no_invoice' => $noInv,
                'tanggal' => $date,
                'subtotal' => $subtotal,
                'diskon' => $diskon,
                'pajak' => $pajak,
                'total' => $total,
                'metode_byr' => $metode,
                'dibayar' => $dibayar,
                'kembali' => $kembali,
                'catatan' => '',
                'status' => $status,
            ]);

            foreach ($detailItems as $di) {
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'jenis' => $di[0],
                    'id_item' => $di[1],
                    'nm_item' => $di[2],
                    'qty' => $di[3],
                    'harga' => $di[4],
                    'diskon' => 0,
                    'subtotal' => $di[3] * $di[4],
                ]);
            }
        }
    }
}
