# Update QRIS Flow

## Tujuan
QRIS bisa di-scan aplikasi APAPUN (Dana, GoPay, OVO, Mobile Banking, dll),
pelanggan isi nominal sendiri, kasir cuma upload bukti.

## Masalah Saat Ini
- Form QRIS masih ada input "Jumlah Dibayar" dan "Kembali" yang diisi kasir
- Padahal di flow QRIS: pelanggan yang scan QR dan input nominal sendiri

## Target Flow Baru

```
1. Kasir pilih metode QRIS
2. QR code tampil dengan animasi scan
3. Info teks: "Scan dengan aplikasi apapun (Dana, GoPay, OVO, Mobile Banking, dll)"
4. Pelanggan scan QR menggunakan hp sendiri
5. Pelanggan input nominal di aplikasi mereka
6. Pelanggan bayar & tunjukkin bukti ke kasir
7. Kasir upload screenshot bukti + catat nama pengirim (atas nama)
8. Simpan transaksi → status otomatis "Selesai"
```

## Perubahan File

| File | Perubahan |
|------|-----------|
| `app/Http/Controllers/KasirTransaksiController.php` | store(): QRIS auto status → 1 (selesai) |
| `resources/views/kasir/transaksi/create.blade.php` | Hapus input dibayar/kembali di section QRIS, tambah info teks universal, ubah tombol simpan jadi "Konfirmasi Pembayaran QRIS" |
| `resources/views/kasir/transaksi/edit.blade.php` | Sama seperti create |
| `resources/views/kasir/transaksi/show.blade.php` | Tampilkan "Dibayar via QRIS", sembunyikan nominal dibayar/kembali khusus QRIS |

## Detail Perubahan Form QRIS

| Sekarang | Usulan Baru | Alasan |
|----------|-------------|--------|
| Input "Jumlah Dibayar" | Dihapus | Pelanggan input sendiri di hp |
| Input "Kembali" | Dihapus | Udah otomatis lunas |
| Input "Atas Nama" | Tetap | Catat siapa yg bayar |
| Upload Bukti Bayar | Tetap | Arsip transaksi |
| - | Baru: info teks panduan scan | Guide buat kasir & pelanggan |
| - | Baru: status auto "Selesai" | QRIS pembayaran instant |

## Yang Tidak Diubah
- Database / migration
- Model Transaksi
- Routes
- CSS / theme yang sudah ada
- File lain di luar yang disebutkan

## Flow Perbandingan Antar Metode

```
QRIS (baru):
  Scan QR → pelanggan input nominal → upload bukti → Selesai ✅

E-Wallet (nanti):
  Pilih metode → input nominal + upload bukti → Selesai ✅

Transfer (udah jadi):
  Input bank + rekening + upload bukti → Proses ⏳

Tunai (udah jadi):
  Input nominal + hitung kembalian → Selesai ✅
```
