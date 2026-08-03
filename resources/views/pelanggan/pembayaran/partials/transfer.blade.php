<div class="pm-box">
    <div class="pm-va-wrap">
        <div class="pm-va-bank">{{ $transaksi->pembayaran->provider }}</div>
        <div class="pm-va-label">Nomor Virtual Account</div>
        <div class="pm-va-number" id="vaNumber">{{ $transaksi->pembayaran->kode_pembayaran }}</div>
        <button type="button" class="pm-copy-btn" onclick="salinVA()">
            <i class="fa-regular fa-copy"></i> Salin Nomor VA
        </button>
    </div>

    <div class="pm-nominal">
        <div class="pm-nominal-label">Total Pembayaran</div>
        <div class="pm-nominal-value">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</div>
    </div>

    <div class="pm-bank-info">
        <div class="pm-bank-info-row">
            <span>Bank Tujuan</span>
            <b>{{ $transaksi->pembayaran->provider }}</b>
        </div>
        <div class="pm-bank-info-row">
            <span>No. Rekening</span>
            <b>{{ $bankTujuan[$transaksi->pembayaran->provider] ?? '-' }}</b>
        </div>
        <div class="pm-bank-info-row">
            <span>Atas Nama</span>
            <b>BeautyCare Official</b>
        </div>
    </div>

    <div class="pm-steps">
        <div class="pm-step">
            <span class="pm-step-num">1</span>
            <span>Buka aplikasi m-banking / ATM bank <b>{{ $transaksi->pembayaran->provider }}</b></span>
        </div>
        <div class="pm-step">
            <span class="pm-step-num">2</span>
            <span>Pilih menu Transfer &gt; Virtual Account, masukkan nomor <b>{{ $transaksi->pembayaran->kode_pembayaran }}</b></span>
        </div>
        <div class="pm-step">
            <span class="pm-step-num">3</span>
            <span>Pastikan nominal <b>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</b> sesuai lalu konfirmasi</span>
        </div>
        <div class="pm-step">
            <span class="pm-step-num">4</span>
            <span>Klik <b>"Saya Sudah Bayar"</b> lalu tunggu verifikasi kasir</span>
        </div>
    </div>
</div>
