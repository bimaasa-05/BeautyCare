# Fitur Diskon Membership (satu diskon: Promo ATAU Member)

> Estimasi: ~2–3 jam | Keputusan user: skema baru, diskon otomatis pilih terbesar

---

## 1. Rantai Diskon (logika sederhana, terverifikasi di kode)

```
1. Admin buat promo                → tabel `promo`
   (jenis: Diskon %, Cashback Rp, Paket)
2. Pelanggan buka halaman Promo    → klik "Ambil" → `promo_klaim` status 'tersedia'
   (PelangganPromoController@claim)
3. Pelanggan checkout              → dropdown promo tersedia
   (CheckoutController@create: filter status='tersedia', jenis ≠ 'Paket')
4. Hitung diskon promo             → `hitungPromo()`: Diskon = % × subtotal;
                                       Cashback = nominal (min(subtotal))
                                       klaim → status 'digunakan'
5. Hitung diskon member (BARU)     → otomatis bila syarat level terpenuhi
6. Pakai SATU yang lebih besar     → promo ATAU member → `transaksi.diskon`
```

## 2. Skema Membership (keputusan user)

| Level | Diskon | Syarat minimal pembelian produk |
|---|---|---|
| Silver | 5% | 3 transaksi |
| Gold | 10% | 5 transaksi |
| Platinum | 20% | 10 transaksi |

- **"Pembelian produk"** = jumlah transaksi berstatus `Lunas` yang memiliki detail `jenis='Produk'` (kasir **dan** online — keputusan user).
- Diskon member **aktif hanya jika** jumlah pembelian ≥ `min_transaksi` level pelanggan saat ini.
- Sinkron DB: update `membership.min_transaksi` → Silver 3, Gold 5, Platinum 10.
- Upgrade member (`MembershipPelangganController@upgrade`) ikut skema baru: syarat = jumlah pembelian produk ≥ `min_transaksi` target (lepas syarat nominal `min_pembelian` agar konsisten).

## 3. Implementasi

### 3.1 Helper perhitungan — `app/Http/Controllers/CheckoutController.php`
- Method baru `hitungDiskonMember($pelanggan, $subtotal)`:
  - Ambil `Pelanggan` (via `getOrCreatePelanggan`) + `membership`.
  - Hitung jumlah pembelian produk: `Transaksi::where('id_pelanggan', …)->where('status','Lunas')->whereHas('detail', fn(q) => q->where('jenis','Produk'))->count()`.
  - Jika `jumlahPembelian >= membership.min_transaksi` → return `round($subtotal × diskon / 100)`; else return 0 (sertakan juga info level & sisa pembelian untuk tampilan).
- `store()`: hitung `diskonPromo` (existing) dan `diskonMember` (baru) → `diskon = max(diskonPromo, diskonMember)`.
  - **Penting:** `hitungPromo()` menandai klaim `digunakan` saat dipanggil. Agar tidak menghabiskan klaim promo saat promo tidak terpakai: panggil `hitungPromo` **setelah** memutuskan diskon mana yang menang, atau hitung dulu nilai promo tanpa menandai, baru tandai jika menang.
- Detail item: alokasi diskon proporsional per item (pola existing) — jika diskon member yang menang, `id_promo` item = null.

### 3.2 Kartu level & progress — `resources/views/pelanggan/checkout/index.blade.php`
- Tampilkan di area ringkasan:
  - "Level Anda: **Silver** — Diskon Member 5% aktif" (hijau) jika syarat terpenuhi.
  - "Level Anda: **Silver** — Butuh **N pembelian** lagi untuk diskon member 5%" (kuning) jika belum.
- Ringkasan diskon: label menampilkan sumbernya, mis. "Diskon Promo (Promo Akhir Tahun 20%)" atau "Diskon Member (Silver 5%)".

### 3.3 Data dari controller
- `create()` mengirim: `memberLevel`, `memberDiskon`, `memberSisaPembelian` (jumlah yang kurang), `memberAktif` (bool).
- JS `hitungRingkasan()` menampilkan diskon sesuai pilihan promo; diskon member ditambahkan sebagai nilai pembanding — jika dipilih promo = 0 (tidak memilih promo), ringkasan memakai diskon member (bila aktif).

## 4. Detail Transaksi & Riwayat

- `transaksi.diskon` = diskon terpakai; tidak ada kolom baru.
- `pelanggan/pesanan/show` — baris Diskon tetap tampil; label sumber diskon opsional (catatan di `transaksi.catatan`, mis. "Diskon: Member Silver 5%").

## 5. QA

1. Update `membership.min_transaksi` (3/5/10) terverifikasi di DB.
2. Pelanggan 2 transaksi Lunas + level Silver → checkout: diskon member belum aktif, info "Butuh 1 pembelian lagi".
3. Pelanggan 3+ transaksi Lunas + level Silver → diskon 5% otomatis aktif.
4. Promo 20% vs member 5% → promo menang; klaim promo tetap `digunakan`.
5. Promo 5% vs member 10% → member menang; **klaim promo tidak dihabiskan** (tetap 'tersedia').
6. Transaksi kasir ikut dihitung sebagai pembelian produk.
7. Render checkout + pesanan OK, `view:cache` OK.
