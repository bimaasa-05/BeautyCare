# Fix SSL SMTP Gmail — Opsi A (php.ini) & Opsi B (config/mail.php)

> Status: **Direncanakan — belum dieksekusi** | Terkait: error `certificate verify failed` saat kirim OTP via Gmail SMTP di mesin rekan developer

---

## Latar Belakang

**Gejala:** Saat daftar/login via Google, callback memanggil `VerificationController::kirimOtp()` (baris 43) → gagal dengan:

```
TransportException — Unable to connect with STARTTLS:
stream_socket_enable_crypto(): SSL operation failed with code 1.
OpenSSL Error messages: error:0A000086:SSL routines::certificate verify failed
```

**Akar masalah:** `.env` **sudah benar** (SMTP Gmail + App Password). Error muncul karena instalasi PHP di mesin rekan **tidak memiliki CA bundle** (`cacert.pem`) untuk verifikasi sertifikat SSL saat STARTTLS ke `smtp.gmail.com`. Di mesin utama, Laragon sudah menyetel `curl.cainfo = "C:\laragon\etc\ssl\cacert.pem"` di php.ini → kirim email sukses.

**Verifikasi di mesin utama:**
```powershell
php -r "echo ini_get('openssl.cafile').PHP_EOL; echo ini_get('curl.cainfo').PHP_EOL;"
# openssl.cafile: '' (kosong, tapi tidak masalah — pakai OS-managed cert store / curl)
# curl.cainfo: 'C:\laragon\etc\ssl\cacert.pem'
```
File `C:\laragon\etc\ssl\cacert.pem` terkonfirmasi ada (Laragon bawaan).

---

## Opsi A — Fix php.ini di Mesin Rekan (DIREKOMENDASIKAN untuk produksi)

### Langkah
1. **Cari lokasi php.ini**: `php --ini` → lihat `Loaded Configuration File:`.
2. **Cek CA bundle**: `Test-Path "C:\laragon\etc\ssl\cacert.pem"` → harus `True`. Kalau tidak ada, download https://curl.se/ca/cacert.pem dan simpan di path itu.
3. **Edit php.ini** (Notepad):
   - Bagian `[curl]` — aktifkan:
     ```ini
     curl.cainfo = "C:\laragon\etc\ssl\cacert.pem"
     ```
   - Bagian `[openssl]` — tambahkan baris baru (default-nya dikomentari):
     ```ini
     openssl.cafile = "C:\laragon\etc\ssl\cacert.pem"
     ```
4. **Restart** Laragon / buka terminal baru.
5. **Verifikasi**:
   ```powershell
   php -r "echo ini_get('openssl.cafile').PHP_EOL; echo ini_get('curl.cainfo').PHP_EOL;"
   ```
   Keduanya harus menampilkan path cacert.pem.
6. **Test**: daftar/login via Google → OTP harus terkirim.

### Catatan
- Aman, verifikasi SSL **tetap aktif** — cocok untuk tahap produksi.
- Tidak mengubah kode repo.

---

## Opsi B — Fix via `config/mail.php` (untuk development cepat)

### Perubahan
`config/mail.php` — mailer `smtp`, tambahkan opsi stream (DEV ONLY):

```php
'smtp' => [
    'transport' => 'smtp',
    'scheme' => env('MAIL_SCHEME'),
    'url' => env('MAIL_URL'),
    'host' => env('MAIL_HOST', '127.0.0.1'),
    'port' => env('MAIL_PORT', 2525),
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
    'timeout' => null,
    'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url((string) env('APP_URL', 'http://localhost'), PHP_URL_HOST)),

    // DEV ONLY — HAPUS SEBELUM PRODUCTION. Menonaktifkan verifikasi sertifikat SSL
    // agar mesin tanpa CA bundle tetap bisa kirim email (Gmail SMTP).
    'stream' => [
        'ssl' => [
            'allow_self_signed' => true,
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ],
],
```

### Efek
- Berlaku untuk **semua mesin** yang pull source code — rekan langsung bisa tanpa sentuh php.ini.
- ⚠️ **Risiko keamanan** (man-in-the-middle). JANGAN dibawa ke produksi.

---

## Keputusan Berjenjang

| Tahap | Solusi | Keterangan |
|---|---|---|
| Sekarang (dev, mesin rekan) | Opsi A ATAU Opsi B | Opsi B lebih cepat (1 file), Opsi A lebih bersih |
| Produksi (Linux/Ubuntu) | **Tanpa perubahan kode** | CA bundle bawaan server (`/etc/ssl/certs/`) → verifikasi jalan otomatis |
| Produksi (Windows) | Opsi A di php.ini server | Jangan pernah Opsi B |

**Catatan kunci:** keduanya tidak saling meniadakan — Opsi A tetap bisa dipasang kapanpun, dan wajib ada kalau Opsi B dihapus sebelum produksi.

---

## Rencana Eksekusi (yang akan kita run)

1. **Putuskan**: pasang Opsi B sekarang (tandai DEV ONLY) ATAU cukup kirim instruksi Opsi A ke rekan.
2. Jika Opsi B → edit `config/mail.php`, verifikasi `php -l` + test kirim via `Mail::raw`.
3. Buat catatan di `00-ROADMAP.md` / checklist: **hapus blok `stream` sebelum deploy produksi**.
4. (Opsional) Verifikasi di mesin rekan setelah Opsi A dipasang: test Google login → OTP masuk Gmail.