<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BeautyCare</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>

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
</head>

<body>
    <!-- Page Loader -->


    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')
            <main class="flex-1 overflow-y-auto p-5">
                <div class="grid grid-cols-3 gap-5 h-[calc(100vh-8rem)]">

                    <!-- Product Selection (Left, 2 columns) -->
                    <div
                        class="col-span-2 bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.07)] border border-pink-50 flex flex-col">
                        <!-- Filter & Search -->
                        <div class="flex items-center gap-3 mb-4 flex-shrink-0">
                            <div class="flex-1 relative">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.3-4.3"></path>
                                </svg>
                                <input
                                    class="w-full pl-8 pr-4 py-2.5 bg-[#FFF7FA] border border-pink-100 rounded-xl text-sm focus:outline-none focus:border-pink-300"
                                    placeholder="Cari layanan atau produk...">
                            </div>
                            <select
                                class="border border-pink-100 rounded-xl px-3 py-2.5 text-sm text-gray-600 bg-[#FFF7FA] focus:outline-none">
                                <option>Semua Kategori</option>
                                <option>Rambut</option>
                                <option>Wajah</option>
                                <option>Kuku</option>
                            </select>
                        </div>

                        <!-- Product Grid -->
                        <div class="grid grid-cols-3 gap-3 overflow-y-auto flex-1">
                            <button
                                class="rounded-xl p-3 text-left border-2 transition-all border-transparent bg-[#FFF7FA] hover:border-pink-100">
                                <img src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=400&q=80&fit=crop"
                                    alt="Hair Treatment" class="w-full h-20 object-cover rounded-lg mb-2">
                                <p class="text-xs font-bold text-gray-800 leading-snug">Hair Treatment</p>
                                <p class="text-[10px] text-gray-400 mb-1">90 menit</p>
                                <p class="text-sm font-bold text-[#EC4899]">Rp 250.000</p>
                            </button>
                            <button
                                class="rounded-xl p-3 text-left border-2 transition-all border-transparent bg-[#FFF7FA] hover:border-pink-100">
                                <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=400&q=80&fit=crop"
                                    alt="Deep Cleansing Facial" class="w-full h-20 object-cover rounded-lg mb-2">
                                <p class="text-xs font-bold text-gray-800 leading-snug">Deep Cleansing Facial</p>
                                <p class="text-[10px] text-gray-400 mb-1">60 menit</p>
                                <p class="text-sm font-bold text-[#EC4899]">Rp 180.000</p>
                            </button>
                            <button
                                class="rounded-xl p-3 text-left border-2 transition-all border-transparent bg-[#FFF7FA] hover:border-pink-100">
                                <img src="https://images.unsplash.com/photo-1604654894610-df63bc536371?w=400&q=80&fit=crop"
                                    alt="Gel Manicure" class="w-full h-20 object-cover rounded-lg mb-2">
                                <p class="text-xs font-bold text-gray-800 leading-snug">Gel Manicure</p>
                                <p class="text-[10px] text-gray-400 mb-1">45 menit</p>
                                <p class="text-sm font-bold text-[#EC4899]">Rp 120.000</p>
                            </button>
                            <button
                                class="rounded-xl p-3 text-left border-2 transition-all border-transparent bg-[#FFF7FA] hover:border-pink-100">
                                <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=400&q=80&fit=crop"
                                    alt="Swedish Massage" class="w-full h-20 object-cover rounded-lg mb-2">
                                <p class="text-xs font-bold text-gray-800 leading-snug">Swedish Massage</p>
                                <p class="text-[10px] text-gray-400 mb-1">60 menit</p>
                                <p class="text-sm font-bold text-[#EC4899]">Rp 220.000</p>
                            </button>
                            <button
                                class="rounded-xl p-3 text-left border-2 transition-all border-transparent bg-[#FFF7FA] hover:border-pink-100">
                                <img src="https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?w=400&q=80&fit=crop"
                                    alt="Bridal Makeup" class="w-full h-20 object-cover rounded-lg mb-2">
                                <p class="text-xs font-bold text-gray-800 leading-snug">Bridal Makeup</p>
                                <p class="text-[10px] text-gray-400 mb-1">120 menit</p>
                                <p class="text-sm font-bold text-[#EC4899]">Rp 500.000</p>
                            </button>
                            <button
                                class="rounded-xl p-3 text-left border-2 transition-all border-transparent bg-[#FFF7FA] hover:border-pink-100">
                                <img src="https://images.unsplash.com/photo-1560781282-abe72bb5f0ea?w=400&q=80&fit=crop"
                                    alt="Eyelash Extension" class="w-full h-20 object-cover rounded-lg mb-2">
                                <p class="text-xs font-bold text-gray-800 leading-snug">Eyelash Extension</p>
                                <p class="text-[10px] text-gray-400 mb-1">75 menit</p>
                                <p class="text-sm font-bold text-[#EC4899]">Rp 300.000</p>
                            </button>
                        </div>
                    </div>

                    <!-- Order Cart (Right, 1 column) -->
                    <div
                        class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.07)] border border-pink-50 flex flex-col">
                        <h3 class="font-bold text-gray-800 mb-3 flex-shrink-0">Pesanan</h3>

                        <!-- Customer Info -->
                        <div class="flex items-center gap-3 mb-3 flex-shrink-0">
                            <div
                                class="w-8 h-8 text-xs rounded-full bg-gradient-to-br from-rose-300 to-pink-400 flex items-center justify-center text-white font-bold flex-shrink-0 shadow-sm">
                                SD</div>
                            <div>
                                <p class="text-sm font-semibold text-gray-700">Sari Dewi</p>
                                <p class="text-xs text-gray-400">Member Gold</p>
                            </div>
                        </div>

                        <!-- Empty Cart State -->
                        <div class="flex-1 space-y-2 overflow-y-auto">
                            <div class="text-center py-8 text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="mx-auto mb-2">
                                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                                    <path d="M3 6h18"></path>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>
                                <p class="text-sm">Pilih layanan</p>
                            </div>
                        </div>

                        <!-- Total Breakdown -->
                        <div class="border-t border-pink-50 pt-3 mt-3 space-y-2 flex-shrink-0">
                            <div class="flex justify-between text-sm text-gray-400">
                                <span>Subtotal</span>
                                <span class="text-gray-700 font-semibold">Rp 370.000</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-400">
                                <span>Diskon Member</span>
                                <span class="text-emerald-500 font-semibold">-Rp 37.000</span>
                            </div>
                            <div class="flex justify-between font-bold text-gray-800">
                                <span>Total</span>
                                <span class="text-[#EC4899]">Rp 333.000</span>
                            </div>
                        </div>

                        <!-- Payment Methods & Checkout button -->
                        <div class="space-y-2 mt-3 flex-shrink-0">
                            <p class="text-xs font-bold text-gray-600">Metode Pembayaran</p>
                            <button
                                class="w-full py-2 border border-pink-100 rounded-xl text-xs font-bold text-gray-600 hover:bg-pink-50 hover:border-pink-300 hover:text-[#EC4899] transition-all">Tunai</button>
                            <button
                                class="w-full py-2 border border-pink-100 rounded-xl text-xs font-bold text-gray-600 hover:bg-pink-50 hover:border-pink-300 hover:text-[#EC4899] transition-all">QRIS</button>
                            <button
                                class="w-full py-2 border border-pink-100 rounded-xl text-xs font-bold text-gray-600 hover:bg-pink-50 hover:border-pink-300 hover:text-[#EC4899] transition-all">Transfer</button>
                            <button
                                class="w-full py-3 mt-1 bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white font-bold rounded-xl shadow-md hover:opacity-95 transition-all flex items-center justify-center gap-2 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                    </path>
                                    <path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"></path>
                                    <rect x="6" y="14" width="12" height="8" rx="1"></rect>
                                </svg> Proses &amp; Cetak
                            </button>
                        </div>
                    </div>

                </div>
            </main>