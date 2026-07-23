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
                            <span class="stat-change up">+2</span>
                        </div>
                        <div class="stat-value">8</div>
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
                            <span class="stat-change up">+1</span>
                        </div>
                        <div class="stat-value">2</div>
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
                            <span class="stat-change up">+6</span>
                        </div>
                        <div class="stat-value">6</div>
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
                            <span class="stat-change up">+150</span>
                        </div>
                        <div class="stat-value">850</div>
                        <div class="stat-label">Poin Reward</div>
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
                            <span class="stat-change up">+3</span>
                        </div>
                        <div class="stat-value">3</div>
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
                                <select>
                                    <option>3 Bulan</option>
                                    <option>6 Bulan</option>
                                    <option>Tahun Ini</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-body" style="padding: 16px 20px 12px;">
                            <div style="display:flex;align-items:flex-end;height:220px;gap:12px;position:relative;padding:0 10px 28px;">
                                <div style="position:absolute;left:0;right:0;bottom:28px;height:1px;background:var(--border);"></div>
                                <div style="position:absolute;left:0;right:0;bottom:78px;height:1px;background:var(--border);"></div>
                                <div style="position:absolute;left:0;right:0;bottom:128px;height:1px;background:var(--border);"></div>
                                <div style="position:absolute;left:0;right:0;bottom:178px;height:1px;background:var(--border);"></div>
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
                                    <div style="width:100%;height:120px;background:linear-gradient(180deg,#FF4F87,#FF7BA6);border-radius:6px 6px 0 0;transition:all 0.3s ease;position:relative;">
                                        <div style="position:absolute;top:-18px;left:50%;transform:translateX(-50%);font-size:10px;font-weight:700;color:var(--primary);background:#FFF5F8;padding:2px 6px;border-radius:4px;">8</div>
                                    </div>
                                    <span style="font-size:10px;color:var(--gray);font-weight:500;">Jan</span>
                                </div>
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
                                    <div style="width:100%;height:80px;background:linear-gradient(180deg,#FF4F87,#FF7BA6);border-radius:6px 6px 0 0;transition:all 0.3s ease;position:relative;">
                                        <div style="position:absolute;top:-18px;left:50%;transform:translateX(-50%);font-size:10px;font-weight:700;color:var(--primary);background:#FFF5F8;padding:2px 6px;border-radius:4px;">5</div>
                                    </div>
                                    <span style="font-size:10px;color:var(--gray);font-weight:500;">Feb</span>
                                </div>
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
                                    <div style="width:100%;height:150px;background:linear-gradient(180deg,#FF4F87,#FF7BA6);border-radius:6px 6px 0 0;transition:all 0.3s ease;position:relative;">
                                        <div style="position:absolute;top:-18px;left:50%;transform:translateX(-50%);font-size:10px;font-weight:700;color:var(--primary);background:#FFF5F8;padding:2px 6px;border-radius:4px;">10</div>
                                    </div>
                                    <span style="font-size:10px;color:var(--gray);font-weight:500;">Mar</span>
                                </div>
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
                                    <div style="width:100%;height:60px;background:linear-gradient(180deg,#FF4F87,#FF7BA6);border-radius:6px 6px 0 0;transition:all 0.3s ease;position:relative;">
                                        <div style="position:absolute;top:-18px;left:50%;transform:translateX(-50%);font-size:10px;font-weight:700;color:var(--primary);background:#FFF5F8;padding:2px 6px;border-radius:4px;">4</div>
                                    </div>
                                    <span style="font-size:10px;color:var(--gray);font-weight:500;">Apr</span>
                                </div>
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
                                    <div style="width:100%;height:105px;background:linear-gradient(180deg,#FF4F87,#FF7BA6);border-radius:6px 6px 0 0;transition:all 0.3s ease;position:relative;">
                                        <div style="position:absolute;top:-18px;left:50%;transform:translateX(-50%);font-size:10px;font-weight:700;color:var(--primary);background:#FFF5F8;padding:2px 6px;border-radius:4px;">7</div>
                                    </div>
                                    <span style="font-size:10px;color:var(--gray);font-weight:500;">Mei</span>
                                </div>
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
                                    <div style="width:100%;height:135px;background:linear-gradient(180deg,#FF4F87,#FF7BA6);border-radius:6px 6px 0 0;transition:all 0.3s ease;position:relative;">
                                        <div style="position:absolute;top:-18px;left:50%;transform:translateX(-50%);font-size:10px;font-weight:700;color:var(--primary);background:#FFF5F8;padding:2px 6px;border-radius:4px;">9</div>
                                    </div>
                                    <span style="font-size:10px;color:var(--gray);font-weight:500;">Jun</span>
                                </div>
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
                                    <div style="width:100%;height:45px;background:linear-gradient(180deg,#FF4F87,#FF7BA6);border-radius:6px 6px 0 0;transition:all 0.3s ease;position:relative;">
                                        <div style="position:absolute;top:-18px;left:50%;transform:translateX(-50%);font-size:10px;font-weight:700;color:var(--primary);background:#FFF5F8;padding:2px 6px;border-radius:4px;">3</div>
                                    </div>
                                    <span style="font-size:10px;color:var(--gray);font-weight:500;">Jul</span>
                                </div>
                            </div>
                            <div style="display:flex;justify-content:space-between;padding:0 10px;margin-top:-4px;">
                                <span style="font-size:9px;color:#ccc;">0</span>
                                <span style="font-size:9px;color:#ccc;">5</span>
                                <span style="font-size:9px;color:#ccc;">10</span>
                                <span style="font-size:9px;color:#ccc;">15</span>
                            </div>
                        </div>
                    </div>

                    <!-- Mini Charts Right -->
                    <div class="mini-charts">
                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Layanan Favorit</h3>
                                <span class="mc-total">3</span>
                            </div>
                            <div class="mc-body" id="miniChartFavorit">
                                <span class="bar bar-primary" data-height="80"></span>
                                <span class="bar bar-success" data-height="55"></span>
                                <span class="bar bar-info" data-height="40"></span>
                                <span class="bar bar-warning" data-height="25"></span>
                            </div>
                            <div style="display:flex;justify-content:space-between;font-size:11px;color:var(--gray);margin-top:8px;">
                                <span>Facial</span>
                                <span>Massage</span>
                                <span>Haircut</span>
                                <span>Nail Art</span>
                            </div>
                        </div>

                        <div class="mini-chart-card">
                            <div class="mc-header">
                                <h3>Booking Mendatang</h3>
                                <span class="mc-total">2</span>
                            </div>
                            <div style="display:grid;gap:8px;">
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">12 Jul</span>
                                    <span style="color:var(--gray);">-</span>
                                    <span style="flex:1;">Facial Treatment</span>
                                    <span class="badge badge-success">Confirmed</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;">
                                    <span style="color:var(--primary);font-weight:600;">15 Jul</span>
                                    <span style="color:var(--gray);">-</span>
                                    <span style="flex:1;">Body Massage</span>
                                    <span class="badge badge-warning">Pending</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:10px;font-size:13px;opacity:0.5;">
                                    <span style="color:var(--primary);font-weight:600;">18 Jul</span>
                                    <span style="color:var(--gray);">-</span>
                                    <span style="flex:1;">Manicure Pedicure</span>
                                    <span class="badge badge-primary">Rencana</span>
                                </div>
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
                                <tr>
                                    <td><div class="td-flex">10 Jul 2026</div></td>
                                    <td>Facial Treatment</td>
                                    <td>Sari Dewi</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">28 Jun 2026</div></td>
                                    <td>Haircut Premium</td>
                                    <td>Dimas Arif</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">15 Jun 2026</div></td>
                                    <td>Body Massage</td>
                                    <td>Rina Putri</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">01 Jun 2026</div></td>
                                    <td>Nail Art Design</td>
                                    <td>Maya Sari</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">20 Mei 2026</div></td>
                                    <td>Hair Color</td>
                                    <td>Dewi Lestari</td>
                                    <td><span class="badge badge-success">Selesai</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Produk Favorit Saya -->
                    <div class="table-widget">
                        <div class="tw-header">
                            <h3>Produk Favorit Saya</h3>
                            <a href="#">Beli Lagi</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Dibeli</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><div class="td-flex">Serum Vitamin C</div></td>
                                    <td>Skincare</td>
                                    <td>3x</td>
                                    <td>Rp 125rb</td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Moisturizer Cream</div></td>
                                    <td>Skincare</td>
                                    <td>2x</td>
                                    <td>Rp 85rb</td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Shampoo Premium</div></td>
                                    <td>Hair Care</td>
                                    <td>2x</td>
                                    <td>Rp 65rb</td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Hair Mask</div></td>
                                    <td>Hair Care</td>
                                    <td>1x</td>
                                    <td>Rp 95rb</td>
                                </tr>
                                <tr>
                                    <td><div class="td-flex">Body Lotion</div></td>
                                    <td>Body Care</td>
                                    <td>1x</td>
                                    <td>Rp 75rb</td>
                                </tr>
                            </tbody>
                        </table>
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
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=PROMO+1&background=FFE5EF&color=FF4F87&size=40&format=svg&font-size=0.30" alt="Promo">
                                <div class="booking-info">
                                    <h4>Diskon 20% Facial Treatment</h4>
                                    <p>Berlaku hingga 31 Juli 2026</p>
                                </div>
                                <span class="badge badge-primary">20%</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=PROMO+2&background=FFF3E0&color=FF9800&size=40&format=svg&font-size=0.30" alt="Promo">
                                <div class="booking-info">
                                    <h4>Buy 1 Get 1 Hair Mask</h4>
                                    <p>Untuk pembelian produk Hair Care</p>
                                </div>
                                <span class="badge badge-warning">BOGO</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=PROMO+3&background=E8F5E9&color=4CAF50&size=40&format=svg&font-size=0.30" alt="Promo">
                                <div class="booking-info">
                                    <h4>Paket Body Massage + Sauna</h4>
                                    <p>Harga spesial Rp 250rb (hemat 40%)</p>
                                </div>
                                <span class="badge badge-success">Paket</span>
                            </div>
                            <div class="booking-item">
                                <img src="https://ui-avatars.com/api/?name=PROMO+4&background=E3F2FD&color=2196F3&size=40&format=svg&font-size=0.30" alt="Promo">
                                <div class="booking-info">
                                    <h4>Double Poin Weekend</h4>
                                    <p>Dapatkan 2x lipat poin setiap weekend</p>
                                </div>
                                <span class="badge badge-info">2x Poin</span>
                            </div>
                        </div>
                    </div>

                    <!-- Layanan Populer -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Layanan Populer</h3>
                            <a href="{{ route('pelanggan.booking') }}" style="font-size:13px;color:var(--primary);font-weight:500;">Booking</a>
                        </div>
                        <div class="employee-grid">
                            <div class="employee-card">
                                <img src="https://ui-avatars.com/api/?name=FT&background=FFE5EF&color=FF4F87&size=36" alt="Facial">
                                <div class="ec-info">
                                    <h4>Facial Treatment</h4>
                                    <p>Skincare - Mulai Rp 150rb</p>
                                </div>
                                <span class="ec-status online"></span>
                            </div>
                            <div class="employee-card">
                                <img src="https://ui-avatars.com/api/?name=BM&background=FFE5EF&color=FF4F87&size=36" alt="Massage">
                                <div class="ec-info">
                                    <h4>Body Massage</h4>
                                    <p>Spa - Mulai Rp 200rb</p>
                                </div>
                                <span class="ec-status online"></span>
                            </div>
                            <div class="employee-card">
                                <img src="https://ui-avatars.com/api/?name=HC&background=FFE5EF&color=FF4F87&size=36" alt="Haircut">
                                <div class="ec-info">
                                    <h4>Haircut Premium</h4>
                                    <p>Salon - Mulai Rp 100rb</p>
                                </div>
                                <span class="ec-status online"></span>
                            </div>
                            <div class="employee-card">
                                <img src="https://ui-avatars.com/api/?name=NA&background=FFE5EF&color=FF4F87&size=36" alt="Nail">
                                <div class="ec-info">
                                    <h4>Nail Art Design</h4>
                                    <p>Nail Art - Mulai Rp 120rb</p>
                                </div>
                                <span class="ec-status break"></span>
                            </div>
                            <div class="employee-card">
                                <img src="https://ui-avatars.com/api/?name=HC&background=FFE5EF&color=FF4F87&size=36" alt="Hair Color">
                                <div class="ec-info">
                                    <h4>Hair Color</h4>
                                    <p>Salon - Mulai Rp 250rb</p>
                                </div>
                                <span class="ec-status online"></span>
                            </div>
                            <div class="employee-card">
                                <img src="https://ui-avatars.com/api/?name=MP&background=FFE5EF&color=FF4F87&size=36" alt="Manicure">
                                <div class="ec-info">
                                    <h4>Manicure & Pedicure</h4>
                                    <p>Nail Art - Mulai Rp 130rb</p>
                                </div>
                                <span class="ec-status online"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Rekomendasi -->
                    <div class="list-widget">
                        <div class="lw-header">
                            <h3>Rekomendasi Untukmu</h3>
                            <a href="#" style="font-size:13px;color:var(--primary);font-weight:500;">Lihat</a>
                        </div>
                        <div class="stock-grid">
                            <div class="stock-item">
                                <div class="stock-icon primary">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /></svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Body Scrub</h4>
                                    <p>Exfoliating - Baru</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill primary" style="width:85%"></div>
                                </div>
                                <span style="font-size:12px;color:var(--primary);font-weight:500;">Cocok</span>
                            </div>
                            <div class="stock-item">
                                <div class="stock-icon success">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /></svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Hair Serum</h4>
                                    <p>Hair Care - Populer</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill success" style="width:72%"></div>
                                </div>
                                <span style="font-size:12px;color:var(--success);font-weight:500;">Rekomendasi</span>
                            </div>
                            <div class="stock-item">
                                <div class="stock-icon warning">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /></svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Face Mask Sheet</h4>
                                    <p>Skincare - Limited</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill warning" style="width:45%"></div>
                                </div>
                                <span style="font-size:12px;color:var(--warning);font-weight:500;">Promo</span>
                            </div>
                            <div class="stock-item">
                                <div class="stock-icon info">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /></svg>
                                </div>
                                <div class="stock-info">
                                    <h4>Night Cream</h4>
                                    <p>Skincare - Best Seller</p>
                                </div>
                                <div class="stock-bar">
                                    <div class="fill info" style="width:90%"></div>
                                </div>
                                <span style="font-size:12px;color:var(--info);font-weight:500;">Best</span>
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
