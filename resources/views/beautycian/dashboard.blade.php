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
                <!-- Stats Row -->
                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                </svg>
                            </div>
                            <span class="stat-change up">+12%</span>
                        </div>
                        <div class="stat-value">Rp 128,5 jt</div>
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
                            <span class="stat-change up">+8%</span>
                        </div>
                        <div class="stat-value">1.247</div>
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
                            <span class="stat-change up">+15%</span>
                        </div>
                        <div class="stat-value">856</div>
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
                            <span class="stat-change down">-2%</span>
                        </div>
                        <div class="stat-value">24</div>
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
                            <span class="stat-change up">+5%</span>
                        </div>
                        <div class="stat-value">1.420</div>
                        <div class="stat-label">Produq Terjual</div>
                    </div>
                </div>

                <!-- Dashboard Grid: Charts -->
                <div class="dashboard-grid">
                    <!-- Pendapatan Chart -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Grafik Pendapatan</h3>
                            <div class="chart-actions">
                                <select>
                                    <option>Tahun Ini</option>
                                    <option>Bulan Ini</option>
                                    <option>Minggu Ini</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-body">
                            <canvas id="chartPendapatan" height="280"></canvas>
                        </div>
                    </div>

                    <!-- Mini Charts Right -->
                    <div class="mini-charts">
                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Grafik Booking</h3>
                                <span class="mc-total">196</span>
                            </div>
                            <div class="mc-body" id="miniChartBooking">
                                <span class="bar bar-primary" data-height="30"></span>
                                <span class="bar bar-primary" data-height="50"></span>
                                <span class="bar bar-primary" data-height="40"></span>
                                <span class="bar bar-primary" data-height="65"></span>
                                <span class="bar bar-primary" data-height="55"></span>
                                <span class="bar bar-primary" data-height="80"></span>
                                <span class="bar bar-primary" data-height="70"></span>
                            </div>
                        </div>

                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Jadwal Hari Ini</h3>
                                <span class="mc-total">12</span>
                            </div>
                            <div style="display:grid;gap:10px;">
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">09:00</span>
                                    <span style="color:var(--gray);">-</span>
                                    <span style="flex:1;">Facial & Massage</span>
                                    <span class="badge badge-success">Confirmed</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">10:30</span>
                                    <span style="color:var(--gray);">-</span>
                                    <span style="flex:1;">Haircut & Styling</span>
                                    <span class="badge badge-warning">Pending</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">13:00</span>
                                    <span style="color:var(--gray);">-</span>
                                    <span style="flex:1;">Manicure & Pedicure</span>
                                    <span class="badge badge-success">Confirmed</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">14:30</span>
                                    <span style="color:var(--gray);">-</span>
                                    <span style="flex:1;">Body Spa</span>
                                    <span class="badge badge-info">Completed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Bottom Grid -->
                <div class="dashboard-bottom-grid">
                    <!-- Layanan Terlaris -->
                    <div class="table-widget">
                        <div class="tw-header">
                            <h3>Layanan Terlaris</h3>
                            <a href="#">Lihat Semua</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Layanan</th>
                                    <th>Kategori</th>
                                    <th>Terjual</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="td-flex">Facial Treatment</div>
                                    </td>
                                    <td>Skincare</td>
                                    <td>128</td>
                                    <td>Rp 25,6 jt</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="td-flex">Haircut Premium</div>
                                    </td>
                                    <td>Salon</td>
                                    <td>96</td>
                                    <td>Rp 14,4 jt</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="td-flex">Body Massage</div>
                                    </td>
                                    <td>Spa</td>
                                    <td>84</td>
                                    <td>Rp 16,8 jt</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="td-flex">Nail Art Design</div>
                                    </td>
                                    <td>Nail Art</td>
                                    <td>72</td>
                                    <td>Rp 10,8 jt</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="td-flex">Hair Color</div>
                                    </td>
                                    <td>Salon</td>
                                    <td>65</td>
                                    <td>Rp 13,0 jt</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Produk Terlaris -->
                    <div class="table-widget">
                        <div class="tw-header">
                            <h3>Produk Terlaris</h3>
                            <a href="#">Lihat Semua</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Terjual</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="td-flex">Serum Vitamin C</div>
                                    </td>
                                    <td>Skincare</td>
                                    <td>245</td>
                                    <td><span class="badge badge-success">Tersedia</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="td-flex">Shampoo Premium</div>
                                    </td>
                                    <td>Hair Care</td>
                                    <td>198</td>
                                    <td><span class="badge badge-warning">Limited</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="td-flex">Nail Polish Set</div>
                                    </td>
                                    <td>Nail Art</td>
                                    <td>167</td>
                                    <td><span class="badge badge-success">Tersedia</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="td-flex">Moisturizer Cream</div>
                                    </td>
                                    <td>Skincare</td>
                                    <td>145</td>
                                    <td><span class="badge badge-danger">Habis</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="td-flex">Hair Mask</div>
                                    </td>
                                    <td>Hair Care</td>
                                    <td>123</td>
                                    <td><span class="badge badge-success">Tersedia</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Dashboard Bottom Row -->
                <div class="dashboard-bottom-row">
                    <!-- Karyawan Aktif -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Karyawan Aktif</h3>
                            <a href="#" style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div class="employee-grid">
                            <div class="employee-card">
                                <img src="https://ui-avatars.com/api/?name=Sari+Dewi&background=FFE5EF&color=FF4F87&size=36"
                                    alt="Sari">
                                <div class="ec-info">
                                    <h4>Sari Dewi</h4>
                                    <p>Stylist</p>
                                </div>
                                <span class="ec-status online"></span>
                            </div>
                            <div class="employee-card">
                                <img src="https://ui-avatars.com/api/?name=Rina+Putri&background=FFE5EF&color=FF4F87&size=36"
                                    alt="Rina">
                                <div class="ec-info">
                                    <h4>Rina Putri</h4>
                                    <p>Terapis</p>
                                </div>
                                <span class="ec-status online"></span>
                            </div>
                            <div class="employee-card">
                                <img src="https://ui-avatars.com/api/?name=Bagus+Adi&background=FFE5EF&color=FF4F87&size=36"
                                    alt="Bagus">
                                <div class="ec-info">
                                    <h4>Bagus Adi</h4>
                                    <p>Barberman</p>
                                </div>
                                <span class="ec-status break"></span>
                            </div>
                            <div class="employee-card">
                                <img src="https://ui-avatars.com/api/?name=Maya+Sari&background=FFE5EF&color=FF4F87&size=36"
                                    alt="Maya">
                                <div class="ec-info">
                                    <h4>Maya Sari</h4>
                                    <p>Nail Artist</p>
                                </div>
                                <span class="ec-status online"></span>
                            </div>
                            <div class="employee-card">
                                <img src="https://ui-avatars.com/api/?name=Dimas+Arif&background=FFE5EF&color=FF4F87&size=36"
                                    alt="Dimas">
                                <div class="ec-info">
                                    <h4>Dimas Arif</h4>
                                    <p>Stylist</p>
                                </div>
                                <span class="ec-status offline"></span>
                            </div>
                            <div class="employee-card">
                                <img src="https://ui-avatars.com/api/?name=Dewi+Lestari&background=FFE5EF&color=FF4F87&size=36"
                                    alt="Dewi">
                                <div class="ec-info">
                                    <h4>Dewi Lestari</h4>
                                    <p>Makeup Artist</p>
                                </div>
                                <span class="ec-status online"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Ringkasan Stok -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Ringkasan Stok</h3>
                            <a href="#" style="font-size:13px;color:var(--primary);font-weight:500;">Kelola</a>
                        </div>
                        <div class="stock-grid">
                            <div class="stock-item">
                                <div class="stock-icon primary">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                    </svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Serum Vitamin C</h4>
                                    <p>Skincare</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill primary" style="width:75%"></div>
                                </div>
                                <span class="stock-qty">48</span>
                            </div>
                            <div class="stock-item">
                                <div class="stock-icon warning">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                    </svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Shampoo Premium</h4>
                                    <p>Hair Care</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill warning" style="width:30%"></div>
                                </div>
                                <span class="stock-qty">12</span>
                            </div>
                            <div class="stock-item">
                                <div class="stock-icon success">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                    </svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Nail Polish Set</h4>
                                    <p>Nail Art</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill success" style="width:90%"></div>
                                </div>
                                <span class="stock-qty">86</span>
                            </div>
                            <div class="stock-item">
                                <div class="stock-icon info">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                    </svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Moisturizer Cream</h4>
                                    <p>Skincare</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill info" style="width:10%"></div>
                                </div>
                                <span class="stock-qty">3</span>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Terbaru -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Booking Terbaru</h3>
                            <a href="#" style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div class="booking-list">
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Ani+Wijaya&background=FFE5EF&color=FF4F87&size=40"
                                    alt="Ani">
                                <div class="booking-info">
                                    <h4>Ani Wijaya</h4>
                                    <p>Facial Treatment</p>
                                </div>
                                <span class="booking-time">09:00</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Rudi+Hartono&background=FFE5EF&color=FF4F87&size=40"
                                    alt="Rudi">
                                <div class="booking-info">
                                    <h4>Rudi Hartono</h4>
                                    <p>Haircut Premium</p>
                                </div>
                                <span class="booking-time">10:30</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Sinta+Dewi&background=FFE5EF&color=FF4F87&size=40"
                                    alt="Sinta">
                                <div class="booking-info">
                                    <h4>Sinta Dewi</h4>
                                    <p>Manicure & Pedicure</p>
                                </div>
                                <span class="booking-time">13:00</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Adi+Putra&background=FFE5EF&color=FF4F87&size=40"
                                    alt="Adi">
                                <div class="booking-info">
                                    <h4>Adi Putra</h4>
                                    <p>Body Spa</p>
                                </div>
                                <span class="booking-time">14:30</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Maya+Anggraini&background=FFE5EF&color=FF4F87&size=40"
                                    alt="Maya">
                                <div class="booking-info">
                                    <h4>Maya Anggraini</h4>
                                    <p>Hair Color & Styling</p>
                                </div>
                                <span class="booking-time">16:00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    // Set current date
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