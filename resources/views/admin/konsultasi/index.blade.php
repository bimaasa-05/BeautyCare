<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konsultasi - BeautyCare</title>
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

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    body { font-family: 'Inter', sans-serif; }
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    .badge-status { display: inline-flex; align-items: center; gap: 4px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 600; }
    .badge-menunggu { background: #FEF3C7; color: #D97706; }
    .badge-dikonfirmasi { background: #DBEAFE; color: #2563EB; }
    .badge-selesai { background: #E8F8EE; color: #22C55E; }
    .badge-ditolak { background: #FDE8E8; color: #EF4444; }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="mb-6">
                        <h3 class="text-[16px] font-bold text-gray-800">
                            <i class="fa-solid fa-comments text-pink-500 mr-2"></i>Data Konsultasi
                        </h3>
                        <p class="text-[12px] text-gray-400 mt-0.5">
                            <i class="fa-regular fa-circle-check text-pink-300 mr-1"></i>
                            Total {{ $konsultasi->count() }} permintaan konsultasi tercatat
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
                        <div class="stat-card-enhanced card-gradient-amber">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Menunggu</p>
                                    <p class="text-[24px] font-bold text-amber-600 mt-1">{{ $summary['menunggu'] }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                                    <i class="fa-regular fa-clock text-amber-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-blue">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Dikonfirmasi</p>
                                    <p class="text-[24px] font-bold text-blue-600 mt-1">{{ $summary['dikonfirmasi'] }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fa-solid fa-user-check text-blue-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-green">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Selesai</p>
                                    <p class="text-[24px] font-bold text-green-600 mt-1">{{ $summary['selesai'] }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fa-regular fa-circle-check text-green-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-red">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Ditolak</p>
                                    <p class="text-[24px] font-bold text-red-600 mt-1">{{ $summary['ditolak'] }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                    <i class="fa-solid fa-ban text-red-500"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="GET" action="" class="flex flex-wrap items-center justify-end gap-2 mb-4">
                        <div class="relative">
                            <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[12px]"></i>
                            <input type="text" placeholder="Cari konsultasi..." name="keyword"
                                class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-[200px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
                                value="{{ Request()->keyword }}">
                        </div>
                        <select name="status" onchange="this.form.submit()"
                            class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-4 pr-8 py-2 focus:outline-none focus:border-pink-300 transition-all">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ $filterStatus === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="dikonfirmasi" {{ $filterStatus === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="selesai" {{ $filterStatus === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ $filterStatus === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left table-enhanced">
                            <thead>
                                <tr class="text-[11px] uppercase tracking-wider text-gray-400 border-b border-gray-100">
                                    <th class="px-3 py-3 font-semibold">Pelanggan</th>
                                    <th class="px-3 py-3 font-semibold">Jadwal</th>
                                    <th class="px-3 py-3 font-semibold">Topik</th>
                                    <th class="px-3 py-3 font-semibold">Mode</th>
                                    <th class="px-3 py-3 font-semibold">Terapis</th>
                                    <th class="px-3 py-3 font-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($konsultasi as $item)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center text-[12px] font-bold flex-shrink-0">
                                                {{ substr($item->pelanggan->nm_pelanggan ?? '?', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-[12px] font-semibold text-gray-700">{{ $item->pelanggan->nm_pelanggan ?? '-' }}</div>
                                                <div class="text-[10px] text-gray-400">{{ $item->pelanggan->no_hp ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="text-[12px] text-gray-600 font-medium">{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM YYYY') }}</div>
                                        <div class="text-[10px] text-gray-400">{{ str_replace(':', '.', substr($item->jam, 0, 5)) }}</div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="text-[12px] font-semibold text-gray-700 max-w-[200px] truncate">{{ $item->topik }}</div>
                                        @if($item->pesan)
                                        <div class="text-[10px] text-gray-400 max-w-[200px] truncate">{{ $item->pesan }}</div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="badge-status {{ $item->mode === 'online' ? 'bg-purple-50 text-purple-600' : 'bg-sky-50 text-sky-600' }}">
                                            <i class="fa-solid {{ $item->mode === 'online' ? 'fa-globe' : 'fa-store' }}"></i>
                                            {{ ucfirst($item->mode) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3">
                                        @if($item->karyawan)
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-user text-gray-300 text-[10px]"></i>
                                            <span class="text-[12px] text-gray-600">{{ $item->karyawan->nama }}</span>
                                        </div>
                                        @else
                                        <span class="text-[11px] text-amber-500 italic">Belum ditugaskan</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="badge-status badge-{{ $item->status }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center">
                                        <div class="w-16 h-16 mx-auto rounded-2xl bg-pink-50 flex items-center justify-center text-[24px] text-pink-300 mb-3">
                                            <i class="fa-regular fa-comments"></i>
                                        </div>
                                        <p class="text-[13px] font-semibold text-gray-500">Belum ada permintaan konsultasi</p>
                                        <p class="text-[11px] text-gray-400 mt-1">Data konsultasi member akan muncul di sini</p>
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
</body>

</html>
