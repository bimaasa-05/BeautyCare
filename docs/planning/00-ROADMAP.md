# Roadmap BeautyCare — Perencanaan Pengembangan

> Terakhir diperbarui: 1 Agustus 2026
> Dokumentasi ini adalah sumber perencanaan utama. Setiap fase memiliki dokumen detail sendiri (01–04).

---

## 1. Status Keseluruhan

### Fitur Selesai
- **Checkout Produk Online** — selesai 100% (DB, backend, views, integrasi, kasir, QA). Detail teknis lengkap: `06-FITUR-SELESAI-CHECKOUT-PRODUK.md`.

### Fitur Rencana (urutan wajib)
| # | Fase | Nama | Status | Estimasi |
|---|------|------|--------|----------|
| A | Fase A | Stok & Katalog Pintar | Belum mulai | ~2–3 jam |
| B | Fase B | Admin & Laporan Pesanan Online | Belum mulai | ~3–4 jam |
| C | Fase C | Upload Bukti Bayar Pelanggan | Belum mulai | ~2 jam |
| D | Fase D | Pembayaran Online Reservasi | Belum mulai | ~4–5 jam |
| 07 | Perbaikan | Expired/Timer/Timeline/QRIS (`07-PERBAIKAN-PEMBAYARAN-EXPIRED.md`) | Rencana disusun | ~2 jam |
| 08 | Fitur | Diskon Membership (`08-FITUR-DISKON-MEMBERSHIP.md`) | Rencana disusun | ~2–3 jam |

---

## 2. Keputusan Kunci (sudah disepakati)

| Topik | Keputusan |
|-------|-----------|
| Status stok | **Auto dua arah**: stok ≤ 0 → `Habis` otomatis; stok terisi → `Tersedia` otomatis; status manual `Belum Restok` tidak disentuh |
| Threshold stok menipis | **≤ 5** (badge katalog & notif admin) |
| Verifikasi admin | Admin pesanan online **view-only** — konfirmasi/tolak eksklusif kasir |
| Notif stok menipis | Hanya saat **transisi** (anti-spam): stok turun melewati ≤ 5 atau jadi `Habis` |
| Demo pembayaran | `CHECKOUT_DEMO_MODE=true` di `.env` → tombol "Simulasi Bayar Berhasil" muncul di kasir |
| VA prototype | `8802` + nomor invoice |
| Timer pembayaran | QRIS & E-Wallet: **10 menit** (sebelumnya 15); Transfer: 24 jam |
| Diskon pelanggan | Pakai **satu** diskon: promo ATAU member — otomatis ambil yang **lebih besar** |
| Skema membership | Silver 5% (min 3 pembelian), Gold 10% (min 5), Platinum 20% (min 10) — pembelian = transaksi Lunas berisi produk (kasir + online) |
| Semantik "Selesai" | Transaksi Lunas (dikonfirmasi kasir) — belum ada sistem pengiriman |
| Pengurangan stok | Hanya saat kasir **konfirmasi Lunas** (verifikasi) |
| Fase D retry | Bila transaksi Gagal/Kadaluarsa, pelanggan boleh membuat transaksi baru untuk booking yang sama |

---

## 3. Bug yang Sudah Diperbaiki (3 Juli sesi ini)

1. `pelanggan/produk/index.blade.php` — tag `</script>` penutup utama hilang saat pembersihan modal checkout → seluruh JS mati (tombol Beli tidak bereaksi). Sudah dikembalikan + `dashboard.js` tidak lagi tertelan.
2. CSS media query penutup `}` hilang di file yang sama (baris 705–707) → sudah diperbaiki.
3. Verifikasi keduanya: tag `<script>` seimbang (2/2), blade compile OK, view render 72 KB dengan `showBeliModal` ada.

> Daftar lengkap & ruang diskusi: `05-CATATAN-PERBAIKAN.md`.

---

## 4. Catatan Teknis Penting (harus diingat di semua fase)

- `transaksi.id_user` bertipe **string** → semua guard kesamaan harus di-cast `(int)` (bug 403 pernah terjadi: `PembayaranController.php:19`, `PesananController.php:20`).
- Kolom `transaksi.sumber` = `string(10)` default `'kasir'` (bukan enum), nilai online: `'online'`.
- Urutan route kasir: `pesanan-online` **harus sebelum** `{id}` (`routes/web.php:221` & `:225`).
- Helper global `buatNotif($userId, $judul, $isi, $type, $url, $aktorId)` ada di `app/helpers.php`.
- `transaksi.bukti_bayar` sudah dipakai kasir/admin sebagai upload file (storage `uploads/bukti_bayar` & `bukti-bayar`, disk public) → Fase C **tanpa migrasi**.
- Status booking (huruf kecil): `menunggu`, `dikonfirmasi`, `selesai`, `dibatalkan`.
- Dashboard kasir sudah punya list stok menipis (≤ 20) di `KasirDashboardController.php:180-182`; admin belum.
