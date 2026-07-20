<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Produk - BeautyCare</title>

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

    .produk-card .pc-body {
        padding: 16px 20px 20px;
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
        margin-bottom: 10px;
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

    .pc-btn-beli {
        padding: 8px 18px;
        border-radius: 100px;
        border: none;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.2);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .pc-btn-beli:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
    }

    .pc-btn-detail {
        padding: 8px 16px;
        border-radius: 100px;
        border: 1.5px solid var(--border);
        background: transparent;
        color: var(--gray);
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .pc-btn-detail:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: var(--hover);
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

    .beli-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .beli-modal.show {
        display: flex;
    }

    .beli-modal .bm-card {
        background: var(--white);
        border-radius: 24px;
        max-width: 420px;
        width: 100%;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        animation: modalIn 0.3s ease;
    }

    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.92) translateY(20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .beli-modal .bm-banner {
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        font-size: 48px;
        color: rgba(255,255,255,0.6);
    }

    .beli-modal .bm-banner.skincare { background: linear-gradient(135deg, #F472B6, #F9A8D4); }
    .beli-modal .bm-banner.haircare { background: linear-gradient(135deg, #34D399, #6EE7B7); }
    .beli-modal .bm-banner.bodycare { background: linear-gradient(135deg, #60A5FA, #93C5FD); }
    .beli-modal .bm-banner.makeup { background: linear-gradient(135deg, #A78BFA, #C4B5FD); }
    .beli-modal .bm-banner.lainnya { background: linear-gradient(135deg, #94A3B8, #CBD5E1); }

    .beli-modal .bm-close {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .beli-modal .bm-close:hover {
        background: rgba(255,255,255,0.35);
        transform: scale(1.05);
    }

    .beli-modal .bm-banner .bm-category-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        padding: 5px 14px;
        border-radius: 100px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .beli-modal .bm-body {
        padding: 24px;
    }

    .beli-modal .bm-body .bm-nama {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .beli-modal .bm-body .bm-kategori {
        font-size: 12px;
        color: var(--gray);
        font-weight: 500;
        margin-bottom: 16px;
    }

    .beli-modal .bm-body .bm-divider {
        height: 1px;
        background: var(--border);
        margin-bottom: 16px;
    }

    .beli-modal .bm-body .bm-harga-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .beli-modal .bm-body .bm-harga {
        font-size: 26px;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 20px;
    }

    .beli-modal .bm-body .bm-qty {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .beli-modal .bm-body .bm-qty label {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
    }

    .beli-modal .bm-body .bm-qty .qty-control {
        display: flex;
        align-items: center;
        gap: 0;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
    }

    .beli-modal .bm-body .bm-qty .qty-control button {
        width: 36px;
        height: 36px;
        border: none;
        background: #FAFAFA;
        color: var(--dark);
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
    }

    .beli-modal .bm-body .bm-qty .qty-control button:hover {
        background: var(--hover);
        color: var(--primary);
    }

    .beli-modal .bm-body .bm-qty .qty-control input {
        width: 50px;
        height: 36px;
        border: none;
        border-left: 1.5px solid var(--border);
        border-right: 1.5px solid var(--border);
        text-align: center;
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        outline: none;
        font-family: 'Inter', sans-serif;
    }

    .bm-btn-beli {
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        border: none;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 16px rgba(255, 79, 135, 0.25);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .bm-btn-beli:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(255, 79, 135, 0.35);
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

        .search-input-wrap input {
            width: 100%;
        }

        .search-input-wrap input:focus {
            width: 100%;
        }
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
                    </div>
                    <div class="pt-right">
                        <div class="search-input-wrap">
                            <i class="fa-solid fa-search si-icon"></i>
                            <input type="text" placeholder="Cari produk..." value="">
                        </div>
                    </div>
                </div>

                <div class="produk-grid">
                    <div class="produk-card">
                        <div class="pc-image">
                            <div class="pc-img-placeholder skincare">
                                <i class="fa-solid fa-spa"></i>
                            </div>
                            <span class="pc-category-badge">Skincare</span>
                        </div>
                        <div class="pc-body">
                            <div class="pc-name">Serum Vitamin C Brightening</div>
                            <div class="pc-category">Skincare</div>
                            <div class="pc-divider"></div>
                            <div class="pc-footer">
                                <div class="pc-price">Rp 125.000 <span>/pcs</span></div>
                                <a href="#" class="pc-btn-beli" data-produk="serum-vitamin-c" data-nama="Serum Vitamin C Brightening" data-kategori="Skincare" data-harga="Rp 125.000" data-harga-numeric="125000" onclick="showBeliModal(this)">
                                    <i class="fa-solid fa-cart-plus"></i> Beli
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="produk-card">
                        <div class="pc-image">
                            <div class="pc-img-placeholder skincare">
                                <i class="fa-solid fa-spa"></i>
                            </div>
                            <span class="pc-category-badge">Skincare</span>
                        </div>
                        <div class="pc-body">
                            <div class="pc-name">Moisturizer Cream Collagen</div>
                            <div class="pc-category">Skincare</div>
                            <div class="pc-divider"></div>
                            <div class="pc-footer">
                                <div class="pc-price">Rp 85.000 <span>/pcs</span></div>
                                <a href="#" class="pc-btn-beli" data-produk="moisturizer-cream" data-nama="Moisturizer Cream Collagen" data-kategori="Skincare" data-harga="Rp 85.000" data-harga-numeric="85000" onclick="showBeliModal(this)">
                                    <i class="fa-solid fa-cart-plus"></i> Beli
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="produk-card">
                        <div class="pc-image">
                            <div class="pc-img-placeholder haircare">
                                <i class="fa-solid fa-scissors"></i>
                            </div>
                            <span class="pc-category-badge">Haircare</span>
                        </div>
                        <div class="pc-body">
                            <div class="pc-name">Shampoo Premium Keratin</div>
                            <div class="pc-category">Haircare</div>
                            <div class="pc-divider"></div>
                            <div class="pc-footer">
                                <div class="pc-price">Rp 65.000 <span>/pcs</span></div>
                                <a href="#" class="pc-btn-beli" data-produk="shampoo-premium" data-nama="Shampoo Premium Keratin" data-kategori="Haircare" data-harga="Rp 65.000" data-harga-numeric="65000" onclick="showBeliModal(this)">
                                    <i class="fa-solid fa-cart-plus"></i> Beli
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="produk-card">
                        <div class="pc-image">
                            <div class="pc-img-placeholder haircare">
                                <i class="fa-solid fa-scissors"></i>
                            </div>
                            <span class="pc-category-badge">Haircare</span>
                        </div>
                        <div class="pc-body">
                            <div class="pc-name">Hair Mask Argan Oil</div>
                            <div class="pc-category">Haircare</div>
                            <div class="pc-divider"></div>
                            <div class="pc-footer">
                                <div class="pc-price">Rp 95.000 <span>/pcs</span></div>
                                <a href="#" class="pc-btn-beli" data-produk="hair-mask" data-nama="Hair Mask Argan Oil" data-kategori="Haircare" data-harga="Rp 95.000" data-harga-numeric="95000" onclick="showBeliModal(this)">
                                    <i class="fa-solid fa-cart-plus"></i> Beli
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="produk-card">
                        <div class="pc-image">
                            <div class="pc-img-placeholder bodycare">
                                <i class="fa-solid fa-hand-sparkles"></i>
                            </div>
                            <span class="pc-category-badge">Bodycare</span>
                        </div>
                        <div class="pc-body">
                            <div class="pc-name">Body Lotion Sakura Glow</div>
                            <div class="pc-category">Bodycare</div>
                            <div class="pc-divider"></div>
                            <div class="pc-footer">
                                <div class="pc-price">Rp 75.000 <span>/pcs</span></div>
                                <a href="#" class="pc-btn-beli" data-produk="body-lotion" data-nama="Body Lotion Sakura Glow" data-kategori="Bodycare" data-harga="Rp 75.000" data-harga-numeric="75000" onclick="showBeliModal(this)">
                                    <i class="fa-solid fa-cart-plus"></i> Beli
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="produk-card">
                        <div class="pc-image">
                            <div class="pc-img-placeholder bodycare">
                                <i class="fa-solid fa-hand-sparkles"></i>
                            </div>
                            <span class="pc-category-badge">Bodycare</span>
                        </div>
                        <div class="pc-body">
                            <div class="pc-name">Body Scrub Coffee Sugar</div>
                            <div class="pc-category">Bodycare</div>
                            <div class="pc-divider"></div>
                            <div class="pc-footer">
                                <div class="pc-price">Rp 89.000 <span>/pcs</span></div>
                                <a href="#" class="pc-btn-beli" data-produk="body-scrub" data-nama="Body Scrub Coffee Sugar" data-kategori="Bodycare" data-harga="Rp 89.000" data-harga-numeric="89000" onclick="showBeliModal(this)">
                                    <i class="fa-solid fa-cart-plus"></i> Beli
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="produk-card">
                        <div class="pc-image">
                            <div class="pc-img-placeholder makeup">
                                <i class="fa-solid fa-palette"></i>
                            </div>
                            <span class="pc-category-badge">Makeup</span>
                        </div>
                        <div class="pc-body">
                            <div class="pc-name">Lipstik Matte Velvet</div>
                            <div class="pc-category">Makeup</div>
                            <div class="pc-divider"></div>
                            <div class="pc-footer">
                                <div class="pc-price">Rp 55.000 <span>/pcs</span></div>
                                <a href="#" class="pc-btn-beli" data-produk="lipstik-matte" data-nama="Lipstik Matte Velvet" data-kategori="Makeup" data-harga="Rp 55.000" data-harga-numeric="55000" onclick="showBeliModal(this)">
                                    <i class="fa-solid fa-cart-plus"></i> Beli
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="produk-card">
                        <div class="pc-image">
                            <div class="pc-img-placeholder makeup">
                                <i class="fa-solid fa-palette"></i>
                            </div>
                            <span class="pc-category-badge">Makeup</span>
                        </div>
                        <div class="pc-body">
                            <div class="pc-name">Setting Spray Matte Finish</div>
                            <div class="pc-category">Makeup</div>
                            <div class="pc-divider"></div>
                            <div class="pc-footer">
                                <div class="pc-price">Rp 68.000 <span>/pcs</span></div>
                                <a href="#" class="pc-btn-beli" data-produk="setting-spray" data-nama="Setting Spray Matte Finish" data-kategori="Makeup" data-harga="Rp 68.000" data-harga-numeric="68000" onclick="showBeliModal(this)">
                                    <i class="fa-solid fa-cart-plus"></i> Beli
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="beli-modal" id="beliModal">
        <div class="bm-card">
            <div class="bm-banner" id="modalBanner">
                <span class="bm-category-badge" id="modalCategoryBadge"></span>
                <div class="um-icon" id="modalIcon"></div>
                <button class="bm-close" onclick="closeBeliModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="bm-body">
                <div class="bm-nama" id="modalNama"></div>
                <div class="bm-kategori" id="modalKategori"></div>
                <div class="bm-divider"></div>
                <div class="bm-harga-label">Harga</div>
                <div class="bm-harga" id="modalHarga"></div>
                <div class="bm-qty">
                    <label>Jumlah</label>
                    <div class="qty-control">
                        <button onclick="qtyMinus()"><i class="fa-solid fa-minus"></i></button>
                        <input type="text" id="qtyInput" value="1" readonly>
                        <button onclick="qtyPlus()"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <button class="bm-btn-beli" onclick="closeBeliModal()">
                    <i class="fa-solid fa-cart-shopping"></i> Tambah ke Keranjang
                </button>
            </div>
        </div>
    </div>

    <script>
    var hargaNumeric = 0;

    var kategoriIcons = {
        'Skincare': '<i class="fa-solid fa-spa"></i>',
        'Haircare': '<i class="fa-solid fa-scissors"></i>',
        'Bodycare': '<i class="fa-solid fa-hand-sparkles"></i>',
        'Makeup': '<i class="fa-solid fa-palette"></i>'
    };

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateTotalHarga() {
        var qty = parseInt(document.getElementById('qtyInput').value) || 1;
        var total = hargaNumeric * qty;
        document.getElementById('modalHarga').textContent = formatRupiah(total);
    }

    function showBeliModal(btn) {
        var nama = btn.getAttribute('data-nama');
        var kategori = btn.getAttribute('data-kategori');
        hargaNumeric = parseInt(btn.getAttribute('data-harga-numeric')) || 0;

        document.getElementById('modalBanner').className = 'bm-banner ' + kategori.toLowerCase();
        document.getElementById('modalIcon').innerHTML = kategoriIcons[kategori] || '<i class="fa-solid fa-cube"></i>';
        document.getElementById('modalCategoryBadge').textContent = kategori;
        document.getElementById('modalNama').textContent = nama;
        document.getElementById('modalKategori').textContent = kategori;
        document.getElementById('qtyInput').value = '1';
        updateTotalHarga();

        document.getElementById('beliModal').classList.add('show');
    }

    function closeBeliModal() {
        document.getElementById('beliModal').classList.remove('show');
    }

    document.getElementById('beliModal').addEventListener('click', function(e) {
        if (e.target === this) closeBeliModal();
    });

    function qtyPlus() {
        var input = document.getElementById('qtyInput');
        input.value = parseInt(input.value) + 1;
        updateTotalHarga();
    }

    function qtyMinus() {
        var input = document.getElementById('qtyInput');
        var val = parseInt(input.value);
        if (val > 1) input.value = val - 1;
        updateTotalHarga();
    }

    document.getElementById('qtyInput').addEventListener('input', updateTotalHarga);

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
            var cardKategori = card.querySelector('.pc-category').textContent.trim();
            var nama = card.querySelector('.pc-name').textContent.toLowerCase();

            var matchKategori = (currentKategori === 'semua' || cardKategori === currentKategori);
            var matchSearch = nama.includes(searchTerm);

            card.style.display = (matchKategori && matchSearch) ? '' : 'none';
        });
    }

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
