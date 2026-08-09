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
                                <select id="chartPeriod" onchange="switchChartPeriod()">
                                    <option value="month" {{ request('chart_period') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                                    <option value="year" {{ request('chart_period') != 'month' ? 'selected' : '' }}>Tahun Ini</option>
                                </select>
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
                                    <select name="filter_status" onchange="this.form.submit()">
                                        <option value="">Semua Status</option>
                                        <option value="dikonfirmasi" {{ request('filter_status') == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                                        <option value="diproses" {{ request('filter_status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ request('filter_status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ request('filter_status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
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
                                            <div class="th-avatar">{{ $item->pelanggan ? substr($item->pelanggan->nm_pelanggan, 0, 1) : '?' }}</div>
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
                                        <div style="display:flex;align-items:center;gap:6px;justify-content:center;">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            <span>{{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}</span>
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

    function switchChartPeriod() {
        var period = document.getElementById('chartPeriod').value;
        initChart(period);
    }

    document.addEventListener('DOMContentLoaded', function() {
        initChart('{{ request('chart_period', 'year') }}');
    });
    </script>
    <script src="{{ asset('assets/js/beautycian.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
