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
    <div class="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div class="float-decoration" style="top:-10px;right:-10px;">📅</div>
                    <div class="float-decoration" style="bottom:-10px;left:-10px;font-size:40px;">✨</div>

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-solid fa-calendar-check text-pink-500 mr-2"></i>Data Reservasi
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-regular fa-circle-check text-pink-300 mr-1"></i>
                                Total {{ $TotalReservasi }} reservasi tercatat
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                                <form action="" class="input-group">
                                    <input type="text" placeholder="Cari reservasi..." name="keyword"
                                        class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-[200px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
                                        value={{ Request()->keyword }}>
                                </form>
                            </div>
                            <a href="{{ route('kasir.reservasi.create') }}"
                                class="flex items-center gap-2 bg-[#FF4F87] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm hover:shadow-md hover:shadow-pink-200">
                                <i class="fa-solid fa-plus"></i> Reservasi Baru
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-pink-50/30">
                                    <th class="py-3 px-4 w-10">#</th>
                                    <th class="py-3 px-4">Pelanggan</th>
                                    <th class="py-3 px-4">Karyawan</th>
                                    <th class="py-3 px-4">Tanggal</th>
                                    <th class="py-3 px-4">Jam</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                @forelse($reservasi as $r)
                                    <tr class="table-row-hover">
                                        <td class="py-3.5 px-4 text-gray-400 font-medium text-center text-[12px]">{{ $loop->iteration }}</td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-7 h-7 rounded-full bg-pink-200 text-pink-600 flex items-center justify-center font-bold text-[10px]">
                                                    {{ $r->pelanggan ? strtoupper(substr($r->pelanggan->nm_pelanggan, 0, 2)) : '??' }}
                                                </div>
                                                <span class="font-medium text-gray-700">{{ $r->pelanggan->nm_pelanggan ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-gray-500">{{ $r->karyawan->nama ?? '-' }}</td>
                                        <td class="py-3.5 px-4 text-gray-500">{{ \Carbon\Carbon::parse($r->tanggal)->format('d/m/Y') }}</td>
                                        <td class="py-3.5 px-4 text-gray-500">{{ $r->jam }}</td>
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
                                        <td class="py-3.5 px-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('kasir.reservasi.show', $r->id_booking) }}"
                                                    class="w-7 h-7 text-blue-500 bg-blue-50 hover:bg-blue-100 rounded-md transition-colors flex items-center justify-center"
                                                    title="Detail"><i class="fa-regular fa-eye text-xs"></i></a>
                                                <a href="{{ route('kasir.reservasi.edit', $r->id_booking) }}"
                                                    class="w-7 h-7 text-amber-500 bg-amber-50 hover:bg-amber-100 rounded-md transition-colors flex items-center justify-center"
                                                    title="Edit"><i class="fa-regular fa-pen-to-square text-xs"></i></a>
                                                <form action="{{ route('kasir.reservasi.destroy', $r->id_booking) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus reservasi ini?')">
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
                                        <td colspan="7" class="py-14 text-center">
                                            <div class="flex flex-col items-center gap-3">
                                                <div class="w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center">
                                                    <i class="fa-solid fa-calendar-check text-3xl text-pink-200"></i>
                                                </div>
                                                <p class="text-gray-400 font-medium text-[14px]">Belum ada data reservasi</p>
                                                <p class="text-gray-300 text-[12px] -mt-2">Buat reservasi baru untuk pelanggan</p>
                                                <a href="{{ route('kasir.reservasi.create') }}"
                                                    class="text-[#FF4F87] text-[12px] font-semibold hover:underline inline-flex items-center gap-1 mt-1">
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
