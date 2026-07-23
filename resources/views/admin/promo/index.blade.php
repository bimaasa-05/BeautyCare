<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BeautyCare</title>
    @include('partials.head-meta')
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
                <div class="space-y-4">

                    @if(session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-[13px] px-4 py-3 rounded-xl mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Subheader / Action Bar -->
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-400">{{ $promos->where('status', 'Tersedia')->count() }} promo tersedia</p>
                        <a href="{{ route('admin.promo.create') }}"
                            class="flex items-center gap-1.5 px-3 py-2 bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white rounded-xl text-xs font-bold shadow-sm hover:opacity-95">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5v14"></path>
                            </svg> Buat Promo
                        </a>
                    </div>

                    <!-- Cards Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($promos as $promo)
                        <div
                            class="bg-white rounded-2xl border overflow-hidden shadow-[0_2px_16px_rgba(236,72,153,0.06)] hover:shadow-lg transition-all {{ $promo->status == 'Tersedia' ? 'border-pink-50' : ($promo->status == 'Belum_tersedia' ? 'border-amber-100 opacity-80' : 'border-gray-100 opacity-60') }}">
                            <div
                                class="bg-gradient-to-r from-[#EC4899] to-[#BE185D] p-5 flex items-center justify-between">
                                <div>
                                    <span
                                        class="text-[10px] font-bold text-pink-100 bg-white/20 px-2 py-0.5 rounded-full">{{ $promo->jenis_promo }}</span>
                                    <h3 class="text-white font-bold text-base mt-2">{{ $promo->nm_promo }}</h3>
                                </div>
                                <div class="text-right">
                                    <p class="text-4xl font-extrabold text-white">{{ $promo->nilai }}%</p>
                                    <p class="text-pink-100 text-xs">diskon</p>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-2 gap-2 mb-3">
                                    <div>
                                        <p class="text-[10px] text-gray-400 mb-0.5">Mulai</p>
                                        <p class="text-xs font-bold text-gray-700">{{ \Carbon\Carbon::parse($promo->mulai)->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-gray-400 mb-0.5">Hingga</p>
                                        <p class="text-xs font-bold text-gray-700">{{ \Carbon\Carbon::parse($promo->selesai)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $promo->status == 'Tersedia' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : ($promo->status == 'Belum_tersedia' ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-gray-50 text-gray-500 border-gray-200') }}">{{ $promo->status == 'Tersedia' ? 'Tersedia' : ($promo->status == 'Belum_tersedia' ? 'Belum Tersedia' : 'Berakhir') }}</span>
                                    <div class="flex gap-1.5">
                                        <a href="{{ route('admin.promo.edit', $promo->id_promo) }}"
                                            class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center hover:bg-amber-100"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="11" height="11"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                </path>
                                                <path
                                                    d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z">
                                                </path>
                                            </svg></a>
                                        <form action="{{ route('admin.promo.destroy', $promo->id_promo) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus promo {{ $promo->nm_promo }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-7 h-7 rounded-lg bg-red-50 text-red-400 flex items-center justify-center hover:bg-red-100"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="11" height="11"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M3 6h18"></path>
                                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                    <line x1="10" x2="10" y1="11" y2="17"></line>
                                                    <line x1="14" x2="14" y1="11" y2="17"></line>
                                                </svg></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-16">
                            <div class="text-gray-300 text-5xl mb-4">
                                <i class="fa-solid fa-tags"></i>
                            </div>
                            <p class="text-gray-400 text-sm">Belum ada promo</p>
                            <a href="{{ route('admin.promo.create') }}"
                                class="inline-flex items-center gap-1.5 mt-3 px-4 py-2 bg-gradient-to-r from-[#EC4899] to-[#BE185D] text-white rounded-xl text-xs font-bold shadow-sm hover:opacity-95">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                    <path d="M12 5v14"></path>
                                </svg> Buat Promo Pertama
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </main>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>