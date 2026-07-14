<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BeautyCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
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
</head>

<body>
    <!-- Page Loader -->


    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <!-- Dashboard Content -->
            <div class="flex-1 overflow-hidden">
                <div class="flex h-full bg-[#FFF7FA]">
                    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                        <main class="flex-1 overflow-y-auto p-5">
                            <div class="space-y-5">

                                <div class="grid grid-cols-4 gap-4">
                                    <div
                                        class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                        <div class="flex items-start justify-between mb-4">
                                            <div
                                                class="w-11 h-11 rounded-xl bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="text-white">
                                                    <path d="M8 2v4"></path>
                                                    <path d="M16 2v4"></path>
                                                    <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                                    <path d="M3 10h18"></path>
                                                </svg>
                                            </div>
                                            <span
                                                class="flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full text-emerald-600 bg-emerald-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                                    <polyline points="16 7 22 7 22 13"></polyline>
                                                </svg>0%
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-400 font-medium mb-1">Booking Hari Ini</p>
                                        <p class="text-2xl font-bold text-gray-800">6</p>
                                        <p class="text-xs text-gray-400 mt-1">3 selesai, 3 akan datang</p>
                                    </div>

                                    <div
                                        class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                        <div class="flex items-start justify-between mb-4">
                                            <div
                                                class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="text-white">
                                                    <path
                                                        d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span
                                                class="flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full text-emerald-600 bg-emerald-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                                    <polyline points="16 7 22 7 22 13"></polyline>
                                                </svg>2%
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-400 font-medium mb-1">Rating Saya</p>
                                        <p class="text-2xl font-bold text-gray-800">4.9</p>
                                        <p class="text-xs text-gray-400 mt-1">Dari 248 ulasan</p>
                                    </div>

                                    <div
                                        class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                        <div class="flex items-start justify-between mb-4">
                                            <div
                                                class="w-11 h-11 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="text-white">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <polyline points="12 6 12 12 16 14"></polyline>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-400 font-medium mb-1">Jam Kerja</p>
                                        <p class="text-2xl font-bold text-gray-800">08:00–17:00</p>
                                        <p class="text-xs text-gray-400 mt-1">Aktif hari ini</p>
                                    </div>

                                    <div
                                        class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                                        <div class="flex items-start justify-between mb-4">
                                            <div
                                                class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="text-white">
                                                    <path
                                                        d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
                                                    </path>
                                                    <circle cx="12" cy="8" r="6"></circle>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-400 font-medium mb-1">Peringkat</p>
                                        <p class="text-2xl font-bold text-gray-800">#1</p>
                                        <p class="text-xs text-gray-400 mt-1">Dari 6 beautician</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-5">

                                    <div
                                        class="col-span-2 bg-white rounded-2xl p-5 border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)]">
                                        <h3 class="font-bold text-gray-800 mb-4">Jadwal Hari Ini</h3>
                                        <div class="space-y-3">

                                            <div
                                                class="flex items-center gap-4 p-4 rounded-xl border bg-[#FFF7FA] border-pink-50">
                                                <div class="text-center w-14 flex-shrink-0">
                                                    <p class="text-sm font-bold text-gray-700">09:00</p>
                                                    <p class="text-xs text-gray-400">90 menit</p>
                                                </div>
                                                <div class="w-px h-8 bg-pink-100"></div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-bold text-gray-800">Sari Dewi</p>
                                                    <p class="text-xs text-gray-400">Hair Treatment</p>
                                                </div>
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border bg-blue-50 text-blue-600 border-blue-100">Dikonfirmasi</span>
                                            </div>

                                            <div
                                                class="flex items-center gap-4 p-4 rounded-xl border bg-violet-50 border-violet-100">
                                                <div class="text-center w-14 flex-shrink-0">
                                                    <p class="text-sm font-bold text-gray-700">10:30</p>
                                                    <p class="text-xs text-gray-400">60 menit</p>
                                                </div>
                                                <div class="w-px h-8 bg-pink-100"></div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-bold text-gray-800">Maya Putri</p>
                                                    <p class="text-xs text-gray-400">Deep Cleansing Facial</p>
                                                </div>
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border bg-violet-50 text-violet-600 border-violet-100">Berlangsung</span>
                                            </div>

                                            <div
                                                class="flex items-center gap-4 p-4 rounded-xl border bg-[#FFF7FA] border-pink-50">
                                                <div class="text-center w-14 flex-shrink-0">
                                                    <p class="text-sm font-bold text-gray-700">13:00</p>
                                                    <p class="text-xs text-gray-400">45 menit</p>
                                                </div>
                                                <div class="w-px h-8 bg-pink-100"></div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-bold text-gray-800">Rina Susanti</p>
                                                    <p class="text-xs text-gray-400">Gel Manicure</p>
                                                </div>
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border bg-amber-50 text-amber-600 border-amber-100">Menunggu</span>
                                            </div>

                                            <div
                                                class="flex items-center gap-4 p-4 rounded-xl border bg-[#FFF7FA] border-pink-50">
                                                <div class="text-center w-14 flex-shrink-0">
                                                    <p class="text-sm font-bold text-gray-700">14:00</p>
                                                    <p class="text-xs text-gray-400">120 menit</p>
                                                </div>
                                                <div class="w-px h-8 bg-pink-100"></div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-bold text-gray-800">Fitri Handayani</p>
                                                    <p class="text-xs text-gray-400">Bridal Makeup</p>
                                                </div>
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border bg-blue-50 text-blue-600 border-blue-100">Dikonfirmasi</span>
                                            </div>

                                            <div
                                                class="flex items-center gap-4 p-4 rounded-xl border bg-[#FFF7FA] border-pink-50">
                                                <div class="text-center w-14 flex-shrink-0">
                                                    <p class="text-sm font-bold text-gray-700">15:30</p>
                                                    <p class="text-xs text-gray-400">60 menit</p>
                                                </div>
                                                <div class="w-px h-8 bg-pink-100"></div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-bold text-gray-800">Indah Lestari</p>
                                                    <p class="text-xs text-gray-400">Swedish Massage</p>
                                                </div>
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border bg-red-50 text-red-500 border-red-100">Dibatalkan</span>
                                            </div>

                                            <div
                                                class="flex items-center gap-4 p-4 rounded-xl border bg-gray-50 border-gray-100">
                                                <div class="text-center w-14 flex-shrink-0">
                                                    <p class="text-sm font-bold text-gray-700">16:00</p>
                                                    <p class="text-xs text-gray-400">75 menit</p>
                                                </div>
                                                <div class="w-px h-8 bg-pink-100"></div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-bold text-gray-800">Citra Wulandari</p>
                                                    <p class="text-xs text-gray-400">Eyelash Extension</p>
                                                </div>
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border bg-emerald-50 text-emerald-600 border-emerald-100">Selesai</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="bg-white rounded-2xl p-5 border border-pink-50 shadow-[0_2px_16px_rgba(236,72,153,0.07)]">
                                        <h3 class="font-bold text-gray-800 mb-4">Performa Bulan Ini</h3>
                                        <div class="space-y-3">
                                            <div class="p-3 bg-pink-50 rounded-xl">
                                                <p class="text-xs text-gray-400 mb-1">Booking Selesai</p>
                                                <p class="text-xl font-bold text-gray-800">42</p>
                                                <p class="text-xs text-gray-400">dari 48 total</p>
                                            </div>
                                            <div class="p-3 bg-pink-50 rounded-xl">
                                                <p class="text-xs text-gray-400 mb-1">Kepuasan Pelanggan</p>
                                                <p class="text-xl font-bold text-gray-800">96%</p>
                                                <p class="text-xs text-gray-400">4.9/5 rata-rata</p>
                                            </div>
                                            <div class="p-3 bg-pink-50 rounded-xl">
                                                <p class="text-xs text-gray-400 mb-1">Kontribusi Revenue</p>
                                                <p class="text-xl font-bold text-gray-800">Rp 10,5jt</p>
                                                <p class="text-xs text-gray-400">dari total salon</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </main>
                    </div>
                </div>
            </div>