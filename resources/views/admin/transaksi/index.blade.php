<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaksi - BeautyCare</title>
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
                            {{ $totalTransaksi }} transaksi — Total pendapatan <span class="font-semibold text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
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

                    <form method="GET" action="{{ route('admin.transaksi.index') }}" class="flex flex-wrap items-center justify-end gap-2 mb-4">
                        <div class="relative">
                            <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[12px]"></i>
                            <input type="text" placeholder="Cari invoice atau pelanggan..." name="keyword"
                                class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-[180px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
                                value="{{ request()->keyword }}">
                        </div>
                        <input type="date" name="dari" value="{{ request()->dari }}"
                            class="bg-gray-50 border border-gray-100 text-[12px] rounded-full px-3 py-2 w-[140px] focus:outline-none focus:border-pink-300 transition-all">
                        <span class="text-gray-400 text-[12px]">—</span>
                        <input type="date" name="sampai" value="{{ request()->sampai }}"
                            class="bg-gray-50 border border-gray-100 text-[12px] rounded-full px-3 py-2 w-[140px] focus:outline-none focus:border-pink-300 transition-all">
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
                        <a href="{{ route('admin.transaksi.create') }}"
                            class="flex items-center gap-2 bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:shadow-md transition-all shadow-sm">
                            <i class="fa-solid fa-plus"></i> Transaksi Baru
                        </a>
                        <a href="javascript:void(0)" onclick="exportTransaksi()"
                            class="flex items-center gap-2 border border-pink-100 text-gray-500 text-[12px] font-semibold px-4 py-2 rounded-full hover:border-pink-300">
                            <i class="fa-solid fa-download"></i> Export
                        </a>
                    </form>

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
                                    <th class="py-3 px-4">Admin</th>
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
                                                <a href="{{ route('admin.transaksi.show', $t->id_transaksi) }}"
                                                    class="w-7 h-7 text-blue-500 bg-blue-50 hover:bg-blue-100 rounded-md transition-colors flex items-center justify-center"
                                                    title="Detail"><i class="fa-regular fa-eye text-xs"></i></a>
                                                <a href="{{ route('admin.transaksi.edit', $t->id_transaksi) }}"
                                                    class="w-7 h-7 text-amber-500 bg-amber-50 hover:bg-amber-100 rounded-md transition-colors flex items-center justify-center"
                                                    title="Edit"><i class="fa-regular fa-pen-to-square text-xs"></i></a>
                                                <form action="{{ route('admin.transaksi.destroy', $t->id_transaksi) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus transaksi {{ $t->no_invoice }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-7 h-7 text-red-500 bg-red-50 hover:bg-red-100 rounded-md transition-colors flex items-center justify-center"
                                                        title="Hapus"><i class="fa-regular fa-trash-can text-xs"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="py-14 text-center">
                                            <div class="flex flex-col items-center gap-3">
                                                <div class="w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center">
                                                    <i class="fa-solid fa-receipt text-3xl text-pink-200"></i>
                                                </div>
                                                <p class="text-gray-400 font-medium text-[14px]">
                                                    {{ request()->keyword || request()->dari || request()->sampai ? 'Transaksi tidak ditemukan' : 'Belum ada data transaksi' }}
                                                </p>
                                                <p class="text-gray-300 text-[12px] -mt-2">
                                                    {{ request()->keyword || request()->dari || request()->sampai ? 'Coba gunakan filter yang berbeda' : 'Buat transaksi baru untuk mulai mencatat' }}
                                                </p>
                                                @if (!request()->keyword && !request()->dari && !request()->sampai)
                                                <a href="{{ route('admin.transaksi.create') }}"
                                                    class="text-pink-500 text-[12px] font-semibold hover:underline inline-flex items-center gap-1 mt-1">
                                                    <i class="fa-solid fa-plus-circle"></i> Buat transaksi sekarang
                                                </a>
                                                @endif
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
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>