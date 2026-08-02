# Catatan Perbaikan

> Log perbaikan & daftar diskusi sebelum/bersamaan dengan eksekusi fase. Diperbarui tiap sesi.

---

## 1. Selesai

| # | Tanggal | Item | Detail |
|---|---------|------|--------|
| 1 | 1 Agu 2026 | Tag `</script>` hilang di `pelanggan/produk/index.blade.php` | Pembersihan modal checkout memotong tag penutup script utama → seluruh JS mati (klik Beli tidak bereaksi). `</script>` dikembalikan (sekarang baris ±994), tag `<script>` seimbang 2/2. |
| 2 | 1 Agu 2026 | Penutup `}` CSS media query hilang di file yang sama | Baris 705–707: `.search-input-wrap input:focus` tanpa penutup → diperbaiki menjadi `}` + `}` + `</style>`. |
| 3 | 1 Agu 2026 | Verifikasi perbaikan di atas | `view:cache` OK; render halaman 72 KB; `showBeliModal` ada; keranjang/index dicek aman (`</script>` baris 1415). |
| 4 | 1 Agu 2026 | **Refresh loop halaman Pembayaran saat countdown habis** | `pembayaran/show.blade.php:690` — `location.reload()` saat `diff <= 0` → loop tak berujung, halaman tak bisa dinavigasi. Fix + modal "Waktu Habis" (Lanjut/Batal) + endpoint `perpanjang()` → detail `07-PERBAIKAN-PEMBAYARAN-EXPIRED.md`. |
| 5 | 1 Agu 2026 | **Icon timeline Selesai masih berputar saat Lunas** | `pesanan/show.blade.php:607-610` — step `Selesai` diberi `active` (spinner) padahal harus `done` (centang). Semantik: Selesai = Lunas (belum ada sistem pengiriman). Detail `07`. |
| 6 | 1 Agu 2026 | **Timer QRIS/E-Wallet 15 menit** | Diubah ke **10 menit** (Transfer tetap 24 jam) — keputusan user. `CheckoutController.php:148`. |

## 2. Catatan Minor (opsional, bisa dikerjakan kapan saja)

| # | Item | Keterangan |
|---|------|------------|
| 1 | File kosong `docs/screenshot/planning/l` (0 byte) | Kemungkinan tidak sengaja terbentuk. Usulan: hapus. |
| 2 | `KeranjangController@store` belum cek stok | Pelanggan bisa menambah ke keranjang melebihi stok; pengecekan baru terjadi di checkout (`CheckoutController.php:90`). Usulan: validasi stok saat store + pesan jelas. |
| 3 | Warning `null` auth saat view render tanpa login | `header2.blade.php` / sidebar mengakses `auth()->user()->...` tanpa guard null → warning deprecation di tinker. Usulan: hardening null-safe (nilai prioritas rendah). |

## 3. Ruang Diskusi (isi saat sesi diskusi)

- [ ] *placeholder — masukan user*
- [ ] *placeholder — masukan user*
