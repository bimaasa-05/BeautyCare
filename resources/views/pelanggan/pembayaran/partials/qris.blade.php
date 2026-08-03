<div class="pm-box">
    <div class="pm-qr-wrap">
        <img src="{{ asset('assets/img/qris-merchant.png') }}" alt="QRIS BeautyCare" class="pm-qr-img">
        <div class="pm-merchant">
            <div class="pm-merchant-name"><i class="fa-solid fa-store"></i> BeautyCare</div>
            <div class="pm-merchant-id">Bayar dengan QRIS</div>
        </div>
    </div>

    <div class="pm-nominal">
        <div class="pm-nominal-label">Total Pembayaran</div>
        <div class="pm-nominal-value">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</div>
    </div>

    <div class="pm-steps">
        <div class="pm-step">
            <span class="pm-step-num">1</span>
            <span>Buka aplikasi e-wallet / m-banking Anda</span>
        </div>
        <div class="pm-step">
            <span class="pm-step-num">2</span>
            <span>Pilih menu Scan / QRIS, lalu pindai kode di atas</span>
        </div>
        <div class="pm-step">
            <span class="pm-step-num">3</span>
            <span>Pastikan nominal <b>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</b> sesuai lalu konfirmasi pembayaran</span>
        </div>
        <div class="pm-step">
            <span class="pm-step-num">4</span>
            <span>Klik <b>"Saya Sudah Bayar"</b> lalu tunggu verifikasi kasir</span>
        </div>
    </div>
</div>
