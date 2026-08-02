# Fase C — Upload Bukti Bayar Pelanggan

> Estimasi: ~2 jam | Depends on: — | Menyalakan: memperkuat alur verifikasi kasir (Fase B tidak wajib mendahului)

---

## 1. Tujuan
Pelanggan yang memilih metode Transfer dapat mengunggah bukti pembayaran (screenshot) dari halaman pembayaran, sehingga kasir memiliki bukti visual saat verifikasi.

## 2. Fakta Penting (tanpa migrasi)
- Kolom `transaksi.bukti_bayar` **sudah ada** dan sudah dipakai kasir/admin sebagai upload file:
  - `KasirTransaksiController.php:115-116` → `store('uploads/bukti_bayar', 'public')`
  - `KasirPembayaranController.php:110-111` → `store('bukti-bayar', 'public')`
- Validasi existing: image `jpeg/png/jpg`, maks 2 MB.
- Storage: disk `public`, pastikan `php artisan storage:link` aktif.

## 3. Langkah

### 3.1 Form upload — `resources/views/pelanggan/pembayaran/show.blade.php`
- Tampilkan form **hanya saat** transaksi status `Menunggu`/`Sedang Diproses` (sebelum Lunas) — setelah `berhasil()` (status Diproses) juga boleh.
- Elemen: input file + tombol "Unggah Bukti"; preview gambar bila `bukti_bayar` sudah ada + opsi ganti.
- Tampilkan nama file/status unggahan dengan feedback sukses/gagal.

### 3.2 Endpoint — `app/Http/Controllers/PembayaranController.php`
- Method baru `uploadBukti(Request $request, $id)`:
  - Guard IDOR dengan cast `(int)` (pola existing baris 19).
  - Validasi: `bukti_bayar` required, `image|mimes:jpeg,png,jpg|max:2048`.
  - Simpan ke `uploads/bukti_bayar` (konsisten dengan kasir).
  - Jika ada file lama → hapus via `Storage::disk('public')->delete()`.
  - Notif kasir: `buatNotif()` — "Bukti bayar baru untuk [no_invoice]" (user role kasir).
  - Redirect balik dengan flash sukses.
- Route baru di grup pelanggan: `POST /pelanggan/pembayaran/{id}/bukti` → `pelanggan.pembayaran.bukti` (letakkan sebelum route `{id}` yang bukan POST bila ada konflik; method POST tidak bentrok dengan GET show).

### 3.3 Preview di kasir
- `app/Http/Controllers/KasirPembayaranController.php@pesananOnline()` — sertakan field `bukti_bayar` di data yang dikirim ke view.
- `resources/views/kasir/pembayaran/pesanan-online.blade.php` — thumbnail `Storage::url(...)` bila ada (klik → buka di tab baru / lightbox sederhana).
- **`resources/views/kasir/pembayaran/show.blade.php`** — tambah blok "Bukti Pembayaran": preview foto bukti bayar + link "Lihat Transaksi" (detail transaksi). Ini sesuai permintaan user: "ketika kasir ngecek ada detail pembayaran, bisa lihat foto bukti bayar atau transaksinya juga". Controller `KasirPembayaranController@show` perlu mengirim `$transaksi` + `$transaksi->pembayaran` + `bukti_bayar` (cek apakah sudah dikirim saat ini; tambahkan bila belum).
- Verifikasi tetap bisa berjalan **tanpa** bukti (bukti hanya pelengkap).

### 3.4 Sinkronisasi demo mode
- Di `CHECKOUT_DEMO_MODE=true`, tombol "Simulasi Bayar Berhasil" tetap jalan seperti sekarang (tidak terblokir karena bukti kosong).

## 4. QA (wajib)
1. Pelanggan upload gambar valid → tersimpan, preview muncul, notif kasir masuk.
2. Upload file non-gambar / > 2MB → ditolak dengan pesan validasi.
3. Kasir buka halaman pesanan online → thumbnail bukti tampil; verifikasi konfirmasi/tolak tetap berfungsi.
4. User lain (bukan pemilik) mencoba akses → 403 (IDOR).
