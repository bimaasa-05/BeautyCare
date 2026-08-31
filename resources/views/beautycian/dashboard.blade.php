<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Beautycian - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/beautycian.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stock-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; }
        .booking-item { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f5f5f5; flex-wrap: wrap; }
        .booking-item:last-child { border-bottom: none; }
        .booking-item .booking-info { flex: 1; min-width: 0; }
        .booking-item         .booking-time { flex-shrink: 0; }
        .dashboard-grid { align-items: start; }
        .mini-chart-card .mc-body { min-height: 130px; }
        .chart-card .chart-body { max-height: 380px; }
        .jadwal-list { max-height: 240px; overflow-y: auto; }
        .booking-next-list { max-height: 240px; overflow-y: auto; }
        .chart-summary { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 14px; padding-top: 14px; border-top: 1px solid #F3E8F5; }
        .cs-item { text-align: center; padding: 10px; border-radius: 10px; background: #FDF2F7; }
        .cs-item .cs-label { font-size: 10px; font-weight: 600; color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; }
        .cs-item .cs-value { font-size: 15px; font-weight: 700; color: var(--dark); margin-top: 4px; }
        .cs-item .cs-sub { font-size: 11px; color: var(--primary); font-weight: 600; margin-top: 2px; }

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
        @media (max-width: 576px) { .chart-summary { grid-template-columns: 1fr; } }
        @media (max-width: 768px) {
            .data-table thead { display: none; }
            .data-table tbody tr { display: block; padding: 12px 0; border-bottom: 1px solid var(--border); }
            .data-table tbody td { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; border: none; font-size: 13px; text-align: right; }
            .data-table tbody td::before { content: attr(data-label); font-weight: 600; color: var(--gray); font-size: 11px; text-transform: uppercase; }
            .data-table tbody td:first-child { padding-left: 0; }
            .data-table tbody td:last-child { padding-right: 0; }
            .data-table .td-flex { justify-content: flex-end; }
        }
        .table-widget { overflow-x: auto; }
        .table-widget .tw-header { flex-wrap: wrap; gap: 8px; }
    </style>
</head>

<body>
    <!-- Page Loader -->
    <div class="dashboard-layout">
        @include('layouts.sidebar-beautycian')

        <main class="main-content">
            @include('layouts.header2')

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Stats Row - Beautycian: Fokus Treatment & Jadwal -->
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
                        </div>
                        <div class="stat-value">{{ $jadwal_hari_ini }}</div>
                        <div class="stat-label">Jadwal Hari Ini</div>
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
                        </div>
                        <div class="stat-value">{{ $pelanggan_ditangani }}</div>
                        <div class="stat-label">Pelanggan Ditangani</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $layanan_selesai }}</div>
                        <div class="stat-label">Layanan Selesai</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $jam_kerja }}</div>
                        <div class="stat-label">Jam Kerja Hari Ini</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                            </div>
                        </div>
                        <div class="stat-value">Rp {{ number_format($pendapatan_hari_ini, 0, ',', '.') }}</div>
                        <div class="stat-label">Pendapatan Hari Ini</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            </div>
                        </div>
                        <div class="stat-value">{{ $reservasi_aktif }}</div>
                        <div class="stat-label">Reservasi Aktif</div>
                    </div>
                </div>

                <!-- Dashboard Grid: Charts -->
                <div class="dashboard-grid">
                    <!-- Grafik Layanan -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Grafik Layanan Perawatan</h3>
                            <div class="chart-actions">
                                <div style="position:relative;" id="periodWrap">
                                    <button type="button" class="period-trigger" id="periodTrigger">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        <span id="periodLabel">Minggu Ini</span>
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
                            <canvas id="chartLayanan" height="280"></canvas>
                        </div>
                        <div class="chart-summary">
                            <div class="cs-item">
                                <div class="cs-label">Total Layanan</div>
                                <div class="cs-value" id="csTotal">0</div>
                                <div class="cs-sub" id="csTotalPeriode">periode ini</div>
                            </div>
                            <div class="cs-item">
                                <div class="cs-label">Hari Tertinggi</div>
                                <div class="cs-value" id="csMax">0</div>
                                <div class="cs-sub" id="csMaxLabel"></div>
                            </div>
                            <div class="cs-item">
                                <div class="cs-label">Rata-rata</div>
                                <div class="cs-value" id="csAvg">0</div>
                                <div class="cs-sub">per hari</div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Berikutnya -->
                    <div class="mini-chart-card">
                        <div class="mc-header">
                            <h3>Booking Berikutnya</h3>
                            <a href="{{ route('beautycian.jadwal-treatment.index') }}" style="font-size:12px;color:var(--primary);font-weight:600;">Lihat Semua</a>
                        </div>
                        <div class="booking-next-list">
                            @forelse($booking_mendatang->take(3) as $item)
                            <div style="display:flex;align-items:center;gap:10px;font-size:13px;padding:10px 0;border-bottom:1px solid #f5f5f5;">
                                <span style="color:var(--primary);font-weight:700;flex-shrink:0;">{{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}</span>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-weight:600;color:var(--dark);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item->pelanggan?->nm_pelanggan ?? 'Pelanggan #'.$item->id_pelanggan }}</div>
                                    <div style="font-size:11px;color:var(--gray);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item->detail->pluck('layanan.nm_layanan')->implode(', ') ?: '-' }} &bull; {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM') }}</div>
                                </div>
                                <span class="badge badge-{{ $item->status === 'selesai' ? 'success' : ($item->status === 'diproses' ? 'primary' : ($item->status === 'dikonfirmasi' ? 'info' : 'warning')) }}">{{ $statusLabels[$item->status] ?? ucfirst($item->status) }}</span>
                            </div>
                            @empty
                            <div style="text-align:center;padding:16px;color:var(--gray);font-size:13px;">
                                Tidak ada booking mendatang
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Mini Charts Right -->
                    <div class="mini-charts">
                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Jam Kerja per Hari</h3>
                                <span class="mc-total">{{ $totalJamKerja > 0 ? round($totalJamKerja / 60, 1) : 0 }}</span>
                            </div>
                            <div class="mc-body" id="miniChartJam">
                                @foreach($jamKerjaBars as $durasi)
                                <span class="bar bar-primary" data-height="{{ $durasi > 0 ? round(($durasi / $maxDurasi) * 100) : 5 }}"></span>
                                @endforeach
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:11px;color:var(--gray);margin-top:8px;">
                                <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
                            </div>
                        </div>

                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Jadwal Perawatan</h3>
                                <span class="mc-total">{{ $jadwal_hari_ini }}</span>
                            </div>
                            <div class="jadwal-list" style="display:grid;gap:8px;">
                                @forelse($jadwal_hari_ini_list as $item)
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">{{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}</span>
                                    <span style="color:var(--gray);">-</span>
                                    <span style="flex:1;">{{ $item->detail->first()?->layanan?->nm_layanan ?? 'Treatment' }}</span>
                                    <span class="badge badge-{{ $item->status === 'selesai' ? 'success' : ($item->status === 'diproses' ? 'primary' : ($item->status === 'dikonfirmasi' ? 'info' : 'warning')) }}">{{ $statusLabels[$item->status] ?? ucfirst($item->status) }}</span>
                                </div>
                                @empty
                                <div style="text-align:center;padding:16px;color:var(--gray);font-size:13px;">
                                    Tidak ada jadwal hari ini
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Produk Favorit Pelanggan</h3>
                            </div>
                            <div class="mc-body" style="display:grid;gap:10px;">
                                @forelse($produk_favorit as $item)
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <span style="color:var(--primary);font-weight:700;flex-shrink:0;font-size:13px;">{{ $maxFavorit > 0 ? round(($item->total / $maxFavorit) * 100) : 0 }}%</span>
                                    <span style="flex:1;font-size:13px;color:var(--dark);font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item->nm_item }}</span>
                                    <div class="stock-bar" style="width:60px;">
                                        <div class="fill primary" style="width:{{ $maxFavorit > 0 ? round(($item->total / $maxFavorit) * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                                @empty
                                <div style="text-align:center;padding:16px;color:var(--gray);font-size:13px;">
                                    Belum ada data produk favorit
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Bottom Grid -->
                <div class="dashboard-bottom-grid">
                    <!-- Riwayat Treatment -->
                    <div class="table-widget">
                        <div class="tw-header">
                            <h3>Riwayat Treatment</h3>
                            <a href="{{ route('beautycian.laporan-reservasi.index') }}">Lihat Semua</a>
                        </div>
                        <div class="overflow-x-auto"><table class="data-table">
                            <thead>
                                <tr>
                                    <th>Pelanggan</th>
                                    <th>Layanan</th>
                                    <th>Tanggal</th>
                                    <th>Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat_treatment as $item)
                                <tr>
                                    <td data-label="Pelanggan"><div class="td-flex">{{ $item->pelanggan?->nm_pelanggan ?? '#' . $item->id_pelanggan }}</div></td>
                                    <td data-label="Layanan">{{ $item->detail->pluck('layanan.nm_layanan')->implode(', ') ?: '-' }}</td>
                                    <td data-label="Waktu">{{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}</td>
                                    <td data-label="Status"><span class="badge badge-{{ $item->status === 'selesai' ? 'success' : ($item->status === 'diproses' ? 'primary' : ($item->status === 'dikonfirmasi' ? 'info' : 'warning')) }}">{{ $statusLabels[$item->status] ?? ucfirst($item->status) }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" style="text-align:center;padding:24px;color:var(--gray);">
                                        Belum ada riwayat treatment
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table></div>
                    </div>

                    <!-- Produk Sering Digunakan -->
                    <div class="table-widget">
                        <div class="tw-header">
                            <h3>Produk Sering Digunakan</h3>
                        </div>
                        <div class="overflow-x-auto"><table class="data-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Digunakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produk_sering as $item)
                                <tr>
                                    <td data-label="Produk"><div class="td-flex">{{ $item->nm_item }}</div></td>
                                    <td data-label="Kategori">{{ $item->nm_kategori ?? '-' }}</td>
                                    <td data-label="Digunakan">{{ $item->total }} kali</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" style="text-align:center;padding:24px;color:var(--gray);">
                                        Belum ada data produk
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table></div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/beautycian.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script>
    const allChartData = {
        week: { labels: @json($weekLabels), values: @json($weekValues) },
        month: { labels: @json($monthLabels), values: @json($monthValues) },
        year: { labels: @json($yearLabels), values: @json($yearValues) },
    };

    const ctx = document.getElementById('chartLayanan').getContext('2d');
    let chartInstance;

    const animOpts = {
        duration: 1200,
        easing: 'easeOutQuart'
    };

    function initChart(period) {
        const data = allChartData[period];
        if (chartInstance) chartInstance.destroy();

        var gradient = ctx.createLinearGradient(0, 0, 0, 280);
        gradient.addColorStop(0, 'rgba(255, 79, 135, 0.25)');
        gradient.addColorStop(1, 'rgba(255, 79, 135, 0.01)');

        chartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Layanan Selesai',
                    data: data.values,
                    borderColor: '#FF4F87',
                    backgroundColor: gradient,
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#FF4F87',
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
                        borderColor: '#FCE7F3',
                        borderWidth: 1,
                        padding: 10,
                        cornerRadius: 8,
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { maxTicksLimit: Math.min(data.labels.length, 10) }
                    },
                    y: {
                        border: { display: false },
                        grid: { color: '#F3E8F5', borderDash: [3, 3] },
                        ticks: { maxTicksLimit: 6, stepSize: 1 }
                    }
                }
            }
        });
        updateSummary(data, period);
    }

    function updateSummary(data, period) {
        const labels = data.labels || [];
        const values = (data.values || []).map(v => Number(v));
        const total = values.reduce((a, b) => a + b, 0);
        const max = values.length ? Math.max(...values) : 0;
        const idx = values.indexOf(max);
        const avg = values.length ? Math.round(total / values.length) : 0;
        const periodeText = period === 'month' ? 'bulan ini' : period === 'year' ? 'tahun ini' : 'minggu ini';
        document.getElementById('csTotal').textContent = total;
        document.getElementById('csTotalPeriode').textContent = periodeText;
        document.getElementById('csMax').textContent = max;
        document.getElementById('csMaxLabel').textContent = max > 0 && labels[idx] ? labels[idx] : '-';
        document.getElementById('csAvg').textContent = avg;
    }

    initChart('{{ request('chart_period', 'week') }}');

    const periodConfig = [
        { key: 'week', title: 'Minggu Ini', sub: '7 hari terakhir' },
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
    let periodValue = validKeys.indexOf('{{ request('chart_period', 'week') }}') !== -1 ? '{{ request('chart_period', 'week') }}' : 'week';

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
            periodValue = 'week';
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
    </script>
</body>

</html>
