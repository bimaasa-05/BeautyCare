# Fase A — Stok & Katalog Pintar

> Estimasi: ~2–3 jam | Depends on: — | Menyalakan: Fase B–D (semua butuh status stok akurat)

---

## 1. Tujuan
Status produk otomatis mengikuti stok, admin mendapat notif stok menipis, katalog pelanggan menampilkan kondisi stok secara visual, dan dead code lama dibersihkan.

## 2. Aturan Status (keputusan user)

| Kondisi stok | Aksi | Catatan |
|---|---|---|
| `stok <= 0` dan status ≠ `Belum Restok` | → `Habis` (otomatis) | |
| `stok > 0` dan status = `Habis` | → `Tersedia` (otomatis) | |
| status `Belum Restok` | **tidak disentuh** | manual admin |

## 3. Langkah

### 3.1 Helper sinkronisasi — `app/Models/Produk.php`
Tambah method:
```php
public static function syncStatusProduk(Produk $produk): bool
```
- Terapkan aturan tabel di atas.
- Return `true` jika status berubah (untuk trigger notif), `false` jika tidak.

### 3.2 Pasang helper di semua titik ubah stok (8 titik)

| File | Baris | Aksi stok |
|---|---|---|
| `app/Http/Controllers/KasirTransaksiController.php` | 139–140 | decrement (store) |
| `app/Http/Controllers/KasirTransaksiController.php` | 288 | increment (refund update) |
| `app/Http/Controllers/KasirTransaksiController.php` | 309–310 | decrement (update) |
| `app/Http/Controllers/KasirTransaksiController.php` | 328 | increment (delete/refund) |
| `app/Http/Controllers/KasirPembayaranController.php` | 211 | decrement (verifikasi online) |
| `app/Http/Controllers/AdminTransaksiController.php` | 146–147 | decrement (store) |
| `app/Http/Controllers/AdminTransaksiController.php` | 255 | increment (refund update) |
| `app/Http/Controllers/AdminTransaksiController.php` | 276–277 | decrement (update) |
| `app/Http/Controllers/AdminTransaksiController.php` | 375 | increment (delete/refund) |
| `app/Http/Controllers/AdminProdukController.php` | store & update | setelah simpan data produk (stok diinput admin) |

> Catatan: `KeranjangController.php:283-284` berisi decrement di dalam `checkoutNotif()` — ikut terhapus (dead code, lihat 3.6).

### 3.3 Notif stok menipis untuk admin
- Setelah sinkron, jika status berubah **transisi**:
  - Stok turun dari `> 5` menjadi `<= 5` (dan `> 0`) → notif "Stok Menipis"
  - Stok menjadi `<= 0` / status jadi `Habis` → notif "Stok Habis"
- Pakai helper `buatNotif()` ke **semua user role `admin`** (id_user admin), `type = 'Produk'`, url ke halaman produk admin.
- Anti-spam: hanya saat transisi; tidak ada notif untuk penurunan dalam zona yang sama.

### 3.4 Dashboard admin — `app/Http/Controllers/AdminDashboardController.php`
- Tambah list produk **Stok Menipis (≤ 5)** dan **Habis** untuk ditampilkan di `resources/views/admin/dashboard.blade.php` (seperti list `stokMenipis` di dashboard kasir).
- Perhatikan query statistik existing (baris 213–215) yang memakai `where('status','Tersedia')` — dipertahankan.

### 3.5 Katalog pintar pelanggan — `resources/views/pelanggan/produk/index.blade.php`
- Badge status di kartu produk: **"Habis"** (merah) saat `stok <= 0` atau status `Habis`; **"Stok Menipis"** (kuning) saat `1 <= stok <= 5`.
- Tombol Beli (`pc-btn-beli`) **disabled** saat Habis: opacity + `cursor: not-allowed`, onclick tidak dipasang.
- Pastikan query `PelangganProdukController@index` mengirim `stok` & `status` ke view (sudah ada).

### 3.6 Hapus dead code
- `app/Http/Controllers/KeranjangController.php` — hapus method `checkoutNotif()` (mulai baris 148) beserta decrement stok di dalamnya.
- `routes/web.php:344` — hapus route `pelanggan.checkout-notif` / `pelanggan.checkout.notif`.
- Verifikasi tidak ada referensi lain (`grep checkout-notif`).

## 4. QA (wajib)
1. Tinker: set stok 0 → status otomatis `Habis`; increment stok → kembali `Tersedia`; produk `Belum Restok` tidak berubah.
2. Simulasi transaksi kasir (store/update/delete) → status ikut sinkron.
3. Render halaman: katalog pelanggan (badge & tombol disabled), dashboard admin (list menipis/habis), dashboard kasir (tidak rusak).
4. `php artisan view:cache` sukses; tidak ada warning blade.
