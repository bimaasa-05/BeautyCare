<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Membership - BeautyCare</title>
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

    .page-header-premium::after {
        content: '';
        position: absolute;
        bottom: -40px;
        left: 30%;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 79, 135, 0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .page-header-premium .ph-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
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

    .member-status-card {
        background: linear-gradient(135deg, #FF4F87 0%, #FF7BA6 50%, #FF9CB8 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(255, 79, 135, 0.25);
    }

    .member-status-card .ms-deco {
        position: absolute;
        pointer-events: none;
    }

    .member-status-card .ms-deco:nth-child(1) {
        width: 250px; height: 250px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.1);
        top: -100px; right: -50px;
    }

    .member-status-card .ms-deco:nth-child(2) {
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        bottom: -40px; left: 30%;
    }

    .member-status-card .ms-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .member-status-card .ms-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .member-status-card .ms-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 28px;
        flex-shrink: 0;
    }

    .member-status-card .ms-text h3 {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }

    .member-status-card .ms-text p {
        font-size: 13px;
        color: rgba(255,255,255,0.8);
        margin: 4px 0 0;
    }

    .member-status-card .ms-countdown {
        font-weight: 700;
        color: #fff;
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 100px;
        padding: 2px 10px;
        display: inline-block;
        margin-left: 4px;
        font-variant-numeric: tabular-nums;
    }

    .member-status-card .ms-countdown.warning {
        background: rgba(251,191,36,0.25);
        border-color: rgba(251,191,36,0.6);
        color: #FDE68A;
        animation: msCountdownPulse 1s ease-in-out infinite;
    }

    @keyframes msCountdownPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(251,191,36,0.35); }
        50% { box-shadow: 0 0 0 6px rgba(251,191,36,0); }
    }

    .member-status-card .ms-level {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 20px;
        border-radius: 100px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .member-status-card .ms-level i {
        font-size: 16px;
    }

    .stats-membership {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-member-card {
        background: var(--white);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-member-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px -8px rgba(255, 79, 135, 0.12);
    }

    .stat-member-card .sm-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin: 0 auto 12px;
    }

    .stat-member-card .sm-icon.transaksi { background: #DBEAFE; color: #2563EB; }
    .stat-member-card .sm-icon.belanja { background: #FEF3C7; color: #D97706; }
    .stat-member-card .sm-icon.diskon { background: #D1FAE5; color: #059669; }
    .stat-member-card .sm-icon.tier { background: #F3E8FF; color: #9333EA; }

    .stat-member-card .sm-value {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-member-card .sm-label {
        font-size: 12px;
        color: var(--gray);
        font-weight: 500;
    }

    .progres-card {
        background: var(--white);
        border-radius: 20px;
        padding: 24px 28px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        margin-bottom: 24px;
    }

    .progres-card .pg-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .progres-card .pg-head h4 {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .progres-card .pg-head .pg-target {
        font-size: 12px;
        color: var(--gray);
        background: var(--hover);
        padding: 6px 14px;
        border-radius: 100px;
        font-weight: 600;
    }

    .progres-card .pg-row {
        margin-bottom: 16px;
    }

    .progres-card .pg-row:last-child {
        margin-bottom: 0;
    }

    .progres-card .pg-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
        color: var(--gray);
        margin-bottom: 6px;
        font-weight: 500;
    }

    .progres-card .pg-label strong {
        color: var(--dark);
    }

    .progres-card .pg-bar {
        height: 10px;
        border-radius: 100px;
        background: var(--hover);
        overflow: hidden;
    }

    .progres-card .pg-bar .pg-fill {
        height: 100%;
        border-radius: 100px;
        background: linear-gradient(90deg, var(--primary), #FF7BA6);
        transition: width 0.8s ease;
        width: 0;
    }

    .progres-card .pg-bar .pg-fill.full {
        background: linear-gradient(90deg, #22C55E, #4ADE80);
    }

    .progres-card .pg-info {
        font-size: 12px;
        color: var(--primary);
        font-weight: 600;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .member-tier-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .member-tier-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .member-tier-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px -8px rgba(255, 79, 135, 0.15);
    }

    .member-tier-card .mt-banner {
        height: 120px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .member-tier-card .mt-banner.silver {
        background: linear-gradient(135deg, #94A3B8, #CBD5E1);
    }

    .member-tier-card .mt-banner.gold {
        background: linear-gradient(135deg, #F59E0B, #FBBF24);
    }

    .member-tier-card .mt-banner.platinum {
        background: linear-gradient(135deg, #6366F1, #818CF8);
    }

    .member-tier-card .mt-banner .mt-icon-big {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 24px;
    }

    .member-tier-card .mt-banner .mt-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        padding: 4px 12px;
        border-radius: 100px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .member-tier-card .mt-banner .mt-badge.active-tier {
        background: #D1FAE5;
        border-color: #A7F3D0;
        color: #059669;
    }

    .member-tier-card .mt-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .member-tier-card .mt-body .mt-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .member-tier-card .mt-body .mt-subtitle {
        font-size: 12px;
        color: var(--gray);
        margin-bottom: 14px;
    }

    .member-tier-card .mt-body .mt-benefits {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }

    .member-tier-card .mt-body .mt-benefits .mt-benefit-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: var(--dark);
    }

    .member-tier-card .mt-body .mt-benefits .mt-benefit-item i {
        width: 18px;
        font-size: 13px;
        color: var(--primary);
        flex-shrink: 0;
    }

    .member-tier-card .mt-body .mt-benefits .mt-benefit-item i.fa-xmark {
        color: #ccc;
    }

    .member-tier-card .mt-body .mt-benefits .mt-benefit-item.disabled {
        color: #ccc;
    }

    .member-tier-card .mt-body .mt-syarat {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px dashed var(--border);
    }

    .member-tier-card .mt-body .mt-syarat-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 12px;
        font-weight: 500;
        color: var(--dark);
    }

    .member-tier-card .mt-body .mt-syarat-row i {
        color: var(--primary);
        width: 16px;
        font-size: 12px;
        flex-shrink: 0;
    }

    .member-tier-card .mt-body .mt-syarat-status {
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 100px;
        white-space: nowrap;
    }

    .member-tier-card .mt-body .mt-syarat-status.ok {
        background: #D1FAE5;
        color: #059669;
    }

    .member-tier-card .mt-body .mt-syarat-status.kurang {
        background: #FEF3C7;
        color: #D97706;
    }

    .member-tier-card .mt-body .mt-validity {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 600;
        color: var(--gray);
        margin-top: 12px;
    }

    .member-tier-card .mt-body .mt-validity i {
        color: var(--primary);
        width: 18px;
        font-size: 13px;
        flex-shrink: 0;
    }

    .mt-btn {
        display: block;
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        border: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
        text-align: center;
        text-decoration: none;
        margin-top: auto;
    }

    .mt-btn.primary {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.2);
    }

    .mt-btn.primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
    }

    .mt-btn.current {
        background: #D1FAE5;
        color: #059669;
        box-shadow: none;
        cursor: default;
    }

    .mt-btn.outline {
        background: transparent;
        border: 1.5px solid var(--border);
        color: var(--gray);
    }

    .mt-btn.outline:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: var(--hover);
    }

    .benefit-section-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .benefit-section-title i {
        color: var(--primary);
    }

    .benefit-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .benefit-card {
        background: var(--white);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        display: flex;
        align-items: flex-start;
        gap: 14px;
        transition: all 0.3s ease;
    }

    .benefit-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px -8px rgba(255, 79, 135, 0.1);
    }

    .benefit-card .bc-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .benefit-card .bc-icon.diskon { background: #FEF3C7; color: #D97706; }
    .benefit-card .bc-icon.prioritas { background: #DBEAFE; color: #2563EB; }
    .benefit-card .bc-icon.event { background: #F3E8FF; color: #9333EA; }
    .benefit-card .bc-icon.kado { background: #FCE7F3; color: #DB2777; }
    .benefit-card .bc-icon.produk { background: #FEF3C7; color: #D97706; }
    .benefit-card .bc-icon.gratis { background: #E0F2FE; color: #0284C7; }

    .benefit-card .bc-text h4 {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        margin: 0 0 3px;
    }

    .benefit-card .bc-text p {
        font-size: 12px;
        color: var(--gray);
        line-height: 1.5;
        margin: 0;
    }

    @media (max-width: 768px) {
        .member-tier-grid {
            grid-template-columns: 1fr;
        }

        .member-status-card .ms-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .benefit-grid {
            grid-template-columns: 1fr;
        }

        .page-header-premium { padding: 22px 20px; }
        .member-status-card { padding: 22px 20px; }
    }

    @media (max-width: 576px) {
        .page-header-premium .ph-text h3 { font-size: 17px; }
        .page-header-premium .ph-icon-wrap { width: 44px; height: 44px; border-radius: 13px; font-size: 18px; }
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
                                <i class="fa-solid fa-crown"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Membership</h3>
                                <p>Nikmati berbagai keuntungan eksklusif sebagai member BeautyCare</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="member-status-card">
                    <div class="ms-deco"></div>
                    <div class="ms-deco"></div>
                    <div class="ms-content">
                        <div class="ms-left">
                            <div class="ms-icon">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="ms-text">
                                <h3>Status Keanggotaan</h3>
                                @if($memberSaatIni)
                                    <p>
                                        @if($masaAkhir)
                                            Berlaku s.d. {{ $masaAkhir->isoFormat('D MMM YYYY') }} &middot; Sisa <span id="masaBerlakuCountdown" class="ms-countdown">{{ $sisaHariMember }} hari</span>
                                        @else
                                            Anda saat ini terdaftar sebagai member aktif BeautyCare
                                        @endif
                                    </p>
                                @elseif($memberKadaluarsa)
                                    <p>Membership {{ $memberKadaluarsa->tingkat }} Anda telah berakhir{{ $masaAkhir ? ' pada ' . $masaAkhir->isoFormat('D MMM YYYY') : '' }}. Silakan perpanjang keanggotaan atau upgrade ke level yang lebih tinggi!</p>
                                @else
                                    <p>Anda belum terdaftar sebagai member BeautyCare</p>
                                @endif
                            </div>
                        </div>
                        <div class="ms-level">
                            @if($memberSaatIni)
                            <i class="fa-solid fa-crown"></i>
                            {{ $memberSaatIni->tingkat }} Member
                            @elseif($memberKadaluarsa)
                            <i class="fa-solid fa-clock"></i>
                            Expired
                            @else
                            <i class="fa-solid fa-user"></i>
                            Non Member
                            @endif
                        </div>
                    </div>
                </div>

                <div class="stats-membership">
                    <div class="stat-member-card">
                        <div class="sm-icon belanja">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <div class="sm-value">{{ formatRupiahSingkat($totalBelanja) }}</div>
                        <div class="sm-label">Total Belanja</div>
                    </div>
                    <div class="stat-member-card">
                        <div class="sm-icon transaksi">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div class="sm-value">{{ $totalTransaksi }}</div>
                        <div class="sm-label">Total Transaksi</div>
                    </div>
                    <div class="stat-member-card">
                        <div class="sm-icon diskon">
                            <i class="fa-solid fa-percent"></i>
                        </div>
                        <div class="sm-value">{{ (int)$diskonMember }}%</div>
                        <div class="sm-label">Diskon Member</div>
                    </div>
                    <div class="stat-member-card">
                        <div class="sm-icon tier">
                            <i class="fa-solid fa-arrow-up"></i>
                        </div>
                        <div class="sm-value">{{ $nextTier->tingkat ?? ($memberSaatIni && $memberSaatIni->tingkat == 'Platinum' ? 'Max Tier' : '-') }}</div>
                        <div class="sm-label">Next Tier</div>
                    </div>
                </div>

                @if($memberKadaluarsa)
                <div class="progres-card">
                    <div class="pg-head">
                        <h4><i class="fa-solid fa-clock" style="color: var(--primary); margin-right: 8px;"></i>Keanggotaan Berakhir</h4>
                    </div>
                    <div class="pg-info" style="border-top: none; padding-top: 0; margin-top: 0;">
                        <i class="fa-solid fa-circle-info"></i>
                        Anda dapat <strong>memperpanjang</strong> level {{ $memberKadaluarsa->tingkat }} atau <strong>naik ke level berikutnya</strong> dengan memenuhi syaratnya. Keuntungan member tidak berlaku lagi sampai membership diaktifkan kembali.
                    </div>
                </div>
                @endif

                @if($nextTier || $isMaxTier)
                <div class="progres-card">
                    <div class="pg-head">
                        <h4><i class="fa-solid fa-chart-line" style="color: var(--primary); margin-right: 8px;"></i>Progres Menuju {{ $isMaxTier ? 'Level Tertinggi' : $nextTier->tingkat }}</h4>
                        @if(!$isMaxTier)
                        <span class="pg-target"><i class="fa-solid fa-trophy"></i> {{ $nextTier->tingkat }}</span>
                        @endif
                    </div>
                    <div class="pg-row">
                        <div class="pg-label">
                            <span>Total Belanja</span>
                            <span><strong>{{ formatRupiahSingkat($totalBelanja) }}</strong> / {{ formatRupiahSingkat($targetBelanja) }}</span>
                        </div>
                        <div class="pg-bar">
                            <div class="pg-fill {{ $progressBelanja >= 100 ? 'full' : '' }}" data-width="{{ $progressBelanja }}"></div>
                        </div>
                    </div>
                    <div class="pg-row">
                        <div class="pg-label">
                            <span>Total Transaksi</span>
                            <span><strong>{{ $totalTransaksi }}</strong> / {{ $targetTransaksi }}</span>
                        </div>
                        <div class="pg-bar">
                            <div class="pg-fill {{ $progressTransaksi >= 100 ? 'full' : '' }}" data-width="{{ $progressTransaksi }}"></div>
                        </div>
                    </div>
                    @if(!$isMaxTier)
                    <div class="pg-info">
                        <i class="fa-solid fa-circle-info"></i>
                        Tinggal {{ formatRupiahSingkat($sisaBelanja) }} atau {{ $sisaTransaksi }} transaksi lagi untuk naik ke {{ $nextTier->tingkat }}!
                    </div>
                    @else
                    <div class="pg-info">
                        <i class="fa-solid fa-crown"></i>
                        Selamat! Anda sudah berada di level tertinggi membership.
                    </div>
                    @endif
                </div>
                @endif

                <div class="benefit-section-title">
                    <i class="fa-solid fa-layer-group"></i> Pilih Level Membership
                </div>

                <div class="member-tier-grid">
                    @php
                        $tierIcons = [
                            'Silver' => ['icon' => 'fa-solid fa-medal', 'banner' => 'silver'],
                            'Gold' => ['icon' => 'fa-solid fa-trophy', 'banner' => 'gold'],
                            'Platinum' => ['icon' => 'fa-solid fa-gem', 'banner' => 'platinum'],
                        ];
                        $tierSubtitles = [
                            'Silver' => 'Untuk pemula yang baru bergabung',
                            'Gold' => 'Untuk member setia dengan transaksi minimal 5x',
                            'Platinum' => 'Untuk member VIP dengan transaksi minimal 15x',
                        ];
                    @endphp

                    @foreach ($semuaMember as $member)
                        @php
                            $icon = $tierIcons[$member->tingkat] ?? ['icon' => 'fa-solid fa-medal', 'banner' => 'silver'];
                            $subtitle = $tierSubtitles[$member->tingkat] ?? '';
                            $benefits = [
                                ['text' => 'Diskon ' . (float) $member->diskon . '% semua layanan', 'active' => true],
                                ['text' => 'Gratis konsultasi ' . (int) $member->jml_konsultasi . 'x/bulan', 'active' => (int) $member->jml_konsultasi > 0],
                                ['text' => 'Prioritas booking', 'active' => (bool) $member->prioritas_booking],
                                ['text' => 'Undangan event eksklusif', 'active' => (bool) $member->undangan_event],
                            ];
                            $isCurrent = $memberSaatIni && $memberSaatIni->id_member === $member->id_member;
                            $isOwnTier = $isCurrent || ($memberKadaluarsa && $memberKadaluarsa->id_member === $member->id_member);
                            $meetsTransaksi = $totalTransaksi >= $member->min_transaksi;
                            $meetsBelanja = $totalBelanja >= $member->min_pembelian;
                            $meetsSyarat = $meetsTransaksi && $meetsBelanja;
                            $kurangTransaksi = max(0, $member->min_transaksi - $totalTransaksi);
                            $kurangBelanja = max(0, $member->min_pembelian - $totalBelanja);
                            $canUpgrade = !$isCurrent && !$memberSaatIni;
                            $showSyarat = !$isOwnTier && !$memberSaatIni;
                            if ($memberSaatIni) {
                                $levels = ['Silver', 'Gold', 'Platinum'];
                                $currentIdx = array_search($memberSaatIni->tingkat, $levels);
                                $thisIdx = array_search($member->tingkat, $levels);
                                $canUpgrade = $thisIdx > $currentIdx;
                                $showSyarat = !$isCurrent && $thisIdx > $currentIdx;
                            }
                        @endphp
                        <div class="member-tier-card">
                            <div class="mt-banner {{ $icon['banner'] }}">
                                <div class="mt-icon-big">
                                    <i class="{{ $icon['icon'] }}"></i>
                                </div>
                                @if ($isCurrent)
                                <span class="mt-badge active-tier">
                                    <i class="fa-regular fa-circle-check"></i> Aktif
                                </span>
                                @endif
                            </div>
                            <div class="mt-body">
                                <div class="mt-title">{{ $member->tingkat }}</div>
                                <div class="mt-subtitle">{{ $subtitle }}</div>
                                <div class="mt-benefits">
                                    @foreach ($benefits as $benefit)
                                    <div class="mt-benefit-item {{ $benefit['active'] ? '' : 'disabled' }}">
                                        @if ($benefit['active'])
                                        <i class="fa-regular fa-circle-check"></i>
                                        @else
                                        <i class="fa-regular fa-circle-xmark"></i>
                                        @endif
                                        {{ $benefit['text'] }}
                                    </div>
                                    @endforeach
                                </div>
                                <div class="mt-syarat">
                                    <div class="mt-syarat-row">
                                        <span><i class="fa-solid fa-bag-shopping"></i> Min. {{ $member->min_transaksi }}x Pembelian Produk</span>
                                        @if($showSyarat)
                                        <span class="mt-syarat-status {{ $meetsTransaksi ? 'ok' : 'kurang' }}">{{ $meetsTransaksi ? 'Terpenuhi' : 'Kurang ' . $kurangTransaksi . 'x' }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-syarat-row">
                                        <span><i class="fa-solid fa-wallet"></i> Min. Belanja {{ formatRupiahSingkat($member->min_pembelian) }}</span>
                                        @if($showSyarat)
                                        <span class="mt-syarat-status {{ $meetsBelanja ? 'ok' : 'kurang' }}">{{ $meetsBelanja ? 'Terpenuhi' : 'Kurang ' . formatRupiahSingkat($kurangBelanja) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-validity">
                                    <i class="fa-regular fa-clock"></i> Masa Berlaku {{ $member->masa_berlaku }} hari
                                </div>
                                <div class="mt-validity">
                                    <i class="fa-solid fa-tags"></i> Harga Upgrade {{ formatRupiahSingkat($member->harga) }}
                                </div>
                                @if ($isOwnTier)
                                <a href="{{ route('pelanggan.pembayaran.membership', ['beli_membership' => $member->id_member]) }}" class="mt-btn primary" style="display:block;">
                                    <i class="fa-regular fa-clock"></i> {{ $isCurrent ? 'Perpanjang Masa Aktif' : 'Perpanjang ke ' . $member->tingkat }}
                                </a>
                                @elseif ($meetsSyarat && $canUpgrade)
                                <a href="{{ route('pelanggan.pembayaran.membership', ['beli_membership' => $member->id_member]) }}" class="mt-btn primary" style="display:block;">
                                    <i class="fa-solid fa-arrow-up"></i> Upgrade Sekarang
                                </a>
                                @elseif ($canUpgrade)
                                <button class="mt-btn outline" disabled style="opacity:0.5;cursor:not-allowed;">
                                    <i class="fa-solid fa-lock"></i> Belum Memenuhi Syarat
                                </button>
                                @else
                                <button class="mt-btn outline" disabled style="opacity:0.5;cursor:not-allowed;">
                                    <i class="fa-solid fa-lock"></i> Tidak Tersedia
                                </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="benefit-section-title">
                    <i class="fa-solid fa-gift"></i> Keuntungan Membership
                </div>

                <div class="benefit-grid">
                    <div class="benefit-card">
                        <div class="bc-icon diskon">
                            <i class="fa-solid fa-tags"></i>
                        </div>
                        <div class="bc-text">
                            <h4>Diskon Spesial</h4>
                            <p>Dapatkan diskon khusus untuk semua layanan dan produk BeautyCare sesuai level membership Anda.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="bc-icon prioritas">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div class="bc-text">
                            <h4>Prioritas Booking</h4>
                            <p>Member Gold dan Platinum mendapatkan prioritas dalam pemesanan jadwal treatment.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="bc-icon produk">
                            <i class="fa-solid fa-cube"></i>
                        </div>
                        <div class="bc-text">
                            <h4>Diskon Produk</h4>
                            <p>Nikmati potongan harga khusus untuk pembelian produk kecantikan pilihan di BeautyCare.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="bc-icon event">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div class="bc-text">
                            <h4>Event Eksklusif</h4>
                            <p>Nikmati undangan ke event-event spesial seperti beauty class dan product launch.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="bc-icon kado">
                            <i class="fa-solid fa-gift"></i>
                        </div>
                        <div class="bc-text">
                            <h4>Hadiah Ulang Tahun</h4>
                            <p>Dapatkan hadiah spesial di bulan ulang tahun Anda sebagai bentuk apresiasi dari BeautyCare.</p>
                        </div>
                    </div>
                    <div class="benefit-card">
                        <div class="bc-icon gratis">
                            <i class="fa-solid fa-spa"></i>
                        </div>
                        <div class="bc-text">
                            <h4>Treatment Gratis</h4>
                            <p>Nikmati treatment gratis secara berkala sesuai dengan ketentuan level membership Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    const now = new Date();
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    const dateEl = document.getElementById('currentDate');
    if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);

    document.querySelectorAll('.pg-fill').forEach(function(fill) {
        var width = parseInt(fill.getAttribute('data-width')) || 0;
        setTimeout(function() { fill.style.width = width + '%'; }, 200);
    });

    var sisaDetik = {{ $sisaDetikMember }};
    var countdownEl = document.getElementById('masaBerlakuCountdown');
    if (countdownEl && sisaDetik > 0) {
        var batasWaspada = 10 * 60;
        var endAt = Date.now() + sisaDetik * 1000;

        function formatCountdown(sisa) {
            var hari = Math.floor(sisa / 86400);
            var jam = Math.floor(sisa % 86400 / 3600);
            var menit = Math.floor(sisa % 3600 / 60);
            var detik = sisa % 60;

            if (hari >= 1) return hari + ' hari ' + jam + ' jam';
            if (sisa >= batasWaspada) return jam + ' jam ' + menit + ' menit';
            return menit + ' menit ' + detik + ' detik';
        }

        function updateCountdown() {
            var sisa = Math.max(0, Math.floor((endAt - Date.now()) / 1000));

            if (sisa <= 0) {
                clearInterval(countdownInterval);
                location.reload();
                return;
            }

            countdownEl.textContent = formatCountdown(sisa);

            if (sisa < batasWaspada) {
                countdownEl.classList.add('warning');
            } else {
                countdownEl.classList.remove('warning');
            }
        }

        updateCountdown();
        var countdownInterval = setInterval(updateCountdown, 1000);
    }
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
