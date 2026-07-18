<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Check In Pelanggan - BeautyCare</title>
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
        .badge-menunggu { background: #FEF3C7; color: #D97706; }
        .badge-dikonfirmasi { background: #DBEAFE; color: #2563EB; }
        .badge-diproses { background: #E0E7FF; color: #4F46E5; }
        .badge-selesai { background: #E8F8EE; color: #22C55E; }
        .badge-dibatalkan { background: #FDE8E8; color: #EF4444; }

        .table-row-hover { transition: all 0.3s ease; }
        .table-row-hover:hover { background: #FFF5F8 !important; }

        .pagination-custom nav svg { display: none; }
        .pagination-custom nav .flex a, .pagination-custom nav .flex span {
            font-size: 12px; padding: 6px 14px; border-radius: 100px !important; margin: 0 2px;
        }
        .pagination-custom nav .flex span:first-child, .pagination-custom nav .flex a:first-child { border-radius: 100px !important; }

        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px -6px rgba(0,0,0,0.08); }

        @keyframes pulse-dot { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
        .pulse-dot { animation: pulse-dot 2s ease-in-out infinite; }
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
                    <div class="float-decoration" style="top:-10px;right:-10px;">🚪</div>
                    <div class="float-decoration" style="bottom:-10px;left:-10px;font-size:40px;">✅</div>

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-solid fa-door-open text-pink-500 mr-2"></i>Check In Pelanggan
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-regular fa-calendar text-pink-300 mr-1"></i>
                                <span id="currentDate"></span> — <span class="text-pink-400 font-medium">{{ $TotalHariIni }} reservasi</span>
                            </p>
                        </div>
                        <div class="relative">
                            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <form action="" method="GET">
                                <input type="text" placeholder="Cari nama, no. HP, atau ID booking..."
                                    name="keyword"
                                    class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-[260px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
                                    value="{{ request()->keyword }}">
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="stat-card bg-gradient-to-br from-pink-50 to-white rounded-xl p-4 border border-pink-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Hari Ini</p>
                                    <p class="text-[26px] font-bold text-gray-800 mt-1">{{ $TotalHariIni }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-full bg-pink-100 flex items-center justify-center">
                                    <i class="fa-regular fa-calendar text-pink-500 text-lg"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card bg-gradient-to-br from-emerald-50 to-white rounded-xl p-4 border border-emerald-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Sudah Check In</p>
                                    <p class="text-[26px] font-bold text-emerald-600 mt-1">{{ $TotalCheckIn }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-full bg-emerald-100 flex items-center justify-center">
                                    <i class="fa-solid fa-check-to-slot text-emerald-500 text-lg"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card bg-gradient-to-br from-amber-50 to-white rounded-xl p-4 border border-amber-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Menunggu</p>
                                    <p class="text-[26px] font-bold text-amber-600 mt-1">{{ $TotalMenunggu }}</p>
                                </div>
                                <div class="w-11 h-11 rounded-full bg-amber-100 flex items-center justify-center">
                                    <i class="fa-regular fa-clock text-amber-500 text-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-[13px] font-medium flex items-center gap-2">
                            <i class="fa-regular fa-circle-check text-emerald-500"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-pink-50/30">
                                    <th class="py-3 px-4 w-10">#</th>
                                    <th class="py-3 px-4">Pelanggan</th>
                                    <th class="py-3 px-4">Jam</th>
                                    <th class="py-3 px-4">Layanan</th>
                                    <th class="py-3 px-4">Karyawan</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                @forelse($reservasi as $r)
                                    <tr class="table-row-hover {{ $r->status == 'diproses' ? 'bg-emerald-50/30' : '' }}">
                                        <td class="py-3.5 px-4 text-gray-400 font-medium text-center text-[12px]">{{ $loop->iteration }}</td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-full {{ $r->status == 'diproses' ? 'bg-emerald-200 text-emerald-600' : 'bg-pink-200 text-pink-600' }} flex items-center justify-center font-bold text-[11px]">
                                                    {{ $r->pelanggan ? strtoupper(substr($r->pelanggan->nm_pelanggan, 0, 2)) : '??' }}
                                                </div>
                                                <div>
                                                    <span class="font-semibold text-gray-700 block leading-tight">{{ $r->pelanggan->nm_pelanggan ?? '-' }}</span>
                                                    <span class="text-[11px] text-gray-400">{{ $r->pelanggan->no_hp ?? '' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <span class="font-mono text-[13px] font-medium {{ $r->jam <= $jamSekarang && $r->status != 'diproses' && $r->status != 'selesai' ? 'text-red-500' : 'text-gray-700' }}">
                                                <i class="fa-regular fa-clock mr-1 text-pink-300"></i>{{ $r->jam }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex flex-wrap gap-1">
                                                @forelse ($r->detail as $d)
                                                    <span class="inline-block text-[11px] bg-pink-50 text-pink-600 px-2 py-0.5 rounded-full font-medium">{{ $d->layanan->nm_layanan ?? '-' }}</span>
                                                @empty
                                                    <span class="text-gray-400 text-[12px]">-</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-gray-500">{{ $r->karyawan->nama ?? '-' }}</td>
                                        <td class="py-3.5 px-4">
                                            @php
                                                $statusClass = match($r->status) {
                                                    'menunggu' => 'badge-menunggu',
                                                    'dikonfirmasi' => 'badge-dikonfirmasi',
                                                    'diproses' => 'badge-diproses',
                                                    'selesai' => 'badge-selesai',
                                                    'dibatalkan' => 'badge-dibatalkan',
                                                    default => 'badge-menunggu',
                                                };
                                                $statusIcon = match($r->status) {
                                                    'menunggu' => 'fa-regular fa-clock',
                                                    'dikonfirmasi' => 'fa-regular fa-circle-check',
                                                    'diproses' => 'fa-solid fa-check-to-slot',
                                                    'selesai' => 'fa-regular fa-circle-check',
                                                    'dibatalkan' => 'fa-regular fa-circle-xmark',
                                                    default => 'fa-regular fa-clock',
                                                };
                                            @endphp
                                            <span class="badge-status {{ $statusClass }}">
                                                <i class="{{ $statusIcon }}"></i> {{ ucfirst($r->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            @if ($r->status == 'menunggu' || $r->status == 'dikonfirmasi')
                                                <form action="{{ route('kasir.checkin.process', $r->id_booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-emerald-100 transition-all border border-emerald-200"
                                                        title="Check In">
                                                        <i class="fa-solid fa-check-to-slot"></i> Check In
                                                    </button>
                                                </form>
                                            @elseif ($r->status == 'diproses')
                                                <div class="flex items-center justify-center gap-2">
                                                    <span class="text-emerald-600 text-[12px] font-medium flex items-center gap-1">
                                                        <i class="fa-solid fa-circle text-[6px] pulse-dot"></i> Sedang diproses
                                                    </span>
                                                    <form action="{{ route('kasir.checkin.undo', $r->id_booking) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="text-amber-500 bg-amber-50 hover:bg-amber-100 w-7 h-7 rounded-md transition-colors flex items-center justify-center"
                                                            title="Batalkan check in"
                                                            onclick="return confirm('Batalkan check in untuk {{ $r->pelanggan->nm_pelanggan ?? 'pelanggan ini' }}?')">
                                                            <i class="fa-solid fa-rotate-left text-xs"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif ($r->status == 'selesai')
                                                <span class="text-green-500 text-[12px] font-medium">
                                                    <i class="fa-regular fa-circle-check mr-1"></i>Selesai
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-[12px]">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-14 text-center">
                                            <div class="flex flex-col items-center gap-3">
                                                <div class="w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center">
                                                    <i class="fa-solid fa-door-open text-3xl text-pink-200"></i>
                                                </div>
                                                <p class="text-gray-400 font-medium text-[14px]">
                                                    {{ request()->keyword ? 'Reservasi tidak ditemukan' : 'Tidak ada reservasi hari ini' }}
                                                </p>
                                                <p class="text-gray-300 text-[12px] -mt-2">
                                                    {{ request()->keyword ? 'Coba gunakan kata kunci lain' : 'Belum ada pelanggan yang melakukan reservasi untuk hari ini' }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($reservasi->hasPages())
                        <div class="mt-4 px-4 pagination-custom">
                            {{ $reservasi->links() }}
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
