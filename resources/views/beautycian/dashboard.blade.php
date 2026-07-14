<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Beautycian - BeautyCare</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

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
    <div class="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <div class="dashboard-layout">
        @include('layouts.sidebar')

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
                            <span class="stat-change up">+4%</span>
                        </div>
                        <div class="stat-value">6</div>
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
                            <span class="stat-change up">+10%</span>
                        </div>
                        <div class="stat-value">12</div>
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
                            <span class="stat-change up">+8%</span>
                        </div>
                        <div class="stat-value">24</div>
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
                            <span class="stat-change up">+2%</span>
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
                            <span class="stat-change up">+6%</span>
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
                            <a href="#">Lihat Semua</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Pelanggan</th>
                                    <th>Layanan</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><div class="td-flex">Ani Wijaya</div></td>
                                    <td>Facial Treatment</td>
                                    <td>09:00 - 10:15</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Sinta Dewi</div></td>
                                    <td>Body Massage</td>
                                    <td>10:30 - 12:00</td>
                                    <td><span class="badge badge-primary">Berjalan</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Rudi Hartono</div></td>
                                    <td>Haircut Premium</td>
                                    <td>08:00 - 08:45</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Maya Anggraini</div></td>
                                    <td>Nail Art Design</td>
                                    <td>11:00 - 12:30</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Dewi Lestari</div></td>
                                    <td>Hair Color</td>
                                    <td>13:00 - 15:00</td>
                                    <td><span class="badge badge-warning">Antri</span></td>
                                </tr>
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
                                    <td><div class="td-flex">Serum Vitamin C</div></td>
                                    <td>Skincare</td>
                                    <td>18 kali</td>
                                    <td><span class="badge badge-success">Tersedia</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Moisturizer Cream</div></td>
                                    <td>Skincare</td>
                                    <td>14 kali</td>
                                    <td><span class="badge badge-danger">Habis</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Shampoo Premium</div></td>
                                    <td>Hair Care</td>
                                    <td>12 kali</td>
                                    <td><span class="badge badge-warning">Limited</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Hair Mask</div></td>
                                    <td>Hair Care</td>
                                    <td>10 kali</td>
                                    <td><span class="badge badge-success">Tersedia</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Nail Polish Set</div></td>
                                    <td>Nail Art</td>
                                    <td>8 kali</td>
                                    <td><span class="badge badge-success">Tersedia</span></td>
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
                            <a href="#" style="font-size:13px;color:var(--primary);font-weight:500;">Atur</a>
                        </div>
                        <div class="booking-list">
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Nina+Zahra&background=FFE5EF&color=FF4F87&size=40" alt="Nina">
                                <div class="booking-info">
                                    <h4>Nina Zahra</h4>
                                    <p>Facial Treatment</p>
                                </div>
                                <span class="booking-time">Besok 09:00</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Dian+Sari&background=FFE5EF&color=FF4F87&size=40" alt="Dian">
                                <div class="booking-info">
                                    <h4>Dian Sari</h4>
                                    <p>Body Massage + Sauna</p>
                                </div>
                                <span class="booking-time">Besok 10:30</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Adi+Santoso&background=FFE5EF&color=FF4F87&size=40" alt="Adi">
                                <div class="booking-info">
                                    <h4>Adi Santoso</h4>
                                    <p>Haircut & Beard Trim</p>
                                </div>
                                <span class="booking-time">Besok 13:00</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Rina+Melati&background=FFE5EF&color=FF4F87&size=40" alt="Rina">
                                <div class="booking-info">
                                    <h4>Rina Melati</h4>
                                    <p>Nail Art Design</p>
                                </div>
                                <span class="booking-time">Lusa 11:00</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Fajar+Alam&background=FFE5EF&color=FF4F87&size=40" alt="Fajar">
                                <div class="booking-info">
                                    <h4>Fajar Alam</h4>
                                    <p>Hair Color Premium</p>
                                </div>
                                <span class="booking-time">Lusa 14:00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    const now = new Date();
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
