<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $produk->nm_produk }} - BeautyCare</title>
    @include('partials.head-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
        gap: 12px;
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

    .btn-history {
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
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.15);
    }

    .btn-history:hover {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
    }

    .produk-detail {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1.2fr);
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .produk-detail {
            grid-template-columns: 1fr;
        }
    }

    .pd-media {
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        background: var(--white);
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        min-height: 340px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pd-media .pd-img {
        width: 100%;
        height: 100%;
        min-height: 420px;
        object-fit: cover;
        display: block;
    }

    .pd-media .pd-img-placeholder {
        width: 100%;
        min-height: 420px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 72px;
        color: rgba(255, 255, 255, 0.6);
    }

    .pd-media .pd-img-placeholder.skincare { background: linear-gradient(135deg, #F472B6, #F9A8D4); }
    .pd-media .pd-img-placeholder.haircare { background: linear-gradient(135deg, #34D399, #6EE7B7); }
    .pd-media .pd-img-placeholder.bodycare { background: linear-gradient(135deg, #60A5FA, #93C5FD); }
    .pd-media .pd-img-placeholder.makeup { background: linear-gradient(135deg, #A78BFA, #C4B5FD); }
    .pd-media .pd-img-placeholder.nailcare { background: linear-gradient(135deg, #F43F5E, #FB7185); }
    .pd-media .pd-img-placeholder.lainnya { background: linear-gradient(135deg, #94A3B8, #CBD5E1); }

    .pd-media .pd-category-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        padding: 6px 16px;
        border-radius: 100px;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .pd-media .pd-favorit-btn {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .pd-media .pd-favorit-btn:hover {
        transform: scale(1.1);
        background: rgba(255, 255, 255, 0.4);
    }

    .pd-media .pd-favorit-btn.active {
        background: #fff;
        color: #FF4F87;
    }

    .pd-info {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        padding: 28px;
    }

    .pd-info .pd-nama {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 6px;
    }

    .pd-info .pd-kategori {
        font-size: 13px;
        color: var(--gray);
        font-weight: 500;
        margin-bottom: 14px;
    }

    .pd-stats {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .pd-stat {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 100px;
        background: #FFF5F8;
        color: var(--primary);
        font-size: 12px;
        font-weight: 600;
    }

    .pd-stat .ps-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .pd-stat.tersedia { background: #D1FAE5; color: #059669; }
    .pd-stat.habis { background: #FEE2E2; color: #DC2626; }

    .pd-price-wrap {
        background: linear-gradient(135deg, #FFF5F8, #FFE5EF);
        border: 1px solid rgba(255, 79, 135, 0.1);
        border-radius: 16px;
        padding: 18px 20px;
        margin-bottom: 20px;
    }

    .pd-price-wrap .pd-price-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .pd-price-wrap .pd-price {
        font-size: 28px;
        font-weight: 800;
        color: var(--primary);
    }

    .pd-price-wrap .pd-price span {
        font-size: 13px;
        font-weight: 500;
        color: var(--gray);
    }

    .pd-qty {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
    }

    .pd-qty label {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
    }

    .pd-qty .qty-control {
        display: flex;
        align-items: center;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
    }

    .pd-qty .qty-control button {
        width: 40px;
        height: 40px;
        border: none;
        background: #FAFAFA;
        color: var(--dark);
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
    }

    .pd-qty .qty-control button:hover {
        background: var(--hover);
        color: var(--primary);
    }

    .pd-qty .qty-control button:disabled,
    .pd-qty .qty-control button:disabled:hover {
        opacity: 0.45;
        cursor: not-allowed;
        background: #FAFAFA;
        color: var(--gray);
    }

    .pd-qty .qty-control input {
        width: 56px;
        height: 40px;
        border: none;
        border-left: 1.5px solid var(--border);
        border-right: 1.5px solid var(--border);
        text-align: center;
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        outline: none;
        font-family: 'Poppins', sans-serif;
    }

    .pd-subtotal {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 14px 18px;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        margin-bottom: 20px;
    }

    .pd-subtotal .pds-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--gray);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .pd-subtotal .pds-label i {
        color: var(--primary);
    }

    .pd-subtotal .pds-nominal {
        font-size: 20px;
        font-weight: 800;
        color: var(--dark);
    }

    .pd-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 10px;
    }

    @media (max-width: 576px) {
        .pd-actions {
            grid-template-columns: 1fr;
        }
    }

    .pd-btn {
        padding: 14px;
        border-radius: 14px;
        border: none;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .pd-btn:hover {
        transform: translateY(-2px);
    }

    .pd-btn-beli {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 16px rgba(255, 79, 135, 0.25);
    }

    .pd-btn-keranjang {
        background: linear-gradient(135deg, #10B981, #34D399);
        color: #fff;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.25);
    }

    .pd-btn:disabled {
        opacity: 0.55;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    .pd-divider {
        height: 1px;
        background: var(--border);
        margin: 22px 0;
    }

    .pd-section-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .pd-section-title i {
        color: var(--primary);
        font-size: 16px;
    }

    .pd-deskripsi p {
        font-size: 13px;
        line-height: 1.8;
        color: var(--gray);
        margin: 0 0 14px;
    }

    .pd-info-row {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 9px 0;
        border-bottom: 1px solid #F5F5F5;
        font-size: 13px;
    }

    .pd-info-row:last-child {
        border-bottom: none;
    }

    .pd-info-row .pir-label {
        color: var(--gray);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .pd-info-row .pir-label i {
        color: var(--primary);
        font-size: 13px;
        width: 16px;
        text-align: center;
    }

    .pd-info-row .pir-value {
        color: var(--dark);
        font-weight: 600;
        text-align: right;
    }

    .produk-lainnya {
        margin-top: 28px;
    }

    .produk-lainnya .pl-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .produk-lainnya .pl-header h4 {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .produk-lainnya .pl-header h4 i {
        color: var(--primary);
    }

    .produk-lainnya .pl-link {
        font-size: 12px;
        font-weight: 600;
        color: var(--primary);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .produk-lainnya .pl-link:hover {
        text-decoration: underline;
    }

    .produk-lainnya .pl-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }

    .produk-lainnya .pl-card {
        background: var(--white);
        border-radius: 16px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
    }

    .produk-lainnya .pl-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px -8px rgba(255, 79, 135, 0.15);
    }

    .produk-lainnya .pl-card .plc-image {
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .produk-lainnya .pl-card .plc-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .produk-lainnya .pl-card .plc-img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        color: rgba(255, 255, 255, 0.6);
    }

    .produk-lainnya .pl-card .plc-img-placeholder.skincare { background: linear-gradient(135deg, #F472B6, #F9A8D4); }
    .produk-lainnya .pl-card .plc-img-placeholder.haircare { background: linear-gradient(135deg, #34D399, #6EE7B7); }
    .produk-lainnya .pl-card .plc-img-placeholder.bodycare { background: linear-gradient(135deg, #60A5FA, #93C5FD); }
    .produk-lainnya .pl-card .plc-img-placeholder.makeup { background: linear-gradient(135deg, #A78BFA, #C4B5FD); }
    .produk-lainnya .pl-card .plc-img-placeholder.nailcare { background: linear-gradient(135deg, #F43F5E, #FB7185); }
    .produk-lainnya .pl-card .plc-img-placeholder.lainnya { background: linear-gradient(135deg, #94A3B8, #CBD5E1); }

    .produk-lainnya .pl-card .plc-body {
        padding: 14px 16px 16px;
    }

    .produk-lainnya .pl-card .plc-name {
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .produk-lainnya .pl-card .plc-kategori {
        font-size: 11px;
        color: var(--gray);
        font-weight: 500;
        margin-bottom: 8px;
    }

    .produk-lainnya .pl-card .plc-price {
        font-size: 15px;
        font-weight: 800;
        color: var(--dark);
    }

    .produk-lainnya .pl-card .plc-price span {
        font-size: 10px;
        font-weight: 500;
        color: var(--gray);
    }

    .cart-notif {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 9999;
        background: #166534;
        color: #fff;
        padding: 14px 24px;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 10px;
        transform: translateX(120%);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        max-width: 380px;
    }

    .cart-notif.show {
        transform: translateX(0);
    }

    .cart-notif .cn-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .page-header-premium { padding: 22px 20px; }
        .pd-info { padding: 20px; }
        .pd-media .pd-img, .pd-media .pd-img-placeholder { min-height: 300px; }
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
                                <i class="fa-solid fa-cube"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Detail Produk</h3>
                                <p>Temukan berbagai produk kecantikan terbaik untuk Anda</p>
                            </div>
                        </div>
                        <a href="{{ route('pelanggan.produk') }}" class="btn-history">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Produk
                        </a>
                    </div>
                </div>

                @php
                    $nmKategori = $produk->kategori?->nm_produk ?? 'Lainnya';
                    $kategoriLower = strtolower(str_replace(' ', '', $nmKategori));
                    $classMap = ['skincare' => 'skincare', 'haircare' => 'haircare', 'bodycare' => 'bodycare', 'makeup' => 'makeup', 'nailcare' => 'nailcare'];
                    $iconMap = ['skincare' => 'fa-spa', 'haircare' => 'fa-scissors', 'bodycare' => 'fa-hand-sparkles', 'makeup' => 'fa-palette', 'nailcare' => 'fa-hand'];
                    $class = $classMap[$kategoriLower] ?? 'lainnya';
                    $icon = $iconMap[$kategoriLower] ?? 'fa-cube';
                    $stokTersedia = $produk->stok > 0;
                @endphp

                <div class="produk-detail">
                    <div class="pd-media">
                        @if ($produk->foto)
                            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nm_produk }}" class="pd-img">
                        @else
                            <div class="pd-img-placeholder {{ $class }}">
                                <i class="fa-solid {{ $icon }}"></i>
                            </div>
                        @endif
                        <span class="pd-category-badge">{{ $nmKategori }}</span>
                        <button class="pd-favorit-btn {{ $isFavorit ? 'active' : '' }}" data-id="{{ $produk->id_produk }}" onclick="toggleFavorit(this)" title="Favoritkan produk">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                    </div>

                    <div class="pd-info">
                        <div class="pd-nama">{{ $produk->nm_produk }}</div>
                        <div class="pd-kategori">{{ $nmKategori }}</div>

                        <div class="pd-stats">
                            <span class="pd-stat {{ $stokTersedia ? 'tersedia' : 'habis' }}">
                                <span class="ps-dot"></span>
                                {{ $stokTersedia ? 'Stok Tersedia' : 'Stok Habis' }}
                            </span>
                            <span class="pd-stat">
                                <i class="fa-solid fa-fire"></i> {{ $beliCount }} Terjual
                            </span>
                            <span class="pd-stat">
                                <i class="fa-solid fa-heart"></i> {{ $favoritCount }} Favorit
                            </span>
                        </div>

                        <div class="pd-price-wrap">
                            <div class="pd-price-label">Harga</div>
                            <div class="pd-price">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }} <span>/{{ $produk->satuan }}</span></div>
                        </div>

                        <div class="pd-qty">
                            <label>Jumlah</label>
                            <div class="qty-control">
                                <button id="qtyMinusBtn" onclick="qtyMinus()" {{ $stokTersedia ? '' : 'disabled' }}><i class="fa-solid fa-minus"></i></button>
                                <input type="text" id="qtyInput" value="1" readonly>
                                <button id="qtyPlusBtn" onclick="qtyPlus()" {{ $stokTersedia ? '' : 'disabled' }}><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="pd-subtotal">
                            <span class="pds-label"><i class="fa-solid fa-receipt"></i> Subtotal (<span id="pdsQty">1</span> item)</span>
                            <span class="pds-nominal" id="pdsNominal">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</span>
                        </div>

                        <div class="pd-actions">
                            <button class="pd-btn pd-btn-beli" onclick="beliLangsung()" {{ $stokTersedia ? '' : 'disabled' }}>
                                <i class="fa-solid fa-bolt"></i> Beli Langsung
                            </button>
                            <button class="pd-btn pd-btn-keranjang" onclick="tambahKeranjang()" {{ $stokTersedia ? '' : 'disabled' }}>
                                <i class="fa-solid fa-cart-plus"></i> Tambah ke Keranjang
                            </button>
                        </div>

                        @if (!$stokTersedia)
                        <div style="font-size:12px;color:#DC2626;font-weight:600;margin-top:6px;">
                            <i class="fa-solid fa-triangle-exclamation"></i> Produk sedang habis, silakan cek kembali nanti.
                        </div>
                        @endif

                        <div class="pd-divider"></div>

                        <div class="pd-section-title">
                            <i class="fa-solid fa-file-lines"></i> Deskripsi Produk
                        </div>
                        <div class="pd-deskripsi">
                            @if ($produk->deskripsi)
                                <p>{{ $produk->deskripsi }}</p>
                            @else
                                <p>{{ $produk->nm_produk }} adalah produk kecantikan kategori <strong>{{ $nmKategori }}</strong> berkualitas dari BeautyCare. Dibanderol dengan harga <strong>Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</strong> per {{ $produk->satuan }}, produk ini telah terpercaya dan banyak dipilih pelanggan untuk kebutuhan perawatan kecantikan Anda sehari-hari.</p>
                                <p>Dapatkan hasil terbaik dengan pemakaian rutin. Tersedia sisa stok sebanyak <strong>{{ $produk->stok }} {{ $produk->satuan }}</strong>. Jangan lewatkan kesempatan untuk memiliki produk andalan BeautyCare ini.</p>
                            @endif
                        </div>

                        <div class="pd-divider"></div>

                        <div class="pd-section-title">
                            <i class="fa-solid fa-circle-info"></i> Informasi Produk
                        </div>
                        <div class="pd-info-row">
                            <span class="pir-label"><i class="fa-solid fa-tag"></i> Kategori</span>
                            <span class="pir-value">{{ $nmKategori }}</span>
                        </div>
                        <div class="pd-info-row">
                            <span class="pir-label"><i class="fa-solid fa-cube"></i> Nama Produk</span>
                            <span class="pir-value">{{ $produk->nm_produk }}</span>
                        </div>
                        <div class="pd-info-row">
                            <span class="pir-label"><i class="fa-solid fa-weight-scale"></i> Satuan</span>
                            <span class="pir-value">{{ $produk->satuan }}</span>
                        </div>
                        <div class="pd-info-row">
                            <span class="pir-label"><i class="fa-solid fa-boxes-stacked"></i> Stok</span>
                            <span class="pir-value">{{ $produk->stok }} {{ $produk->satuan }}</span>
                        </div>
                        <div class="pd-info-row">
                            <span class="pir-label"><i class="fa-solid fa-circle-check"></i> Status</span>
                            <span class="pir-value">{{ $produk->status }}</span>
                        </div>
                        <div class="pd-info-row">
                            <span class="pir-label"><i class="fa-solid fa-fire"></i> Total Terjual</span>
                            <span class="pir-value">{{ $beliCount }} {{ $produk->satuan }}</span>
                        </div>
                        <div class="pd-info-row">
                            <span class="pir-label"><i class="fa-solid fa-heart"></i> Favorit</span>
                            <span class="pir-value">{{ $favoritCount }} Pelanggan</span>
                        </div>
                    </div>
                </div>

                @if ($produkLainnya->isNotEmpty())
                <div class="produk-lainnya">
                    <div class="pl-header">
                        <h4><i class="fa-solid fa-cubes"></i> Produk {{ $nmKategori }} Lainnya</h4>
                        <a href="{{ route('pelanggan.produk') }}" class="pl-link">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="pl-grid">
                        @foreach ($produkLainnya as $lain)
                        @php
                            $lainKategori = $lain->kategori?->nm_produk ?? 'Lainnya';
                            $lainLower = strtolower(str_replace(' ', '', $lainKategori));
                            $lainClass = $classMap[$lainLower] ?? 'lainnya';
                            $lainIcon = $iconMap[$lainLower] ?? 'fa-cube';
                        @endphp
                        <a href="{{ route('pelanggan.produk.detail', $lain->id_produk) }}" class="pl-card">
                            <div class="plc-image">
                                @if ($lain->foto)
                                    <img src="{{ asset('storage/' . $lain->foto) }}" alt="{{ $lain->nm_produk }}">
                                @else
                                    <div class="plc-img-placeholder {{ $lainClass }}">
                                        <i class="fa-solid {{ $lainIcon }}"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="plc-body">
                                <div class="plc-name">{{ $lain->nm_produk }}</div>
                                <div class="plc-kategori">{{ $lainKategori }}</div>
                                <div class="plc-price">Rp {{ number_format($lain->harga_jual, 0, ',', '.') }} <span>/{{ $lain->satuan }}</span></div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </main>
    </div>

    <div class="cart-notif" id="cartNotif">
        <div class="cn-icon"><i class="fa-solid fa-check"></i></div>
        <span id="cartNotifMsg">Berhasil ditambahkan ke keranjang!</span>
    </div>

    <script>
    var currentProdukId = '{{ $produk->id_produk }}';
    var currentProdukNama = '{{ addslashes($produk->nm_produk) }}';
    var currentKategori = '{{ addslashes($nmKategori) }}';
    var currentHarga = {{ (int) $produk->harga_jual }};
    var stokProdukDetail = {{ (int) $produk->stok }};
    var stokTersediaDetail = {{ $stokTersedia ? 'true' : 'false' }};

    function showNotif(msg) {
        var el = document.getElementById('cartNotif');
        document.getElementById('cartNotifMsg').textContent = msg;
        el.classList.add('show');
        setTimeout(function() { el.classList.remove('show'); }, 3000);
    }

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateSubtotal() {
        var qty = parseInt(document.getElementById('qtyInput').value) || 1;
        document.getElementById('pdsQty').textContent = qty;
        document.getElementById('pdsNominal').textContent = formatRupiah(currentHarga * qty);

        var minus = document.getElementById('qtyMinusBtn');
        if (minus) minus.disabled = !stokTersediaDetail || qty <= 1;
        var plus = document.getElementById('qtyPlusBtn');
        if (plus) plus.disabled = !stokTersediaDetail || qty >= stokProdukDetail;
    }

    function qtyPlus() {
        var input = document.getElementById('qtyInput');
        var val = parseInt(input.value);
        if (!stokTersediaDetail || val >= stokProdukDetail) return;
        input.value = val + 1;
        updateSubtotal();
    }

    function qtyMinus() {
        var input = document.getElementById('qtyInput');
        var val = parseInt(input.value);
        if (val > 1) input.value = val - 1;
        updateSubtotal();
    }

    updateSubtotal();

    function tambahKeranjang() {
        var qty = parseInt(document.getElementById('qtyInput').value) || 1;
        var csrf = document.querySelector('meta[name="csrf-token"]').content;

        fetch('{{ route("pelanggan.keranjang.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({
                nm_produk: currentProdukNama,
                produk_slug: currentProdukId,
                kategori: currentKategori,
                harga_satuan: currentHarga,
                qty: qty
            })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.success) {
                showNotif(data.message);
                localStorage.removeItem('cart_seen');
                var badge = document.getElementById('cartBadgeSidebar');
                if (badge) {
                    badge.textContent = data.count;
                    badge.style.display = data.count > 0 ? '' : 'none';
                }
            }
        })
        .catch(function() { alert('Terjadi kesalahan'); });
    }

    function beliLangsung() {
        var qty = parseInt(document.getElementById('qtyInput').value) || 1;
        window.location.href = '{{ route("pelanggan.checkout") }}?beli=' + currentProdukId + '&qty=' + qty;
    }

    function toggleFavorit(btn) {
        var id = btn.getAttribute('data-id');
        var csrf = document.querySelector('meta[name="csrf-token"]').content;

        fetch('{{ route("pelanggan.favorit.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ id_produk: id })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                btn.classList.toggle('active', data.in_favorit);
                showNotif(data.in_favorit ? 'Produk berhasil difavoritkan' : 'Favorit produk dihapus');
            }
        })
        .catch(function() { alert('Terjadi kesalahan'); });
    }

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
