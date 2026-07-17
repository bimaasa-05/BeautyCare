# BeautyCare - Rencana Kerja Transaksi Kasir

Dokumen perencanaan fitur-fitur yang akan diimplementasikan
pada halaman transaksi kasir.

## Daftar Fitur (Urut Prioritas)

| No | Fitur | Estimasi | Status |
|----|-------|----------|--------|
| 1 | [Update QRIS Flow](01-update-qris-flow.md) | ~30 menit | ✅ Selesai |
| 2 | [E-Wallet ganti Kredit](02-e-wallet-replace-kredit.md) | ~30 menit | ✅ Selesai |
| 3 | [Notifikasi Suara](03-notifikasi-suara.md) | ~15 menit | ✅ Selesai |
| 4 | [Cetak Struk](04-cetak-struk.md) | ~15 menit | ✅ Selesai |
| 5 | [Pecahan Kembalian](05-pecahan-kembalian.md) | ~20 menit | ✅ Selesai |
| 6 | [Payment Timer](06-payment-timer.md) | ~15 menit | ✅ Selesai |

**Total estimasi: ~2 jam**

## Keterangan Status
- 🟢 Selesai
- 🟡 Belum
- 🔴 Ditunda
- ✅ Diimplementasikan (untuk fitur yang sudah jalan)

## Struktur Metode Pembayaran Final

```
Metode Pembayaran:
├── 💵 Tunai           → auto selesai, hitung kembalian + pecahan
├── 📱 QRIS            → QR scan universal + animasi scan + timer
├── 💳 E-Wallet        → Dana / GoPay / OVO / ShopeePay + timer
├── 🏦 Transfer        → bank asal/tujuan + rekening + upload bukti
└── 💳 Debit           → nominal + atas nama + upload bukti
```

## Catatan
- Tidak mengubah struktur database yang sudah ada
- Tidak mengubah CSS / theme utama
- Tidak mengubah file migration
- Semua perubahan hanya di Controller dan View
- Web Audio API untuk notifikasi suara (native, tanpa library)
- QR Code menggunakan package `simplesoftwareio/simple-qrcode` (sudah terinstall)
