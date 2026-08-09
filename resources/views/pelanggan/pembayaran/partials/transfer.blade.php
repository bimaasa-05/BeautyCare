@php
    $pembayaran = $transaksi->pembayaran;
    $bank = $pembayaran->bank;
    $provider = $pembayaran->provider;
    $bankColors = [
        'BRI' => 'linear-gradient(135deg,#00529C,#003A6E)',
        'BCA' => 'linear-gradient(135deg,#CC0000,#990000)',
        'Mandiri' => 'linear-gradient(135deg,#003D79,#00264D)',
        'BNI' => 'linear-gradient(135deg,#FF6600,#CC5200)',
        'BSI' => 'linear-gradient(135deg,#005747,#003A2E)',
    ];
@endphp
<div class="pm-box">
    <div class="bank-card-hero" style="background:{{ $bankColors[$provider] ?? 'linear-gradient(135deg,#64748B,#475569)' }};">
        <div class="bank-card-head">
            <span class="bank-card-name">{{ $provider }}</span>
            <span class="bank-card-chip">
                <i class="fa-solid fa-building-columns"></i>
            </span>
        </div>
        <div class="bank-card-label">Nomor Virtual Account</div>
        <div class="bank-card-va" id="vaNumber">{{ $pembayaran->kode_pembayaran }}</div>
        <button type="button" class="pm-copy-btn bank-card-copy" onclick="salinVA()">
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
            <b>{{ $provider }}</b>
        </div>
        <div class="pm-bank-info-row">
            <span>No. Rekening</span>
            <b>{{ $pembayaran->no_rekening_tujuan ?? $bank->no_rekening ?? '-' }}</b>
        </div>
        <div class="pm-bank-info-row">
            <span>Atas Nama</span>
            <b>{{ $pembayaran->atas_nama_tujuan ?? $bank->atas_nama ?? 'BeautyCare Official' }}</b>
        </div>
        @if($bank && $bank->logo)
        <div class="pm-bank-info-row">
            <span>Logo Bank</span>
            <img src="{{ asset('storage/' . $bank->logo) }}" alt="{{ $bank->nama_bank }}" style="height:40px;">
        </div>
        @endif
    </div>

    <div class="pm-steps">
        <div class="pm-step">
            <span class="pm-step-num">1</span>
            <span>Buka aplikasi m-banking / ATM bank <b>{{ $provider }}</b></span>
        </div>
        <div class="pm-step">
            <span class="pm-step-num">2</span>
            <span>Pilih menu Transfer > Virtual Account, masukkan nomor <b>{{ $pembayaran->kode_pembayaran }}</b></span>
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