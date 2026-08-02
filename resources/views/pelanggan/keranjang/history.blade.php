<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>History Checkout - BeautyCare</title>
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
        gap: 16px;
        flex-wrap: wrap;
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

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 100px;
        border: 1.5px solid var(--primary);
        background: var(--white);
        color: var(--primary);
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.15);
    }

    .btn-back:hover {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        transform: translateY(-1px);
    }

    .history-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .history-card .hc-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .history-card .hc-header .hc-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .history-card .hc-header .hc-title-icon {
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

    .history-card .hc-header .hc-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
    }

    .history-card .hc-header .hc-subtitle {
        font-size: 12px;
        color: var(--gray);
        margin-top: 1px;
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
    }

    .history-table thead th {
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

    .history-table thead th:first-child {
        padding-left: 24px;
    }

    .history-table thead th:last-child {
        padding-right: 24px;
    }

    .history-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #F5F5F5;
    }

    .history-table tbody tr:last-child {
        border-bottom: none;
    }

    .history-table tbody tr:hover {
        background: #FFF8FA;
    }

    .history-table tbody td {
        padding: 14px 16px;
        font-size: 13px;
        color: var(--dark);
        vertical-align: middle;
    }

    .history-table tbody td:first-child {
        padding-left: 24px;
    }

    .history-table tbody td:last-child {
        padding-right: 24px;
    }

    .invoice-badge {
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

    .item-list {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .item-list .item-name {
        font-weight: 500;
        color: var(--dark);
    }

    .item-list .item-meta {
        font-size: 11px;
        color: var(--gray);
    }

    .total-cell {
        font-weight: 700;
        color: var(--dark);
        white-space: nowrap;
    }

    .metode-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 600;
        background: #F0F4FF;
        color: #3B5BDB;
        white-space: nowrap;
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
        background: #D1FAE5;
        color: #059669;
    }

    .status-badge .sb-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #059669;
    }

    .status-badge.sb-menunggu { background: #FEF3C7; color: #B45309; }
    .status-badge.sb-menunggu .sb-dot { background: #F59E0B; }
    .status-badge.sb-diproses { background: #DBEAFE; color: #1D4ED8; }
    .status-badge.sb-diproses .sb-dot { background: #3B82F6; }
    .status-badge.sb-gagal { background: #FEE2E2; color: #B91C1C; }
    .status-badge.sb-gagal .sb-dot { background: #DC2626; }
    .status-badge.sb-kadaluarsa, .status-badge.sb-dibatalkan { background: #F3F4F6; color: #6B7280; }
    .status-badge.sb-kadaluarsa .sb-dot, .status-badge.sb-dibatalkan .sb-dot { background: #9CA3AF; }

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

    .empty-state .btn-keranjang {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        border-radius: 100px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.25);
        transition: all 0.2s ease;
    }

    .empty-state .btn-keranjang:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.35);
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

    @media (max-width: 768px) {
        .history-table thead {
            display: none;
        }

        .history-table tbody tr {
            display: block;
            padding: 16px;
            border-bottom: 1px solid var(--border);
        }

        .history-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border: none;
            font-size: 13px;
        }

        .history-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--gray);
            font-size: 11px;
            text-transform: uppercase;
        }

        .history-table tbody td:first-child {
            padding-left: 0;
        }

        .history-table tbody td:last-child {
            padding-right: 0;
        }
    }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="dashboard-content">
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <div class="ph-text">
                                <h3>History Checkout</h3>
                                <p>Riwayat pembelian dan checkout yang pernah Anda lakukan</p>
                            </div>
                        </div>
                        <a href="{{ route('pelanggan.keranjang') }}" class="btn-back">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Keranjang
                        </a>
                    </div>
                </div>

                <div class="history-card">
                    <div class="hc-header">
                        <div class="hc-title-wrap">
                            <div class="hc-title-icon">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                            <div>
                                <div class="hc-title">Daftar Checkout</div>
                                <div class="hc-subtitle">Semua transaksi pembelian produk Anda</div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="history-table">
                            <thead>
                                <tr>
                                    <th>No. Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Produk</th>
                                    <th>Total</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $transaksi)
                                @php
                                    $metodeIcons = [
                                        'Transfer' => 'fa-solid fa-building-columns',
                                        'Dana' => 'fa-solid fa-qrcode',
                                        'GoPay' => 'fa-solid fa-qrcode',
                                        'OVO' => 'fa-solid fa-qrcode',
                                        'ShopeePay' => 'fa-solid fa-qrcode',
                                        'QRIS' => 'fa-solid fa-qrcode',
                                        'Tunai' => 'fa-solid fa-wallet',
                                        'Kartu' => 'fa-solid fa-credit-card',
                                    ];
                                    $metodeIcon = $metodeIcons[$transaksi->metode_byr] ?? 'fa-solid fa-wallet';
                                @endphp
                                <tr>
                                    <td data-label="No. Invoice">
                                        <span class="invoice-badge">
                                            <i class="fa-solid fa-receipt" style="font-size:10px;"></i>
                                            {{ $transaksi->no_invoice }}
                                        </span>
                                    </td>
                                    <td data-label="Tanggal">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-calendar text-gray-300 text-[11px]"></i>
                                            <span>{{ \Carbon\Carbon::parse($transaksi->tanggal)->isoFormat('D MMM YYYY') }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Produk">
                                        <div class="item-list">
                                            @foreach($transaksi->detail as $detail)
                                            <span class="item-name">{{ $detail->nm_item }}</span>
                                            <span class="item-meta">{{ $detail->qty }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td data-label="Total">
                                        <span class="total-cell">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                                    </td>
                                    <td data-label="Metode Pembayaran">
                                        <span class="metode-badge">
                                            <i class="{{ $metodeIcon }}"></i>
                                            {{ $transaksi->metode_byr }}
                                        </span>
                                    </td>
                                    <td data-label="Status">
                                        @php
                                        $sbClass = [
                                            'Menunggu Pembayaran' => 'sb-menunggu',
                                            'Sedang Diproses' => 'sb-diproses',
                                            'Lunas' => '',
                                            'Gagal' => 'sb-gagal',
                                            'Kadaluarsa' => 'sb-kadaluarsa',
                                            'Dibatalkan' => 'sb-dibatalkan',
                                        ][$transaksi->status] ?? 'sb-kadaluarsa';
                                        @endphp
                                        <span class="status-badge {{ $sbClass }}">
                                            <span class="sb-dot"></span>
                                            {{ $transaksi->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="es-illustration">
                                                <i class="fa-solid fa-clock-rotate-left"></i>
                                            </div>
                                            <h4>Belum Ada Checkout</h4>
                                            <p>Anda belum melakukan checkout dari keranjang.</p>
                                            <a href="{{ route('pelanggan.keranjang') }}" class="btn-keranjang">
                                                <i class="fa-solid fa-cart-shopping"></i> Lihat Keranjang
                                            </a>
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
                            Menampilkan {{ $transaksis->count() }} transaksi
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
