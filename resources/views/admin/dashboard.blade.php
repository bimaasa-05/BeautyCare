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

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .chart-card:hover {
            box-shadow: 0 4px 24px rgba(236, 72, 153, 0.14);
        }

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

        .card-scroll {
            max-height: 320px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .card-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .card-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .card-scroll::-webkit-scrollbar-thumb {
            background: #FBCFE8;
            border-radius: 10px;
        }

        .card-scroll::-webkit-scrollbar-thumb:hover {
            background: #F9A8D4;
        }

        @media (max-width: 768px) {
            .sidebar-toggle {
                display: flex;
                align-items: center;
            }

            .data-table thead {
                display: none;
            }

            .data-table tbody tr {
                display: block;
                padding: 16px;
                border-bottom: 1px solid var(--border);
            }

            .data-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border: none;
                font-size: 13px;
                text-align: right;
            }

            .data-table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--gray);
                font-size: 11px;
                text-transform: uppercase;
            }

            .data-table tbody td:first-child {
                padding-left: 0;
            }

            .data-table tbody td:last-child {
                padding-right: 0;
            }
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

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            border-bottom: 1px solid #FEE2EC;
        }

        .chart-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: #1F2937;
            margin: 0;
        }

        .chart-actions {
            margin-left: 12px;
        }

        /* ─── Period Dropdown (custom popup, mengikuti pola dashboard pelanggan) ─── */
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

        .period-options {
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
                right: auto;
                width: calc(100vw - 32px);
                max-width: 320px;
                transform: translateX(-50%);
            }
        }

        .chart-empty-msg {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #9CA3AF;
            font-size: 13px;
        }

        .mc-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            gap: 8px;
            flex-wrap: wrap;
        }

        .mc-header h3 {
            font-size: 14px;
            font-weight: 600;
            color: #1F2937;
            margin: 0;
        }

        .mc-total {
            font-size: 18px;
            font-weight: 700;
            color: #EC4899;
        }

        .mc-header .chart-actions {
            margin-left: auto;
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <!-- Dashboard Content -->
            <div class="dashboard-content p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6">

                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <span class="nav-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="14" width="7" height="7"></rect>
                                        <rect x="3" y="14" width="7" height="7"></rect>
                                    </svg>
                                </span>
                            </div>
                            <div class="ph-text">
                                <h3>Dashboard</h3>
                                <p>Selamat datang di panel admin BeautyCare. Pantau seluruh aktivitas bisnis Anda dalam
                                    satu tempat.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="stats-row grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                </svg>
                            </div>
                            <span id="stat-pendapatan-growth"
                                class="stat-change {{ $pendapatanGrowth >= 0 ? 'up' : 'down' }}">{{ $pendapatanGrowth >= 0 ? '+' : '' }}{{ $pendapatanGrowth }}%</span>
                        </div>
                        <div id="stat-pendapatan" class="stat-value">{{ $fmt($totalPendapatan) }}</div>
                        <div class="stat-label">Total Pendapatan</div>
                    </div>

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
                            <span id="stat-booking-growth"
                                class="stat-change {{ $bookingGrowth >= 0 ? 'up' : 'down' }}">{{ $bookingGrowth >= 0 ? '+' : '' }}{{ $bookingGrowth }}%</span>
                        </div>
                        <div id="stat-booking" class="stat-value">{{ number_format($totalBooking) }}</div>
                        <div class="stat-label">Total Booking</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon success">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="8.5" cy="7" r="4" />
                                    <polyline points="17 11 19 13 23 9" />
                                </svg>
                            </div>
                            <span id="stat-pelanggan-growth"
                                class="stat-change {{ $pelangganGrowth >= 0 ? 'up' : 'down' }}">{{ $pelangganGrowth >= 0 ? '+' : '' }}{{ $pelangganGrowth }}%</span>
                        </div>
                        <div id="stat-pelanggan" class="stat-value">{{ number_format($totalPelanggan) }}</div>
                        <div class="stat-label">Total Pelanggan</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
                                    <line x1="8" y1="21" x2="16" y2="21" />
                                    <line x1="12" y1="17" x2="12" y2="21" />
                                </svg>
                            </div>
                            <span id="stat-karyawan-growth"
                                class="stat-change {{ $karyawanGrowth >= 0 ? 'up' : 'down' }}">{{ $karyawanGrowth >= 0 ? '+' : '' }}{{ $karyawanGrowth }}%</span>
                        </div>
                        <div id="stat-karyawan" class="stat-value">{{ number_format($totalKaryawan) }}</div>
                        <div class="stat-label">Total Karyawan</div>
                    </div>

                    <div class="stat-card stat-card-produk">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                                </svg>
                            </div>
                            <span id="stat-produk-growth"
                                class="stat-change {{ $produkTerjualGrowth >= 0 ? 'up' : 'down' }}">{{ $produkTerjualGrowth >= 0 ? '+' : '' }}{{ $produkTerjualGrowth }}%</span>
                        </div>
                        <div id="stat-produk" class="stat-value">{{ number_format($produkTerjual) }}</div>
                        <div class="stat-label">Produk Terjual</div>
                    </div>
                </div>

                <!-- Dashboard Grid: Charts -->
                <div class="dashboard-grid grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                    <!-- Pendapatan Chart -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Grafik Pendapatan <span id="labelPendapatanPeriode"></span></h3>
                            <div class="chart-actions">
                                <div style="position:relative;" id="pendapatanPeriodWrap">
                                    <button type="button" class="period-trigger" id="pendapatanPeriodTrigger">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        <span id="pendapatanPeriodLabel">7 Hari</span>
                                        <i class="fa-solid fa-chevron-down period-arrow"></i>
                                    </button>
                                    <div class="period-popup" id="pendapatanPeriodPopup">
                                        <div class="pp-header">
                                            <span class="pp-icon"><i class="fa-solid fa-chart-line"></i></span>
                                            <h4>Periode Grafik Pendapatan</h4>
                                        </div>
                                        <div class="period-options" id="pendapatanPeriodOptions"></div>
                                        <div class="pp-footer">
                                            <button type="button" class="pp-today" id="pendapatanPeriodReset"><i class="fa-solid fa-arrow-rotate-left"></i> Reset</button>
                                            <button type="button" class="pp-oke" id="pendapatanPeriodOke"><i class="fa-solid fa-check"></i> Oke</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chart-body" style="position: relative; height: 280px;">
                            <canvas id="chartPendapatan"></canvas>
                            <span id="pendapatanEmptyMsg" class="chart-empty-msg" style="display:none;">Belum ada
                                data</span>
                        </div>
                    </div>

                    <!-- Mini Charts Right -->
                    <div class="mini-charts">
                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Grafik Booking <span id="labelBookingPeriode"></span></h3>
                                <span class="mc-total" id="totalBookingPeriode">{{ $totalBookingPeriode }}</span>
                                <div class="chart-actions">
                                    <div style="position:relative;" id="bookingPeriodWrap">
                                        <button type="button" class="period-trigger" id="bookingPeriodTrigger">
                                            <i class="fa-solid fa-calendar-days"></i>
                                            <span id="bookingPeriodLabel">7 Hari</span>
                                            <i class="fa-solid fa-chevron-down period-arrow"></i>
                                        </button>
                                        <div class="period-popup" id="bookingPeriodPopup">
                                            <div class="pp-header">
                                                <span class="pp-icon"><i class="fa-solid fa-chart-pie"></i></span>
                                                <h4>Periode Grafik Booking</h4>
                                            </div>
                                            <div class="period-options" id="bookingPeriodOptions"></div>
                                            <div class="pp-footer">
                                                <button type="button" class="pp-today" id="bookingPeriodReset"><i class="fa-solid fa-arrow-rotate-left"></i> Reset</button>
                                                <button type="button" class="pp-oke" id="bookingPeriodOke"><i class="fa-solid fa-check"></i> Oke</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mc-body" id="miniChartBooking"
                                style="position: relative; height: 180px; min-height: 180px;">
                                <canvas id="chartBookingDonut" style="max-width: 100%; height: 100%;"></canvas>
                                <span id="bookingEmptyMsg" class="chart-empty-msg" style="display:none;">Belum ada
                                    data</span>
                            </div>
                        </div>

                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Jadwal Hari Ini</h3>
                                <span id="jadwal-hari-ini-total" class="mc-total">{{ $jadwalHariIni->count() }}</span>
                            </div>
                            <div id="jadwal-hari-ini-list" class="grid gap-2 sm:gap-2.5">
                                @include('partials.dashboard.jadwal-hari-ini', ['jadwalHariIni' => $jadwalHariIni])
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Bottom Grid -->
                <div class="dashboard-bottom-grid grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Layanan Terlaris -->
                    <div class="table-widget overflow-x-auto">
                        <div class="tw-header">
                            <h3>Layanan Terlaris</h3>
                            <a href="{{ route('admin.layanan.index') }}">Lihat Semua</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Layanan</th>
                                    <th>Terjual</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody id="layanan-terlaris-body">
                                @include('partials.dashboard.layanan-terlaris', ['items' => $layananTerlaris, 'fmt' => $fmt])
                            </tbody>
                        </table>
                    </div>

                    <!-- Produk Terlaris -->
                    <div class="table-widget overflow-x-auto">
                        <div class="tw-header">
                            <h3>Produk Terlaris</h3>
                            <a href="{{ route('admin.produk.index') }}">Lihat Semua</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Terjual</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody id="produk-terlaris-body">
                                @include('partials.dashboard.produk-terlaris', ['items' => $produkTerlaris, 'fmt' => $fmt])
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Dashboard Leaderboard Grid -->
                <div class="dashboard-bottom-grid grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Top Global Pelanggan Layanan -->
                    <div class="table-widget overflow-x-auto">
                        <div class="tw-header">
                            <h3>Top Global Pelanggan (Layanan)</h3>
                            <a href="{{ route('admin.leaderboard.index') }}">Lihat Semua</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Layanan</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody id="top-global-layanan-body">
                                @include('partials.dashboard.top-global-layanan', ['items' => $topGlobalLayanan, 'fmt' => $fmt])
                            </tbody>
                        </table>
                    </div>

                    <!-- Top Global Pelanggan Produk -->
                    <div class="table-widget overflow-x-auto">
                        <div class="tw-header">
                            <h3>Top Global Pelanggan (Produk)</h3>
                            <a href="{{ route('admin.leaderboard.index') }}">Lihat Semua</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Produk</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody id="top-global-produk-body">
                                @include('partials.dashboard.top-global-produk', ['items' => $topGlobalProduk, 'fmt' => $fmt])
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Dashboard Leaderboard Karyawan Grid -->
                <div class="dashboard-bottom-grid grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Top Kasir -->
                    <div class="table-widget overflow-x-auto">
                        <div class="tw-header">
                            <h3>Top Kasir</h3>
                            <a href="{{ route('admin.leaderboard.index') }}">Lihat Semua</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kasir</th>
                                    <th>Transaksi</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody id="top-kasir-body">
                                @include('partials.dashboard.top-kasir', ['items' => $topKasir, 'fmt' => $fmt])
                            </tbody>
                        </table>
                    </div>

                    <!-- Top Beautycian -->
                    <div class="table-widget overflow-x-auto">
                        <div class="tw-header">
                            <h3>Top Beautycian</h3>
                            <a href="{{ route('admin.leaderboard.index') }}">Lihat Semua</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Beautycian</th>
                                    <th>Pelanggan</th>
                                    <th>Selesai</th>
                                </tr>
                            </thead>
                            <tbody id="top-beautycian-body">
                                @include('partials.dashboard.top-beautycian', ['items' => $topBeautycian])
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Dashboard Bottom Row -->
                <div class="dashboard-bottom-row grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Karyawan Aktif -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Karyawan Aktif</h3>
                            <a href="{{ route('admin.karyawan.index') }}"
                                style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div id="karyawan-aktif-grid" class="employee-grid">
                            @include('partials.dashboard.karyawan-aktif', ['karyawanAktif' => $karyawanAktif])
                        </div>
                    </div>

                    <!-- Ringkasan Stok -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Ringkasan Stok</h3>
                            <a href="{{ route('admin.produk.index') }}"
                                style="font-size:13px;color:var(--primary);font-weight:500;">Kelola</a>
                        </div>
                        <div id="ringkasan-stok-grid" class="stock-grid">
                            @include('partials.dashboard.ringkasan-stok', ['ringkasanStok' => $ringkasanStok])
                        </div>
                    </div>

                    <!-- Booking Terbaru -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Booking Terbaru</h3>
                            <a href="{{ route('admin.reservasi.index') }}"
                                style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div id="booking-terbaru-list" class="booking-list">
                            @include('partials.dashboard.booking-terbaru', ['bookingTerbaru' => $bookingTerbaru])
                        </div>
                    </div>

                    <!-- Notifikasi Stok -->
                    <div class="list-widget" style="max-height:440px;display:flex;flex-direction:column;">
                        <div class="lw-header">
                            <h3>Notifikasi Stok</h3>
                            <a href="{{ route('admin.stok.index') }}"
                                style="font-size:13px;color:var(--primary);font-weight:500;">Kelola</a>
                        </div>
                        <div id="notif-stok-grid" class="stock-grid card-scroll" style="flex:1;">
                            @include('partials.dashboard.notif-stok', ['notifStok' => $notifStok])
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

<style>
        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            border-bottom: 1px solid #FEE2EC;
        }
        .chart-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: #1F2937;
            margin: 0;
        }
        .chart-actions {
            margin-left: 12px;
        }
        .dropdown-pink {
            appearance: none;
            background: #fff;
            border: 1.5px solid #FCE7F3;
            border-radius: 8px;
            padding: 6px 32px 6px 12px;
            font-size: 12px;
            font-weight: 500;
            color: #EC4899;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23EC4899' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 12px;
            transition: all 0.2s ease;
            min-width: 110px;
        }
        .dropdown-pink:hover {
            border-color: #F9A8D4;
            box-shadow: 0 2px 8px rgba(236, 72, 153, 0.1);
        }
        .dropdown-pink:focus {
            outline: none;
            border-color: #EC4899;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.15);
        }
        .dropdown-pink option {
            background: #fff;
            color: #374151;
            padding: 8px;
        }
        .chart-empty-msg {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #9CA3AF;
            font-size: 13px;
        }
        .mc-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            gap: 8px;
            flex-wrap: wrap;
        }
        .mc-header h3 {
            font-size: 14px;
            font-weight: 600;
            color: #1F2937;
            margin: 0;
        }
        .mc-total {
            font-size: 18px;
            font-weight: 700;
            color: #EC4899;
        }
        .mc-header .chart-actions {
            margin-left: auto;
        }
    </style>

    <script>
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', options);

    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.color = '#9CA3AF';
    Chart.defaults.font.size = 11;

    const chartDataByPeriod = @json($chartDataPeriode);
    const donutDataByPeriod = @json($donutDataPeriode);
    let currentPeriodPendapatan = '{{ $periode }}';
    let currentPeriodBooking = '{{ $periodeBooking ?? $periode }}';

    const donutColors = ['#EC4899','#8B5CF6','#F59E0B','#10B981','#3B82F6','#EF4444','#14B8A6','#F97316','#6366F1','#84CC16'];

    let pendapatanChart = null;
    let bookingDonutChart = null;

    function getPeriodLabel(periode) {
        return periode === '7hari' ? '7 Hari' : (periode === '1bulan' ? '1 Bulan' : '1 Tahun');
    }

    function updatePendapatanLabel(periode) {
        const label = getPeriodLabel(periode);
        const pendLabel = document.getElementById('labelPendapatanPeriode');
        if (pendLabel) pendLabel.textContent = ' · ' + label;
    }

    function updateBookingLabel(periode) {
        const label = getPeriodLabel(periode);
        const bookLabel = document.getElementById('labelBookingPeriode');
        if (bookLabel) bookLabel.textContent = ' · ' + label;
    }

    function initPendapatanChart(labels, revenue) {
        const ctx = document.getElementById('chartPendapatan').getContext('2d');
        const maxRev = revenue.length > 0 ? Math.max(...revenue) : 0;
        const emptyMsg = document.getElementById('pendapatanEmptyMsg');
        const canvas = document.getElementById('chartPendapatan');
        const isEmpty = labels.length === 0 || revenue.every(v => Number(v) === 0);

        if (pendapatanChart) pendapatanChart.destroy();

        if (isEmpty) {
            if (canvas) canvas.style.display = 'none';
            if (emptyMsg) emptyMsg.style.display = 'flex';
            pendapatanChart = null;
            return;
    <script>
        const dateEl = document.getElementById('currentDate');
        if (dateEl) {
            const now = new Date();
            dateEl.textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
    </script>

    <script>
        Chart.defaults.font.family = "'Poppins', sans-serif";
        Chart.defaults.color = '#9CA3AF';
        Chart.defaults.font.size = 11;

        pendapatanChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: revenue,
                    borderColor: '#EC4899',
                    backgroundColor: 'rgba(236, 72, 153, 0.08)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#EC4899',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1F2937',
                        bodyColor: '#4B5563',
                        borderColor: '#FCE7F3',
                        borderWidth: 1,
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                var val = context.parsed.y;
                                if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(1) + ' jt';
                                return 'Rp ' + val.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { maxTicksLimit: Math.min(labels.length, 10) }
                    },
                    y: {
                        border: { display: false },
                        grid: { color: '#F3E8F5', borderDash: [3, 3] },
                        ticks: {
                            maxTicksLimit: 6,
                            callback: function(value) {
                                if (maxRev > 1000000) return 'Rp' + (value / 1000000).toFixed(1) + 'jt';
                                return 'Rp' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }
        const donutColors = ['#EC4899', '#8B5CF6', '#F59E0B', '#10B981', '#3B82F6', '#EF4444', '#14B8A6', '#F97316', '#6366F1', '#84CC16'];

        const chartDataByPeriod = @json($chartDataPeriode ?? []);
        const donutDataByPeriod = @json($donutDataPeriode ?? []);
        let currentPeriodPendapatan = '{{ $periode }}';
        let currentPeriodBooking = '{{ $periodeBooking ?? $periode }}';

        let pendapatanChart = null;
        let bookingDonutChart = null;

        const pendapatanCanvas = document.getElementById('chartPendapatan');
        const donutCanvas = document.getElementById('chartBookingDonut');

        function getPeriodLabel(periode) {
            return periode === '7hari' ? '7 Hari' : (periode === '1bulan' ? '1 Bulan' : '1 Tahun');
        }

        function updatePendapatanLabel(periode) {
            const el = document.getElementById('labelPendapatanPeriode');
            if (el) el.textContent = ' · ' + getPeriodLabel(periode);
        }

        function updateBookingLabel(periode) {
            const el = document.getElementById('labelBookingPeriode');
            if (el) el.textContent = ' · ' + getPeriodLabel(periode);
        }

        function initPendapatanChart(labels, revenue) {
            const emptyMsg = document.getElementById('pendapatanEmptyMsg');
            if (!pendapatanCanvas) return;

            const isEmpty = !labels || labels.length === 0 || revenue.every(v => Number(v) === 0);

            if (pendapatanChart) {
                pendapatanChart.destroy();
                pendapatanChart = null;
            }

            if (isEmpty) {
                pendapatanCanvas.style.display = 'none';
                if (emptyMsg) emptyMsg.style.display = 'flex';
                return;
            }

            pendapatanCanvas.style.display = 'block';
            if (emptyMsg) emptyMsg.style.display = 'none';

            const maxRev = Math.max(...revenue.map(Number)) || 0;

            pendapatanChart = new Chart(pendapatanCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: revenue,
                        borderColor: '#EC4899',
                        backgroundColor: 'rgba(236, 72, 153, 0.08)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#EC4899',
                        pointBorderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#1F2937',
                            bodyColor: '#4B5563',
                            borderColor: '#FCE7F3',
                            borderWidth: 1,
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: {
                                label: function (context) {
                                    const val = context.parsed.y;
                                    if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(1) + ' jt';
                                    return 'Rp ' + val.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { maxTicksLimit: Math.min(labels.length, 10) }
                        },
                        y: {
                            grid: { color: '#F3E8F5', borderDash: [3, 3] },
                            ticks: {
                                maxTicksLimit: 6,
                                callback: function (value) {
                                    if (maxRev > 1000000) return 'Rp' + (value / 1000000).toFixed(1) + 'jt';
                                    return 'Rp' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }

        function initDonut(values, labels) {
            const emptyMsg = document.getElementById('bookingEmptyMsg');
            if (!donutCanvas) return;

            const isEmpty = !labels || labels.length === 0 || values.every(v => Number(v) === 0);

            if (bookingDonutChart) {
                bookingDonutChart.destroy();
                bookingDonutChart = null;
            }

            if (isEmpty) {
                donutCanvas.style.display = 'none';
                if (emptyMsg) emptyMsg.style.display = 'flex';
                return;
            }

            donutCanvas.style.display = 'block';
            if (emptyMsg) emptyMsg.style.display = 'none';

            bookingDonutChart = new Chart(donutCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: donutColors.slice(0, labels.length),
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { family: 'Poppins', size: 10 },
                                color: '#6B7280',
                                padding: 10,
                                usePointStyle: true,
                                pointStyleWidth: 8
                            }
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#1F2937',
                            bodyColor: '#4B5563',
                            borderColor: '#FCE7F3',
                            borderWidth: 1,
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: {
                                label: function (context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                                    return ' ' + context.label + ': ' + context.parsed + ' (' + pct + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }

        function updatePendapatanChart() {
            updatePendapatanLabel(currentPeriodPendapatan);
            const data = chartDataByPeriod[currentPeriodPendapatan];
            initPendapatanChart(data ? data.labels : [], data ? data.revenue : []);
        }

        function updateBookingChart() {
            updateBookingLabel(currentPeriodBooking);
            const data = donutDataByPeriod[currentPeriodBooking];
            const values = data ? data.values : [];
            const labels = data ? data.labels : [];
            initDonut(values, labels);
            const totalEl = document.getElementById('totalBookingPeriode');
            if (totalEl) totalEl.textContent = values.reduce((a, b) => a + Number(b), 0);
        }

        function changePendapatanPeriod(value) {
            currentPeriodPendapatan = value;
            updatePendapatanChart();
        }

        function changeBookingPeriod(value) {
            currentPeriodBooking = value;
            updateBookingChart();
        }

        function initPeriodDropdown(config) {
            const wrap = document.getElementById(config.wrapId);
            const trigger = document.getElementById(config.triggerId);
            const popup = document.getElementById(config.popupId);
            const optionsEl = document.getElementById(config.optionsId);
            const resetBtn = document.getElementById(config.resetId);
            const okeBtn = document.getElementById(config.okeId);
            const labelEl = document.getElementById(config.labelId);
            if (!wrap || !trigger || !popup || !optionsEl || !resetBtn || !okeBtn || !labelEl) return;

            let current = config.defaultValue;

            function periodConfigs() {
                const now = new Date();
                const fmt = { day: 'numeric', month: 'short', year: 'numeric' };
                const rangeLabel = function(daysBack) {
                    const start = new Date(now.getFullYear(), now.getMonth(), now.getDate() - daysBack);
                    return start.toLocaleDateString('id-ID', fmt) + ' \u2014 ' + now.toLocaleDateString('id-ID', fmt);
                };
                return [
                    { value: '7hari', title: '7 Hari Terakhir', range: rangeLabel(6) },
                    { value: '1bulan', title: '1 Bulan Terakhir', range: rangeLabel(29) },
                    { value: '1tahun', title: 'Tahun Ini', range: 'Jan ' + now.getFullYear() + ' \u2014 ' + now.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' }) }
                ];
            }

            function getPeriodLabel(value) {
                return value === '7hari' ? '7 Hari' : (value === '1bulan' ? '1 Bulan' : '1 Tahun');
            }

            function buildOptions() {
                optionsEl.innerHTML = '';
                periodConfigs().forEach(function(cfg) {
                    const opt = document.createElement('button');
                    opt.type = 'button';
                    opt.className = 'pp-option' + (cfg.value === current ? ' selected' : '');
                    opt.setAttribute('data-value', cfg.value);
                    opt.innerHTML = '<span class="po-title">' + cfg.title + ' <i class="fa-solid fa-check"></i></span><span class="po-sub">' + cfg.range + '</span>';
                    opt.addEventListener('click', function(e) {
                        e.stopPropagation();
                        optionsEl.querySelectorAll('.pp-option').forEach(function(o) {
                            o.classList.remove('selected');
                        });
                        opt.classList.add('selected');
                        current = opt.getAttribute('data-value');
                    });
                    optionsEl.appendChild(opt);
                });
            }

            function positionPopup() {
                if (window.matchMedia('(max-width: 480px)').matches) {
                    popup.classList.remove('open-up');
                    return;
                }
                const rect = trigger.getBoundingClientRect();
                const spaceBelow = window.innerHeight - rect.bottom;
                const popupH = popup.offsetHeight;
                if (spaceBelow < popupH + 12 && rect.top > popupH + 12) {
                    popup.classList.add('open-up');
                } else {
                    popup.classList.remove('open-up');
                }
            }

            function openPopup() {
                buildOptions();
                popup.classList.add('open');
                trigger.classList.add('open');
                positionPopup();
            }

            function closePopup() {
                popup.classList.remove('open');
                trigger.classList.remove('open');
            }

            function applyPeriod() {
                labelEl.textContent = getPeriodLabel(current);
                if (config.onChange) config.onChange(current);
                closePopup();
            }

            labelEl.textContent = getPeriodLabel(current);

            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                if (popup.classList.contains('open')) {
                    closePopup();
                } else {
                    openPopup();
                }
            });

            okeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                applyPeriod();
            });

            resetBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                current = config.defaultValue;
                buildOptions();
                applyPeriod();
            });

            document.addEventListener('click', function(e) {
                if (wrap && !wrap.contains(e.target)) closePopup();
            });
        }

        initPeriodDropdown({
            wrapId: 'pendapatanPeriodWrap',
            triggerId: 'pendapatanPeriodTrigger',
            popupId: 'pendapatanPeriodPopup',
            optionsId: 'pendapatanPeriodOptions',
            resetId: 'pendapatanPeriodReset',
            okeId: 'pendapatanPeriodOke',
            labelId: 'pendapatanPeriodLabel',
            defaultValue: currentPeriodPendapatan,
            onChange: changePendapatanPeriod
        });

        initPeriodDropdown({
            wrapId: 'bookingPeriodWrap',
            triggerId: 'bookingPeriodTrigger',
            popupId: 'bookingPeriodPopup',
            optionsId: 'bookingPeriodOptions',
            resetId: 'bookingPeriodReset',
            okeId: 'bookingPeriodOke',
            labelId: 'bookingPeriodLabel',
            defaultValue: currentPeriodBooking,
            onChange: changeBookingPeriod
        });

        updatePendapatanChart();
        updateBookingChart();
    </script>

    <script>
        const DASHBOARD_URL = "{{ route('admin.dashboard.data') }}";
        const REFRESH_INTERVAL = 30000;

        function updateGrowth(id, value) {
            const node = document.getElementById(id);
            if (!node) return;
            node.textContent = (value >= 0 ? '+' : '') + value + '%';
            node.classList.remove('up', 'down');
            node.classList.add(value >= 0 ? 'up' : 'down');
        }

        function setHTML(id, html) {
            const el = document.getElementById(id);
            if (el) el.innerHTML = html;
        }

        function refreshDashboard() {
            fetch(DASHBOARD_URL + '?periode=' + currentPeriodPendapatan + '&periode_booking=' + currentPeriodBooking, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(res => res.json())
                .then(data => {
                    const s = data.stats;
                    const setText = (id, val) => {
                        const el = document.getElementById(id);
                        if (el) el.textContent = val;
                    };
                    setText('stat-pendapatan', s.totalPendapatan);
                    setText('stat-booking', s.totalBooking);
                    setText('stat-pelanggan', s.totalPelanggan);
                    setText('stat-karyawan', s.totalKaryawan);
                    setText('stat-produk', s.produkTerjual);
                    updateGrowth('stat-pendapatan-growth', s.pendapatanGrowth);
                    updateGrowth('stat-booking-growth', s.bookingGrowth);
                    updateGrowth('stat-pelanggan-growth', s.pelangganGrowth);
                    updateGrowth('stat-karyawan-growth', s.karyawanGrowth);
                    updateGrowth('stat-produk-growth', s.produkTerjualGrowth);

                    if (data.charts) {
                        updatePendapatanChart();
                    }

                    if (data.donut) {
                        const v = data.donut.values;
                        if (v.length > 0) {
                            initDonut(v, data.donut.labels);
                            const totalEl = document.getElementById('totalBookingPeriode');
                            if (totalEl) totalEl.textContent = data.donut.total;
                        } else {
                            const emptyMsg = document.getElementById('bookingEmptyMsg');
                            if (emptyMsg) emptyMsg.style.display = 'flex';
                            const donutCanvasEl = document.getElementById('chartBookingDonut');
                            if (donutCanvasEl) donutCanvasEl.style.display = 'none';
                            if (bookingDonutChart) {
                                bookingDonutChart.destroy();
                                bookingDonutChart = null;
                            }
                        }
                    }

                    setText('jadwal-hari-ini-total', data.jadwalHariIni.total);
                    setHTML('jadwal-hari-ini-list', data.jadwalHariIni.html);
                    setHTML('layanan-terlaris-body', data.layananTerlaris.html);
                    setHTML('produk-terlaris-body', data.produkTerlaris.html);
                    setHTML('top-global-layanan-body', data.topGlobalLayanan.html);
                    setHTML('top-global-produk-body', data.topGlobalProduk.html);
                    setHTML('top-kasir-body', data.topKasir.html);
                    setHTML('top-beautycian-body', data.topBeautycian.html);
                    setHTML('karyawan-aktif-grid', data.karyawanAktif.html);
                    setHTML('ringkasan-stok-grid', data.ringkasanStok.html);
                    setHTML('booking-terbaru-list', data.bookingTerbaru.html);
                    setHTML('notif-stok-grid', data.notifStok.html);
                })
                .catch(err => console.warn('Dashboard refresh gagal:', err));
        }

        refreshDashboard();
        setInterval(refreshDashboard, REFRESH_INTERVAL);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
<<<<<<< HEAD
=======

>>>>>>> dcdf78362ebd328f023e1444d304aa589d9d2db6
</html>