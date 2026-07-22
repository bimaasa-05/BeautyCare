<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran - BeautyCare</title>
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
        .badge-selesai { background: #E8F8EE; color: #22C55E; }

        .stat-card-enhanced { padding: 20px; border-radius: 16px; border: 1px solid rgba(0,0,0,0.04); }
        .card-gradient-pink { background: linear-gradient(135deg, #FFF5F8, #FFFFFF); border-color: #FFE0E8; }
        .card-gradient-green { background: linear-gradient(135deg, #F0FDF4, #FFFFFF); border-color: #DCFCE7; }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="float-decoration" style="top:-10px;right:-10px;">💳</div>

                    @if (session('message'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 text-[13px] rounded-xl flex items-center gap-2">
                            <i class="fa-regular fa-circle-check"></i> {{ session('message') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 text-[13px] rounded-xl flex items-center gap-2">
                            <i class="fa-regular fa-circle-xmark"></i> {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-[16px] font-bold text-gray-800">
                            <i class="fa-solid fa-credit-card text-pink-500 mr-2"></i>Pembayaran
                        </h3>
                        <p class="text-[12px] text-gray-400 mt-0.5">Proses pembayaran reservasi yang sudah selesai</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                        <div class="stat-card-enhanced card-gradient-pink">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Tagihan Baru</p>
                                    <p class="text-[24px] font-bold text-gray-800 mt-1">{{ $totalTagihan }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center">
                                    <i class="fa-regular fa-clock text-pink-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-green">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Sudah Dibayar</p>
                                    <p class="text-[24px] font-bold text-green-600 mt-1">{{ $totalSudahDibayar }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fa-regular fa-circle-check text-green-500"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="" method="GET" class="flex justify-end mb-4">
                        <div class="relative">
                            <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[12px]"></i>
                            <input type="text" placeholder="Cari pelanggan..." name="keyword"
                                class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-[220px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
                                value="{{ request()->keyword }}">
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-gray-50/50">
                                    <th class="py-3 px-4">#</th>
                                    <th class="py-3 px-4">Pelanggan</th>
                                    <th class="py-3 px-4">Tanggal</th>
                                    <th class="py-3 px-4">Jam</th>
                                    <th class="py-3 px-4 text-right">Total Layanan</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                @forelse ($reservasiSelesai as $r)
                                    <tr class="hover:bg-gray-100 transition-colors duration-150">
                                        <td class="py-3 px-4 text-gray-400 font-medium">{{ $loop->iteration }}</td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-full bg-green-200 text-green-600 flex items-center justify-center font-bold text-[11px]">
                                                    {{ $r->pelanggan ? strtoupper(substr($r->pelanggan->nm_pelanggan, 0, 2)) : '??' }}
                                                </div>
                                                <div>
                                                    <span class="font-semibold text-gray-700 block leading-tight">{{ $r->pelanggan->nm_pelanggan ?? '-' }}</span>
                                                    <span class="text-[11px] text-gray-400">{{ $r->pelanggan->no_hp ?? '' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 text-gray-500">{{ \Carbon\Carbon::parse($r->tanggal)->format('d/m/Y') }}</td>
                                        <td class="py-3 px-4 text-gray-500 font-mono">{{ $r->jam }}</td>
                                        <td class="py-3 px-4 text-right font-semibold text-gray-700">
                                            Rp {{ number_format($r->detail->sum(fn($d) => ($d->harga ?? 0) - ($d->diskon ?? 0)), 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="badge-status badge-selesai">
                                                <i class="fa-regular fa-circle-check"></i> Selesai
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <a href="{{ route('kasir.pembayaran.create', $r->id_booking) }}"
                                                class="inline-flex items-center gap-2 bg-[#FF4F87] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm hover:shadow-md hover:shadow-pink-200">
                                                <i class="fa-regular fa-credit-card"></i> Bayar
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-10 text-center">
                                            <div class="flex flex-col items-center gap-2">
                                                <i class="fa-solid fa-credit-card text-4xl text-gray-300"></i>
                                                <p class="text-gray-400 font-medium text-[14px]">Tidak ada tagihan baru</p>
                                                <p class="text-gray-400 text-[12px]">Semua reservasi selesai sudah dibayar</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
