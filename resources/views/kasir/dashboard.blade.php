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
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') . '?v=3' }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/dropdown.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        /* unified period dropdown — dari beautycian/dashboard.blade.php:39-112 */
        .chart-actions { flex-shrink: 0; }

        .chart-card .chart-actions {
            flex-shrink: 0;
        }

        .chart-card .chart-header {
            flex-wrap: wrap;
            gap: 10px;
        }

        .chart-body {
            position: relative;
            width: 100%;
            height: 420px;
            min-height: 420px;
            flex: 1 1 auto;
        }

        .chart-body canvas {
            display: block;
            width: 100% !important;
            height: 100% !important;
        }

        .chart-empty-msg {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #999;
        }

        .mini-chart-card .mc-body {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 200px;
        }

        .card-scroll {
            max-height: 320px;
            overflow-y: auto;
        }

        .table-scroll {
            max-height: 320px;
            overflow-y: auto;
        }

        .table-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .table-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .table-scroll::-webkit-scrollbar-thumb {
            background: #FBCFE8;
            border-radius: 10px;
        }

        .table-scroll::-webkit-scrollbar-thumb:hover {
            background: #F9A8D4;
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
                                {{ $periode == '30hari' ? '30 Hari' : ($periode == '3bulan' ? '3 Bulan' : ($periode == 'tahunini' ? '1 Tahun' : '7 Hari')) }}
                            </h3>
                            <div class="chart-actions">
                                <div style="position:relative;" id="salesPeriodWrap">
                                    <button type="button" class="period-trigger" id="salesPeriodTrigger">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        <span id="salesPeriodLabel">{{ $periode == '30hari' ? '30 Hari' : ($periode == '3bulan' ? '3 Bulan' : ($periode == 'tahunini' ? 'Tahun Ini' : '7 Hari')) }}</span>
                                        <i class="fa-solid fa-chevron-down period-arrow"></i>
                                    </button>
                                    <div class="period-popup" id="salesPeriodPopup">
                                        <div class="pp-header">
                                            <span class="pp-icon"><i class="fa-solid fa-chart-line"></i></span>
                                            <h4>Periode Grafik</h4>
                                        </div>
                                        <div id="salesPeriodOptions" class="pp-options"></div>
                                        <div class="pp-footer">
                                            <button type="button" class="pp-today" id="salesPeriodReset"><i class="fa-solid fa-arrow-rotate-left"></i> Reset</button>
                                            <button type="button" class="pp-oke" id="salesPeriodOke"><i class="fa-solid fa-check"></i> Oke</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chart-body">
                            <canvas id="chartPendapatan"></canvas>
                            <span id="salesEmptyMsg" class="chart-empty-msg" style="display:none;">Belum ada data penjualan</span>
                        </div>
                    </div>

                    <div class="mini-charts">
                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Metode Pembayaran</h3>
                                <div class="chart-actions">
                                    <div style="position:relative;" id="paymentPeriodWrap">
                                        <button type="button" class="period-trigger" id="paymentPeriodTrigger">
                                            <i class="fa-solid fa-calendar-days"></i>
                                            <span id="paymentPeriodLabel">{{ $paymentPeriode == '30hari' ? '30 Hari' : ($paymentPeriode == '3bulan' ? '3 Bulan' : ($paymentPeriode == 'tahunini' ? 'Tahun Ini' : '7 Hari')) }}</span>
                                            <i class="fa-solid fa-chevron-down period-arrow"></i>
                                        </button>
                                        <div class="period-popup" id="paymentPeriodPopup">
                                            <div class="pp-header">
                                                <span class="pp-icon"><i class="fa-solid fa-chart-line"></i></span>
                                                <h4>Periode Pembayaran</h4>
                                            </div>
                                            <div id="paymentPeriodOptions" class="pp-options"></div>
                                            <div class="pp-footer">
                                                <button type="button" class="pp-today" id="paymentPeriodReset"><i class="fa-solid fa-arrow-rotate-left"></i> Reset</button>
                                                <button type="button" class="pp-oke" id="paymentPeriodOke"><i class="fa-solid fa-check"></i> Oke</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mc-body">
                                <canvas id="chartPembayaran" style="max-width:220px;max-height:220px;"></canvas>
                                <span id="paymentEmptyMsg" style="display:none;font-size:12px;color:#999;">Belum ada
                                    data</span>
                            </div>
                        </div>

                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Transaksi Terbaru</h3>
                                <span class="mc-total">{{ $transaksiTerbaru->count() }}</span>
                            </div>
                            <div class="card-scroll" style="display:grid;gap:8px;">
                                @forelse($transaksiTerbaru as $t)
                                    <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                        <span
                                            style="color:var(--primary);font-weight:600;">{{ $t->no_invoice }}</span>
                                        <span style="flex:1;">{{ $t->pelanggan->nm_pelanggan ?? 'Umum' }}</span>
                                        <span style="font-weight:500;color:var(--dark);">{{ $fmt($t->total) }}</span>
                                <span
                                    class="badge {{ in_array($t->status, ['Lunas', 'DP Dibayar', 'Selesai']) ? 'badge-success' : (in_array($t->status, ['Batal', 'Gagal', 'Dibatalkan', 'Kadaluarsa']) ? 'badge-danger' : 'badge-warning') }}">{{ $t->status }}</span>
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
                        <div class="table-scroll">
                            <div class="overflow-x-auto"><table class="data-table table-card-mobile">
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
                                            <td data-label="Item">
                                                <div class="td-flex">{{ $p->nm_item }}</div>
                                            </td>
                                            <td data-label="Tipe">{{ $p->jenis }}</td>
                                            <td data-label="Terjual">{{ $p->total_qty }}</td>
                                            <td data-label="Total">{{ $fmt($p->total_subtotal) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                style="text-align:center;padding:20px;color:var(--gray);">
                                                Belum ada data penjualan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table></div>
                        </div>
                    </div>

                    <div class="table-widget">
                        <div class="tw-header">
                            <h3>Rekap Pembayaran</h3>
                            <a href="{{ route('kasir.laporan.index') }}">Detail</a>
                        </div>
                        <div class="table-scroll">
                            <div class="overflow-x-auto"><table class="data-table table-card-mobile">
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
                                            <td data-label="Metode">
                                                <div class="td-flex">{{ $r->metode_byr }}</div>
                                            </td>
                                            <td data-label="Jumlah">{{ $r->jumlah }}</td>
                                            <td data-label="Total">{{ $fmt($r->total) }}</td>
                                            <td data-label="Status"><span class="badge badge-success">Aktif</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                style="text-align:center;padding:20px;color:var(--gray);">
                                                Belum ada pembayaran hari ini</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table></div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-bottom-row">
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Pesanan Check-In</h3>
                            <a href="{{ route('kasir.checkin.index') }}"
                                style="font-size:13px;color:var(--primary);font-weight:500;">Proses</a>
                        </div>
                        <div class="booking-list card-scroll">
                            @forelse($checkinHariIni as $b)
                                <div class="booking-item">
                                    <img src="{{ $b->pelanggan?->foto_url ?? 'https://ui-avatars.com/api/?name=Unknown&background=FFE5EF&color=FF4F87&size=40' }}"
                                        alt="{{ $b->pelanggan?->nm_pelanggan ?? '-' }}" class="booking-avatar" style="width:40px;height:40px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                                    <div class="booking-info">
                                        <h4>{{ $b->pelanggan?->nm_pelanggan ?? '-' }}</h4>
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
                        <div class="employee-grid card-scroll">
                            @forelse($riwayatTransaksi as $t)
                                <div class="employee-card" style="grid-template-columns:36px 1fr auto;">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($t->no_invoice) }}&background={{ $t->status == 'Lunas' ? 'E8F5E9&color=4CAF50' : ($t->status == 'Pending' ? 'FFF3E0&color=FF9800' : 'FFEBEE&color=F44336') }}&size=36"
                                        alt="TRX">
                                    <div class="ec-info">
                                            <h4>{{ $t->no_invoice }} - {{ $t->pelanggan?->nm_pelanggan ?? 'Umum' }}</h4>
                                        <p>{{ $t->metode_byr }} - {{ $fmt($t->total) }}</p>
                                    </div>
                                    <span
                                        style="font-size:11px;color:var(--gray);">{{ $t->tanggal ? \Carbon\Carbon::parse($t->tanggal)->format('d/m') : '-' }}</span>
                                </div>
                            @empty
                                <div style="text-align:center;padding:24px;color:var(--gray);font-size:13px;">
                                    Belum ada transaksi
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="list-widget" style="max-height:440px;display:flex;flex-direction:column;">
                            <div class="lw-header">
                                <h3>Notifikasi Stok</h3>
                                <span style="font-size:13px;color:var(--gray);font-weight:500;cursor:default;">Kelola</span>
                            </div>
                        <div class="stock-grid card-scroll" style="flex:1;">
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
                                        <p>{{ $p->kategori && $p->kategori->nm_kategori ? $p->kategori->nm_kategori : 'Tidak Berkategori' }} - Sisa {{ $stok }}</p>
                                            {{ $stok }}</p>
                                    </div>
                                    <div class="stock-bar">
                                        <div class="fill {{ $barClass }}" style="width:{{ $barW }}%">
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="stock-qty">{{ $stok }}</span>
                                        @if ($stok <= 0)
                                            <span class="text-[10px] font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded-full">HABIS</span>
                                        @endif
                                    </div>
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

    <script src="{{ asset('assets/js/components/dropdown.js') }}"></script>
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

        const allSalesChartData = @json($salesChartData);
        const allPaymentChartData = @json($paymentChartData);

        const salesChartLabels = @json($chartLabels);
        const salesChartRevenue = @json($chartRevenue);
        const paymentLabels = @json($paymentLabels);
        const paymentValues = @json($paymentValues);

        Chart.defaults.font.family = "'Poppins', sans-serif";
        Chart.defaults.color = '#9CA3AF';
        Chart.defaults.font.size = 10;

        const doughnutColors = ['#EC4899', '#8B5CF6', '#F59E0B', '#10B981', '#3B82F6', '#EF4444'];

        let salesChartInstance = null;
        let paymentChartInstance = null;

        function initSalesChart(labels, revenue) {
            const ctx = document.getElementById('chartPendapatan').getContext('2d');
            const max = revenue.length > 0 ? Math.max(...revenue) : 0;
            const stagger = labels.length > 0 ? 1600 / labels.length : 0;
            const canvas = document.getElementById('chartPendapatan');
            const emptyMsg = document.getElementById('salesEmptyMsg');
            const isEmpty = labels.length === 0 || revenue.every(v => Number(v) === 0);
            if (salesChartInstance) salesChartInstance.destroy();
            if (isEmpty) {
                if (canvas) canvas.style.display = 'none';
                if (emptyMsg) emptyMsg.style.display = 'flex';
                salesChartInstance = null;
                return;
            }
            if (canvas) canvas.style.display = 'block';
            if (emptyMsg) emptyMsg.style.display = 'none';
            salesChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: revenue,
                        backgroundColor: '#8B5CF6',
                        borderRadius: { topLeft: 6, topRight: 6 },
                        barPercentage: 0.55,
                        categoryPercentage: 0.75,
                        maxBarThickness: 50
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: { padding: { left: 0, right: 0, top: 0, bottom: 0 } },
                    animation: {
                        y: {
                            type: 'number',
                            easing: 'easeOutQuart',
                            duration: 700,
                            from: 0,
                            delay: function(ctx) {
                                if (ctx.type !== 'data' || ctx.yStarted) return 0;
                                ctx.yStarted = true;
                                return ctx.dataIndex * stagger;
                            }
                        }
                    },
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
                            displayColors: false,
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
                                autoSkip: true,
                                maxRotation: 45,
                                minRotation: 0,
                                maxTicksLimit: 12
                            }
                        },
                        y: {
                            border: {
                                display: false
                            },
                            beginAtZero: true,
                            grace: '6%',
                            grid: {
                                color: '#F9EEF4',
                                borderDash: [3, 3],
                                drawTicks: false
                            },
                            ticks: {
                                maxTicksLimit: 5,
                                maxWidth: 70,
                                padding: 6,
                                callback: function(value) {
                                    if (max >= 1000000000) return (value / 1000000000).toFixed(1) + 'M';
                                    if (max >= 1000000) return (value / 1000000).toFixed(1) + 'jt';
                                    if (max >= 1000) return (value / 1000).toFixed(0) + 'rb';
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
        }

        function initPaymentChart(labels, values) {
            const canvas = document.getElementById('chartPembayaran');
            const emptyMsg = document.getElementById('paymentEmptyMsg');
            if (paymentChartInstance) paymentChartInstance.destroy();
            if (labels.length === 0) {
                if (canvas) canvas.style.display = 'none';
                if (emptyMsg) emptyMsg.style.display = 'block';
                return;
            }
            if (canvas) canvas.style.display = 'block';
            if (emptyMsg) emptyMsg.style.display = 'none';
            const ctx = canvas.getContext('2d');
            paymentChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: doughnutColors.slice(0, labels.length),
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    animation: {
                        animateRotate: true,
                        duration: 1000
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    family: 'Poppins',
                                    size: 10
                                },
                                color: '#6B7280',
                                padding: 12,
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
                                    const total = context.dataset.data.reduce(function(a, b) { return a + b; }, 0);
                                    const pct = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                                    return ' ' + context.label + ': ' + context.parsed + ' (' + pct + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }

        function updateSalesChart(period) {
            const data = allSalesChartData[period];
            if (!data) return;
            const periodNames = { '7hari': '7 Hari', '30hari': '30 Hari', '3bulan': '3 Bulan', 'tahunini': '1 Tahun' };
            const wrap = document.getElementById('salesPeriodWrap');
            const heading = wrap ? wrap.closest('.chart-card').querySelector('.chart-header h3') : document.querySelector('.chart-card .chart-header h3');
            if (heading) heading.textContent = 'Grafik Penjualan ' + (periodNames[period] || period);
            initSalesChart(data.labels, data.values);
            fitSalesChart();
        }

        function updatePaymentChart(period) {
            const data = allPaymentChartData[period];
            if (!data) return;
            const periodNames = { '7hari': '7 Hari', '30hari': '30 Hari', '3bulan': '3 Bulan', 'tahunini': '1 Tahun' };
            const wrap = document.getElementById('paymentPeriodWrap');
            const heading = wrap ? wrap.closest('.mini-chart-card').querySelector('.mc-header h3') : document.querySelector('.mini-chart-card .mc-header h3');
            if (heading) heading.textContent = 'Metode Pembayaran ' + (periodNames[period] || period);
            initPaymentChart(data.labels, data.values);
            fitPaymentChart();
        }

        // ——— Unified fitChart (dari fix grafik sebelumnya) ———
        function fitChart(canvasId, getInstance) {
            const canvas = document.getElementById(canvasId);
            const inst = getInstance();
            if (!canvas || !inst) return;
            const rect = canvas.parentElement.getBoundingClientRect();
            if (rect.width <= 0 || rect.height <= 0) return;
            const w = Math.round(rect.width);
            const h = Math.round(rect.height);
            const cur = canvas.getBoundingClientRect();
            if (Math.abs(cur.width - w) <= 2 && Math.abs(cur.height - h) <= 2) return;
            const dpr = window.devicePixelRatio || 1;
            canvas.width = Math.round(w * dpr);
            canvas.height = Math.round(h * dpr);
            canvas.style.width = w + 'px';
            canvas.style.height = h + 'px';
            const yScale = inst.scales && inst.scales.y;
            if (yScale && yScale.width > 0) {
                inst.options.layout = inst.options.layout || {};
                inst.options.layout.padding = inst.options.layout.padding || {};
                inst.options.layout.padding.left = 0;
                inst.options.layout.padding.right = Math.ceil(yScale.width) + 8;
            }
            inst.resize(w, h);
        }
        function fitSalesChart(){ fitChart('chartPendapatan', function(){ return salesChartInstance; }); }
        function fitPaymentChart(){ fitChart('chartPembayaran', function(){ return paymentChartInstance; }); }
        function fitAllCharts(){ fitSalesChart(); fitPaymentChart(); }
        function bindChartResize(canvasId, getInstance){
            const canvas = document.getElementById(canvasId);
            if (!canvas || !canvas.parentElement || typeof ResizeObserver === 'undefined') return;
            new ResizeObserver(function(){ fitChart(canvasId, getInstance); }).observe(canvas.parentElement);
        }
        function watchChartSize(canvasId, getInstance){
            let checks=0; const timer=setInterval(function(){
                const canvas=document.getElementById(canvasId); const inst=getInstance();
                if(canvas&&inst){
                    const rect=canvas.parentElement.getBoundingClientRect();
                    const cur=canvas.getBoundingClientRect();
                    if(Math.abs(cur.height-rect.height)>2||Math.abs(cur.width-rect.width)>2) fitChart(canvasId,getInstance);
                }
                checks++; if(checks>=8) clearInterval(timer);
            },1000);
        }

        initSalesChart(salesChartLabels, salesChartRevenue);
        initPaymentChart(paymentLabels, paymentValues);

        // ——— Unified period dropdown (beautycian pattern) ———
        const kasirPeriodConfig = [
            {key:'7hari', title:'7 Hari', sub:'7 hari terakhir'},
            {key:'30hari', title:'30 Hari', sub:'30 hari terakhir'},
            {key:'3bulan', title:'3 Bulan', sub:'3 bulan terakhir'},
            {key:'tahunini', title:'Tahun Ini', sub:'1 Jan - hari ini'}
        ];
        initPeriodDropdown({
            wrapId:'salesPeriodWrap', triggerId:'salesPeriodTrigger', popupId:'salesPeriodPopup',
            optionsId:'salesPeriodOptions', labelId:'salesPeriodLabel', resetId:'salesPeriodReset', okeId:'salesPeriodOke',
            defaultValue:'{{ $periode }}', periodConfig:kasirPeriodConfig, onChange:updateSalesChart
        });
        initPeriodDropdown({
            wrapId:'paymentPeriodWrap', triggerId:'paymentPeriodTrigger', popupId:'paymentPeriodPopup',
            optionsId:'paymentPeriodOptions', labelId:'paymentPeriodLabel', resetId:'paymentPeriodReset', okeId:'paymentPeriodOke',
            defaultValue:'{{ $paymentPeriode }}', periodConfig:kasirPeriodConfig, onChange:updatePaymentChart
        });

        bindChartResize('chartPendapatan', function(){ return salesChartInstance; });
        bindChartResize('chartPembayaran', function(){ return paymentChartInstance; });
        requestAnimationFrame(fitAllCharts);
        setTimeout(fitAllCharts, 300);
        if (document.fonts && document.fonts.ready) document.fonts.ready.then(fitAllCharts);
        window.addEventListener('load', fitAllCharts);
        window.addEventListener('resize', fitAllCharts);
        watchChartSize('chartPendapatan', function(){ return salesChartInstance; });
        watchChartSize('chartPembayaran', function(){ return paymentChartInstance; });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
