<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Pesanan {{ $transaksi->no_invoice }} - BeautyCare</title>
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

    .detail-layout {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 992px) {
        .detail-layout {
            grid-template-columns: 1fr;
        }
    }

    .d-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .d-card .dc-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .d-card .dc-header .dc-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--hover);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .d-card .dc-header .dc-title {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--dark);
    }

    .d-card .dc-header .dc-subtitle {
        font-size: 11.5px;
        color: var(--gray);
    }

    .d-body {
        padding: 20px 24px;
    }

    .status-hero {
        text-align: center;
        padding: 24px;
        border-bottom: 1px solid var(--border);
    }

    .status-hero .sh-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 18px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 700;
    }

    .status-hero .sh-invoice {
        font-size: 12px;
        font-weight: 600;
        color: var(--primary);
        letter-spacing: 0.5px;
        margin-top: 12px;
    }

    .status-hero .sh-total {
        font-size: 26px;
        font-weight: 800;
        color: var(--dark);
        margin-top: 2px;
    }

    .status-hero .sh-meta {
        font-size: 12px;
        color: var(--gray);
        margin-top: 4px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 14px;
        border-radius: 100px;
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    .status-badge .sb-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .status-menunggu { background: #FEF3C7; color: #B45309; }
    .status-menunggu .sb-dot { background: #F59E0B; }
    .status-diproses { background: #DBEAFE; color: #1D4ED8; }
    .status-diproses .sb-dot { background: #3B82F6; }
    .status-lunas { background: #D1FAE5; color: #059669; }
    .status-lunas .sb-dot { background: #059669; }
    .status-dp { background: #EDE9FE; color: #6D28D9; }
    .status-dp .sb-dot { background: #7C3AED; }
    .status-gagal { background: #FEE2E2; color: #B91C1C; }
    .status-gagal .sb-dot { background: #DC2626; }
    .status-kadaluarsa, .status-dibatalkan { background: #F3F4F6; color: #6B7280; }
    .status-kadaluarsa .sb-dot, .status-dibatalkan .sb-dot { background: #9CA3AF; }

    .timeline {
        margin: 8px 0 4px;
    }

    .tl-step {
        display: flex;
        gap: 12px;
        position: relative;
        padding-bottom: 20px;
    }

    .tl-step:last-child {
        padding-bottom: 0;
    }

    .tl-step::before {
        content: '';
        position: absolute;
        left: 13px;
        top: 28px;
        bottom: 0;
        width: 2px;
        background: #EEEEEE;
    }

    .tl-step:last-child::before {
        display: none;
    }

    .tl-step .tl-dot {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #F3F4F6;
        color: #9CA3AF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .tl-step.done .tl-dot {
        background: linear-gradient(135deg, #10B981, #34D399);
        color: #fff;
    }

    .tl-step.active .tl-dot {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 0 0 4px rgba(255, 79, 135, 0.15);
    }

    .tl-step .tl-info .tl-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
    }

    .tl-step .tl-info .tl-desc {
        font-size: 11.5px;
        color: var(--gray);
        margin-top: 1px;
    }

    .tl-step:not(.done):not(.active) .tl-name {
        color: #9CA3AF;
    }

    .dt-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px dashed #F0F0F0;
        font-size: 13px;
    }

    .dt-row:last-child {
        border-bottom: none;
    }

    .dt-row .dt-label {
        color: var(--gray);
    }

    .dt-row .dt-value {
        font-weight: 600;
        color: var(--dark);
        text-align: right;
    }

    .dt-row .dt-value.total {
        font-size: 16px;
        font-weight: 800;
        color: var(--primary);
    }

    .dt-item {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px dashed #F0F0F0;
    }

    .dt-item .dti-info .dti-nama {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
    }

    .dt-item .dti-info .dti-meta {
        font-size: 11.5px;
        color: var(--gray);
        margin-top: 2px;
    }

    .dt-item .dti-harga {
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
        white-space: nowrap;
    }

    .pay-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 600;
    }

    .pay-menunggu { background: #FEF3C7; color: #B45309; }
    .pay-dibayar { background: #D1FAE5; color: #059669; }
    .pay-gagal { background: #FEE2E2; color: #B91C1C; }
    .pay-kadaluarsa, .pay-dibatalkan { background: #F3F4F6; color: #6B7280; }

    .kode-box {
        background: #FFF9FB;
        border: 1.5px dashed #F3C6D3;
        border-radius: 14px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: 8px;
    }

    .kode-box .kb-label {
        font-size: 10.5px;
        font-weight: 600;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .kode-box .kb-value {
        font-size: 16px;
        font-weight: 800;
        color: var(--primary);
        letter-spacing: 1px;
    }

    .kode-box .kb-copy {
        background: none;
        border: none;
        color: var(--primary);
        cursor: pointer;
        font-size: 14px;
    }

    .btn-pay-lanjut {
        width: 100%;
        padding: 13px;
        border: none;
        border-radius: 14px;
        background: linear-gradient(135deg, #10B981, #34D399);
        color: #fff;
        font-size: 13.5px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-pay-lanjut:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.4);
    }

    .btn-batal {
        width: 100%;
        padding: 13px;
        border-radius: 14px;
        border: 1.5px solid #FECACA;
        background: #fff;
        color: #DC2626;
        font-size: 13px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        margin-top: 10px;
        transition: all 0.2s ease;
    }

    .btn-batal:hover {
        background: #FEF2F2;
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
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Detail Pesanan</h3>
                                <p>{{ $transaksi->no_invoice }}</p>
                            </div>
                        </div>
                        <a href="{{ route('pelanggan.pesanan.index') }}" class="btn-back">
                            <i class="fa-solid fa-arrow-left"></i> Semua Pesanan
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

                @php
$badgeClass = [
                        'Menunggu Pembayaran' => 'status-menunggu',
                        'Sedang Diproses' => 'status-diproses',
                        'Lunas' => 'status-lunas',
                        'DP Dibayar' => 'status-dp',
                        'Gagal' => 'status-gagal',
                        'Kadaluarsa' => 'status-kadaluarsa',
                        'Dibatalkan' => 'status-dibatalkan',
                    ][$transaksi->status] ?? 'status-kadaluarsa';
                $payClass = [
                    'Menunggu' => 'pay-menunggu',
                    'Dibayar' => 'pay-dibayar',
                    'Gagal' => 'pay-gagal',
                    'Kadaluarsa' => 'pay-kadaluarsa',
                    'Dibatalkan' => 'pay-dibatalkan',
                ][$transaksi->pembayaran->status ?? 'Menunggu'] ?? 'pay-menunggu';
                @endphp

                <div class="detail-layout">
                    <div class="d-card">
                        <div class="status-hero">
                            <span class="status-badge {{ $badgeClass }}">
                                <span class="sb-dot"></span>
                                {{ $transaksi->status }}
                            </span>
                            <div class="sh-invoice"><i class="fa-solid fa-receipt"></i> {{ $transaksi->no_invoice }}</div>
                            <div class="sh-total">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</div>
                            <div class="sh-meta">Dibuat {{ \Carbon\Carbon::parse($transaksi->tanggal)->isoFormat('D MMM YYYY') }}</div>
                        </div>

                        <div class="d-body">
                            <div class="dc-subtitle" style="margin-bottom:12px;"><i class="fa-solid fa-route" style="color:var(--primary);"></i> Status Pesanan</div>
                            <div class="timeline">
                                @php
                                $tlStatus = $transaksi->status;
                                $tahap = [
                                    'Menunggu Pembayaran' => ['Menunggu Pembayaran', 'Selesaikan pembayaran Anda', 'pending'],
                                    'Menunggu Verifikasi' => ['Menunggu Verifikasi', 'Pembayaran sedang diverifikasi kasir', 'pending'],
                                    'Selesai' => ['Selesai', 'Pesanan telah diproses', 'pending'],
                                ];
                                if ($tlStatus === 'Lunas') {
                                    $tahap['Menunggu Pembayaran'][2] = 'done';
                                    $tahap['Menunggu Verifikasi'][2] = 'done';
                                    $tahap['Selesai'][2] = 'done';
                                } elseif ($tlStatus === 'DP Dibayar') {
                                    $tahap['Menunggu Pembayaran'][2] = 'done';
                                    $tahap['Menunggu Verifikasi'][2] = 'done';
                                } elseif ($tlStatus === 'Sedang Diproses') {
                                    $tahap['Menunggu Pembayaran'][2] = 'done';
                                    $tahap['Menunggu Verifikasi'][2] = 'active';
                                } elseif ($tlStatus === 'Menunggu Pembayaran') {
                                    $tahap['Menunggu Pembayaran'][2] = 'active';
                                }
                                @endphp

                                @if(in_array($tlStatus, ['Gagal', 'Kadaluarsa', 'Dibatalkan']))
                                <div class="tl-step active">
                                    <div class="tl-dot"><i class="fa-solid {{ $tlStatus === 'Gagal' ? 'fa-xmark' : ($tlStatus === 'Dibatalkan' ? 'fa-ban' : 'fa-hourglass-end') }}"></i></div>
                                    <div class="tl-info">
                                        <div class="tl-name">{{ $tlStatus }}</div>
                                        <div class="tl-desc">
                                            @if($tlStatus === 'Gagal')
                                            Pembayaran Anda ditolak oleh kasir. Silakan hubungi BeautyCare.
                                            @elseif($tlStatus === 'Kadaluarsa')
                                            Pesanan melewati batas waktu pembayaran. Anda bisa memperpanjang waktu atau membuat pesanan baru.
                                            @else
                                            Pesanan ini dibatalkan oleh Anda.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($tlStatus === 'Kadaluarsa')
                                <form action="{{ route('pelanggan.pembayaran.perpanjang', $transaksi->id_transaksi) }}" method="POST" style="margin-top:16px;">
                                    @csrf
                                    <button type="submit" class="btn-pay-lanjut">
                                        <i class="fa-solid fa-clock-rotate-left"></i> Lanjutkan Pembayaran
                                    </button>
                                </form>
                                @endif
                                @else
                                @foreach($tahap as $step)
                                <div class="tl-step {{ $step[2] }}">
                                    <div class="tl-dot"><i class="fa-solid {{ $step[2] === 'active' ? 'fa-spinner fa-spin' : 'fa-check' }}"></i></div>
                                    <div class="tl-info">
                                        <div class="tl-name">{{ $step[0] }}</div>
                                        <div class="tl-desc">{{ $step[1] }}</div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="d-body" style="border-top:1px solid var(--border);">
                            <div class="dc-subtitle" style="margin-bottom:8px;"><i class="fa-solid fa-box" style="color:var(--primary);"></i> Produk Dipesan</div>
                            @foreach($transaksi->detail as $d)
                            <div class="dt-item">
                                <div class="dti-info">
                                    <div class="dti-nama">{{ $d->nm_item }}</div>
                                    <div class="dti-meta">{{ $d->qty }} x Rp {{ number_format($d->harga, 0, ',', '.') }} {{ $d->diskon > 0 ? '&bull; Diskon Rp '.number_format($d->diskon,0,',','.').'' : '' }}</div>
                                </div>
                                <div class="dti-harga">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</div>
                            </div>
                            @endforeach

                            <div class="dt-row" style="margin-top:12px;">
                                <span class="dt-label">Subtotal</span>
                                <span class="dt-value">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="dt-row">
                                <span class="dt-label">Diskon</span>
                                <span class="dt-value" style="color:#059669;">- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</span>
                            </div>
                            <div class="dt-row">
                                <span class="dt-label">Total</span>
                                <span class="dt-value total">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-card">
                        <div class="dc-header">
                            <div class="dc-icon"><i class="fa-solid fa-wallet"></i></div>
                            <div>
                                <div class="dc-title">Informasi Pembayaran</div>
                                <div class="dc-subtitle">Detail metode dan status pembayaran</div>
                            </div>
                        </div>
                        <div class="d-body">
                            <div class="dt-row">
                                <span class="dt-label">Metode</span>
                                <span class="dt-value">{{ $transaksi->pembayaran->provider ?? $transaksi->metode_byr }}</span>
                            </div>
                            @if((float)($transaksi->saldo_terpakai ?? 0) > 0)
                            <div class="dt-row">
                                <span class="dt-label">Dibayar Saldo</span>
                                <span class="dt-value" style="color:#059669;">- Rp {{ number_format($transaksi->saldo_terpakai, 0, ',', '.') }}</span>
                            </div>
                            @php
                            $sisaMetodeKedua = (float)$transaksi->total - (float)$transaksi->saldo_terpakai;
                            $providerKedua = $transaksi->pembayaran->provider ?? $transaksi->metode_byr;
                            @endphp
                            @if($sisaMetodeKedua > 0)
                            <div class="dt-row">
                                <span class="dt-label">Dibayar {{ $providerKedua }}</span>
                                <span class="dt-value" style="color:var(--primary);">- Rp {{ number_format($sisaMetodeKedua, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @endif
                            <div class="dt-row">
                                <span class="dt-label">Status Pembayaran</span>
                                <span class="pay-status {{ $payClass }}">
                                    <i class="fa-regular fa-circle-check"></i>
                                    {{ $transaksi->pembayaran->status ?? 'Menunggu' }}
                                </span>
                            </div>
                            @if($transaksi->pembayaran && $transaksi->pembayaran->kode_pembayaran)
                            <div>
                                <div class="kb-label" style="font-size:10.5px;font-weight:600;color:var(--gray);text-transform:uppercase;letter-spacing:0.5px;margin-top:12px;">
                                    {{ $transaksi->pembayaran->metode === 'Transfer' ? 'Nomor Virtual Account' : ($transaksi->pembayaran->metode === 'QRIS' ? 'Kode QRIS' : 'Kode Referensi') }}
                                </div>
                                <div class="kode-box">
                                    <span class="kb-value">{{ $transaksi->pembayaran->kode_pembayaran }}</span>
                                    <button class="kb-copy" onclick="salinKode(this, '{{ $transaksi->pembayaran->kode_pembayaran }}')">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            @endif
                            <div class="dt-row">
                                <span class="dt-label">Batas Bayar</span>
                                <span class="dt-value">{{ \Carbon\Carbon::parse($transaksi->pembayaran->expires_at)->format('d M Y H:i') }}</span>
                            </div>
                            @if($transaksi->pembayaran && $transaksi->pembayaran->paid_at)
                            <div class="dt-row">
                                <span class="dt-label">Dibayar Pada</span>
                                <span class="dt-value">{{ \Carbon\Carbon::parse($transaksi->pembayaran->paid_at)->format('d M Y H:i') }}</span>
                            </div>
                            @endif
                            @if($transaksi->pembayaran && $transaksi->pembayaran->no_referensi)
                            <div class="dt-row">
                                <span class="dt-label">No. Referensi</span>
                                <span class="dt-value">{{ $transaksi->pembayaran->no_referensi }}</span>
                            </div>
                            @endif

                            @if($transaksi->status === 'Menunggu Pembayaran')
                            <div style="margin-top:16px;">
                                <a href="{{ route('pelanggan.pembayaran.show', $transaksi->id_transaksi) }}" class="btn-pay-lanjut">
                                    <i class="fa-solid fa-credit-card"></i> Lanjutkan Pembayaran
                                </a>
                                <form action="{{ route('pelanggan.pembayaran.batal', $transaksi->id_transaksi) }}" method="POST" style="margin-top:10px;">
                                    @csrf
                                    <button type="submit" class="btn-batal" data-confirm-title="Batalkan Pesanan" data-confirm-body="Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan." data-confirm-icon="fa-circle-xmark" data-confirm-type="danger" data-confirm-yes="Ya, Batalkan">
                                        <i class="fa-solid fa-xmark"></i> Batalkan Pesanan
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    function salinKode(btn, kode) {
        navigator.clipboard.writeText(kode).then(function() {
            btn.innerHTML = '<i class="fa-solid fa-check"></i>';
            setTimeout(function() { btn.innerHTML = '<i class="fa-regular fa-copy"></i>'; }, 1500);
        });
    }

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
