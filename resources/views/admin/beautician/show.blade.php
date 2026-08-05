<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Beautician - BeautyCare</title>
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

        .page-header-premium {
            background: linear-gradient(135deg, #FFF5F8 0%, #FFE5EF 50%, #FFD6E6 100%);
            border-radius: 20px;
            padding: 28px 32px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 79, 135, 0.08);
        }

        .page-header-premium::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 79, 135, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .page-header-premium::after {
            content: '';
            position: absolute;
            bottom: -40px;
            left: 30%;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 79, 135, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .page-header-premium .ph-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-header-premium .ph-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .page-header-premium .ph-icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), #FF7BA6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 22px;
            box-shadow: 0 6px 20px rgba(255, 79, 135, 0.3);
            flex-shrink: 0;
        }

        .page-header-premium .ph-text h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .page-header-premium .ph-text p {
            font-size: 13px;
            color: var(--gray);
            margin: 2px 0 0;
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <main class="flex-1 flex flex-col overflow-hidden relative">
                <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                    <div class="page-header-premium no-print">
                        <div class="ph-content">
                            <div class="ph-left">
                                <div class="ph-icon-wrap">
                                    <i class="fa-solid fa-user-pen"></i>
                                </div>
                                <div class="ph-text">
                                    <h3>Detail Beautician</h3>
                                    <p>Informasi lengkap data karyawan beautician.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="no-print mb-5">
                        <a href="{{ route('admin.beautician.index') }}"
                            class="inline-flex items-center gap-2 text-[13px] font-semibold text-gray-500 hover:text-gray-700 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <div class="print-area bg-white rounded-3xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] border border-pink-50/50 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#de3b7c] to-[#ff7ba6] px-6 sm:px-10 py-8 flex flex-col sm:flex-row items-center gap-6">
                            <div class="w-24 h-24 rounded-full overflow-hidden bg-white/30 ring-4 ring-white/50 flex-shrink-0">
                                @if ($beautician->user?->foto)
                                    <img src="{{ asset('storage/' . $beautician->user->foto) }}" alt="foto"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white font-bold text-3xl">
                                        {{ strtoupper(substr($beautician->user?->nama ?? '??', 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="text-center sm:text-left">
                                <h1 class="text-white font-bold text-2xl">{{ $beautician->user?->nama ?? 'User tidak ditemukan' }}</h1>
                                <p class="text-pink-100 text-[13px] font-medium mt-1 uppercase tracking-wide">{{ $beautician->user?->role ?? '-' }}</p>
                                <div class="mt-3 flex flex-wrap justify-center sm:justify-start gap-2">
                                    <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-white/20 text-white backdrop-blur">NIP: {{ $beautician->NIP ?? '-' }}</span>
                                    @if ($beautician->status == 'Tersedia')
                                        <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">Tersedia</span>
                                    @elseif ($beautician->status == 'Sibuk')
                                        <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-orange-100 text-orange-700">Sibuk</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-[11px] font-semibold bg-gray-200 text-gray-600">Libur</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-6 sm:p-10">
                            <h2 class="font-bold text-gray-800 text-[15px] mb-5 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info text-[#de3b7c]"></i> Informasi Pribadi
                            </h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
                                <div class="flex flex-col gap-1 border-b border-gray-100 pb-4">
                                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Jabatan</span>
                                    <span class="text-[14px] font-semibold text-gray-800">{{ $beautician->jabatan ?? '-' }}</span>
                                </div>
                                <div class="flex flex-col gap-1 border-b border-gray-100 pb-4">
                                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Email</span>
                                    <span class="text-[14px] font-semibold text-gray-800 break-words">{{ $beautician->user?->email ?? '-' }}</span>
                                </div>
                                <div class="flex flex-col gap-1 border-b border-gray-100 pb-4">
                                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">No. HP</span>
                                    <span class="text-[14px] font-semibold text-gray-800">{{ $beautician->user?->no_hp ?? '-' }}</span>
                                </div>
                                <div class="flex flex-col gap-1 border-b border-gray-100 pb-4">
                                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Tanggal Lahir</span>
                                    <span class="text-[14px] font-semibold text-gray-800">{{ $beautician->tgl_lahir ? \Carbon\Carbon::parse($beautician->tgl_lahir)->format('d M Y') : '-' }}</span>
                                </div>
                                <div class="flex flex-col gap-1 border-b border-gray-100 pb-4">
                                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Tanggal Masuk</span>
                                    <span class="text-[14px] font-semibold text-gray-800">{{ $beautician->tgl_masuk ? \Carbon\Carbon::parse($beautician->tgl_masuk)->format('d M Y') : '-' }}</span>
                                </div>
                                <div class="flex flex-col gap-1 border-b border-gray-100 pb-4">
                                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Alamat</span>
                                    <span class="text-[14px] font-semibold text-gray-800">{{ $beautician->user?->alamat ?: '-' }}</span>
                                </div>
                            </div>

                            <h2 class="font-bold text-gray-800 text-[15px] mb-5 mt-8 flex items-center gap-2">
                                <i class="fa-solid fa-coins text-[#de3b7c]"></i> Informasi Gaji & Komisi
                            </h2>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="bg-[#fdf2f8] rounded-2xl p-5 text-center">
                                    <i class="fa-solid fa-money-bill-wave text-[#de3b7c] text-xl mb-2"></i>
                                    <p class="text-[#de3b7c] font-bold text-lg">Rp {{ number_format($beautician->gaji, 0, ',', '.') }}</p>
                                    <p class="text-[11px] text-gray-400 font-medium mt-1">Gaji Pokok</p>
                                </div>
                                <div class="bg-[#fdf2f8] rounded-2xl p-5 text-center">
                                    <i class="fa-solid fa-percent text-[#de3b7c] text-xl mb-2"></i>
                                    <p class="text-[#de3b7c] font-bold text-lg">{{ $beautician->komisi }}%</p>
                                    <p class="text-[11px] text-gray-400 font-medium mt-1">Komisi</p>
                                </div>
                                <div class="bg-[#fdf2f8] rounded-2xl p-5 text-center">
                                    <i class="fa-solid fa-id-card text-[#de3b7c] text-xl mb-2"></i>
                                    <p class="text-[#de3b7c] font-bold text-lg">{{ $beautician->NIP ?? '-' }}</p>
                                    <p class="text-[11px] text-gray-400 font-medium mt-1">NIP</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
