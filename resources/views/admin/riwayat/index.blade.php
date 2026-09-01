<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Aktivitas - BeautyCare</title>
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
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--background);
        }

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
            background: #ddd;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #bbb;
        }

        /* ============ PAGE HEADER PREMIUM ============ */
        .page-header-premium {
            background:
                radial-gradient(ellipse 480px 220px at 88% -30%, rgba(255, 79, 135, 0.22), transparent 60%),
                radial-gradient(ellipse 380px 200px at -5% 115%, rgba(190, 24, 93, 0.12), transparent 60%),
                linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 45%, #FFD6E6 100%);
            border-radius: 24px;
            padding: 30px 34px;
            margin-bottom: 22px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 79, 135, 0.12);
            box-shadow: 0 10px 40px -12px rgba(255, 79, 135, 0.25);
        }

        .page-header-premium::before {
            content: '';
            position: absolute;
            top: -70px;
            right: -50px;
            width: 230px;
            height: 230px;
            border-radius: 50%;
            border: 32px solid rgba(255, 255, 255, 0.35);
            pointer-events: none;
        }

        .page-header-premium::after {
            content: '';
            position: absolute;
            bottom: -55px;
            left: 24%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 79, 135, 0.1) 0%, transparent 70%);
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
            gap: 18px;
        }

        .page-header-premium .ph-icon-wrap {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--primary), #FF7BA6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            box-shadow: 0 8px 24px rgba(255, 79, 135, 0.38), inset 0 1px 0 rgba(255, 255, 255, 0.3);
            flex-shrink: 0;
            position: relative;
        }

        .page-header-premium .ph-icon-wrap::after {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 22px;
            border: 1px dashed rgba(255, 79, 135, 0.35);
            pointer-events: none;
        }

        .page-header-premium .ph-text h3 {
            font-size: 22px;
            font-weight: 800;
            color: var(--dark);
            margin: 0;
            letter-spacing: -0.3px;
        }

        .page-header-premium .ph-text p {
            font-size: 13px;
            color: #8b6b78;
            margin: 3px 0 0;
        }

        .ph-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 500;
            color: #b4899b;
            margin-bottom: 6px;
        }

        .ph-breadcrumb i {
            font-size: 10px;
            color: #d9a8ba;
        }

        .ph-breadcrumb span:last-child {
            color: #db2777;
            font-weight: 600;
        }

        .ph-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 79, 135, 0.18);
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            color: #db2777;
            box-shadow: 0 4px 14px rgba(255, 79, 135, 0.12);
        }

        .ph-badge .dot-pulse {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            position: relative;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.5);
            }
            70% {
                box-shadow: 0 0 0 8px rgba(34, 197, 94, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
            }
        }

        /* ============ CONTENT CARD ============ */
        .content-card {
            background: #fff;
            border: 1px solid #FDE1EC;
            border-radius: 22px;
            padding: 26px 28px;
            box-shadow: 0 2px 18px rgba(236, 72, 153, 0.07);
            position: relative;
            overflow: hidden;
            animation: cardIn 0.5s ease both;
        }

        .content-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #FF4F87, #FF7BA6, #FFC2D6);
            opacity: 0.85;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-title-wrap h3 {
            font-size: 16px;
            font-weight: 700;
            color: #1F2937;
            margin: 0;
        }

        .card-title-wrap p {
            font-size: 12px;
            color: #9CA3AF;
            margin: 2px 0 0;
        }

        /* ============ STAT CARDS ============ */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-bottom: 18px;
        }

        @media (min-width: 768px) {
            .stat-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .stat-card {
            border-radius: 16px;
            padding: 16px 18px;
            border: 1px solid;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 26px -8px rgba(0, 0, 0, 0.12);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -40%;
            right: -30%;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.5) 0%, transparent 70%);
            pointer-events: none;
        }

        .stat-card .sc-label {
            font-size: 11px;
            font-weight: 700;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .stat-card .sc-value {
            font-size: 24px;
            font-weight: 800;
            color: #1F2937;
            margin-top: 4px;
            line-height: 1.1;
        }

        .stat-card .sc-icon {
            width: 40px;
            height: 40px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .stat-admin {
            background: linear-gradient(135deg, #FFF1F2 0%, #fff 100%);
            border-color: #FECDD3;
        }

        .stat-admin .sc-icon {
            background: #FECDD3;
            color: #E11D48;
        }

        .stat-kasir {
            background: linear-gradient(135deg, #EFF6FF 0%, #fff 100%);
            border-color: #BFDBFE;
        }

        .stat-kasir .sc-icon {
            background: #BFDBFE;
            color: #2563EB;
        }

        .stat-beautycian {
            background: linear-gradient(135deg, #ECFDF5 0%, #fff 100%);
            border-color: #A7F3D0;
        }

        .stat-beautycian .sc-icon {
            background: #A7F3D0;
            color: #059669;
        }

        .stat-pelanggan {
            background: linear-gradient(135deg, #FFFBEB 0%, #fff 100%);
            border-color: #FDE68A;
        }

        .stat-pelanggan .sc-icon {
            background: #FDE68A;
            color: #D97706;
        }

        /* ============ FILTER BAR ============ */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 18px;
        }

        .filter-input {
            background: #FFF9FC;
            border: 1.5px solid #FDE1EC;
            color: #374151;
            font-size: 12px;
            border-radius: 100px;
            padding: 9px 16px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            font-family: 'Poppins', sans-serif;
        }

        .filter-input:hover {
            border-color: #F9C4D9;
        }

        .filter-input:focus {
            border-color: #FF4F87;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(255, 79, 135, 0.12);
        }

        .filter-search-wrap {
            position: relative;
        }

        .filter-search-wrap i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #f0a1bd;
            font-size: 12px;
            pointer-events: none;
        }

        .filter-search-wrap .filter-input {
            padding-left: 36px;
            width: 100%;
        }

        .btn-filter {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 20px;
            border-radius: 100px;
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            color: #fff;
            border: none;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 4px 14px rgba(255, 79, 135, 0.3);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-filter:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 20px rgba(255, 79, 135, 0.4);
        }

        .btn-reset {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1.5px solid #FDE1EC;
            background: #fff;
            color: #9CA3AF;
            font-size: 12px;
            transition: all 0.2s;
        }

        .btn-reset:hover {
            border-color: #FF4F87;
            color: #FF4F87;
            transform: rotate(90deg);
        }

        @media (max-width: 640px) {
            .filter-bar>* {
                width: 100%;
            }

            .filter-search-wrap .filter-input {
                width: 100%;
            }
        }

        /* ============ TABLE PREMIUM ============ */
        .table-wrap {
            overflow-x: auto;
            border: 1px solid #FBE3EE;
            border-radius: 16px;
        }

        .table-premium {
            width: 100%;
            border-collapse: collapse;
        }

        .table-premium thead th {
            text-align: left;
            padding: 13px 16px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #9CA3AF;
            background: linear-gradient(180deg, #FFF9FC, #FFF4F8);
            border-bottom: 1px solid #FCE7F3;
            white-space: nowrap;
        }

        .table-premium tbody td {
            padding: 13px 16px;
            font-size: 13px;
            color: #374151;
            border-bottom: 1px solid #FDF2F7;
            vertical-align: middle;
        }

        .table-premium tbody tr {
            transition: background 0.2s;
        }

        .table-premium tbody tr:hover {
            background: #FFF8FB;
        }

        .table-premium tbody tr:last-child td {
            border-bottom: none;
        }

        .avatar-initials {
            width: 32px;
            height: 32px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
        }

        .av-admin {
            background: linear-gradient(135deg, #F43F5E, #FB7185);
        }

        .av-kasir {
            background: linear-gradient(135deg, #3B82F6, #60A5FA);
        }

        .av-beautycian {
            background: linear-gradient(135deg, #10B981, #34D399);
        }

        .av-pelanggan {
            background: linear-gradient(135deg, #F59E0B, #FBBF24);
        }

        .av-default {
            background: linear-gradient(135deg, #6B7280, #9CA3AF);
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
        }

        .role-admin {
            background: #FEE2E2;
            color: #DC2626;
        }

        .role-kasir {
            background: #DBEAFE;
            color: #2563EB;
        }

        .role-beautycian {
            background: #D1FAE5;
            color: #059669;
        }

        .role-pelanggan {
            background: #FEF3C7;
            color: #D97706;
        }

        .aksi-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 500;
            background: #F3F4F6;
            color: #4B5563;
        }

        .tipe-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            background: #FFF0F5;
            color: #DB2777;
        }

        .btn-view {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: #EFF6FF;
            color: #3B82F6;
            transition: all 0.2s;
        }

        .btn-view:hover {
            background: #3B82F6;
            color: #fff;
            transform: scale(1.08);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        }

        /* ============ EMPTY STATE ============ */
        .empty-state {
            padding: 48px 20px;
            text-align: center;
        }

        .empty-state .es-icon {
            width: 84px;
            height: 84px;
            margin: 0 auto 16px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFF0F5, #FFE3EC);
            border: 1px solid #FBCFE8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f9a8c4;
            font-size: 28px;
        }

        .empty-state h4 {
            font-size: 14px;
            font-weight: 600;
            color: #6B7280;
            margin: 0 0 4px;
        }

        .empty-state p {
            font-size: 12px;
            color: #B8A3AE;
            margin: 0;
        }

        /* ============ PAGINATION ============ */
        .pagination-custom nav svg {
            width: 14px;
            height: 14px;
        }

        .pagination-custom nav .flex {
            justify-content: center;
        }

        .pagination-custom nav .flex a,
        .pagination-custom nav .flex span {
            font-size: 12px;
            padding: 6px 14px;
            border-radius: 100px !important;
            margin: 0 2px;
            font-family: 'Poppins', sans-serif;
        }

        .pagination-custom nav .flex a:hover {
            background: #FFF0F5 !important;
            color: #DB2777 !important;
        }

        .pagination-custom nav .flex .text-white {
            background: linear-gradient(135deg, #FF4F87, #FF7BA6) !important;
            border-color: transparent !important;
        }

        /* ============ MOBILE TABLE ============ */
        @media (max-width: 768px) {
            .table-premium thead {
                display: none;
            }

            .table-premium tbody tr {
                display: block;
                padding: 14px;
                border-bottom: 1px solid var(--border);
            }

            .table-premium tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border: none;
                font-size: 13px;
                text-align: right;
            }

            .table-premium tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--gray);
                font-size: 11px;
                text-transform: uppercase;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6">

                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <div class="ph-text">
                                <div class="ph-breadcrumb">
                                    <span>Dashboard</span>
                                    <i class="fas fa-chevron-right"></i>
                                    <span>Riwayat Aktivitas</span>
                                </div>
                                <h3>Riwayat Aktivitas</h3>
                                <p>Lihat jejak aktivitas dan perubahan yang terjadi di sistem.</p>
                            </div>
                        </div>
                        <div class="ph-badge">
                            <span class="dot-pulse"></span>
                            {{ $totalAktivitas }} aktivitas tercatat
                        </div>
                    </div>
                </div>

                <div class="content-card">
                    <div class="card-title-wrap mb-5">
                        <h3><i class="fa-solid fa-clock-rotate-left text-pink-500 mr-2"></i>Riwayat Aktivitas</h3>
                        <p><i class="fa-regular fa-circle-check text-pink-300 mr-1"></i>Semua aktivitas pengguna tercatat
                            di sini</p>
                    </div>

                    @php
                        $roleCards = [
                            'admin' => ['stat' => 'stat-admin', 'icon' => 'fa-user-shield', 'label' => 'Admin'],
                            'kasir' => ['stat' => 'stat-kasir', 'icon' => 'fa-user-tie', 'label' => 'Kasir'],
                            'beautycian' => ['stat' => 'stat-beautycian', 'icon' => 'fa-spa', 'label' => 'Beautycian'],
                            'pelanggan' => ['stat' => 'stat-pelanggan', 'icon' => 'fa-user', 'label' => 'Pelanggan'],
                        ];
                    @endphp
                    <div class="stat-grid">
                        @foreach ($roleCards as $key => $rc)
                            <div class="stat-card {{ $rc['stat'] }}">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="sc-label">{{ $rc['label'] }}</p>
                                        <p class="sc-value">{{ $totalByRole[$key] ?? 0 }}</p>
                                    </div>
                                    <div class="sc-icon">
                                        <i class="fa-solid {{ $rc['icon'] }}"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form method="GET" action="{{ route('admin.riwayat.index') }}" class="filter-bar">
                        <select name="role" class="filter-input w-full sm:w-[130px]">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request()->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ request()->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                            <option value="beautycian" {{ request()->role == 'beautycian' ? 'selected' : '' }}>Beautycian</option>
                            <option value="pelanggan" {{ request()->role == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                        </select>
                        <select name="tipe" class="filter-input w-full sm:w-[150px]">
                            <option value="">Semua Tipe</option>
                            <option value="transaksi" {{ request()->tipe == 'transaksi' ? 'selected' : '' }}>Transaksi</option>
                            <option value="booking" {{ request()->tipe == 'booking' ? 'selected' : '' }}>Booking</option>
                            <option value="pelanggan" {{ request()->tipe == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                            <option value="pembayaran" {{ request()->tipe == 'pembayaran' ? 'selected' : '' }}>Pembayaran</option>
                            <option value="user" {{ request()->tipe == 'user' ? 'selected' : '' }}>User</option>
                            <option value="produk" {{ request()->tipe == 'produk' ? 'selected' : '' }}>Produk</option>
                            <option value="layanan" {{ request()->tipe == 'layanan' ? 'selected' : '' }}>Layanan</option>
                            <option value="konsultasi" {{ request()->tipe == 'konsultasi' ? 'selected' : '' }}>Konsultasi</option>
                        </select>
                        <div class="filter-search-wrap w-full sm:w-[200px]">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" placeholder="Cari aktivitas..." name="keyword"
                                class="filter-input" value="{{ request()->keyword }}">
                        </div>
                        <input type="date" name="dari" value="{{ request()->dari }}" class="filter-input w-full sm:w-[140px]">
                        <span class="text-gray-400 text-[12px] hidden sm:inline">â€”</span>
                        <input type="date" name="sampai" value="{{ request()->sampai }}" class="filter-input w-full sm:w-[140px]">
                        <button type="submit" class="btn-filter">
                            <i class="fa-solid fa-filter"></i> Filter
                        </button>
                        @if (request()->keyword || request()->dari || request()->sampai || request()->role || request()->tipe)
                            <a href="{{ route('admin.riwayat.index') }}" class="btn-reset" title="Reset Filter">
                                <i class="fa-solid fa-rotate-right"></i>
                            </a>
                        @endif
                    </form>

                    <div class="table-wrap">
                        <table class="table-premium">
                            <thead>
                                <tr>
                                    <th class="text-center w-12">#</th>
                                    <th>Waktu</th>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                    <th>Tipe</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat as $r)
                                    <tr>
                                        <td data-label="#" class="text-center text-gray-400 font-medium text-[12px]">
                                            {{ $loop->iteration }}</td>
                                        <td data-label="Waktu" class="whitespace-nowrap">
                                            <span class="text-[12px] text-gray-500">
                                                <i class="fa-regular fa-clock text-pink-300 mr-1"></i>
                                                {{ \Carbon\Carbon::parse($r->created_at)->format('d/m/Y H:i') }}
                                            </span>
                                        </td>
                                        <td data-label="User">
                                            <div class="flex items-center gap-2.5">
                                                @php
                                                    $avClass = match ($r->role) {
                                                        'admin' => 'av-admin',
                                                        'kasir' => 'av-kasir',
                                                        'beautycian' => 'av-beautycian',
                                                        'pelanggan' => 'av-pelanggan',
                                                        default => 'av-default',
                                                    };
                                                @endphp
                                                <div class="avatar-initials {{ $avClass }}">
                                                    {{ $r->user ? strtoupper(substr($r->user->nama, 0, 2)) : '??' }}
                                                </div>
                                                <span class="font-medium text-gray-700">{{ $r->user->nama ?? 'System' }}</span>
                                            </div>
                                        </td>
                                        <td data-label="Role">
                                            @php
                                                $roleClass = match ($r->role) {
                                                    'admin' => 'role-admin',
                                                    'kasir' => 'role-kasir',
                                                    'beautycian' => 'role-beautycian',
                                                    'pelanggan' => 'role-pelanggan',
                                                    default => 'bg-gray-100 text-gray-600',
                                                };
                                            @endphp
                                            <span class="role-badge {{ $roleClass }}">
                                                <i class="fa-solid fa-circle text-[6px]"></i> {{ ucfirst($r->role) }}
                                            </span>
                                        </td>
                                        <td data-label="Aksi">
                                            <span class="aksi-badge"><i class="fa-solid fa-bolt text-[9px] text-pink-400"></i>{{ $r->aksi }}</span>
                                        </td>
                                        <td data-label="Tipe">
                                            @if ($r->tipe)
                                                <span class="tipe-badge">{{ $r->tipe }}</span>
                                            @else
                                                <span class="text-gray-300">-</span>
                                            @endif
                                        </td>
                                        <td data-label="Deskripsi" class="max-w-[260px]">
                                            <p class="truncate text-gray-600">{{ $r->deskripsi }}</p>
                                        </td>
                                        <td data-label="Detail" class="text-center">
                                            <a href="{{ route('admin.riwayat.show', $r->id) }}" class="btn-view"
                                                title="Lihat Detail">
                                                <i class="fa-regular fa-eye text-xs"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            <div class="empty-state">
                                                <div class="es-icon">
                                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                                </div>
                                                <h4>
                                                    {{ request()->keyword || request()->dari || request()->sampai || request()->role || request()->tipe ? 'Aktivitas tidak ditemukan' : 'Belum ada riwayat aktivitas' }}
                                                </h4>
                                                <p>
                                                    {{ request()->keyword || request()->dari || request()->sampai || request()->role || request()->tipe ? 'Coba gunakan filter yang berbeda' : 'Aktivitas dari semua pengguna akan tercatat di sini' }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($riwayat->hasPages())
                        <div class="mt-5 pagination-custom">
                            {{ $riwayat->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script>
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>