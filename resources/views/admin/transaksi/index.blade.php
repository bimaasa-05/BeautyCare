<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaksi - BeautyCare</title>
    @include('partials.head-meta')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
        .sidebar-toggle { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
        .sidebar-toggle svg { width: 24px; height: 24px; color: var(--dark); }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: 90; }
        .sidebar-overlay.active { display: block; }
        @media (max-width: 768px) { .sidebar-toggle { display: flex; align-items: center; } }
    </style>
    <style>
        @media (max-width: 768px) {
            .data-table thead { display: none; }
            .data-table tbody tr {
                display: block;
                padding: 16px;
                border-bottom: 1px solid var(--border);
            }
            .data-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border: none;
                font-size: 13px;
                text-align: right;
            }
            .data-table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--gray);
                font-size: 11px;
                text-transform: uppercase;
            }
            .data-table tbody td:first-child { padding-left: 0; }
            .data-table tbody td:last-child { padding-right: 0; }
        }
    </style>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .float-decoration { position: absolute; pointer-events: none; opacity: 0.15; font-size: 60px; }
        .badge-status { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .status-selesai { background: #E8F8EE; color: #22C55E; }
        .status-proses { background: #FEF3C7; color: #F59E0B; }
        .status-batal { background: #FDE8E8; color: #EF4444; }

        .table-row-hover { transition: background 0.2s ease; }
        .table-row-hover:hover { background: #FFF5F8 !important; }

        .pagination-custom nav svg { display: none; }
        .pagination-custom nav .flex a, .pagination-custom nav .flex span {
            font-size: 12px; padding: 6px 14px; border-radius: 100px !important; margin: 0 2px;
        }
        .pagination-custom nav .flex span:first-child, .pagination-custom nav .flex a:first-child { border-radius: 100px !important; }

        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px -6px rgba(0,0,0,0.08); }

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


            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6">

            <div class="page-header-premium">
                <div class="ph-content">
                    <div class="ph-left">
                        <div class="ph-icon-wrap">
                            <span class="nav-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Data Transaksi</h3>
                            <p>Pantau seluruh data transaksi (penjualan, pengeluaran, pemasukan).</p>
                        </div>
                    </div>
                </div>
            </div>
                @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center gap-2 text-sm text-emerald-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check text-emerald-500"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                    {{ session('success') }}
                </div>
                @endif

                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="float-decoration" style="top:-10px;right:-10px;">📋</div>
                    <div class="float-decoration" style="bottom:-10px;left:-10px;font-size:40px;">🧾</div>

                    <div class="mb-6">
                        <h3 class="text-[16px] font-bold text-gray-800">
                            <i class="fa-solid fa-receipt text-pink-500 mr-2"></i>Data Transaksi
                        </h3>
                        <p class="text-[12px] text-gray-400 mt-0.5">
                            <i class="fa-regular fa-circle-check text-pink-300 mr-1"></i>
                            Riwayat seluruh transaksi (kasir & admin)
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 mb-4" id="jenisTabs">
                        @php
                            $tabs = [
                                'semua' => 'Semua',
                                'penjualan' => 'Penjualan',
                                'pemasukan' => 'Pemasukan',
                                'pengeluaran' => 'Pengeluaran',
                            ];
                        @endphp
                        @foreach ($tabs as $key => $label)
                            <button type="button"
                                onclick="filterByJenis('{{ $key }}')"
                                data-tab="{{ $key }}"
                                class="jenis-tab px-4 py-1.5 rounded-full text-[12px] font-semibold transition-colors border {{ $key === 'semua' ? 'bg-pink-500 text-white border-pink-500 shadow-sm' : 'bg-white text-gray-500 border-gray-200 hover:border-pink-300 hover:text-pink-500' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-4">
                        <div class="stat-card bg-gradient-to-br from-sky-50 to-white rounded-xl p-4 border border-sky-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Transaksi</p>
                                    <p class="text-[26px] font-bold text-gray-800 mt-1">{{ $snapTotal }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-full bg-sky-100 flex items-center justify-center">
                                    <i class="fa-solid fa-rectangle-list text-sky-500 text-lg"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card bg-gradient-to-br from-emerald-50 to-white rounded-xl p-4 border border-emerald-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Pendapatan</p>
                                    <p class="text-[26px] font-bold text-emerald-600 mt-1">Rp {{ number_format($snapPendapatan, 0, ',', '.') }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-full bg-emerald-100 flex items-center justify-center">
                                    <i class="fa-solid fa-money-bill-trend-up text-emerald-500 text-lg"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card bg-gradient-to-br from-red-50 to-white rounded-xl p-4 border border-red-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Pengeluaran</p>
                                    <p class="text-[26px] font-bold text-red-600 mt-1">Rp {{ number_format($snapPengeluaran, 0, ',', '.') }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-full bg-red-100 flex items-center justify-center">
                                    <i class="fa-solid fa-arrow-trend-down text-red-500 text-lg"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card bg-gradient-to-br from-purple-50 to-white rounded-xl p-4 border border-purple-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Bersih</p>
                                    <p class="text-[26px] font-bold {{ $snapBersih >= 0 ? 'text-purple-600' : 'text-red-600' }} mt-1">Rp {{ number_format($snapBersih, 0, ',', '.') }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-full bg-purple-100 flex items-center justify-center">
                                    <i class="fa-solid fa-wallet text-purple-500 text-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        <a href="{{ route('admin.transaksi.pembelian-create') }}"
                            class="flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-[12px] font-semibold px-4 py-2 rounded-full transition-colors">
                            <i class="fa-solid fa-truck"></i> Pembelian Stok
                        </a>
                        <button type="button" onclick="openTambahModal()"
                            class="flex items-center gap-2 bg-gradient-to-r from-[#EC4899] to-[#BE185D] hover:shadow-md text-white text-[12px] font-semibold px-4 py-2 rounded-full transition-all shadow-sm">
                            <i class="fa-solid fa-plus"></i> Tambah Transaksi
                        </button>
                    </div>

                    <form method="GET" action="{{ route('admin.transaksi.index') }}" class="flex flex-wrap items-center justify-between gap-2 mb-4">
                        <div class="relative">
                            <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[12px]"></i>
                            <input type="text" placeholder="Cari invoice, pelanggan, kategori..." name="keyword"
                                class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-full sm:w-[180px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
                                value="{{ request()->keyword }}">
                        </div>
                        <input type="date" name="dari" value="{{ request()->dari }}"
                            class="bg-gray-50 border border-gray-100 text-[12px] rounded-full px-3 py-2 w-full sm:w-[140px] focus:outline-none focus:border-pink-300 transition-all">
                        <span class="text-gray-400 text-[12px] hidden sm:inline">—</span>
                        <input type="date" name="sampai" value="{{ request()->sampai }}"
                            class="bg-gray-50 border border-gray-100 text-[12px] rounded-full px-3 py-2 w-full sm:w-[140px] focus:outline-none focus:border-pink-300 transition-all">
                        <button type="submit"
                            class="bg-pink-50 text-pink-600 text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-pink-100 transition-colors border border-pink-200">
                            <i class="fa-solid fa-filter mr-1"></i> Filter
                        </button>
                        @if (request()->keyword || request()->dari || request()->sampai)
                            <a href="{{ route('admin.transaksi.index') }}"
                                class="text-gray-400 hover:text-gray-600 text-[12px] px-1">
                                <i class="fa-solid fa-rotate-right"></i>
                            </a>
                        @endif
                        <a href="javascript:void(0)" onclick="exportTransaksi()"
                            class="flex items-center gap-2 border border-pink-100 text-gray-500 text-[12px] font-semibold px-4 py-2 rounded-full hover:border-pink-300">
                            <i class="fa-solid fa-download"></i> Export
                        </a>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="data-table w-full text-left border-collapse" style="table-layout:fixed">
                            <thead>
                                <tr class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-pink-50/30">
                                    <th class="py-3 px-4 w-10">#</th>
                                    <th class="py-3 px-4 w-[130px]">No. Invoice</th>
                                    <th class="py-3 px-4 w-[110px]">Jenis</th>
                                    <th class="py-3 px-4">Pelanggan/Supplier</th>
                                    <th class="py-3 px-4 w-[100px]">Tanggal</th>
                                    <th class="py-3 px-4 w-[120px]">Total</th>
                                    <th class="py-3 px-4 w-[100px]">Metode</th>
                                    <th class="py-3 px-4 w-[140px]">Admin</th>
                                    <th class="py-3 px-4 w-[90px]">Status</th>
                                    <th class="py-3 px-4 w-[110px] text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                @forelse($transaksi as $t)
                                    <tr class="table-row-hover" data-jenis="{{ strtolower($t->jenis_transaksi) }}">
                                        <td data-label="#" class="py-3.5 px-4 text-gray-400 font-medium text-center text-[12px]">{{ $loop->iteration }}</td>
                                        <td data-label="Invoice" class="py-3.5 px-4">
                                            <span class="font-mono font-semibold text-gray-700 text-[12px]">{{ $t->no_invoice }}</span>
                                        </td>
                                        <td data-label="Jenis" class="py-3.5 px-4">
                                            @if ($t->jenis_transaksi === 'Pengeluaran')
                                                <span class="badge-status" style="background:#FDE8E8;color:#EF4444;">
                                                    <i class="fa-solid fa-arrow-trend-down"></i> Pengeluaran
                                                </span>
                                            @elseif ($t->jenis_transaksi === 'Pemasukan')
                                                <span class="badge-status" style="background:#E6FFFA;color:#0D9488;">
                                                    <i class="fa-solid fa-gift"></i> Pemasukan
                                                </span>
                                            @else
                                                <span class="badge-status" style="background:#E8F8EE;color:#22C55E;">
                                                    <i class="fa-solid fa-arrow-trend-up"></i> Penjualan
                                                </span>
                                            @endif
                                        </td>
                                        <td data-label="Pelanggan/Supplier" class="py-3.5 px-4">
                                            @if (in_array($t->jenis_transaksi, ['Pengeluaran', 'Pemasukan']))
                                                @php
                                                    if ($t->jenis_transaksi === 'Pengeluaran') {
                                                        $pihakKat = $t->supplier->nm_supplier ?? ($t->pengeluaran->kategori ?? 'Umum');
                                                    } else {
                                                        $bag = explode(' — ', $t->catatan, 2);
                                                        $pihakKat = $bag[0] ?? 'Umum';
                                                    }
                                                @endphp
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 rounded-full bg-red-100 text-red-500 flex items-center justify-center font-bold text-[10px]">
                                                        <i class="fa-solid fa-tag"></i>
                                                    </div>
                                                    <span class="font-medium text-gray-700">{{ $pihakKat }}</span>
                                                </div>
                                            @else
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 rounded-full bg-pink-200 text-pink-600 flex items-center justify-center font-bold text-[10px]">
                                                        {{ $t->pelanggan ? strtoupper(substr($t->pelanggan->nm_pelanggan, 0, 2)) : '??' }}
                                                    </div>
                                                    <span class="font-medium text-gray-700">{{ $t->pelanggan->nm_pelanggan ?? 'Umum' }}</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td data-label="Tanggal" class="py-3.5 px-4 text-gray-500">{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                                        <td data-label="Total" class="py-3.5 px-4 font-semibold text-gray-800">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                        <td data-label="Metode" class="py-3.5 px-4">
                                            @php
                                                $metodeIcon = match($t->metode_byr) {
                                                    'Tunai' => 'fa-solid fa-money-bill-wave text-emerald-500',
                                                    'Transfer' => 'fa-solid fa-building-columns text-purple-500',
                                                    'Debit' => 'fa-solid fa-credit-card text-amber-500',
                                                    'E-Wallet' => 'fa-solid fa-wallet text-pink-500',
                                                    default => 'fa-regular fa-circle text-gray-400',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center gap-1.5 text-[12px] font-medium text-gray-600">
                                                <i class="{{ $metodeIcon }}"></i> {{ $t->metode_byr }}
                                            </span>
                                        </td>
                                        <td data-label="Admin" class="py-3.5 px-4">
                                            @php
                                                $roleBadge = match($t->user->role ?? '') {
                                                    'admin' => 'bg-purple-50 text-purple-600',
                                                    'kasir' => 'bg-amber-50 text-amber-600',
                                                    default => 'bg-gray-50 text-gray-500',
                                                };
                                                $roleIcon = match($t->user->role ?? '') {
                                                    'admin' => 'fa-solid fa-shield-halved',
                                                    'kasir' => 'fa-solid fa-user-tie',
                                                    default => 'fa-solid fa-user',
                                                };
                                            @endphp
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-gray-500 text-[12px]">{{ $t->user->nama ?? '-' }}</span>
                                                @if ($t->user && in_array($t->user->role, ['admin', 'kasir']))
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-semibold {{ $roleBadge }}">
                                                        <i class="{{ $roleIcon }}"></i> {{ ucfirst($t->user->role) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td data-label="Status" class="py-3.5 px-4">
                                            @php
                                                $mapStatus = [
                                                    'Lunas' => ['class' => 'status-selesai', 'icon' => 'fa-regular fa-circle-check', 'label' => 'Lunas'],
                                                    'Pending' => ['class' => 'status-proses', 'icon' => 'fa-regular fa-clock', 'label' => 'Pending'],
                                                    'Menunggu Pembayaran' => ['class' => 'status-proses', 'icon' => 'fa-regular fa-clock', 'label' => 'Menunggu Pembayaran'],
                                                    'Sedang Diproses' => ['class' => 'status-proses', 'icon' => 'fa-regular fa-hourglass-half', 'label' => 'Sedang Diproses'],
                                                    'Batal' => ['class' => 'status-batal', 'icon' => 'fa-regular fa-circle-xmark', 'label' => 'Batal'],
                                                    'Gagal' => ['class' => 'status-batal', 'icon' => 'fa-solid fa-xmark', 'label' => 'Gagal'],
                                                    'Dibatalkan' => ['class' => 'status-batal', 'icon' => 'fa-solid fa-ban', 'label' => 'Dibatalkan'],
                                                    'Kadaluarsa' => ['class' => 'status-batal', 'icon' => 'fa-regular fa-hourglass-end', 'label' => 'Kadaluarsa'],
                                                ];
                                                $s = $mapStatus[$t->status] ?? ['class' => 'status-proses', 'icon' => 'fa-regular fa-clock', 'label' => $t->status];
                                            @endphp
                                            <span class="badge-status {{ $s['class'] }}"><i class="{{ $s['icon'] }}"></i> {{ $s['label'] }}</span>
                                        </td>
                                        <td data-label="Aksi" class="py-3.5 px-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.transaksi.show', $t->id_transaksi) }}"
                                                    class="w-7 h-7 text-blue-500 bg-blue-50 hover:bg-blue-100 rounded-md transition-colors flex items-center justify-center"
                                                    title="Detail"><i class="fa-regular fa-eye text-xs"></i></a>
                                                @if (in_array($t->jenis_transaksi, ['Pengeluaran', 'Pemasukan']))
                                                    @php
                                                        if ($t->jenis_transaksi === 'Pemasukan') {
                                                            $bagi = explode(' — ', $t->catatan, 2);
                                                            $kategoriEdit = $bagi[0] ?? '';
                                                            $ketEdit = $bagi[1] ?? '';
                                                        } else {
                                                            $kategoriEdit = $t->pengeluaran->kategori ?? '';
                                                            $ketEdit = $t->pengeluaran->keterangan ?? '';
                                                        }
                                                    @endphp
                                                    <button onclick="editTransaksi({{ $t->id_transaksi }}, '{{ $t->jenis_transaksi }}', '{{ $t->tanggal }}', '{{ addslashes($kategoriEdit) }}', {{ $t->total }}, '{{ addslashes($ketEdit) }}')"
                                                        class="w-7 h-7 text-amber-500 bg-amber-50 hover:bg-amber-100 rounded-md transition-colors flex items-center justify-center"
                                                        title="Edit"><i class="fa-regular fa-pen-to-square text-xs"></i></button>
                                                    <form action="{{ route('admin.transaksi.destroy', $t->id_transaksi) }}" method="POST"
                                                        data-confirm-title="Hapus Transaksi" data-confirm-body="Apakah Anda yakin ingin menghapus transaksi ini? Tindakan ini tidak dapat dibatalkan." data-confirm-icon="fa-trash-can" data-confirm-type="danger" data-confirm-yes="Ya, Hapus">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="w-7 h-7 text-red-500 bg-red-50 hover:bg-red-100 rounded-md transition-colors flex items-center justify-center"
                                                            title="Hapus"><i class="fa-regular fa-trash-can text-xs"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="py-14 text-center">
                                            <div class="flex flex-col items-center gap-3">
                                                <div class="w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center">
                                                    <i class="fa-solid fa-receipt text-3xl text-pink-200"></i>
                                                </div>
                                                <p class="text-gray-400 font-medium text-[14px]">
                                                    {{ request()->keyword || request()->dari || request()->sampai ? 'Transaksi tidak ditemukan' : 'Belum ada data transaksi' }}
                                                </p>
                                                <p class="text-gray-300 text-[12px] -mt-2">
                                                    {{ request()->keyword || request()->dari || request()->sampai ? 'Coba gunakan filter yang berbeda' : 'Data transaksi akan tampil di sini' }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($transaksi->hasPages())
                        <div class="mt-4 px-4 pagination-custom">
                            {{ $transaksi->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Tambah Transaksi -->
    <div id="modalTambah" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeTambahModal()"></div>
        <div class="relative bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-pink-50 flex items-center justify-center">
                        <i class="fa-solid fa-plus text-pink-500"></i>
                    </div>
                    <div>
                        <h4 class="text-[15px] font-bold text-gray-800">Tambah Transaksi</h4>
                        <p class="text-[11px] text-gray-400">Catat pengeluaran atau pemasukan dana luar</p>
                    </div>
                </div>
                <button onclick="closeTambahModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="{{ route('admin.transaksi.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="text-[12px] font-semibold text-gray-600 mb-2 block">Jenis Transaksi</label>
                        <div class="flex gap-2">
                            <label id="btn-pengeluaran" onclick="selectJenis('Pengeluaran')" class="flex-1 flex items-center justify-center gap-2 cursor-pointer p-3 rounded-xl border-2 border-red-400 bg-red-50 transition-all">
                                <i class="fa-solid fa-arrow-trend-down text-red-500"></i>
                                <span class="text-[12px] font-semibold text-red-600">Pengeluaran</span>
                            </label>
                            <label id="btn-pemasukan" onclick="selectJenis('Pemasukan')" class="flex-1 flex items-center justify-center gap-2 cursor-pointer p-3 rounded-xl border-2 border-gray-200 bg-white transition-all">
                                <i class="fa-solid fa-arrow-trend-up text-gray-400"></i>
                                <span class="text-[12px] font-semibold text-gray-400">Pemasukan</span>
                            </label>
                        </div>
                        <input type="hidden" name="jenis" id="jenis_input" value="Pengeluaran">
                    </div>
                    <div>
                        <label class="text-[12px] font-semibold text-gray-600 mb-1.5 block">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="form-input" required>
                        @error('tanggal')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div id="field-kategori">
                        <label class="text-[12px] font-semibold text-gray-600 mb-1.5 block">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" class="form-input" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Operasional">Operasional</option>
                            <option value="Perawatan Alat">Perawatan Alat</option>
                            <option value="Bahan & Stok">Bahan & Stok</option>
                            <option value="Listrik & Air">Listrik & Air</option>
                            <option value="Kebersihan">Kebersihan</option>
                            <option value="Lainnya">Lainnya</option>
                            <option value="Dana Pemasukan">Dana Pemasukan</option>
                        </select>
                        @error('kategori')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-[12px] font-semibold text-gray-600 mb-1.5 block">Nominal (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="nominal" min="1" placeholder="Masukkan nominal" class="form-input" required>
                        @error('nominal')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-[12px] font-semibold text-gray-600 mb-1.5 block">Keterangan</label>
                        <textarea name="keterangan" rows="2" class="form-input" placeholder="Catatan (opsional)"></textarea>
                        @error('keterangan')<p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="button" onclick="closeTambahModal()"
                            class="flex-1 py-2.5 rounded-xl border border-gray-200 text-gray-600 text-[13px] font-semibold hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 py-2.5 rounded-xl bg-pink-500 text-white text-[13px] font-semibold hover:bg-pink-600 transition-colors shadow-sm">
                            <i class="fa-solid fa-check mr-1"></i>Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Transaksi -->
    <div id="modalEdit" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeEditModal()"></div>
        <div class="relative bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center">
                        <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                    </div>
                    <div>
                        <h4 class="text-[15px] font-bold text-gray-800">Edit Transaksi</h4>
                        <p class="text-[11px] text-gray-400">Ubah data transaksi</p>
                    </div>
                </div>
                <button onclick="closeEditModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="" method="POST" id="formEdit">
                @csrf
                @method('PUT')
                <input type="hidden" name="jenis" id="edit_jenis" value="Pengeluaran">
                <div class="space-y-4">
                    <div>
                        <label class="text-[12px] font-semibold text-gray-600 mb-1.5 block">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="form-input" required>
                    </div>
                    <div>
                        <label class="text-[12px] font-semibold text-gray-600 mb-1.5 block">Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="kategori" id="edit_kategori" class="form-input" required>
                    </div>
                    <div>
                        <label class="text-[12px] font-semibold text-gray-600 mb-1.5 block">Nominal (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="nominal" id="edit_nominal" min="1" class="form-input" required>
                    </div>
                    <div>
                        <label class="text-[12px] font-semibold text-gray-600 mb-1.5 block">Keterangan</label>
                        <textarea name="keterangan" id="edit_keterangan" rows="2" class="form-input"></textarea>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="button" onclick="closeEditModal()"
                            class="flex-1 py-2.5 rounded-xl border border-gray-200 text-gray-600 text-[13px] font-semibold hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 py-2.5 rounded-xl bg-amber-500 text-white text-[13px] font-semibold hover:bg-amber-600 transition-colors shadow-sm">
                            <i class="fa-solid fa-check mr-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentJenis = 'semua';

        function selectJenis(jenis) {
            document.getElementById('jenis_input').value = jenis;
            const btnPengeluaran = document.getElementById('btn-pengeluaran');
            const btnPemasukan = document.getElementById('btn-pemasukan');
            if (jenis === 'Pengeluaran') {
                btnPengeluaran.className = 'flex-1 flex items-center justify-center gap-2 cursor-pointer p-3 rounded-xl border-2 border-red-400 bg-red-50 transition-all';
                btnPengeluaran.querySelector('i').className = 'fa-solid fa-arrow-trend-down text-red-500';
                btnPengeluaran.querySelector('span').className = 'text-[12px] font-semibold text-red-600';
                btnPemasukan.className = 'flex-1 flex items-center justify-center gap-2 cursor-pointer p-3 rounded-xl border-2 border-gray-200 bg-white transition-all';
                btnPemasukan.querySelector('i').className = 'fa-solid fa-arrow-trend-up text-gray-400';
                btnPemasukan.querySelector('span').className = 'text-[12px] font-semibold text-gray-400';
            } else {
                btnPemasukan.className = 'flex-1 flex items-center justify-center gap-2 cursor-pointer p-3 rounded-xl border-2 border-emerald-400 bg-emerald-50 transition-all';
                btnPemasukan.querySelector('i').className = 'fa-solid fa-arrow-trend-up text-emerald-500';
                btnPemasukan.querySelector('span').className = 'text-[12px] font-semibold text-emerald-600';
                btnPengeluaran.className = 'flex-1 flex items-center justify-center gap-2 cursor-pointer p-3 rounded-xl border-2 border-gray-200 bg-white transition-all';
                btnPengeluaran.querySelector('i').className = 'fa-solid fa-arrow-trend-down text-gray-400';
                btnPengeluaran.querySelector('span').className = 'text-[12px] font-semibold text-gray-400';
            }
        }

        function filterByJenis(jenis) {
            currentJenis = jenis;
            document.querySelectorAll('.jenis-tab').forEach(btn => {
                if (btn.dataset.tab === jenis) {
                    btn.classList.add('bg-pink-500', 'text-white', 'border-pink-500', 'shadow-sm');
                    btn.classList.remove('bg-white', 'text-gray-500', 'border-gray-200');
                } else {
                    btn.classList.remove('bg-pink-500', 'text-white', 'border-pink-500', 'shadow-sm');
                    btn.classList.add('bg-white', 'text-gray-500', 'border-gray-200');
                }
            });
            document.querySelectorAll('tbody tr[data-jenis]').forEach(row => {
                row.style.display = (jenis === 'semua' || row.dataset.jenis === jenis) ? '' : 'none';
            });
        }

        function exportTransaksi() {
            const params = new URLSearchParams();
            const keyword = document.querySelector('input[name="keyword"]')?.value;
            const dari = document.querySelector('input[name="dari"]')?.value;
            const sampai = document.querySelector('input[name="sampai"]')?.value;
            if (keyword) params.set('keyword', keyword);
            if (dari) params.set('dari', dari);
            if (sampai) params.set('sampai', sampai);
            const qs = params.toString();
            window.location.href = '{{ route('admin.transaksi.export') }}' + (qs ? '?' + qs : '');
        }

        // Set current date
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);

        // Tambah transaksi modal
        function openTambahModal() {
            const modal = document.getElementById('modalTambah');
            if (!modal) return;
            modal.classList.remove('hidden');
            modal.querySelector('form').reset();
            selectJenis('Pengeluaran');
        }

        function closeTambahModal() {
            const modal = document.getElementById('modalTambah');
            if (modal) modal.classList.add('hidden');
        }

        function closeEditModal() {
            const modal = document.getElementById('modalEdit');
            if (modal) modal.classList.add('hidden');
        }

        function editTransaksi(id, jenis, tanggal, kategori, nominal, keterangan) {
            const form = document.getElementById('formEdit');
            form.action = "{{ url('admin/transaksi') }}/" + id;
            document.getElementById('edit_jenis').value = jenis;
            document.getElementById('edit_tanggal').value = tanggal;
            document.getElementById('edit_kategori').value = kategori;
            document.getElementById('edit_nominal').value = nominal;
            document.getElementById('edit_keterangan').value = keterangan;
            document.getElementById('modalEdit').classList.remove('hidden');
        }
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @include('partials.confirm-modal')
</body>

</html>
