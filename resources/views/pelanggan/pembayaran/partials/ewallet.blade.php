<div class="pm-box">
    <div class="pm-va-wrap">
        <div class="pm-va-bank">
            <i class="fa-solid fa-wallet"></i> {{ $transaksi->pembayaran->provider }}
        </div>
        <div class="pm-va-label">Kode Referensi Pembayaran</div>
        <div class="pm-va-number" id="vaNumber">{{ $transaksi->pembayaran->kode_pembayaran }}</div>
        <button type="button" class="pm-copy-btn" onclick="salinVA()">
            <i class="fa-regular fa-copy"></i> Salin Kode Referensi
        </button>
    </div>

    <div class="pm-nominal">
        <div class="pm-nominal-label">Total Pembayaran</div>
        <div class="pm-nominal-value">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</div>
    </div>

    <div class="pm-steps">
        <div class="pm-step">
            <span class="pm-step-num">1</span>
            <span>Buka aplikasi <b>{{ $transaksi->pembayaran->provider }}</b> Anda</span>
        </div>
        <div class="pm-step">
            <span class="pm-step-num">2</span>
            <span>Pilih menu Bayar / Scan QRIS, lalu scan kode QR merchant BeautyCare</span>
        </div>
        <div class="pm-step">
            <span class="pm-step-num">3</span>
            <span>Masukkan nominal <b>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</b> atau gunakan kode referensi <b>{{ $transaksi->pembayaran->kode_pembayaran }}</b></span>
        </div>
        <div class="pm-step">
            <span class="pm-step-num">4</span>
            <span>Klik <b>"Saya Sudah Bayar"</b> lalu tunggu verifikasi kasir</span>
        </div>
    </div>
</div>
