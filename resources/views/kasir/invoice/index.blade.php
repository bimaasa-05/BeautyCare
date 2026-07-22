<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Invoice - BeautyCare</title>
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

        .badge-status { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .badge-lunas { background: #E8F8EE; color: #22C55E; }
        .badge-pending { background: #FEF3C7; color: #F59E0B; }

        .stat-card-enhanced { padding: 20px; border-radius: 16px; border: 1px solid rgba(0,0,0,0.04); }
        .card-gradient-pink { background: linear-gradient(135deg, #FFF5F8, #FFFFFF); border-color: #FFE0E8; }
        .card-gradient-green { background: linear-gradient(135deg, #F0FDF4, #FFFFFF); border-color: #DCFCE7; }
        .card-gradient-yellow { background: linear-gradient(135deg, #FFFBEB, #FFFFFF); border-color: #FDE68A; }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">

                    @if (session('message'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 text-[13px] rounded-xl flex items-center gap-2">
                            <i class="fa-regular fa-circle-check"></i> {{ session('message') }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-[16px] font-bold text-gray-800">
                            <i class="fa-solid fa-file-invoice text-pink-500 mr-2"></i>Invoice
                        </h3>
                        <p class="text-[12px] text-gray-400 mt-0.5">Daftar invoice transaksi</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                        <div class="stat-card-enhanced card-gradient-pink">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Invoice</p>
                                    <p class="text-[24px] font-bold text-gray-800 mt-1">{{ $totalInvoice }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center">
                                    <i class="fa-solid fa-file-invoice text-pink-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-green">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Lunas</p>
                                    <p class="text-[24px] font-bold text-green-600 mt-1">{{ $totalLunas }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fa-regular fa-circle-check text-green-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-yellow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Pending</p>
                                    <p class="text-[24px] font-bold text-amber-600 mt-1">{{ $totalPending }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                                    <i class="fa-regular fa-clock text-amber-500"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('kasir.invoice.index') }}" class="flex flex-wrap items-center justify-end gap-2 mb-4">
                        <div class="relative">
                            <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[12px]"></i>
                            <input type="text" name="keyword" placeholder="Cari no. invoice atau pelanggan..." value="{{ request('keyword') }}"
                                class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-[180px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400">
                        </div>
                        <input type="date" name="dari" value="{{ request('dari') }}"
                            class="bg-gray-50 border border-gray-100 text-[12px] rounded-full px-3 py-2 w-[140px] focus:outline-none focus:border-pink-300 transition-all">
                        <span class="text-gray-400 text-[12px]">—</span>
                        <input type="date" name="sampai" value="{{ request('sampai') }}"
                            class="bg-gray-50 border border-gray-100 text-[12px] rounded-full px-3 py-2 w-[140px] focus:outline-none focus:border-pink-300 transition-all">
                        <button type="submit"
                            class="bg-pink-50 text-pink-600 text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-pink-100 transition-colors border border-pink-200">
                            <i class="fa-solid fa-filter mr-1"></i> Filter
                        </button>
                        <a href="{{ route('kasir.invoice.index') }}"
                            class="text-gray-400 hover:text-gray-600 text-[12px] px-2">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-gray-50/50">
                                    <th class="py-3 px-4">#</th>
                                    <th class="py-3 px-4">No. Invoice</th>
                                    <th class="py-3 px-4">Pelanggan</th>
                                    <th class="py-3 px-4">Tanggal</th>
                                    <th class="py-3 px-4 text-right">Total</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                @forelse ($invoices as $i)
                                    <tr class="hover:bg-gray-100 transition-colors duration-150">
                                        <td class="py-3 px-4 text-gray-400 font-medium">{{ $loop->iteration }}</td>
                                        <td class="py-3 px-4 font-semibold text-gray-700">{{ $i->no_invoice }}</td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-full bg-pink-200 text-pink-600 flex items-center justify-center font-bold text-[11px]">
                                                    {{ $i->pelanggan ? strtoupper(substr($i->pelanggan->nm_pelanggan, 0, 2)) : '??' }}
                                                </div>
                                                <span class="font-medium text-gray-700">{{ $i->pelanggan->nm_pelanggan ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 text-gray-500">{{ \Carbon\Carbon::parse($i->tanggal)->format('d/m/Y') }}</td>
                                        <td class="py-3 px-4 text-right font-semibold text-gray-700">Rp {{ number_format($i->total, 0, ',', '.') }}</td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="badge-status {{ $i->status == 'Lunas' ? 'badge-lunas' : 'badge-pending' }}">
                                                @if ($i->status == 'Lunas')
                                                    <i class="fa-regular fa-circle-check"></i>
                                                @else
                                                    <i class="fa-regular fa-clock"></i>
                                                @endif
                                                {{ $i->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <a href="{{ route('kasir.invoice.show', $i->id_transaksi) }}"
                                                class="inline-flex items-center gap-1.5 bg-pink-500 text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-pink-600 transition-all shadow-sm hover:shadow-md hover:shadow-pink-200">
                                                <i class="fa-solid fa-print"></i> Cetak
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-10 text-center">
                                            <div class="flex flex-col items-center gap-2">
                                                <i class="fa-solid fa-file-invoice text-4xl text-gray-300"></i>
                                                <p class="text-gray-400 font-medium text-[14px]">Belum ada data invoice</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($invoices->hasPages())
                        <div class="mt-4">
                            {{ $invoices->appends(request()->query())->links('vendor.pagination.tailwind') }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
