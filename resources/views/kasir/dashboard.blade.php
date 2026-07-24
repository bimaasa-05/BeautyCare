<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Kasir - BeautyCare</title>
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
        select.form-input-custom {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
            border: 1.5px solid #ECECEC;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 13px;
            width: 100%;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            background-color: #fff;
            cursor: pointer;
        }
        select.form-input-custom:focus {
            border-color: #FF4F87;
            box-shadow: 0 0 0 3px rgba(255,79,135,0.12);
            outline: none;
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

        .status-menunggu {
            color: #F59E0B;
        }

        .status-dikonfirmasi {
            color: #3B82F6;
        }

        .status-diproses {
            color: #8B5CF6;
        }

        .status-selesai {
            color: #22C55E;
        }

        .status-dibatalkan {
            color: #EF4444;
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="8.5" cy="7" r="4" />
                                </svg>
                            </div>
                            <span
                                class="stat-change {{ $pelangganGrowth >= 0 ? 'up' : 'down' }}">{{ $pelangganGrowth >= 0 ? '+' : '' }}{{ $pelangganGrowth }}%</span>
                        </div>
                        <div class="stat-value">{{ $pelangganHariIni }}</div>
                        <div class="stat-label">Pelanggan</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                                </svg>
                            </div>
                            <span
                                class="stat-change {{ $pendingGrowth >= 0 ? 'up' : 'down' }}">{{ $pendingGrowth >= 0 ? '+' : '' }}{{ $pendingGrowth }}%</span>
                        </div>
                        <div class="stat-value">{{ $pesananPending }}</div>
                        <div class="stat-label">Pesanan</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
                                    <line x1="8" y1="21" x2="16" y2="21" />
                                    <line x1="12" y1="17" x2="12" y2="21" />
                                </svg>
                            </div>
                            <span
                                class="stat-change {{ $produkTerjualGrowth >= 0 ? 'up' : 'down' }}">{{ $produkTerjualGrowth >= 0 ? '+' : '' }}{{ $produkTerjualGrowth }}%</span>
                        </div>
                        <div class="stat-value">{{ $produkTerjual }}</div>
                        <div class="stat-label">Produk</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                    <line x1="16" y1="13" x2="8" y2="13" />
                                    <line x1="16" y1="17" x2="8" y2="17" />
                                </svg>
                            </div>
                            <span
                                class="stat-change {{ $transaksiGrowth >= 0 ? 'up' : 'down' }}">{{ $transaksiGrowth >= 0 ? '+' : '' }}{{ $transaksiGrowth }}%</span>
                        </div>
                        <div class="stat-value">{{ $transaksiHariIni }}</div>
                        <div class="stat-label">Transaksi Hari Ini</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon success">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                </svg>
                            </div>
                            <span
                                class="stat-change {{ $pendapatanGrowth >= 0 ? 'up' : 'down' }}">{{ $pendapatanGrowth >= 0 ? '+' : '' }}{{ $pendapatanGrowth }}%</span>
                        </div>
                        <div class="stat-value">{{ $fmt($pendapatanHariIni) }}</div>
                        <div class="stat-label">Pendapatan Hari Ini</div>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Grafik Penjualan
                                {{ $periode == 'bulanini' ? 'Bulan Ini' : ($periode == 'tahunini' ? '1 Tahun' : ($periode == '30hari' ? '30 Hari' : '7 Hari')) }}
                            </h3>
                            <div class="chart-actions">
                                <select id="periodSelect" class="form-input-custom" onchange="changeSalesPeriod(this.value)">
                                    <option value="7hari" {{ $periode == '7hari' ? 'selected' : '' }}>7 Hari</option>
                                    <option value="30hari" {{ $periode == '30hari' ? 'selected' : '' }}>30 Hari
                                    </option>
                                    <option value="bulanini" {{ $periode == 'bulanini' ? 'selected' : '' }}>Bulan Ini
                                    </option>
                                    <option value="tahunini" {{ $periode == 'tahunini' ? 'selected' : '' }}>1 Tahun
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-body">
                            <canvas id="chartPendapatan" height="280"></canvas>
                        </div>
                    </div>

                    <div class="mini-charts">
                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Metode Pembayaran</h3>
                                <div class="chart-actions">
                                <select id="paymentPeriodSelect" class="form-input-custom" onchange="changePaymentPeriod(this.value)">
                                        <option value="7hari" {{ $paymentPeriode == '7hari' ? 'selected' : '' }}>7
                                            Hari
                                        </option>
                                        <option value="30hari" {{ $paymentPeriode == '30hari' ? 'selected' : '' }}>30
                                            Hari
                                        </option>
                                        <option value="bulanini"
                                            {{ $paymentPeriode == 'bulanini' ? 'selected' : '' }}>Bulan
                                            Ini</option>
                                        <option value="tahunini"
                                            {{ $paymentPeriode == 'tahunini' ? 'selected' : '' }}>1 Tahun
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="mc-body"
                                style="display:flex;justify-content:center;align-items:center;height:200px;position:relative;">
                                <canvas id="chartPembayaran"></canvas>
                            </div>
                        </div>

                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Transaksi Terbaru</h3>
                                <span class="mc-total">{{ $transaksiTerbaru->count() }}</span>
                            </div>
                            <div style="display:grid;gap:8px;">
                                @forelse($transaksiTerbaru as $t)
                                    <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                        <span
                                            style="color:var(--primary);font-weight:600;">{{ $t->no_invoice }}</span>
                                        <span style="flex:1;">{{ $t->pelanggan->nm_pelanggan ?? 'Umum' }}</span>
                                        <span style="font-weight:500;color:var(--dark);">{{ $fmt($t->total) }}</span>
                                        <span
                                            class="badge {{ $t->status == 'Lunas' ? 'badge-success' : ($t->status == 'Pending' ? 'badge-warning' : 'badge-danger') }}">{{ $t->status }}</span>
                                    </div>
                                @empty
                                    <div style="text-align:center;padding:16px;color:var(--gray);font-size:13px;">Belum
                                        ada transaksi hari ini</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-bottom-grid">
                    <div class="table-widget">
                        <div class="tw-header">
                            <h3>Produk & Layanan Terlaris</h3>
                            <a href="{{ route('kasir.transaksi.index') }}">Lihat Semua</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Tipe</th>
                                    <th>Terjual</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produkTerlaris as $p)
                                    <tr>
                                        <td>
                                            <div class="td-flex">{{ $p->nm_item }}</div>
                                        </td>
                                        <td>{{ $p->jenis }}</td>
                                        <td>{{ $p->total_qty }}</td>
                                        <td>{{ $fmt($p->total_subtotal) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center;padding:20px;color:var(--gray);">
                                            Belum ada data penjualan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="table-widget">
                        <div class="tw-header">
                            <h3>Rekap Pembayaran</h3>
                            <a href="{{ route('kasir.laporan.index') }}">Detail</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Metode</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekapPembayaran as $r)
                                    <tr>
                                        <td>
                                            <div class="td-flex">{{ $r->metode_byr }}</div>
                                        </td>
                                        <td>{{ $r->jumlah }}</td>
                                        <td>{{ $fmt($r->total) }}</td>
                                        <td><span class="badge badge-success">Aktif</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center;padding:20px;color:var(--gray);">
                                            Belum ada pembayaran hari ini</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="dashboard-bottom-row">
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Pesanan Check-In</h3>
                            <a href="{{ route('kasir.checkin.index') }}"
                                style="font-size:13px;color:var(--primary);font-weight:500;">Proses</a>
                        </div>
                        <div class="booking-list">
                            @forelse($checkinHariIni as $b)
                                <div class="booking-item">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($b->pelanggan->nm_pelanggan ?? 'Unknown') }}&background=FFE5EF&color=FF4F87&size=40"
                                        alt="{{ $b->pelanggan->nm_pelanggan ?? '-' }}">
                                    <div class="booking-info">
                                        <h4>{{ $b->pelanggan->nm_pelanggan ?? '-' }}</h4>
                                        <p>{{ $b->detail->pluck('layanan.nm_layanan')->implode(', ') ?: 'Tanpa detail' }}
                                        </p>
                                    </div>
                                    <span
                                        class="booking-time">{{ $b->jam ? \Carbon\Carbon::parse($b->jam)->format('H:i') : '-' }}</span>
                                </div>
                            @empty
                                <div style="text-align:center;padding:24px;color:var(--gray);font-size:13px;">
                                    Tidak ada jadwal check-in hari ini
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Riwayat Transaksi</h3>
                            <a href="{{ route('kasir.riwayat-transaksi.index') }}"
                                style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div class="employee-grid">
                            @forelse($riwayatTransaksi as $t)
                                <div class="employee-card" style="grid-template-columns:36px 1fr auto;">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($t->no_invoice) }}&background={{ $t->status == 'Lunas' ? 'E8F5E9&color=4CAF50' : ($t->status == 'Pending' ? 'FFF3E0&color=FF9800' : 'FFEBEE&color=F44336') }}&size=36"
                                        alt="TRX">
                                    <div class="ec-info">
                                        <h4>{{ $t->no_invoice }} - {{ $t->pelanggan->nm_pelanggan ?? 'Umum' }}</h4>
                                        <p>{{ $t->metode_byr }} - {{ $fmt($t->total) }}</p>
                                    </div>
                                    <span
                                        style="font-size:11px;color:var(--gray);">{{ $t->created_at ? \Carbon\Carbon::parse($t->created_at)->format('H:i') : '-' }}</span>
                                </div>
                            @empty
                                <div style="text-align:center;padding:24px;color:var(--gray);font-size:13px;">
                                    Belum ada transaksi
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Notifikasi Stok</h3>
                            <a href="#" style="font-size:13px;color:var(--primary);font-weight:500;">Kelola</a>
                        </div>
                        <div class="stock-grid">
                            @forelse($stokMenipis as $p)
                                @php
                                    $stok = (int) $p->stok;
                                    if ($stok <= 0) {
                                        $iconClass = 'danger';
                                        $barClass = 'danger';
                                        $barW = 0;
                                    } elseif ($stok <= 10) {
                                        $iconClass = 'danger';
                                        $barClass = 'danger';
                                        $barW = max(5, ($stok / 50) * 100);
                                    } elseif ($stok <= 20) {
                                        $iconClass = 'warning';
                                        $barClass = 'warning';
                                        $barW = ($stok / 50) * 100;
                                    } else {
                                        $iconClass = 'success';
                                        $barClass = 'success';
                                        $barW = min(100, ($stok / 50) * 100);
                                    }
                                @endphp
                                <div class="stock-item">
                                    <div class="stock-icon {{ $iconClass }}">
                                        @if ($stok <= 0)
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10" />
                                                <line x1="15" y1="9" x2="9" y2="15" />
                                                <line x1="9" y1="9" x2="15" y2="15" />
                                            </svg>
                                        @elseif ($stok <= 20)
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path
                                                    d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                                <line x1="12" y1="9" x2="12" y2="13" />
                                                <line x1="12" y1="17" x2="12.01" y2="17" />
                                            </svg>
                                        @else
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                                <polyline points="22 4 12 14.01 9 11.01" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="stock-info">
                                        <h4>{{ $p->nm_produk }}</h4>
                                        <p>{{ $p->kategori->nm_kategori ?? 'Uncategorized' }} - Sisa
                                            {{ $stok }}</p>
                                    </div>
                                    <div class="stock-bar">
                                        <div class="fill {{ $barClass }}" style="width:{{ $barW }}%">
                                        </div>
                                    </div>
                                    <span class="stock-qty">{{ $stok }}</span>
                                </div>
                            @empty
                                <div style="text-align:center;padding:24px;color:var(--gray);font-size:13px;">
                                    Semua stok dalam kondisi baik
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function changeSalesPeriod(value) {
            var url = '{{ route('kasir.dashboard') }}?periode=' + value;
            var pp = '{{ $paymentPeriode ?? '7hari' }}';
            url += '&payment_periode=' + pp;
            window.location.href = url;
        }

        function changePaymentPeriod(value) {
            var url = '{{ route('kasir.dashboard') }}?payment_periode=' + value;
            var p = '{{ $periode ?? '7hari' }}';
            url += '&periode=' + p;
            window.location.href = url;
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

        const chartLabels = @json($chartLabels);
        const chartRevenue = @json($chartRevenue);
        const paymentLabels = @json($paymentLabels);
        const paymentValues = @json($paymentValues);

        const maxRev = chartRevenue.length > 0 ? Math.max(...chartRevenue) : 0;

        Chart.defaults.font.family = "'Poppins', sans-serif";
        Chart.defaults.color = '#9CA3AF';
        Chart.defaults.font.size = 11;

        const paymentColors = ['#22C55E', '#3B82F6', '#F59E0B', '#8B5CF6', '#EC4899', '#EF4444'];

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
                    legend: {
                        display: false
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
                                var val = context.parsed.y;
                                if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(1) + ' jt';
                                return 'Rp ' + val.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: Math.min(chartLabels.length, 10)
                        }
                    },
                    y: {
                        border: {
                            display: false
                        },
                        grid: {
                            color: '#F3E8F5',
                            borderDash: [3, 3]
                        },
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

        const ctxPayment = document.getElementById('chartPembayaran');
        if (ctxPayment && paymentLabels.length > 0) {
            new Chart(ctxPayment.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: paymentLabels,
                    datasets: [{
                        data: paymentValues,
                        backgroundColor: paymentColors.slice(0, paymentLabels.length),
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '65%',
                    animation: {
                        animateRotate: true,
                        duration: 2000,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    family: 'Poppins',
                                    size: 11
                                },
                                color: '#6B7280',
                                padding: 12,
                                usePointStyle: true,
                                pointStyle: 'rectRot'
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
        } else if (ctxPayment) {
            ctxPayment.parentNode.innerHTML = '<span style="font-size:12px;color:#999;">Belum ada data</span>';
        }
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
