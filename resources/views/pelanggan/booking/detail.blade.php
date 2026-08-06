<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Booking - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
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

    @media (max-width: 768px) {
        .sidebar-toggle {
            display: flex;
            align-items: center;
        }
    }

    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .detail-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .detail-card .dc-body {
        padding: 32px;
    }

    .detail-card .dc-section-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-card .dc-section-title .dc-st-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: var(--hover);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }

    .detail-card .dc-section-sub {
        font-size: 12px;
        color: var(--gray);
        margin-bottom: 20px;
        margin-left: 36px;
    }

    .detail-card .dc-divider {
        height: 1px;
        background: var(--border);
        margin: 24px 0;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
        .detail-card .dc-body { padding: 20px; }
        .detail-card .dc-section-sub { margin-left: 0; }
        .header-back-detail { align-items: flex-start; }
        .action-bar-bottom { flex-wrap: wrap; }
        .services-table thead { display: none; }
        .services-table tbody tr {
            display: block;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 10px;
        }
        .services-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 6px 0;
            border: none;
            font-size: 13px;
        }
        .services-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--gray);
            font-size: 11px;
            text-transform: uppercase;
            flex-shrink: 0;
        }
        .price-summary { padding: 18px 16px; }
        .price-summary .ps-row .ps-value { text-align: right; }
    }

    @media (max-width: 576px) {
        .detail-card .dc-body { padding: 16px; }
        .header-back-detail .hbd-text h3 { font-size: 17px; }
        .action-bar-bottom .btn-back-detail,
        .action-bar-bottom .btn-print-detail { flex: 1; justify-content: center; }
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .detail-item .di-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--gray);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .detail-item .di-label i {
        color: var(--primary);
        font-size: 12px;
        width: 16px;
        text-align: center;
    }

    .detail-item .di-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
    }

    .services-table {
        width: 100%;
        border-collapse: collapse;
    }

    .services-table th {
        text-align: left;
        padding: 10px 16px;
        font-size: 12px;
        font-weight: 700;
        color: var(--gray);
        text-transform: uppercase;
        background: #FFF7FA;
        border-bottom: 1px solid var(--border);
    }

    .services-table td {
        padding: 12px 16px;
        font-size: 13px;
        color: var(--dark);
        border-bottom: 1px solid var(--border);
    }

    .services-table tr:last-child td {
        border-bottom: none;
    }

    .price-summary {
        background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
        border-radius: 16px;
        padding: 24px;
        margin-top: 24px;
        border: 1px solid rgba(255, 79, 135, 0.1);
    }

    .price-summary .ps-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        font-size: 13px;
        color: var(--gray);
    }

    .price-summary .ps-row:not(:last-child) {
        border-bottom: 1px dashed rgba(255, 79, 135, 0.15);
    }

    .price-summary .ps-row .ps-value {
        font-weight: 600;
        color: var(--dark);
    }

    .price-summary .ps-row.ps-total {
        padding-top: 12px;
        border-bottom: none !important;
    }

    .price-summary .ps-row.ps-total .ps-label {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
    }

    .price-summary .ps-row.ps-total .ps-value {
        font-size: 20px;
        font-weight: 800;
        color: var(--primary);
    }

    .status-header-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: capitalize;
        letter-spacing: 0.3px;
    }

    .status-header-badge .shb-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-header-badge.menunggu {
        background: #FFF7ED;
        color: #C2410C;
    }

    .status-header-badge.menunggu .shb-dot {
        background: #F97316;
    }

    .status-header-badge.dikonfirmasi {
        background: #EFF6FF;
        color: #1D4ED8;
    }

    .status-header-badge.dikonfirmasi .shb-dot {
        background: #3B82F6;
    }

    .status-header-badge.diproses {
        background: #F5F3FF;
        color: #6D28D9;
    }

    .status-header-badge.diproses .shb-dot {
        background: #8B5CF6;
    }

    .status-header-badge.selesai {
        background: #F0FDF4;
        color: #166534;
    }

    .status-header-badge.selesai .shb-dot {
        background: #22C55E;
    }

    .status-header-badge.dibatalkan {
        background: #FEF2F2;
        color: #991B1B;
    }

    .status-header-badge.dibatalkan .shb-dot {
        background: #EF4444;
    }

    .btn-back-detail {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: var(--white);
        color: var(--gray);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
    }

    .btn-back-detail:hover {
        background: var(--background);
        border-color: #ddd;
    }

    .btn-print-detail {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: #F3E8FF;
        color: #9333EA;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
        border: none;
    }

    .btn-print-detail:hover {
        background: #E9D5FF;
        box-shadow: 0 4px 12px rgba(147, 51, 234, 0.2);
    }

    .action-bar-bottom {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid var(--border);
    }

    @media print {
        .sidebar-toggle, .sidebar-overlay, .no-print { display: none !important; }
        .sidebar { display: none !important; }
        .main-content { margin-left: 0 !important; padding: 0 !important; }
        .dashboard-layout { display: block !important; }
        .dashboard-content { padding: 20px !important; }
        .detail-card { box-shadow: none; border: 1px solid #ddd; }
        body { background: white; }
        header, .navbar-top, .main-content > .header2, .dashboard-content > .header-back-detail, .action-bar-bottom { display: none !important; }
    }

    .header-back-detail {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }

    .header-back-detail .hbd-btn-back {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: var(--white);
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray);
        font-size: 15px;
        transition: all 0.2s ease;
        text-decoration: none;
        flex-shrink: 0;
    }

    .header-back-detail .hbd-btn-back:hover {
        background: var(--hover);
        color: var(--primary);
        transform: translateX(-2px);
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.15);
    }

    .header-back-detail .hbd-text h3 {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .header-back-detail .hbd-text p {
        font-size: 13px;
        color: var(--gray);
        margin: 2px 0 0;
    }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="header-back-detail">
                    <a href="{{ route('pelanggan.booking') }}" class="hbd-btn-back">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div class="hbd-text">
                        <h3>
                            Detail Booking #BK{{ str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) }}
                            <span class="status-header-badge {{ $booking->status }}">
                                <span class="shb-dot"></span>
                                {{ ucfirst($booking->status) }}
                            </span>
                        </h3>
                        <p>Informasi lengkap booking treatment Anda</p>
                    </div>
                </div>

                <div class="detail-card">
                    <div class="dc-body">
                        <!-- Jadwal -->
                        <div class="dc-section-title">
                            <span class="dc-st-icon"><i class="fa-regular fa-calendar"></i></span>
                            Jadwal Treatment
                        </div>
                        <div class="dc-section-sub">Tanggal dan jam booking treatment</div>

                        <div class="detail-grid">
                            <div class="detail-item">
                                <span class="di-label"><i class="fa-regular fa-calendar-check"></i> Tanggal</span>
                                <span class="di-value">{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('dddd, D MMMM YYYY') }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="di-label"><i class="fa-regular fa-clock"></i> Jam</span>
                                <span class="di-value">{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }}</span>
                            </div>
                        </div>

                        <div class="dc-divider"></div>

                        <!-- Terapis -->
                        <div class="dc-section-title">
                            <span class="dc-st-icon"><i class="fa-regular fa-user"></i></span>
                            Beauty Therapist
                        </div>
                        <div class="dc-section-sub">Terapis yang akan menangani treatment Anda</div>

                        <div class="detail-item">
                            <span class="di-value">{{ $booking->karyawan ? $booking->karyawan->nama : 'Terapis #'.$booking->id_karyawan }}</span>
                        </div>

                        <div class="dc-divider"></div>

                        <!-- Layanan -->
                        <div class="dc-section-title">
                            <span class="dc-st-icon"><i class="fa-solid fa-spa"></i></span>
                            Layanan Treatment
                        </div>
                        <div class="dc-section-sub">Daftar layanan yang akan dilakukan</div>

                        <div style="overflow-x:auto;">
                        <table class="services-table">
                            <thead>
                                <tr>
                                    <th style="width:40px;">No</th>
                                    <th>Layanan</th>
                                    <th style="text-align:right;">Harga</th>
                                    <th style="text-align:right;">Diskon</th>
                                    <th style="text-align:right;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalHarga = 0; $totalDiskon = 0; $totalSubtotal = 0; @endphp
                                @foreach($booking->detail as $i => $d)
                                @php
                                    $totalHarga += $d->harga;
                                    $totalDiskon += $d->diskon;
                                    $totalSubtotal += $d->subtotal;
                                @endphp
                                <tr>
                                    <td data-label="No" style="color:var(--gray);">{{ $i + 1 }}</td>
                                    <td data-label="Layanan">
                                        <span style="font-weight:600;">{{ $d->layanan ? $d->layanan->nm_layanan : '-' }}</span>
                                    </td>
                                    <td data-label="Harga" style="text-align:right;">Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                                    <td data-label="Diskon" style="text-align:right;color:#DC2626;">- Rp {{ number_format($d->diskon, 0, ',', '.') }}</td>
                                    <td data-label="Subtotal" style="text-align:right;font-weight:600;">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>

                        <!-- Price Summary -->
                        <div class="price-summary">
                            <div class="ps-row">
                                <span class="ps-label">Total Harga</span>
                                <span class="ps-value">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                            </div>
                            <div class="ps-row">
                                <span class="ps-label">Total Diskon</span>
                                <span class="ps-value" style="color:#DC2626;">- Rp {{ number_format($totalDiskon, 0, ',', '.') }}</span>
                            </div>
                            <div class="ps-row ps-total">
                                <span class="ps-label">Total Bayar</span>
                                <span class="ps-value">Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        @if($booking->catatan)
                        <div class="dc-divider"></div>
                        <div class="dc-section-title">
                            <span class="dc-st-icon"><i class="fa-regular fa-note-sticky"></i></span>
                            Catatan
                        </div>
                        <div class="dc-section-sub">Pesan tambahan untuk terapis</div>
                        <p style="font-size:13px;color:var(--dark);margin:0;">{{ $booking->catatan }}</p>
                        @endif

                        <div class="action-bar-bottom no-print">
                            <a href="{{ route('pelanggan.booking') }}" class="btn-back-detail">
                                <i class="fa-solid fa-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ route('pelanggan.booking.pdf', $booking->id_booking) }}" class="btn-print-detail">
                                <i class="fa-solid fa-file-pdf"></i> Unduh PDF
                            </a>
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
    const dateEl = document.getElementById('currentDate');
    if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);

    const params = new URLSearchParams(window.location.search);
    if (params.get('print') === '1') {
        window.print();
    }
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
