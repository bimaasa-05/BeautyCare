<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Reservasi - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/beautycian.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .bc-actions form { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .filter-group { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .search-input-wrap input { max-width: 100%; box-sizing: border-box; }

        .mini-list-card { background: #fff; border-radius: 16px; border: 1px solid var(--border); padding: 20px; }
        .mini-list-card .ml-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .mini-list-card .ml-header h4 { font-size: 13px; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 8px; }
        .mini-list-card .ml-header h4 svg { width: 16px; height: 16px; color: var(--primary); }
        .ml-item { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f5f5f5; }
        .ml-item:last-child { border-bottom: none; }
        .ml-item .ml-rank { width: 22px; height: 22px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; flex-shrink: 0; }
        .ml-item .ml-rank.gold { background: #FEF3C7; color: #D97706; }
        .ml-item .ml-rank.silver { background: #F1F5F9; color: #64748B; }
        .ml-item .ml-rank.bronze { background: #FDE8E8; color: #DC2626; }
        .ml-item .ml-rank.normal { background: #F8F9FC; color: #94A3B8; }
        .ml-item .ml-info { flex: 1; min-width: 0; }
        .ml-item .ml-info .ml-name { font-size: 12px; font-weight: 600; color: var(--dark); }
        .ml-item .ml-info .ml-count { font-size: 11px; color: var(--gray); }
        .ml-item .ml-value { font-size: 12px; font-weight: 700; color: var(--primary); }

        .dashboard-bottom-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 24px; }
        .dashboard-grid { align-items: start; }
        @media (max-width: 900px) { .dashboard-bottom-grid { grid-template-columns: 1fr; } }
        @media (max-width: 1200px) { .search-input-wrap input { width: 180px; } }
        @media (max-width: 768px) { .search-input-wrap input { width: 150px; } }
        @media (max-width: 430px) { .search-input-wrap input { width: 100%; } }

        /* ─── Filter custom select (pola pelanggan custom-select-wrap) ─── */
        .csw-pill { position: relative; min-width: 150px; }
        .csw-pill .custom-select-trigger {
            display: flex; align-items: center; justify-content: space-between; gap: 10px;
            width: 100%; padding: 8px 16px; border-radius: 100px;
            border: 1.5px solid #E5E7EB; background: #fff; font-size: 12px;
            font-family: 'Poppins', sans-serif; color: var(--dark); cursor: pointer;
            transition: all 0.2s ease; user-select: none; box-sizing: border-box;
        }
        .csw-pill .custom-select-trigger:hover { border-color: #FFB6CD; }
        .csw-pill .custom-select-trigger.open { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(255, 79, 135, 0.1); }
        .csw-pill .custom-select-trigger .cst-placeholder { color: #bbb; }
        .csw-pill .custom-select-trigger .cst-text { color: var(--dark); }
        .csw-pill .custom-select-trigger .cst-arrow { font-size: 11px; color: #999; transition: transform 0.2s ease; flex-shrink: 0; }
        .csw-pill .custom-select-trigger.open .cst-arrow { transform: rotate(180deg); }
        .csw-pill .custom-select-dropdown {
            position: absolute; top: calc(100% + 4px); left: 0; right: 0; background: #fff;
            border: 1.5px solid var(--border); border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            z-index: 100; display: none; max-height: 200px; overflow-y: auto; padding: 4px;
        }
        .csw-pill .custom-select-dropdown.open { display: block; }
        .csw-pill .custom-select-dropdown.open-up { top: auto; bottom: calc(100% + 4px); }
        .csw-pill .custom-select-dropdown .csd-item {
            padding: 9px 12px; font-size: 12px; border-radius: 8px; cursor: pointer;
            transition: background 0.15s ease; color: var(--dark);
        }
        .csw-pill .custom-select-dropdown .csd-item:hover { background: #FFF0F5; }
        .csw-pill .custom-select-dropdown .csd-item.selected { background: #FFE4EC; color: var(--primary); font-weight: 600; }
        .csw-pill .custom-select-dropdown::-webkit-scrollbar { width: 5px; }
        .csw-pill .custom-select-dropdown::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }

        /* ─── Period Popup (pola pelanggan dashboard) ─── */
        .period-trigger {
            display: inline-flex; align-items: center; gap: 8px;
            background: #fff; border: 1.5px solid #E5E7EB; border-radius: 10px;
            padding: 8px 14px; font-family: 'Poppins', sans-serif; font-size: 13px;
            font-weight: 600; color: var(--dark); cursor: pointer;
            transition: all 0.25s ease; box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        }
        .period-trigger:hover { border-color: #FFB6CD; background: #FFF9FB; }
        .period-trigger > i:first-child { color: var(--primary); }
        .period-trigger .period-arrow { font-size: 11px; color: var(--gray); transition: transform 0.3s ease; }
        .period-trigger.open .period-arrow { transform: rotate(180deg); }
        .period-popup {
            display: none; position: absolute; top: calc(100% + 6px); right: 0; width: 280px;
            background: #fff; border-radius: 16px; border: 1px solid #FFD6E6;
            box-shadow: 0 12px 40px rgba(255, 79, 135, 0.15); z-index: 120; padding: 20px;
            font-family: 'Poppins', sans-serif; transform-origin: top center;
            animation: curtainUnroll 0.45s cubic-bezier(0.22, 0.61, 0.36, 1);
        }
        .period-popup.open { display: block; }
        .period-popup.open-up { top: auto; bottom: calc(100% + 6px); transform-origin: bottom center; animation-name: curtainUnrollUp; }
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
        .period-popup .pp-header { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
        .period-popup .pp-icon {
            width: 34px; height: 34px; border-radius: 10px; background: #FFE3EE; color: var(--primary);
            display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0;
        }
        .period-popup .pp-header h4 { font-size: 14px; font-weight: 700; color: var(--dark); margin: 0; }
        #periodOptions { display: grid; gap: 6px; margin-bottom: 14px; }
        .pp-option {
            display: flex; flex-direction: column; gap: 2px; text-align: left; width: 100%;
            border: 1.5px solid #F1F2F6; background: #fff; border-radius: 12px; padding: 10px 12px;
            cursor: pointer; transition: all 0.2s ease; font-family: 'Poppins', sans-serif;
        }
        .pp-option:hover { background: #FFF9FB; border-color: #FFB6CD; }
        .pp-option .po-title { font-size: 13px; font-weight: 700; color: var(--dark); display: flex; align-items: center; gap: 8px; }
        .pp-option .po-title i { font-size: 11px; color: #fff; opacity: 0; transform: scale(0.5); transition: all 0.2s ease; }
        .pp-option .po-sub { font-size: 11px; color: var(--gray); font-weight: 500; }
        .pp-option.selected { border-color: var(--primary); background: linear-gradient(135deg, var(--primary), #FF7BA6); }
        .pp-option.selected .po-title, .pp-option.selected .po-sub { color: #fff; }
        .pp-option.selected .po-title i { opacity: 1; transform: scale(1); }
        .pp-footer { display: flex; gap: 8px; }
        .pp-today, .pp-oke {
            flex: 1; border: none; border-radius: 10px; padding: 9px 0; font-family: 'Poppins', sans-serif;
            font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center;
            justify-content: center; gap: 6px; transition: all 0.2s ease;
        }
        .pp-today { background: #F1F2F6; color: var(--gray); }
        .pp-today:hover { background: #E5E7EB; color: var(--dark); }
        .pp-oke { background: linear-gradient(135deg, var(--primary), #FF7BA6); color: #fff; box-shadow: 0 4px 12px rgba(255, 79, 135, 0.3); }
        .pp-oke:hover { box-shadow: 0 6px 16px rgba(255, 79, 135, 0.4); transform: translateY(-1px); }
        @media (max-width: 768px) { .period-popup { left: 0; right: auto; } }
        @media (max-width: 480px) {
            .period-popup {
                position: fixed; left: 50%; top: 50%; right: auto; bottom: auto;
                transform: translate(-50%, -50%); width: calc(100vw - 40px); max-width: 320px;
                max-height: calc(100vh - 32px); overflow-y: auto;
                animation: curtainUnrollMobile 0.45s cubic-bezier(0.22, 0.61, 0.36, 1);
            }
        }
        @keyframes curtainUnrollMobile {
            0%   { transform: translate(-50%, -50%) scaleY(0); opacity: 0.2; }
            55%  { transform: translate(-50%, -50%) scaleY(1.03); opacity: 1; }
            100% { transform: translate(-50%, -50%) scaleY(1); opacity: 1; }
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar-beautycian')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                            </div>
                            <div class="ph-text">
                                <h3>Riwayat Reservasi</h3>
                                <p>Rekap seluruh reservasi dan treatment yang telah ditangani</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $total_reservasi }}</div>
                        <div class="stat-label">Total Reservasi</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon success">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $selesai }}</div>
                        <div class="stat-label">Selesai</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</div>
                        <div class="stat-label">Total Pendapatan</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value">Rp {{ number_format($pendapatan_bulan_ini, 0, ',', '.') }}</div>
                        <div class="stat-label">Pendapatan Bulan Ini</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                        </div>
                        <div class="stat-value">Rp {{ number_format($rata_rata_transaksi, 0, ',', '.') }}</div>
                        <div class="stat-label">Rata-rata/Transaksi</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $booking_hari_ini }}</div>
                        <div class="stat-label">Booking Hari Ini</div>
                    </div>
                </div>

                <div class="dashboard-grid" style="margin-top:24px;">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Grafik Treatment Selesai</h3>
                            <div class="chart-actions">
                                <div style="position:relative;" id="periodWrap">
                                    <button type="button" class="period-trigger" id="periodTrigger">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        <span id="periodLabel">Tahun Ini</span>
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
                        <div class="chart-body">
                            <canvas id="chartReservasi" height="280"></canvas>
                        </div>
                    </div>
                    <div class="mini-charts">
                        <div class="mini-list-card">
                            <div class="ml-header">
                                <h4>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                    Layanan Terpopuler
                                </h4>
                            </div>
                            <div>
                                @forelse($layananTerpopuler as $i => $item)
                                <div class="ml-item">
                                    <div class="ml-rank {{ $i == 0 ? 'gold' : ($i == 1 ? 'silver' : ($i == 2 ? 'bronze' : 'normal')) }}">#{{ $i + 1 }}</div>
                                    <div class="ml-info">
                                        <div class="ml-name">{{ $item->layanan->nm_layanan ?? '-' }}</div>
                                        <div class="ml-count">{{ $item->total }} kali digunakan</div>
                                    </div>
                                    <div class="ml-value">{{ $item->total }}x</div>
                                </div>
                                @empty
                                <div style="padding:20px;text-align:center;color:var(--gray);font-size:12px;">Belum ada data</div>
                                @endforelse
                            </div>
                        </div>
                        <div class="mini-list-card" style="margin-top:16px;">
                            <div class="ml-header">
                                <h4>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/></svg>
                                    Pelanggan Setia
                                </h4>
                            </div>
                            <div>
                                @forelse($pelanggan_setia as $i => $item)
                                <div class="ml-item">
                                    <div class="ml-rank {{ $i == 0 ? 'gold' : ($i == 1 ? 'silver' : ($i == 2 ? 'bronze' : 'normal')) }}">#{{ $i + 1 }}</div>
                                    <div class="ml-info">
                                        <div class="ml-name">{{ $item->pelanggan->nm_pelanggan ?? '#' . $item->id_pelanggan }}</div>
                                        <div class="ml-count">{{ $item->total }} kali reservasi</div>
                                    </div>
                                    <div class="ml-value">{{ $item->total }}x</div>
                                </div>
                                @empty
                                <div style="padding:20px;text-align:center;color:var(--gray);font-size:12px;">Belum ada data</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="booking-card-premium" style="margin-top:24px;">
                    <div class="bc-header">
                        <div class="bc-title-wrap">
                            <div class="bc-title-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                            </div>
                            <div>
                                <div class="bc-title">Daftar Reservasi</div>
                                <div class="bc-subtitle">Riwayat seluruh reservasi yang tercatat</div>
                            </div>
                        </div>
                        <div class="bc-actions">
                            <div class="flex items-center gap-2 mb-3">
                                <a href="{{ route('beautycian.laporan-reservasi.export-pdf') }}" target="_blank"
                                    class="flex items-center gap-1 px-3 py-1.5 text-[11px] font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition-colors">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    PDF
                                </a>
                                <a href="{{ route('beautycian.laporan-reservasi.export-excel') }}" target="_blank"
                                    class="flex items-center gap-1 px-3 py-1.5 text-[11px] font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    Excel
                                </a>
                            </div>
                            <form action="{{ route('beautycian.laporan-reservasi.index') }}" method="GET">
                                <div class="filter-group">
                                    <input type="hidden" name="filter_status" id="filterStatusInput" value="{{ request('filter_status') }}">
                                    <div class="csw-pill" id="filterStatusWrap">
                                        <div class="custom-select-trigger" id="filterStatusTrigger">
                                            <span class="cst-placeholder">Semua Status</span>
                                            <span class="cst-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                                        </div>
                                        <div class="custom-select-dropdown" id="filterStatusDropdown">
                                            <div class="csd-item {{ request('filter_status') == '' ? 'selected' : '' }}" data-value="">Semua Status</div>
                                            <div class="csd-item {{ request('filter_status') == 'dikonfirmasi' ? 'selected' : '' }}" data-value="dikonfirmasi">Dikonfirmasi</div>
                                            <div class="csd-item {{ request('filter_status') == 'diproses' ? 'selected' : '' }}" data-value="diproses">Diproses</div>
                                            <div class="csd-item {{ request('filter_status') == 'selesai' ? 'selected' : '' }}" data-value="selesai">Selesai</div>
                                            <div class="csd-item {{ request('filter_status') == 'dibatalkan' ? 'selected' : '' }}" data-value="dibatalkan">Dibatalkan</div>
                                        </div>
                                    </div>
                                    <div class="search-input-wrap" style="display:inline-block;">
                                        <svg class="si-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                        <input type="text" name="search" placeholder="Cari pelanggan..." value="{{ $search ?? '' }}">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div style="overflow-x:auto;">
                        <div class="overflow-x-auto"><table class="booking-table">
                            <thead>
                                <tr>
                                    <th>ID Booking</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Layanan</th>
                                    <th>Status</th>
                                    <th>Total Bayar</th>
                                    <th style="text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $statusLabels = [
                                        'dikonfirmasi' => 'Dikonfirmasi',
                                        'diproses'     => 'Diproses',
                                        'selesai'      => 'Selesai',
                                        'dibatalkan'   => 'Dibatalkan',
                                    ];
                                @endphp
                                @forelse($reservasi as $item)
                                <tr>
                                    <td>
                                        <span class="booking-id-badge">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 2h16v20l-4-2-4 2-4-2-4 2V2z"/><line x1="8" y1="8" x2="16" y2="8"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                                            #BK{{ str_pad($item->id_booking, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td data-label="Pelanggan">
                                        <div class="therapist-cell">
                                            <div class="th-avatar"><img src="{{ $item->pelanggan?->foto_url ?? 'https://ui-avatars.com/api/?name=%3F&background=FFE5EF&color=FF4F87&size=40' }}" alt="{{ $item->pelanggan->nm_pelanggan ?? '?' }}" style="width:100%;height:100%;border-radius:50%;object-fit:cover;display:block;"></div>
                                            <span class="th-name">{{ $item->pelanggan ? $item->pelanggan->nm_pelanggan : 'Pelanggan #'.$item->id_pelanggan }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Tanggal">
                                        <div style="display:flex;align-items:center;gap:6px;justify-content:center;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                            <span>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM YYYY') }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Jam">
                                        @php
                                            $lpDurasi = \App\Support\BookingSlot::durasiBooking($item);
                                            $lpMulai = \Carbon\Carbon::parse($item->jam)->format('H:i');
                                            $lpSelesai = \Carbon\Carbon::parse($item->tanggal . ' ' . substr($item->jam, 0, 5))->addMinutes($lpDurasi)->format('H:i');
                                        @endphp
                                        <div style="display:flex;align-items:center;gap:6px;justify-content:center;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            <div style="text-align:left;">
                                                <span style="font-weight:600;font-variant-numeric:tabular-nums;">{{ $lpMulai }} - {{ $lpSelesai }}</span>
                                                <div style="font-size:11px;color:var(--gray);">{{ $lpDurasi }} menit</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Layanan">
                                        <span style="font-weight:500;">
                                            @if($item->detail && $item->detail->isNotEmpty())
                                                @foreach($item->detail as $dt)
                                                    {{ $dt->layanan ? $dt->layanan->nm_layanan : '-' }}@if(!$loop->last), @endif
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </td>
                                    <td data-label="Status">
                                        <span class="status-badge {{ $item->status }}">
                                            <span class="sb-dot"></span>
                                            {{ $statusLabels[$item->status] ?? ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td data-label="Total Bayar">
                                        <span style="font-weight:600;color:var(--text-primary);">
                                            Rp {{ number_format($item->detail->sum('subtotal') ?? 0, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td data-label="Aksi" style="text-align:center;">
                                        <a href="{{ route('beautycian.laporan-reservasi.show', $item->id_booking) }}" class="action-btn edit" title="Detail reservasi">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="es-illustration">
                                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                            </div>
                                            <h4>Belum Ada Reservasi</h4>
                                            <p>Tidak ada data reservasi yang ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table></div>
                    </div>

                    <div class="table-footer">
                        <div class="tf-info">
                            <span class="tf-dot"></span>
                            Menampilkan {{ $reservasi->firstItem() ?? 0 }}-{{ $reservasi->lastItem() ?? 0 }} dari {{ $reservasi->total() }} reservasi
                        </div>
                        <div class="tf-pagination">
                            @if ($reservasi->onFirstPage())
                                <span class="page-btn" style="opacity:0.4;cursor:default;">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                                </span>
                            @else
                                <a href="{{ $reservasi->previousPageUrl() }}" class="page-btn">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                                </a>
                            @endif

                            @foreach ($reservasi->getUrlRange(max(1, $reservasi->currentPage() - 2), min($reservasi->lastPage(), $reservasi->currentPage() + 2)) as $page => $url)
                                <a href="{{ $url }}" class="page-btn {{ $page == $reservasi->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                            @endforeach

                            @if ($reservasi->hasMorePages())
                                <a href="{{ $reservasi->nextPageUrl() }}" class="page-btn">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                </a>
                            @else
                                <span class="page-btn" style="opacity:0.4;cursor:default;">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    var monthLabels = @json($chartBulan);
    var monthData = @json($chartSelesai);
    var dailyData = @json($chartDailyData);

    var chartCtx = document.getElementById('chartReservasi').getContext('2d');
    var chartInstance;

    var animOpts = {
        duration: 1200,
        easing: 'easeOutQuart'
    };

    function initChart(period) {
        var labels, values;

        if (period === 'month') {
            labels = [];
            for (var d = 1; d <= dailyData.length; d++) {
                labels.push(d);
            }
            values = dailyData;
        } else {
            labels = monthLabels;
            values = monthData;
        }

        if (chartInstance) chartInstance.destroy();

        var gradient = chartCtx.createLinearGradient(0, 0, 0, 280);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.25)');
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

        chartInstance = new Chart(chartCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Treatment Selesai',
                    data: values,
                    borderColor: '#10B981',
                    backgroundColor: gradient,
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#10B981',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: animOpts,
                onClick: function() {
                    this.reset();
                    this.update();
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1F2937',
                        bodyColor: '#4B5563',
                        borderColor: '#D1FAE5',
                        borderWidth: 1,
                        padding: 10,
                        cornerRadius: 8,
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { maxTicksLimit: 12 }
                    },
                    y: {
                        border: { display: false },
                        grid: { color: '#ECFDF5', borderDash: [3, 3] },
                        ticks: { maxTicksLimit: 6, stepSize: 1 }
                    }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initChart('{{ request('chart_period', 'year') }}');
    });

    const periodConfig = [
        { key: 'month', title: 'Bulan Ini', sub: '1 bulan terakhir' },
        { key: 'year', title: 'Tahun Ini', sub: '12 bulan terakhir' }
    ];
    const periodTrigger = document.getElementById('periodTrigger');
    const periodPopup = document.getElementById('periodPopup');
    const periodOptions = document.getElementById('periodOptions');
    const periodReset = document.getElementById('periodReset');
    const periodOke = document.getElementById('periodOke');
    const periodLabel = document.getElementById('periodLabel');
    const validKeys = periodConfig.map(function(c) { return c.key; });
    let periodValue = validKeys.indexOf('{{ request('chart_period', 'year') }}') !== -1 ? '{{ request('chart_period', 'year') }}' : 'year';

    const initPeriodCfg = periodConfig.find(function(c) { return c.key === periodValue; });
    if (initPeriodCfg && periodLabel) periodLabel.textContent = initPeriodCfg.title;

    function buildPeriodOptions() {
        periodOptions.innerHTML = '';
        periodConfig.forEach(function(cfg) {
            const opt = document.createElement('button');
            opt.type = 'button';
            opt.className = 'pp-option' + (cfg.key === periodValue ? ' selected' : '');
            opt.setAttribute('data-key', cfg.key);
            opt.innerHTML = '<span class="po-title">' + cfg.title + ' <i class="fa-solid fa-check"></i></span><span class="po-sub">' + cfg.sub + '</span>';
            opt.addEventListener('click', function(e) {
                e.stopPropagation();
                periodOptions.querySelectorAll('.pp-option').forEach(function(o) { o.classList.remove('selected'); });
                opt.classList.add('selected');
                periodValue = opt.getAttribute('data-key');
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
        const cfg = periodConfig.find(function(c) { return c.key === periodValue; });
        if (cfg) periodLabel.textContent = cfg.title;
        initChart(periodValue);
        closePeriodPopup();
    }

    if (periodTrigger && periodPopup) {
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
            periodValue = 'year';
            buildPeriodOptions();
            applyPeriod();
        });
        document.addEventListener('click', function(e) {
            const wrap = document.getElementById('periodWrap');
            if (wrap && !wrap.contains(e.target)) {
                closePeriodPopup();
            }
        });
    }

    function initFilterPill(inputId, wrapId, triggerId, dropdownId) {
        const input = document.getElementById(inputId);
        const wrap = document.getElementById(wrapId);
        const trigger = document.getElementById(triggerId);
        const dropdown = document.getElementById(dropdownId);
        if (!input || !wrap || !trigger || !dropdown) return;
        const placeholderText = trigger.querySelector('.cst-placeholder') ? trigger.querySelector('.cst-placeholder').textContent : 'Semua';

        function syncSelected() {
            dropdown.querySelectorAll('.csd-item').forEach(function(item) {
                item.classList.toggle('selected', item.getAttribute('data-value') === input.value);
            });
        }

        function updateTrigger() {
            const selected = dropdown.querySelector('.csd-item.selected');
            if (selected) {
                trigger.innerHTML = '<span class="cst-text">' + selected.textContent.trim() + '</span><span class="cst-arrow"><i class="fa-solid fa-chevron-down"></i></span>';
            } else {
                trigger.innerHTML = '<span class="cst-placeholder">' + placeholderText + '</span><span class="cst-arrow"><i class="fa-solid fa-chevron-down"></i></span>';
            }
        }

        syncSelected();
        updateTrigger();

        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            const open = dropdown.classList.contains('open');
            document.querySelectorAll('.custom-select-dropdown.open').forEach(function(d) {
                if (d.id !== dropdownId) d.classList.remove('open');
            });
            document.querySelectorAll('.custom-select-trigger.open').forEach(function(t) {
                if (t.id !== triggerId) t.classList.remove('open');
            });
            dropdown.classList.toggle('open');
            trigger.classList.toggle('open');
            if (dropdown.classList.contains('open')) {
                const rect = dropdown.getBoundingClientRect();
                const flip = rect.bottom > window.innerHeight - 8 && rect.top > window.innerHeight / 2;
                dropdown.classList.toggle('open-up', flip);
            }
        });

        dropdown.addEventListener('click', function(e) {
            const item = e.target.closest('.csd-item');
            if (!item) return;
            input.value = item.getAttribute('data-value');
            syncSelected();
            updateTrigger();
            dropdown.classList.remove('open');
            trigger.classList.remove('open');
            if (input.closest('form')) input.closest('form').submit();
        });

        document.addEventListener('click', function() {
            dropdown.classList.remove('open');
            trigger.classList.remove('open');
        });
    }

    initFilterPill('filterStatusInput', 'filterStatusWrap', 'filterStatusTrigger', 'filterStatusDropdown');
    </script>
    <script src="{{ asset('assets/js/beautycian.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
