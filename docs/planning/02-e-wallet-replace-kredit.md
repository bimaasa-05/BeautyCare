# Ganti Kredit → E-Wallet (Dana, GoPay, OVO, ShopeePay)

## Tujuan
Kredit jarang dipakai di salon. Ganti dengan E-Wallet yang lebih relevan
dan sering digunakan pelanggan sehari-hari.

## Perubahan File

| File | Perubahan |
|------|-----------|
| `resources/views/kasir/transaksi/create.blade.php` | Ganti option "Kredit" jadi "E-Wallet", tambah dropdown sub-option (Dana/GoPay/OVO/ShopeePay), ubah section payment method |
| `resources/views/kasir/transaksi/edit.blade.php` | Sama seperti create |
| `resources/views/kasir/transaksi/show.blade.php` | Tampilkan metode e-wallet yang dipilih + detail pembayaran |

## Sub-Option E-Wallet

- **Dana**
- **GoPay**
- **OVO**
- **ShopeePay**

## Form E-Wallet

```
[Metode E-Wallet]        ▼ Dana / GoPay / OVO / ShopeePay
[Nominal Dibayar]        [input]
[Kembali]                [auto]
[Atas Nama]              [input]
[Upload Bukti Bayar]     [file]
[Status]                 Otomatis "Selesai"
```

## Flow E-Wallet

```
1. Kasir pilih "E-Wallet"
2. Muncul dropdown pilih: Dana / GoPay / OVO / ShopeePay
3. Input nominal dibayar
4. Otomatis hitung kembalian
5. Input atas nama pengirim
6. Upload screenshot bukti bayar
7. Simpan → status "Selesai" ✅
```

## Yang Tidak Diubah
- Database / migration (cukup pakai `metode_byr` enum + kolom `atas_nama`)
- Model Transaksi
- Routes
- CSS / theme yang sudah ada
