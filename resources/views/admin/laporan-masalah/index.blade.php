<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Masalah - BeautyCare</title>
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

        .ph-badge .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #F59E0B;
            position: relative;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.5);
            }
            70% {
                box-shadow: 0 0 0 8px rgba(245, 158, 11, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0);
            }
        }

        /* ============ ALERT ============ */
        .alert-premium {
            border-radius: 16px;
            padding: 15px 20px;
            margin-bottom: 22px;
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
            grid-template-columns: 1fr;
            gap: 14px;
            margin-bottom: 18px;
        }

        @media (min-width: 640px) {
            .stat-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .stat-card {
            border-radius: 16px;
            padding: 18px 20px;
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
            width: 100px;
            height: 100px;
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
            font-size: 26px;
            font-weight: 800;
            margin-top: 4px;
            line-height: 1.1;
        }

        .stat-card .sc-icon {
            width: 42px;
            height: 42px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .stat-baru {
            background: linear-gradient(135deg, #FFFBEB 0%, #fff 100%);
            border-color: #FDE68A;
        }

        .stat-baru .sc-value {
            color: #D97706;
        }

        .stat-baru .sc-icon {
            background: #FDE68A;
            color: #D97706;
        }

        .stat-diproses {
            background: linear-gradient(135deg, #EFF6FF 0%, #fff 100%);
            border-color: #BFDBFE;
        }

        .stat-diproses .sc-value {
            color: #2563EB;
        }

        .stat-diproses .sc-icon {
            background: #BFDBFE;
            color: #2563EB;
        }

        .stat-selesai {
            background: linear-gradient(135deg, #ECFDF5 0%, #fff 100%);
            border-color: #A7F3D0;
        }

        .stat-selesai .sc-value {
            color: #059669;
        }

        .stat-selesai .sc-icon {
            background: #A7F3D0;
            color: #059669;
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
            flex: 1;
            min-width: 200px;
            max-width: 100%;
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

        @media (max-width: 640px) {
            .filter-bar>* {
                width: 100%;
            }

            .filter-search-wrap {
                max-width: 100%;
                min-width: 0;
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
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
            box-shadow: 0 3px 8px rgba(255, 79, 135, 0.25);
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-baru {
            background: #FEF3C7;
            color: #D97706;
        }

        .badge-diproses {
            background: #DBEAFE;
            color: #2563EB;
        }

        .badge-selesai {
            background: #E8F8EE;
            color: #16A34A;
        }

        .badge-role {
            background: #F3E8FF;
            color: #9333EA;
        }

        .tipe-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            background: #FFF0F5;
            color: #DB2777;
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 100px;
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s;
            box-shadow: 0 4px 14px rgba(255, 79, 135, 0.28);
            position: relative;
            overflow: hidden;
        }

        .btn-detail::after {
            content: '';
            position: absolute;
            top: 0;
            left: -80%;
            width: 50%;
            height: 100%;
            background: linear-gradient(105deg, transparent, rgba(255, 255, 255, 0.35), transparent);
            transform: skewX(-20deg);
            transition: left 0.5s;
        }

        .btn-detail:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 20px rgba(255, 79, 135, 0.4);
            color: #fff;
        }

        .btn-detail:hover::after {
            left: 130%;
        }

        /* ============ EMPTY STATE ============ */
        .empty-state {
            padding: 48px 20px;
            text-align: center;
        }

        .empty-state .es-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 16px;
            border-radius: 24px;
            background: linear-gradient(135deg, #FFF0F5, #FFE3EC);
            border: 1px solid #FBCFE8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f9a8c4;
            font-size: 26px;
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

        /* ============ MOBILE TABLE ============ */
        @media (max-width: 768px) {
            .table-premium thead {
                display: none;
            }

            .table-premium tbody tr {
                display: block;
                padding: 14px;
                border: 1px solid #FDE1EC;
                border-radius: 14px;
                margin-bottom: 10px;
                background: #fff;
            }

            .table-premium tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 12px;
                padding: 7px 0;
                border: none;
                text-align: right;
            }

            .table-premium tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--gray);
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.3px;
            }

            .table-premium tbody td .truncate {
                max-width: 55vw;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                @if (session('message'))
                    <div class="alert-premium success">
                        <div class="alert-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                        </div>
                        {{ session('message') }}
                    </div>
                @endif

                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                    <line x1="12" y1="9" x2="12" y2="13" />
                                    <line x1="12" y1="17" x2="12.01" y2="17" />
                                </svg>
                            </div>
                            <div class="ph-text">
                                <div class="ph-breadcrumb">
                                    <span>Dashboard</span>
                                    <i class="fas fa-chevron-right"></i>
                                    <span>Laporan Masalah</span>
                                </div>
                                <h3>Laporan Masalah</h3>
                                <p>Kelola laporan masalah dari kasir, beautycian, dan pelanggan.</p>
                            </div>
                        </div>
                        <div class="ph-badge">
                            <span class="badge-dot"></span>
                            {{ $summary['baru'] }} laporan baru
                        </div>
                    </div>
                </div>

                <div class="content-card">
                    <div class="card-title-wrap mb-5">
                        <h3><i class="fa-solid fa-triangle-exclamation text-pink-500 mr-2"></i>Laporan Masalah</h3>
                        <p><i class="fa-regular fa-circle-check text-pink-300 mr-1"></i>Total {{ $laporan->count() }}
                            laporan masalah tercatat</p>
                    </div>

                    <div class="stat-grid">
                        <div class="stat-card stat-baru">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="sc-label">Baru</p>
                                    <p class="sc-value">{{ $summary['baru'] }}</p>
                                </div>
                                <div class="sc-icon">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card stat-diproses">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="sc-label">Diproses</p>
                                    <p class="sc-value">{{ $summary['diproses'] }}</p>
                                </div>
                                <div class="sc-icon">
                                    <i class="fa-solid fa-gears"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card stat-selesai">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="sc-label">Selesai</p>
                                    <p class="sc-value">{{ $summary['selesai'] }}</p>
                                </div>
                                <div class="sc-icon">
                                    <i class="fa-regular fa-circle-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="GET" action="" class="filter-bar">
                        <div class="filter-search-wrap">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" placeholder="Cari laporan..." name="keyword"
                                class="filter-input" value="{{ Request()->keyword }}">
                        </div>
                        <select name="role" onchange="this.form.submit()" class="filter-input w-full sm:w-auto">
                            <option value="">Semua Pelapor</option>
                            <option value="kasir" {{ $filterRole === 'kasir' ? 'selected' : '' }}>Kasir</option>
                            <option value="beautycian" {{ $filterRole === 'beautycian' ? 'selected' : '' }}>Beautycian</option>
                            <option value="pelanggan" {{ $filterRole === 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                        </select>
                        <select name="status" onchange="this.form.submit()" class="filter-input w-full sm:w-auto">
                            <option value="">Semua Status</option>
                            <option value="baru" {{ $filterStatus === 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="diproses" {{ $filterStatus === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $filterStatus === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </form>

                    <div class="table-wrap">
                        <table class="table-premium">
                            <thead>
                                <tr>
                                    <th>Pelapor</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Bukti</th>
                                    <th>Status</th>
                                    <th>Waktu</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporan as $item)
                                    <tr>
                                        <td data-label="Pelapor">
                                            <div class="flex items-center gap-2.5">
                                                <div class="avatar-initials">
                                                    {{ substr($item->user->nama ?? '?', 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-[12px] font-semibold text-gray-700">
                                                        {{ $item->user->nama ?? '-' }}
                                                    </div>
                                                    <span class="badge-status badge-role mt-0.5">{{ ucfirst($item->role) }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Kategori">
                                            <span class="tipe-pill"><i class="fa-solid fa-tag text-[9px]"></i>{{ $item->kategori }}</span>
                                        </td>
                                        <td data-label="Deskripsi">
                                            <div class="text-[12px] font-semibold text-gray-700 max-w-[220px] truncate">
                                                {{ $item->deskripsi }}
                                            </div>
                                        </td>
                                        <td data-label="Bukti">
                                            @if (!empty($item->bukti))
                                                <span class="inline-flex items-center gap-1.5 text-[12px] text-gray-600">
                                                    <i class="fa-solid fa-paperclip text-pink-400"></i>
                                                    {{ count($item->bukti) }} file
                                                </span>
                                            @else
                                                <span class="text-[11px] text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td data-label="Status">
                                            <span class="badge-status badge-{{ $item->status }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td data-label="Waktu">
                                            <div class="text-[12px] text-gray-600 font-medium">
                                                <i class="fa-regular fa-calendar text-pink-300 mr-1"></i>
                                                {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                                            </div>
                                            <div class="text-[10px] text-gray-400 mt-0.5">
                                                {{ $item->created_at ? $item->created_at->format('H:i') : '' }}
                                            </div>
                                        </td>
                                        <td data-label="Aksi" class="text-right">
                                            <a href="{{ route('admin.laporan-masalah.show', $item->id_laporan) }}" class="btn-detail">
                                                <i class="fa-solid fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state">
                                                <div class="es-icon">
                                                    <i class="fa-solid fa-flag"></i>
                                                </div>
                                                <h4>Belum ada laporan masalah</h4>
                                                <p>Laporan dari kasir, beautycian, dan pelanggan akan muncul di sini</p>
                                            </div>
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
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>