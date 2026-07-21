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
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-5">
                <div class="space-y-5">

                    <!-- 5 STATS GRID -->
                    <div class="grid grid-cols-5 gap-4">
                        <!-- Card Total -->
                        <div
                            class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="w-11 h-11 rounded-xl bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-users text-white">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">Total Member</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalMember }}</p>
                            <p class="text-xs text-gray-400 mt-1">total membership terdaftar</p>
                        </div>
                        <!-- Card Silver -->
                        <div
                            class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(148,163,184,0.15)] border border-gray-100 hover:shadow-[0_4px_24px_rgba(148,163,184,0.2)] transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="w-11 h-11 rounded-xl bg-gradient-to-br from-gray-400 to-slate-500 flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-credit-card text-white">
                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                        <line x1="1" y1="10" x2="23" y2="10"></line>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">Member Silver</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $memberSilver }}</p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $totalMember > 0 ? round($memberSilver / $totalMember * 100) : 0 }}% dari total
                            </p>
                        </div>
                        <!-- Card 2 -->
                        <div
                            class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-star text-white">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">Member Gold</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $memberGold }}</p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $totalMember > 0 ? round($memberGold / $totalMember * 100) : 0 }}% dari total
                            </p>
                        </div>
                        <div
                            class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="w-11 h-11 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-award text-white">
                                        <path
                                            d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
                                        </path>
                                        <circle cx="12" cy="8" r="6"></circle>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">Member Platinum</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $memberPlatinum }}</p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $totalMember > 0 ? round($memberPlatinum / $totalMember * 100) : 0 }}% dari total
                            </p>
                        </div>
                        <!-- Card 4 -->
                        <div
                            class="bg-white rounded-2xl p-5 shadow-[0_2px_16px_rgba(236,72,153,0.08)] border border-pink-50 hover:shadow-[0_4px_24px_rgba(236,72,153,0.14)] transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-gift text-white">
                                        <rect x="3" y="8" width="18" height="4" rx="1"></rect>
                                        <path d="M12 8v13"></path>
                                        <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"></path>
                                        <path
                                            d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 font-medium mb-1">Member Aktif</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $memberAktif }}</p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $totalMember > 0 ? round($memberAktif / $totalMember * 100) : 0 }}% member aktif
                            </p>
                        </div>
                    </div>

                    <!-- 3 TIERS PRICING GRID -->
                    <div class="grid grid-cols-3 gap-5" id="tierFilters">
                        <!-- Tier Silver -->
                        <div data-tingkat="Silver"
                            class="tier-card rounded-2xl border border-gray-200 overflow-hidden shadow-[0_4px_24px_rgba(0,0,0,0.06)] hover:shadow-xl transition-all relative cursor-pointer">
                            <div class="bg-gradient-to-br from-gray-400 to-slate-500 p-5 text-white">
                                <h3 class="text-2xl font-extrabold mb-2">Silver</h3>
                                <p class="text-xl font-bold">Gratis</p>
                            </div>
                            <div class="bg-gray-50 p-5 space-y-3">
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="text-center p-2.5 bg-white rounded-xl">
                                        <p class="text-lg font-extrabold text-gray-800">{{ $diskonSilver }}%</p>
                                        <p class="text-[10px] text-gray-400">Diskon</p>
                                    </div>
                                    <div class="text-center p-2.5 bg-white rounded-xl">
                                        <p class="text-lg font-extrabold text-gray-800">
                                            {{ $memberGold + $memberPlatinum > 0 ? '1x' : '-' }}
                                        </p>
                                        <p class="text-[10px] text-gray-400">Poin</p>
                                    </div>
                                </div>
                                <ul class="space-y-1.5">
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-circle-check text-[#EC4899] mt-0.5 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>Diskon {{ $diskonSilver }}% semua layanan</li>
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-circle-check text-[#EC4899] mt-0.5 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>Poin reward 1x</li>
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-circle-check text-[#EC4899] mt-0.5 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>Notifikasi promo</li>
                                </ul>
                            </div>
                        </div>
                        <!-- Tier Gold -->
                        <div data-tingkat="Gold"
                            class="tier-card rounded-2xl border border-amber-200 overflow-hidden shadow-[0_4px_24px_rgba(0,0,0,0.06)] hover:shadow-xl transition-all relative cursor-pointer">
                            <div class="bg-gradient-to-br from-yellow-400 to-amber-500 p-5 text-white">
                                <h3 class="text-2xl font-extrabold mb-2">Gold</h3>
                                <p class="text-xl font-bold">Rp 500rb/thn</p>
                            </div>
                            <div class="bg-amber-50 p-5 space-y-3">
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="text-center p-2.5 bg-white rounded-xl">
                                        <p class="text-lg font-extrabold text-gray-800">{{ $diskonGold }}%</p>
                                        <p class="text-[10px] text-gray-400">Diskon</p>
                                    </div>
                                    <div class="text-center p-2.5 bg-white rounded-xl">
                                        <p class="text-lg font-extrabold text-gray-800">2x</p>
                                        <p class="text-[10px] text-gray-400">Poin</p>
                                    </div>
                                </div>
                                <ul class="space-y-1.5">
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-circle-check text-[#EC4899] mt-0.5 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>Diskon {{ $diskonGold }}% semua layanan</li>
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-circle-check text-[#EC4899] mt-0.5 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>Poin reward 2x</li>
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-circle-check text-[#EC4899] mt-0.5 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>1 layanan gratis/bulan</li>
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-circle-check text-[#EC4899] mt-0.5 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>Hadiah ulang tahun</li>
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-circle-check text-[#EC4899] mt-0.5 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>Booking prioritas VIP</li>
                                </ul>
                            </div>
                        </div>
                        <!-- Tier Platinum -->
                        <div data-tingkat="Platinum"
                            class="tier-card rounded-2xl border border-violet-200 overflow-hidden shadow-[0_4px_24px_rgba(0,0,0,0.06)] hover:shadow-xl transition-all relative cursor-pointer">
                            <div
                                class="absolute top-3 right-3 z-10 bg-violet-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                                TERBAIK</div>
                            <div class="bg-gradient-to-br from-violet-400 to-purple-600 p-5 text-white">
                                <h3 class="text-2xl font-extrabold mb-2">Platinum</h3>
                                <p class="text-xl font-bold">Rp 1jt/thn</p>
                            </div>
                            <div class="bg-violet-50 p-5 space-y-3">
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="text-center p-2.5 bg-white rounded-xl">
                                        <p class="text-lg font-extrabold text-gray-800">{{ $diskonPlatinum }}%</p>
                                        <p class="text-[10px] text-gray-400">Diskon</p>
                                    </div>
                                    <div class="text-center p-2.5 bg-white rounded-xl">
                                        <p class="text-lg font-extrabold text-gray-800">3x</p>
                                        <p class="text-[10px] text-gray-400">Poin</p>
                                    </div>
                                </div>
                                <ul class="space-y-1.5">
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="lucide lucide-circle-check text-[#EC4899] mt-0.5 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>Diskon {{ $diskonPlatinum }}% semua layanan</li>
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="lucide lucide-circle-check text-[#EC4899] mt-0.5 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>Poin reward 3x</li>
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="lucide lucide-circle-check text-[#EC4899] mt-0.5 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>2 layanan gratis/bulan</li>
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="lucide lucide-circle-check text-[#EC4899] mt-0.5 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>Akses VIP exclusive</li>
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="lucide lucide-circle-check text-[#EC4899] mt-0.5 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>Hadiah mewah ulang tahun</li>
                                    <li class="flex items-start gap-2 text-xs text-gray-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="lucide lucide-circle-check text-[#EC4899] mt-0.5 flex-shrink-0">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>Konsultasi beauty gratis</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- MEMBER TABLE WRAPPER -->
                    <div class="bg-white rounded-2xl p-5 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)]">
                        @if (session('success'))
                            <div
                                class="mb-4 flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 text-[13px] px-4 py-3 rounded-xl">
                                <i class="fa-solid fa-check-circle text-emerald-500"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
                            <div>
                                <h3 class="text-[16px] font-bold text-gray-800">Data Membership</h3>
                                <p class="text-[12px] text-gray-400 mt-0.5">Total <span
                                        id="totalCount">{{ $memberships->count() }}</span> member</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                                    <input id="searchMember"
                                        class="pl-8 pr-3 py-2 bg-[#FFF7FA] border border-pink-100 rounded-xl text-xs focus:outline-none focus:border-pink-300 w-full sm:w-[200px] lg:w-44"
                                        placeholder="Cari member...">
                                </div>
                                <a href="{{ route('admin.membership.create') }}"
                                    class="flex items-center gap-2 bg-[#de3b7c] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#c62f6b] transition-colors shadow-sm">
                                    <i class="fa-solid fa-plus"></i> Tambah
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mb-4" id="filterButtons">
                            <button data-filter="all"
                                class="filter-btn text-[11px] font-semibold px-3.5 py-1.5 rounded-full border transition-colors bg-[#de3b7c] text-white border-[#de3b7c]">
                                Semua
                            </button>
                            <button data-filter="Silver"
                                class="filter-btn text-[11px] font-semibold px-3.5 py-1.5 rounded-full border transition-colors bg-gray-50 text-gray-500 border-gray-200 hover:bg-gray-100">
                                Silver
                            </button>
                            <button data-filter="Gold"
                                class="filter-btn text-[11px] font-semibold px-3.5 py-1.5 rounded-full border transition-colors bg-yellow-50 text-yellow-600 border-yellow-200 hover:bg-yellow-100">
                                Gold
                            </button>
                            <button data-filter="Platinum"
                                class="filter-btn text-[11px] font-semibold px-3.5 py-1.5 rounded-full border transition-colors bg-violet-50 text-violet-600 border-violet-200 hover:bg-violet-100">
                                Platinum
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr
                                        class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-gray-50/50">
                                        <th class="py-3 px-3 w-10">#</th>
                                        <th class="py-3 px-3">Nama Member</th>
                                        <th class="py-3 px-3">Tingkat</th>
                                        <th class="py-3 px-3">Diskon</th>
                                        <th class="py-3 px-3">Masa Berlaku</th>
                                        <th class="py-3 px-3">Status</th>
                                        <th class="py-3 px-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="memberTableBody" class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                    @forelse ($memberships as $item)
                                        <tr class="hover:bg-gray-50/50 transition-colors"
                                            data-tingkat="{{ $item->tingkat }}">
                                            <td class="py-3 px-3 text-gray-400">{{ $loop->iteration }}</td>
                                            <td class="py-3 px-3 font-medium">{{ $item->nm_member }}</td>
                                            <td class="py-3 px-3">
                                                @php
                                                    $tierColors = [
                                                        'Silver' => ['bg' => 'bg-gray-50', 'text' => 'text-gray-500', 'border' => 'border-gray-200'],
                                                        'Gold' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-600', 'border' => 'border-yellow-200'],
                                                        'Platinum' => ['bg' => 'bg-violet-50', 'text' => 'text-violet-600', 'border' => 'border-violet-100'],
                                                    ];
                                                    $colors = $tierColors[$item->tingkat] ?? $tierColors['Silver'];
                                                @endphp
                                                <span
                                                    class="inline-flex items-center text-[11px] font-semibold px-2.5 py-1 rounded-full border {{ $colors['bg'] }} {{ $colors['text'] }} {{ $colors['border'] }}">
                                                    {{ $item->tingkat }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-3">{{ $item->diskon }}%</td>
                                            <td class="py-3 px-3">{{ number_format($item->masa_berlaku) }} hari</td>
                                            <td class="py-3 px-3">
                                                @php
                                                    $statusBg = [
                                                        'aktif' => '#ecfdf5',
                                                        'suspend' => '#fffbeb',
                                                        'non_aktif' => '#fff1f2',
                                                    ];
                                                    $statusText = [
                                                        'aktif' => '#059669',
                                                        'suspend' => '#d97706',
                                                        'non_aktif' => '#e11d48',
                                                    ];
                                                @endphp
                                                <select onchange="ubahStatusMember(this, {{ $item->id_member }})"
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold border cursor-pointer focus:outline-none focus:ring-2 focus:ring-pink-300"
                                                    style="background-color: {{ $statusBg[$item->status] ?? '#f9fafb' }}; color: {{ $statusText[$item->status] ?? '#6b7280' }}; border-color: transparent;">
                                                    <option value="aktif" {{ $item->status == 'aktif' ? 'selected' : '' }} style="background:#ecfdf5;color:#059669;">Aktif</option>
                                                    <option value="suspend" {{ $item->status == 'suspend' ? 'selected' : '' }} style="background:#fffbeb;color:#d97706;">Suspend</option>
                                                    <option value="non_aktif" {{ $item->status == 'non_aktif' ? 'selected' : '' }} style="background:#fff1f2;color:#e11d48;">Non Aktif</option>
                                                </select>
                                            </td>
                                            <td class="py-3 px-3">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('admin.membership.edit', $item->id_member) }}"
                                                        class="w-7 h-7 inline-flex items-center justify-center text-amber-500 bg-amber-50 hover:bg-amber-100 rounded-md transition-colors"><i
                                                            class="fa-regular fa-pen-to-square text-xs"></i>
                                                    </a>
                                                    <form action="{{ route('admin.membership.destroy', $item->id_member) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus membership ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="w-7 h-7 text-red-500 bg-red-50 hover:bg-red-100 rounded-md transition-colors"><i
                                                                class="fa-regular fa-trash-can text-xs"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-8 text-center text-gray-400 text-[13px]">
                                                <i class="fa-solid fa-folder-open text-2xl block mb-2 text-gray-300"></i>
                                                Belum ada data membership
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
        </main>

        <script>
            function ubahStatusMember(el, id) {
                const status = el.value;
                fetch('/admin/membership/' + id + '/status', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const colors = {
                            aktif: { bg: '#ecfdf5', text: '#059669' },
                            suspend: { bg: '#fffbeb', text: '#d97706' },
                            non_aktif: { bg: '#fff1f2', text: '#e11d48' },
                        };
                        const c = colors[status] || { bg: '#f9fafb', text: '#6b7280' };
                        el.style.backgroundColor = c.bg;
                        el.style.color = c.text;
                    } else {
                        alert('Gagal mengubah status');
                        location.reload();
                    }
                })
                .catch(() => { alert('Terjadi kesalahan'); location.reload(); });
            }
        </script>
        <script src="{{ asset('assets/js/dashboard.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tierCards = document.querySelectorAll('.tier-card');
                const filterBtns = document.querySelectorAll('.filter-btn');
                const rows = document.querySelectorAll('#memberTableBody tr');
                const totalSpan = document.getElementById('totalCount');

                function filterTable(tingkat) {
                    let visible = 0;

                    const ringMap = {
                        'Silver': ['ring-2', 'ring-gray-400', 'ring-offset-2'],
                        'Gold': ['ring-2', 'ring-amber-400', 'ring-offset-2'],
                        'Platinum': ['ring-2', 'ring-violet-400', 'ring-offset-2'],
                    };

                    tierCards.forEach(card => {
                        card.classList.remove('ring-2', 'ring-gray-400', 'ring-amber-400', 'ring-violet-400', 'ring-offset-2');
                        if (card.dataset.tingkat === tingkat) {
                            card.classList.add(...ringMap[tingkat]);
                        }
                    });

                    filterBtns.forEach(btn => {
                        const isActive = btn.dataset.filter === tingkat;
                        if (isActive) {
                            btn.classList.remove('bg-gray-50', 'text-gray-500', 'border-gray-200', 'hover:bg-gray-100',
                                'bg-yellow-50', 'text-yellow-600', 'border-yellow-200', 'hover:bg-yellow-100',
                                'bg-violet-50', 'text-violet-600', 'border-violet-200', 'hover:bg-violet-100');
                            btn.classList.add('bg-[#de3b7c]', 'text-white', 'border-[#de3b7c]');
                        } else {
                            btn.classList.remove('bg-[#de3b7c]', 'text-white', 'border-[#de3b7c]');
                            const tier = btn.dataset.filter;
                            if (tier === 'all') {
                                btn.classList.add('bg-gray-50', 'text-gray-500', 'border-gray-200', 'hover:bg-gray-100');
                            } else if (tier === 'Silver') {
                                btn.classList.add('bg-gray-50', 'text-gray-500', 'border-gray-200', 'hover:bg-gray-100');
                            } else if (tier === 'Gold') {
                                btn.classList.add('bg-yellow-50', 'text-yellow-600', 'border-yellow-200', 'hover:bg-yellow-100');
                            } else if (tier === 'Platinum') {
                                btn.classList.add('bg-violet-50', 'text-violet-600', 'border-violet-200', 'hover:bg-violet-100');
                            }
                        }
                    });

                    rows.forEach(row => {
                        if (tingkat === 'all' || row.dataset.tingkat === tingkat) {
                            row.style.display = '';
                            visible++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    totalSpan.textContent = visible;
                }

                tierCards.forEach(card => {
                    if (card.tagName === 'DIV') {
                        card.addEventListener('click', function () {
                            filterTable(this.dataset.tingkat);
                        });
                    }
                });

                filterBtns.forEach(btn => {
                    btn.addEventListener('click', function () {
                        filterTable(this.dataset.filter);
                    });
                });

                document.getElementById('searchMember').addEventListener('input', function() {
                    const q = this.value.toLowerCase();
                    let visible = 0;
                    rows.forEach(function(row) {
                        const nm = row.querySelector('td:nth-child(2)')?.textContent?.toLowerCase() || '';
                        if (nm.includes(q)) {
                            row.style.display = '';
                            visible++;
                        } else {
                            row.style.display = 'none';
                        }
                    });
                    totalSpan.textContent = visible;
                });
            });
        </script>
</body>

</html>