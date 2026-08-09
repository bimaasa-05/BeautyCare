@php
    $pembayaran = $transaksi->pembayaran;
    $bank = $pembayaran->bank;
@endphp
<div class="pm-box">
    <div class="pm-va-wrap">
        <div class="pm-va-bank">
            <i class="fa-solid fa-wallet"></i> {{ $pembayaran->provider }}
        </div>
        <div class="pm-va-label">Kode Referensi Pembayaran</div>
        <div class="pm-va-number" id="vaNumber">{{ $pembayaran->kode_pembayaran }}</div>
        <button type="button" class="pm-copy-btn" onclick="salinVA()">
            <i class="fa-regular fa-copy"></i> Salin Kode Referensi
        </button>
    </div>

    <div class="pm-nominal">
        <div class="pm-nominal-label">Total Pembayaran</div>
        <div class="pm-nominal-value">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</div>
    </div>

    @if($bank && $bank->nomor_telepon)
    <div class="pm-bank-info" style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border);">
        <div class="pm-bank-info-row">
            <span>Kontak E-Wallet</span>
            <b>{{ $bank->nomor_telepon }}</b>
        </div>
        <div class="pm-bank-info-row">
            <span>Atas Nama</span>
            <b>{{ $bank->atas_nama ?? 'BeautyCare Official' }}</b>
        </div>
    </div>
    @endif

    <div class="pm-steps">
        <div class="pm-step">
            <span class="pm-step-num">1</span>
            <span>Buka aplikasi <b>{{ $pembayaran->provider }}</b> Anda</span>
        </div>
        <div class="pm-step">
            <span class="pm-step-num">2</span>
            <span>Pilih menu Bayar / Scan QRIS, lalu scan kode QR merchant BeautyCare</span>
        </div>
        <div class="pm-step">
            <span class="pm-step-num">3</span>
            <span>Masukkan nominal <b>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</b> atau gunakan kode referensi <b>{{ $pembayaran->kode_pembayaran }}</b></span>
        </div>
        <div class="pm-step">
            <span class="pm-step-num">4</span>
            <span>Klik <b>"Saya Sudah Bayar"</b> lalu tunggu verifikasi kasir</span>
        </div>
    </div>
</div>