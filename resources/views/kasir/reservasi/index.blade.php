<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reservasi - BeautyCare</title>
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
        .table-row-hover:hover { background: #FFF5F8 !important; transform: scale(1.002); }

        .pagination-custom nav svg { display: none; }
        .pagination-custom nav .flex a, .pagination-custom nav .flex span {
            font-size: 12px; padding: 6px 14px; border-radius: 100px !important; margin: 0 2px;
        }
        .pagination-custom nav .flex span:first-child, .pagination-custom nav .flex a:first-child { border-radius: 100px !important; }
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
                            <i class="fa-solid fa-calendar-check text-pink-500 mr-2"></i>Data Reservasi
                        </h3>
                        <p class="text-[12px] text-gray-400 mt-0.5">
                            <i class="fa-regular fa-circle-check text-pink-300 mr-1"></i>
                            Total {{ $TotalReservasi }} reservasi tercatat
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
                        <div class="stat-card-enhanced card-gradient-pink">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total</p>
                                    <p class="text-[24px] font-bold text-gray-800 mt-1">{{ $TotalReservasi }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center">
                                    <i class="fa-regular fa-calendar-check text-pink-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-amber">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Menunggu</p>
                                    <p class="text-[24px] font-bold text-amber-600 mt-1">{{ $totalMenunggu }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                                    <i class="fa-regular fa-clock text-amber-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-purple">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Diproses</p>
                                    <p class="text-[24px] font-bold text-purple-600 mt-1">{{ $totalDiproses }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                                    <i class="fa-solid fa-spinner text-purple-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-enhanced card-gradient-green">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Selesai</p>
                                    <p class="text-[24px] font-bold text-green-600 mt-1">{{ $totalSelesai }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fa-regular fa-circle-check text-green-500"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="GET" action="" class="flex flex-wrap items-center justify-end gap-2 mb-4">
                        <div class="relative">
                            <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[12px]"></i>
                            <input type="text" placeholder="Cari reservasi..." name="keyword"
                                class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-[200px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
                                value="{{ Request()->keyword }}">
                        </div>
                        <a href="{{ route('kasir.reservasi.create') }}"
                            class="flex items-center gap-2 bg-[#FF4F87] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm hover:shadow-md hover:shadow-pink-200">
                            <i class="fa-solid fa-plus"></i> Reservasi Baru
                        </a>
                    </form>

                    <div class="overflow-x-auto table-container">
                        <table class="w-full text-left border-collapse table-enhanced">
                            <thead>
                                <tr>
                                    <th class="w-10 text-center">#</th>
                                    <th>Pelanggan</th>
                                    <th>Karyawan</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-[13px] text-gray-700">
                                @forelse($reservasi as $r)
                                    <tr>
                                        <td class="text-center text-gray-400 font-medium">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-full bg-pink-200 text-pink-600 flex items-center justify-center font-bold text-[11px]">
                                                    {{ $r->pelanggan ? strtoupper(substr($r->pelanggan->nm_pelanggan, 0, 2)) : '??' }}
                                                </div>
                                                <div>
                                                    <span class="font-semibold text-gray-700 block leading-tight">{{ $r->pelanggan->nm_pelanggan ?? '-' }}</span>
                                                    <span class="text-[11px] text-gray-400">{{ $r->pelanggan->no_hp ?? '' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-gray-500">{{ $r->karyawan->nama ?? '-' }}</td>
                                        <td class="text-gray-500">{{ \Carbon\Carbon::parse($r->tanggal)->format('d/m/Y') }}</td>
                                        <td class="text-gray-500 font-mono">{{ $r->jam }}</td>
                                        <td>
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
                                                    'diproses' => 'fa-solid fa-spinner',
                                                    'selesai' => 'fa-regular fa-circle-check',
                                                    'dibatalkan' => 'fa-regular fa-circle-xmark',
                                                    default => 'fa-regular fa-clock',
                                                };
                                            @endphp
                                            <span class="badge-status {{ $statusClass }}">
                                                <i class="{{ $statusIcon }}"></i> {{ ucfirst($r->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <a href="{{ route('kasir.reservasi.show', $r->id_booking) }}"
                                                    class="action-btn action-btn-view" title="Detail">
                                                    <i class="fa-regular fa-eye"></i>
                                                </a>
                                                <a href="{{ route('kasir.reservasi.edit', $r->id_booking) }}"
                                                    class="action-btn action-btn-edit" title="Edit">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('kasir.reservasi.destroy', $r->id_booking) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus reservasi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="action-btn action-btn-delete" title="Hapus">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state">
                                                <div class="empty-icon">
                                                    <i class="fa-solid fa-calendar-check"></i>
                                                </div>
                                                <h4>Belum ada data reservasi</h4>
                                                <p>Buat reservasi baru untuk pelanggan</p>
                                                <a href="{{ route('kasir.reservasi.create') }}"
                                                    class="text-[#FF4F87] text-[12px] font-semibold hover:underline inline-flex items-center gap-1 mt-3">
                                                    <i class="fa-solid fa-plus-circle"></i> Buat reservasi sekarang
                                                </a>
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
        document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
