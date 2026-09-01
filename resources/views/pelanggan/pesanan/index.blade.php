<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pesanan Saya - BeautyCare</title>
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

    .pesanan-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .pesanan-card .pc-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pesanan-card .pc-header .pc-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pesanan-card .pc-header .pc-title-icon {
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

    .pesanan-card .pc-header .pc-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
    }

    .pesanan-card .pc-header .pc-subtitle {
        font-size: 12px;
        color: var(--gray);
        margin-top: 1px;
    }

    .pesanan-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 16px 24px;
        border-bottom: 1px solid #F5F5F5;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .pesanan-item:hover {
        background: #FFF8FA;
    }

    .pesanan-item:last-child {
        border-bottom: none;
    }

    .pi-main {
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1;
        min-width: 0;
    }

    .pi-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #FFF5F8;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .pi-info .pi-invoice {
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pi-info .pi-meta {
        font-size: 11.5px;
        color: var(--gray);
        margin-top: 3px;
    }

    .pi-info .pi-meta i {
        font-size: 10px;
    }

    .pi-right {
        text-align: right;
        flex-shrink: 0;
    }

    .pi-right .pi-total {
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
    }

    .pi-right .pi-action {
        font-size: 11px;
        color: var(--primary);
        font-weight: 600;
        margin-top: 3px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    .status-badge .sb-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .status-menunggu { background: #FEF3C7; color: #B45309; }
    .status-menunggu .sb-dot { background: #F59E0B; }
    .status-diproses { background: #DBEAFE; color: #1D4ED8; }
    .status-diproses .sb-dot { background: #3B82F6; }
    .status-lunas { background: #D1FAE5; color: #059669; }
    .status-lunas .sb-dot { background: #059669; }
    .status-dp { background: #EDE9FE; color: #6D28D9; }
    .status-dp .sb-dot { background: #7C3AED; }
    .status-gagal { background: #FEE2E2; color: #B91C1C; }
    .status-gagal .sb-dot { background: #DC2626; }
    .status-kadaluarsa, .status-dibatalkan { background: #F3F4F6; color: #6B7280; }
    .status-kadaluarsa .sb-dot, .status-dibatalkan .sb-dot { background: #9CA3AF; }

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

    @media (max-width: 640px) {
        .pesanan-item {
            flex-wrap: wrap;
        }

        .pi-right {
            text-align: left;
            padding-left: 58px;
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
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Pesanan Saya</h3>
                                <p>Semua pesanan online yang pernah Anda buat</p>
                            </div>
                        </div>
                        <a href="{{ route('pelanggan.produk') }}" class="btn-back">
                            <i class="fa-solid fa-store"></i> Belanja Produk
                        </a>
                    </div>
                </div>

                <div class="pesanan-card">
                    <div class="pc-header">
                        <div class="pc-title-wrap">
                            <div class="pc-title-icon">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                            <div>
                                <div class="pc-title">Daftar Pesanan</div>
                                <div class="pc-subtitle">Riwayat lengkap pesanan produk Anda</div>
                            </div>
                        </div>
                    </div>

                    @forelse($pesanan as $p)
                    <a href="{{ route('pelanggan.pesanan.show', $p->id_transaksi) }}" class="pesanan-item">
                        <div class="pi-main">
                            <div class="pi-icon">
                                @if($p->status === 'Lunas' || $p->status === 'DP Dibayar')
                                <i class="fa-solid fa-check-circle"></i>
                                @elseif($p->status === 'Menunggu Pembayaran')
                                <i class="fa-regular fa-clock"></i>
                                @else
                                <i class="fa-solid fa-box"></i>
                                @endif
                            </div>
                            <div class="pi-info">
                                <div class="pi-invoice">
                                    {{ $p->no_invoice }}
                                    @php
                                    $badgeClass = [
                                        'Menunggu Pembayaran' => 'status-menunggu',
                                        'Sedang Diproses' => 'status-diproses',
                                        'Lunas' => 'status-lunas',
                                        'DP Dibayar' => 'status-dp',
                                        'Gagal' => 'status-gagal',
                                        'Kadaluarsa' => 'status-kadaluarsa',
                                        'Dibatalkan' => 'status-dibatalkan',
                                    ][$p->status] ?? 'status-kadaluarsa';
                                    @endphp
                                    <span class="status-badge {{ $badgeClass }}">
                                        <span class="sb-dot"></span>
                                        {{ $p->status }}
                                    </span>
                                </div>
                                <div class="pi-meta">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($p->tanggal)->isoFormat('D MMM YYYY') }}
                                    &bull; {{ $p->pembayaran ? $p->pembayaran->provider : $p->metode_byr }}
                                    &bull; {{ $p->detail->count() }} item
                                </div>
                            </div>
                        </div>
                        <div class="pi-right">
                            <div class="pi-total">Rp {{ number_format($p->total, 0, ',', '.') }}</div>
                            <div class="pi-action">
                                @if($p->status === 'Menunggu Pembayaran')
                                Bayar sekarang <i class="fa-solid fa-arrow-right" style="font-size:9px;"></i>
                                @else
                                Lihat detail <i class="fa-solid fa-arrow-right" style="font-size:9px;"></i>
                                @endif
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="empty-state">
                        <div class="es-illustration">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <h4>Belum Ada Pesanan</h4>
                        <p>Anda belum memiliki pesanan produk online.</p>
                        <a href="{{ route('pelanggan.produk') }}" class="btn-keranjang">
                            <i class="fa-solid fa-store"></i> Mulai Belanja
                        </a>
                    </div>
                    @endforelse

                    <div class="table-footer">
                        <div class="tf-info">
                            <span class="tf-dot"></span>
                            Menampilkan {{ $pesanan->count() }} pesanan
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
