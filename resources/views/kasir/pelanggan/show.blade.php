<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Pelanggan - BeautyCare</title>
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
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] relative overflow-hidden">
                    <div style="position:absolute;pointer-events:none;opacity:0.08;font-size:80px;top:-10px;right:-5px;">👤</div>
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-[16px] font-bold text-gray-800">
                                <i class="fa-regular fa-address-card text-pink-500 mr-2"></i>Detail Pelanggan
                            </h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">
                                <i class="fa-regular fa-file-lines text-pink-300 mr-1"></i>Informasi lengkap pelanggan
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('kasir.pelanggan.edit', $pelanggan->id_pelanggan) }}"
                                class="flex items-center gap-2 bg-amber-50 text-amber-600 text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-amber-100 transition-colors">
                                <i class="fa-regular fa-pen-to-square"></i> Edit
                            </a>
                            <a href="{{ route('kasir.pelanggan.index') }}"
                                class="flex items-center gap-2 border border-gray-200 text-gray-600 text-[12px] font-medium px-4 py-2 rounded-full hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-1">
                            <div class="flex flex-col items-center bg-gradient-to-br from-pink-50/80 to-white rounded-2xl p-6 border border-pink-100/50">
                                @if($pelanggan->foto)
                                    <img src="{{ asset('storage/' . $pelanggan->foto) }}" alt="{{ $pelanggan->nm_pelanggan }}"
                                        class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-md">
                                @else
                                    <div class="w-28 h-28 rounded-full bg-pink-400 text-white flex items-center justify-center font-bold text-3xl border-4 border-white shadow-md">
                                        {{ strtoupper(substr($pelanggan->nm_pelanggan, 0, 2)) }}
                                    </div>
                                @endif
                                <h4 class="text-[16px] font-bold text-gray-800 mt-4">{{ $pelanggan->nm_pelanggan }}</h4>
                                <p class="text-[12px] text-gray-400">{{ $pelanggan->email }}</p>

                                @if($pelanggan->id_member)
                                    <span class="mt-3 px-3 py-1 bg-pink-100 text-pink-600 font-semibold text-[11px] rounded-full">
                                        <i class="fa-regular fa-gem mr-1"></i> Member
                                    </span>
                                @else
                                    <span class="mt-3 px-3 py-1 bg-gray-100 text-gray-500 font-semibold text-[11px] rounded-full">
                                        Non Member
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="lg:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Nama Lengkap</p>
                                    <p class="text-[14px] font-semibold text-gray-800 mt-1">{{ $pelanggan->nm_pelanggan }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Email</p>
                                    <p class="text-[14px] font-semibold text-gray-800 mt-1">{{ $pelanggan->email }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Nomor HP</p>
                                    <p class="text-[14px] font-semibold text-gray-800 mt-1">{{ $pelanggan->no_hp ?? '-' }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">ID Member</p>
                                    <p class="text-[14px] font-semibold text-gray-800 mt-1">
                                        @if($pelanggan->id_member)
                                            {{ $pelanggan->id_member }}
                                            @if($pelanggan->membership)
                                                <span class="text-[11px] text-pink-500 font-medium">({{ $pelanggan->membership->nm_member }} - {{ $pelanggan->membership->tingkat }})</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4 md:col-span-2">
                                    <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Alamat</p>
                                    <p class="text-[14px] font-semibold text-gray-800 mt-1">{{ $pelanggan->alamat ?? '-' }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4 md:col-span-2">
                                    <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Catatan Alergi</p>
                                    <p class="text-[14px] font-semibold text-gray-800 mt-1">{{ $pelanggan->catatan_alergi ?? '-' }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
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
