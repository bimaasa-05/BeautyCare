<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BeautyCare</title>

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

    .table-widget .table-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .table-widget .table-scroll::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 10px;
    }

    .table-widget .table-scroll::-webkit-scrollbar-thumb:hover {
        background: #bbb;
    }

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

    @media (max-width: 768px) {
        .sidebar-toggle {
            display: flex;
            align-items: center;
        }
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
                            <span class="stat-change up">{{ $totalBooking }}</span>
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
                            <span class="stat-change up">{{ $bookingAktif }}</span>
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
                            <span class="stat-change up">{{ $riwayatTreatment }}</span>
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
                            <span class="stat-change up">{{ $kunjunganBulanIni }}</span>
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
                                <select id="chartPeriod">
                                    <option value="3">3 Bulan</option>
                                    <option value="6">6 Bulan</option>
                                    <option value="12">Tahun Ini</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-body" style="padding: 16px 20px 12px;">
                            <div id="chartBars" style="display:flex;align-items:flex-end;height:220px;gap:12px;position:relative;padding:0 10px 28px;"></div>
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
                            <div class="mc-body" id="miniChartFavorit">
                                @php
                                    $maxHeight = $layananFavorit->max('harga') ?: 1;
                                    $colors = ['bar-primary', 'bar-success', 'bar-info', 'bar-warning'];
                                @endphp
                                @foreach($layananFavorit as $i => $fav)
                                <span class="bar {{ $colors[$i % 4] }}" data-height="{{ round(($fav->harga / $maxHeight) * 80) }}"></span>
                                @endforeach
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:11px;color:var(--gray);margin-top:8px;">
                                @foreach($layananFavorit as $fav)
                                <span>{{ $fav->nm_layanan }}</span>
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
                            <a href="#">Lihat Semua</a>
                        </div>
                        <div class="table-scroll">
                        <table class="data-table">
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

                <!-- Dashboard Bottom Row -->
                <div class="dashboard-bottom-row">
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

                    <!-- Rekomendasi -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Produk Terlaris</h3>
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
                </div>
            </div>
        </main>
    </div>

    <script>
    const chartMonths = @json($chartMonths);
    const chartCounts = @json($chartCounts);

    function renderChart(months) {
        const container = document.getElementById('chartBars');
        const labelContainer = document.getElementById('chartLabels');
        container.innerHTML = '';
        labelContainer.innerHTML = '';

        const start = Math.max(0, chartMonths.length - months);
        const subsetMonths = chartMonths.slice(start);
        const subsetCounts = chartCounts.slice(start);
        const maxVal = Math.max(...subsetCounts, 1);

        const gridValues = [];
        const gridStep = Math.ceil(maxVal / 4);
        for (let i = 0; i <= 4; i++) {
            gridValues.push(gridStep * i);
        }

        for (let i = 0; i < 4; i++) {
            const pct = ((i + 1) / 5) * 100;
            const line = document.createElement('div');
            line.style.cssText = 'position:absolute;left:0;right:0;bottom:' + (28 + (pct * 192 / 100)) + 'px;height:1px;background:var(--border);';
            container.appendChild(line);
        }

        subsetMonths.forEach(function(month, i) {
            const count = subsetCounts[i];
            const pct = maxVal > 0 ? (count / maxVal) : 0;
            const barHeight = Math.round(pct * 192);

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

        const periodSelect = document.getElementById('chartPeriod');
        if (periodSelect) {
            renderChart(parseInt(periodSelect.value));
            periodSelect.addEventListener('change', function() {
                renderChart(parseInt(this.value));
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
