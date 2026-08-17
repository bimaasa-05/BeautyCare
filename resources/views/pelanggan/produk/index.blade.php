<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Produk - BeautyCare</title>
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

    .produk-tools {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .produk-tools .pt-left {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .produk-tools .pt-right {
        display: flex;
        align-items: center;
        gap: 10px;
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
        font-family: 'Poppins', sans-serif;
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
        font-family: 'Poppins', sans-serif;
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

    .produk-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }

    .produk-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .produk-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px -8px rgba(255, 79, 135, 0.15);
    }

    .produk-card .pc-image {
        height: 180px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.3s ease;
    }

    .produk-card .pc-image:hover {
        transform: scale(1.03);
    }

    .produk-card .pc-image .pc-img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: rgba(255,255,255,0.6);
    }

    .produk-card .pc-image .pc-img-placeholder.skincare {
        background: linear-gradient(135deg, #F472B6, #F9A8D4);
    }

    .produk-card .pc-image .pc-img-placeholder.haircare {
        background: linear-gradient(135deg, #34D399, #6EE7B7);
    }

    .produk-card .pc-image .pc-img-placeholder.bodycare {
        background: linear-gradient(135deg, #60A5FA, #93C5FD);
    }

    .produk-card .pc-image .pc-img-placeholder.makeup {
        background: linear-gradient(135deg, #A78BFA, #C4B5FD);
    }

    .produk-card .pc-image .pc-img-placeholder.nailcare {
        background: linear-gradient(135deg, #F43F5E, #FB7185);
    }

    .produk-card .pc-image .pc-img-placeholder.lainnya {
        background: linear-gradient(135deg, #94A3B8, #CBD5E1);
    }

    .produk-card .pc-image .pc-category-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 4px 12px;
        border-radius: 100px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .produk-card .pc-image .pc-favorit-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: none;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .produk-card .pc-image .pc-favorit-btn:hover {
        transform: scale(1.1);
        background: rgba(255,255,255,0.35);
    }

    .produk-card .pc-image .pc-favorit-btn.active {
        background: #fff;
        color: #FF4F87;
    }

    .produk-card .pc-image .pc-favorit-count {
        position: absolute;
        top: 52px;
        right: 12px;
        padding: 3px 10px;
        border-radius: 100px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .sort-group {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--white);
        border: 1.5px solid var(--border);
        border-radius: 100px;
        padding: 4px 6px 4px 14px;
        box-shadow: 0 2px 10px -4px rgba(0, 0, 0, 0.05);
    }

    .sort-group .sort-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        color: var(--gray);
        white-space: nowrap;
    }

    .sort-group .sort-label i {
        color: var(--primary);
        font-size: 12px;
    }

    .sort-group .sort-pills {
        display: flex;
        align-items: center;
        gap: 4px;
        background: #F5F0F2;
        border-radius: 100px;
        padding: 3px;
    }

    .sort-group .sort-pill {
        padding: 6px 14px;
        border-radius: 100px;
        border: none;
        background: transparent;
        font-size: 11px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        color: var(--gray);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .sort-group .sort-pill:hover {
        color: var(--primary);
    }

    .sort-group .sort-pill.active {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 3px 10px rgba(255, 79, 135, 0.3);
    }

    @media (max-width: 900px) {
        .sort-group {
            border-radius: 16px;
            flex-wrap: wrap;
            padding: 8px 10px;
        }
    }

    .produk-card .pc-body {
        padding: 16px 20px 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .produk-card .pc-body .pc-name {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 3px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .produk-card .pc-body .pc-category {
        font-size: 11px;
        color: var(--gray);
        font-weight: 500;
        margin-bottom: 4px;
    }

    .produk-card .pc-body .pc-rating {
        font-size: 12px;
        color: var(--gray);
        font-weight: 500;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .produk-card .pc-body .pc-rating i {
        color: #F59E0B;
    }

    .produk-card .pc-body .pc-rating b {
        color: var(--dark);
        font-weight: 600;
    }

    .produk-card .pc-body .pc-divider {
        height: 1px;
        background: var(--border);
        margin-bottom: 10px;
    }

    .produk-card .pc-body .pc-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: auto;
        padding-top: 8px;
    }

    .produk-card .pc-body .pc-price {
        font-size: 17px;
        font-weight: 800;
        color: var(--dark);
    }

    .produk-card .pc-body .pc-price span {
        font-size: 11px;
        font-weight: 500;
        color: var(--gray);
    }

    .produk-card .pc-body .pc-keranjang-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 100px;
        border: none;
        background: linear-gradient(135deg, #10B981, #34D399);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        white-space: nowrap;
    }

    .produk-card .pc-body .pc-keranjang-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(16, 185, 129, 0.35);
    }

    .produk-card .pc-body .pc-keranjang-btn:active {
        transform: translateY(0);
    }

    .produk-card .pc-body .pc-keranjang-btn:disabled,
    .produk-card .pc-body .pc-keranjang-btn:disabled:hover {
        opacity: 0.55;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .pc-name-link {
        color: var(--dark);
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .pc-name-link:hover {
        color: var(--primary);
    }

    .produk-empty {
        text-align: center;
        padding: 60px 20px;
    }

    .produk-empty .pe-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: linear-gradient(135deg, #FFF5F8, #FFE5EF);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: var(--primary);
        opacity: 0.6;
    }

    .produk-empty h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 6px;
    }

    .produk-empty p {
        font-size: 13px;
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
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
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
        background: rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }



    @media (max-width: 768px) {
        .produk-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 12px;
        }

        .produk-card .pc-image {
            height: 140px;
        }

        .produk-tools {
            flex-direction: column;
            align-items: stretch;
        }

        .search-input-wrap {
            flex: 1 1 100%;
        }

        .search-input-wrap input {
            width: 100%;
        }

        .search-input-wrap input:focus {
            width: 100%;
        }

        .checkout-modal .cmp-group {
            grid-template-columns: 1fr;
        }

        .page-header-premium { padding: 22px 20px; }
        .filter-tab { padding: 7px 14px; font-size: 11px; }
        .cart-notif { left: 16px; right: 16px; max-width: none; }
    }

    @media (max-width: 576px) {
        .page-header-premium .ph-text h3 { font-size: 17px; }
        .page-header-premium .ph-icon-wrap { width: 44px; height: 44px; border-radius: 13px; font-size: 18px; }
        .produk-grid { grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 10px; }
        .produk-card .pc-body { padding: 12px 14px 14px; }
        .checkout-modal .cm-header { padding: 16px 16px 0; }
        .checkout-modal .cm-items { padding: 12px 16px; }
        .checkout-modal .cm-total { padding: 12px 16px; }
        .checkout-modal .cm-payment { padding: 0 16px 16px; }
        .checkout-modal .cm-bayar { margin: 0 16px 16px; width: calc(100% - 32px); }
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
                                <h3>Produk</h3>
                                <p>Temukan berbagai produk kecantikan terbaik untuk Anda</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="produk-tools">
                    <div class="pt-left">
                        <a href="javascript:void(0)" class="filter-tab active" data-kategori="semua" onclick="filterProduk('semua')">
                            <i class="fa-solid fa-th-large"></i> Semua
                        </a>
                        <a href="javascript:void(0)" class="filter-tab" data-kategori="Skincare" onclick="filterProduk('Skincare')">
                            <i class="fa-solid fa-spa"></i> Skincare
                        </a>
                        <a href="javascript:void(0)" class="filter-tab" data-kategori="Haircare" onclick="filterProduk('Haircare')">
                            <i class="fa-solid fa-scissors"></i> Haircare
                        </a>
                        <a href="javascript:void(0)" class="filter-tab" data-kategori="Bodycare" onclick="filterProduk('Bodycare')">
                            <i class="fa-solid fa-hand-sparkles"></i> Bodycare
                        </a>
                        <a href="javascript:void(0)" class="filter-tab" data-kategori="Makeup" onclick="filterProduk('Makeup')">
                            <i class="fa-solid fa-palette"></i> Makeup
                        </a>
                        <a href="javascript:void(0)" class="filter-tab" data-kategori="Nailcare" onclick="filterProduk('Nailcare')">
                            <i class="fa-solid fa-hand"></i> Nailcare
                        </a>
                    </div>
                    <div class="pt-right">
                        <div class="sort-group" title="Urutkan produk">
                            <span class="sort-label"><i class="fa-solid fa-arrow-down-wide-short"></i> Urutkan</span>
                            <div class="sort-pills">
                                <button type="button" class="sort-pill active" data-sort="terbaru" onclick="setSort('terbaru', this)">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Terbaru
                                </button>
                                <button type="button" class="sort-pill" data-sort="favorit" onclick="setSort('favorit', this)">
                                    <i class="fa-solid fa-heart"></i> Favorit
                                </button>
                                <button type="button" class="sort-pill" data-sort="beli" onclick="setSort('beli', this)">
                                    <i class="fa-solid fa-ranking-star"></i> Terlaris
                                </button>
                                <button type="button" class="sort-pill" data-sort="rating-desc" onclick="setSort('rating-desc', this)">
                                    <i class="fa-solid fa-star"></i> Rating Tertinggi
                                </button>
                                <button type="button" class="sort-pill" data-sort="rating-asc" onclick="setSort('rating-asc', this)">
                                    <i class="fa-solid fa-star-half-stroke"></i> Rating Terendah
                                </button>
                            </div>
                        </div>
                        <div class="search-input-wrap">
                            <i class="fa-solid fa-search si-icon"></i>
                            <input type="text" placeholder="Cari produk..." value="">
                        </div>
                    </div>
                </div>

                <div class="produk-grid">
                    @forelse($produks as $produk)
                    @php
                        $nmKategori = $produk->kategori?->nm_produk ?? 'Lainnya';
                        $kategoriLower = strtolower(str_replace(' ', '', $nmKategori));
                        $classMap = ['skincare' => 'skincare', 'haircare' => 'haircare', 'bodycare' => 'bodycare', 'makeup' => 'makeup', 'nailcare' => 'nailcare'];
                        $iconMap = ['skincare' => 'fa-spa', 'haircare' => 'fa-scissors', 'bodycare' => 'fa-hand-sparkles', 'makeup' => 'fa-palette', 'nailcare' => 'fa-hand'];
                        $class = $classMap[$kategoriLower] ?? 'lainnya';
                        $icon = $iconMap[$kategoriLower] ?? 'fa-cube';
                    @endphp
                    <div class="produk-card" data-id="{{ $produk->id_produk }}" data-favorit="{{ $produk->favorit_count }}" data-beli="{{ $produk->beli_count }}" data-rating="{{ $produk->rating_rata }}">
                        <a href="{{ route('pelanggan.produk.detail', $produk->id_produk) }}" class="pc-image">
                            @if ($produk->foto)
                                <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nm_produk }}" style="width:100%;height:100%;object-fit:cover;">
                            @else
                                <div class="pc-img-placeholder {{ $class }}">
                                    <i class="fa-solid {{ $icon }}"></i>
                                </div>
                            @endif
                            <span class="pc-category-badge">{{ $nmKategori }}</span>
                            <button class="pc-favorit-btn {{ in_array($produk->id_produk, $favoritProdukIds) ? 'active' : '' }}" data-id="{{ $produk->id_produk }}" onclick="toggleFavorit(this)" title="Favoritkan produk">
                                <i class="fa-solid fa-heart"></i>
                            </button>
                            <span class="pc-favorit-count"><i class="fa-solid fa-heart"></i> {{ $produk->favorit_count }}</span>
                        </a>
                        <div class="pc-body">
                            <a href="{{ route('pelanggan.produk.detail', $produk->id_produk) }}" class="pc-name-link">{{ $produk->nm_produk }}</a>
                            <div class="pc-category">{{ $nmKategori }}</div>
                            <div class="pc-rating">
                                <i class="fa-solid fa-star"></i>
                                <b>{{ number_format($produk->rating_rata, 1, ',', '.') }}</b>
                                <span>({{ $produk->rating_jumlah }})</span>
                            </div>
                            <div class="pc-divider"></div>
                            <div class="pc-footer">
                                <div class="pc-price">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }} <span>/{{ $produk->satuan }}</span></div>
                                <button class="pc-keranjang-btn" onclick="tambahKeranjangCard(this)" data-id="{{ $produk->id_produk }}" data-nama="{{ $produk->nm_produk }}" data-kategori="{{ $nmKategori }}" data-harga="{{ $produk->harga_jual }}" {{ $produk->stok > 0 ? '' : 'disabled' }} title="{{ $produk->stok > 0 ? 'Tambah ke keranjang' : 'Stok habis' }}">
                                    <i class="fa-solid fa-cart-plus"></i> Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="produk-empty" style="grid-column:1/-1;">
                        <div class="pe-icon">
                            <i class="fa-solid fa-cube"></i>
                        </div>
                        <h4>Belum Ada Produk</h4>
                        <p>Belum ada produk yang tersedia saat ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <div class="cart-notif" id="cartNotif">
        <div class="cn-icon"><i class="fa-solid fa-check"></i></div>
        <span id="cartNotifMsg">Berhasil ditambahkan ke keranjang!</span>
    </div>

    <script>
    function showNotif(msg) {
        var el = document.getElementById('cartNotif');
        document.getElementById('cartNotifMsg').textContent = msg;
        el.classList.add('show');
        setTimeout(function() { el.classList.remove('show'); }, 3000);
    }

    var currentKategori = 'semua';

    function filterProduk(kategori) {
        currentKategori = kategori;
        document.querySelectorAll('.filter-tab').forEach(function(tab) {
            tab.classList.remove('active');
            if (tab.getAttribute('data-kategori') === kategori) {
                tab.classList.add('active');
            }
        });
        applyFilters();
    }

    function applyFilters() {
        var searchTerm = document.querySelector('.search-input-wrap input').value.toLowerCase();
        document.querySelectorAll('.produk-card').forEach(function(card) {
            var cardKategori = card.querySelector('.pc-category').textContent.trim().replace(/\s+/g, '').toLowerCase();
            var nama = card.querySelector('.pc-name-link').textContent.toLowerCase();
            var current = currentKategori.replace(/\s+/g, '').toLowerCase();

            var matchKategori = (currentKategori === 'semua' || cardKategori === current);
            var matchSearch = nama.includes(searchTerm);

            card.style.display = (matchKategori && matchSearch) ? '' : 'none';
        });
    }

    var currentSort = 'terbaru';

    function setSort(mode, btn) {
        document.querySelectorAll('.sort-pill').forEach(function(p) {
            p.classList.remove('active');
        });
        if (btn) btn.classList.add('active');
        applySort(mode);
    }

    function applySort(mode) {
        currentSort = mode;
        document.querySelectorAll('.sort-pill').forEach(function(p) {
            p.classList.toggle('active', p.getAttribute('data-sort') === mode);
        });
        var grid = document.querySelector('.produk-grid');
        var cards = Array.prototype.slice.call(grid.querySelectorAll('.produk-card'));

        cards.sort(function(a, b) {
            var va, vb;
            if (mode === 'favorit') {
                va = parseInt(a.getAttribute('data-favorit')) || 0;
                vb = parseInt(b.getAttribute('data-favorit')) || 0;
            } else if (mode === 'beli') {
                va = parseInt(a.getAttribute('data-beli')) || 0;
                vb = parseInt(b.getAttribute('data-beli')) || 0;
            } else if (mode === 'rating-desc') {
                va = parseFloat(a.getAttribute('data-rating')) || 0;
                vb = parseFloat(b.getAttribute('data-rating')) || 0;
                if (va !== vb) return vb - va;
                return (parseInt(b.getAttribute('data-id')) || 0) - (parseInt(a.getAttribute('data-id')) || 0);
            } else if (mode === 'rating-asc') {
                va = parseFloat(a.getAttribute('data-rating')) || 0;
                vb = parseFloat(b.getAttribute('data-rating')) || 0;
                if (va !== vb) return va - vb;
                return (parseInt(b.getAttribute('data-id')) || 0) - (parseInt(a.getAttribute('data-id')) || 0);
            } else {
                va = parseInt(a.getAttribute('data-id')) || 0;
                vb = parseInt(b.getAttribute('data-id')) || 0;
            }
            if (vb !== va) return vb - va;
            return (parseInt(b.getAttribute('data-id')) || 0) - (parseInt(a.getAttribute('data-id')) || 0);
        });

        cards.forEach(function(card) {
            grid.appendChild(card);
        });
        applyFilters();
    }

    function toggleFavorit(btn) {
        event.preventDefault();
        event.stopPropagation();
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
                (data.affected || []).forEach(function(item) {
                    var card = document.querySelector('.produk-card[data-id="' + item.id_produk + '"]');
                    if (card) {
                        card.setAttribute('data-favorit', item.count);
                        var countEl = card.querySelector('.pc-favorit-count');
                        if (countEl) countEl.innerHTML = '<i class="fa-solid fa-heart"></i> ' + item.count;
                    }
                });
                if (currentSort === 'favorit') applySort('favorit');
                showNotif(data.in_favorit ? 'Produk berhasil difavoritkan' : 'Favorit produk dihapus');
            }
        })
        .catch(function() { alert('Terjadi kesalahan'); });
    }

    function tambahKeranjangCard(btn) {
        event.preventDefault();
        event.stopPropagation();
        var csrf = document.querySelector('meta[name="csrf-token"]').content;

        fetch('{{ route("pelanggan.keranjang.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({
                nm_produk: btn.getAttribute('data-nama'),
                produk_slug: btn.getAttribute('data-id'),
                kategori: btn.getAttribute('data-kategori'),
                harga_satuan: parseInt(btn.getAttribute('data-harga')),
                qty: 1
            })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                showNotif(data.message);
                localStorage.removeItem('cart_seen');
                updateCartBadge();
            }
        })
        .catch(function() { alert('Terjadi kesalahan'); });
    }

    document.addEventListener('DOMContentLoaded', function() {
        applySort('terbaru');
    });

    document.querySelector('.search-input-wrap input').addEventListener('input', applyFilters);

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
