# Fase E — Midtrans: Transaksi Nyata (QRIS Dinamis + E-Wallet)

> Status: Rencana disusun | Estimasi: ~5–6 jam + 1 jam QA sandbox | Butuh: akun Midtrans merchant (sandbox → produksi)

---

## 1. Tujuan & Ruang Lingkup

Mengganti pembayaran demo (QR statis `qris-merchant.png`) dengan **transaksi nyata via Midtrans**:

| Metode | Cara | Catatan |
|---|---|---|
| **QRIS dinamis** | Charge API Midtrans → QR unik per transaksi, tampil inline di halaman | QR asli, nominal sesuai total |
| **E-Wallet** (Dana, GoPay, OVO, ShopeePay) | **Snap modal** (tombol "Bayar Sekarang") | Redirect/deeplink otomatis dari Midtrans |
| **Transfer Bank** | Tetap manual (verifikasi kasir) | Tidak berubah |

**Otomatisasi penuh untuk QRIS/E-Wallet:** pelanggan bayar → webhook Midtrans → sistem otomatis tandai `Lunas`, decrement stok, kirim notifikasi — tanpa intervensi kasir.

---

## 2. Keputusan Kunci

| Topik | Keputusan |
|---|---|
| Order ID Midtrans | = `pembayaran.kode_pembayaran` (unik per transaksi, sudah ada) |
| Timer QRIS/E-Wallet | 3 menit (konsisten dengan `CheckoutController::store` & `perpanjang()`); disesuaikan dengan expiry Midtrans via parameter `expiry` |
| Timer Transfer | 24 jam (tidak berubah) |
| Webhook vs Kadaluarsa | **Settlement selalu menang** — override status `Kadaluarsa` (pelanggan sudah bayar walau lewat batas) |
| Decrement stok | Hanya 1x saat Lunas (idempotent); pola sama dengan `KasirPembayaranController::verifikasi` |
| Guard order lama | Notifikasi dari order Midtrans lama (setelah perpanjang/re-charge) diabaikan |
| Anti-manipulasi | Verifikasi signature `sha512(order_id.status_code.gross_amount.server_key)` + cek `gross_amount == pembayaran.nominal` |
| Charge gagal | Pesanan tetap dibuat; tampilkan pesan + tombol ganti metode (jangan sampai pelanggan kehilangan pesanan) |
| Legacy | Transaksi lama (QRIS statis, E-Wallet lama) tetap dirender partial lama |
| Env | `MIDTRANS_IS_PRODUCTION=false` di dev; switch hanya saat go-live |
| CSRF webhook | Route dikecualikan dari CSRF, diganti verifikasi signature |
| Stok | Decrement pindah ke webhook settlement (untuk metode Midtrans); kasir verifikasi tetap untuk Transfer |

---

## 3. Kondisi Saat Ini (peta kode yang akan disentuh)

| Komponen | Lokasi | Catatan |
|---|---|---|
| Package | `composer.json` | **Belum ada** `midtrans/midtrans-php` |
| Config | `config/midtrans.php`, `.env` | Belum ada; `.env` sudah punya `CHECKOUT_DEMO_MODE` |
| Checkout | `app/Http/Controllers/CheckoutController.php` | `store()` validasi `in:QRIS,Transfer` (baris ±110); `$expiresAt` QRIS `addMinutes(3)`, Transfer `addHours(24)` (±164-166); `generateKodePembayaran()` `QR-`/`8802`/`EP-` |
| Pembayaran | `app/Models/Pembayaran.php` + migrasi `2026_07_31_010000_create_pembayaran_table.php` | Kolom: `metode, provider, kode_pembayaran, nominal, status, expires_at, paid_at, no_referensi` — perlu tambah `qr_url` + `snap_token` (nullable) |
| Show page | `resources/views/pelanggan/pembayaran/show.blade.php` | Countdown HTML ±752-757, JS ±870-916; partial: `partials/qris` (statis), `partials/transfer`, `partials/ewallet` (legacy) |
| Partial QRIS | `resources/views/pelanggan/pembayaran/partials/qris.blade.php` | Gambar statis `assets/img/qris-merchant.png` → diganti QR dinamis |
| Status API | `PembayaranController::status` | Polling lokal; perlu tambah cek API Midtrans bila metode Midtrans |
| Perpanjang | `PembayaranController::perpanjang` | QRIS/E-Wallet reset 3 menit; perlu re-charge Midtrans (order lama sudah expire) |
| Verifikasi kasir | `app/Http/Controllers/KasirPembayaranController.php` `verifikasi()` ±181 | Set `Lunas` + decrement stok + `paid_at` + `no_referensi` → pola ini dipakai webhook |
| Expire | `app/Console/Commands/ExpirePesanan.php` | Tiap menit; hanya expire status `Menunggu` |
| Route pelanggan | `routes/web.php` ±355-369 | Group auth; webhook Midtrans dibuat **di luar** group |

---

## 4. Alur Bayar Baru

```
1. Checkout (QRIS / E-Wallet)
2. CheckoutController@store:
   - buat Transaksi (status 'Menunggu Pembayaran') + DetailTransaksi
      - buat Pembayaran (status 'Menunggu', expires_at = 3 menit / 24 jam)
      - QRIS      → MidtransService@createQris(amount, orderId) → simpan qr_url
      - E-Wallet  → MidtransService@createSnapToken(amount, orderId, customer) → simpan snap_token
      - charge gagal → fallback: pesanan tetap dibuat, tampilkan pesan ganti metode
   3. show.blade.php:
   - QRIS      → <img src="{{ qr_url }}"> + polling /status + "Saya Sudah Bayar" (fallback)
   - E-Wallet  → tombol "Bayar Sekarang" → snap.js (client key) → snap.pay(snap_token)
4. Pelanggan bayar di app e-wallet / m-banking
5. Midtrans POST webhook → POST /midtrans/notification (tanpa CSRF)
6. MidtransWebhookController@handle:
   - verify signature → verify order_id → verify gross_amount → idempotent guard
   - mapping status → update Pembayaran + Transaksi + stok + notifikasi
7. (Pengaman) PembayaranController@status: bila metode Midtrans & belum Lunas
   → MidtransService@getStatus(orderId) → update DB → balas status terbaru
```

---

## 5. Implementasi — Fase A–E

### Fase A — Fondasi
1. `composer require midtrans/midtrans-php` (PHP 8.2, Laravel 12 — kompatibel).
2. `config/midtrans.php`: `server_key`, `client_key`, `is_production`, `merchant_id`, `snap_base_url`.
3. `.env`: `MIDTRANS_SERVER_KEY=`, `MIDTRANS_CLIENT_KEY=`, `MIDTRANS_IS_PRODUCTION=false`, `MIDTRANS_MERCHANT_ID=`.
4. `app/Services/MidtransService.php`:
   - `createQris(int $amount, string $orderId): string` → `qr_url`
   - `createSnapToken(int $amount, string $orderId, ?User $user): string` → token
   - `getStatus(string $orderId): array` → status dari API (polling)
   - `verifySignature($orderId, $statusCode, $grossAmount, $signature): bool` → `sha512(order_id.status_code.gross_amount.server_key)`
5. Migrasi `add qr_url` + `snap_token` (nullable string) ke tabel `pembayaran`.

### Fase B — Checkout & Charge
6. `CheckoutController@store`:
   - Validasi `in:QRIS,E-Wallet,Transfer`; providers: `QRIS` → `['QRIS']`, `E-Wallet` → `['Dana','GoPay','OVO','ShopeePay']`, `Transfer` → `bankTujuan()`.
   - Setelah `Pembayaran::create` → charge sesuai metode (lihat §4 langkah 2).
   - `generateKodePembayaran` sudah mendukung `EP-` — pertahankan.
7. `checkout/index.blade.php`: kembalikan blok E-Wallet (4 provider) + QRIS (label "QRIS Dinamis"); Transfer tetap.

### Fase C — Webhook
8. `routes/web.php`: `Route::post('/midtrans/notification', [MidtransWebhookController::class, 'handle']);` di luar group auth/middleware web.
9. `app/Http/Middleware/VerifyCsrfToken.php`: `except => ['midtrans/notification']` (diganti verifikasi signature).
10. `app/Http/Controllers/MidtransWebhookController.php` `handle(Request $request)`:
    - Verifikasi signature → gagal = 403.
    - Cari `Pembayaran::where('kode_pembayaran', $orderId)->with('transaksi')` → tidak ada = 404.
    - Guard order lama: bila `kode_pembayaran` pembayaran ≠ order_id saat ini → 200 (diabaikan).
    - Guard nominal: `gross_amount != nominal` → 400.
    - Mapping status (tabel §6) + update di `DB::transaction`, idempotent.
    - Selalu balas 200 untuk notifikasi valid (Midtrans retry bila bukan 2xx).

### Fase D — UI & Polling
11. `show.blade.php`:
    - QRIS → `<img src="{{ $transaksi->pembayaran->qr_url }}">` (ganti partial statis untuk metode QRIS; partial lama tetap untuk legacy bila `qr_url` kosong).
    - E-Wallet → tombol "Bayar Sekarang" → `snap.js` + `snap.pay(snap_token)`; `onSuccess` → redirect `/berhasil`; `onPending` → pesan; `onError` → pesan.
    - Sembunyikan upload bukti untuk E-Wallet (otomatis), tetap untuk Transfer; "Saya Sudah Bayar" tetap untuk semua (fallback).
12. `PembayaranController@status`: bila metode QRIS/E-Wallet, status `Menunggu`, timer belum habis → `getStatus(orderId)` → update DB bila berubah → balas terbaru. JS polling tetap tiap ~10 detik (batasi agar tidak spam API).
13. `PembayaranController@perpanjang`: untuk QRIS/E-Wallet → re-charge dengan `kode_pembayaran` baru (suffix `-R1`, `-R2`, …) + update `qr_url`/`snap_token` + `expires_at`; notifikasi order lama otomatis diabaikan oleh guard order lama.
14. `berhasil.blade.php`: tampilkan `no_referensi` (= transaction_id Midtrans) sebagai bukti.

### Fase E — Testing & Go-Live
15. Test sandbox (detail §8) → simulasi webhook lokal + tunnel opsional.
16. Switch produksi: keys produksi, `MIDTRANS_IS_PRODUCTION=true`, URL webhook publik → verifikasi 1 transaksi riil kecil.

---

## 6. Mapping Status Midtrans → Status Lokal

| Midtrans (`status_code` / `transaction_status`) | Pembayaran | Transaksi | Aksi tambahan |
|---|---|---|---|
| `200`/`201` settlement, capture | `Dibayar`, `paid_at=now`, `no_referensi=transaction_id` | `Lunas` | decrement stok, notif pelanggan+admin; **override Kadaluarsa** |
| `202` pending | `Menunggu` (update `expires_at` bila perlu) | `Menunggu Pembayaran` | — |
| `400` cancel | `Gagal` | `Gagal` | notif |
| `407` deny | `Gagal` | `Gagal` | notif |
| `401` expire | `Kadaluarsa` (hanya jika masih `Menunggu`) | `Kadaluarsa` | jangan timpa yang sudah Dibayar |
| Duplikat (pending → settlement → capture) | — | — | **skip** (sudah `Dibayar`/`Lunas` → tidak decrement 2x) |

---

## 7. Risiko & Mitigasi

| Risiko | Mitigasi |
|---|---|
| Webhook telat / tak sampai | Polling API di `status()` + "Saya Sudah Bayar" → kasir verifikasi manual |
| Stok decrement 2x | Idempotent guard: skip bila sudah `Dibayar`/`Lunas` |
| `ExpirePesanan` mark Kadaluarsa padahal sudah bayar | Settlement selalu menang (override); `ExpirePesanan` hanya proses status `Menunggu` |
| Notif order lama menimpa order baru (setelah perpanjang) | Guard `order_id` == `kode_pembayaran` saat ini |
| Spoofing webhook / manipulasi nominal | Signature sha512 + cek `gross_amount` |
| Charge gagal / Midtrans down | Pesanan tetap dibuat, tombol ganti metode; data tidak hilang |
| Server key bocor | Key server hanya backend; client hanya `client_key` via `snap.js` |
| Webhook kena CSRF | Route di-except, diganti verifikasi signature |
| Localhost tak bisa terima webhook | Simulasi signature lokal (deterministik) + opsi tunnel ngrok/cloudflared |
| `expires_at` lokal vs expiry Midtrans tidak sinkron | Set `expiry` Midtrans = timer lokal (3 menit QRIS/E-Wallet) |

---

## 8. Test Plan

1. **Simulasi webhook lokal** (tanpa internet inbound):
   - Hit `POST /midtrans/notification` dari script test; hitung `signature_key = sha512(order_id.status_code.gross_amount.server_key_sandbox)`.
   - Uji semua state: `200`, `201`, `202`, `400`, `401`, `407`, duplikat, `gross_amount` salah, signature salah.
   - Verifikasi: status DB, stok decrement 1x, notifikasi, `no_referensi`.
2. **E2E sandbox** (opsional, via tunnel): kartu `4811 1111 1111 1114`, OTP `112233`, 3DS `112233`; e-wallet pakai app GoPay/OVO/Dana versi sandbox; QRIS pakai simulasi dari dashboard sandbox Midtrans.
3. **Regresi**: Transfer manual (upload bukti → verifikasi kasir) tetap jalan; transaksi legacy QRIS statis/E-Wallet lama tetap tampil; countdown & perpanjang tetap benar.
4. `php artisan view:cache` + render halaman checkout & pembayaran.

---

## 9. Pertanyaan Terbuka (butuh jawaban user sebelum Fase E)

1. Akun Midtrans merchant (sandbox) — Server Key, Client Key, Merchant ID, nama toko, email?
2. Durasi bayar QRIS/E-Wallet tetap 3 menit? (sinkron dengan expiry Midtrans)
3. Webhook saat development: simulasi lokal (disarankan) atau pasang tunnel?
4. Booking pelayanan juga pakai Midtrans nantinya, atau checkout produk dulu?
5. Domain/URL publik saat go-live untuk tujuan webhook?

---

## 10. Checklist Eksekusi

- [ ] Fase A: composer + config/midtrans.php + .env + MidtransService + migrasi kolom
- [ ] Fase B: CheckoutController charge QRIS/Snap + view checkout E-Wallet
- [ ] Fase C: route + CSRF except + MidtransWebhookController (signature, mapping, idempotent, stok)
- [ ] Fase D: show.blade (QR dinamis + tombol Snap) + status polling + perpanjang re-charge + berhasil
- [ ] Fase E: QA simulasi webhook → test e2e sandbox → go-live produksi
