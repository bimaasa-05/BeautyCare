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
                            <span class="stat-change {{ $pendapatanGrowth >= 0 ? 'up' : 'down' }}">{{ $pendapatanGrowth >= 0 ? '+' : '' }}{{ $pendapatanGrowth }}%</span>
                        </div>
                        <div class="stat-value">{{ $fmt($totalPendapatan) }}</div>
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
                            <span class="stat-change {{ $bookingGrowth >= 0 ? 'up' : 'down' }}">{{ $bookingGrowth >= 0 ? '+' : '' }}{{ $bookingGrowth }}%</span>
                        </div>
                        <div class="stat-value">{{ number_format($totalBooking) }}</div>
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
                            <span class="stat-change {{ $pelangganGrowth >= 0 ? 'up' : 'down' }}">{{ $pelangganGrowth >= 0 ? '+' : '' }}{{ $pelangganGrowth }}%</span>
                        </div>
                        <div class="stat-value">{{ number_format($totalPelanggan) }}</div>
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
                            <span class="stat-change {{ $karyawanGrowth >= 0 ? 'up' : 'down' }}">{{ $karyawanGrowth >= 0 ? '+' : '' }}{{ $karyawanGrowth }}%</span>
                        </div>
                        <div class="stat-value">{{ number_format($totalKaryawan) }}</div>
                        <div class="stat-label">Total Karyawan</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                                </svg>
                            </div>
                            <span class="stat-change {{ $produkTerjualGrowth >= 0 ? 'up' : 'down' }}">{{ $produkTerjualGrowth >= 0 ? '+' : '' }}{{ $produkTerjualGrowth }}%</span>
                        </div>
                        <div class="stat-value">{{ number_format($produkTerjual) }}</div>
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
                                <h3>Jadwal Hari Ini</h3>
                                <span class="mc-total">{{ $jadwalHariIni->count() }}</span>
                            </div>
                            <div class="grid gap-2 sm:gap-2.5">
                                @forelse($jadwalHariIni as $j)
                                <div class="flex flex-wrap sm:flex-nowrap items-center gap-x-2 gap-y-1 text-sm">
                                    <span style="color:var(--primary);font-weight:600;">{{ substr($j->jam, 0, 5) }}</span>
                                    <span style="color:var(--gray);">-</span>
                                    <span class="flex-1 min-w-0">{{ $j->pelanggan->nm_pelanggan ?? 'N/A' }} - {{ $j->detail->first()->layanan->nm_layanan ?? 'Booking' }}</span>
                                    @php
                                        $badge = match($j->status) {
                                            'Confirmed', 'Dikonfirmasi' => 'badge-success',
                                            'Pending', 'Menunggu' => 'badge-warning',
                                            'Completed', 'Selesai' => 'badge-info',
                                            'Dibatalkan' => 'badge-danger',
                                            default => 'badge-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ $j->status }}</span>
                                </div>
                                @empty
                                <div style="text-align:center;padding:16px;color:var(--gray);font-size:13px;">Tidak ada jadwal untuk hari ini</div>
                                @endforelse
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
                                    <th>Layanan</th>
                                    <th>Terjual</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($layananTerlaris as $lt)
                                <tr>
                                    <td data-label="Layanan">
                                        <div class="td-flex">{{ $lt->nm_item }}</div>
                                    </td>
                                    <td data-label="Terjual">{{ $lt->total_qty }}</td>
                                    <td data-label="Pendapatan">{{ $fmt($lt->total_subtotal) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td data-label="Layanan" colspan="3" style="text-align:center;color:var(--gray);">Belum ada data transaksi</td>
                                </tr>
                                @endforelse
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
                                    <th>Produk</th>
                                    <th>Terjual</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produkTerlaris as $pt)
                                <tr>
                                    <td data-label="Produk">
                                        <div class="td-flex">{{ $pt->nm_item }}</div>
                                    </td>
                                    <td data-label="Terjual">{{ $pt->total_qty }}</td>
                                    <td data-label="Pendapatan">{{ $fmt($pt->total_subtotal) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td data-label="Produk" colspan="3" style="text-align:center;color:var(--gray);">Belum ada data transaksi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Dashboard Bottom Row -->
                <div class="dashboard-bottom-row grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                    <!-- Karyawan Aktif -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Karyawan Aktif</h3>
                            <a href="{{ route('admin.beautician.index') }}" style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div class="employee-grid">
                            @forelse($karyawanAktif as $k)
                            <div class="employee-card">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($k->user->nama ?? 'Karyawan') }}&background=FFE5EF&color=FF4F87&size=36"
                                    alt="{{ $k->user->nama ?? 'Karyawan' }}">
                                <div class="ec-info">
                                    <h4>{{ $k->user->nama ?? 'Karyawan' }}</h4>
                                    <p>{{ $k->jabatan }}</p>
                                </div>
                                <span class="ec-status online"></span>
                            </div>
                            @empty
                            <div style="text-align:center;padding:16px;color:var(--gray);font-size:13px;grid-column:1/-1;">Tidak ada karyawan aktif</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Ringkasan Stok -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Ringkasan Stok</h3>
                            <a href="{{ route('admin.produk.index') }}" style="font-size:13px;color:var(--primary);font-weight:500;">Kelola</a>
                        </div>
                        <div class="stock-grid">
                            @forelse($ringkasanStok as $s)
                            @php
                                $maxStok = max(50, $s->stok);
                                $pct = round(($s->stok / $maxStok) * 100);
                                if ($s->stok <= 0) { $color = 'danger'; $pct = 0; }
                                elseif ($s->stok <= 10) { $color = 'info'; }
                                elseif ($s->stok <= 20) { $color = 'warning'; }
                                else { $color = 'success'; }
                            @endphp
                            <div class="stock-item">
                                <div class="stock-icon {{ $color }}">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                    </svg>
                                </div>
                                <div class="stock-info">
                                    <h4>{{ $s->nm_produk }}</h4>
                                    <p>{{ $s->kategori->nm_produk ?? 'Tanpa Kategori' }}</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill {{ $color }}" style="width:{{ $pct }}%"></div>
                                </div>
                                <span class="stock-qty">{{ $s->stok }}</span>
                            </div>
                            @empty
                            <div style="text-align:center;padding:16px;color:var(--gray);font-size:13px;grid-column:1/-1;">Tidak ada produk</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Booking Terbaru -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Booking Terbaru</h3>
                            <a href="{{ route('admin.reservasi.index') }}" style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div class="booking-list">
                            @forelse($bookingTerbaru as $b)
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($b->pelanggan->nm_pelanggan ?? 'Customer') }}&background=FFE5EF&color=FF4F87&size=40"
                                    alt="{{ $b->pelanggan->nm_pelanggan ?? 'Customer' }}">
                                <div class="booking-info">
                                    <h4>{{ $b->pelanggan->nm_pelanggan ?? 'N/A' }}</h4>
                                    <p>{{ $b->detail->first()->layanan->nm_layanan ?? 'Booking' }}</p>
                                </div>
                                <span class="booking-time">{{ \Carbon\Carbon::parse($b->tanggal)->format('d/m') }} {{ substr($b->jam, 0, 5) }}</span>
                            </div>
                            @empty
                            <div style="text-align:center;padding:16px;color:var(--gray);font-size:13px;">Belum ada booking</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

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
    new Chart(ctx, {
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
                        }
                    }
                }
            }
        }
    });

    const donutCanvas = document.getElementById('chartBookingDonut');
    if (donutCanvas) {
        const values = JSON.parse(donutCanvas.getAttribute('data-values') || '[]');
        const labels = JSON.parse(donutCanvas.getAttribute('data-labels') || '[]');
        const colors = ['#EC4899','#8B5CF6','#F59E0B','#10B981','#3B82F6','#EF4444','#14B8A6','#F97316','#6366F1','#84CC16'];
        if (values.length > 0) {
            new Chart(donutCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors.slice(0, labels.length),
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
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
            donutCanvas.parentNode.innerHTML = '<span style="font-size:12px;color:#999;">Tidak ada data</span>';
        }
    }
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>