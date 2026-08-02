# Fase D — Pembayaran Online Reservasi

> Estimasi: ~4–5 jam | Depends on: Fase B (filter sumber laporan berguna), Fase C (bukti bayar bisa dipakai juga di sini) | Fase paling besar — dikerjakan terakhir

---

## 1. Tujuan
Pelanggan dapat membayar reservasi (booking layanan) secara online melalui alur pembayaran VA/QRIS/E-Wallet yang sama dengan checkout produk, lengkap dengan verifikasi kasir dan sinkronisasi status booking.

## 2. Kondisi Saat Ini (grounding)

| Aspek | Kondisi |
|---|---|
| Status booking | `menunggu`, `dikonfirmasi`, `selesai`, `dibatalkan` (huruf kecil, kolom `status`) |
| Alur kasir | `KasirReservasiController` (CRUD + `konfirmasi` di `routes/web.php:214`); pembayaran reservasi di kasir lewat transaksi |
| Tabel transaksi | Sudah punya `id_booking` (nullable) |
| Detail transaksi | `detail_transaksi` punya kolom `jenis` (nilai existing: cek migrasi — untuk transaksi online produk dipakai `'Produk'`; layanan → `'Layanan'`) |
| Promo | Promo produk (checkout produk) vs promo layanan (`promo_layanan`); booking store sudah pakai klaim promo → `digunakan` (`PelangganBookingController.php:129`) |
| Relasi | `Transaksi::booking()`; `Booking::transaksi()` sudah ada di model |

## 3. Alur yang Dituju

```
Pelanggan (booking menunggu/dikonfirmasi, belum lunas)
  → Halaman "Bayar Sekarang" pada booking
  → Checkout reservasi: pilih metode (Transfer/QRIS/E-Wallet)
  → Transaksi: sumber='online', id_booking=…, detail jenis='Layanan'
  → Pembayaran VA/QRIS/EW (timer: 15 mnt / 24 jam)
  → Pelanggan bayar → (opsional) upload bukti (Fase C)
  → Kasir verifikasi (pesanan-online)
      ├─ Konfirmasi → transaksi Lunas, stok tidak terpengaruh,
      │               booking → 'selesai', buat RiwayatTreatment bila belum ada
      └─ Tolak → transaksi 'Ditolak', booking kembali ke status semula
  → Gagal/Kadaluarsa → pelanggan boleh buat transaksi baru (retry)
```

## 4. Langkah

### 4.1 Persiapkan data & aturan
- Helper `bankTujuan()` & `generateKodePembayaran()` di `CheckoutController` bersifat statis → siap dipakai ulang.
- Identifikasi struktur `detail_transaksi` (kolom `jenis`, `id_item`, `nm_item`, `harga`, `qty`) — pastikan nilai yang dipakai untuk layanan konsisten.

### 4.2 Checkout reservasi
- Perluas `CheckoutController` (atau controller baru `CheckoutReservasiController` — putuskan saat implementasi, preferensi: perluas dengan param `booking_id` agar view checkout dipakai ulang):
  - `create(Request)` dengan `?booking_id=…`: muat booking milik user (guard), cek status `menunggu`/`dikonfirmasi`, cek belum ada transaksi aktif (lihat 4.3).
  - `resolveItems` → source item dari `detail_booking` (layanan) bukan troli.
  - `hitungPromo` → promo layanan yang relevan (sudah diclaim di booking? jangan potong ganda — booking store sudah menandai promo `digunakan`; konfirmasi behavior diskon saat implementasi).
  - `store` → `id_booking` terisi, `id_produk` kosong, detail `jenis='Layanan'`, `sumber='online'`.
- Guard khusus: pemilik booking harus `(int)` cast untuk `id_user` transaksi (pola existing).

### 4.3 Guard satu pembayaran aktif per booking
- Sebelum buat transaksi: cek apakah booking sudah punya transaksi `sumber='online'` berstatus `Menunggu`/`Sedang Diproses` → blokir dengan pesan "sudah ada pembayaran aktif".
- Retry hanya boleh bila transaksi terakhir `Ditolak`/`Gagal`/`Kadaluarsa`/`Dibatalkan`.

### 4.4 Kasir verifikasi & sinkronisasi booking
- `KasirPembayaranController@verifikasi()` — cabang jika `transaksi->id_booking` terisi:
  - Konfirmasi → booking `status='selesai'`; jangan decrement stok; buat notif pelanggan; bila alur riwayat treatment existing butuh, ikuti polanya.
  - Tolak → booking kembali ke `status` sebelum (simpan status lama di `catatan` transaksi saat store, atau ambil dari transaksi aktif sebelumnya — putuskan saat implementasi, preferensi: catat di `catatan`).
- `pesananOnline()` tidak berubah — transaksi online reservasi sudah ikut tampil (karena `sumber='online'`).

### 4.5 Halaman pelanggan
- `pelanggan/booking` (index) — tombol "Bayar" pada booking dengan status layak bayar.
- `pelanggan/pembayaran/show` — otomatis menampilkan ringkasan layanan (detail sudah dari transaksi; sesuaikan label kategori bila perlu).
- `pelanggan/pesanan/show` — tampilkan badge "Reservasi" bila `id_booking` terisi + link ke detail booking.

### 4.6 Pembersihan
- `pesanan:expire` — pastikan batch expire transaksi online produk **tidak mengubah booking** (booking tidak boleh kehilangan status karena transaksi kadaluarsa; retry diizinkan).

## 5. Pertanyaan Desain (putuskan saat implementasi, catat hasil di sini)
- [ ] Diskon promo layanan di transaksi online: pakai klaim promo yang sudah `digunakan` di booking, atau hitung ulang dari promo aktif?
- [ ] Bila booking sudah `dikonfirmasi` oleh kasir lalu pelanggan bayar — tetap ubah ke `selesai` saat verifikasi? (proposal: ya)
- [ ] RiwayatTreatment: dibuat saat verifikasi konfirmasi atau mengikuti alur beautycian existing?

## 6. QA (wajib)
1. Alur penuh: booking → bayar → verifikasi konfirmasi → transaksi Lunas + booking `selesai`.
2. Duplicate guard: transaksi aktif kedua diblokir; retry setelah Gagal/Kadaluarsa berhasil.
3. Verifikasi tolak → booking kembali, retry bisa.
4. Kasir: stok produk **tidak berubah** saat verifikasi transaksi reservasi.
5. `pesanan:expire` tidak merusak status booking.
6. Render semua halaman terpengaruh + `view:cache`.
