# Perbaikan Pembayaran Online — Expired, Timer, Timeline, QRIS

> Estimasi: ~2 jam | Ditemukan dari pengujian manual pelanggan (1 Agu 2026)

---

## 1. Bug Refresh Loop Saat Waktu Habis (kritis)

### Gejala
Saat countdown mencapai `00:00`, halaman Pembayaran me-refresh terus tanpa henti dan tidak bisa pindah ke halaman lain.

### Akar Masalah
`resources/views/pelanggan/pembayaran/show.blade.php`:
- **Baris 690:** `location.reload()` dipanggil saat `diff <= 0` di `updateCountdown()`. Setelah reload, `expires_at` masih lewat → `updateCountdown()` langsung reload lagi → **loop tak berujung**.
- `cekStatus()` (baris 721–734) juga reload pada status `Kadaluarsa/Gagal/Dibatalkan` → potensi loop kedua jika server sudah menandai Kadaluarsa.

### Perbaikan
1. Hapus `location.reload()` dari `updateCountdown()` — countdown **berhenti** di `00:00:00` dan muncul modal.
2. `cekStatus()`:
   - `Lunas` → redirect ke `berhasil` (tetap).
   - `Sedang Diproses` → reload (tetap, menampilkan "Menunggu Verifikasi Kasir").
   - `Kadaluarsa` → **tampilkan modal expired** (bukan reload).
   - `Gagal` / `Dibatalkan` → redirect ke halaman pesanan (bukan reload).
3. Deteksi sisi klien saat countdown habis: tampilkan **modal "Waktu Pembayaran Habis"** dengan 2 opsi:
   - **Lanjut Pembayaran** → POST ke `perpanjang()` → reset `pembayaran.expires_at = now + 10 mnt`, `pembayaran.status = 'Menunggu'`, `transaksi.status = 'Menunggu Pembayaran'` (bila sudah Kadaluarsa oleh scheduler) → reload halaman dengan countdown baru. Kode VA/QRIS/kode referensi **tetap sama**.
   - **Batal Pembayaran** → POST ke `batal()` existing → status `Dibatalkan` → redirect ke pesanan.

### Endpoint baru
`PembayaranController@perpanjang(Request $request, $id)` + route POST `/pelanggan/pembayaran/{id}/perpanjang` → `pelanggan.pembayaran.perpanjang`.
- Guard IDOR cast `(int)` (pola existing baris 19).
- Hanya berlaku untuk status `Menunggu Pembayaran` atau `Kadaluarsa`.
- Batasi jumlah perpanjangan? — untuk prototype: **tanpa batas**, dicatat di catatan transaksi (opsional).

### Tambahan
- Halaman `pelanggan/pesanan/show`: status `Kadaluarsa` → tombol **"Lanjutkan Pembayaran"** (POST perpanjang) di samping keterangan kadaluarsa.

## 2. Timer 15 → 10 Menit

`CheckoutController.php:147-149`:
```php
$expiresAt = in_array($request->metode, ['QRIS', 'E-Wallet'])
    ? now()->addMinutes(10)   // ← 10 menit (keputusan user)
    : now()->addHours(24);    // Transfer tetap 24 jam
```

## 3. Timeline Status Pesanan (icon salah)

### Gejala
`pelanggan/pesanan/show.blade.php` — saat transaksi `Lunas`, step "Selesai" masih menampilkan icon **berputar** (spinner), harusnya **centang**.

### Akar Masalah
Baris 607–610: untuk `Lunas`, step `Selesai` diberi class `active` → di baris 638 icon `fa-spinner fa-spin`. `active` = proses berjalan; step terakhir yang selesai harus `done` (centang).

### Aturan Timeline Baru
| Status transaksi | Step 1 Menunggu Pembayaran | Step 2 Menunggu Verifikasi | Step 3 Selesai |
|---|---|---|---|
| `Menunggu Pembayaran` | `active` (spinner) | `pending` | `pending` |
| `Sedang Diproses` | `done` (centang) | `active` (spinner) | `pending` |
| `Lunas` | `done` | `done` | `done` — **semua centang** |
| `Gagal` / `Kadaluarsa` / `Dibatalkan` | step khusus merah/abu (existing) | | |

- Label step 2 diubah tampilannya dari "Sedang Diproses" menjadi **"Menunggu Verifikasi"** (DB tidak diubah).
- **Semantik "Selesai"** (jawaban untuk pelanggan): belum ada sistem pengiriman → **Selesai = transaksi Lunas** (dikonfirmasi kasir). Tahap "Dikirim/Diterima" adalah fitur terpisah di masa depan.
- Badge status (`status-badge`) tetap memakai nilai DB (Menunggu Pembayaran / Sedang Diproses / Lunas / dll).

## 4. QRIS Asli (ganti dummy)

- Gambar asli: `storage/app/public/Pembayaran/QrisCode BeautyCare.jpeg` (149 KB, sudah ter-link `public/storage/`).
- Perbaikan: **salin ke `public/assets/img/qris-merchant.png`** (nama tetap sama → `partials/qris.blade.php` tidak berubah).
- File dummy `qris-merchant.png` lama (1,8 KB) ditimpa.

## 5. QA

1. Tinker: buat transaksi QRIS → `expires_at` = now + 10 mnt; Transfer → + 24 jam.
2. Simulasi countdown habis (atur expires_at masa lalu): halaman **tidak** reload loop; modal muncul; **Lanjut** → countdown baru; **Batal** → Dibatalkan.
3. `perpanjang` saat status Kadaluarsa → kembali Menunggu Pembayaran.
4. Timeline: Lunas → 3 centang; Sedang Diproses → 2 centang + 1 spinner; Menunggu → 1 spinner.
5. Halaman pembayaran menampilkan QRIS asli.
6. `view:cache` OK.
