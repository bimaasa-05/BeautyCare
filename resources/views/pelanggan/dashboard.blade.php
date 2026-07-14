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
             <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeautyCare Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-[#FFF7FA] text-gray-800">

    <!-- Header Navigation -->
    <nav class="bg-white border-b border-pink-50 h-16 flex items-center justify-between px-6 shadow-sm">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-gradient-to-br from-[#EC4899] to-[#BE185D] rounded-lg flex items-center justify-center">
                <span class="text-white font-bold">✨</span>
            </div>
            <span class="font-bold text-lg text-gray-800">BeautyCare</span>
        </div>
        <div class="flex items-center gap-6">
            <a href="#" class="text-sm text-gray-500 hover:text-[#EC4899] font-medium">Beranda</a>
            <a href="#" class="text-sm text-gray-500 hover:text-[#EC4899] font-medium">Layanan</a>
            <a href="#" class="text-sm text-gray-500 hover:text-[#EC4899] font-medium">Booking</a>
            <a href="#" class="text-sm text-gray-500 hover:text-[#EC4899] font-medium">Riwayat</a>
            <a href="#" class="text-sm text-gray-500 hover:text-[#EC4899] font-medium">Membership</a>
        </div>
        <div class="flex items-center gap-3">
            <button class="w-9 h-9 rounded-xl bg-pink-50 flex items-center justify-center text-gray-500">🔔</button>
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-rose-300 to-pink-400 flex items-center justify-center text-white font-bold text-sm">SD</div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto p-6 space-y-6">
        
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-[#EC4899] to-[#BE185D] rounded-2xl p-8 text-white flex items-center justify-between">
            <div>
                <p class="text-pink-100 text-sm mb-1">Selamat datang kembali,</p>
                <h2 class="text-3xl font-extrabold mb-3">Sari Dewi ✨</h2>
                <div class="flex items-center gap-2 bg-white/20 rounded-xl px-4 py-2 w-fit">
                    <span>⭐</span>
                    <span class="text-sm font-semibold">Member Gold · 2.450 Poin</span>
                </div>
            </div>
            <div class="w-32 h-24 bg-white/10 rounded-xl flex items-center justify-center">User Image</div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-4 gap-4">
            <!-- Stat Card Template -->
            <div class="bg-white rounded-2xl p-5 border border-pink-50 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-400 to-rose-500 mb-3 flex items-center justify-center text-white">📅</div>
                <p class="text-sm text-gray-400 font-medium">Booking Aktif</p>
                <p class="text-2xl font-bold text-gray-800">2</p>
            </div>
            <!-- ... Repeat for other cards (Total Kunjungan, Poin, Favorit) ... -->
        </div>

        <!-- Bottom Section -->
        <div class="grid grid-cols-2 gap-6">
            <!-- Booking Mendatang -->
            <div class="bg-white rounded-2xl p-6 border border-pink-50 shadow-sm">
                <h3 class="font-bold text-gray-800 mb-4">Booking Mendatang</h3>
                <div class="p-4 bg-pink-50 rounded-xl mb-3 flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#EC4899] rounded-xl"></div>
                    <div class="flex-1">
                        <p class="text-sm font-bold">Hair Treatment</p>
                        <p class="text-xs text-gray-400">10 Jul 2026 · 09:00</p>
                    </div>
                </div>
            </div>

            <!-- Layanan Favorit -->
            <div class="bg-white rounded-2xl p-6 border border-pink-50 shadow-sm">
                <h3 class="font-bold text-gray-800 mb-4">Layanan Favorit</h3>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-10 bg-gray-200 rounded-lg"></div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold">Hair Treatment</p>
                        <p class="text-xs text-gray-400">Rp 250.000</p>
                    </div>
                    <button class="text-xs text-[#EC4899] font-bold">Booking</button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>