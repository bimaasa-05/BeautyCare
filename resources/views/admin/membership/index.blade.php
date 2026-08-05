<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Membership - BeautyCare</title>
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

    .ph-add-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 100px;
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(255, 79, 135, 0.2);
        transition: all 0.2s ease;
    }

    .ph-add-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
        color: #fff;
    }

    .member-status-card {
        background: linear-gradient(135deg, #FF4F87 0%, #FF7BA6 50%, #FF9CB8 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(255, 79, 135, 0.25);
    }

    .member-status-card .ms-deco {
        position: absolute;
        pointer-events: none;
    }

    .member-status-card .ms-deco:nth-child(1) {
        width: 250px; height: 250px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.1);
        top: -100px; right: -50px;
    }

    .member-status-card .ms-deco:nth-child(2) {
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        bottom: -40px; left: 30%;
    }

    .member-status-card .ms-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .member-status-card .ms-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .member-status-card .ms-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 28px;
        flex-shrink: 0;
    }

    .member-status-card .ms-text h3 {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }

    .member-status-card .ms-text p {
        font-size: 13px;
        color: rgba(255,255,255,0.8);
        margin: 4px 0 0;
    }

    .member-status-card .ms-level {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 20px;
        border-radius: 100px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .member-status-card .ms-level i {
        font-size: 16px;
    }

    .stats-membership {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-member-card {
        background: var(--white);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-member-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px -8px rgba(255, 79, 135, 0.12);
    }

    .stat-member-card .sm-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin: 0 auto 12px;
    }

    .stat-member-card .sm-icon.paket { background: #DBEAFE; color: #2563EB; }
    .stat-member-card .sm-icon.aktif { background: #D1FAE5; color: #059669; }
    .stat-member-card .sm-icon.tier { background: #F3E8FF; color: #9333EA; }
    .stat-member-card .sm-icon.diskon { background: #FEF3C7; color: #D97706; }

    .stat-member-card .sm-value {
        font-size: 22px;
        font-weight: 700;
        color: var(--dark);
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-member-card .sm-label {
        font-size: 12px;
        color: var(--gray);
        font-weight: 500;
    }

    .progres-card {
        background: var(--white);
        border-radius: 20px;
        padding: 24px 28px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        margin-bottom: 24px;
    }

    .progres-card .pg-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .progres-card .pg-head h4 {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .progres-card .pg-head .pg-target {
        font-size: 12px;
        color: var(--gray);
        background: var(--hover);
        padding: 6px 14px;
        border-radius: 100px;
        font-weight: 600;
    }

    .progres-card .pg-row {
        margin-bottom: 16px;
    }

    .progres-card .pg-row:last-child {
        margin-bottom: 0;
    }

    .progres-card .pg-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
        color: var(--gray);
        margin-bottom: 6px;
        font-weight: 500;
    }

    .progres-card .pg-label strong {
        color: var(--dark);
    }

    .progres-card .pg-bar {
        height: 10px;
        border-radius: 100px;
        background: var(--hover);
        overflow: hidden;
    }

    .progres-card .pg-bar .pg-fill {
        height: 100%;
        border-radius: 100px;
        background: linear-gradient(90deg, var(--primary), #FF7BA6);
        transition: width 0.8s ease;
        width: 0;
    }

    .progres-card .pg-bar .pg-fill.full {
        background: linear-gradient(90deg, #22C55E, #4ADE80);
    }

    .member-tier-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .member-tier-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .member-tier-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px -8px rgba(255, 79, 135, 0.15);
    }

    .member-tier-card .mt-banner {
        min-height: 120px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .member-tier-card .mt-banner.silver {
        background: linear-gradient(135deg, #94A3B8, #CBD5E1);
    }

    .member-tier-card .mt-banner.gold {
        background: linear-gradient(135deg, #F59E0B, #FBBF24);
    }

    .member-tier-card .mt-banner.platinum {
        background: linear-gradient(135deg, #6366F1, #818CF8);
    }

    .member-tier-card .mt-banner .mt-icon-big {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 24px;
    }

    .member-tier-card .mt-banner .mt-badge {
        position: absolute;
        top: 14px;
        right: 14px;
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

    .member-tier-card .mt-banner .mt-status {
        position: absolute;
        bottom: 14px;
        left: 14px;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 700;
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
    }

    .member-tier-card .mt-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .member-tier-card .mt-body .mt-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .member-tier-card .mt-body .mt-subtitle {
        font-size: 12px;
        color: var(--gray);
        margin-bottom: 14px;
    }

    .member-tier-card .mt-body .mt-benefits {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }

    .member-tier-card .mt-body .mt-benefits .mt-benefit-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: var(--dark);
    }

    .member-tier-card .mt-body .mt-benefits .mt-benefit-item i {
        width: 18px;
        font-size: 13px;
        color: var(--primary);
        flex-shrink: 0;
    }

    .member-tier-card .mt-body .mt-syarat {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px dashed var(--border);
    }

    .member-tier-card .mt-body .mt-syarat-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 12px;
        font-weight: 500;
        color: var(--dark);
    }

    .member-tier-card .mt-body .mt-syarat-row i {
        color: var(--primary);
        width: 16px;
        font-size: 12px;
        flex-shrink: 0;
    }

    .member-tier-card .mt-body .mt-syarat-status {
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 100px;
        white-space: nowrap;
    }

    .member-tier-card .mt-body .mt-syarat-status.ok {
        background: #D1FAE5;
        color: #059669;
    }

    .member-tier-card .mt-body .mt-syarat-status.kurang {
        background: #FEF3C7;
        color: #D97706;
    }

    .member-tier-card .mt-body .mt-syarat-status.bad {
        background: #FEE2E2;
        color: #B91C1C;
    }

    .card-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 14px;
    }

    .card-action-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        transition: all 0.2s ease;
        border: none;
        text-decoration: none;
    }

    .card-action-btn.edit {
        background: #FEF3C7;
        color: #B45309;
    }

    .card-action-btn.edit:hover {
        background: #FDE68A;
    }

    .card-action-btn.delete {
        background: #FEE2E2;
        color: #B91C1C;
    }

    .card-action-btn.delete:hover {
        background: #FECACA;
    }

    .benefit-section-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .benefit-section-title .bst-left {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .benefit-section-title i {
        color: var(--primary);
    }

    .manage-card {
        background: var(--white);
        border-radius: 20px;
        padding: 24px 28px;
        box-shadow: 0 2px 12px -4px rgba(0, 0, 0, 0.06);
        margin-bottom: 24px;
    }

    .manage-card .mc-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .mc-search {
        position: relative;
        flex: 1;
        min-width: 180px;
        max-width: 260px;
    }

    .mc-search i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 12px;
        color: var(--gray);
    }

    .mc-search input {
        width: 100%;
        padding: 9px 12px 9px 32px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        font-size: 12px;
        font-family: 'Poppins', sans-serif;
        background: var(--white);
        outline: none;
        transition: border-color 0.2s ease;
    }

    .mc-search input:focus {
        border-color: var(--primary);
    }

    .filter-chips {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }

    .filter-btn {
        font-size: 11px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 100px;
        border: 1px solid var(--border);
        background: var(--white);
        color: var(--gray);
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Poppins', sans-serif;
    }

    .filter-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    .filter-btn.active {
        background: linear-gradient(135deg, var(--primary), #FF7BA6);
        color: #fff;
        border-color: transparent;
    }

    .manage-table {
        width: 100%;
        border-collapse: collapse;
    }

    .manage-table thead th {
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--gray);
        padding: 10px 12px;
        border-bottom: 1px solid var(--border);
        background: var(--hover);
    }

    .manage-table thead th:first-child {
        border-radius: 10px 0 0 10px;
    }

    .manage-table thead th:last-child {
        border-radius: 0 10px 10px 0;
    }

    .manage-table tbody td {
        font-size: 13px;
        color: var(--dark);
        padding: 12px;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    .manage-table tbody tr {
        transition: background 0.2s ease;
    }

    .manage-table tbody tr:hover {
        background: var(--hover);
    }

    .tier-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 600;
    }

    .tier-badge.silver { background: #F1F5F9; color: #64748B; }
    .tier-badge.gold { background: #FEF3C7; color: #B45309; }
    .tier-badge.platinum { background: #EDE9FE; color: #6D28D9; }
    .tier-badge.default { background: #FCE7F3; color: #DB2777; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-badge.ok { background: #D1FAE5; color: #059669; }
    .status-badge.warn { background: #FEF3C7; color: #D97706; }
    .status-badge.bad { background: #FEE2E2; color: #B91C1C; }
    .status-badge.gray { background: #F1F5F9; color: #64748B; }

    .row-action {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .row-action.edit { background: #FEF3C7; color: #B45309; }
    .row-action.edit:hover { background: #FDE68A; }
    .row-action.delete { background: #FEE2E2; color: #B91C1C; }
    .row-action.delete:hover { background: #FECACA; }

    .alert-success {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #D1FAE5;
        border: 1px solid #A7F3D0;
        color: #047857;
        font-size: 13px;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .alert-success i {
        color: #059669;
    }

    @media (max-width: 768px) {
        .member-tier-grid {
            grid-template-columns: 1fr;
        }

        .member-status-card .ms-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .manage-card {
            padding: 18px 16px;
        }

        .mc-search {
            max-width: 100%;
        }

        .manage-table thead { display: none; }
        .manage-table tbody tr {
            display: block;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }
        .manage-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border: none;
            font-size: 13px;
            text-align: right;
        }
        .manage-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--gray);
            font-size: 11px;
            text-transform: uppercase;
        }
        .page-header-premium { padding: 22px 20px; }
        .member-status-card { padding: 22px 20px; }
    }

    @media (max-width: 576px) {
        .page-header-premium .ph-text h3 { font-size: 17px; }
        .page-header-premium .ph-icon-wrap { width: 44px; height: 44px; border-radius: 13px; font-size: 18px; }
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
                                <i class="fa-solid fa-crown"></i>
                            </div>
                            <div class="ph-text">
                                <h3>Data Membership</h3>
                                <p>Atur program membership dan keanggotaan pelanggan.</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.membership.create') }}" class="ph-add-btn">
                            <i class="fa-solid fa-plus"></i> Tambah Paket
                        </a>
                    </div>
                </div>

                @if (session('success'))
                <div class="alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
                @endif

                @php
                    $warnaTingkat = ['Silver' => 'silver', 'Gold' => 'gold', 'Platinum' => 'platinum'];
                    $iconTingkat = ['Silver' => 'fa-solid fa-medal', 'Gold' => 'fa-solid fa-trophy', 'Platinum' => 'fa-solid fa-gem'];
                @endphp

                <div class="member-status-card">
                    <div class="ms-deco"></div>
                    <div class="ms-deco"></div>
                    <div class="ms-content">
                        <div class="ms-left">
                            <div class="ms-icon">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                            <div class="ms-text">
                                <h3>Program Membership</h3>
                                <p>{{ $totalMember }} paket membership terdaftar &middot; {{ $memberAktif }} paket berstatus aktif</p>
                            </div>
                        </div>
                        <div class="ms-level">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ $memberAktif }} Aktif
                        </div>
                    </div>
                </div>

                <div class="stats-membership">
                    <div class="stat-member-card">
                        <div class="sm-icon paket">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <div class="sm-value">{{ $totalMember }}</div>
                        <div class="sm-label">Total Paket</div>
                    </div>
                    <div class="stat-member-card">
                        <div class="sm-icon aktif">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="sm-value">{{ $memberAktif }}</div>
                        <div class="sm-label">Paket Aktif</div>
                    </div>
                    @foreach ($statPerTingkat as $tingkat => $stat)
                    <div class="stat-member-card">
                        <div class="sm-icon tier">
                            <i class="{{ $iconTingkat[$tingkat] ?? 'fa-solid fa-star' }}"></i>
                        </div>
                        <div class="sm-value">{{ $stat['total'] }}</div>
                        <div class="sm-label">{{ $tingkat }} &middot; {{ $stat['diskon'] }}%</div>
                    </div>
                    @endforeach
                </div>

                <div class="progres-card">
                    <div class="pg-head">
                        <h4><i class="fa-solid fa-chart-pie" style="color: var(--primary); margin-right: 8px;"></i>Distribusi Paket per Tingkat</h4>
                        @if ($totalMember > 0)
                        <span class="pg-target"><i class="fa-solid fa-box"></i> {{ $totalMember }} paket</span>
                        @endif
                    </div>
                    @forelse ($statPerTingkat as $tingkat => $stat)
                    <div class="pg-row">
                        <div class="pg-label">
                            <span>{{ $tingkat }} <i class="{{ $iconTingkat[$tingkat] ?? 'fa-solid fa-star' }}" style="color: var(--primary); margin-left: 4px;"></i></span>
                            <span><strong>{{ $stat['total'] }}</strong> / {{ $totalMember }} paket</span>
                        </div>
                        <div class="pg-bar">
                            <div class="pg-fill {{ $stat['total'] >= $totalMember ? 'full' : '' }}" data-width="{{ $totalMember > 0 ? round($stat['total'] / $totalMember * 100) : 0 }}"></div>
                        </div>
                    </div>
                    @empty
                    <div class="pg-label" style="justify-content: center; gap: 6px;">
                        <i class="fa-solid fa-box-open" style="color: var(--gray);"></i>
                        Belum ada paket membership yang terdaftar.
                    </div>
                    @endforelse
                </div>

                <div class="benefit-section-title">
                    <div class="bst-left">
                        <i class="fa-solid fa-crown"></i> Paket Membership Tersedia
                    </div>
                </div>

                <div class="member-tier-grid" id="tierFilters">
                    @forelse ($memberships as $item)
                    @php
                        $banner = $warnaTingkat[$item->tingkat] ?? 'gold';
                        $icon = $iconTingkat[$item->tingkat] ?? 'fa-solid fa-trophy';
                        $statusOtomatis = $item->masa_berlaku > 0 && $item->status === 'aktif'
                            ? 'aktif'
                            : ($item->status === 'suspend' ? 'suspend' : 'non_aktif');
                        $statusLabel = $statusOtomatis === 'aktif' ? 'Aktif' : ($statusOtomatis === 'suspend' ? 'Suspend' : 'Non Aktif');
                    @endphp
                    <div class="member-tier-card" data-tingkat="{{ $item->tingkat }}">
                        <div class="mt-banner {{ $banner }}">
                            <div class="mt-icon-big">
                                <i class="{{ $icon }}"></i>
                            </div>
                            <span class="mt-badge">
                                <i class="fa-solid fa-layer-group"></i> {{ $item->tingkat }}
                            </span>
                            <span class="mt-status">
                                <i class="fa-solid fa-circle {{ $statusOtomatis === 'aktif' ? 'fa-beat-fade' : '' }}" style="font-size: 8px; margin-right: 4px;"></i>{{ $statusLabel }}
                            </span>
                        </div>
                        <div class="mt-body">
                            <div class="mt-title">{{ $item->nm_member }}</div>
                            <div class="mt-subtitle">
                                {{ $item->deskripsi ?: 'Paket membership ' . $item->tingkat . ' BeautyCare' }}
                            </div>
                            <div class="mt-benefits">
                                <div class="mt-benefit-item">
                                    <i class="fa-solid fa-tags"></i> Diskon {{ $item->diskon }}% semua layanan
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-solid fa-bag-shopping"></i> Min. {{ $item->min_transaksi }}x transaksi
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-solid fa-wallet"></i> Min. Rp {{ number_format($item->min_pembelian, 0, ',', '.') }} pembelian
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-solid fa-money-bill-wave"></i> Harga Upgrade: Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-solid fa-comments"></i> Gratis konsultasi {{ (int) $item->jml_konsultasi }}x/bulan
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-solid fa-calendar-check"></i> Prioritas booking
                                </div>
                                <div class="mt-benefit-item">
                                    <i class="fa-solid fa-star"></i> Undangan event eksklusif
                                </div>
                            </div>
                            <div class="mt-syarat">
                                <div class="mt-syarat-row">
                                    <span><i class="fa-regular fa-clock"></i> Masa Berlaku</span>
                                    <span class="mt-syarat-status {{ $item->masa_berlaku > 0 ? 'ok' : 'bad' }}">{{ $item->masa_berlaku }} hari</span>
                                </div>
                                <div class="mt-syarat-row">
                                    <span><i class="fa-solid fa-gear"></i> Status Paket</span>
                                    @if ($statusOtomatis === 'aktif')
                                    <span class="mt-syarat-status ok">Aktif</span>
                                    @elseif ($statusOtomatis === 'suspend')
                                    <span class="mt-syarat-status kurang">Suspend</span>
                                    @else
                                    <span class="mt-syarat-status bad">Non Aktif</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-actions">
                                <a href="{{ route('admin.membership.edit', $item->id_member) }}" class="card-action-btn edit">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.membership.destroy', $item->id_member) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus paket membership ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="card-action-btn delete">
                                        <i class="fa-regular fa-trash-can"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="manage-card" style="grid-column: 1 / -1; text-align: center; color: var(--gray);">
                        <i class="fa-solid fa-folder-open fa-2x mb-2" style="color: #cbd5e1;"></i>
                        <p style="font-size: 13px; margin: 0;">Belum ada paket membership. Klik "Tambah Paket" untuk membuat yang baru.</p>
                    </div>
                    @endforelse
                </div>

                <div class="benefit-section-title">
                    <div class="bst-left">
                        <i class="fa-solid fa-users-gear"></i> Tabel Pengelolaan Paket
                    </div>
                </div>

                <div class="manage-card">
                    <div class="mc-toolbar">
                        <div class="mc-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="searchMember" placeholder="Cari paket...">
                        </div>
                        <div class="filter-chips" id="filterButtons" style="margin-bottom: 0;">
                            <button data-filter="all" class="filter-btn active">Semua</button>
                            @foreach ($statPerTingkat as $tingkat => $stat)
                            <button data-filter="{{ $tingkat }}" class="filter-btn">{{ $tingkat }}</button>
                            @endforeach
                        </div>
                    </div>

                    <div class="overflow-x-auto" style="overflow-x: auto;">
                        <table class="manage-table">
                            <thead>
                                <tr>
                                    <th class="w-10">#</th>
                                    <th>Nama Paket</th>
                                    <th>Tingkat</th>
                                    <th>Diskon</th>
                                    <th>Masa Berlaku</th>
                                    <th>Status</th>
                                    <th class="text-center" style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="memberTableBody">
                                @forelse ($memberships as $item)
                                @php
                                    $statusOtomatis = $item->masa_berlaku > 0 && $item->status === 'aktif'
                                        ? 'aktif'
                                        : ($item->status === 'suspend' ? 'suspend' : 'non_aktif');
                                    $tierBadge = $warnaTingkat[$item->tingkat] ?? 'default';
                                @endphp
                                <tr data-tingkat="{{ $item->tingkat }}">
                                    <td data-label="#" class="text-gray" style="color: var(--gray);">{{ $loop->iteration }}</td>
                                    <td data-label="Nama Paket" style="font-weight: 600;">{{ $item->nm_member }}</td>
                                    <td data-label="Tingkat">
                                        <span class="tier-badge {{ $tierBadge }}">
                                            <i class="{{ $iconTingkat[$item->tingkat] ?? 'fa-solid fa-star' }}"></i>
                                            {{ $item->tingkat }}
                                        </span>
                                    </td>
                                    <td data-label="Diskon">{{ $item->diskon }}%</td>
                                    <td data-label="Masa Berlaku">{{ number_format($item->masa_berlaku) }} hari</td>
                                    <td data-label="Status">
                                        @if ($statusOtomatis === 'aktif')
                                        <span class="status-badge ok"><i class="fa-solid fa-circle" style="font-size: 6px;"></i> Aktif</span>
                                        @elseif ($statusOtomatis === 'suspend')
                                        <span class="status-badge warn"><i class="fa-solid fa-circle" style="font-size: 6px;"></i> Suspend</span>
                                        @else
                                        <span class="status-badge bad"><i class="fa-solid fa-circle" style="font-size: 6px;"></i> Non Aktif</span>
                                        @endif
                                    </td>
                                    <td data-label="Aksi">
                                        <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                            <a href="{{ route('admin.membership.edit', $item->id_member) }}" class="row-action edit" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('admin.membership.destroy', $item->id_member) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus paket membership ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="row-action delete" title="Hapus">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" style="padding: 32px; text-align: center; color: var(--gray);">
                                        <i class="fa-solid fa-folder-open fa-2x mb-2" style="color: #cbd5e1;"></i>
                                        <p style="font-size: 13px; margin: 0;">Belum ada paket membership</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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

    document.querySelectorAll('.pg-fill').forEach(function(fill) {
        var width = parseInt(fill.getAttribute('data-width')) || 0;
        setTimeout(function() { fill.style.width = width + '%'; }, 200);
    });

    document.addEventListener('DOMContentLoaded', function () {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const rows = document.querySelectorAll('#memberTableBody tr');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const tingkat = this.dataset.filter;
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                rows.forEach(row => {
                    if (tingkat === 'all' || row.dataset.tingkat === tingkat) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });

        const searchInput = document.getElementById('searchMember');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const q = this.value.toLowerCase();
                rows.forEach(function(row) {
                    const nm = row.querySelector('[data-label="Nama Paket"]')?.textContent?.toLowerCase() || '';
                    if (nm.includes(q)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>