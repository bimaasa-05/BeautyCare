<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Kasir - BeautyCare</title>

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
                <!-- Stats Row - Kasir: Fokus Transaksi -->
                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon success">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                </svg>
                            </div>
                            <span class="stat-change up">+18%</span>
                        </div>
                        <div class="stat-value">Rp 4,8 jt</div>
                        <div class="stat-label">Pendapatan Hari Ini</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                    <line x1="16" y1="13" x2="8" y2="13" />
                                    <line x1="16" y1="17" x2="8" y2="17" />
                                </svg>
                            </div>
                            <span class="stat-change up">+5%</span>
                        </div>
                        <div class="stat-value">48</div>
                        <div class="stat-label">Transaksi Hari Ini</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="8.5" cy="7" r="4" />
                                </svg>
                            </div>
                            <span class="stat-change up">+12%</span>
                        </div>
                        <div class="stat-value">36</div>
                        <div class="stat-label">Pelanggan Hari Ini</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                                </svg>
                            </div>
                            <span class="stat-change down">-3%</span>
                        </div>
                        <div class="stat-value">7</div>
                        <div class="stat-label">Pesanan Pending</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
                                    <line x1="8" y1="21" x2="16" y2="21" />
                                    <line x1="12" y1="17" x2="12" y2="21" />
                                </svg>
                            </div>
                            <span class="stat-change up">+8%</span>
                        </div>
                        <div class="stat-value">62</div>
                        <div class="stat-label">Produk Terjual</div>
                    </div>
                </div>

                <!-- Dashboard Grid: Charts -->
                <div class="dashboard-grid">
                    <!-- Grafik Penjualan -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Grafik Penjualan Harian</h3>
                            <div class="chart-actions">
                                <select>
                                    <option>7 Hari</option>
                                    <option>30 Hari</option>
                                    <option>Bulan Ini</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-body">
                            <canvas id="chartPenjualan" height="280"></canvas>
                        </div>
                    </div>

                    <!-- Mini Charts Right -->
                    <div class="mini-charts">
                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Metode Pembayaran</h3>
                                <span class="mc-total">48</span>
                            </div>
                            <div class="mc-body" id="miniChartPayment">
                                <span class="bar bar-success" data-height="60"></span>
                                <span class="bar bar-primary" data-height="40"></span>
                                <span class="bar bar-warning" data-height="25"></span>
                                <span class="bar bar-info" data-height="15"></span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:11px;color:var(--gray);margin-top:8px;">
                                <span>Cash</span>
                                <span>QRIS</span>
                                <span>Kartu</span>
                                <span>Transfer</span>
                            </div>
                        </div>

                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Transaksi Terbaru</h3>
                                <span class="mc-total">5</span>
                            </div>
                            <div style="display:grid;gap:8px;">
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">#TRX-001</span>
                                    <span style="flex:1;">Ani Wijaya</span>
                                    <span style="font-weight:500;color:var(--dark);">Rp 350rb</span>
                                    <span class="badge badge-success">Lunas</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">#TRX-002</span>
                                    <span style="flex:1;">Rudi Hartono</span>
                                    <span style="font-weight:500;color:var(--dark);">Rp 180rb</span>
                                    <span class="badge badge-success">Lunas</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">#TRX-003</span>
                                    <span style="flex:1;">Sinta Dewi</span>
                                    <span style="font-weight:500;color:var(--dark);">Rp 520rb</span>
                                    <span class="badge badge-warning">Pending</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">#TRX-004</span>
                                    <span style="flex:1;">Adi Putra</span>
                                    <span style="font-weight:500;color:var(--dark);">Rp 275rb</span>
                                    <span class="badge badge-success">Lunas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Bottom Grid -->
                <div class="dashboard-bottom-grid">
                    <!-- Produk Terlaris Hari Ini -->
                    <div class="table-widget">
                        <div class="tw-header">
                            <h3>Produk Terlaris Hari Ini</h3>
                            <a href="#">Lihat Semua</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Terjual</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><div class="td-flex">Serum Vitamin C</div></td>
                                    <td>Skincare</td>
                                    <td>12</td>
                                    <td>Rp 1,2 jt</td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Facial Treatment</div></td>
                                    <td>Skincare</td>
                                    <td>8</td>
                                    <td>Rp 1,6 jt</td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Haircut Premium</div></td>
                                    <td>Salon</td>
                                    <td>7</td>
                                    <td>Rp 1,05 jt</td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Shampoo Premium</div></td>
                                    <td>Hair Care</td>
                                    <td>6</td>
                                    <td>Rp 360rb</td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Body Massage</div></td>
                                    <td>Spa</td>
                                    <td>4</td>
                                    <td>Rp 800rb</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="table-widget">
                        <div class="tw-header">
                            <h3>Rekap Pembayaran</h3>
                            <a href="#">Detail</a>
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
                                <tr>
                                    <td><div class="td-flex">Tunai</div></td>
                                    <td>22</td>
                                    <td>Rp 2,4 jt</td>
                                    <td><span class="badge badge-success">Aktif</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">QRIS</div></td>
                                    <td>14</td>
                                    <td>Rp 1,6 jt</td>
                                    <td><span class="badge badge-success">Aktif</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Kartu Debit/Kredit</div></td>
                                    <td>8</td>
                                    <td>Rp 980rb</td>
                                    <td><span class="badge badge-success">Aktif</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Transfer Bank</div></td>
                                    <td>4</td>
                                    <td>Rp 420rb</td>
                                    <td><span class="badge badge-success">Aktif</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">E-Wallet</div></td>
                                    <td>5</td>
                                    <td>Rp 380rb</td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Dashboard Bottom Row -->
                <div class="dashboard-bottom-row">
                    <!-- Pesanan Check-In -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Pesanan Check-In</h3>
                            <a href="#" style="font-size:13px;color:var(--primary);font-weight:500;">Proses</a>
                        </div>
                        <div class="booking-list">
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Dian+Sari&background=FFE5EF&color=FF4F87&size=40" alt="Dian">
                                <div class="booking-info">
                                    <h4>Dian Sari</h4>
                                    <p>Facial Treatment + Masker</p>
                                </div>
                                <span class="booking-time">15 menit</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Bayu+Segara&background=FFE5EF&color=FF4F87&size=40" alt="Bayu">
                                <div class="booking-info">
                                    <h4>Bayu Segara</h4>
                                    <p>Haircut Premium</p>
                                </div>
                                <span class="booking-time">30 menit</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Nina+Zahra&background=FFE5EF&color=FF4F87&size=40" alt="Nina">
                                <div class="booking-info">
                                    <h4>Nina Zahra</h4>
                                    <p>Manicure & Pedicure</p>
                                </div>
                                <span class="booking-time">45 menit</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Adi+Santoso&background=FFE5EF&color=FF4F87&size=40" alt="Adi">
                                <div class="booking-info">
                                    <h4>Adi Santoso</h4>
                                    <p>Body Massage</p>
                                </div>
                                <span class="booking-time">60 menit</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=Rina+Melati&background=FFE5EF&color=FF4F87&size=40" alt="Rina">
                                <div class="booking-info">
                                    <h4>Rina Melati</h4>
                                    <p>Hair Color + Styling</p>
                                </div>
                                <span class="booking-time">90 menit</span>
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Transaksi -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Riwayat Transaksi</h3>
                            <a href="#" style="font-size:13px;color:var(--primary);font-weight:500;">Lihat Semua</a>
                        </div>
                        <div class="employee-grid">
                            <div class="employee-card" style="grid-template-columns:36px 1fr auto;">
                                <img src="https://ui-avatars.com/api/?name=TRX+001&background=E8F5E9&color=4CAF50&size=36" alt="TRX">
                                <div class="ec-info">
                                    <h4>#TRX-001 - Ani W.</h4>
                                    <p>Cash - Rp 350rb</p>
                                </div>
                                <span style="font-size:11px;color:var(--gray);">09:15</span>
                            </div>
                            <div class="employee-card" style="grid-template-columns:36px 1fr auto;">
                                <img src="https://ui-avatars.com/api/?name=TRX+002&background=E8F5E9&color=4CAF50&size=36" alt="TRX">
                                <div class="ec-info">
                                    <h4>#TRX-002 - Rudi H.</h4>
                                    <p>QRIS - Rp 180rb</p>
                                </div>
                                <span style="font-size:11px;color:var(--gray);">10:30</span>
                            </div>
                            <div class="employee-card" style="grid-template-columns:36px 1fr auto;">
                                <img src="https://ui-avatars.com/api/?name=TRX+003&background=FFF3E0&color=FF9800&size=36" alt="TRX">
                                <div class="ec-info">
                                    <h4>#TRX-003 - Sinta D.</h4>
                                    <p>Kartu - Rp 520rb</p>
                                </div>
                                <span style="font-size:11px;color:var(--gray);">11:45</span>
                            </div>
                            <div class="employee-card" style="grid-template-columns:36px 1fr auto;">
                                <img src="https://ui-avatars.com/api/?name=TRX+004&background=E8F5E9&color=4CAF50&size=36" alt="TRX">
                                <div class="ec-info">
                                    <h4>#TRX-004 - Adi P.</h4>
                                    <p>Cash - Rp 275rb</p>
                                </div>
                                <span style="font-size:11px;color:var(--gray);">13:00</span>
                            </div>
                            <div class="employee-card" style="grid-template-columns:36px 1fr auto;">
                                <img src="https://ui-avatars.com/api/?name=TRX+005&background=E8F5E9&color=4CAF50&size=36" alt="TRX">
                                <div class="ec-info">
                                    <h4>#TRX-005 - Maya A.</h4>
                                    <p>QRIS - Rp 1,2 jt</p>
                                </div>
                                <span style="font-size:11px;color:var(--gray);">14:20</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notifikasi Stok -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Notifikasi Stok</h3>
                            <a href="#" style="font-size:13px;color:var(--primary);font-weight:500;">Kelola</a>
                        </div>
                        <div class="stock-grid">
                            <div class="stock-item">
                                <div class="stock-icon danger">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10" /><line x1="15" y1="9" x2="9" y2="15" /><line x1="9" y1="9" x2="15" y2="15" />
                                    </svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Moisturizer Cream</h4>
                                    <p>Skincare - Sisa 3</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill danger" style="width:10%"></div>
                                </div>
                                <span class="stock-qty">3</span>
                            </div>
                            <div class="stock-item">
                                <div class="stock-icon warning">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" /><line x1="12" y1="9" x2="12" y2="13" /><line x1="12" y1="17" x2="12.01" y2="17" />
                                    </svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Shampoo Premium</h4>
                                    <p>Hair Care - Sisa 12</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill warning" style="width:30%"></div>
                                </div>
                                <span class="stock-qty">12</span>
                            </div>
                            <div class="stock-item">
                                <div class="stock-icon success">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" /><polyline points="22 4 12 14.01 9 11.01" />
                                    </svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Nail Polish Set</h4>
                                    <p>Nail Art - Sisa 86</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill success" style="width:90%"></div>
                                </div>
                                <span class="stock-qty">86</span>
                            </div>
                            <div class="stock-item">
                                <div class="stock-icon primary">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                    </svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Serum Vitamin C</h4>
                                    <p>Skincare - Sisa 48</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill primary" style="width:75%"></div>
                                </div>
                                <span class="stock-qty">48</span>
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
