<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keranjang - BeautyCare</title>
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

    .keranjang-tools {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .keranjang-tools .kt-left {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .keranjang-tools .kt-info-total {
        font-size: 13px;
        color: var(--gray);
        font-weight: 500;
    }

    .keranjang-tools .kt-info-total strong {
        color: var(--dark);
        font-weight: 700;
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

    .keranjang-tools .kt-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .select-all-wrap {
        display: none;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 10px;
        background: var(--hover);
        border: 1.5px solid var(--border);
        font-size: 12px;
        font-weight: 600;
        color: var(--gray);
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
        user-select: none;
    }

    .select-all-wrap.show {
        display: inline-flex;
    }

    .select-all-wrap:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    .select-all-wrap input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--primary);
        cursor: pointer;
        margin: 0;
    }

    .select-all-wrap label {
        cursor: pointer;
    }

    .btn-hapus-sebagian {
        padding: 10px 22px;
        border-radius: 12px;
        border: 1.5px solid #fecaca;
        background: linear-gradient(135deg, #fff5f5, #fff);
        color: #dc2626;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.06);
    }

    .btn-hapus-sebagian:hover {
        background: linear-gradient(135deg, #fef2f2, #fff5f5);
        border-color: #f87171;
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.12);
        transform: translateY(-1px);
    }

    .btn-hapus-sebagian.active {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.3);
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
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.15);
    }

    .btn-history:hover {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
    }

    .btn-hapus-sebagian.active:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        box-shadow: 0 6px 24px rgba(239, 68, 68, 0.4);
        transform: translateY(-2px);
    }

    #btnBatalHapus {
        border-color: #e2e8f0;
        background: linear-gradient(135deg, #f8fafc, #fff);
        color: #64748b;
        box-shadow: none;
    }

    #btnBatalHapus:hover {
        border-color: #cbd5e1;
        background: linear-gradient(135deg, #f1f5f9, #f8fafc);
        color: #475569;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transform: translateY(-1px);
    }

    .keranjang-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .keranjang-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }

    .keranjang-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px -8px rgba(255, 79, 135, 0.15);
    }

    .keranjang-card .kc-image {
        height: 160px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .keranjang-card .kc-image .kc-img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        color: rgba(255,255,255,0.6);
    }

    .keranjang-card .kc-image .kc-img-placeholder.skincare {
        background: linear-gradient(135deg, #F472B6, #F9A8D4);
    }

    .keranjang-card .kc-image .kc-img-placeholder.haircare {
        background: linear-gradient(135deg, #34D399, #6EE7B7);
    }

    .keranjang-card .kc-image .kc-img-placeholder.bodycare {
        background: linear-gradient(135deg, #60A5FA, #93C5FD);
    }

    .keranjang-card .kc-image .kc-img-placeholder.nailcare {
        background: linear-gradient(135deg, #F43F5E, #FB7185);
    }

    .keranjang-card .kc-image .kc-img-placeholder.makeup {
        background: linear-gradient(135deg, #A78BFA, #C4B5FD);
    }

    .keranjang-card .kc-image .kc-img-placeholder.lainnya {
        background: linear-gradient(135deg, #94A3B8, #CBD5E1);
    }

    .keranjang-card .kc-image .kc-category-badge {
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

    .keranjang-card .kc-image .kc-checkbox-wrap {
        position: absolute;
        top: 12px;
        right: 12px;
        display: none;
    }

    .keranjang-card .kc-image .kc-checkbox-wrap.show {
        display: block;
    }

    .keranjang-card .kc-image .kc-checkbox-wrap input {
        width: 18px;
        height: 18px;
        accent-color: var(--primary);
        cursor: pointer;
        border-radius: 4px;
    }

    .keranjang-card .kc-body {
        padding: 16px 20px 20px;
    }

    .keranjang-card .kc-body .kc-nama {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 2px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .keranjang-card .kc-body .kc-kategori {
        font-size: 11px;
        color: var(--gray);
        font-weight: 500;
        margin-bottom: 10px;
    }

    .keranjang-card .kc-body .kc-divider {
        height: 1px;
        background: var(--border);
        margin-bottom: 10px;
    }

    .keranjang-card .kc-body .kc-harga {
        font-size: 16px;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 12px;
    }

    .keranjard-card .kc-body .kc-harga span {
        font-size: 11px;
        font-weight: 500;
        color: var(--gray);
    }

    .keranjang-card .kc-qty-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
    }

    .keranjang-card .kc-qty-row .kc-qty-control {
        display: inline-flex;
        align-items: center;
        gap: 0;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
    }

    .keranjang-card .kc-qty-row .kc-qty-control button {
        width: 32px;
        height: 32px;
        border: none;
        background: #FAFAFA;
        color: var(--dark);
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
    }

    .keranjang-card .kc-qty-row .kc-qty-control button:hover {
        background: var(--hover);
        color: var(--primary);
    }

    .keranjang-card .kc-qty-row .kc-qty-control .kc-qty-val {
        width: 40px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        border-left: 1.5px solid var(--border);
        border-right: 1.5px solid var(--border);
    }

    .keranjang-card .kc-qty-row .kc-subtotal {
        text-align: right;
    }

    .keranjang-card .kc-qty-row .kc-subtotal .kcs-label {
        font-size: 10px;
        font-weight: 600;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .keranjang-card .kc-qty-row .kc-subtotal .kcs-nominal {
        font-size: 15px;
        font-weight: 800;
        color: var(--primary);
    }

    .keranjang-card .kc-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        padding-top: 4px;
    }

    .keranjang-card .kc-actions .kc-btn-detail {
        flex: 1;
        padding: 8px 16px;
        border-radius: 100px;
        border: 1.5px solid var(--border);
        background: transparent;
        color: var(--gray);
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
    }

    .keranjang-card .kc-actions .kc-btn-detail:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: var(--hover);
    }

    .keranjang-card .kc-actions .kc-btn-hapus {
        padding: 8px 14px;
        border-radius: 100px;
        border: 1.5px solid #fee2e2;
        background: #fff;
        color: #ef4444;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        text-decoration: none;
    }

    .keranjang-card .kc-actions .kc-btn-hapus:hover {
        background: #fef2f2;
        border-color: #fecaca;
    }

    .keranjang-card .kc-check-indicator {
        display: none;
        position: absolute;
        top: 8px;
        right: 8px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--primary);
        color: #fff;
        font-size: 14px;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(255, 79, 135, 0.3);
        z-index: 2;
        pointer-events: none;
    }

    .keranjang-card .kc-check-indicator.show {
        display: flex;
    }

    .keranjang-footer {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        padding: 24px 32px;
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .keranjang-footer .kf-total-label {
        font-size: 13px;
        color: var(--gray);
        font-weight: 500;
    }

    .keranjang-footer .kf-total {
        font-size: 28px;
        font-weight: 800;
        color: var(--dark);
    }

    .keranjang-footer .kf-total span {
        font-size: 14px;
        font-weight: 500;
        color: var(--gray);
    }

    .keranjang-footer .kf-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-belanja {
        padding: 10px 24px;
        border-radius: 100px;
        border: none;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-belanja:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
    }

    .btn-belanja-outline {
        background: transparent;
        color: var(--gray);
        border: 1.5px solid var(--border);
        box-shadow: none;
    }

    .btn-belanja-outline:hover {
        border-color: var(--primary);
        color: var(--primary);
        box-shadow: none;
        transform: translateY(-2px);
    }

    .keranjang-empty {
        text-align: center;
        padding: 80px 20px;
    }

    .keranjang-empty .ke-icon {
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

    .keranjang-empty h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 6px;
    }

    .keranjang-empty p {
        font-size: 13px;
        color: var(--gray);
        margin-bottom: 20px;
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

    .detail-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .detail-modal.show {
        display: flex;
    }

    .detail-modal .dm-card {
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

    .detail-modal .dm-banner {
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        font-size: 48px;
        color: rgba(255,255,255,0.6);
    }

    .detail-modal .dm-banner.skincare { background: linear-gradient(135deg, #F472B6, #F9A8D4); }
    .detail-modal .dm-banner.haircare { background: linear-gradient(135deg, #34D399, #6EE7B7); }
    .detail-modal .dm-banner.bodycare { background: linear-gradient(135deg, #60A5FA, #93C5FD); }
    .detail-modal .dm-banner.nailcare { background: linear-gradient(135deg, #F43F5E, #FB7185); }
    .detail-modal .dm-banner.makeup { background: linear-gradient(135deg, #A78BFA, #C4B5FD); }
    .detail-modal .dm-banner.lainnya { background: linear-gradient(135deg, #94A3B8, #CBD5E1); }

    .detail-modal .dm-close {
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

    .detail-modal .dm-close:hover {
        background: rgba(255,255,255,0.35);
        transform: scale(1.05);
    }

    .detail-modal .dm-banner .dm-category-badge {
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

    .detail-modal .dm-body {
        padding: 24px;
    }

    .detail-modal .dm-body .dm-nama {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .detail-modal .dm-body .dm-kategori {
        font-size: 12px;
        color: var(--gray);
        font-weight: 500;
        margin-bottom: 16px;
    }

    .detail-modal .dm-body .dm-divider {
        height: 1px;
        background: var(--border);
        margin-bottom: 16px;
    }

    .detail-modal .dm-body .dm-harga-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .detail-modal .dm-body .dm-harga {
        font-size: 26px;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 8px;
    }

    .detail-modal .dm-body .dm-qty-info {
        font-size: 13px;
        color: var(--gray);
        font-weight: 500;
        margin-bottom: 20px;
    }


<<<<<<< HEAD
    /* â”€â”€â”€ Modal Premium â”€â”€â”€ */
=======
    .checkout-modal.show {
        display: flex;
    }

    .checkout-modal .cm-card {
        background: var(--white);
        border-radius: 24px;
        max-width: 520px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        animation: modalIn 0.3s ease;
    }

    .checkout-modal .cm-header {
        padding: 24px 28px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .checkout-modal .cm-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .checkout-modal .cm-close {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: #f1f5f9;
        color: var(--gray);
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .checkout-modal .cm-close:hover {
        background: #e2e8f0;
    }

    .checkout-modal .cm-items {
        padding: 16px 28px;
        max-height: 240px;
        overflow-y: auto;
    }

    .checkout-modal .cm-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--border);
        gap: 12px;
    }

    .checkout-modal .cm-item:last-child {
        border-bottom: none;
    }

    .checkout-modal .cm-item .cmi-left {
        flex: 1;
        min-width: 0;
    }

    .checkout-modal .cm-item .cmi-nama {
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .checkout-modal .cm-item .cmi-qty {
        font-size: 11px;
        color: var(--gray);
        font-weight: 500;
    }

    .checkout-modal .cm-item .cmi-harga {
        font-size: 14px;
        font-weight: 700;
        color: var(--primary);
        white-space: nowrap;
    }

    .checkout-modal .cm-divider {
        height: 1px;
        background: var(--border);
        margin: 0 28px;
    }

    .checkout-modal .cm-total {
        padding: 16px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .checkout-modal .cm-total .cmt-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--gray);
    }

    .checkout-modal .cm-total .cmt-nominal {
        font-size: 22px;
        font-weight: 800;
        color: var(--dark);
    }

    .checkout-modal .cm-payment {
        padding: 0 28px 24px;
    }

    .checkout-modal .cm-payment .cmp-title {
        font-size: 12px;
        font-weight: 700;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .checkout-modal .cmp-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .checkout-modal .cmp-option {
        position: relative;
    }

    .checkout-modal .cmp-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .checkout-modal .cmp-option label {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: #FAFAFA;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 12px;
        font-weight: 600;
        color: var(--dark);
        font-family: 'Poppins', sans-serif;
    }

    .checkout-modal .cmp-option label:hover {
        border-color: var(--primary);
        background: var(--hover);
    }

    .checkout-modal .cmp-option input:checked + label {
        border-color: var(--primary);
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.2);
    }

    .checkout-modal .cm-bayar {
        margin: 0 28px 24px;
        width: calc(100% - 56px);
        padding: 14px;
        border-radius: 12px;
        border: none;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        box-shadow: 0 4px 16px rgba(255, 79, 135, 0.25);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .checkout-modal .cm-bayar:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(255, 79, 135, 0.35);
    }

    @media (max-width: 768px) {
        .keranjang-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .keranjang-card .kc-image {
            height: 140px;
        }

        .keranjang-tools {
            flex-direction: column;
            align-items: stretch;
        }

        .keranjang-tools .kt-left {
            flex-direction: column;
            align-items: stretch;
        }

        .search-input-wrap input {
            width: 100%;
        }

        .search-input-wrap input:focus {
            width: 100%;
        }

        .keranjang-tools .kt-actions {
            justify-content: flex-end;
        }

        .keranjang-footer {
            flex-direction: column;
            text-align: center;
        }

        .keranjang-footer .kf-buttons {
            justify-content: center;
        }

        .checkout-modal .cmp-group {
            grid-template-columns: 1fr;
        }

        .page-header-premium { padding: 22px 20px; }
        .keranjang-card .kc-body { padding: 12px 14px 14px; }
        .keranjang-tools .kt-actions { flex-wrap: wrap; gap: 8px; }
    }

    @media (max-width: 576px) {
        .page-header-premium .ph-text h3 { font-size: 17px; }
        .page-header-premium .ph-icon-wrap { width: 44px; height: 44px; border-radius: 13px; font-size: 18px; }
        .keranjang-tools .kt-actions .btn-primary-rounded { flex: 1; justify-content: center; }
        .checkout-modal .cm-header { padding: 16px 16px 0; }
        .checkout-modal .cm-items { padding: 12px 16px; }
        .checkout-modal .cm-total { padding: 12px 16px; }
        .checkout-modal .cm-payment { padding: 0 16px 16px; }
        .checkout-modal .cm-bayar { margin: 0 16px 16px; width: calc(100% - 32px); }
    }

    /* ─── Modal Premium ─── */
>>>>>>> 357fd1431f743dcc3322899f04711b817ce83046
    .modal-premium {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(4px);
        z-index: 200;
        display: none;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.2s ease;
    }

    .modal-premium.show {
        display: flex;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-premium .modal-box {
        background: var(--white);
        border-radius: 24px;
        padding: 32px;
        width: 100%;
        max-width: 400px;
        margin: 0 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        animation: scaleIn 0.3s ease;
    }

    @keyframes scaleIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .modal-premium .modal-box .modal-icon-wrap {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #FEE2E2;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .modal-premium .modal-box .modal-icon-wrap i {
        font-size: 28px;
        color: #DC2626;
    }

    .modal-premium .modal-box h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
        text-align: center;
        margin-bottom: 8px;
    }

    .modal-premium .modal-box p {
        font-size: 13px;
        color: var(--gray);
        text-align: center;
        margin-bottom: 24px;
        line-height: 1.6;
    }

    .modal-premium .modal-box .modal-actions {
        display: flex;
        gap: 12px;
    }

    .modal-premium .modal-box .modal-actions .btn-cancel {
        flex: 1;
        padding: 11px 20px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: var(--white);
        color: var(--gray);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .modal-premium .modal-box .modal-actions .btn-cancel:hover {
        background: var(--background);
        border-color: #ddd;
    }

    .modal-premium .modal-box .modal-actions .btn-danger {
        flex: 1;
        padding: 11px 20px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #DC2626, #EF4444);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
    }

    .modal-premium .modal-box .modal-actions .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.35);
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
                                <i class="fa-solid fa-cart-shopping"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Keranjang</h3>
                                <p>Daftar produk yang Anda pilih untuk dibeli</p>
                            </div>
                        </div>
                        <a href="{{ route('pelanggan.keranjang.history') }}" class="btn-history">
                            <i class="fa-solid fa-clock-rotate-left"></i> History
                        </a>
                    </div>
                </div>

                @if(session('success'))
                <div id="cartNotifData" data-msg="{{ session('success') }}" style="display:none;"></div>
                @endif

                @if($troli->count() > 0)
                    <div class="keranjang-tools">
                        <div class="kt-left">
                            <div class="search-input-wrap">
                                <i class="fa-solid fa-search si-icon"></i>
                                <input type="text" id="searchInput" placeholder="Cari produk di keranjang..." oninput="cariProduk()">
                            </div>
                            <div class="kt-info-total">
                                {{ $troli->count() }} produk di keranjang
                            </div>
                        </div>
                        <div class="kt-actions">
                            <div class="select-all-wrap" id="selectAllWrap">
                                <input type="checkbox" id="cbSelectAll" onchange="toggleAll(event)">
                                <label for="cbSelectAll">Pilih Semua</label>
                            </div>
                            <button class="btn-hapus-sebagian" id="btnBatalHapus" onclick="toggleHapusMode()" style="display: none;">
                                <i class="fa-solid fa-xmark"></i> Batal
                            </button>
                            <button class="btn-hapus-sebagian" id="btnHapusSebagian" onclick="onHapusBtnClick()">
                                <i class="fa-solid fa-check-square"></i> Hapus Sebagian
                            </button>
                        </div>
                    </div>

                    <div class="keranjang-grid" id="keranjangGrid">
                        @foreach($troli as $item)
                        <div class="keranjang-card" data-id="{{ $item->id }}">
                            <div class="kc-image">
                                <div class="kc-img-placeholder {{ str_replace(' ', '', strtolower($item->kategori)) }}">
                                    @php
                                        $iconMap = [
                                            'Skincare' => 'fa-solid fa-spa',
                                            'Hair Care' => 'fa-solid fa-scissors',
                                            'Body Care' => 'fa-solid fa-hand-sparkles',
                                            'Nail Care' => 'fa-solid fa-hand',
                                            'Makeup' => 'fa-solid fa-palette',
                                        ];
                                        $icon = $iconMap[$item->kategori] ?? 'fa-solid fa-cube';
                                    @endphp
                                    <i class="{{ $icon }}"></i>
                                </div>
                                <span class="kc-category-badge">{{ $item->kategori }}</span>
                                <div class="kc-checkbox-wrap" id="cbWrap-{{ $item->id }}">
                                    <input type="checkbox" class="cb-hapus" value="{{ $item->id }}">
                                </div>
                            </div>
                            <div class="kc-body">
                                <div class="kc-nama">{{ $item->nm_produk }}</div>
                                <div class="kc-kategori">{{ $item->kategori }}</div>
                                <div class="kc-divider"></div>

                                <div class="kc-harga">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }} <span>/pcs</span></div>

                                <div class="kc-qty-row">
                                    <div class="kc-qty-control">
                                        <button onclick="updateQty({{ $item->id }}, -1)"><i class="fa-solid fa-minus"></i></button>
                                        <span class="kc-qty-val" id="qty-{{ $item->id }}">{{ $item->qty }}</span>
                                        <button onclick="updateQty({{ $item->id }}, 1)"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                    <div class="kc-subtotal">
                                        <div class="kcs-label">Subtotal</div>
                                        <div class="kcs-nominal" id="total-item-{{ $item->id }}">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</div>
                                    </div>
                                </div>

                                <div class="kc-divider"></div>

                                <div class="kc-actions">
                                    <a href="javascript:void(0)" class="kc-btn-detail" onclick="showDetail({{ $item->id }})">
                                        <i class="fa-regular fa-eye"></i> Selengkapnya
                                    </a>
                                    <button onclick="confirmDelete({{ $item->id }})" class="kc-btn-hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="keranjang-footer">
                        <div>
                            <div class="kf-total-label">Total Belanja</div>
                            <div class="kf-total" id="grandTotal">Rp {{ number_format($total, 0, ',', '.') }} <span></span></div>
                        </div>
                        <div class="kf-buttons">
                            <a href="{{ route('pelanggan.produk') }}" class="btn-belanja btn-belanja-outline">
                                <i class="fa-solid fa-arrow-left"></i> Lanjut Belanja
                            </a>
                            <a href="{{ route('pelanggan.checkout') }}" class="btn-belanja">
                                <i class="fa-solid fa-credit-card"></i> Checkout
                            </a>
                        </div>
                    </div>
                @endif

                    <div class="keranjang-empty" id="keranjangEmpty" style="display: {{ $troli->count() > 0 ? 'none' : '' }};">
                        <div class="ke-icon">
                            <i class="fa-solid fa-cart-plus"></i>
                        </div>
                        <h4>Keranjang Kosong</h4>
                        <p>Belum ada produk yang ditambahkan ke keranjang.</p>
                        <a href="{{ route('pelanggan.produk') }}" class="btn-belanja">
                            <i class="fa-solid fa-store"></i> Mulai Belanja
                        </a>
                    </div>
            </div>

            <div class="cart-notif" id="cartNotif">
                <div class="cn-icon"><i class="fa-solid fa-check"></i></div>
                <span id="cartNotifMsg">Berhasil!</span>
            </div>

            <div class="detail-modal" id="detailModal">
                <div class="dm-card">
                    <div class="dm-banner" id="dmBanner">
                        <span class="dm-category-badge" id="dmCategoryBadge"></span>
                        <div id="dmIcon"></div>
                        <button class="dm-close" onclick="closeDetail()">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="dm-body">
                        <div class="dm-nama" id="dmNama"></div>
                        <div class="dm-kategori" id="dmKategori"></div>
                        <div class="dm-divider"></div>
                        <div class="dm-harga-label">Harga Satuan</div>
                        <div class="dm-harga" id="dmHarga"></div>
                        <div class="dm-qty-info" id="dmQty">Jumlah: -</div>
                        <div class="dm-divider"></div>
                        <div class="dm-harga-label">Subtotal</div>
                        <div class="dm-harga" id="dmSubtotal" style="color: var(--dark);"></div>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- â•â•â• Modal Delete Premium â•â•â• -->
    <div id="deleteModal" class="modal-premium">
        <div class="modal-box">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-icon-wrap">
                    <i class="fa-regular fa-trash-can"></i>
                </div>
                <h3 id="modalDeleteTitle">Hapus Produk</h3>
                <p id="modalDeleteBody">Apakah Anda yakin ingin menghapus produk ini?<br>Tindakan ini tidak dapat dibatalkan.</p>
                <div class="modal-actions">
                    <button type="button" onclick="closeDeleteModal()" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-danger">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    var kategoriIcons = {
        'Skincare': '<i class="fa-solid fa-spa"></i>',
        'Hair Care': '<i class="fa-solid fa-scissors"></i>',
        'Body Care': '<i class="fa-solid fa-hand-sparkles"></i>',
        'Nail Care': '<i class="fa-solid fa-hand"></i>',
        'Makeup': '<i class="fa-solid fa-palette"></i>'
    };

    var detailData = {};

    function formatAngka(n) {
        return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function showDetail(id) {
        var nama = document.querySelector('.keranjang-card[data-id="' + id + '"] .kc-nama').textContent;
        var kategori = document.querySelector('.keranjang-card[data-id="' + id + '"] .kc-kategori').textContent;
        var hargaText = document.querySelector('.keranjang-card[data-id="' + id + '"] .kc-harga').textContent.trim();
        var qty = document.getElementById('qty-' + id).textContent;
        var subtotal = document.getElementById('total-item-' + id).textContent;

        var banner = document.getElementById('dmBanner');
        banner.className = 'dm-banner ' + kategori.toLowerCase().replace(/\s+/g, '');
        document.getElementById('dmIcon').innerHTML = kategoriIcons[kategori] || '<i class="fa-solid fa-cube"></i>';
        document.getElementById('dmCategoryBadge').textContent = kategori;
        document.getElementById('dmNama').textContent = nama;
        document.getElementById('dmKategori').textContent = kategori;
        document.getElementById('dmHarga').textContent = hargaText;
        document.getElementById('dmQty').textContent = 'Jumlah: ' + qty + ' pcs';
        document.getElementById('dmSubtotal').textContent = subtotal;

        document.getElementById('detailModal').classList.add('show');
    }

    function closeDetail() {
        document.getElementById('detailModal').classList.remove('show');
    }

    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) closeDetail();
    });

    function updateQty(id, delta) {
        var valEl = document.getElementById('qty-' + id);
        var curr = parseInt(valEl.textContent);
        var newQty = curr + delta;
        if (newQty < 1) return;

        var csrf = document.querySelector('meta[name="csrf-token"]').content;

        fetch('/pelanggan/keranjang/' + id, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ qty: newQty })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                valEl.textContent = newQty;

                var totalEl = document.getElementById('total-item-' + id);
                totalEl.textContent = 'Rp ' + formatAngka(data.total_item);

                var grandEl = document.getElementById('grandTotal');
                grandEl.textContent = 'Rp ' + formatAngka(data.total_all);
            }
        });
    }

    var hapusMode = false;
    var deleteMode = 'single';
    var deleteId = null;

    function onHapusBtnClick() {
        if (hapusMode) {
            confirmBatchDelete();
        } else {
            toggleHapusMode();
        }
    }

    function confirmDelete(id) {
        deleteMode = 'single';
        deleteId = id;
        document.getElementById('deleteForm').action = '/pelanggan/keranjang/' + id;
        document.getElementById('modalDeleteTitle').textContent = 'Hapus Produk';
        document.getElementById('modalDeleteBody').innerHTML = 'Apakah Anda yakin ingin menghapus produk ini?<br>Tindakan ini tidak dapat dibatalkan.';
        document.getElementById('deleteModal').classList.add('show');
    }

    function confirmBatchDelete() {
        var selected = [];
        document.querySelectorAll('.cb-hapus:checked').forEach(function(cb) {
            selected.push(cb.value);
        });
        if (selected.length === 0) {
            showNotif('Pilih produk yang ingin dihapus.');
            return;
        }
        deleteMode = 'batch';
        document.getElementById('modalDeleteTitle').textContent = 'Hapus Produk';
        document.getElementById('modalDeleteBody').innerHTML = 'Apakah Anda yakin ingin menghapus ' + selected.length + ' produk ini?<br>Tindakan ini tidak dapat dibatalkan.';
        document.getElementById('deleteModal').classList.add('show');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('show');
        deleteId = null;
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });

    document.getElementById('deleteForm').addEventListener('submit', function(e) {
        if (deleteMode === 'batch') {
            e.preventDefault();
            closeDeleteModal();
            hapusTerpilih();
        }
    });

    function toggleHapusMode() {
        hapusMode = !hapusMode;
        var btn = document.getElementById('btnHapusSebagian');
        var btnBatal = document.getElementById('btnBatalHapus');
        var wraps = document.querySelectorAll('.kc-checkbox-wrap');
        var cbs = document.querySelectorAll('.cb-hapus');
        var selectAllWrap = document.getElementById('selectAllWrap');
        var cbSelectAll = document.getElementById('cbSelectAll');

        wraps.forEach(function(w) { w.classList.toggle('show', hapusMode); });

        if (hapusMode) {
            btn.innerHTML = '<i class="fa-solid fa-trash-can"></i> Hapus';
            btn.classList.add('active');
            selectAllWrap.classList.add('show');
            cbSelectAll.checked = false;
        } else {
            btn.innerHTML = '<i class="fa-solid fa-check-square"></i> Hapus Sebagian';
            btn.classList.remove('active');
            cbs.forEach(function(cb) { cb.checked = false; });
            selectAllWrap.classList.remove('show');
            cbSelectAll.checked = false;
        }
        btnBatal.style.display = hapusMode ? 'inline-flex' : 'none';
    }

    function toggleAll(e) {
        var checked = e.target.checked;
        document.querySelectorAll('.cb-hapus').forEach(function(cb) {
            cb.checked = checked;
        });
    }

    function hapusTerpilih() {
        var selected = [];
        document.querySelectorAll('.cb-hapus:checked').forEach(function(cb) {
            selected.push(cb.value);
        });
        if (selected.length === 0) {
            showNotif('Pilih produk yang ingin dihapus.');
            return;
        }

        var csrf = document.querySelector('meta[name="csrf-token"]').content;

        fetch('/pelanggan/keranjang/batch', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ ids: selected })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                selected.forEach(function(id) {
                    var card = document.querySelector('.keranjang-card[data-id="' + id + '"]');
                    if (card) card.remove();
                });
                toggleHapusMode();

                var grandEl = document.getElementById('grandTotal');
                grandEl.textContent = 'Rp ' + formatAngka(data.total_all);

                localStorage.setItem('cart_seen', '1');
                showNotif(data.message);

                if (data.count === 0) {
                    location.reload();
                }
            }
        });
    }

    function cariProduk() {
        var keyword = document.getElementById('searchInput').value.toLowerCase().trim();
        var cards = document.querySelectorAll('.keranjang-card');
        var visible = 0;

        cards.forEach(function(card) {
            var nama = card.querySelector('.kc-nama').textContent.toLowerCase();
            var kategori = card.querySelector('.kc-kategori').textContent.toLowerCase();
            var match = nama.includes(keyword) || kategori.includes(keyword);
            card.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        var infoEl = document.querySelector('.kt-info-total');
        if (infoEl) {
            if (keyword) {
                infoEl.textContent = visible + ' produk ditemukan';
            } else {
                infoEl.textContent = cards.length + ' produk di keranjang';
            }
        }
    }

    function showNotif(msg) {
        var el = document.getElementById('cartNotif');
        document.getElementById('cartNotifMsg').textContent = msg;
        el.classList.add('show');
        setTimeout(function() { el.classList.remove('show'); }, 3000);
    }

    var notifData = document.getElementById('cartNotifData');
    if (notifData) {
        var msg = notifData.getAttribute('data-msg');
        if (msg) {
            document.getElementById('cartNotifMsg').textContent = msg;
            var el = document.getElementById('cartNotif');
            el.classList.add('show');
            setTimeout(function() { el.classList.remove('show'); }, 3000);
        }
    }

    localStorage.setItem('cart_seen', '1');
    window.updateCartBadge = function() {};

    var badge = document.getElementById('cartBadgeSidebar');
    if (badge) badge.style.display = 'none';
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
