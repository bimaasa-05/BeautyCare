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
    <div class="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <main class="flex-1 flex flex-col overflow-hidden relative">
                <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                    <main class="flex-1 overflow-y-auto p-5">
                        <div class="space-y-4">

                            <div class="flex items-center justify-between flex-wrap gap-3">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <button
                                        class="px-3 py-2 rounded-xl text-xs font-bold transition-all bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white shadow-sm">Semua</button>
                                    <button
                                        class="px-3 py-2 rounded-xl text-xs font-bold transition-all bg-white border border-pink-100 text-gray-500 hover:border-pink-300 hover:text-[#EC4899]">Rambut</button>
                                    <button
                                        class="px-3 py-2 rounded-xl text-xs font-bold transition-all bg-white border border-pink-100 text-gray-500 hover:border-pink-300 hover:text-[#EC4899]">Wajah</button>
                                    <button
                                        class="px-3 py-2 rounded-xl text-xs font-bold transition-all bg-white border border-pink-100 text-gray-500 hover:border-pink-300 hover:text-[#EC4899]">Kuku</button>
                                    <button
                                        class="px-3 py-2 rounded-xl text-xs font-bold transition-all bg-white border border-pink-100 text-gray-500 hover:border-pink-300 hover:text-[#EC4899]">Tubuh</button>
                                    <button
                                        class="px-3 py-2 rounded-xl text-xs font-bold transition-all bg-white border border-pink-100 text-gray-500 hover:border-pink-300 hover:text-[#EC4899]">Makeup</button>
                                    <button
                                        class="px-3 py-2 rounded-xl text-xs font-bold transition-all bg-white border border-pink-100 text-gray-500 hover:border-pink-300 hover:text-[#EC4899]">Mata</button>
                                </div>
                                <a href="{{ route('admin.layanan.create') }}"
                                    class="flex items-center gap-1.5 px-3 py-2 bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white rounded-xl text-xs font-bold shadow-sm hover:opacity-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5v14"></path>
                                    </svg> Tambah Layanan
                                </a>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @forelse ($layanan as $l)
                                <div
                                    class="bg-white rounded-2xl overflow-hidden border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.06)] hover:shadow-[0_4px_24px_rgba(236,72,153,0.12)] transition-all group">
                                    <div class="relative overflow-hidden h-40">
                                        <img src="{{ asset('storage/' . $l->foto) }}"
                                            alt="Hair Treatment"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        <div
                                            class="absolute top-3 left-3 bg-[#EC4899] text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1">
                                            ✨ Populer</div>
                                        <div
                                            class="absolute top-3 right-3 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button
                                                class="w-7 h-7 bg-white rounded-lg flex items-center justify-center shadow text-amber-500 hover:bg-amber-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                    </path>
                                                    <path
                                                        d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button
                                                class="w-7 h-7 bg-white rounded-lg flex items-center justify-center shadow text-red-400 hover:bg-red-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M3 6h18"></path>
                                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                    <line x1="10" x2="10" y1="11" y2="17"></line>
                                                    <line x1="14" x2="14" y1="11" y2="17"></line>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-1.5">
                                            <span
                                                class="text-[10px] font-bold text-[#EC4899] bg-pink-50 px-2 py-0.5 rounded-full">{{ $l->id_kategori }}</span>
                                            <span class="text-[10px] text-gray-400 flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <polyline points="12 6 12 12 16 14"></polyline>
                                                </svg> 90 menit
                                            </span>
                                        </div>
                                        <h3 class="font-bold text-gray-800 mb-2">{{ $l->nm_layanan }}</h3>
                                        <div class="flex items-center justify-between">
                                            <span class="text-base font-extrabold text-[#EC4899]">Rp {{ number_format($l->harga, 0, ',', '.') }}a</span>
                                            <button
                                                class="text-[10px] font-bold text-white bg-gradient-to-r from-[#EC4899] to-[#BE185D] px-2.5 py-1.5 rounded-xl hover:opacity-90">Booking</button>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-span-full bg-white p-8 rounded-2xl text-center shadow-sm border border-pink-50">
                                    <p class="text-gray-500">Belum ada layanan yang ditambahkan.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </main>
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

        // Jika Anda memakai lucide icon, pastikan script-nya ada di header
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>