# 11 - FIX BUG ROLE KASIR

**Tanggal**: 17 Agu 2026
**Branch**: `login-g`
**Status**: Selesai dieksekusi

## Latar Belakang

Debug menyeluruh role kasir (dashboard, transaksi, check-in pelanggan, pembayaran, laporan) menemukan beberapa bug & inkonsistensi. Yang paling krusial: kasir melihat & bisa mengkonfirmasi pesanan online yang **belum dibayar** oleh pelanggan.

## Temuan Audit

| # | Area | Masalah | Akar Penyebab |
|---|------|---------|---------------|
| 1 | Pesanan Online | Transaksi `Menunggu Pembayaran` (belum bayar) tampil di kasir, tombol Konfirmasi/Tolak aktif | Query `pesananOnline()` & `index()` memakai `whereIn(['Menunggu Pembayaran','Sedang Diproses'])`; guard `verifikasi()` menerima kedua status |
| 2 | Notifikasi | Notif "Bukti Bayar Baru" dikirim ke kasir saat upload bukti (belum perlu aksi) | `PembayaranController::uploadBukti()` |
| 3 | Check-In | Booking bisa di-check-in / di-undo pada status apa pun (termasuk selesai/batal) | Tanpa guard status di `checkIn()`/`undoCheckIn()` |
| 4 | Transaksi manual | `dibayar` tanpa `gte:total` → transaksi bisa dicatat Lunas padahal kurang bayar | `KasirTransaksiController::store()`/`update()` (bedanya dgn `KasirPembayaranController` yang sudah punya guard) |
| 5 | Transaksi manual | Transaksi Lunas bisa dihapus → cashback/saldo pelanggan menggantung, record `pembayaran` jadi yatim | `destroy()` tanpa guard & tanpa pembersihan `pembayaran` |
| 6 | Dashboard | `produkTerjual` selalu 0 | Query `jenis = 'produk'` lowercase, data riil `'Produk'` |
| 7 | Laporan Pelanggan | Halaman tampil global (semua kasir) tapi export PDF/Excel per-kasir → angka tidak konsisten | `index()`/`exportPDF()` tanpa filter `id_kasir` |
| 8 | Laporan Keuangan | `metodeTerbanyak` tanpa filter periode (minor) | `KasirLaporanController::index()` |

## Keputusan

- Pesanan Online: **Opsi A** — kasir hanya melihat status `Sedang Diproses` (sudah klik "Saya Sudah Bayar" atau bayar saldo penuh).
- Hapus transaksi Lunas: **diblokir** (guard server + tombol disembunyikan); hapus hanya utk status non-final; record `pembayaran` ikut dibersihkan.
- Laporan Pelanggan kasir: **per-kasir** (konsisten dgn export); **admin tetap global** (tidak diubah).

## Perubahan

### 1. Pesanan Online hanya `Sedang Diproses`
- `app/Http/Controllers/KasirPembayaranController.php`
  - `index()`: `pesananOnlineCount` → hanya status `Sedang Diproses`.
  - `pesananOnline()`: query → hanya status `Sedang Diproses`.
  - `verifikasi()`: guard → `status !== 'Sedang Diproses'` ditolak.
- `resources/views/kasir/pembayaran/pesanan-online.blade.php`
  - Kartu statistik: 3 → 2 kartu (Menunggu Verifikasi / Total Pesanan Aktif); kartu "Menunggu Pembayaran" dihapus.
  - Badge status: disederhanakan menjadi badge `Sedang Diproses` (badgeMap dihapus).

### 2. Notifikasi upload bukti
- `app/Http/Controllers/PembayaranController.php` — `uploadBukti()`: notif "Bukti Bayar Baru" ke kasir/admin **dihapus** (kasir hanya dinotifikasi lewat `sudahBayar()` "Menunggu Verifikasi"); pesan flash diubah: "…Klik 'Saya Sudah Bayar' untuk mengirim konfirmasi ke kasir."

### 3. Guard Check-In
- `app/Http/Controllers/KasirCheckinController.php`
  - `checkIn()`: hanya izinkan status `['menunggu','dikonfirmasi']`.
  - `undoCheckIn()`: hanya izinkan status `diproses`.

### 4. Validasi pembayaran transaksi manual
- `app/Http/Controllers/KasirTransaksiController.php` — `store()` & `update()`: jika status `Lunas` dan `dibayar < total` → redirect error "Nominal dibayar kurang dari total tagihan."

### 5. Hapus transaksi diblokir utk status final
- `app/Http/Controllers/KasirTransaksiController.php` — `destroy()`:
  - Tolak status `['Lunas','DP Dibayar']` (error: ubah ke Batal jika perlu).
  - Hapus record `pembayaran` terkait saat hapus transaksi non-final.
- `resources/views/kasir/transaksi/index.blade.php` — tombol hapus disembunyikan utk status `Lunas`/`DP Dibayar`.

### 6. Dashboard produkTerjual
- `app/Http/Controllers/KasirDashboardController.php` — filter `jenis` `'produk'` → `'Produk'` (hari ini & kemarin).

### 7. Laporan Pelanggan per-kasir
- `app/Http/Controllers/KasirLaporanPelangganController.php`
  - `index()` & `exportPDF()`: semua metrik & list pelanggan difilter `whereHas('transaksi', id_kasir = auth()->id(), jenis != Pengeluaran)`; `withCount/withSum/withMax` juga difilter `id_kasir`.
  - `getChartData($userId, ...)` & `getMembershipDistribution($userId)`: filter kasir.
  - `exportExcel()` sudah per-kasir (tidak diubah).

### 8. Metode terbanyak filter periode (minor)
- `app/Http/Controllers/KasirLaporanController.php` — `metodeTerbanyak`: tambah `whereBetween('tanggal', [$startDate, $endDate])`.

## Perbaikan Tampilan / Teks (View)

Audit tampilan view kasir menemukan bug teks & badge yang menyebabkan tampilan/tulisan tidak rapi atau menyesatkan.

### 9. Badge status konsisten (shared partial)
- Buat `resources/views/partials/badge-status.blade.php` — peta status pusat (Lunas/Selesai/DP Dibayar/Selesai, Proses/Menunggu Diproses/Menunggu Bayar/Pending/Di…, Batal/Gagal/Dibatalkan/Kadaluarsa). Label fallback = status asli (bukan "Pending"/"Batal").
- Ganti map inline di: `transaksi/index`, `transaksi/show`, `riwayat-transaksi/index`, `riwayat-transaksi/show`, `invoice/index`, `invoice/show`, `laporan/index`, `laporan/pdf` → `@include('partials.badge-status', ['status' => ...])`.
- `dashboard.blade.php` badge: `Proses`/`DP Dibayar` tidak lagi merah (dikira error).

### 10. Hardcode alamat/kontak salon → dinamis
- `struk/index.blade.php`: `alamat1/alamat2` (termasuk typo "oslo") → pecah dari `pengaturan.alamat`; `namaToko`/`telpToko` sudah pakai `pengaturan`.
- `invoice/show.blade.php`: header "Jl. Contoh No. 123" & "0812-3456-7890" → `pengaturan.alamat/telepon/email`.

### 11. Kondisi mustahil / duplikat teks
- `pembayaran/show.blade.php`: `@if (metode_byr === 'Saldo Akun')` → ganti `@if (saldo_terpakai > 0)` + label "Penggunaan Saldo Akun (Cashback)" (muncul untuk transaksi pakai saldo).
- `pembayaran/create.blade.php`: hapus duplikat teks "Dibayar otomatis" (totalBayar & sisaBayar).
- `transaksi/create` & `transaksi/edit` & `pembayaran/create`: label kartu e-wallet "No Rekening" → "No. HP / WhatsApp" (nilai = nomor telepon).

### 12. Keamanan & markup
- `pelanggan/index.blade.php`: `value={{ }}` → `value="{{ }}"` (escape; cegah broken attribute + XSS).
- `checkin/index.blade.php`: hapus duplikat `id="currentDate"` (konflik dgn `layouts/header2.blade.php`); ganti ke `id="currentDateInline"`.
- `laporan/pdf.blade.php`: ganti `class="status-{{ strtolower($t->status) }}"` (nama class rusak karena spasi) → partial badge / class inline aman.
- `dashboard.blade.php`: null-safe `?->nm_pelanggan` (463/465/492) + hapus dead code `@php $adaStok = route(...) ... try{...}` (509).
- Icon: emoji 💵/🏦 akordeon pembayaran → Font Awesome (konsisten).

### 13. Typo / kapitalisasi
- `konsultasi/index.blade.php`: "beautycian" → "beautician" (teks UI, 3 tempat); hapus klausa tak masuk akal pada modal tolak.
- `pelanggan/index`: "Nomor Hp" → "Nomor HP".

## Verifikasi
- `php -l` 7 controller: bersih (syntax OK).
- Render view via login + controller data: blade syntax semua valid (hanya undefined-variable bila render manual tak pakai data; tidak ada error syntax/partial/layout/badge).
- Tinker: pesanan online kasir hanya status `Sedang Diproses`; `Menunggu Pembayaran` tidak tampil; `produkTerjual` (fix kapital `Produk`) kini terhitung; laporan pelanggan per-kasir filter `id_kasir` berfungsi.
- Alur uji: login kasir -> Dashboard (badge warna benar, Proses tidak merah) -> Pesanan Online hanya menampilkan `Sedang Diproses` -> notif kasir "Menunggu Verifikasi" tiba saat pelanggan klik "Saya Sudah Bayar" -> Kasir Konfirmasi/Tolak -> transaksi Lunas (tombol hapus tidak tampil di daftar transaksi).

## Catatan
- Alur pelanggan: checkout -> `Menunggu Pembayaran` -> upload bukti (notif `Bukti Bayar Baru` ke kasir dihapus; pesan kasir minta klik "Saya Sudah Bayar") -> klik "Saya Sudah Bayar" (guard bukti wajib) -> `Sedang Diproses` + notif "Menunggu Verifikasi" -> kasir Konfirmasi/Tolak.
- File `resources/views/partials/badge-status.blade.php` baru (shared) — kirim `['status' => ...]`.
- Konflik git `routes/web.php` (marker :61-75) & file `UU` masih menggantung (di luar scope dokumen ini).
