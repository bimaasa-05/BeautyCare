<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Riwayat - BeautyCare</title>
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

        /* ============ BACK LINK ============ */
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

        .dc-header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding-bottom: 20px;
            border-bottom: 1px solid #FDF2F7;
            margin-bottom: 24px;
        }

        .dc-header .dc-icon {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            background: linear-gradient(135deg, #FF4F87, #FF7BA6);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            box-shadow: 0 6px 18px rgba(255, 79, 135, 0.3);
        }

        .dc-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: #1F2937;
            margin: 0;
        }

        .dc-header p {
            font-size: 12px;
            color: #9CA3AF;
            margin: 2px 0 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
            margin-bottom: 22px;
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

        .deskripsi-box {
            background: linear-gradient(135deg, #FFF9FC, #fff);
            border: 1px solid #FDE1EC;
            border-radius: 14px;
            padding: 18px 20px;
            margin-bottom: 22px;
        }

        .deskripsi-box .db-label {
            font-size: 11px;
            font-weight: 700;
            color: #DB2777;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .deskripsi-box p {
            font-size: 13px;
            color: #4B5563;
            line-height: 1.8;
            margin: 0;
        }

        /* ============ JSON VIEW ============ */
        .json-section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .json-view {
            background: #1E293B;
            border-radius: 14px;
            padding: 18px 20px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.7;
            white-space: pre-wrap;
            word-break: break-all;
            max-height: 420px;
            overflow-y: auto;
            border: 1px solid #0F172A;
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.25);
        }

        .json-view .jv-key {
            color: #F472B6;
        }

        .json-view .jv-str {
            color: #6EE7B7;
        }

        .json-view .jv-num {
            color: #93C5FD;
        }

        .json-view .jv-bool {
            color: #FBBF24;
        }

        .json-view .jv-null {
            color: #94A3B8;
            font-style: italic;
        }

        .json-view::-webkit-scrollbar-thumb {
            background: #475569;
        }

        @media (max-width: 768px) {
            .dc-body {
                padding: 20px;
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
                                    <i class="fas fa-chevron-right"></i>
                                    <span>Detail</span>
                                </div>
                                <h3>Detail Riwayat</h3>
                                <p>Lihat detail riwayat aktivitas secara lengkap.</p>
                            </div>
                        </div>
                        <div class="ph-badge">
                            <i class="fa-solid fa-hashtag"></i>
                            ID {{ $riwayat->id }}
                        </div>
                    </div>
                </div>

                <div class="max-w-4xl mx-auto">
                    <a href="{{ route('admin.riwayat.index') }}" class="btn-back mb-4">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat
                    </a>

                    <div class="detail-card">
                        <div class="dc-body">
                            <div class="dc-header">
                                <div class="dc-icon">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </div>
                                <div>
                                    <h3>Detail Riwayat Aktivitas</h3>
                                    <p>{{ \Carbon\Carbon::parse($riwayat->created_at)->format('d F Y H:i:s') }}</p>
                                </div>
                            </div>

                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="ii-label"><i class="fa-solid fa-user"></i> User</div>
                                    <div class="ii-value">
                                        @php
                                            $avClass = match ($riwayat->role) {
                                                'admin' => 'av-admin',
                                                'kasir' => 'av-kasir',
                                                'beautycian' => 'av-beautycian',
                                                'pelanggan' => 'av-pelanggan',
                                                default => 'av-default',
                                            };
                                        @endphp
                                        <div class="avatar-initials {{ $avClass }}">
                                            {{ $riwayat->user ? strtoupper(substr($riwayat->user->nama, 0, 2)) : '??' }}
                                        </div>
                                        {{ $riwayat->user->nama ?? 'System' }}
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="ii-label"><i class="fa-solid fa-shield-halved"></i> Role</div>
                                    <div class="ii-value">
                                        @php
                                            $roleClass = match ($riwayat->role) {
                                                'admin' => 'role-admin',
                                                'kasir' => 'role-kasir',
                                                'beautycian' => 'role-beautycian',
                                                'pelanggan' => 'role-pelanggan',
                                                default => 'bg-gray-100 text-gray-600',
                                            };
                                        @endphp
                                        <span class="role-badge {{ $roleClass }}">
                                            <i class="fa-solid fa-circle text-[6px]"></i> {{ ucfirst($riwayat->role) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="ii-label"><i class="fa-solid fa-bolt"></i> Aksi</div>
                                    <div class="ii-value">
                                        <span class="aksi-pill">{{ $riwayat->aksi }}</span>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="ii-label"><i class="fa-solid fa-tag"></i> Tipe</div>
                                    <div class="ii-value">{{ $riwayat->tipe ?? '-' }}</div>
                                </div>

                                @if ($riwayat->id_tipe)
                                    <div class="info-item">
                                        <div class="ii-label"><i class="fa-solid fa-link"></i> ID Terkait</div>
                                        <div class="ii-value">{{ $riwayat->tipe }} #{{ $riwayat->id_tipe }}</div>
                                    </div>
                                @endif
                            </div>

                            <div class="deskripsi-box">
                                <div class="db-label"><i class="fa-solid fa-align-left mr-1"></i> Deskripsi</div>
                                <p>{{ $riwayat->deskripsi }}</p>
                            </div>

                            @if ($riwayat->data_lama || $riwayat->data_baru)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if ($riwayat->data_lama)
                                        <div>
                                            <div class="json-section-title" style="color:#F87171;">
                                                <i class="fa-solid fa-circle-exclamation"></i> Data Lama
                                            </div>
                                            <div class="json-view">{{ json_encode(json_decode($riwayat->data_lama), JSON_PRETTY_PRINT) }}</div>
                                        </div>
                                    @endif

                                    @if ($riwayat->data_baru)
                                        <div>
                                            <div class="json-section-title" style="color:#34D399;">
                                                <i class="fa-solid fa-circle-check"></i> Data Baru
                                            </div>
                                            <div class="json-view">{{ json_encode(json_decode($riwayat->data_baru), JSON_PRETTY_PRINT) }}</div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .aksi-pill {
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
    </style>

    <script>
        document.querySelectorAll('.json-view').forEach(el => {
            const raw = el.textContent.trim();
            if (!raw) return;
            const safe = raw.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            el.innerHTML = safe.replace(
                /("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g,
                (match) => {
                    let cls = 'jv-num';
                    if (/^"/.test(match)) {
                        cls = /:\s*$/.test(match) ? 'jv-key' : 'jv-str';
                    } else if (/true|false/.test(match)) {
                        cls = 'jv-bool';
                    } else if (/null/.test(match)) {
                        cls = 'jv-null';
                    }
                    return '<span class="' + cls + '">' + match + '</span>';
                }
            );
        });
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>