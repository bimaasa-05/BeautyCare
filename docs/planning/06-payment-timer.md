# Payment Timer Countdown (60 Detik)

## Tujuan
Membuat flow pembayaran QRIS/E-Wallet terasa lebih real-time dan profesional.
Kasir dan pelanggan melihat waktu countdown.

## Perubahan File

| File | Perubahan |
|------|-----------|
| `resources/views/kasir/transaksi/create.blade.php` | Tambah timer countdown di section QRIS dan E-Wallet, reset otomatis saat ganti metode |
| `resources/views/kasir/transaksi/edit.blade.php` | Sama seperti create |

## Cara Kerja

```
1. Kasir pilih QRIS/E-Wallet → timer mulai 00:60
2. Timer tampil di atas form pembayaran
3. Hitung mundur setiap detik
4. Jika waktu habis:
   - Tampilkan peringatan "Waktu pembayaran habis"
   - Reset timer ke 00:60
   - Timer mulai lagi
5. Jika kasir klik "Simpan" → timer berhenti
6. Jika ganti metode pembayaran → timer reset
```

## Kode JavaScript

```javascript
let paymentTimer = null;
let timerSeconds = 60;

function startPaymentTimer(displayElement) {
    clearInterval(paymentTimer);
    timerSeconds = 60;
    updateTimerDisplay(displayElement);

    paymentTimer = setInterval(() => {
        timerSeconds--;
        updateTimerDisplay(displayElement);

        if (timerSeconds <= 0) {
            clearInterval(paymentTimer);
            alert('⏰ Waktu pembayaran habis! Silakan ulangi.');
            timerSeconds = 60;
            updateTimerDisplay(displayElement);
            startPaymentTimer(displayElement);
        }
    }, 1000);
}

function updateTimerDisplay(el) {
    const menit = Math.floor(timerSeconds / 60);
    const detik = timerSeconds % 60;
    el.textContent = `${String(menit).padStart(2, '0')}:${String(detik).padStart(2, '0')}`;

    // Warna berubah kalau < 10 detik
    if (timerSeconds <= 10) {
        el.style.color = '#EF4444';
    } else {
        el.style.color = '#666666';
    }
}

function stopPaymentTimer() {
    clearInterval(paymentTimer);
}
```

## Visual Timer

```
⏱️ Sisa Waktu: 00:45
```

Timer akan:
- Normal: teks abu-abu
- < 10 detik: teks merah (peringatan)

## Yang Tidak Diubah
- Database
- Model
- Controller
- Routes
- CSS files utama
