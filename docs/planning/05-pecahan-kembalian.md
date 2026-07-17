# Auto Hitung Pecahan Kembalian

## Tujuan
Kasir langsung tahu pecahan uang yang harus dikembalikan ke pelanggan.
Contoh: Kembali Rp 85.000 → 1×Rp50.000 + 1×Rp20.000 + 1×Rp10.000 + 1×Rp5.000

## Perubahan File

| File | Perubahan |
|------|-----------|
| `resources/views/kasir/transaksi/create.blade.php` | Tambah fungsi JS `hitungPecahan()`, tampilkan hasil di bawah input kembalian |
| `resources/views/kasir/transaksi/edit.blade.php` | Sama seperti create |

## Kode JavaScript

```javascript
function hitungPecahan(nominal) {
    const pecahan = [100000, 50000, 20000, 10000, 5000, 2000, 1000, 500];
    let sisa = nominal;
    const hasil = [];

    pecahan.forEach(p => {
        const jumlah = Math.floor(sisa / p);
        if (jumlah > 0) {
            hasil.push(`${jumlah}×Rp ${p.toLocaleString('id-ID')}`);
            sisa -= jumlah * p;
        }
    });

    return hasil;
}
```

## Tampilan

```
Kembali: Rp 85.000
Pecahan: 1×Rp 50.000 + 1×Rp 20.000 + 1×Rp 10.000 + 1×Rp 5.000
```

## Yang Tidak Diubah
- Database
- Model
- Controller
- Routes
- CSS files
