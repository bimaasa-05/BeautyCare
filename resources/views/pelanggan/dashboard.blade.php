<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
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

    .table-widget {
        display: flex;
        flex-direction: column;
    }

    .table-widget .table-scroll {
        flex: 1;
        max-height: 242px;
        overflow-y: auto;
        border-radius: 0 0 var(--radius-sm) var(--radius-sm);
    }

    .rating-col .table-widget .table-scroll {
        max-height: 135px;
    }

    .table-widget .table-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .table-widget .table-scroll::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 10px;
    }

.

    .table-widget .table-scroll thead {
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .table-widget .table-scroll thead th {
        background: var(--white);
    }

    .table-widget .table-scroll thead th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 12px;
        right: 12px;
        height: 1px;
        background: var(--border);
    }

    .dashboard-bottom-row .list-widget {
        display: flex;
        flex-direction: column;
    }

    .dashboard-bottom-row .list-widget .content-scroll {
        flex: 1;
        overflow-y: auto;
        max-height: 176px;
    }

    .dashboard-bottom-row .list-widget .content-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .dashboard-bottom-row .list-widget .content-scroll::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 10px;
    }

    .dashboard-bottom-row .list-widget .content-scroll::-webkit-scrollbar-thumb:hover {
        background: #bbb;
    }

    .dashboard-bottom-row .list-widget .booking-list {
        flex: 1;
    }

    .dashboard-bottom-row .list-widget .stock-grid {
        flex: 1;
    }

    .dashboard-bottom-grid .list-widget {
        display: flex;
        flex-direction: column;
    }

    .dashboard-bottom-grid .list-widget .stock-grid {
        flex: 1;
        grid-auto-rows: 1fr;
    }

    .mb-progres {
        display: flex;
        flex-direction: column;
        gap: 12px;
        flex: 1;
    }

    .mb-progres .mb-tier-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }

    .mb-progres .mb-tier-name {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
        min-width: 0;
    }

    .mb-progres .mb-tier-name i {
        color: var(--primary);
    }

    .mb-progres .mb-tier-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 100px;
        background: #F3E8FF;
        color: #9333EA;
        white-space: nowrap;
    }

    .mb-progres .mb-tier-badge.max {
        background: #D1FAE5;
        color: #059669;
    }

    .mb-progres .mb-bar-label {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        color: var(--gray);
        font-weight: 500;
        margin-bottom: 5px;
    }

    .mb-progres .mb-bar-label strong {
        color: var(--dark);
    }

    .mb-progres .mb-bar {
        height: 8px;
        border-radius: 100px;
        background: var(--hover);
        overflow: hidden;
    }

    .mb-progres .mb-bar .mb-fill {
        height: 100%;
        border-radius: 100px;
        background: linear-gradient(90deg, var(--primary), #FF7BA6);
        transition: width 0.8s ease;
        width: 0;
    }

    .mb-progres .mb-bar .mb-fill.full {
        background: linear-gradient(90deg, #22C55E, #4ADE80);
    }

    /* ─── Bar Grafik Mini (Layanan Favorit) ─── */
    #miniChartFavorit {
        align-items: flex-end;
        justify-content: flex-start;
        gap: 8px;
    }

    #miniChartFavorit .mc-col {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }

    #miniChartFavorit .bar {
        flex: 0 0 auto;
        width: 100%;
        max-width: 34px;
        min-width: 14px;
        height: 0;
        border-radius: 6px 6px 0 0;
        display: block;
        transition: height 0.6s ease;
    }

    #miniChartFavorit .bar.bar-primary { background: linear-gradient(180deg, #FF4F87, #FF7BA6); }
    #miniChartFavorit .bar.bar-success { background: linear-gradient(180deg, #22C55E, #4ADE80); }
    #miniChartFavorit .bar.bar-info    { background: linear-gradient(180deg, #3B82F6, #60A5FA); }
    #miniChartFavorit .bar.bar-warning { background: linear-gradient(180deg, #F59E0B, #FBBF24); }

    #miniChartFavorit .mc-label {
        width: 100%;
        font-size: 11px;
        color: var(--gray);
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 768px) {
        .sidebar-toggle {
            display: flex;
            align-items: center;
        }

        .table-widget .table-scroll {
            overflow-x: auto;
        }

        .dashboard-bottom-row .list-widget {
            min-width: 0;
        }
    }

    /* ─── Stats Premium (sama dengan booking index) ─── */
    .stats-row .stat-card {
        position: relative;
        overflow: hidden;
    }

    .stats-row .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        border-radius: 0 0 20px 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stats-row .stat-card:hover::after {
        opacity: 1;
    }

    .stats-row .stat-card:nth-child(1)::after { background: linear-gradient(90deg, var(--primary), #FF7BA6); }
    .stats-row .stat-card:nth-child(2)::after { background: linear-gradient(90deg, #F59E0B, #FBBF24); }
    .stats-row .stat-card:nth-child(3)::after { background: linear-gradient(90deg, #3B82F6, #60A5FA); }
    .stats-row .stat-card:nth-child(4)::after { background: linear-gradient(90deg, #22C55E, #4ADE80); }
    .stats-row .stat-card:nth-child(5)::after { background: linear-gradient(90deg, #EF4444, #F87171); }

    /* ─── Chart body penuh (menyesuaikan tinggi kartu di samping) ─── */
    .chart-card .chart-body.bc-chart-body {
        display: flex;
        flex-direction: column;
    }

    /* ─── Period Dropdown (seperti popup tanggal di booking/create) ─── */
    .period-trigger {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1.5px solid #E5E7EB;
        border-radius: 10px;
        padding: 8px 14px;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
    }

    .period-trigger:hover {
        border-color: #FFB6CD;
        background: #FFF9FB;
    }

    .period-trigger > i:first-child {
        color: var(--primary);
    }

    .period-trigger .period-arrow {
        font-size: 11px;
        color: var(--gray);
        transition: transform 0.3s ease;
    }

    .period-trigger.open .period-arrow {
        transform: rotate(180deg);
    }

    .period-popup {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        width: 280px;
        background: #fff;
        border-radius: 16px;
        border: 1px solid #FFD6E6;
        box-shadow: 0 12px 40px rgba(255, 79, 135, 0.15);
        z-index: 120;
        padding: 20px;
        font-family: 'Poppins', sans-serif;
        transform-origin: top center;
        animation: curtainUnroll 0.45s cubic-bezier(0.22, 0.61, 0.36, 1);
    }

    .period-popup.open {
        display: block;
    }

    .period-popup.open-up {
        top: auto;
        bottom: calc(100% + 6px);
        transform-origin: bottom center;
        animation-name: curtainUnrollUp;
    }

    @keyframes curtainUnroll {
        0%   { transform: scaleY(0); opacity: 0.2; }
        55%  { transform: scaleY(1.03); opacity: 1; }
        100% { transform: scaleY(1); opacity: 1; }
    }

    @keyframes curtainUnrollUp {
        0%   { transform: scaleY(0); opacity: 0.2; }
        55%  { transform: scaleY(1.03); opacity: 1; }
        100% { transform: scaleY(1); opacity: 1; }
    }

    .period-popup .pp-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 14px;
    }

    .period-popup .pp-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #FFE3EE;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .period-popup .pp-header h4 {
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    #periodOptions {
        display: grid;
        gap: 6px;
        margin-bottom: 14px;
    }

    .pp-option {
        display: flex;
        flex-direction: column;
        gap: 2px;
        text-align: left;
        width: 100%;
        border: 1.5px solid #F1F2F6;
        background: #fff;
        border-radius: 12px;
        padding: 10px 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
    }

    .pp-option:hover {
        background: #FFF9FB;
        border-color: #FFB6CD;
    }

    .pp-option .po-title {
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .pp-option .po-title i {
        font-size: 11px;
        color: #fff;
        opacity: 0;
        transform: scale(0.5);
        transition: all 0.2s ease;
    }

    .pp-option .po-sub {
        font-size: 11px;
        color: var(--gray);
        font-weight: 500;
    }

    .pp-option.selected {
        border-color: var(--primary);
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
    }

    .pp-option.selected .po-title,
    .pp-option.selected .po-sub {
        color: #fff;
    }

    .pp-option.selected .po-title i {
        opacity: 1;
        transform: scale(1);
    }

    .pp-footer {
        display: flex;
        gap: 8px;
    }

    .pp-today,
    .pp-oke {
        flex: 1;
        border: none;
        border-radius: 10px;
        padding: 9px 0;
        font-family: 'Poppins', sans-serif;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .pp-today {
        background: #F1F2F6;
        color: var(--gray);
    }

    .pp-today:hover {
        background: #E5E7EB;
        color: var(--dark);
    }

    .pp-oke {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.3);
    }

    .pp-oke:hover {
        box-shadow: 0 6px 16px rgba(255, 79, 135, 0.4);
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .period-popup {
            left: 0;
            right: auto;
        }
    }

    @media (max-width: 480px) {
        .period-popup {
            position: fixed;
            left: 50%;
            top: 50%;
            right: auto;
            bottom: auto;
            transform: translate(-50%, -50%);
            width: calc(100vw - 40px);
            max-width: 320px;
            max-height: calc(100vh - 32px);
            overflow-y: auto;
            animation: curtainUnrollMobile 0.45s cubic-bezier(0.22, 0.61, 0.36, 1);
        }
    }

    @keyframes curtainUnrollMobile {
        0%   { transform: translate(-50%, -50%) scaleY(0); opacity: 0.2; }
        55%  { transform: translate(-50%, -50%) scaleY(1.03); opacity: 1; }
        100% { transform: translate(-50%, -50%) scaleY(1); opacity: 1; }
    }

    .dash-rating-stars {
        color: #F59E0B;
        font-size: 13px;
        letter-spacing: 1px;
        white-space: nowrap;
    }

    .dash-rate-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 600;
        color: var(--primary);
        background: #FFF5F8;
        border: 1.5px solid var(--primary);
        border-radius: 12px;
        padding: 7px 14px;
        text-decoration: none;
        transition: all .2s ease;
        cursor: pointer;
        font-family: inherit;
    }

    .dash-rate-btn:hover {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        border-color: var(--primary);
        color: #FFF;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.25);
    }

    .dash-rate-btn.primary {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        border-color: var(--primary);
        color: #FFF;
        box-shadow: 0 4px 10px rgba(255, 79, 135, 0.2);
    }

    .dash-rate-btn.primary:hover {
        background: var(--secondary);
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.3);
    }

    .dash-rate-btn.danger {
        background: #FEF2F2;
        border-color: #FECACA;
        color: #DC2626;
    }

    .dash-rate-btn.danger:hover {
        border-color: #DC2626;
        background: #DC2626;
        color: #FFF;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
    }
    </style>
</head>

<body>
    <!-- Page Loader -->
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Stats Row - Pelanggan: Fokus Personal -->
                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                            </div>
                            <span class="stat-change up">+{{ $totalBooking }}</span>
                        </div>
                        <div class="stat-value">{{ $totalBooking }}</div>
                        <div class="stat-label">Total Booking Saya</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon success">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                            </div>
                            <span class="stat-change up">+{{ $bookingAktif }}</span>
                        </div>
                        <div class="stat-value">{{ $bookingAktif }}</div>
                        <div class="stat-label">Booking Aktif</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                                </svg>
                            </div>
                            <span class="stat-change up">+{{ $riwayatTreatment }}</span>
                        </div>
                        <div class="stat-value">{{ $riwayatTreatment }}</div>
                        <div class="stat-label">Riwayat Treatment</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                </svg>
                            </div>
                            <span class="stat-change up">{{ $memberTingkat ?? '—' }}</span>
                        </div>
                        <div class="stat-value">{{ $memberTingkat ?? 'Tidak Ada' }}</div>
                        <div class="stat-label">Pangkat Membership</div>
                        @if($memberTingkat && $memberList->isNotEmpty() && $memberTingkat !== $memberList->last()->tingkat)
                        <a href="{{ route('pelanggan.membership') }}" id="btnTingkatkan" style="display:inline-flex;align-items:center;gap:6px;margin-top:8px;padding:4px 14px;border-radius:8px;border:1.5px solid var(--primary);color:var(--primary);font-size:11px;font-weight:600;text-decoration:none;transition:all 0.2s ease;cursor:pointer;">Tingkatkan <i class="fa-solid fa-arrow-right" style="font-size:10px;transition:transform 0.2s ease;"></i></a>
                        @endif
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </div>
                            <span class="stat-change up">+{{ $kunjunganBulanIni }}</span>
                        </div>
                        <div class="stat-value">{{ $kunjunganBulanIni }}</div>
                        <div class="stat-label">Kunjungan Bulan Ini</div>
                    </div>
                </div>

                <!-- Dashboard Grid: Charts -->
                <div class="dashboard-grid">
                    <!-- Grafik Riwayat Booking -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Grafik Riwayat Booking</h3>
                            <div class="chart-actions">
                                <div style="position:relative;" id="periodWrap">
                                    <button type="button" class="period-trigger" id="periodTrigger">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        <span id="periodLabel">3 Bulan</span>
                                        <i class="fa-solid fa-chevron-down period-arrow"></i>
                                    </button>
                                    <div class="period-popup" id="periodPopup">
                                        <div class="pp-header">
                                            <span class="pp-icon"><i class="fa-solid fa-chart-line"></i></span>
                                            <h4>Periode Grafik</h4>
                                        </div>
                                        <div id="periodOptions"></div>
                                        <div class="pp-footer">
                                            <button type="button" class="pp-today" id="periodReset"><i class="fa-solid fa-arrow-rotate-left"></i> Reset</button>
                                            <button type="button" class="pp-oke" id="periodOke"><i class="fa-solid fa-check"></i> Oke</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chart-body bc-chart-body" style="padding: 16px 20px 12px;">
                            <div id="chartBars" style="display:flex;align-items:flex-end;flex:1;gap:12px;position:relative;padding:22px 10px 28px;"></div>
                            <div id="chartLabels" style="display:flex;justify-content:space-between;padding:0 10px;margin-top:-4px;"></div>
                        </div>
                    </div>

                    <!-- Mini Charts Right -->
                    <div class="mini-charts">
                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Layanan Favorit</h3>
                                <span class="mc-total">{{ $layananFavorit->count() }}</span>
                            </div>
                            <div class="mc-body" id="miniChartFavorit" style="min-height:140px;">
                                @php
                                    $maxHeight = max($layananFavorit->max('total') ?: 0, 1);
                                    $colors = ['bar-primary', 'bar-success', 'bar-info', 'bar-warning'];
                                @endphp
                                @foreach($layananFavorit as $i => $fav)
                                <div class="mc-col">
                                    <span class="bar {{ $colors[$i % 4] }}" data-height="{{ round(($fav->total / $maxHeight) * 80) }}"></span>
                                    <span class="mc-label" title="{{ $fav->nm_layanan }}">{{ $fav->nm_layanan }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Booking Mendatang</h3>
                                <span class="mc-total">{{ $bookingMendatang->count() }}</span>
                            </div>
                            <div style="display:grid;gap:8px;">
                                @forelse($bookingMendatang as $bm)
                                @php
                                    $badgeClass = $bm->status === 'menunggu' ? 'badge-warning' : ($bm->status === 'dikonfirmasi' ? 'badge-success' : 'badge-primary');
                                    $label = ucfirst($bm->status);
                                @endphp
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">{{ \Carbon\Carbon::parse($bm->tanggal)->isoFormat('D MMM') }}</span>
                                    <span style="color:var(--gray);">-</span>
                                    <span style="flex:1;">{{ $bm->detail->first() && $bm->detail->first()->layanan ? $bm->detail->first()->layanan->nm_layanan : '-' }}</span>
                                    <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                                </div>
                                @empty
                                <div style="text-align:center;padding:16px;color:var(--gray);font-size:12px;">
                                    Tidak ada booking mendatang.
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Bottom Grid -->
                <div class="dashboard-bottom-grid">
                    <!-- Riwayat Treatment Saya -->
                    <div class="table-widget">
                        <div class="tw-header">
                            <h3>Riwayat Treatment Saya</h3>
                            <a href="{{ route('pelanggan.treatment') }}">Lihat Semua</a>
                        </div>
                        <div class="table-scroll">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Layanan</th>
                                    <th>Terapis</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatTreatments as $treatment)
                                <tr>
                                    <td><div class="td-flex">{{ \Carbon\Carbon::parse($treatment->tanggal)->isoFormat('D MMM YYYY') }}</div></td>
                                    <td>{{ $treatment->detail->first() && $treatment->detail->first()->layanan ? $treatment->detail->first()->layanan->nm_layanan : '-' }}</td>
                                    <td>{{ $treatment->karyawan ? $treatment->karyawan->nama : 'Terapis #'.$treatment->id_karyawan }}</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" style="text-align:center;padding:20px;color:var(--gray);font-size:13px;">
                                        Belum ada riwayat treatment.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                    </div>

                    <!-- Produk Yang Tersedia -->
                    <div class="table-widget">
                        <div class="tw-header">
                            <h3>Produk Yang Tersedia</h3>
                            <a href="{{ route('pelanggan.produk') }}">Lihat Semua</a>
                        </div>
                        <div class="table-scroll" style="max-height:242px;overflow-y:auto;">
                            <div style="display:block;width:100%;">
                            <table class="data-table" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($produks as $produk)
                                    <tr>
                                        <td><div class="td-flex">{{ $produk->nm_produk }}</div></td>
                                        <td>{{ $produk->kategori?->nm_produk ?? 'Umum' }}</td>
                                        <td>{{ $produk->stok }} {{ $produk->satuan }}</td>
                                        <td>Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center;padding:20px;color:var(--gray);font-size:13px;">
                                            Belum ada produk tersedia.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Bottom Row -->
                <div class="dashboard-bottom-row">
                    <!-- Progres Membership -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Progres Membership</h3>
                            <a href="{{ route('pelanggan.membership') }}" style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        @if($nextTier || $isMaxTier)
                        <div class="mb-progres">
                            <div class="mb-tier-row">
                                <span class="mb-tier-name">
                                    <i class="fa-solid fa-crown"></i>
                                    {{ $memberSaatIni ? $memberSaatIni->tingkat : 'Non Member' }}
                                </span>
                                @if($isMaxTier)
                                <span class="mb-tier-badge max"><i class="fa-solid fa-check"></i> Max Tier</span>
                                @else
                                <span class="mb-tier-badge"><i class="fa-solid fa-arrow-up"></i> {{ $nextTier->tingkat }}</span>
                                @endif
                            </div>
                            <div>
                                <div class="mb-bar-label">
                                    <span>Total Belanja</span>
                                    <span><strong>Rp {{ number_format($totalBelanja, 0, ',', '.') }}</strong> / Rp {{ number_format($targetBelanja, 0, ',', '.') }}</span>
                                </div>
                                <div class="mb-bar">
                                    <div class="mb-fill {{ $progressBelanja >= 100 ? 'full' : '' }}" data-width="{{ $progressBelanja }}"></div>
                                </div>
                            </div>
                            <div>
                                <div class="mb-bar-label">
                                    <span>Total Transaksi</span>
                                    <span><strong>{{ $totalTransaksi }}</strong> / {{ $targetTransaksi }}</span>
                                </div>
                                <div class="mb-bar">
                                    <div class="mb-fill {{ $progressTransaksi >= 100 ? 'full' : '' }}" data-width="{{ $progressTransaksi }}"></div>
                                </div>
                            </div>
                            @if(!$isMaxTier)
                            <div style="font-size:11px;color:var(--gray);margin-top:2px;">
                                <i class="fa-solid fa-circle-info" style="color:var(--primary);"></i>
                                Tinggal <strong style="color:var(--primary);">Rp {{ number_format(max(0, $nextTier->min_pembelian - $totalBelanja), 0, ',', '.') }}</strong> lagi untuk naik ke {{ $nextTier->tingkat }}!
                            </div>
                            @endif
                        </div>
                        @else
                        <div style="text-align:center;padding:20px;color:var(--gray);font-size:13px;">
                            Belum ada data membership. Mulai transaksi Anda untuk bergabung!
                        </div>
                        @endif
                    </div>

                    <!-- Promo Terbaru -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Promo Terbaru</h3>
                            <a href="{{ route('pelanggan.promo') }}" style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div class="booking-list">
                            @forelse($promos as $promo)
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(substr($promo->nm_promo, 0, 2)) }}&background=FFE5EF&color=FF4F87&size=40&format=svg&font-size=0.30" alt="Promo">
                                <div class="booking-info">
                                    <h4>{{ $promo->nm_promo }}</h4>
                                    <p>{{ $promo->jenis_promo }} - {{ $promo->nilai }}{{ $promo->jenis_promo == 'Diskon' ? '%' : '' }} | {{ \Carbon\Carbon::parse($promo->mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($promo->selesai)->format('d M Y') }}</p>
                                </div>
                                <span class="badge badge-primary">{{ $promo->jenis_promo }}</span>
                            </div>
                            @empty
                            <div style="text-align:center;padding:20px;color:var(--gray);font-size:13px;">
                                Belum ada promo tersedia saat ini.
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Layanan Populer -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Layanan Populer</h3>
                            <a href="{{ route('pelanggan.booking') }}" style="font-size:13px;color:var(--primary);font-weight:500;">Booking</a>
                        </div>
                        <div class="content-scroll">
                        <div class="employee-grid">
                            @forelse($layanans as $layanan)
                            @php
                                $kategori = $kategoriLayanan->firstWhere('id_kategori_layanan', $layanan->id_kategori);
                                $nmKategori = $kategori ? $kategori->nm_layanan : 'Layanan';
                                $initial = substr($layanan->nm_layanan, 0, 2);
                            @endphp
                            <div class="employee-card">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($initial) }}&background=FFE5EF&color=FF4F87&size=36" alt="{{ $layanan->nm_layanan }}">
                                <div class="ec-info">
                                    <h4>{{ $layanan->nm_layanan }}</h4>
                                    <p>{{ $nmKategori }} - Mulai Rp {{ number_format($layanan->harga, 0, ',', '.') }}</p>
                                </div>
                                <span class="ec-status online"></span>
                            </div>
                            @empty
                            <div style="grid-column:1/-1;text-align:center;padding:20px;color:var(--gray);font-size:13px;">
                                Belum ada layanan tersedia.
                            </div>
                            @endforelse
                        </div>
                        </div>
                    </div>

                </div>

                <!-- Dashboard Bottom Row: Produk & Rating -->
                <div class="dashboard-bottom-grid">
                    <!-- Produk Yang Sering Dibeli -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Produk Yang Sering Dibeli</h3>
                            <a href="{{ route('pelanggan.produk') }}" style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div class="stock-grid">
                            @forelse($produkTerlaris as $produk)
                            <div class="stock-item">
                                <div class="stock-icon {{ $loop->index % 4 === 0 ? 'primary' : ($loop->index % 4 === 1 ? 'success' : ($loop->index % 4 === 2 ? 'warning' : 'info')) }}">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /></svg>
                                </div>
                                <div class="stock-info">
                                    <h4>{{ $produk->nm_produk }}</h4>
                                    <p>{{ $produk->kategori?->nm_produk ?? 'Produk' }} - Terjual: {{ $produk->total_terjual ?? 0 }}</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill {{ $loop->index % 4 === 0 ? 'primary' : ($loop->index % 4 === 1 ? 'success' : ($loop->index % 4 === 2 ? 'warning' : 'info')) }}" style="width:{{ min(100, ($produk->total_terjual ?? 0) * 20) }}%"></div>
                                </div>
                                <span style="font-size:12px;color:var(--primary);font-weight:500;">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</span>
                            </div>
                            @empty
                            <div style="grid-column:1/-1;text-align:center;padding:20px;color:var(--gray);font-size:13px;">
                                Belum ada produk terlaris.
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Rating Saya & Belum Diberi Rating -->
                    <div class="rating-col" style="display:grid;gap:20px;align-content:start;min-width:0;">
                    <div class="table-widget">
                        <div class="tw-header">
                            <h3><i class="fa-solid fa-star" style="color:#F59E0B;font-size:14px;margin-right:4px;"></i> Rating Saya</h3>
                            <a href="{{ route('rating.index') }}">Semua Ulasan</a>
                        </div>
                        <div class="table-scroll">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Objek</th>
                                    <th>Bintang</th>
                                    <th>Komentar</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ratingSaya as $rating)
                                <tr>
                                    <td>
                                        <div class="td-flex">
                                            <span class="badge {{ $rating->tipe === 'layanan' ? 'badge-primary' : 'badge-success' }}" style="margin-right:6px;">{{ $rating->tipe_label }}</span>
                                            {{ $rating->nama_objek }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="dash-rating-stars">{{ str_repeat('★', $rating->bintang) }}{{ str_repeat('☆', 5 - $rating->bintang) }}</span>
                                    </td>
                                    <td>{{ $rating->komentar ? \Illuminate\Support\Str::limit($rating->komentar, 40) : '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($rating->created_at)->isoFormat('D MMM YYYY') }}</td>
                                    <td>
                                        <div style="display:flex;gap:6px;align-items:center;">
                                            <a href="{{ $rating->tipe === 'layanan' ? ($rating->booking_id ? route('pelanggan.rating.layanan', $rating->booking_id) : route('layanan.detail', $rating->id_target)) : route('pelanggan.produk.detail', $rating->id_target) . '#ulasan' }}"
                                                class="dash-rate-btn" title="Edit ulasan">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </a>
                                            <form action="{{ route('rating.destroy', $rating->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus rating Anda?')" style="margin:0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dash-rate-btn danger" title="Hapus ulasan">
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" style="text-align:center;padding:20px;color:var(--gray);font-size:13px;">
                                        Anda belum memberikan rating.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                    </div>

                    <div class="table-widget">
                        <div class="tw-header">
                            <h3><i class="fa-solid fa-pen" style="color:var(--primary);font-size:13px;margin-right:4px;"></i> Belum Diberi Rating</h3>
                        </div>
                        <div class="table-scroll">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Objek</th>
                                    <th style="text-align:right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $adaBelum = $belumDirating['layanan']->isNotEmpty() || $belumDirating['produk']->isNotEmpty(); @endphp
                                @forelse($belumDirating['layanan'] as $layanan)
                                <tr>
                                    <td>
                                        <div class="td-flex">
                                            <span class="badge badge-primary" style="margin-right:6px;flex-shrink:0;">Layanan</span>
                                            <span style="min-width:0;">{{ $layanan->nm_layanan }}</span>
                                        </div>
                                    </td>
                                    <td style="text-align:right;">
                                        <a href="{{ $layanan->booking_id ? route('pelanggan.rating.layanan', $layanan->booking_id) : route('layanan.detail', $layanan->id_layanan) }}" class="dash-rate-btn primary" style="white-space:nowrap;">
                                            <i class="fa-solid fa-star"></i> Beri Rating
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                                @forelse($belumDirating['produk'] as $produk)
                                <tr>
                                    <td>
                                        <div class="td-flex">
                                            <span class="badge badge-success" style="margin-right:6px;flex-shrink:0;">Produk</span>
                                            <span style="min-width:0;">{{ $produk->nm_produk }}</span>
                                        </div>
                                    </td>
                                    <td style="text-align:right;">
                                        <a href="{{ route('pelanggan.produk.detail', $produk->id_produk) }}#ulasan" class="dash-rate-btn primary" style="white-space:nowrap;">
                                            <i class="fa-solid fa-star"></i> Beri Rating
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                                @if (!$adaBelum)
                                <tr>
                                    <td colspan="2" style="text-align:center;padding:20px;color:var(--gray);font-size:13px;">
                                        Tidak ada yang perlu di-rating.
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    const chartMonths = @json($chartMonths);
    const chartCounts = @json($chartCounts);
    const chartYearMonths = @json($chartYearMonths);
    const chartYearCounts = @json($chartYearCounts);

    function renderChart(months) {
        const container = document.getElementById('chartBars');
        const labelContainer = document.getElementById('chartLabels');
        container.innerHTML = '';
        labelContainer.innerHTML = '';

        let subsetMonths, subsetCounts;
        if (months === 12) {
            subsetMonths = chartYearMonths;
            subsetCounts = chartYearCounts;
        } else {
            const start = Math.max(0, chartMonths.length - months);
            subsetMonths = chartMonths.slice(start);
            subsetCounts = chartCounts.slice(start);
        }
        const maxVal = Math.max(...subsetCounts, 1);

        const topPad = 22;
        const bottomPad = 28;
        const availHeight = Math.max(80, (container.clientHeight || 220) - topPad - bottomPad);

        const gridValues = [];
        const gridStep = Math.ceil(maxVal / 4);
        for (let i = 0; i <= 4; i++) {
            gridValues.push(gridStep * i);
        }

        for (let i = 0; i < 4; i++) {
            const pct = ((i + 1) / 5) * 100;
            const line = document.createElement('div');
            line.style.cssText = 'position:absolute;left:0;right:0;bottom:' + (bottomPad + (pct * availHeight / 100)) + 'px;height:1px;background:var(--border);';
            container.appendChild(line);
        }

        subsetMonths.forEach(function(month, i) {
            const count = subsetCounts[i];
            const pct = maxVal > 0 ? (count / maxVal) : 0;
            const barHeight = Math.round(pct * availHeight);

            const col = document.createElement('div');
            col.style.cssText = 'flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;';

            const bar = document.createElement('div');
            bar.style.cssText = 'width:100%;height:' + barHeight + 'px;background:linear-gradient(180deg,#FF4F87,#FF7BA6);border-radius:6px 6px 0 0;transition:all 0.3s ease;position:relative;';

            const label = document.createElement('div');
            label.style.cssText = 'position:absolute;top:-18px;left:50%;transform:translateX(-50%);font-size:10px;font-weight:700;color:var(--primary);background:#FFF5F8;padding:2px 6px;border-radius:4px;';
            label.textContent = count;

            const monthLabel = document.createElement('span');
            monthLabel.style.cssText = 'font-size:10px;color:var(--gray);font-weight:500;';
            monthLabel.textContent = month;

            bar.appendChild(label);
            col.appendChild(bar);
            col.appendChild(monthLabel);
            container.appendChild(col);
        });

        const step = Math.max(1, Math.floor(maxVal / 4));
        for (let i = 0; i <= 4; i++) {
            const span = document.createElement('span');
            span.style.cssText = 'font-size:9px;color:#ccc;';
            span.textContent = step * i;
            labelContainer.appendChild(span);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);

        document.querySelectorAll('.mb-fill').forEach(function(fill) {
            var width = parseInt(fill.getAttribute('data-width')) || 0;
            setTimeout(function() { fill.style.width = width + '%'; }, 200);
        });

        document.querySelectorAll('#miniChartFavorit .bar').forEach(function(bar) {
            var height = parseInt(bar.getAttribute('data-height')) || 0;
            setTimeout(function() { bar.style.height = height + 'px'; }, 200);
        });

        const periodTrigger = document.getElementById('periodTrigger');
        const periodPopup = document.getElementById('periodPopup');
        const periodOptions = document.getElementById('periodOptions');
        const periodReset = document.getElementById('periodReset');
        const periodOke = document.getElementById('periodOke');
        const periodLabel = document.getElementById('periodLabel');
        let periodValue = 3;

        const periodConfig = [
            { months: 3, title: '3 Bulan Terakhir' },
            { months: 6, title: '6 Bulan Terakhir' },
            { months: 12, title: 'Tahun Ini' }
        ];

        function monthRangeLabel(months) {
            const now = new Date();
            const start = new Date(now.getFullYear(), now.getMonth() - (months - 1), 1);
            const fmt = { month: 'short', year: 'numeric' };
            return start.toLocaleDateString('id-ID', fmt) + ' \u2014 ' + now.toLocaleDateString('id-ID', fmt);
        }

        function buildPeriodOptions() {
            periodOptions.innerHTML = '';
            periodConfig.forEach(function(cfg) {
                const opt = document.createElement('button');
                opt.type = 'button';
                opt.className = 'pp-option' + (cfg.months === periodValue ? ' selected' : '');
                opt.setAttribute('data-months', cfg.months);
                opt.innerHTML = '<span class="po-title">' + cfg.title + ' <i class="fa-solid fa-check"></i></span><span class="po-sub">' + monthRangeLabel(cfg.months) + '</span>';
                opt.addEventListener('click', function(e) {
                    e.stopPropagation();
                    periodOptions.querySelectorAll('.pp-option').forEach(function(o) {
                        o.classList.remove('selected');
                    });
                    opt.classList.add('selected');
                    periodValue = parseInt(opt.getAttribute('data-months'));
                });
                periodOptions.appendChild(opt);
            });
        }

        function positionPeriodPopup() {
            if (window.matchMedia('(max-width: 480px)').matches) {
                periodPopup.classList.remove('open-up');
                return;
            }
            const rect = periodTrigger.getBoundingClientRect();
            const spaceBelow = window.innerHeight - rect.bottom;
            const popupH = periodPopup.offsetHeight;
            if (spaceBelow < popupH + 12 && rect.top > popupH + 12) {
                periodPopup.classList.add('open-up');
            } else {
                periodPopup.classList.remove('open-up');
            }
        }

        function openPeriodPopup() {
            buildPeriodOptions();
            periodPopup.classList.add('open');
            periodTrigger.classList.add('open');
            positionPeriodPopup();
        }

        function closePeriodPopup() {
            periodPopup.classList.remove('open');
            periodTrigger.classList.remove('open');
        }

        function applyPeriod() {
            periodLabel.textContent = periodValue === 12 ? 'Tahun Ini' : periodValue + ' Bulan';
            renderChart(periodValue);
            closePeriodPopup();
        }

        if (periodTrigger && periodPopup) {
            renderChart(periodValue);
            periodTrigger.addEventListener('click', function(e) {
                e.stopPropagation();
                if (periodPopup.classList.contains('open')) {
                    closePeriodPopup();
                } else {
                    openPeriodPopup();
                }
            });
            periodOke.addEventListener('click', function(e) {
                e.stopPropagation();
                applyPeriod();
            });
            periodReset.addEventListener('click', function(e) {
                e.stopPropagation();
                periodValue = 3;
                buildPeriodOptions();
                applyPeriod();
            });
            document.addEventListener('click', function(e) {
                const wrap = document.getElementById('periodWrap');
                if (wrap && !wrap.contains(e.target)) {
                    closePeriodPopup();
                }
            });
            window.addEventListener('resize', function() {
                renderChart(periodValue);
            });
        }

        const btnTingkatkan = document.getElementById('btnTingkatkan');
        if (btnTingkatkan) {
            btnTingkatkan.addEventListener('click', function(e) {
                const arrow = this.querySelector('i');
                if (arrow) {
                    arrow.style.transform = 'translateX(4px)';
                    setTimeout(function() {
                        arrow.style.transform = 'translateX(0)';
                    }, 200);
                }
            });
        }
    });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
