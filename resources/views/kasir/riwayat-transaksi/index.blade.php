<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Transaksi - BeautyCare</title>
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .float-decoration { position: absolute; pointer-events: none; opacity: 0.15; font-size: 60px; }
        .badge-status { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .status-selesai { background: #E8F8EE; color: #22C55E; }
        .status-proses { background: #FEF3C7; color: #F59E0B; }
        .status-batal { background: #FDE8E8; color: #EF4444; }

        .table-row-hover { transition: all 0.3s ease; }
        .table-row-hover:hover { background: #FFF5F8 !important; transform: scale(1.002); }

        .pagination-custom nav svg { display: none; }
        .pagination-custom nav .flex a, .pagination-custom nav .flex span {
            font-size: 12px; padding: 6px 14px; border-radius: 100px !important; margin: 0 2px;
        }
        .pagination-custom nav .flex span:first-child, .pagination-custom nav .flex a:first-child { border-radius: 100px !important; }

        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px -6px rgba(0,0,0,0.08); }
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

            <div class="flex-1 overflow-y-auto p-8">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="float-decoration" style="top:-10px;right:-10px;">📋</div>
                    <div class="float-decoration" style="bottom:-10px;left:-10px;font-size:40px;">🧾</div>

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-solid fa-clock-rotate-left text-pink-500 mr-2"></i>Riwayat Transaksi
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-regular fa-circle-check text-pink-300 mr-1"></i>
                                {{ $totalTransaksi }} transaksi — Total pendapatan <span class="font-semibold text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="stat-card bg-gradient-to-br from-sky-50 to-white rounded-xl p-4 border border-sky-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Transaksi</p>
                                    <p class="text-[26px] font-bold text-gray-800 mt-1">{{ $totalTransaksi }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-full bg-sky-100 flex items-center justify-center">
                                    <i class="fa-regular fa-rectangle-list text-sky-500 text-lg"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card bg-gradient-to-br from-emerald-50 to-white rounded-xl p-4 border border-emerald-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Pendapatan</p>
                                    <p class="text-[26px] font-bold text-emerald-600 mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-full bg-emerald-100 flex items-center justify-center">
                                    <i class="fa-solid fa-money-bill-trend-up text-emerald-500 text-lg"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card bg-gradient-to-br from-purple-50 to-white rounded-xl p-4 border border-purple-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Rata-rata</p>
                                    <p class="text-[26px] font-bold text-purple-600 mt-1">
                                        Rp {{ number_format($totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="w-11 h-11 rounded-full bg-purple-100 flex items-center justify-center">
                                    <i class="fa-solid fa-chart-line text-purple-500 text-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <div class="relative flex-1 min-w-[200px] max-w-[300px]">
                            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <form action="" method="GET" id="searchForm">
                                <input type="text" placeholder="Cari invoice atau pelanggan..."
                                    name="keyword"
                                    class="w-full bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
                                    value="{{ request()->keyword }}">
                            </form>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="date" name="dari" form="searchForm"
                                class="bg-gray-50 border border-gray-100 text-[12px] rounded-full px-4 py-2 focus:outline-none focus:border-pink-300 transition-all"
                                value="{{ request()->dari }}">
                            <span class="text-gray-400 text-[12px]">s/d</span>
                            <input type="date" name="sampai" form="searchForm"
                                class="bg-gray-50 border border-gray-100 text-[12px] rounded-full px-4 py-2 focus:outline-none focus:border-pink-300 transition-all"
                                value="{{ request()->sampai }}">
                            <button type="submit" form="searchForm"
                                class="bg-pink-50 text-pink-500 text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-pink-100 transition-colors border border-pink-200">
                                <i class="fa-solid fa-filter mr-1"></i> Filter
                            </button>
                            @if (request()->keyword || request()->dari || request()->sampai)
                                <a href="{{ route('kasir.riwayat-transaksi.index') }}"
                                    class="text-gray-400 hover:text-gray-600 text-[12px]">
                                    <i class="fa-solid fa-rotate-right"></i> Reset
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-pink-50/30">
                                    <th class="py-3 px-4 w-10">#</th>
                                    <th class="py-3 px-4">No. Invoice</th>
                                    <th class="py-3 px-4">Pelanggan</th>
                                    <th class="py-3 px-4">Tanggal</th>
                                    <th class="py-3 px-4">Total</th>
                                    <th class="py-3 px-4">Metode</th>
                                    <th class="py-3 px-4">Kasir</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                @forelse($transaksi as $t)
                                    <tr class="table-row-hover">
                                        <td class="py-3.5 px-4 text-gray-400 font-medium text-center text-[12px]">{{ $loop->iteration }}</td>
                                        <td class="py-3.5 px-4">
                                            <span class="font-mono font-semibold text-gray-700 text-[12px]">{{ $t->no_invoice }}</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-full bg-pink-200 text-pink-600 flex items-center justify-center font-bold text-[10px]">
                                                    {{ $t->pelanggan ? strtoupper(substr($t->pelanggan->nm_pelanggan, 0, 2)) : '??' }}
                                                </div>
                                                <span class="font-medium text-gray-700">{{ $t->pelanggan->nm_pelanggan ?? 'Umum' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-gray-500">{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}</td>
                                        <td class="py-3.5 px-4 font-semibold text-gray-800">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                        <td class="py-3.5 px-4">
                                            @php
                                                $metodeIcon = match($t->metode_byr) {
                                                    'Tunai' => 'fa-solid fa-money-bill-wave text-emerald-500',
                                                    'Transfer' => 'fa-solid fa-building-columns text-purple-500',
                                                    'Debit' => 'fa-regular fa-credit-card text-amber-500',
                                                    'E-Wallet' => 'fa-solid fa-wallet text-pink-500',
                                                    default => 'fa-regular fa-circle text-gray-400',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center gap-1.5 text-[12px] font-medium text-gray-600">
                                                <i class="{{ $metodeIcon }}"></i> {{ $t->metode_byr }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-gray-500">{{ $t->user->nama ?? '-' }}</td>
                                        <td class="py-3.5 px-4">
                                            @if ($t->status == 'Lunas')
                                                <span class="badge-status status-selesai"><i class="fa-regular fa-circle-check"></i> Lunas</span>
                                            @elseif ($t->status == 'Pending')
                                                <span class="badge-status status-proses"><i class="fa-regular fa-clock"></i> Pending</span>
                                            @else
                                                <span class="badge-status status-batal"><i class="fa-regular fa-circle-xmark"></i> Batal</span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('kasir.riwayat-transaksi.show', $t->id_transaksi) }}"
                                                    class="w-7 h-7 text-blue-500 bg-blue-50 hover:bg-blue-100 rounded-md transition-colors flex items-center justify-center"
                                                    title="Detail"><i class="fa-regular fa-eye text-xs"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="py-14 text-center">
                                            <div class="flex flex-col items-center gap-3">
                                                <div class="w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center">
                                                    <i class="fa-solid fa-clock-rotate-left text-3xl text-pink-200"></i>
                                                </div>
                                                <p class="text-gray-400 font-medium text-[14px]">
                                                    {{ request()->keyword || request()->dari || request()->sampai ? 'Transaksi tidak ditemukan' : 'Belum ada riwayat transaksi' }}
                                                </p>
                                                <p class="text-gray-300 text-[12px] -mt-2">
                                                    {{ request()->keyword || request()->dari || request()->sampai ? 'Coba gunakan filter yang berbeda' : 'Transaksi yang sudah selesai akan muncul di sini' }}
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

    <script>
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateEl = document.getElementById('currentDate');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
