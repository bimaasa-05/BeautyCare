# Tombol Cetak Struk

## Tujuan
Kasir bisa cetak struk langsung dari halaman detail transaksi
tanpa perlu browser print menu.

## Perubahan File

| File | Perubahan |
|------|-----------|
| `resources/views/kasir/transaksi/show.blade.php` | Tambah tombol "Cetak Struk", tambah CSS @media print, bungkus area struk dengan class `.struk-area` |

## Desain Struk

Struk akan menampilkan:
```
     BEAUTYCARE SALON
     Jl. Contoh No. 123
   Telp: 0812-3456-7890
  =========================
  No. Invoice: INV-20260716-0001
  Tanggal: 16 Juli 2026
  Kasir: [nama kasir]
  Pelanggan: [nama pelanggan]
  =========================
  Subtotal:       Rp 150.000
  Diskon:         Rp  10.000
  Pajak:          Rp   5.000
  -------------------------
  TOTAL:          Rp 145.000
  =========================
  Metode: QRIS
  Dibayar:        Rp 145.000
  Kembali:        Rp       0
  =========================
  Terima kasih telah
  berbelanja di BeautyCare!
  =========================
```

## CSS Print

```css
@media print {
    @page { margin: 0; size: 80mm auto; }
    body * { visibility: hidden; }
    .struk-area, .struk-area * { visibility: visible; }
    .struk-area {
        position: absolute;
        left: 0; top: 0;
        width: 100%;
        padding: 20px;
        font-family: 'Courier New', monospace;
        font-size: 12px;
    }
    .struk-area .no-print { display: none; }
}
```

## Trigger
- Tombol "Cetak Struk" di halaman show transaksi
- Tidak menyimpan ke database, hanya print dari browser

## Yang Tidak Diubah
- Database
- Model
- Controller
- Routes
