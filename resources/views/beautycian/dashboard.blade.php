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
                            <div class="stat-icon warning">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value">4,9</div>
                        <div class="stat-label">Rating Rata-rata</div>
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
                        <div class="stat-value">7,5 jam</div>
                        <div class="stat-label">Jam Kerja</div>
                    </div>
                </div>

                <!-- Dashboard Grid: Charts -->
                <div class="dashboard-grid">
                    <!-- Grafik Layanan -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Grafik Layanan Perawatan</h3>
                            <div class="chart-actions">
                                <select>
                                    <option>Minggu Ini</option>
                                    <option>Bulan Ini</option>
                                    <option>Tahun Ini</option>
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
                                <span class="mc-total">7,5</span>
                            </div>
                            <div class="mc-body" id="miniChartJam">
                                <span class="bar bar-primary" data-height="60"></span>
                                <span class="bar bar-primary" data-height="75"></span>
                                <span class="bar bar-primary" data-height="45"></span>
                                <span class="bar bar-primary" data-height="80"></span>
                                <span class="bar bar-primary" data-height="70"></span>
                                <span class="bar bar-primary" data-height="50"></span>
                                <span class="bar bar-primary" data-height="30"></span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:11px;color:var(--gray);margin-top:8px;">
                                <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
                            </div>
                        </div>

                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Jadwal Perawatan</h3>
                                <span class="mc-total">6</span>
                            </div>
                            <div style="display:grid;gap:8px;">
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">09:00</span>
                                    <span style="color:var(--gray);">-</span>
                                    <span style="flex:1;">Facial Treatment</span>
                                    <span class="badge badge-success">Selesai</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">10:30</span>
                                    <span style="color:var(--gray);">-</span>
                                    <span style="flex:1;">Body Massage</span>
                                    <span class="badge badge-primary">Berjalan</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">13:00</span>
                                    <span style="color:var(--gray);">-</span>
                                    <span style="flex:1;">Hair Color & Styling</span>
                                    <span class="badge badge-warning">Antri</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">15:00</span>
                                    <span style="color:var(--gray);">-</span>
                                    <span style="flex:1;">Manicure & Pedicure</span>
                                    <span class="badge badge-warning">Antri</span>
                                </div>
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
                            <a href="{{ route('beautycian.riwayat-treatment.index') }}">Lihat Semua</a>
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
                                @forelse($riwayat_terbaru as $item)
                                <tr>
                                    <td data-label="Pelanggan"><div class="td-flex">{{ $item->pelanggan->nm_pelanggan ?? '-' }}</div></td>
                                    <td data-label="Layanan">
                                        @if($item->detail && $item->detail->isNotEmpty())
                                            @foreach($item->detail as $dt){{ $dt->layanan->nm_layanan ?? '-' }}@if(!$loop->last), @endif @endforeach
                                        @else - @endif
                                    </td>
                                    <td data-label="Tanggal">{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM') }}</td>
                                    <td data-label="Dokumen">
                                        @if($item->riwayatTreatment)
                                        <span class="badge badge-success">Ada</span>
                                        @else
                                        <span class="badge badge-warning">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" style="text-align:center;padding:30px;color:var(--gray);font-size:13px;">
                                        Belum ada riwayat treatment.
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
                            <a href="#">Detail</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Digunakan</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="Produk"><div class="td-flex">Serum Vitamin C</div></td>
                                    <td data-label="Kategori">Skincare</td>
                                    <td data-label="Digunakan">18 kali</td>
                                    <td data-label="Stok"><span class="badge badge-success">Tersedia</span></td>
                                </tr>
                                <tr>
                                    <td data-label="Produk"><div class="td-flex">Moisturizer Cream</div></td>
                                    <td data-label="Kategori">Skincare</td>
                                    <td data-label="Digunakan">14 kali</td>
                                    <td data-label="Stok"><span class="badge badge-danger">Habis</span></td>
                                </tr>
                                <tr>
                                    <td data-label="Produk"><div class="td-flex">Shampoo Premium</div></td>
                                    <td data-label="Kategori">Hair Care</td>
                                    <td data-label="Digunakan">12 kali</td>
                                    <td data-label="Stok"><span class="badge badge-warning">Limited</span></td>
                                </tr>
                                <tr>
                                    <td data-label="Produk"><div class="td-flex">Hair Mask</div></td>
                                    <td data-label="Kategori">Hair Care</td>
                                    <td data-label="Digunakan">10 kali</td>
                                    <td data-label="Stok"><span class="badge badge-success">Tersedia</span></td>
                                </tr>
                                <tr>
                                    <td data-label="Produk"><div class="td-flex">Nail Polish Set</div></td>
                                    <td data-label="Kategori">Nail Art</td>
                                    <td data-label="Digunakan">8 kali</td>
                                    <td data-label="Stok"><span class="badge badge-success">Tersedia</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Dashboard Bottom Row -->
                <div class="dashboard-bottom-row">
                    <!-- Ulasan Pelanggan -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Ulasan Pelanggan</h3>
                            <a href="#" style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div class="booking-list">
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Ani+Wijaya&background=FFE5EF&color=FF4F87&size=40" alt="Ani">
                                <div class="booking-info">
                                    <h4>Ani Wijaya</h4>
                                    <p>"Facialnya bikin wajah glowing! Makasih"</p>
                                </div>
                                <div style="display:flex;gap:2px;">
                                    <span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span>
                                </div>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Rina+Putri&background=FFE5EF&color=FF4F87&size=40" alt="Rina">
                                <div class="booking-info">
                                    <h4>Rina Putri</h4>
                                    <p>"Massage nya enak banget, badan rileks"</p>
                                </div>
                                <div style="display:flex;gap:2px;">
                                    <span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span><span style="color:#E0E0E0;">&#9733;</span>
                                </div>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Bagus+Adi&background=FFE5EF&color=FF4F87&size=40" alt="Bagus">
                                <div class="booking-info">
                                    <h4>Bagus Adi</h4>
                                    <p>"Potongan rambutnya rapi, recommended!"</p>
                                </div>
                                <div style="display:flex;gap:2px;">
                                    <span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span>
                                </div>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Maya+Sari&background=FFE5EF&color=FF4F87&size=40" alt="Maya">
                                <div class="booking-info">
                                    <h4>Maya Sari</h4>
                                    <p>"Nail artnya cantik, detail banget!"</p>
                                </div>
                                <div style="display:flex;gap:2px;">
                                    <span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span><span style="color:#FFB74D;">&#9733;</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Produk Favorit -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Produk Favorit Pelanggan</h3>
                            <a href="#" style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div class="stock-grid">
                            <div class="stock-item">
                                <div class="stock-icon primary">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /></svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Serum Vitamin C</h4>
                                    <p>Skincare - Diminati</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill primary" style="width:90%"></div>
                                </div>
                                <span class="stock-qty">90%</span>
                            </div>
                            <div class="stock-item">
                                <div class="stock-icon success">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /></svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Hair Mask</h4>
                                    <p>Hair Care - Populer</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill success" style="width:75%"></div>
                                </div>
                                <span class="stock-qty">75%</span>
                            </div>
                            <div class="stock-item">
                                <div class="stock-icon warning">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /></svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Shampoo Premium</h4>
                                    <p>Hair Care - Cukup</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill warning" style="width:45%"></div>
                                </div>
                                <span class="stock-qty">45%</span>
                            </div>
                            <div class="stock-item">
                                <div class="stock-icon info">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /></svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Body Lotion</h4>
                                    <p>Body Care - Baru</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill info" style="width:20%"></div>
                                </div>
                                <span class="stock-qty">20%</span>
                            </div>
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
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->pelanggan->nm_pelanggan ?? '?') }}&background=FFE5EF&color=FF4F87&size=40" alt="{{ $item->pelanggan->nm_pelanggan ?? '?' }}">
                                <div class="booking-info">
                                    <h4>{{ $item->pelanggan->nm_pelanggan ?? '#' . $item->id_pelanggan }}</h4>
                                    <p>
                                        @if($item->detail && $item->detail->isNotEmpty())
                                            @foreach($item->detail as $dt){{ $dt->layanan->nm_layanan ?? '-' }}@if(!$loop->last), @endif @endforeach
                                        @else - @endif
                                    </p>
                                </div>
                                <span class="booking-time">{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM') }} {{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}</span>
                            </div>
                            @empty
                            <div style="padding:30px;text-align:center;color:var(--gray);font-size:13px;">
                                Tidak ada booking mendatang.
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
</body>

</html>
