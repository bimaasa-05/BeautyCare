<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran {{ $transaksi->no_invoice }} - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
    .sidebar-toggle {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px;
    }

    .sidebar-toggle svg {
        width: 24px;
        height: 24px;
        color: var(--dark);
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        z-index: 90;
    }

    .sidebar-overlay.active {
        display: block;
    }

    @media (max-width: 768px) {
        .sidebar-toggle {
            display: flex;
            align-items: center;
        }
    }

    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .page-header-premium {
        background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 79, 135, 0.08);
    }

    .page-header-premium::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 79, 135, 0.12) 0%, transparent 70%);
        pointer-events: none;
    }

    .page-header-premium .ph-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .page-header-premium .ph-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-header-premium .ph-icon-wrap {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 22px;
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
        flex-shrink: 0;
    }

    .page-header-premium .ph-text h3 {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .page-header-premium .ph-text p {
        font-size: 13px;
        color: var(--gray);
        margin: 2px 0 0;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 100px;
        border: 1.5px solid var(--primary);
        background: var(--white);
        color: var(--primary);
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.15);
    }

    .btn-back:hover {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        transform: translateY(-1px);
    }

    .pay-main {
        max-width: 720px;
        margin: 0 auto;
    }

    .status-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        padding: 22px 26px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .status-card .sc-info .sc-invoice {
        font-size: 12px;
        font-weight: 600;
        color: var(--primary);
        letter-spacing: 0.4px;
    }

    .status-card .sc-info .sc-total {
        font-size: 22px;
        font-weight: 800;
        color: var(--dark);
        margin-top: 2px;
    }

    .status-card .sc-info .sc-meta {
        font-size: 12px;
        color: var(--gray);
        margin-top: 2px;
    }

    .countdown-box {
        background: linear-gradient(135deg, #FFF5F8, #FFE5EF);
        border: 1px solid #FFD6E6;
        border-radius: 16px;
        padding: 12px 22px;
        text-align: center;
    }

    .countdown-box .cd-label {
        font-size: 10.5px;
        font-weight: 600;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .countdown-box .cd-time {
        font-size: 26px;
        font-weight: 800;
        color: var(--dark);
        font-variant-numeric: tabular-nums;
        margin-top: 2px;
    }

    .countdown-box .cd-time.warning {
        color: #DC2626;
    }

    .waiting-box {
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
        border-radius: 16px;
        padding: 14px 22px;
        text-align: center;
    }

    .waiting-box .wb-title {
        font-size: 14px;
        font-weight: 700;
        color: #1D4ED8;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .waiting-box .wb-title i {
        animation: spin 1.5s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .waiting-box .wb-desc {
        font-size: 12px;
        color: #3B5BDB;
        margin-top: 4px;
    }

    .pay-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .pay-card .pc-header {
        padding: 18px 26px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pay-card .pc-header .pc-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: var(--hover);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .pay-card .pc-header .pc-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
    }

    .pay-card .pc-header .pc-subtitle {
        font-size: 12px;
        color: var(--gray);
    }

    .pm-box {
        padding: 26px;
    }

    .bank-card-hero {
        border-radius: 18px;
        padding: 24px 22px;
        color: #fff;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.18);
        position: relative;
        overflow: hidden;
    }

    .bank-card-hero::after {
        content: '';
        position: absolute;
        right: -40px;
        top: -40px;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
    }

    .bank-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .bank-card-name {
        font-size: 18px;
        font-weight: 800;
        letter-spacing: 2px;
    }

    .bank-card-chip {
        width: 36px;
        height: 28px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }

    .bank-card-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.75;
        font-weight: 600;
    }

    .bank-card-va {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: 1.5px;
        font-family: 'Courier New', monospace;
        margin-top: 4px;
    }

    .bank-card-copy {
        margin-top: 16px;
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.35);
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background 0.2s;
    }

    .bank-card-copy:hover {
        background: rgba(255, 255, 255, 0.22);
    }

    .pm-qr-wrap {
        text-align: center;
    }

    .pm-qr-img {
        width: 280px;
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        border: 1px solid #F3C6D3;
        padding: 10px;
        background: #fff;
        display: inline-block;
    }

    .pm-merchant {
        margin-top: 14px;
    }

    .pm-merchant-name {
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .pm-merchant-name i {
        color: var(--primary);
    }

    .pm-merchant-id {
        font-size: 11px;
        color: var(--gray);
        margin-top: 2px;
    }

    .pm-nominal {
        text-align: center;
        margin: 22px 0;
        padding: 16px;
        background: #FFF9FB;
        border: 1px solid #FFE5EF;
        border-radius: 14px;
    }

    .pm-saldo-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 14px;
        padding: 10px 14px;
        background: #ECFDF5;
        border: 1px solid #A7F3D0;
        border-radius: 12px;
    }

    .pm-saldo-info span {
        font-size: 12px;
        font-weight: 600;
        color: #047857;
    }

    .pm-saldo-info b {
        font-size: 13px;
        font-weight: 700;
        color: #059669;
        font-variant-numeric: tabular-nums;
    }

    .pm-kombinasi {
        background: #FFF9FB;
        border: 1px solid #FFE5EF;
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 14px;
    }

    .pm-kombinasi .pk-title {
        font-size: 12px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .pm-kombinasi .pk-title i {
        color: var(--primary);
        margin-right: 6px;
    }

    .pm-kombinasi .pk-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12.5px;
        color: var(--gray);
        padding: 4px 0;
    }

    .pm-kombinasi .pk-row b {
        color: var(--dark);
        font-variant-numeric: tabular-nums;
    }

    .pm-kombinasi .pk-total {
        border-top: 1px dashed #FFD6E6;
        margin-top: 6px;
        padding-top: 10px;
    }

    .pm-kombinasi .pk-total span {
        font-weight: 600;
        color: var(--dark);
    }

    .pm-kombinasi .pk-total b {
        font-size: 16px;
        font-weight: 800;
        color: var(--primary);
    }

    .pm-nominal-label {
        font-size: 11px;
        color: var(--gray);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .pm-nominal-value {
        font-size: 24px;
        font-weight: 800;
        color: var(--dark);
        margin-top: 2px;
    }

    .pm-va-wrap {
        text-align: center;
    }

    .pm-va-bank {
        font-size: 15px;
        font-weight: 800;
        color: var(--dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .pm-va-label {
        font-size: 11px;
        color: var(--gray);
        margin-top: 6px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .pm-va-number {
        font-size: 26px;
        font-weight: 800;
        color: var(--primary);
        letter-spacing: 2px;
        background: #FFF5F8;
        border: 1.5px dashed #F3C6D3;
        border-radius: 14px;
        padding: 14px;
        margin-top: 8px;
        font-variant-numeric: tabular-nums;
    }

    .pm-copy-btn {
        margin-top: 12px;
        padding: 10px 22px;
        border-radius: 100px;
        border: 1.5px solid var(--primary);
        background: var(--white);
        color: var(--primary);
        font-size: 12px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .pm-copy-btn:hover {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
    }

    .pm-copy-btn.copied {
        background: #10B981;
        border-color: #10B981;
        color: #fff;
    }

    .pm-bank-info {
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 18px;
    }

    .pm-bank-info-row {
        display: flex;
        justify-content: space-between;
        font-size: 12.5px;
        padding: 5px 0;
        color: var(--gray);
    }

    .pm-bank-info-row b {
        color: var(--dark);
    }

    .pm-steps {
        text-align: left;
    }

    .pm-step {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 12.5px;
        color: var(--dark);
        padding: 6px 0;
        line-height: 1.5;
    }

    .pm-step b {
        color: var(--primary);
    }

    .pm-step-num {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .pay-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 20px;
    }

    @media (max-width: 560px) {
        .pay-actions {
            grid-template-columns: 1fr;
        }
    }

    .btn-pay {
        padding: 14px;
        border-radius: 14px;
        border: none;
        font-size: 13.5px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-pay-confirm {
        background: linear-gradient(135deg, #10B981, #34D399);
        color: #fff;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
    }

    .btn-pay-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.4);
    }

    .btn-pay-batal {
        background: #fff;
        color: #DC2626;
        border: 1.5px solid #FECACA;
    }

    .btn-pay-batal:hover {
        background: #FEF2F2;
    }

    .pay-demo-note {
        margin-top: 14px;
        padding: 12px 16px;
        border-radius: 12px;
        background: #FFFBEB;
        border: 1px solid #FDE68A;
        font-size: 12px;
        color: #92400E;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-box {
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 12px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-box.alert-error {
        background: #FEF2F2;
        color: #B91C1C;
        border: 1px solid #FECACA;
    }

    .alert-box.alert-success {
        background: #ECFDF5;
        color: #047857;
        border: 1px solid #A7F3D0;
    }

    .expired-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .expired-modal.show {
        display: flex;
    }

    .expired-modal .em-card {
        background: var(--white);
        border-radius: 20px;
        max-width: 420px;
        width: 100%;
        padding: 28px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        animation: modalIn 0.3s ease;
    }

    .expired-modal .em-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #FEF2F2;
        color: #DC2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin: 0 auto 14px;
    }

    .expired-modal .em-title {
        font-size: 17px;
        font-weight: 800;
        color: var(--dark);
    }

    .expired-modal .em-desc {
        font-size: 12.5px;
        color: var(--gray);
        margin-top: 6px;
        line-height: 1.6;
    }

    .expired-modal .em-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 20px;
    }

    @media (max-width: 480px) {
        .expired-modal .em-actions {
            grid-template-columns: 1fr;
        }
    }

    .expired-modal .em-btn {
        padding: 13px;
        border-radius: 12px;
        border: none;
        font-size: 13px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .expired-modal .em-btn-lanjut {
        background: linear-gradient(135deg, #10B981, #34D399);
        color: #fff;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
    }

    .expired-modal .em-btn-lanjut:hover {
        transform: translateY(-2px);
    }

    .expired-modal .em-btn-batal {
        background: #fff;
        color: #DC2626;
        border: 1.5px solid #FECACA;
    }

    .expired-modal .em-btn-batal:hover {
        background: #FEF2F2;
    }

    .bukti-input {
        display: none;
    }

    .bukti-pick {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        padding: 20px 16px;
        border: 1.5px dashed #F3C6D3;
        border-radius: 14px;
        background: #FFF9FB;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
    }

    .bukti-pick:hover {
        background: #FFF5F8;
        border-color: var(--primary);
    }

    .bukti-pick i {
        font-size: 22px;
        color: var(--primary);
    }

    .bukti-pick span {
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
    }

    .bukti-pick small {
        font-size: 11px;
        color: var(--gray);
    }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Selesaikan Pembayaran</h3>
                                <p>Pesanan {{ $transaksi->no_invoice }} sedang menunggu pembayaran</p>
                            </div>
                        </div>
                        <a href="{{ route('pelanggan.keranjang.history') }}" class="btn-back">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                @if (session('message'))
                <div class="alert-box alert-success">
                    <i class="fa-solid fa-circle-check"></i> {{ session('message') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert-box alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
                @endif

                <div class="pay-main">
                    <div class="status-card">
                        <div class="sc-info">
                            <div class="sc-invoice"><i class="fa-solid fa-receipt"></i> {{ $transaksi->no_invoice }}</div>
                            <div class="sc-total">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</div>
                            <div class="sc-meta">{{ $transaksi->pembayaran->provider }} &bull; Dibuat {{ \Carbon\Carbon::parse($transaksi->tanggal)->isoFormat('D MMM YYYY') }}</div>
                        </div>

                        @if($transaksi->status === 'Menunggu Pembayaran')
                        <div class="countdown-box">
                            <div class="cd-label"><i class="fa-regular fa-clock"></i> Sisa Waktu Pembayaran</div>
                            <div class="cd-time" id="countdown" data-expires="{{ $transaksi->pembayaran->expires_at->toIso8601String() }}">--:--:--</div>
                        </div>
                        @else
                        <div class="waiting-box">
                            <div class="wb-title"><i class="fa-solid fa-circle-notch"></i> Menunggu Verifikasi Kasir</div>
                            <div class="wb-desc">Konfirmasi pembayaran Anda sudah terkirim. Kasir akan memverifikasi pesanan Anda.</div>
                        </div>
                        @endif
                    </div>

                    <div class="pay-card">
                        <div class="pc-header">
                            <div class="pc-icon"><i class="fa-solid fa-wallet"></i></div>
                            <div>
                                <div class="pc-title">
                                    @if($transaksi->pembayaran->metode === 'QRIS')
                                    QRIS
                                    @elseif($transaksi->pembayaran->metode === 'Transfer')
                                    Transfer Bank - {{ $transaksi->pembayaran->provider }}
                                    @elseif($transaksi->pembayaran->metode === 'Saldo')
                                    Saldo Akun
                                    @else
                                    E-Wallet - {{ $transaksi->pembayaran->provider }}
                                    @endif
                                </div>
                                <div class="pc-subtitle">Metode pembayaran yang Anda pilih</div>
                            </div>
                        </div>

                        @php $dibayarSaldoP = (float) ($transaksi->saldo_terpakai ?? 0); @endphp

                        @if($dibayarSaldoP > 0 && $transaksi->pembayaran->metode !== 'Saldo')
                        <div class="pm-kombinasi">
                            <div class="pk-title"><i class="fa-solid fa-layer-group"></i> Pembayaran Kombinasi</div>
                            <div class="pk-row">
                                <span>Total Pesanan</span>
                                <b>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</b>
                            </div>
                            <div class="pk-row">
                                <span>Dibayar Saldo Akun</span>
                                <b style="color:#059669;">- Rp {{ number_format($dibayarSaldoP, 0, ',', '.') }}</b>
                            </div>
                            <div class="pk-row pk-total">
                                <span>Sisa via {{ $transaksi->pembayaran->provider }}</span>
                                <b>Rp {{ number_format($transaksi->pembayaran->nominal, 0, ',', '.') }}</b>
                            </div>
                        </div>
                        @endif

                        @if($transaksi->pembayaran->metode === 'QRIS')
                        @include('pelanggan.pembayaran.partials.qris')
                        @elseif($transaksi->pembayaran->metode === 'Transfer')
                        @include('pelanggan.pembayaran.partials.transfer')
                        @elseif($transaksi->pembayaran->metode === 'Saldo')
                        @include('pelanggan.pembayaran.partials.saldo')
                        @else
                        @include('pelanggan.pembayaran.partials.ewallet')
                        @endif
                    </div>

                    @if(in_array($transaksi->status, ['Menunggu Pembayaran', 'Sedang Diproses']) && $transaksi->pembayaran->metode !== 'Saldo')
                    <div class="pay-card">
                        <div class="pc-header">
                            <div class="pc-icon"><i class="fa-solid fa-paperclip"></i></div>
                            <div>
                                <div class="pc-title">Upload Bukti Pembayaran</div>
                                <div class="pc-subtitle">Screenshot bukti transfer / pembayaran Anda (opsional, maks 2 MB)</div>
                            </div>
                        </div>
                        <div class="pm-box">
                            @if($transaksi->bukti_bayar)
                            <div style="text-align:center;margin-bottom:14px;">
                                <img src="{{ Storage::url($transaksi->bukti_bayar) }}" alt="Bukti bayar" style="max-width:220px;border-radius:14px;border:1.5px solid var(--border);">
                                <div style="font-size:11px;color:var(--gray);margin-top:6px;">Bukti yang sudah diunggah. Ganti dengan yang baru jika diperlukan.</div>
                            </div>
                            @endif
                            <form action="{{ route('pelanggan.pembayaran.bukti', $transaksi->id_transaksi) }}" method="POST" enctype="multipart/form-data" id="formBukti">
                                @csrf
                                <input type="file" name="bukti_bayar" id="inpBukti" accept="image/jpeg,image/png,image/jpg" class="bukti-input" onchange="pilihBukti(this)">
                                <div class="bukti-pick" id="buktiPick" onclick="document.getElementById('inpBukti').click()">
                                    <i class="fa-solid fa-image"></i>
                                    <span id="buktiLabel">{{ $transaksi->bukti_bayar ? 'Ganti Bukti Pembayaran' : 'Upload Bukti Pembayaran' }}</span>
                                    <small>JPG / PNG, maks 2 MB</small>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                    @if($transaksi->status === 'Menunggu Pembayaran')
                    <div class="pay-actions">
                        <form action="{{ route('pelanggan.pembayaran.sudah-bayar', $transaksi->id_transaksi) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-pay btn-pay-confirm" style="width:100%;" data-confirm-title="Saya Sudah Bayar" data-confirm-body="Pastikan Anda sudah melakukan pembayaran sesuai nominal. Lanjutkan?" data-confirm-icon="fa-money-check-dollar" data-confirm-type="warning" data-confirm-yes="Ya, Sudah Bayar">
                                <i class="fa-solid fa-check-circle"></i> Saya Sudah Bayar
                            </button>
                        </form>
                        <form action="{{ route('pelanggan.pembayaran.batal', $transaksi->id_transaksi) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-pay btn-pay-batal" style="width:100%;" data-confirm-title="Batalkan Pesanan" data-confirm-body="Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan." data-confirm-icon="fa-circle-xmark" data-confirm-type="danger" data-confirm-yes="Ya, Batalkan">
                                <i class="fa-solid fa-xmark"></i> Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                    @endif

                    @if($demoMode)
                    <div class="pay-demo-note">
                        <i class="fa-solid fa-flask"></i>
                        <span>Mode demo aktif: gunakan tombol <b>Simulasi Bayar Berhasil</b> di halaman kasir untuk menguji alur verifikasi.</span>
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <div class="expired-modal" id="expiredModal">
        <div class="em-card">
            <div class="em-icon"><i class="fa-solid fa-clock"></i></div>
            <div class="em-title">Waktu Pembayaran Habis</div>
            <div class="em-desc">Pembayaran pesanan <b>{{ $transaksi->no_invoice }}</b> melewati batas waktu. Anda bisa memperpanjang waktu atau membatalkan pesanan.</div>
            <div class="em-actions">
                <form action="{{ route('pelanggan.pembayaran.perpanjang', $transaksi->id_transaksi) }}" method="POST" style="display:contents;">
                    @csrf
                    <button type="submit" class="em-btn em-btn-lanjut">
                        <i class="fa-solid fa-clock-rotate-left"></i> Lanjut Pembayaran
                    </button>
                </form>
                <form action="{{ route('pelanggan.pembayaran.batal', $transaksi->id_transaksi) }}" method="POST" style="display:contents;">
                    @csrf
                    <button type="submit" class="em-btn em-btn-batal" data-confirm-title="Batalkan Pesanan" data-confirm-body="Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan." data-confirm-icon="fa-circle-xmark" data-confirm-type="danger" data-confirm-yes="Ya, Batalkan">
                        <i class="fa-solid fa-xmark"></i> Batal Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    var expiresAt = document.getElementById('countdown') ? new Date(document.getElementById('countdown').getAttribute('data-expires')) : null;
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    var statusRoute = '{{ route("pelanggan.pembayaran.status", $transaksi->id_transaksi) }}';
    var berhasilRoute = '{{ route("pelanggan.pembayaran.berhasil", $transaksi->id_transaksi) }}';
    var pesananRoute = '{{ route("pelanggan.pesanan.show", $transaksi->id_transaksi) }}';
    var expiredShown = false;

    function pilihBukti(input) {
        if (!input.files || !input.files[0]) return;
        var label = document.getElementById('buktiLabel');
        var pick = document.getElementById('buktiPick');
        label.textContent = 'Mengunggah bukti bayar...';
        pick.style.pointerEvents = 'none';
        pick.style.opacity = '0.6';
        document.getElementById('formBukti').submit();
    }

    function showExpiredModal() {
        if (expiredShown) return;
        expiredShown = true;
        var el = document.getElementById('countdown');
        if (el) {
            el.textContent = '00:00:00';
            el.classList.add('warning');
        }
        document.getElementById('expiredModal').classList.add('show');
    }

    function updateCountdown() {
        if (!expiresAt) return;
        var el = document.getElementById('countdown');
        var diff = expiresAt - new Date();
        if (diff <= 0) {
            showExpiredModal();
            return;
        }
        var h = Math.floor(diff / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);
        var pad = function(n) { return n < 10 ? '0' + n : n; };
        el.textContent = pad(h) + ':' + pad(m) + ':' + pad(s);
        if (diff < 100000) el.classList.add('warning');
    }

    if (expiresAt) {
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    function salinVA() {
        var va = document.getElementById('vaNumber').textContent.trim();
        navigator.clipboard.writeText(va).then(function() {
            var btn = document.querySelector('.pm-copy-btn');
            btn.classList.add('copied');
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Tersalin!';
            setTimeout(function() {
                btn.classList.remove('copied');
                btn.innerHTML = '<i class="fa-regular fa-copy"></i> ' + (btn.getAttribute('data-label') || 'Salin');
            }, 2000);
        });
    }

    var payStatus = '{{ $transaksi->status }}';

    function cekStatus() {
        fetch(statusRoute, { headers: { 'X-CSRF-TOKEN': csrfToken } })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.status === 'Lunas') {
                window.location.href = berhasilRoute;
            } else if (data.status === 'Kadaluarsa') {
                showExpiredModal();
            } else if (data.status === 'Dibatalkan' || data.status === 'Gagal') {
                window.location.href = pesananRoute;
            } else if (data.status === 'Sedang Diproses' && payStatus !== 'Sedang Diproses') {
                window.location.reload();
            }
        })
        .catch(function() {});
    }

    setInterval(cekStatus, 5000);

    const now = new Date();
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    const dateEl = document.getElementById('currentDate');
    if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @include('partials.confirm-modal')
</body>

</html>
