<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Saya - BeautyCare</title>

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

    /* ─── Page Header Premium ─── */
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

    /* ─── Premium Stats ─── */
    .stats-row .stat-card {
        position: relative;
        overflow: hidden;
    }

    .stats-row .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        border-radius: 0 0 20px 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stats-row .stat-card:hover::after {
        opacity: 1;
    }

    .stats-row .stat-card:nth-child(1)::after { background: linear-gradient(90deg, var(--primary), #FF7BA6); }
    .stats-row .stat-card:nth-child(2)::after { background: linear-gradient(90deg, #F59E0B, #FBBF24); }
    .stats-row .stat-card:nth-child(3)::after { background: linear-gradient(90deg, #3B82F6, #60A5FA); }
    .stats-row .stat-card:nth-child(4)::after { background: linear-gradient(90deg, #22C55E, #4ADE80); }
    .stats-row .stat-card:nth-child(5)::after { background: linear-gradient(90deg, #EF4444, #F87171); }

    /* ─── CTA Banner Premium ─── */
    .cta-banner-premium {
        background: linear-gradient(135deg, #FF4F87 0%, #FF7BA6 50%, #FF9CB8 100%);
        border-radius: 20px;
        padding: 0;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(255, 79, 135, 0.25);
    }

    .cta-banner-premium .cta-bg-deco {
        position: absolute;
        inset: 0;
        pointer-events: none;
        overflow: hidden;
    }

    .cta-banner-premium .cta-bg-deco .deco-circle {
        position: absolute;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .cta-banner-premium .cta-bg-deco .deco-circle:nth-child(1) {
        width: 300px; height: 300px;
        top: -100px; right: -60px;
    }

    .cta-banner-premium .cta-bg-deco .deco-circle:nth-child(2) {
        width: 150px; height: 150px;
        bottom: -40px; left: 20%;
        background: rgba(255, 255, 255, 0.05);
    }

    .cta-banner-premium .cta-bg-deco .deco-circle:nth-child(3) {
        width: 80px; height: 80px;
        top: 20px; left: 40%;
        background: rgba(255, 255, 255, 0.06);
    }

    .cta-banner-premium .cta-inner {
        position: relative;
        z-index: 1;
        padding: 28px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .cta-banner-premium .cta-inner .cta-icon-big {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #fff;
        flex-shrink: 0;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    /* ─── Booking Card Premium ─── */
    .booking-card-premium {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .booking-card-premium .bc-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .booking-card-premium .bc-header .bc-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .booking-card-premium .bc-header .bc-title-icon {
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

    .booking-card-premium .bc-header .bc-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
    }

    .booking-card-premium .bc-header .bc-subtitle {
        font-size: 12px;
        color: var(--gray);
        margin-top: 1px;
    }

    .booking-card-premium .bc-header .bc-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* ─── Enhanced Table ─── */
    .booking-table {
        width: 100%;
        border-collapse: collapse;
    }

    .booking-table thead th {
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

    .booking-table thead th:first-child {
        padding-left: 24px;
    }

    .booking-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #F5F5F5;
    }

    .booking-table tbody tr:last-child {
        border-bottom: none;
    }

    .booking-table tbody tr:hover {
        background: #FFF8FA;
    }

    .booking-table tbody td {
        padding: 14px 16px;
        font-size: 13px;
        color: var(--dark);
        vertical-align: middle;
        text-align: center;
    }

    .booking-table tbody td:first-child {
        padding-left: 24px;
    }

    .booking-table tbody td:last-child {
        padding-right: 24px;
    }

    /* ─── Booking ID Badge ─── */
    .booking-id-badge {
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

    /* ─── Therapist Avatar ─── */
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

    /* ─── Status Badge Premium ─── */
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

    /* ─── Action Buttons ─── */
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
    }

    .action-btn.edit {
        background: #FEF3C7;
        color: #D97706;
    }

    .action-btn.edit:hover {
        background: #FDE68A;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.2);
    }

    .action-btn.delete {
        background: #FEE2E2;
        color: #DC2626;
    }

    .action-btn.delete:hover {
        background: #FECACA;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
    }

    /* ─── Empty State ─── */
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

    .empty-state .btn-empty {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(255, 79, 135, 0.25);
    }

    .empty-state .btn-empty:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(255, 79, 135, 0.35);
    }

    /* ─── Footer Info ─── */
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

    /* ─── Success Alert Premium ─── */
    .alert-premium {
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        font-weight: 500;
        animation: slideDown 0.4s ease;
    }

    .alert-premium.success {
        background: linear-gradient(135deg, #ECFDF5, #D1FAE5);
        border: 1px solid #A7F3D0;
        color: #065F46;
    }

    .alert-premium .alert-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .alert-premium.success .alert-icon {
        background: #A7F3D0;
        color: #059669;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-12px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ─── Modal Premium ─── */
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

    /* ─── Search Input Premium ─── */
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

    /* ─── Btn Primary Rounded ─── */
    .btn-primary-rounded {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 20px;
        border-radius: 100px;
        border: none;
        background: linear-gradient(135deg, #de3b7c, #FF4F87);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(222, 59, 124, 0.25);
        text-decoration: none;
        font-family: 'Inter', sans-serif;
    }

    .btn-primary-rounded:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(222, 59, 124, 0.35);
    }

    /* ─── Catatan Text ─── */
    .catatan-text {
        max-width: 140px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: var(--gray);
        font-size: 12px;
    }

    .catatan-text.no-catatan {
        color: #ccc;
        font-style: italic;
    }

    /* ─── Responsive Table ─── */
    @media (max-width: 768px) {
        .booking-table thead { display: none; }
        .booking-table tbody tr {
            display: block;
            padding: 16px;
            border-bottom: 1px solid var(--border);
        }
        .booking-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border: none;
            font-size: 13px;
        }
        .booking-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--gray);
            font-size: 11px;
            text-transform: uppercase;
        }
        .booking-table tbody td:first-child { padding-left: 0; }
        .booking-table tbody td:last-child { padding-right: 0; }
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
                <!-- ═══ Page Header Premium ═══ -->
                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <i class="fa-regular fa-calendar-check"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Booking Saya</h3>
                                <p>Kelola semua jadwal treatment BeautyCare Anda</p>
                            </div>
                        </div>
                        <div class="ph-stats">
                            <div class="ph-stat-item">
                                <div class="ph-stat-num">{{ $total_booking }}</div>
                                <div class="ph-stat-label">Total</div>
                            </div>
                            <div class="ph-stat-divider"></div>
                            <div class="ph-stat-item">
                                <div class="ph-stat-num" style="color: #F59E0B;">{{ $menunggu }}</div>
                                <div class="ph-stat-label">Pending</div>
                            </div>
                            <div class="ph-stat-divider"></div>
                            <div class="ph-stat-item">
                                <div class="ph-stat-num" style="color: #22C55E;">{{ $selesai }}</div>
                                <div class="ph-stat-label">Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ═══ Stats Row ═══ -->
                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                            </div>
                            <span class="stat-change up">+{{ $total_booking }}</span>
                        </div>
                        <div class="stat-value">{{ $total_booking }}</div>
                        <div class="stat-label">Total Booking</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                            </div>
                            <span class="stat-change up">+{{ $menunggu }}</span>
                        </div>
                        <div class="stat-value">{{ $menunggu }}</div>
                        <div class="stat-label">Menunggu</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                                </svg>
                            </div>
                            <span class="stat-change up">+{{ $dikonfirmasi }}</span>
                        </div>
                        <div class="stat-value">{{ $dikonfirmasi }}</div>
                        <div class="stat-label">Dikonfirmasi</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon success">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                            </div>
                            <span class="stat-change up">+{{ $selesai }}</span>
                        </div>
                        <div class="stat-value">{{ $selesai }}</div>
                        <div class="stat-label">Selesai</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon danger">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="15" y1="9" x2="9" y2="15" />
                                    <line x1="9" y1="9" x2="15" y2="15" />
                                </svg>
                            </div>
                            <span class="stat-change down">-{{ $dibatalkan }}</span>
                        </div>
                        <div class="stat-value">{{ $dibatalkan }}</div>
                        <div class="stat-label">Dibatalkan</div>
                    </div>
                </div>

                <!-- ═══ CTA Banner Premium ═══ -->
                <div class="cta-banner-premium">
                    <div class="cta-bg-deco">
                        <div class="deco-circle"></div>
                        <div class="deco-circle"></div>
                        <div class="deco-circle"></div>
                    </div>
                    <div class="cta-inner">
                        <div class="flex items-center gap-4">
                            <div class="cta-icon-big">
                                <i class="fa-solid fa-spa"></i>
                            </div>
                            <div>
                                <h3 class="text-[18px] font-bold text-white">Ingin reservasi treatment?</h3>
                                <p class="text-[13px] text-white/80 mt-1">Booking sekarang dan dapatkan perawatan terbaik dari kami</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ═══ Success Alert ═══ -->
                @if(session('success'))
                <div class="alert-premium success">
                    <div class="alert-icon">
                        <i class="fa-regular fa-circle-check"></i>
                    </div>
                    {{ session('success') }}
                </div>
                @endif

                <!-- ═══ Booking Card Premium ═══ -->
                <div class="booking-card-premium">
                    <div class="bc-header">
                        <div class="bc-title-wrap">
                            <div class="bc-title-icon">
                                <i class="fa-regular fa-list"></i>
                            </div>
                            <div>
                                <div class="bc-title">Daftar Booking Saya</div>
                                <div class="bc-subtitle">Kelola semua booking treatment Anda</div>
                            </div>
                        </div>
                        <div class="bc-actions">
                            <form action="{{ route('pelanggan.booking') }}" method="GET">
                                <div class="search-input-wrap">
                                    <i class="fa-solid fa-search si-icon"></i>
                                    <input type="text" name="search" placeholder="Cari booking..." value="{{ $search }}">
                                </div>
                            </form>
                            <a href="{{ route('pelanggan.booking.create') }}" class="btn-primary-rounded">
                                <i class="fa-solid fa-plus"></i> Booking Baru
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="booking-table">
                            <thead>
                                <tr>
                                    <th>ID Booking</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Terapis</th>
                                    <th>Layanan</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                    <th style="text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                <tr>
                                    <td>
                                        <span class="booking-id-badge">
                                            <i class="fa-regular fa-receipt" style="font-size:10px;"></i>
                                            #BK{{ str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td data-label="Tanggal">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-calendar text-gray-300 text-[11px]"></i>
                                            <span>{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('D MMM YYYY') }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Jam">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock text-gray-300 text-[11px]"></i>
                                            <span>{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Terapis">
                                        <div class="therapist-cell">
                                            <div class="th-avatar">{{ $booking->karyawan ? substr($booking->karyawan->nama, 0, 1) : '?' }}</div>
                                            <span class="th-name">{{ $booking->karyawan ? $booking->karyawan->nama : 'Terapis #'.$booking->id_karyawan }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Layanan">
                                        <span style="font-weight:500;">{{ $booking->detail && $booking->detail->layanan ? $booking->detail->layanan->nm_layanan : '-' }}</span>
                                    </td>
                                    <td data-label="Status">
                                        <span class="status-badge {{ $booking->status }}">
                                            <span class="sb-dot"></span>
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td data-label="Catatan">
                                        <span class="catatan-text {{ !$booking->catatan ? 'no-catatan' : '' }}" title="{{ $booking->catatan }}">
                                            {{ $booking->catatan ?: 'Tidak ada catatan' }}
                                        </span>
                                    </td>
                                    <td data-label="Aksi" style="text-align:center;">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="{{ route('pelanggan.booking.edit', $booking->id_booking) }}" class="action-btn edit" title="Edit booking">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <button onclick="confirmDelete({{ $booking->id_booking }})" class="action-btn delete" title="Hapus booking">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
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
                                            <h4>Belum Ada Booking</h4>
                                            <p>Yuk booking treatment favorit Anda sekarang juga!</p>
                                            <a href="{{ route('pelanggan.booking.create') }}" class="btn-empty">
                                                <i class="fa-solid fa-plus"></i> Booking Sekarang
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
                            Menampilkan {{ $bookings->count() }} booking
                        </div>
                        <div class="tf-pagination">
                            <button class="page-btn active">1</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- ═══ Modal Delete Premium ═══ -->
    <div id="deleteModal" class="modal-premium">
        <div class="modal-box">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-icon-wrap">
                    <i class="fa-regular fa-trash-can"></i>
                </div>
                <h3>Hapus Booking</h3>
                <p>Apakah Anda yakin ingin menghapus booking ini?<br>Tindakan ini tidak dapat dibatalkan.</p>
                <div class="modal-actions">
                    <button type="button" onclick="closeDeleteModal()" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-danger">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    let deleteId = null;
    const deleteBaseUrl = '{{ url('/pelanggan/booking') }}';

    function confirmDelete(id) {
        deleteId = id;
        const form = document.getElementById('deleteForm');
        form.action = deleteBaseUrl + '/' + id;
        const modal = document.getElementById('deleteModal');
        modal.classList.add('show');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('show');
        deleteId = null;
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });

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
