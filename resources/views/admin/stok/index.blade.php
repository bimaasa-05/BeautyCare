<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mutasi Stok - BeautyCare</title>
    @include('partials.head-meta')
    <script src="https://cdn.tailwindcss.com"></script>
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
    </style>

    <style>
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
            .admin-table thead { display: none; }
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
            .admin-table tbody td:first-child { padding-left: 0; }
            .admin-table tbody td:last-child { padding-right: 0; }
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
    </style>
</head>

<body>
    <!-- Page Loader -->
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <main class="flex-1 overflow-y-auto p-4 sm:p-5 lg:p-6">
                <div class="space-y-4">

                    <div class="page-header-premium">
                        <div class="ph-content">
                            <div class="ph-left">
                                <div class="ph-icon-wrap">
                                    <span class="nav-icon">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M12 3v12" />
                                            <path d="m7 10 5 5 5-5" />
                                            <path d="M5 21h14" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="ph-text">
                                    <h3>Mutasi Stok</h3>
                                    <p>Kelola seluruh pergerakan stok: catat barang masuk dari supplier, refund barang
                                        rusak / tidak sesuai, dan pantau riwayat penjualan. Ini satu-satunya tempat
                                        perubahan stok dilakukan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (session('success'))
                        <div
                            class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-medium px-4 py-3 rounded-xl flex items-center gap-2">
                            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div
                            class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="text-white">
                                        <path d="M12 3v12"></path>
                                        <path d="m7 10 5 5 5-5"></path>
                                        <path d="M5 21h14"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">Total Barang Masuk</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalMasuk }}</p>
                        </div>

                        <div
                            class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="w-11 h-11 rounded-xl bg-gradient-to-br from-red-400 to-rose-500 flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="text-white">
                                        <path d="M12 21V9"></path>
                                        <path d="m17 14-5 5-5-5"></path>
                                        <path d="M5 3h14"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">Total Barang Keluar</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalKeluar }}</p>
                        </div>

                        <div
                            class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="text-white">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">Total Mutasi Tercatat</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalMutasi }}</p>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-2xl border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)] overflow-hidden">
                        <div class="p-5 border-b border-pink-50 flex items-center justify-between flex-wrap gap-3">
                            <h3 class="font-bold text-gray-800">
                                @php
                                    $tabType = request('type');
                                    $judulTabel = match ($tabType) {
                                        'Masuk' => 'Daftar Barang Masuk',
                                        'Keluar' => 'Daftar Barang Keluar',
                                        'Refund' => 'Daftar Refund Stok',
                                        default => 'Daftar Mutasi Stok',
                                    };
                                @endphp
                                {{ $judulTabel }}
                            </h3>
                            <div class="flex items-center gap-2 flex-wrap">
                                <form method="GET" action="{{ route('admin.stok.index') }}"
                                    class="flex items-center gap-2 flex-wrap">
                                    <input type="hidden" name="type" value="{{ $tabType }}">
                                    <input type="date" name="dari" value="{{ request('dari') }}"
                                        class="bg-[#FFF7FA] border border-pink-100 rounded-xl text-xs px-3 py-2 focus:outline-none focus:border-pink-300">
                                    <input type="date" name="sampai" value="{{ request('sampai') }}"
                                        class="bg-[#FFF7FA] border border-pink-100 rounded-xl text-xs px-3 py-2 focus:outline-none focus:border-pink-300">
                                    <button type="submit"
                                        class="px-3 py-2 bg-gray-100 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-200">
                                        Filter
                                    </button>
                                </form>
                                <a href="{{ route('admin.stok.create') }}"
                                    class="flex items-center gap-1.5 px-3 py-2 bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white rounded-xl text-xs font-bold shadow-sm hover:opacity-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5v14"></path>
                                    </svg> Catat Barang Masuk
                                </a>
                                <a href="{{ route('admin.stok.refund-create') }}"
                                    class="flex items-center gap-1.5 px-3 py-2 bg-gradient-to-r from-violet-500 to-purple-700 text-white rounded-xl text-xs font-bold shadow-sm hover:opacity-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                                        <path d="M3 3v5h5"></path>
                                    </svg> Catat Refund
                                </a>
                            </div>
                        </div>
                        <div class="px-5 pt-4 text-[11px] text-gray-400">
                            <i class="fa-solid fa-circle-info text-[#EC4899] mr-1"></i>
                            Stok produk adalah stok keseluruhan toko saat ini, bukan stok per supplier. Setiap catatan barang masuk otomatis menambah stok produk.
                        </div>
                        <div class="flex items-center gap-2 px-5 pt-4 flex-wrap">
                            <a href="{{ route('admin.stok.index', request()->only(['dari', 'sampai'])) }}"
                                class="px-4 py-2 rounded-xl text-xs font-bold transition-colors {{ !$tabType ? 'bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white shadow-sm' : 'bg-[#FFF7FA] text-gray-500 hover:bg-pink-50' }}">
                                Semua <span class="ml-1 opacity-70">({{ $totalMutasi }})</span>
                            </a>
                            <a href="{{ route('admin.stok.index', array_merge(request()->only(['dari', 'sampai']), ['type' => 'Masuk'])) }}"
                                class="px-4 py-2 rounded-xl text-xs font-bold transition-colors {{ $tabType === 'Masuk' ? 'bg-emerald-500 text-white shadow-sm' : 'bg-[#FFF7FA] text-gray-500 hover:bg-pink-50' }}">
                                <i class="fa-solid fa-arrow-down mr-1"></i>Barang Masuk
                                <span class="ml-1 opacity-70">({{ $countMasuk }})</span>
                            </a>
                            <a href="{{ route('admin.stok.index', array_merge(request()->only(['dari', 'sampai']), ['type' => 'Keluar'])) }}"
                                class="px-4 py-2 rounded-xl text-xs font-bold transition-colors {{ $tabType === 'Keluar' ? 'bg-rose-500 text-white shadow-sm' : 'bg-[#FFF7FA] text-gray-500 hover:bg-pink-50' }}">
                                <i class="fa-solid fa-arrow-up mr-1"></i>Barang Keluar
                                <span class="ml-1 opacity-70">({{ $countKeluar }})</span>
                            </a>
                            <a href="{{ route('admin.stok.index', array_merge(request()->only(['dari', 'sampai']), ['type' => 'Refund'])) }}"
                                class="px-4 py-2 rounded-xl text-xs font-bold transition-colors {{ $tabType === 'Refund' ? 'bg-violet-500 text-white shadow-sm' : 'bg-[#FFF7FA] text-gray-500 hover:bg-pink-50' }}">
                                <i class="fa-solid fa-rotate-left mr-1"></i>Refund
                                <span class="ml-1 opacity-70">({{ $countRefund }})</span>
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full admin-table">
                                <thead>
                                    <tr class="bg-[#FFF7FA]">
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">#</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Tanggal
                                        </th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Produk
                                        </th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">
                                            Supplier</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Tipe
                                        </th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Jumlah
                                        </th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Stok
                                            Sebelum</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">Stok
                                            Sesudah</th>
                                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase">
                                            Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($stok as $s)
                                        @php
                                            $badge = match ($s->type) {
                                                'Masuk' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                'Keluar' => 'bg-red-50 text-red-500 border-red-100',
                                                'Refund' => 'bg-violet-50 text-violet-600 border-violet-100',
                                                default => 'bg-gray-50 text-gray-500 border-gray-100',
                                            };
                                        @endphp
                                        <tr class="border-t border-pink-50 hover:bg-pink-50/30 transition-colors">
                                            <td class="px-5 py-4 text-sm text-gray-600" data-label="#">#{{ $loop->iteration }}</td>
                                            <td class="px-5 py-4 text-sm text-gray-600" data-label="Tanggal">
                                                {{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}</td>
                                            <td class="px-5 py-4" data-label="Produk">
                                                <p class="text-sm font-semibold text-gray-800">
                                                    {{ $s->produk->nm_produk ?? '-' }}</p>
                                            </td>
                                            <td class="px-5 py-4 text-sm text-gray-600" data-label="Supplier">
                                                {{ $s->supplier->nm_supplier ?? '-' }}</td>
                                            <td class="px-5 py-4" data-label="Tipe">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $badge }}">
                                                    {{ $s->type }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-4 text-sm font-semibold text-gray-800" data-label="Jumlah">
                                                {{ $s->jumlah }}</td>
                                            <td class="px-5 py-4 text-sm text-gray-600" data-label="Stok Sebelum">
                                                {{ $s->stok_sebelum }}</td>
                                            <td class="px-5 py-4 text-sm text-gray-600" data-label="Stok Sesudah">
                                                {{ $s->stok_sesudah }}</td>
                                            <td class="px-5 py-4 text-sm text-gray-600 sm:max-w-[200px] sm:truncate"
                                                data-label="Keterangan">{{ $s->keterangan }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="px-5 py-10 text-center text-gray-400 text-sm">
                                                <i class="fa-regular fa-face-frown text-4xl block mb-3"></i>
                                                Belum ada data {{ strtolower($judulTabel) }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>

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
            </script>
            <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
