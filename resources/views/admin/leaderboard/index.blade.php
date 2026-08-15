<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Papan Peringkat - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
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

        @media (max-width: 768px) {
            .admin-table thead {
                display: none;
            }

            .admin-table tbody tr {
                display: block;
                padding: 16px;
                border-bottom: 1px solid #f0f0f0;
            }

            .admin-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border: none;
                font-size: 13px;
                text-align: right;
            }

            .admin-table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #9ca3af;
                font-size: 11px;
                text-transform: uppercase;
            }

            .admin-table tbody td:first-child {
                padding-left: 0;
            }

            .admin-table tbody td:last-child {
                padding-right: 0;
            }
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

        .rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .rank-1 {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: #fff;
            box-shadow: 0 3px 10px rgba(245, 158, 11, 0.4);
        }

        .rank-2 {
            background: linear-gradient(135deg, #cbd5e1, #94a3b8);
            color: #fff;
            box-shadow: 0 3px 10px rgba(148, 163, 184, 0.4);
        }

        .rank-3 {
            background: linear-gradient(135deg, #d97706, #b45309);
            color: #fff;
            box-shadow: 0 3px 10px rgba(180, 83, 9, 0.4);
        }

        .rank-rest {
            background: #f1f5f9;
            color: #64748b;
            font-weight: 600;
        }

        .filter-btn {
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #4b5563;
            transition: all 0.15s;
            cursor: pointer;
        }

        .filter-btn:hover {
            background: #f9fafb;
        }

        .filter-btn.active {
            background: #de3b7c;
            color: #fff;
            border-color: transparent;
            box-shadow: 0 1px 4px rgba(222, 59, 124, 0.35);
        }
    </style>
</head>

<body>
    <!-- Page Loader -->
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <!-- Dashboard Content -->
            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

                <div class="page-header-premium">
                    <div class="ph-content">
                        <div class="ph-left">
                            <div class="ph-icon-wrap">
                                <span class="nav-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" />
                                        <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18" />
                                        <path d="M4 22h16" />
                                        <circle cx="12" cy="8" r="2" />
                                        <path d="M8 22v-5a4 4 0 0 1 8 0v5" />
                                    </svg>
                                </span>
                            </div>
                            <div class="ph-text">
                                <h3>Papan Peringkat</h3>
                                <p>Pantau pelanggan paling loyal! Di sini Anda dapat melihat peringkat pelanggan
                                    berdasarkan total pembelian layanan maupun produk, lengkap dengan layanan atau
                                    produk favorit mereka.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="GET" action="{{ route('admin.leaderboard.index') }}"
                    class="bg-white rounded-2xl p-4 sm:p-5 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] mb-6">
                    <div class="flex flex-wrap items-center gap-3">
                        <span
                            class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Periode</span>
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="submit" name="periode" value="semua"
                                class="filter-btn text-[12px] font-semibold px-4 py-2 rounded-full {{ $periode === 'semua' ? 'active' : '' }}">
                                Semua
                            </button>
                            <button type="submit" name="periode" value="7hari"
                                class="filter-btn text-[12px] font-semibold px-4 py-2 rounded-full {{ $periode === '7hari' ? 'active' : '' }}">
                                7 Hari
                            </button>
                            <button type="submit" name="periode" value="1bulan"
                                class="filter-btn text-[12px] font-semibold px-4 py-2 rounded-full {{ $periode === '1bulan' ? 'active' : '' }}">
                                1 Bulan
                            </button>
                            <button type="submit" name="periode" value="1tahun"
                                class="filter-btn text-[12px] font-semibold px-4 py-2 rounded-full {{ $periode === '1tahun' ? 'active' : '' }}">
                                1 Tahun
                            </button>
                            <button type="button" id="filterKustom" onclick="toggleCustomRange()"
                                class="filter-btn text-[12px] font-semibold px-4 py-2 rounded-full {{ $periode === 'custom' ? 'active' : '' }}">
                                <i class="fa-solid fa-calendar-day text-[10px]"></i> Kustom
                            </button>
                        </div>
                        <div id="customRange"
                            class="{{ $periode === 'custom' ? 'flex' : 'hidden' }} items-end gap-3">
                            <div>
                                <label for="filterDari"
                                    class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Dari</label>
                                <input type="date" id="filterDari" name="dari" value="{{ $dari ?? '' }}"
                                    class="bg-gray-50 border border-gray-100 text-[12px] rounded-lg px-3 py-2 focus:outline-none focus:border-pink-300 transition-all">
                            </div>
                            <div>
                                <label for="filterSampai"
                                    class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Sampai</label>
                                <input type="date" id="filterSampai" name="sampai" value="{{ $sampai ?? '' }}"
                                    class="bg-gray-50 border border-gray-100 text-[12px] rounded-lg px-3 py-2 focus:outline-none focus:border-pink-300 transition-all">
                            </div>
                        </div>
                        <button type="submit" name="periode" value="custom" id="filterTerapkan"
                            class="{{ $periode === 'custom' ? 'flex' : 'hidden' }} items-center gap-2 bg-[#de3b7c] text-white text-[12px] font-semibold px-5 py-2 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                            <i class="fa-solid fa-filter text-xs"></i> Terapkan
                        </button>
                    </div>
                    <p class="text-[11px] text-gray-400 mt-3">
                        <i class="fa-solid fa-calendar-days text-[10px]"></i>
                        Periode aktif:
                        @if ($periode === 'semua')
                            Semua Waktu
                        @else
                            {{ date('d M Y', strtotime($startDate)) }} - {{ date('d M Y', strtotime($endDate)) }}
                        @endif
                        &middot; hanya transaksi berstatus Lunas
                    </p>
                </form>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div
                        class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex flex-col min-w-0">
                        <div class="flex items-center gap-3 mb-6">
                            <span
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-rose-400 text-white flex items-center justify-center shadow-md shadow-pink-200 flex-shrink-0">
                                <i class="fa-solid fa-wand-magic-sparkles text-sm"></i>
                            </span>
                            <div>
                                <h3 class="text-[16px] font-bold text-gray-800">Top Global Pelanggan (Layanan)</h3>
                                <p class="text-[12px] text-gray-400 mt-0.5">Peringkat berdasarkan total pembelian
                                    layanan (status Lunas)</p>
                            </div>
                        </div>

                        <div class="overflow-x-auto flex-1">
                            <table class="w-full text-left border-collapse admin-table">
                                <thead>
                                    <tr
                                        class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-gray-50/50">
                                        <th class="py-3 px-4 w-14">No</th>
                                        <th class="py-3 px-4">Nama Pelanggan</th>
                                        <th class="py-3 px-4">Layanan</th>
                                        <th class="py-3 px-4 text-right">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                    @forelse ($topLayanan as $row)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="py-3.5 px-4" data-label="No">
                                                <span
                                                    class="rank-badge {{ $loop->iteration == 1 ? 'rank-1' : ($loop->iteration == 2 ? 'rank-2' : ($loop->iteration == 3 ? 'rank-3' : 'rank-rest')) }}">
                                                    @if ($loop->iteration == 1)
                                                        <i class="fa-solid fa-crown text-[11px]"></i>
                                                    @else
                                                        {{ $loop->iteration }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-4 font-semibold text-gray-800" data-label="Nama Pelanggan">
                                                {{ $row->nm_pelanggan }}
                                            </td>
                                            <td class="py-3.5 px-4 text-gray-500" data-label="Layanan">
                                                <span
                                                    class="inline-flex items-center gap-1.5 bg-pink-50 text-pink-600 px-2.5 py-1 rounded-full text-[11px] font-semibold">
                                                    <i class="fa-solid fa-heart text-[9px]"></i>
                                                    {{ $row->favorit }}
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-4 text-right font-bold text-gray-800 whitespace-nowrap"
                                                data-label="Nominal">
                                                {{ $fmt($row->nominal) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-8 text-center text-gray-400 text-[13px]">Belum
                                                ada data transaksi layanan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex flex-col min-w-0">
                        <div class="flex items-center gap-3 mb-6">
                            <span
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-400 text-white flex items-center justify-center shadow-md shadow-violet-200 flex-shrink-0">
                                <i class="fa-solid fa-bag-shopping text-sm"></i>
                            </span>
                            <div>
                                <h3 class="text-[16px] font-bold text-gray-800">Top Global Pelanggan (Produk)</h3>
                                <p class="text-[12px] text-gray-400 mt-0.5">Peringkat berdasarkan total pembelian
                                    produk (status Lunas)</p>
                            </div>
                        </div>

                        <div class="overflow-x-auto flex-1">
                            <table class="w-full text-left border-collapse admin-table">
                                <thead>
                                    <tr
                                        class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-gray-50/50">
                                        <th class="py-3 px-4 w-14">No</th>
                                        <th class="py-3 px-4">Nama Pelanggan</th>
                                        <th class="py-3 px-4">Produk</th>
                                        <th class="py-3 px-4 text-right">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                    @forelse ($topProduk as $row)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="py-3.5 px-4" data-label="No">
                                                <span
                                                    class="rank-badge {{ $loop->iteration == 1 ? 'rank-1' : ($loop->iteration == 2 ? 'rank-2' : ($loop->iteration == 3 ? 'rank-3' : 'rank-rest')) }}">
                                                    @if ($loop->iteration == 1)
                                                        <i class="fa-solid fa-crown text-[11px]"></i>
                                                    @else
                                                        {{ $loop->iteration }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-4 font-semibold text-gray-800" data-label="Nama Pelanggan">
                                                {{ $row->nm_pelanggan }}
                                            </td>
                                            <td class="py-3.5 px-4 text-gray-500" data-label="Produk">
                                                <span
                                                    class="inline-flex items-center gap-1.5 bg-violet-50 text-violet-600 px-2.5 py-1 rounded-full text-[11px] font-semibold">
                                                    <i class="fa-solid fa-heart text-[9px]"></i>
                                                    {{ $row->favorit }}
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-4 text-right font-bold text-gray-800 whitespace-nowrap"
                                                data-label="Nominal">
                                                {{ $fmt($row->nominal) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-8 text-center text-gray-400 text-[13px]">Belum
                                                ada data transaksi produk</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)]">
                    <div class="flex items-center gap-3 mb-6">
                        <span
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-400 text-white flex items-center justify-center shadow-md shadow-emerald-200 flex-shrink-0">
                            <i class="fa-solid fa-star text-sm"></i>
                        </span>
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">Leaderboard Beautycian</h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">Peringkat berdasarkan jumlah pelanggan yang
                                memilih beautycian untuk treatment</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse admin-table">
                            <thead>
                                <tr
                                    class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-gray-50/50">
                                    <th class="py-3 px-4 w-14">No</th>
                                    <th class="py-3 px-4">Beautycian</th>
                                    <th class="py-3 px-4 text-right">Pelanggan</th>
                                    <th class="py-3 px-4 text-right">Total Booking</th>
                                    <th class="py-3 px-4 text-right">Selesai</th>
                                    <th class="py-3 px-4 text-right">Tingkat Selesai</th>
                                </tr>
                            </thead>
                            <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                @forelse ($topBeautycian as $row)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="py-3.5 px-4" data-label="No">
                                            <span
                                                class="rank-badge {{ $loop->iteration == 1 ? 'rank-1' : ($loop->iteration == 2 ? 'rank-2' : ($loop->iteration == 3 ? 'rank-3' : 'rank-rest')) }}">
                                                @if ($loop->iteration == 1)
                                                    <i class="fa-solid fa-crown text-[11px]"></i>
                                                @else
                                                    {{ $loop->iteration }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4" data-label="Beautycian">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $row->foto_url }}" alt="{{ $row->nama }}"
                                                    class="w-9 h-9 rounded-full object-cover border border-gray-100"
                                                    loading="lazy">
                                                <span class="font-semibold text-gray-800">{{ $row->nama }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-right font-bold text-emerald-600 whitespace-nowrap"
                                            data-label="Pelanggan">
                                            {{ $row->total_pelanggan }}
                                        </td>
                                        <td class="py-3.5 px-4 text-right font-semibold text-gray-800 whitespace-nowrap"
                                            data-label="Total Booking">
                                            {{ $row->total_booking }}
                                        </td>
                                        <td class="py-3.5 px-4 text-right text-gray-600 whitespace-nowrap"
                                            data-label="Selesai">
                                            {{ $row->total_selesai }}
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap" data-label="Tingkat Selesai">
                                            <span
                                                class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full text-[11px] font-semibold">
                                                <i class="fa-solid fa-check text-[9px]"></i>
                                                {{ $row->win_rate }}%
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-gray-400 text-[13px]">Belum
                                            ada data treatment beautycian</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            <div class="mt-6 bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)]">
                    <div class="flex items-center gap-3 mb-6">
                        <span
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-400 text-white flex items-center justify-center shadow-md shadow-amber-200 flex-shrink-0">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                                <line x1="1" y1="10" x2="23" y2="10" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">Leaderboard Kasir</h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">Peringkat berdasarkan total nominal transaksi
                                kasir (status Lunas)</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse admin-table">
                            <thead>
                                <tr
                                    class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-gray-50/50">
                                    <th class="py-3 px-4 w-14">No</th>
                                    <th class="py-3 px-4">Kasir</th>
                                    <th class="py-3 px-4 text-right">Total Nominal</th>
                                    <th class="py-3 px-4 text-right">Transaksi</th>
                                    <th class="py-3 px-4 text-right">Pelanggan</th>
                                    <th class="py-3 px-4 text-right">Rata-rata</th>
                                </tr>
                            </thead>
                            <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                @forelse ($topKasir as $row)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="py-3.5 px-4" data-label="No">
                                            <span
                                                class="rank-badge {{ $loop->iteration == 1 ? 'rank-1' : ($loop->iteration == 2 ? 'rank-2' : ($loop->iteration == 3 ? 'rank-3' : 'rank-rest')) }}">
                                                @if ($loop->iteration == 1)
                                                    <i class="fa-solid fa-crown text-[11px]"></i>
                                                @else
                                                    {{ $loop->iteration }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4" data-label="Kasir">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $row->foto_url }}" alt="{{ $row->nama }}"
                                                    class="w-9 h-9 rounded-full object-cover border border-gray-100"
                                                    loading="lazy">
                                                <span class="font-semibold text-gray-800">{{ $row->nama }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-right font-bold text-amber-600 whitespace-nowrap"
                                            data-label="Total Nominal">
                                            {{ $fmt($row->total_nominal) }}
                                        </td>
                                        <td class="py-3.5 px-4 text-right font-semibold text-gray-800 whitespace-nowrap"
                                            data-label="Transaksi">
                                            {{ $row->total_transaksi }}
                                        </td>
                                        <td class="py-3.5 px-4 text-right text-gray-600 whitespace-nowrap"
                                            data-label="Pelanggan">
                                            {{ $row->total_pelanggan }}
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap" data-label="Rata-rata">
                                            <span
                                                class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 px-2.5 py-1 rounded-full text-[11px] font-semibold">
                                                <i class="fa-solid fa-coins text-[9px]"></i>
                                                {{ $fmt($row->rata_rata) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-gray-400 text-[13px]">Belum
                                            ada data transaksi kasir</td>
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
        function toggleCustomRange() {
            const range = document.getElementById('customRange');
            const apply = document.getElementById('filterTerapkan');
            const btn = document.getElementById('filterKustom');
            const show = range.classList.contains('hidden');
            range.classList.toggle('hidden', !show);
            apply.classList.toggle('hidden', !show);
            btn.classList.toggle('active', show);
        }

        // Set current date
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @include('partials.confirm-modal')
</body>

</html>