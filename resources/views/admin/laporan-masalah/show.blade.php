<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Laporan Masalah - BeautyCare</title>
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

        /* ============ BACK BUTTON ============ */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 20px;
            border-radius: 100px;
            background: #fff;
            border: 1.5px solid #FDE1EC;
            color: #DB2777;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 2px 10px rgba(236, 72, 153, 0.08);
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: #FFF0F5;
            border-color: #F9A8C9;
            transform: translateX(-3px);
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

        /* ============ DETAIL CARD ============ */
        .detail-card {
            background: #fff;
            border: 1px solid #FDE1EC;
            border-radius: 22px;
            box-shadow: 0 2px 18px rgba(236, 72, 153, 0.07);
            position: relative;
            overflow: hidden;
            animation: cardIn 0.5s ease both;
        }

        .detail-card::before {
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

        .dc-body {
            padding: 28px 30px;
        }

        .dc-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 22px;
            padding-bottom: 20px;
            border-bottom: 1px solid #FDF2F7;
        }

        .dc-top .dt-title {
            font-size: 16px;
            font-weight: 700;
            color: #1F2937;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dc-top .dt-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            box-shadow: 0 6px 16px rgba(255, 79, 135, 0.3);
            flex-shrink: 0;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 14px;
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

        /* ============ INFO GRID ============ */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }

        @media (min-width: 640px) {
            .info-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .info-item {
            background: #FFF9FC;
            border: 1px solid #FDE1EC;
            border-radius: 14px;
            padding: 14px 18px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .info-item:hover {
            border-color: #F9C4D9;
            box-shadow: 0 4px 14px -6px rgba(236, 72, 153, 0.15);
        }

        .info-item .ii-label {
            font-size: 10.5px;
            font-weight: 700;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-item .ii-label i {
            color: #f0a1bd;
            font-size: 10px;
        }

        .info-item .ii-value {
            font-size: 13.5px;
            font-weight: 600;
            color: #1F2937;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .avatar-initials {
            width: 32px;
            height: 32px;
            border-radius: 11px;
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
            box-shadow: 0 3px 8px rgba(255, 79, 135, 0.25);
        }

        /* ============ DESKRIPSI & CATATAN ============ */
        .dc-deskripsi {
            margin-top: 20px;
            background: linear-gradient(135deg, #FFF9FC, #fff);
            border: 1px solid #FDE1EC;
            border-radius: 14px;
            padding: 18px 20px;
        }

        .dc-deskripsi .dd-label {
            font-size: 11px;
            font-weight: 700;
            color: #DB2777;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .dc-deskripsi p {
            font-size: 13px;
            color: #4B5563;
            line-height: 1.8;
            white-space: pre-line;
            margin: 0;
        }

        .dc-catatan {
            margin-top: 16px;
            background: #F0FDF4;
            border-left: 4px solid #22C55E;
            border-radius: 12px;
            padding: 14px 18px;
        }

        .dc-catatan .cc-label {
            font-size: 11px;
            font-weight: 700;
            color: #15803D;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .dc-catatan p {
            font-size: 12.5px;
            color: #475569;
            line-height: 1.7;
            margin: 0;
            white-space: pre-line;
        }

        /* ============ BUKTI ============ */
        .bukti-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 14px;
            margin-top: 14px;
        }

        .bukti-item {
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #FDE1EC;
            background: #FFF9FC;
            position: relative;
            transition: transform 0.25s, box-shadow 0.25s;
        }

        .bukti-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px -8px rgba(236, 72, 153, 0.25);
        }

        .bukti-item img,
        .bukti-item video {
            width: 100%;
            height: 150px;
            object-fit: cover;
            display: block;
        }

        .bukti-item .bi-video-icon {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.3);
            color: #fff;
            font-size: 32px;
            pointer-events: none;
        }

        .bukti-item .bi-name {
            font-size: 10.5px;
            color: #9CA3AF;
            padding: 8px 12px;
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }

        /* ============ TIMELINE ============ */
        .section-divider {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #FDF2F7;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: #f472b6;
        }

        .timeline {
            position: relative;
        }

        .timeline-item {
            position: relative;
            padding-left: 34px;
            margin-bottom: 20px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: 0;
            top: 4px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px currentColor;
        }

        .timeline-dot.dot-baru {
            background: #D97706;
            color: #FEF3C7;
        }

        .timeline-dot.dot-diproses {
            background: #2563EB;
            color: #DBEAFE;
        }

        .timeline-dot.dot-selesai {
            background: #22C55E;
            color: #E8F8EE;
        }

        .timeline-line {
            position: absolute;
            left: 6px;
            top: 18px;
            bottom: -20px;
            width: 2px;
            background: #FBE3EE;
        }

        .timeline-item:last-child .timeline-line {
            display: none;
        }

        .timeline-content {
            background: #FFF9FC;
            border: 1px solid #FDE1EC;
            border-radius: 14px;
            padding: 14px 16px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .timeline-content:hover {
            border-color: #F9C4D9;
            box-shadow: 0 4px 14px -6px rgba(236, 72, 153, 0.15);
        }

        .timeline-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 8px;
        }

        .timeline-time {
            font-size: 11px;
            color: #9CA3AF;
        }

        .timeline-body {
            font-size: 13px;
            color: #475569;
            line-height: 1.7;
            white-space: pre-line;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .timeline-body strong {
            color: #1F2937;
        }

        .timeline-catatan {
            margin-top: 8px;
            padding: 8px 12px;
            background: #fff;
            border-radius: 10px;
            border: 1px solid #FDE1EC;
            font-size: 12px;
            color: #4B5563;
        }

        /* ============ STATUS FORM ============ */
        .form-status {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #FDF2F7;
        }

        .fs-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        @media (min-width: 768px) {
            .fs-grid {
                grid-template-columns: 240px 1fr;
                align-items: start;
            }
        }

        .fg-label {
            font-size: 12px;
            font-weight: 600;
            color: #1F2937;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .fg-label i {
            color: #f472b6;
        }

        .fg-input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #FDE1EC;
            border-radius: 12px;
            font-size: 13px;
            outline: none;
            background: #FFF9FC;
            transition: all 0.2s;
            font-family: 'Poppins', sans-serif;
            color: #1F2937;
        }

        .fg-input:focus {
            border-color: #FF4F87;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(255, 79, 135, 0.1);
        }

        select.fg-input {
            cursor: pointer;
        }

        .fs-actions {
            margin-top: 16px;
            text-align: right;
        }

        .btn-simpan {
            padding: 12px 30px;
            border-radius: 13px;
            border: none;
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 6px 18px rgba(255, 79, 135, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-simpan::after {
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

        .btn-simpan:hover {
            transform: translateY(-2px);
            box-shadow: 0 9px 26px rgba(255, 79, 135, 0.42);
        }

        .btn-simpan:hover::after {
            left: 130%;
        }

        /* ============ SELESAI BANNER ============ */
        .closed-banner {
            margin-top: 24px;
            background: linear-gradient(135deg, #F0FDF4, #DCFCE7);
            border: 1px solid #BBF7D0;
            border-radius: 14px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .closed-banner .cb-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #22C55E, #4ADE80);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.35);
        }

        .closed-banner .cb-title {
            font-size: 14px;
            font-weight: 700;
            color: #15803D;
        }

        .closed-banner .cb-desc {
            font-size: 12px;
            color: #475569;
            margin-top: 2px;
        }

        @media (max-width: 768px) {
            .dc-body {
                padding: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .fs-grid {
                grid-template-columns: 1fr;
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
                                    <i class="fas fa-chevron-right"></i>
                                    <span>Detail</span>
                                </div>
                                <h3>Detail Laporan #{{ $laporan->id_laporan }}</h3>
                                <p>Tinjau dan tindak lanjuti laporan masalah dari pengguna.</p>
                            </div>
                        </div>
                        <span class="badge-status badge-{{ $laporan->status }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            {{ ucfirst($laporan->status) }}
                        </span>
                    </div>
                </div>

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

                <a href="{{ route('admin.laporan-masalah.index') }}" class="btn-back mb-4">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Laporan Masalah
                </a>

                <div class="detail-card">
                    <div class="dc-body">
                        <div class="dc-top">
                            <div class="dt-title">
                                <div class="dt-icon">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                                {{ $laporan->kategori }}
                            </div>
                            <span class="badge-status badge-{{ $laporan->status }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ ucfirst($laporan->status) }}
                            </span>
                        </div>

                        <div class="info-grid">
                            <div class="info-item">
                                <div class="ii-label"><i class="fa-solid fa-user"></i> Pelapor</div>
                                <div class="ii-value">
                                    <div class="avatar-initials">
                                        {{ substr($laporan->user->nama ?? '?', 0, 1) }}
                                    </div>
                                    {{ $laporan->user->nama ?? '-' }}
                                    <span class="badge-status badge-role">{{ ucfirst($laporan->role) }}</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="ii-label"><i class="fa-regular fa-clock"></i> Waktu Dilaporkan</div>
                                <div class="ii-value">
                                    {{ $laporan->created_at ? $laporan->created_at->format('d M Y H:i') : '-' }}
                                    <span class="text-[10px] text-gray-400 font-normal">
                                        {{ $laporan->created_at ? $laporan->created_at->diffForHumans() : '' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="dc-deskripsi">
                            <div class="dd-label"><i class="fa-solid fa-align-left mr-1"></i> Deskripsi Masalah</div>
                            <p>{{ $laporan->deskripsi }}</p>
                        </div>

                        @if ($laporan->catatan_admin)
                            <div class="dc-catatan">
                                <div class="cc-label"><i class="fa-solid fa-comment-dots mr-1"></i> Tanggapan Admin Saat Ini</div>
                                <p>{{ $laporan->catatan_admin }}</p>
                            </div>
                        @endif

                        @if (!empty($laporan->bukti))
                            <div class="section-divider">
                                <div class="section-title">
                                    <i class="fa-solid fa-paperclip"></i>
                                    Bukti Terlampir ({{ count($laporan->bukti) }})
                                </div>
                                <div class="bukti-grid">
                                    @foreach ($laporan->bukti as $b)
                                        @php $ext = strtolower(pathinfo($b, PATHINFO_EXTENSION)); @endphp
                                        @if (in_array($ext, ['mp4', 'mov', 'mkv', 'webm']))
                                            <div class="bukti-item">
                                                <video src="{{ asset('storage/' . $b) }}" controls></video>
                                                <div class="bi-video-icon"><i class="fa-solid fa-play"></i></div>
                                                <div class="bi-name">{{ basename($b) }}</div>
                                            </div>
                                        @else
                                            <a href="{{ asset('storage/' . $b) }}" target="_blank" class="bukti-item"
                                                style="text-decoration:none;">
                                                <img src="{{ asset('storage/' . $b) }}" alt="Bukti">
                                                <div class="bi-name">{{ basename($b) }}</div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($laporan->statusLog->count() > 0)
                            <div class="section-divider">
                                <div class="section-title">
                                    <i class="fa-solid fa-history"></i> Riwayat Status
                                </div>
                                <div class="timeline">
                                    @foreach ($laporan->statusLog as $log)
                                        <div class="timeline-item">
                                            <div class="timeline-dot dot-{{ $log->status }}"></div>
                                            <div class="timeline-line"></div>
                                            <div class="timeline-content">
                                                <div class="timeline-head">
                                                    <span class="badge-status badge-{{ $log->status }}">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                        {{ ucfirst($log->status) }}
                                                    </span>
                                                    <span class="timeline-time">
                                                        {{ $log->created_at ? $log->created_at->format('d M Y H:i') : '' }}
                                                        ({{ $log->created_at ? $log->created_at->diffForHumans() : '' }})
                                                    </span>
                                                </div>
                                                <div class="timeline-body">
                                                    <i class="fa-solid fa-user-tie text-pink-400 text-[12px]"></i>
                                                    <strong>{{ $log->admin->nama ?? 'Sistem' }}</strong>
                                                    @if ($log->catatan)
                                                        <div class="timeline-catatan">{{ $log->catatan }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($laporan->status === 'selesai')
                            <div class="closed-banner">
                                <div class="cb-icon">
                                    <i class="fa-solid fa-lock"></i>
                                </div>
                                <div>
                                    <div class="cb-title">Laporan Ditutup</div>
                                    <div class="cb-desc">Status ini sudah final dan tidak dapat diubah lagi.</div>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('admin.laporan-masalah.update-status', $laporan->id_laporan) }}"
                                method="POST" class="form-status">
                                @csrf
                                <div class="fs-grid">
                                    <div>
                                        <label class="fg-label">
                                            <i class="fa-solid fa-arrows-rotate"></i>
                                            Ubah Status <span style="color:#EF4444;">*</span>
                                        </label>
                                        <select name="status" class="fg-input" required>
                                            <option value="baru" {{ $laporan->status === 'baru' ? 'selected' : '' }}>Baru</option>
                                            <option value="diproses" {{ $laporan->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="selesai" {{ $laporan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="fg-label">
                                            <i class="fa-regular fa-comment-dots"></i>
                                            Catatan / Tanggapan untuk Pelapor
                                        </label>
                                        <textarea name="catatan_admin" class="fg-input" rows="3" maxlength="2000"
                                            placeholder="cth: Sudah diperbaiki di versi terbaru, silakan coba kembali...">{{ $laporan->catatan_admin }}</textarea>
                                    </div>
                                </div>
                                <div class="fs-actions">
                                    <button type="submit" class="btn-simpan">
                                        <i class="fa-solid fa-paper-plane"></i> Simpan &amp; Beri Tahu Pelapor
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>