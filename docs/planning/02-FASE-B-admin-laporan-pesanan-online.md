# Fase B — Admin & Laporan Pesanan Online

> Estimasi: ~3–4 jam | Depends on: Fase A (opsional, independen) | Menyalakan: — (laporan sumber berguna untuk Fase D)

---

## 1. Tujuan
Admin dapat memantau pesanan online (view-only sesuai keputusan), kasir dapat memfilter pesanan online berdasarkan status, laporan dapat dipisah sumber (kasir/online), dan dashboard menampilkan statistik pesanan online.

## 2. Langkah

### 2.1 Halaman admin "Pesanan Online" (view-only)
- Controller baru: `app/Http/Controllers/AdminPesananOnlineController.php`
  - `index()` — list transaksi `sumber = 'online'` (relasi `pembayaran`, `user`, `detail`), filter status.
  - `show($id)` — detail transaksi + pembayaran + status (tanpa aksi konfirmasi/tolak).
- Route baru (grup admin, `routes/web.php` bagian admin): `admin/pesanan-online` (index & `{id}` — urutkan route `{id}` di akhir).
- Menu sidebar admin `resources/views/layouts/sidebar-admin.blade.php`: item "Pesanan Online" + badge count menunggu (bila pola sidebar lain sudah memakai badge).
- Style: ikuti pola halaman kasir `pesanan-online.blade.php` yang sudah ada.

### 2.2 Filter tab status di kasir — `resources/views/kasir/pembayaran/pesanan-online.blade.php`
- Tab filter: **Semua / Menunggu / Sedang Diproses / Lunas / Ditolak / Kadaluarsa / Dibatalkan**.
- Backend: `KasirPembayaranController@pesananOnline()` terima `?status=...` (nilai `transaksi.status`).
- Default tab menampilkan semua; badge count per status opsional.

### 2.3 Filter sumber di laporan (kasir & admin) + export
- `app/Http/Controllers/AdminLaporanController.php` (index baris 17, exportPDF 176, exportExcel 234) & `app/Http/Controllers/KasirLaporanController.php` (index 15, exportPDF 219, exportExcel 264):
  - Tambah parameter `sumber` (Semua / Kasir / Online) → `where('sumber', ...)`.
  - Filter ikut serta di export PDF & Excel (view yang dipakai sama).
- View laporan: tambah dropdown sumber di form filter (`resources/views/admin/laporan/index.blade.php`, `resources/views/kasir/laporan/index.blade.php` — cek nama persis saat implementasi).

### 2.4 Statistik dashboard
- `app/Http/Controllers/KasirDashboardController.php` & `app/Http/Controllers/AdminDashboardController.php`:
  - Tambah `pesananOnlineHariIni` (jumlah transaksi `sumber='online'` tanggal hari ini) + nominal total.
  - Tampilkan di `resources/views/kasir/dashboard.blade.php` & `resources/views/admin/dashboard.blade.php` (kartu/stat kecil).

## 3. QA (wajib)
1. Login admin → menu "Pesanan Online" tampil, halaman index & show render, tanpa tombol aksi.
2. Kasir: tab filter menampilkan data sesuai status (uji tiap tab dengan data transaksi online berbagai status).
3. Laporan: filter sumber menghasilkan data benar; export PDF/Excel ikut terfilter (nama file ekspor tetap).
4. Dashboard kasir & admin menampilkan stat pesanan online hari ini.
5. `php artisan route:list` — tidak ada konflik `{id}` vs route statis.
