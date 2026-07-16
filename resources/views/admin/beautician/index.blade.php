<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BeautyCare</title>
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

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
    </style>
</head>

<body>
    <!-- Page Loader -->
    <div class="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <!-- Dashboard Content -->
            <main class="flex-1 flex flex-col overflow-hidden relative">
            <div class="flex-1 overflow-y-auto p-8">
                
                <div class="flex justify-between items-center mb-6">
                    <p class="text-[13px] font-medium text-gray-400">{{ $beautician->count() }} beautician terdaftar</p>
                    
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="text" placeholder="Cari beautician..." class="bg-white border border-gray-200 text-[12px] rounded-full pl-9 pr-4 py-2 w-[220px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400 shadow-sm">
                        </div>
                        <a href="{{ route('admin.beautician.create') }}" class="flex items-center gap-2 bg-[#de3b7c] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                            <i class="fa-solid fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    @forelse ($beautician as $b)
                    <div class="bg-white rounded-3xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] border border-pink-50/50">
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-[#f472b6] text-white flex items-center justify-center font-bold text-lg">{{ strtoupper(substr($b->user?->nama ?? '??', 0, 2)) }}</div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-[15px]">{{ $b->user?->nama ?? 'User tidak ditemukan' }}</h3>
                                    <p class="text-[12px] text-gray-400 mt-0.5">{{ $b->role }}</p>
                                </div>
                            </div>
                            @if ($b->status == 1)
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-500 font-semibold text-[11px] rounded-lg border border-emerald-100">Tersedia</span>
                            @elseif ($b->status == 2)
                                <span class="px-2.5 py-1 bg-orange-50 text-orange-500 font-semibold text-[11px] rounded-lg border border-orange-100">Sibuk</span>
                            @else
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-500 font-semibold text-[11px] rounded-lg border border-gray-200">Libur</span>
                            @endif
                        </div>

                        <div class="grid grid-cols-3 gap-3 mb-5">
                            <div class="bg-[#fdf2f8] rounded-2xl py-2.5 flex flex-col items-center justify-center">
                                <span class="text-[#de3b7c] font-bold text-[15px] mb-0.5">{{ $b->jabatan }}</span>
                                <span class="text-[10px] text-gray-400 font-medium">Karyawan</span>
                            </div>
                            <div class="bg-[#fdf2f8] rounded-2xl py-2.5 flex flex-col items-center justify-center">
                                <span class="text-[#de3b7c] font-bold text-[15px] mb-0.5"></span>
                                <span class="text-[10px] text-gray-400 font-medium">Booking</span>
                            </div>
                            <div class="bg-[#fdf2f8] rounded-2xl py-2.5 flex flex-col items-center justify-center">
                                <span class="text-[#de3b7c] font-bold text-[15px] mb-0.5">-</span>
                                <span class="text-[10px] text-gray-400 font-medium">Pengalaman</span>
                            </div>
                        </div>

                        <div class="flex items-center text-[12px] text-gray-400 font-medium mb-5">
                            <i class="fa-regular fa-clock mr-2 text-gray-300"></i> -
                        </div>

                        <div class="flex gap-2.5">
                            <button class="flex-1 bg-[#fdf2f8] text-[#de3b7c] font-bold text-[13px] py-2.5 rounded-2xl hover:bg-pink-100 transition-colors">Jadwal</button>
                            <a href="{{ route('admin.beautician.edit', $b->id_karyawan) }}" class="w-10 h-10 flex items-center justify-center text-amber-500 bg-amber-50 border border-amber-100 hover:bg-amber-100 rounded-2xl transition-colors"><i class="fa-regular fa-pen-to-square text-[13px]"></i></a>
                            <form action="{{ route('admin.beautician.destroy', $b->id_karyawan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus beautician ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 flex items-center justify-center text-red-500 bg-red-50 border border-red-100 hover:bg-red-100 rounded-2xl transition-colors"><i class="fa-regular fa-trash-can text-[13px]"></i></button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 flex items-center justify-center py-16">
                        <div class="text-center">
                            <i class="fa-regular fa-face-frown text-5xl text-gray-300 mb-4"></i>
                            <p class="text-gray-400 text-[13px] font-medium">Belum ada data beautician</p>
                        </div>
                    </div>
                    @endforelse
                </div>

            </div>
        </main>
        </main>
    </div>

    <script>
        // Set current date
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', options);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
