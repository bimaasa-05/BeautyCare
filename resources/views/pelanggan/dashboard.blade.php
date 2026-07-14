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
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Menyembunyikan scrollbar untuk top bar horizontal */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
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
            <div class="max-w-5xl mx-auto space-y-5">
                <div
                    class="bg-gradient-to-r from-[#EC4899] to-[#BE185D] rounded-2xl p-6 text-white flex items-center justify-between">
                    <div>
                        <p class="text-pink-100 text-sm mb-1">Selamat datang kembali,</p>
                        <h2 class="text-2xl font-extrabold mb-2">Sari Dewi ✨</h2>
                        <div class="flex items-center gap-2 bg-white/20 rounded-xl px-3 py-1.5 w-fit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-yellow-300 fill-yellow-300">
                                <path
                                    d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                </path>
                            </svg>
                            <span class="text-sm font-semibold">Member Gold · 2.450 Poin</span>
                        </div>
                    </div>
                    <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=400&q=80"
                        alt="Customer Profile" class="w-36 h-28 rounded-xl object-cover opacity-80">
                </div>

                <div class="grid grid-cols-4 gap-4">
                    <div
                        class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-11 h-11 rounded-xl bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-white">
                                    <path d="M8 2v4"></path>
                                    <path d="M16 2v4"></path>
                                    <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                    <path d="M3 10h18"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-400 font-medium mb-1">Booking Aktif</p>
                        <p class="text-2xl font-bold text-gray-800">2</p>
                        <p class="text-xs text-gray-400 mt-1">Berikutnya: 15 Jul</p>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-11 h-11 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-white">
                                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                                    <path d="M3 3v5h5"></path>
                                    <path d="M12 7v5l4 2"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-400 font-medium mb-1">Total Kunjungan</p>
                        <p class="text-2xl font-bold text-gray-800">28</p>
                        <p class="text-xs text-gray-400 mt-1">Sejak Jan 2025</p>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-white">
                                    <rect x="3" y="8" width="18" height="4" rx="1"></rect>
                                    <path d="M12 8v13"></path>
                                    <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"></path>
                                    <path
                                        d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-400 font-medium mb-1">Poin Reward</p>
                        <p class="text-2xl font-bold text-gray-800">2.450</p>
                        <p class="text-xs text-gray-400 mt-1">Tukar dengan diskon</p>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-11 h-11 rounded-xl bg-gradient-to-br from-rose-400 to-pink-600 flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-white">
                                    <path
                                        d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-400 font-medium mb-1">Layanan Favorit</p>
                        <p class="text-2xl font-bold text-gray-800">5</p>
                        <p class="text-xs text-gray-400 mt-1">Tersimpan</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">

                    <div class="bg-white rounded-2xl p-5 border border-pink-50 shadow-sm">
                        <h3 class="font-bold text-gray-800 mb-4">Booking Mendatang</h3>

                        <div class="flex items-center gap-3 p-3 bg-pink-50 rounded-xl mb-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-[#EC4899] to-[#BE185D] rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-white">
                                    <circle cx="6" cy="6" r="3"></circle>
                                    <path d="M8.12 8.12 12 12"></path>
                                    <path d="M20 4 8.12 15.88"></path>
                                    <circle cx="6" cy="18" r="3"></circle>
                                    <path d="M14.8 14.8 20 20"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-800">Hair Treatment</p>
                                <p class="text-xs text-gray-400">10 Jul 2026 · 09:00</p>
                            </div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border bg-blue-50 text-blue-600 border-blue-100">Dikonfirmasi</span>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-pink-50 rounded-xl mb-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-[#EC4899] to-[#BE185D] rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-white">
                                    <circle cx="6" cy="6" r="3"></circle>
                                    <path d="M8.12 8.12 12 12"></path>
                                    <path d="M20 4 8.12 15.88"></path>
                                    <circle cx="6" cy="18" r="3"></circle>
                                    <path d="M14.8 14.8 20 20"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-800">Deep Cleansing Facial</p>
                                <p class="text-xs text-gray-400">10 Jul 2026 · 10:30</p>
                            </div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border bg-violet-50 text-violet-600 border-violet-100">Berlangsung</span>
                        </div>

                        <button
                            class="w-full mt-1 py-2.5 border-2 border-dashed border-pink-200 rounded-xl text-sm font-semibold text-[#EC4899] hover:bg-pink-50 transition-colors flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5v14"></path>
                            </svg> Buat Booking Baru
                        </button>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-pink-50 shadow-sm">
                        <h3 class="font-bold text-gray-800 mb-4">Layanan Favorit</h3>
                        <div class="space-y-3">

                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&w=150&q=80"
                                    alt="Hair Treatment" class="w-12 h-10 rounded-lg object-cover flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-700 truncate">Hair Treatment</p>
                                    <p class="text-xs text-gray-400">Rp 250.000 · 90 menit</p>
                                </div>
                                <button class="text-xs text-[#EC4899] font-bold hover:underline">Booking</button>
                            </div>

                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=150&q=80"
                                    alt="Deep Cleansing Facial" class="w-12 h-10 rounded-lg object-cover flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-700 truncate">Deep Cleansing Facial</p>
                                    <p class="text-xs text-gray-400">Rp 180.000 · 60 menit</p>
                                </div>
                                <button class="text-xs text-[#EC4899] font-bold hover:underline">Booking</button>
                            </div>

                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1604654894610-df63bc536371?auto=format&fit=crop&w=150&q=80"
                                    alt="Gel Manicure" class="w-12 h-10 rounded-lg object-cover flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-700 truncate">Gel Manicure</p>
                                    <p class="text-xs text-gray-400">Rp 120.000 · 45 menit</p>
                                </div>
                                <button class="text-xs text-[#EC4899] font-bold hover:underline">Booking</button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>