# Dokumentasi Fitur Selesai — Checkout Produk Online

> Fitur: pelanggan checkout produk dari keranjang / beli langsung, bayar via VA/QRIS/E-Wallet (prototype), kasir verifikasi.
> Status: **selesai 100%** (per 31 Juli 2026), semua tahap teruji end-to-end.

---

## 1. Database (3 migrasi, 31 Juli 2026)

| Migrasi | Isi |
|---|---|
| `2026_07_31_010000_create_pembayaran_table.php` | Tabel `pembayaran`: `id`, `id_transaksi`, `metode`, `provider`, `kode_pembayaran`, `nominal`, `status`, `expires_at`, `paid_at`, `no_referensi`, timestamps |
| `2026_07_31_020000_add_sumber_to_transaksi_table.php` | `transaksi.sumber` = `string(10)` default `'kasir'` (bukan enum); nilai online: `'online'` |
| `2026_07_31_030000_add_id_produk_to_troli_table.php` | `troli.id_produk` (string, slug/id produk) |

Model baru: `app/Models/Pembayaran.php` (fillable + casts `expires_at`, `paid_at`; relasi `transaksi()`).
`Transaksi` + `sumber` di fillable + relasi `pembayaran()` (hasOne).
`Troli` + `id_produk` di fillable.

## 2. Route Baru

| Route | Method | Nama |
|---|---|---|
| `/pelanggan/checkout` | GET | `pelanggan.checkout` |
| `/pelanggan/checkout` | POST | `pelanggan.checkout.store` (pasti nama final saat implementasi) |
| `/pelanggan/pembayaran/{id}` | GET | `pelanggan.pembayaran.show` |
| `/pelanggan/pembayaran/{id}/berhasil` | GET | `pelanggan.pembayaran.berhasil` |
| `/pelanggan/pembayaran/{id}/status` | GET (JSON polling) | `pelanggan.pembayaran.status` |
| `/pelanggan/pembayaran/{id}/sudah-bayar` | POST | `pelanggan.pembayaran.sudah-bayar` |
| `/pelanggan/pembayaran/{id}/batal` | POST | `pelanggan.pembayaran.batal` |
| `/pelanggan/pesanan` | GET | `pelanggan.pesanan.index` |
| `/pelanggan/pesanan/{id}` | GET | `pelanggan.pesanan.show` |
| `/kasir/pembayaran/pesanan-online` | GET | `kasir.pembayaran.pesanan-online` |
| `/kasir/pembayaran/verifikasi/{id}` | POST | `kasir.pembayaran.verifikasi` |

> **Penting:** route `pesanan-online` harus didaftarkan SEBELUM `/kasir/pembayaran/{id}` (web.php:221 vs 225).

## 3. Controller & Alur

### `CheckoutController`
- `create()`: keranjang user atau `?beli={id}&qty={n}` (beli langsung); validasi ulang harga & stok; daftar promo produk yang bisa dipakai.
- `store()`: buat `transaksi` (`sumber='online'`, `no_invoice` INV-YYYYMMDD-NNN), kosongkan troli, buat `pembayaran` dengan kode + timer, redirect ke halaman pembayaran.
- Helper statis: `bankTujuan()` (BRI 10101010, BCA 20202020, Mandiri 30303030, BNI 40404040, BSI 50505050), `generateKodePembayaran()` — VA: `8802`+id; QRIS: `QR-`; E-Wallet: `EP-`.
- Helper lain: `resolveItems()`, `getOrCreatePelanggan()`, `hitungPromo()`.
- Timer: **QRIS & E-Wallet 15 menit, Transfer 24 jam** → `pembayaran.expires_at`.

### `PembayaranController`
- `show($id)` — halaman pembayaran + countdown + polling status.
- `berhasil($id)` — pelanggan menandai sudah bayar → transaksi `Sedang Diproses` + notif kasir.
- `status($id)` — JSON untuk polling (status transaksi & pembayaran).
- `sudahBayar($id)` — aksi "Saya sudah bayar" (POST).
- `batal($id)` — membatalkan (status `Dibatalkan`).
- **IDOR guard:** `(int)` cast `id_user` (kolom string!) → cek pemilik → 403 bila bukan miliknya (`PembayaranController.php:19`).

### `PesananController`
- `index()` — daftar pesanan user (transaksi `sumber='online'`).
- `show($id)` — detail + timeline status + kode pembayaran + tombol salin (`PesananController.php:20` IDOR cast sama).

### `KasirPembayaranController` (perluasan)
- `pesananOnline()` — list transaksi `sumber='online'` dengan info pembayaran.
- `verifikasi($id)` — aksi **Konfirmasi** (→ transaksi `Lunas`, `decrement` stok produk, notif pelanggan & admin) atau **Tolak** (→ `Ditolak`, stok tidak berubah).
- `pesananOnlineCount` — badge di halaman kasir.
- `CHECKOUT_DEMO_MODE=true` → tombol "Simulasi Bayar Berhasil" (set `paid_at` + transaksi Diproses) untuk demo.

### Command `pesanan:expire`
- `app/Console/Commands/ExpirePesanan.php`, signature `pesanan:expire`.
- `routes/console.php`: `Schedule::command('pesanan:expire')->everyMinute()`.
- Fungsi: transaksi `Menunggu` dengan `expires_at` lewat → `Kadaluarsa` (tanpa mengubah stok).

## 4. Status Transaksi Online (alur)

```
Menunggu ──(sudahBayar/berhasil)──▶ Sedang Diproses ──(verifikasi Konfirmasi)──▶ Lunas
   │                                    │
   │(expire)                            │(verifikasi Tolak)
   ▼                                    ▼
Kadaluarsa                          Ditolak
Menunggu ──(batal)──▶ Dibatalkan
```

- Stok produk berkurang **hanya** saat verifikasi Konfirmasi.
- `sumber='online'` membedakan dari transaksi kasir (`'kasir'`).

## 5. View

| View | Keterangan |
|---|---|
| `pelanggan/checkout/index.blade.php` | 2 kolom: ringkasan (item+promo) & metode bayar; buat transaksi |
| `pelanggan/pembayaran/show.blade.php` | Countdown, polling 5 dtk (`/status`), salin kode VA, metode tampil via partial |
| `pelanggan/pembayaran/berhasil.blade.php` | Konfirmasi + auto-redirect 5 dtk ke pesanan |
| `pelanggan/pembayaran/partials/{qris,transfer,ewallet}.blade.php` | Detail tiap metode |
| `pelanggan/pesanan/{index,show}.blade.php` | Daftar & detail pesanan + timeline status + badge |
| `kasir/pembayaran/pesanan-online.blade.php` | List + Simulasi/Konfirmasi/Tolak |
| `kasir/pembayaran/index.blade.php` | Tab "Pesanan Online" + badge count |
| `pelanggan/keranjang/index.blade.php` | Tombol checkout → `pelanggan.checkout`; modal lama dihapus (−432 baris) |
| `pelanggan/produk/index.blade.php` | `beliLangsung()` → redirect `?beli=&qty=`; modal lama dihapus (−321 baris) |
| `pelanggan/keranjang/history.blade.php` | Badge status dinamis (menunggu/diproses/gagal/kadaluarsa/dibatalkan) |
| `layouts/sidebar-pelanggan.blade.php` | Menu "Pesanan" |

Aset: `public/assets/img/qris-merchant.png` (QR statis, dibuat via GD).

## 6. QA Terakhir (31 Juli 2026)
- Tinker end-to-end lulus: STORE (INV-20260731-0026/27, kode QR-00000026/27, troli terhapus, stok belum berubah) → SUDABAYAR (Diproses) → VERIFIKASI (Lunas, stok −2 → 43, notif user & kasir) → EXPIRE (Kadaluarsa) → BATAL (Dibatalkan).
- 7 halaman render OK (checkout.index 43 KB, pesanan.index 34 KB, pesanan.show 39 KB, pembayaran.show 40 KB, kasir.pesanan-online 32 KB, dll).
- Data test (transaksi 26, 27) dibersihkan; `view:cache` & `schedule:list` OK.

## 7. Pelajaran / Poin Penting untuk Fase Berikutnya
1. `transaksi.id_user` string → **selalu cast `(int)`** untuk guard (pernah 403).
2. Pemotongan baris via script bisa merusak tag HTML (kasus `</script>` 1 Agu 2026) → selalu verifikasi keseimbangan tag setelah edit massal.
3. Urutan route statis vs `{id}` di kasir.
4. Stok hanya berubah saat verifikasi → Fase A harus pasang helper sinkron status di titik itu.
5. `bukti_bayar` (transaksi) sudah dipakai kasir → Fase C tidak butuh migrasi.
