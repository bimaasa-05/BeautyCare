<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Pelanggan - BeautyCare</title>
    @include('partials.head-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') . '?v=3' }}">

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
        .pagination-custom nav svg { display: none; }
        .pagination-custom nav .flex a, .pagination-custom nav .flex span {
            font-size: 12px; padding: 6px 14px; border-radius: 100px !important; margin: 0 2px;
        }
        .pagination-custom nav .flex span:first-child, .pagination-custom nav .flex a:first-child { border-radius: 100px !important; }
    
        @media (max-width: 768px) {
            .filter-bar { justify-content: flex-start !important; align-items: stretch !important; }
            .filter-bar .relative { flex: 1 1 100%; }
            .filter-bar input, .filter-bar select { width: 100% !important; }
        }
</style>

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
    </style>
</head>

<body>
    <div class="dashboard-layout">
        @include('layouts.sidebar')

        <main class="main-content">
            @include('layouts.header2')

            <div class="flex-1 overflow-y-auto p-8">
                <div
                    class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex flex-col h-full min-h-[580px] justify-between relative overflow-hidden">
                    <div style="position:absolute;pointer-events:none;opacity:0.08;font-size:70px;top:-5px;right:-5px;">👥</div>
                    <div style="position:absolute;pointer-events:none;opacity:0.08;font-size:45px;bottom:-5px;left:-5px;">🌸</div>
                    <div>
                        <form action="" method="GET" class="flex flex-wrap items-center justify-end gap-2 mb-4 filter-bar">
                            <div class="relative">
                                <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[12px]"></i>
                                <input type="text" placeholder="Cari pelanggan..." name="keyword"
class="bg-gray-50 border border-gray-100 text-[12px] rounded-full pl-9 pr-4 py-2 w-[220px] focus:outline-none focus:border-pink-300 transition-all placeholder-gray-400"
                                    value="{{ Request()->keyword }}">
                            </div>
                            <input type="date" name="dari" value="{{ $dari ?? '' }}"
                                class="bg-gray-50 border border-gray-100 text-[12px] rounded-full px-3 py-2 w-[140px] focus:outline-none focus:border-pink-300 transition-all">
                            <span class="text-gray-400 text-[12px]">—</span>
                            <input type="date" name="sampai" value="{{ $sampai ?? '' }}"
                                class="bg-gray-50 border border-gray-100 text-[12px] rounded-full px-3 py-2 w-[140px] focus:outline-none focus:border-pink-300 transition-all">
                            <button type="submit"
                                class="bg-pink-50 text-pink-600 text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-pink-100 transition-colors border border-pink-200">
                                <i class="fa-solid fa-filter mr-1"></i> Filter
                            </button>
                            @if (request()->keyword || request()->dari || request()->sampai)
                                <a href="{{ route('kasir.pelanggan.index') }}"
                                    class="text-gray-400 hover:text-gray-600 text-[12px] px-1">
                                <i class="fa-solid fa-rotate-right"></i>
                            </a>
                            @endif
                            <a href="{{ route('kasir.pelanggan.create') }}"
                                class="flex items-center gap-2 bg-[#FF4F87] text-white text-[12px] font-semibold px-4 py-2 rounded-full hover:bg-[#ff3a78] transition-all shadow-sm hover:shadow-md hover:shadow-pink-200">
                                <i class="fa-solid fa-plus"></i> Tambah
                            </a>
                        </form>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
                            <div class="bg-gradient-to-br from-pink-50 to-white rounded-xl p-4 border border-pink-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Pelanggan</p>
                                        <p class="text-[26px] font-bold text-gray-800 mt-1">{{ $TotalPelanggan }}</p>
                                    </div>
                                    <div class="w-11 h-11 rounded-full bg-pink-100 flex items-center justify-center">
                                        <i class="fa-solid fa-users text-pink-500 text-lg"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-blue-50 to-white rounded-xl p-4 border border-blue-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Pelanggan Baru</p>
                                        <p class="text-[26px] font-bold text-blue-600 mt-1">{{ $PelangganBaru }}</p>
                                    </div>
                                    <div class="w-11 h-11 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fa-solid fa-user-plus text-blue-500 text-lg"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-amber-50 to-white rounded-xl p-4 border border-amber-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Pelanggan Member</p>
                                        <p class="text-[26px] font-bold text-amber-600 mt-1">{{ $PelangganMember }}</p>
                                    </div>
                                    <div class="w-11 h-11 rounded-full bg-amber-100 flex items-center justify-center">
                                        <i class="fa-solid fa-gem text-amber-500 text-lg"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-emerald-50 to-white rounded-xl p-4 border border-emerald-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Transaksi (Periode)</p>
                                        <p class="text-[26px] font-bold text-emerald-600 mt-1">{{ $TransaksiPelanggan }}</p>
                                    </div>
                                    <div class="w-11 h-11 rounded-full bg-emerald-100 flex items-center justify-center">
                                        <i class="fa-solid fa-receipt text-emerald-500 text-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6"><table class="w-full text-left border-collapse table-card-mobile">
                                <thead>
                                    <tr
                                        class="text-[11px] font-bold text-gray-400 uppercase border-b border-gray-100 bg-pink-50/30">
                                        <th class="py-3 px-4 w-10">#</th>
                                        <th class="py-3 px-4">Nama Lengkap</th>
                                        <th class="py-3 px-4">Nomor HP</th>
                                        <th class="py-3 px-4">Email</th>
                                        <th class="py-3 px-4">Alamat</th>
                                        <th class="py-3 px-4">Member ID</th>
                                        <th class="py-3 px-4">Catatan Alergi</th>
                                        <th class="py-3 px-4">Foto</th>
                                        <th class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-[13px] text-gray-700 divide-y divide-gray-50">
                                    @forelse($pelanggan as $p)
<tr class="hover:bg-gray-100 transition-colors duration-150">
                                             <td class="py-3.5 px-4 text-gray-400 font-medium text-center text-[12px]" data-label="#">{{ $loop->iteration }}</td>
                                            <td class="py-3.5 px-4" data-label="Nama Lengkap">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-400 to-pink-300 text-white flex items-center justify-center font-bold text-[11px] shadow-sm">
                                                        {{ strtoupper(substr($p->nm_pelanggan, 0, 2)) }}</div>
                                                    <span
                                                        class="font-semibold text-gray-800">{{ $p->nm_pelanggan }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3.5 px-4 text-gray-500 font-medium" data-label="Nomor HP">{{ $p->no_hp ?? '-' }}
                                            </td>
                                            <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Email">{{ $p->email }}</td>
                                            <td class="py-3.5 px-4 font-medium text-gray-500 max-w-[150px] truncate" data-label="Alamat">
                                                {{ $p->alamat }}</td>
                                            <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Member ID">
                                                @if($p->id_member)
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-pink-50 text-pink-500">
                                                        <i class="fa-regular fa-gem text-[9px]"></i> {{ $p->id_member }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 px-4 font-medium text-gray-500 max-w-[120px] truncate" data-label="Catatan Alergi">
                                                {{ $p->catatan_alergi ?? '-' }}</td>
                                            <td class="py-3.5 px-4 font-medium text-gray-500" data-label="Foto">
                                                <img src="{{ $p->foto_url }}" alt="foto"
                                                    class="w-8 h-8 rounded-full object-cover ring-2 ring-pink-100">
                                            </td>
                                            <td class="py-3.5 px-4 text-center" data-label="">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('kasir.pelanggan.show', $p->id_pelanggan) }}"
                                                        class="w-7 h-7 text-blue-500 bg-blue-50 hover:bg-blue-100 rounded-md transition-colors flex items-center justify-center"><i
                                                            class="fa-regular fa-eye text-xs"></i></a>
                                                    <a href="{{ route('kasir.pelanggan.edit', $p->id_pelanggan) }}"
                                                        class="w-7 h-7 text-amber-500 bg-amber-50 hover:bg-amber-100 rounded-md transition-colors flex items-center justify-center"><i
                                                            class="fa-solid fa-pen-to-square text-xs"></i></a>
                                                    <form
                                                        action="{{ route('kasir.pelanggan.destroy', $p->id_pelanggan) }}"
                                                        method="POST" class="inline"
                                                        data-confirm-title="Hapus Pelanggan" data-confirm-body="Apakah Anda yakin ingin menghapus pelanggan {{ $p->nm_pelanggan }}? Tindakan ini tidak dapat dibatalkan." data-confirm-icon="fa-trash-can" data-confirm-type="danger" data-confirm-yes="Ya, Hapus">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="w-7 h-7 text-red-500 bg-red-50 hover:bg-red-100 rounded-md transition-colors flex items-center justify-center"><i
                                                                class="fa-regular fa-trash-can text-xs"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="py-14 text-center">
                                                <div class="flex flex-col items-center gap-3">
                                                    <div class="w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center">
                                                        <i class="fa-solid fa-user text-3xl text-pink-200"></i>
                                                    </div>
                                                    <p class="text-gray-400 font-medium text-[14px]">Belum ada data pelanggan</p>
                                                    <p class="text-gray-300 text-[12px] -mt-2">Tambahkan pelanggan baru untuk memulai</p>
                                                    <a href="{{ route('kasir.pelanggan.create') }}"
                                                        class="text-[#FF4F87] text-[12px] font-semibold hover:underline inline-flex items-center gap-1 mt-1">
                                                        <i class="fa-solid fa-plus-circle"></i> Tambah pelanggan sekarang
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table></div>
                        </div>

                        @if ($pelanggan->hasPages())
                            <div class="mt-4 px-4 pagination-custom">
                                {{ $pelanggan->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @include('partials.confirm-modal')
</body>

</html>
