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
        .booking-item .booking-time { flex-shrink: 0; }
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
                </div>

                <!-- Dashboard Grid: Charts -->
                <div class="dashboard-grid">
                    <!-- Grafik Layanan -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Grafik Layanan Perawatan</h3>
                            <div class="chart-actions">
                                <select id="chartPeriod" onchange="switchChartPeriod()">
                                    <option value="week" {{ request('chart_period') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                                    <option value="month" {{ request('chart_period') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                                    <option value="year" {{ request('chart_period') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-body">
                            <canvas id="chartLayanan" height="280"></canvas>
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
                            <div style="display:grid;gap:8px;">
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
                        <table class="data-table">
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
                        </table>
                    </div>

                    <!-- Produk Sering Digunakan -->
                    <div class="table-widget">
                        <div class="tw-header">
                            <h3>Produk Sering Digunakan</h3>
                        </div>
                        <table class="data-table">
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
                        </table>
                    </div>
                </div>

                <!-- Dashboard Bottom Row -->
                <div class="dashboard-bottom-row">

                    <!-- Produk Favorit -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Produk Favorit Pelanggan</h3>
                        </div>
                        <div class="stock-grid">
                            @forelse($produk_favorit as $item)
                            <div class="stock-item">
                                <div class="stock-icon primary">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /></svg>
                                </div>
                                <div class="stock-info">
                                    <h4>{{ $item->nm_item }}</h4>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill primary" style="width:{{ $maxFavorit > 0 ? round(($item->total / $maxFavorit) * 100) : 0 }}%"></div>
                                </div>
                                <span class="stock-qty">{{ $maxFavorit > 0 ? round(($item->total / $maxFavorit) * 100) : 0 }}%</span>
                            </div>
                            @empty
                            <div style="text-align:center;padding:16px;color:var(--gray);font-size:13px;grid-column:1/-1;">
                                Belum ada data produk favorit
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Booking Mendatang -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Booking Mendatang</h3>
                            <a href="{{ route('beautycian.jadwal-treatment.index') }}" style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div class="booking-list">
                            @forelse($booking_mendatang as $item)
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->pelanggan?->nm_pelanggan ?? 'User') }}&background=FFE5EF&color=FF4F87&size=40" alt="{{ $item->pelanggan?->nm_pelanggan ?? 'User' }}">
                                <div class="booking-info">
                                    <h4>{{ $item->pelanggan?->nm_pelanggan ?? 'Pelanggan #'.$item->id_pelanggan }}</h4>
                                    <p>{{ $item->detail->pluck('layanan.nm_layanan')->implode(', ') ?: '-' }}</p>
                                </div>
                                <span class="booking-time">{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM') }} {{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}</span>
                            </div>
                            @empty
                            <div style="text-align:center;padding:24px;color:var(--gray);font-size:13px;">
                                Tidak ada booking mendatang
                            </div>
                            @endforelse
                        </div>
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

    function initChart(period) {
        const data = allChartData[period];
        if (chartInstance) chartInstance.destroy();

        chartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Layanan Selesai',
                    data: data.values,
                    borderColor: '#FF4F87',
                    backgroundColor: 'rgba(255, 79, 135, 0.08)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#FF4F87',
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
    }

    function switchChartPeriod() {
        const period = document.getElementById('chartPeriod').value;
        initChart(period);
    }

    initChart('{{ request('chart_period', 'week') }}');
    </script>
</body>

</html>
