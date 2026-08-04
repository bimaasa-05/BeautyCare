<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BeautyCare</title>
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


            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-5">

            <div class="page-header-premium">
                <div class="ph-content">
                    <div class="ph-left">
                        <div class="ph-icon-wrap">
                            <span class="nav-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                            </span>
                        </div>
                        <div class="ph-text">
                            <h3>Data Membership</h3>
                            <p>Atur program membership dan keanggotaan pelanggan.</p>
                        </div>
                    </div>
                </div>
            </div>
                <div class="space-y-5">

                    @php
                        $warnaCard = ['from-pink-400 to-rose-500', 'from-gray-400 to-slate-500', 'from-amber-400 to-orange-500', 'from-violet-400 to-purple-500', 'from-emerald-400 to-teal-500', 'from-blue-400 to-cyan-500', 'from-red-400 to-rose-500'];
                        $iconCard = ['users', 'credit-card', 'star', 'award', 'gift', 'crown', 'gem'];
                        $warnaTingkat = ['Silver' => 'from-gray-400 to-slate-500', 'Gold' => 'from-amber-400 to-orange-500', 'Platinum' => 'from-violet-400 to-purple-500'];
                        $warnaTierBadge = ['Silver' => 'bg-gray-50 text-gray-500 border-gray-200', 'Gold' => 'bg-yellow-50 text-yellow-600 border-yellow-200', 'Platinum' => 'bg-violet-50 text-violet-600 border-violet-100'];
                        $iconTingkat = ['Silver' => 'star', 'Gold' => 'crown', 'Platinum' => 'gem'];
                    @endphp
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                        <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">Total Paket</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalMember }}</p>
                            <p class="text-xs text-gray-400 mt-1">total paket terdaftar</p>
                        </div>
                         @foreach ($statPerTingkat as $tingkat => $stat)
                        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                 <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $warnaTingkat[$tingkat] ?? $warnaCard[$loop->index % count($warnaCard)] }} flex items-center justify-center shadow-sm">
                                        <i class="fa-solid fa-{{ $iconTingkat[$tingkat] ?? $iconCard[$loop->index % count($iconCard)] }} text-white text-sm"></i>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">{{ $tingkat }}</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stat['total'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">diskon {{ $stat['diskon'] }}%</p>
                        </div>
                        @endforeach
                        <div class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-check text-white text-sm"></i>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">Aktif</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $memberAktif }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $totalMember > 0 ? round($memberAktif / $totalMember * 100) : 0 }}% paket aktif</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5" id="tierFilters">
                        @forelse ($memberships as $item)
                        <div data-tingkat="{{ $item->tingkat }}" class="tier-card rounded-2xl border border-gray-200 overflow-hidden shadow-[0_4px_24px_rgba(0,0,0,0.06)] hover:shadow-xl transition-all relative cursor-pointer">
                            <div class="bg-gradient-to-br {{ $warnaTingkat[$item->tingkat] ?? $warnaCard[$loop->index % count($warnaCard)] }} p-5 text-white">
                                <h3 class="text-2xl font-extrabold mb-1">{{ $item->nm_member }}</h3>
                                <span class="inline-block text-xs font-semibold bg-white/20 px-2.5 py-0.5 rounded-full">{{ $item->tingkat }}</span>
                            </div>
                            <div class="bg-gray-50 p-5 space-y-3">
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="text-center p-2.5 bg-white rounded-xl">
                                        <p class="text-lg font-extrabold text-gray-800">{{ $item->diskon }}%</p>
                                        <p class="text-[10px] text-gray-400">Diskon</p>
                                    </div>
                                    <div class="text-center p-2.5 bg-white rounded-xl">
                                        <p class="text-lg font-extrabold text-gray-800">{{ number_format($item->masa_berlaku) }} hr</p>
                                        <p class="text-[10px] text-gray-400">Masa Berlaku</p>
                                    </div>
                                </div>
                                @if ($item->deskripsi)
                                <p class="text-xs text-gray-500 leading-relaxed">{{ $item->deskripsi }}</p>
                                @endif
                                <ul class="space-y-1.5">
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#EC4899] mt-0.5 flex-shrink-0"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>Diskon {{ $item->diskon }}% semua layanan</li>
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#EC4899] mt-0.5 flex-shrink-0"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>Min. {{ $item->min_transaksi }}x transaksi</li>
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#EC4899] mt-0.5 flex-shrink-0"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>Min. Rp {{ number_format($item->min_pembelian, 0, ',', '.') }} pembelian</li>
                                    <li class="flex items-start gap-2 text-xs font-semibold text-gray-700"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#EC4899] mt-0.5 flex-shrink-0"><path d="M12 1v22"></path><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>Harga Upgrade: Rp {{ number_format($item->harga, 0, ',', '.') }}</li>
                                </ul>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-8 text-gray-400 text-[13px]">
                            <i class="fa-solid fa-folder-open text-2xl block mb-2 text-gray-300"></i>
                            Belum ada paket membership
                        </div>
                        @endforelse
                    </div>

                    <!-- MEMBER TABLE WRAPPER -->
                    <div class="bg-white rounded-2xl p-5 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)]">
                        @if (session('success'))
                            <div
                                class="mb-4 flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 text-[13px] px-4 py-3 rounded-xl">
                                <i class="fa-solid fa-check-circle text-emerald-500"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
                            <div>
                                <h3 class="text-[16px] font-bold text-gray-800">Paket Membership</h3>
                                <p class="text-[12px] text-gray-400 mt-0.5">Total <span
                                        id="totalCount">{{ $memberships->count() }}</span> paket</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                                    <input id="searchMember"
                                        class="pl-8 pr-3 py-2 bg-[#FFF7FA] border border-pink-100 rounded-xl text-xs focus:outline-none focus:border-pink-300 w-full sm:w-[200px] lg:w-44"
                                        placeholder="Cari paket...">
                                </div>
                                <a href="{{ route('admin.membership.create') }}"
                                    class="flex items-center gap-2 bg-[#de3b7c] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                                    <i class="fa-solid fa-plus"></i> Tambah Paket
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mb-4 flex-wrap" id="filterButtons">
                            <button data-filter="all"
                                class="filter-btn text-[11px] font-semibold px-3.5 py-1.5 rounded-full border transition-colors bg-[#de3b7c] text-white border-[#de3b7c]">
                                Semua
                            </button>
                            @foreach ($statPerTingkat as $tingkat => $stat)
                            <button data-filter="{{ $tingkat }}"
                                class="filter-btn text-[11px] font-semibold px-3.5 py-1.5 rounded-full border transition-colors bg-gray-50 text-gray-500 border-gray-200 hover:bg-gray-100">
                                {{ $tingkat }}
                            </button>
                            @endforeach
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse admin-table">
                                <thead>
                                    <tr
                                        class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-gray-50/50">
                                        <th class="py-3 px-3 w-10">#</th>
                                        <th class="py-3 px-3">Nama Paket</th>
                                        <th class="py-3 px-3">Tingkat</th>
                                        <th class="py-3 px-3">Diskon</th>
                                        <th class="py-3 px-3">Masa Berlaku</th>
                                        <th class="py-3 px-3">Status</th>
                                        <th class="py-3 px-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="memberTableBody" class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                    @forelse ($memberships as $item)
                                        <tr class="hover:bg-gray-50/50 transition-colors"
                                            data-tingkat="{{ $item->tingkat }}">
                                            <td class="py-3 px-3 text-gray-400">{{ $loop->iteration }}</td>
                                             <td class="py-3 px-3 font-medium" data-label="Nama Paket">{{ $item->nm_member }}</td>
                                            <td class="py-3 px-3" data-label="Tingkat">
                                                @php
                                                    $warnaTier = ['bg-gray-50 text-gray-500 border-gray-200', 'bg-yellow-50 text-yellow-600 border-yellow-200', 'bg-violet-50 text-violet-600 border-violet-100', 'bg-blue-50 text-blue-600 border-blue-200', 'bg-green-50 text-green-600 border-green-200', 'bg-red-50 text-red-600 border-red-200'];
                                                    $tierBadge = $warnaTierBadge[$item->tingkat] ?? $warnaTier[$loop->index % count($warnaTier)];
                                                    $tc = explode(' ', $tierBadge);
                                                @endphp
                                                <span
                                                    class="inline-flex items-center text-[11px] font-semibold px-2.5 py-1 rounded-full border {{ $tc[0] }} {{ $tc[1] }} {{ $tc[2] }}">
                                                    {{ $item->tingkat }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-3" data-label="Diskon">{{ $item->diskon }}%</td>
                                            <td class="py-3 px-3" data-label="Masa Berlaku">{{ number_format($item->masa_berlaku) }} hari</td>
                                             <td class="py-3 px-3" data-label="Status">
                                                @php
                                                    $statusOtomatis = $item->masa_berlaku > 0 && $item->status === 'aktif'
                                                        ? 'aktif'
                                                        : ($item->status === 'suspend' ? 'suspend' : 'non_aktif');
                                                @endphp
                                                @if ($statusOtomatis === 'aktif')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold border border-green-200 bg-green-50 text-green-600">
                                                        Aktif
                                                    </span>
                                                @elseif ($statusOtomatis === 'suspend')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold border border-yellow-200 bg-yellow-50 text-yellow-600">
                                                        Suspend
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold border border-red-200 bg-red-50 text-red-500">
                                                        Non Aktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-3" data-label="Aksi">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('admin.membership.edit', $item->id_member) }}"
                                                        class="w-7 h-7 inline-flex items-center justify-center text-amber-500 bg-amber-50 hover:bg-amber-100 rounded-md transition-colors"><i
                                                            class="fa-solid fa-pen-to-square text-xs"></i>
                                                    </a>
                                                    <form action="{{ route('admin.membership.destroy', $item->id_member) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus paket membership ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="w-7 h-7 text-red-500 bg-red-50 hover:bg-red-100 rounded-md transition-colors"><i
                                                                class="fa-regular fa-trash-can text-xs"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-8 text-center text-gray-400 text-[13px]">
                                                <i class="fa-solid fa-folder-open text-2xl block mb-2 text-gray-300"></i>
                                                Belum ada paket membership
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </main>

        <script src="{{ asset('assets/js/dashboard.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tierCards = document.querySelectorAll('.tier-card');
                const filterBtns = document.querySelectorAll('.filter-btn');
                const rows = document.querySelectorAll('#memberTableBody tr');
                const totalSpan = document.getElementById('totalCount');

                function filterTable(tingkat) {
                    let visible = 0;

                    const warnaRing = ['ring-gray-400', 'ring-amber-400', 'ring-violet-400', 'ring-blue-400', 'ring-green-400', 'ring-red-400'];
                    const semuaRing = ['ring-2', ...warnaRing, 'ring-offset-2'];

                    tierCards.forEach((card, i) => {
                        card.classList.remove(...semuaRing);
                        if (card.dataset.tingkat === tingkat) {
                            card.classList.add('ring-2', warnaRing[i % warnaRing.length], 'ring-offset-2');
                        }
                    });

                    filterBtns.forEach(btn => {
                        const isActive = btn.dataset.filter === tingkat;
                        btn.classList.remove('bg-[#de3b7c]', 'text-white', 'border-[#de3b7c]',
                            'bg-gray-50', 'text-gray-500', 'border-gray-200', 'hover:bg-gray-100',
                            'bg-yellow-50', 'text-yellow-600', 'border-yellow-200', 'hover:bg-yellow-100',
                            'bg-violet-50', 'text-violet-600', 'border-violet-200', 'hover:bg-violet-100',
                            'bg-blue-50', 'text-blue-600', 'border-blue-200', 'hover:bg-blue-100');
                        if (isActive) {
                            btn.classList.add('bg-[#de3b7c]', 'text-white', 'border-[#de3b7c]');
                        } else if (btn.dataset.filter === 'all') {
                            btn.classList.add('bg-gray-50', 'text-gray-500', 'border-gray-200', 'hover:bg-gray-100');
                        } else {
                            btn.classList.add('bg-gray-50', 'text-gray-500', 'border-gray-200', 'hover:bg-gray-100');
                        }
                    });

                    rows.forEach(row => {
                        if (tingkat === 'all' || row.dataset.tingkat === tingkat) {
                            row.style.display = '';
                            visible++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    totalSpan.textContent = visible;
                }

                tierCards.forEach(card => {
                    if (card.tagName === 'DIV') {
                        card.addEventListener('click', function () {
                            filterTable(this.dataset.tingkat);
                        });
                    }
                });

                filterBtns.forEach(btn => {
                    btn.addEventListener('click', function () {
                        filterTable(this.dataset.filter);
                    });
                });

                document.getElementById('searchMember').addEventListener('input', function() {
                    const q = this.value.toLowerCase();
                    let visible = 0;
                    rows.forEach(function(row) {
                        const nm = row.querySelector('td:nth-child(2)')?.textContent?.toLowerCase() || '';
                        if (nm.includes(q)) {
                            row.style.display = '';
                            visible++;
                        } else {
                            row.style.display = 'none';
                        }
                    });
                    totalSpan.textContent = visible;
                });
            });

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
        </script>
</body>

</html>
