<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Reservasi - BeautyCare</title>

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

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    body {
        font-family: 'Inter', sans-serif;
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

    .page-header-premium {
        background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 79, 135, 0.08);
    }

    .page-header-premium::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 79, 135, 0.12) 0%, transparent 70%);
        pointer-events: none;
    }

    .page-header-premium::after {
        content: '';
        position: absolute;
        bottom: -40px;
        left: 30%;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 79, 135, 0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .page-header-premium .ph-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .page-header-premium .ph-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-header-premium .ph-icon-wrap {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 22px;
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
        flex-shrink: 0;
    }

    .page-header-premium .ph-text h3 {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .page-header-premium .ph-text p {
        font-size: 13px;
        color: var(--gray);
        margin: 2px 0 0;
    }

    .page-header-premium .ph-stats {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .page-header-premium .ph-stat-item {
        text-align: center;
    }

    .page-header-premium .ph-stat-item .ph-stat-num {
        font-size: 24px;
        font-weight: 700;
        color: var(--primary);
        line-height: 1;
    }

    .page-header-premium .ph-stat-item .ph-stat-label {
        font-size: 11px;
        color: var(--gray);
        margin-top: 2px;
    }

    .page-header-premium .ph-stat-divider {
        width: 1px;
        height: 32px;
        background: rgba(255, 79, 135, 0.15);
    }

    .filter-tabs {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 8px 20px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
        border: 1.5px solid var(--border);
        background: var(--white);
        color: var(--gray);
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .filter-tab:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: var(--hover);
    }

    .filter-tab.active {
        border-color: var(--primary);
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.25);
    }

    .filter-tab .ft-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .reservasi-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .reservasi-card .rc-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .reservasi-card .rc-header .rc-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .reservasi-card .rc-header .rc-title-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--hover);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .reservasi-card .rc-header .rc-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
    }

    .reservasi-card .rc-header .rc-subtitle {
        font-size: 12px;
        color: var(--gray);
        margin-top: 1px;
    }

    .reservasi-card .rc-header .rc-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .search-input-wrap {
        position: relative;
    }

    .search-input-wrap .si-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 12px;
        pointer-events: none;
    }

    .search-input-wrap input {
        padding: 9px 16px 9px 36px;
        border-radius: 100px;
        border: 1.5px solid var(--border);
        background: #FAFAFA;
        font-size: 12px;
        font-family: 'Inter', sans-serif;
        color: var(--dark);
        width: 220px;
        transition: all 0.2s ease;
        outline: none;
    }

    .search-input-wrap input:focus {
        border-color: var(--primary);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(255, 79, 135, 0.1);
        width: 260px;
    }

    .search-input-wrap input::placeholder {
        color: #bbb;
    }

    .reservasi-table {
        width: 100%;
        border-collapse: collapse;
    }

    .reservasi-table thead th {
        padding: 14px 16px;
        font-size: 11px;
        font-weight: 600;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #FAFAFA;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    .reservasi-table thead th:first-child {
        padding-left: 24px;
    }

    .reservasi-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #F5F5F5;
    }

    .reservasi-table tbody tr:last-child {
        border-bottom: none;
    }

    .reservasi-table tbody tr:hover {
        background: #FFF8FA;
    }

    .reservasi-table tbody td {
        padding: 14px 16px;
        font-size: 13px;
        color: var(--dark);
        vertical-align: middle;
    }

    .reservasi-table tbody td:first-child {
        padding-left: 24px;
    }

    .reservasi-table tbody td:last-child {
        padding-right: 24px;
    }

    .reservasi-id-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: var(--primary);
        background: var(--hover);
        letter-spacing: 0.3px;
    }

    .therapist-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .therapist-cell .th-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(255, 79, 135, 0.2);
    }

    .therapist-cell .th-name {
        font-size: 13px;
        font-weight: 500;
        color: var(--dark);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    .status-badge .sb-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        animation: pulse-dot 2s ease-in-out infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    .status-badge.menunggu { background: #FEF3C7; color: #D97706; }
    .status-badge.menunggu .sb-dot { background: #D97706; }
    .status-badge.dikonfirmasi { background: #DBEAFE; color: #2563EB; }
    .status-badge.dikonfirmasi .sb-dot { background: #2563EB; }
    .status-badge.diproses { background: #F3E8FF; color: #9333EA; }
    .status-badge.diproses .sb-dot { background: #9333EA; }
    .status-badge.selesai { background: #D1FAE5; color: #059669; }
    .status-badge.selesai .sb-dot { background: #059669; }
    .status-badge.dibatalkan { background: #FEE2E2; color: #DC2626; }
    .status-badge.dibatalkan .sb-dot { background: #DC2626; }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .action-btn.detail {
        background: #DBEAFE;
        color: #2563EB;
    }

    .action-btn.detail:hover {
        background: #BFDBFE;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .action-btn.print {
        background: #F3E8FF;
        color: #9333EA;
    }

    .action-btn.print:hover {
        background: #E9D5FF;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(147, 51, 234, 0.2);
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
    }

    .empty-state .es-illustration {
        width: 120px;
        height: 120px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #FFF5F8, #FFE5EF);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: var(--primary);
        opacity: 0.6;
    }

    .empty-state h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 6px;
    }

    .empty-state p {
        font-size: 13px;
        color: var(--gray);
        margin-bottom: 20px;
    }

    .table-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .table-footer .tf-info {
        font-size: 12px;
        color: var(--gray);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .table-footer .tf-info .tf-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--primary);
    }

    .table-footer .tf-pagination {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .table-footer .tf-pagination .page-btn {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        background: transparent;
        color: var(--gray);
    }

    .table-footer .tf-pagination .page-btn:hover {
        background: var(--hover);
        color: var(--primary);
    }

    .table-footer .tf-pagination .page-btn.active {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.25);
    }

    .layanan-cell {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .layanan-cell .layanan-name {
        font-weight: 500;
        color: var(--dark);
    }

    .layanan-cell .layanan-price {
        font-size: 11px;
        color: var(--gray);
    }

    .harga-cell {
        font-weight: 600;
        color: var(--dark);
    }

    @media (max-width: 768px) {
        .reservasi-table thead { display: none; }
        .reservasi-table tbody tr {
            display: block;
            padding: 16px;
            border-bottom: 1px solid var(--border);
        }
        .reservasi-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border: none;
            font-size: 13px;
        }
        .reservasi-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--gray);
            font-size: 11px;
            text-transform: uppercase;
        }
        .reservasi-table tbody td:first-child { padding-left: 0; }
        .reservasi-table tbody td:last-child { padding-right: 0; }
    }
    </style>
</head>

<body>
    <div class="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Riwayat Reservasi</h3>
                                <p>Lihat seluruh riwayat reservasi treatment Anda</p>
                            </div>
                        </div>
                        <div class="ph-stats">
                            <div class="ph-stat-item">
                                <div class="ph-stat-num" id="totalCount">0</div>
                                <div class="ph-stat-label">Total</div>
                            </div>
                            <div class="ph-stat-divider"></div>
                            <div class="ph-stat-item">
                                <div class="ph-stat-num" style="color: #F59E0B;" id="pendingCount">0</div>
                                <div class="ph-stat-label">Pending</div>
                            </div>
                            <div class="ph-stat-divider"></div>
                            <div class="ph-stat-item">
                                <div class="ph-stat-num" style="color: #22C55E;" id="selesaiCount">0</div>
                                <div class="ph-stat-label">Selesai</div>
                            </div>
                            <div class="ph-stat-divider"></div>
                            <div class="ph-stat-item">
                                <div class="ph-stat-num" style="color: #DC2626;" id="batalCount">0</div>
                                <div class="ph-stat-label">Dibatalkan</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="filter-tabs">
                    <a href="{{ route('pelanggan.reservasi') }}"
                       class="filter-tab {{ !request('status') ? 'active' : '' }}">
                        <span class="ft-dot" style="background: var(--primary);"></span>
                        Semua
                    </a>
                    <a href="{{ route('pelanggan.reservasi', ['status' => 'menunggu']) }}"
                       class="filter-tab {{ request('status') === 'menunggu' ? 'active' : '' }}">
                        <span class="ft-dot" style="background: #D97706;"></span>
                        Menunggu
                    </a>
                    <a href="{{ route('pelanggan.reservasi', ['status' => 'dikonfirmasi']) }}"
                       class="filter-tab {{ request('status') === 'dikonfirmasi' ? 'active' : '' }}">
                        <span class="ft-dot" style="background: #2563EB;"></span>
                        Dikonfirmasi
                    </a>
                    <a href="{{ route('pelanggan.reservasi', ['status' => 'diproses']) }}"
                       class="filter-tab {{ request('status') === 'diproses' ? 'active' : '' }}">
                        <span class="ft-dot" style="background: #9333EA;"></span>
                        Diproses
                    </a>
                    <a href="{{ route('pelanggan.reservasi', ['status' => 'selesai']) }}"
                       class="filter-tab {{ request('status') === 'selesai' ? 'active' : '' }}">
                        <span class="ft-dot" style="background: #059669;"></span>
                        Selesai
                    </a>
                    <a href="{{ route('pelanggan.reservasi', ['status' => 'dibatalkan']) }}"
                       class="filter-tab {{ request('status') === 'dibatalkan' ? 'active' : '' }}">
                        <span class="ft-dot" style="background: #DC2626;"></span>
                        Dibatalkan
                    </a>
                </div>

                <div class="reservasi-card">
                    <div class="rc-header">
                        <div class="rc-title-wrap">
                            <div class="rc-title-icon">
                                <i class="fa-regular fa-receipt"></i>
                            </div>
                            <div>
                                <div class="rc-title">Daftar Reservasi</div>
                                <div class="rc-subtitle">Semua riwayat reservasi treatment Anda</div>
                            </div>
                        </div>
                        <div class="rc-actions">
                            <form action="{{ route('pelanggan.reservasi') }}" method="GET">
                                @if(request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                                @endif
                                <div class="search-input-wrap">
                                    <i class="fa-solid fa-search si-icon"></i>
                                    <input type="text" name="search" placeholder="Cari reservasi..." value="{{ request('search') }}">
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="reservasi-table">
                            <thead>
                                <tr>
                                    <th>ID Reservasi</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Terapis</th>
                                    <th>Layanan</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th style="text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservasis ?? [] as $reservasi)
                                <tr>
                                    <td>
                                        <span class="reservasi-id-badge">
                                            <i class="fa-regular fa-receipt" style="font-size:10px;"></i>
                                            #RS{{ str_pad($reservasi->id_booking, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td data-label="Tanggal">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-calendar text-gray-300 text-[11px]"></i>
                                            <span>{{ \Carbon\Carbon::parse($reservasi->tanggal)->isoFormat('D MMM YYYY') }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Jam">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock text-gray-300 text-[11px]"></i>
                                            <span>{{ \Carbon\Carbon::parse($reservasi->jam)->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Terapis">
                                        <div class="therapist-cell">
                                            <div class="th-avatar">{{ $reservasi->karyawan ? substr($reservasi->karyawan->nama, 0, 1) : '?' }}</div>
                                            <span class="th-name">{{ $reservasi->karyawan ? $reservasi->karyawan->nama : 'Terapis #'.$reservasi->id_karyawan }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Layanan">
                                        <div class="layanan-cell">
                                            <span class="layanan-name">{{ $reservasi->detail && $reservasi->detail->layanan ? $reservasi->detail->layanan->nm_layanan : '-' }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Harga">
                                        <span class="harga-cell">Rp {{ number_format($reservasi->detail->subtotal ?? 0, 0, ',', '.') }}</span>
                                    </td>
                                    <td data-label="Status">
                                        <span class="status-badge {{ $reservasi->status }}">
                                            <span class="sb-dot"></span>
                                            {{ ucfirst($reservasi->status) }}
                                        </span>
                                    </td>
                                    <td data-label="Aksi" style="text-align:center;">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="#" class="action-btn detail" title="Detail reservasi">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <a href="#" class="action-btn print" title="Cetak invoice">
                                                <i class="fa-regular fa-print"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="es-illustration">
                                                <i class="fa-regular fa-calendar-xmark"></i>
                                            </div>
                                            <h4>Belum Ada Reservasi</h4>
                                            <p>Anda belum memiliki riwayat reservasi treatment.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="table-footer">
                        <div class="tf-info">
                            <span class="tf-dot"></span>
                            Menampilkan {{ ($reservasis ?? collect())->count() }} reservasi
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
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
