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
    }

    @media (max-width: 768px) {
        .data-table thead { display: none; }
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
        .data-table tbody td:first-child { padding-left: 0; }
        .data-table tbody td:last-child { padding-right: 0; }
    }
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
        }

        @media (max-width: 768px) {
            .data-table thead { display: none; }
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
            .data-table tbody td:first-child { padding-left: 0; }
            .data-table tbody td:last-child { padding-right: 0; }
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

        /* Dropdown Period Filter */
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
            -webkit-appearance: none;
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
            min-width: 120px;
        }
        .dropdown-pink:hover {
            border-color: #F9A8D4;
            box-shadow: 0 2px 8px rgba(236, 72, 153, 0.10);
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
</head>

<body>
    <!-- Page Loader -->
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
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Dashboard</h3>
                            <p>Selamat datang di panel admin BeautyCare. Pantau seluruh aktivitas bisnis Anda dalam satu tempat.</p>
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
                            <span id="stat-pendapatan-growth" class="stat-change {{ $pendapatanGrowth >= 0 ? 'up' : 'down' }}">{{ $pendapatanGrowth >= 0 ? '+' : '' }}{{ $pendapatanGrowth }}%</span>
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
                            <span id="stat-booking-growth" class="stat-change {{ $bookingGrowth >= 0 ? 'up' : 'down' }}">{{ $bookingGrowth >= 0 ? '+' : '' }}{{ $bookingGrowth }}%</span>
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
                            <span id="stat-pelanggan-growth" class="stat-change {{ $pelangganGrowth >= 0 ? 'up' : 'down' }}">{{ $pelangganGrowth >= 0 ? '+' : '' }}{{ $pelangganGrowth }}%</span>
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
                            <span id="stat-karyawan-growth" class="stat-change {{ $karyawanGrowth >= 0 ? 'up' : 'down' }}">{{ $karyawanGrowth >= 0 ? '+' : '' }}{{ $karyawanGrowth }}%</span>
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
                            <span id="stat-produk-growth" class="stat-change {{ $produkTerjualGrowth >= 0 ? 'up' : 'down' }}">{{ $produkTerjualGrowth >= 0 ? '+' : '' }}{{ $produkTerjualGrowth }}%</span>
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
                            <h3>Grafik Pendapatan {{ date('Y') }}</h3>
                        </div>
                        <div class="chart-body">
                            <canvas id="chartPendapatan" height="280"></canvas>
                            <h3>Grafik Pendapatan <span id="labelPendapatanPeriode"></span></h3>
                            <div class="chart-actions">
                                <select id="pendapatanPeriode" class="dropdown-pink" onchange="changePendapatanPeriod(this.value)">
                                    <option value="7hari">7 Hari</option>
                                    <option value="1bulan">1 Bulan</option>
                                    <option value="1tahun">1 Tahun</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-body">
                            <canvas id="chartPendapatan" height="280"></canvas>
                            <span id="pendapatanEmptyMsg" class="chart-empty-msg" style="display:none;">Belum ada data</span>
                        </div>
                    </div>

                    <!-- Mini Charts Right -->
                    <div class="mini-charts">
                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Grafik Booking (Minggu Ini)</h3>
                                <span class="mc-total">{{ $totalBookingMinggu }}</span>
                            </div>
                            <div class="mc-body" id="miniChartBooking">
                                <canvas id="chartBookingDonut" width="200" height="200"
                                    data-values='@json(array_values($layananBookingMinggu))'
                                    data-labels='@json(array_keys($layananBookingMinggu))'></canvas>
                            </div>
                        </div>
<div class="mini-chart-card">
    <div class="mc-header">
        <h3>Grafik Booking <span id="labelBookingPeriode"></span></h3>
        <span class="mc-total" id="totalBookingPeriode">{{ $totalBookingPeriode }}</span>
        <div class="chart-actions">
            <select id="bookingPeriode" class="dropdown-pink" onchange="changeBookingPeriod(this.value)">
                <option value="7hari">7 Hari</option>
                <option value="1bulan">1 Bulan</option>
                <option value="1tahun">1 Tahun</option>
            </select>
        </div>
    </div>
    <div class="mc-body" id="miniChartBooking" style="position: relative; height: 180px; min-height: 180px;">
        <canvas id="chartBookingDonut" style="max-width: 100%; height: 100%;"></canvas>
        <span id="bookingEmptyMsg" style="display:none;font-size:12px;color:#999;">Belum ada data</span>
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
                            <a href="{{ route('admin.karyawan.index') }}" style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div id="karyawan-aktif-grid" class="employee-grid">
                            @include('partials.dashboard.karyawan-aktif', ['karyawanAktif' => $karyawanAktif])
                        </div>
                    </div>

                    <!-- Ringkasan Stok -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Ringkasan Stok</h3>
                            <a href="{{ route('admin.produk.index') }}" style="font-size:13px;color:var(--primary);font-weight:500;">Kelola</a>
                        </div>
                        <div id="ringkasan-stok-grid" class="stock-grid">
                            @include('partials.dashboard.ringkasan-stok', ['ringkasanStok' => $ringkasanStok])
                        </div>
                    </div>

                    <!-- Booking Terbaru -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Booking Terbaru</h3>
                            <a href="{{ route('admin.reservasi.index') }}" style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div id="booking-terbaru-list" class="booking-list">
                            @include('partials.dashboard.booking-terbaru', ['bookingTerbaru' => $bookingTerbaru])
                        </div>
                    </div>

                    <!-- Notifikasi Stok -->
                    <div class="list-widget" style="max-height:440px;display:flex;flex-direction:column;">
                        <div class="lw-header">
                            <h3>Notifikasi Stok</h3>
                            <a href="{{ route('admin.stok.index') }}" style="font-size:13px;color:var(--primary);font-weight:500;">Kelola</a>
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

    const chartLabels = @json($chartLabels);
    const chartRevenue = @json($chartRevenueData);
    const maxRev = chartRevenue.length > 0 ? Math.max(...chartRevenue) : 0;

    const ctx = document.getElementById('chartPendapatan').getContext('2d');
    const pendapatanChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Pendapatan',
                data: chartRevenue,
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
                    ticks: { maxTicksLimit: Math.min(chartLabels.length, 10) }
                },
                y: {
                    border: { display: false },
                    grid: { color: '#F3E8F5', borderDash: [3, 3] },
                    ticks: {
                        maxTicksLimit: 6,
                        callback: function(value) {
                            if (maxRev > 1000000) return 'Rp' + (value / 1000000).toFixed(1) + 'jt';
                            return 'Rp' + value.toLocaleString('id-ID');
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
        }

        if (canvas) canvas.style.display = 'block';
        if (emptyMsg) emptyMsg.style.display = 'none';

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
            }
        });

    const donutCanvas = document.getElementById('chartBookingDonut');
    const donutColors = ['#EC4899','#8B5CF6','#F59E0B','#10B981','#3B82F6','#EF4444','#14B8A6','#F97316','#6366F1','#84CC16'];
    let bookingDonutChart = null;
    function initDonut(values, labels) {
        if (donutCanvas && donutCanvas.parentNode.querySelector('span')) {
            donutCanvas.parentNode.innerHTML = '';
            donutCanvas.parentNode.appendChild(donutCanvas);
        }
        });
    }

    function initDonut(values, labels) {
        const donutCanvas = document.getElementById('chartBookingDonut');
        const emptyMsg = document.getElementById('bookingEmptyMsg');
        const isEmpty = labels.length === 0 || values.every(v => Number(v) === 0);

        if (isEmpty) {
            if (donutCanvas) {
                donutCanvas.style.display = 'none';
                if (donutCanvas.parentNode && donutCanvas.parentNode.querySelector('span')) {
                    donutCanvas.parentNode.innerHTML = '';
                    donutCanvas.parentNode.appendChild(donutCanvas);
                }
            }
            if (emptyMsg) emptyMsg.style.display = 'flex';
            if (bookingDonutChart) {
                bookingDonutChart.destroy();
                bookingDonutChart = null;
            }
            return;
        }

        if (donutCanvas) donutCanvas.style.display = 'block';
        if (emptyMsg) emptyMsg.style.display = 'none';

        if (donutCanvas) {
            const container = donutCanvas.parentNode;
            while (container.firstChild) {
                if (container.firstChild !== donutCanvas && container.firstChild !== emptyMsg) {
                    container.removeChild(container.firstChild);
                } else {
                    break;
                }
            }
        }

        if (!bookingDonutChart) {
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
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                                    return ' ' + context.label + ': ' + context.parsed + ' (' + pct + '%)';
                                }
                            }
                        }
                    }
                }
            });
        } else {
            bookingDonutChart.data.labels = labels;
            bookingDonutChart.data.datasets[0].data = values;
            bookingDonutChart.data.datasets[0].backgroundColor = donutColors.slice(0, labels.length);
            bookingDonutChart.update();
        }
    }

    function updatePendapatanChart() {
        const chartData = chartDataByPeriod[currentPeriodPendapatan];
        updatePendapatanLabel(currentPeriodPendapatan);
        if (chartData) {
            initPendapatanChart(chartData.labels, chartData.revenue);
        }
    }

    function updateBookingChart() {
        const donutData = donutDataByPeriod[currentPeriodBooking];
        updateBookingLabel(currentPeriodBooking);
        if (donutData) {
            initDonut(donutData.values, donutData.labels);
            const total = donutData.values.reduce((a, b) => a + b, 0);
            const totalEl = document.getElementById('totalBookingPeriode');
            if (totalEl) totalEl.textContent = total;
        }
    }

    function changePendapatanPeriod(value) {
        currentPeriodPendapatan = value;
        document.getElementById('pendapatanPeriode').value = value;
        updatePendapatanChart();
    }

    function changeBookingPeriod(value) {
        currentPeriodBooking = value;
        document.getElementById('bookingPeriode').value = value;
        updateBookingChart();
    }

    document.getElementById('pendapatanPeriode').value = currentPeriodPendapatan;
    document.getElementById('bookingPeriode').value = currentPeriodBooking;
    updatePendapatanLabel(currentPeriodPendapatan);
    updateBookingLabel(currentPeriodBooking);

    const initPendData = chartDataByPeriod[currentPeriodPendapatan] || { labels: [], revenue: [] };
    initPendapatanChart(initPendData.labels, initPendData.revenue);

    const initDonutData = donutDataByPeriod[currentPeriodBooking] || { labels: [], values: [] };
    initDonut(initDonutData.values, initDonutData.labels);
    if (initDonutData.values.length > 0) {
        const total = initDonutData.values.reduce((a, b) => a + b, 0);
        const totalEl = document.getElementById('totalBookingPeriode');
        if (totalEl) totalEl.textContent = total;
    }
    </script>
    <script>
    function pilihPeriode(el) {
        window.location.href = '?' + el.dataset.param + '=' + el.value;
    }
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

            if (pendapatanChart && data.charts) {
                pendapatanChart.data.labels = data.charts.labels;
                pendapatanChart.data.datasets[0].data = data.charts.revenue;
                pendapatanChart.update('none');
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
                    const donutCanvas = document.getElementById('chartBookingDonut');
                    if (donutCanvas) donutCanvas.style.display = 'none';
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

    function setHTML(id, html) {
        const el = document.getElementById(id);
        if (el) el.innerHTML = html;
    }

    refreshDashboard();
    setInterval(refreshDashboard, REFRESH_INTERVAL);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>